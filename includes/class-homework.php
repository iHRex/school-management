<?php 
class Smgt_Homework
{
	public function check_valid_extension($filename)
	{
		$flag = 2;
		if($filename != '')
		{
			$flag = 0;
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$valid_extension = array('gif','png','jpg','jpeg');
			if(in_array($ext,$valid_extension) )
			{
				$flag = 1;
			}
		}
		return $flag;
	}
	function get_delete_records($tablenm,$record_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . $tablenm;
		return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE homework_id= %d",$record_id));
	}
	public function smgt_check_uploaded($assign_id)
	{
		global $wpdb;
		$table = $wpdb->prefix."mj_smgt_student_homework";
		$result = $wpdb->get_row("SELECT file FROM {$table} WHERE stu_homework_id = {$assign_id}",ARRAY_A);
			if($result['file'] != "")
			{
				return $result['file'];
			}
			else
			{ 
				return false;
			}
	}
	function smgt_get_class_homework()
	{
		global $wpdb;
		$table_name = $wpdb->prefix . 'mj_smgt_homework';
		return $result = $wpdb->get_results("SELECT * FROM $table_name");
	}
	function view_submission($data){
		global $wpdb;
		$table_name = $wpdb->prefix . 'mj_smgt_homework';
		$table_name2 = $wpdb->prefix . 'mj_smgt_student_homework';
		return $result = $wpdb->get_results("SELECT * FROM $table_name as a LEFT JOIN $table_name2 as b ON a.`homework_id` = b.`homework_id` where a.`homework_id`= $data ");
		
	}
	function parent_view_detail($child_ids){
		global $wpdb;
		$table_name = $wpdb->prefix . 'mj_smgt_homework';
		$table_name2 = $wpdb->prefix . 'mj_smgt_student_homework';
		return $result = $wpdb->get_results("SELECT * FROM $table_name as a LEFT JOIN $table_name2 as b ON a.`homework_id` = b.`homework_id`WHERE b.student_id IN ({$child_ids})");
	}
	function student_view_detail(){
		global $wpdb;
		global $user_ID;
		$table_name = $wpdb->prefix . 'mj_smgt_homework';
		$table_name2 = $wpdb->prefix . 'mj_smgt_student_homework';
		return $result = $wpdb->get_results("SELECT * FROM $table_name as a LEFT JOIN $table_name2 as b ON a.`homework_id` = b.`homework_id`WHERE b.student_id = $user_ID");
	}
	function parent_update_detail($data,$student_id){
		global $wpdb;
		global $user_ID;
		$table_name = $wpdb->prefix . 'mj_smgt_homework';
		$table_name2 = $wpdb->prefix . 'mj_smgt_student_homework';
		return $result = $wpdb->get_results("SELECT * FROM $table_name as a LEFT JOIN $table_name2 as b ON a.`homework_id` = b.`homework_id` WHERE a.`homework_id`=$data AND b.student_id = $student_id");
	}
	function add_homework($data,$document_data)
	{
			global $current_user;
			global $wpdb;
			$user=$current_user->user_login;
			$table_name=$wpdb->prefix ."mj_smgt_homework";
			$table_name2 = $wpdb->prefix . 'mj_smgt_student_homework';
			$homeworkdata['title']=MJ_smgt_address_description_validation($data['title']);
			$homeworkdata['class_name']=$data['class_name'];
			$homeworkdata['section_id']=$data['class_section'];
			$homeworkdata['subject']=$data['subject_id'];
			$homeworkdata['content']=$data['content'];
			$homeworkdata['created_date']=date('Y-m-d H:i:s');
			$homeworkdata['submition_date']= date('Y-m-d',strtotime($data['sdate']));
			$homeworkdata['createdby']=get_current_user_id();
			if(!empty($_REQUEST['homework_id']))
			{
				$homework_id['homework_id']=$_REQUEST['homework_id'];
				$homeworkdata['homework_document']=json_encode($document_data);
				$result = $wpdb->update($table_name,$homeworkdata,$homework_id);
				if($result)
				{
					if(!empty($data['class_section']))
					{
						$class_id =$data['class_name'];
						$studentdata = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student'));
						
					}
					else
					{
					   $studentdata = get_users(array('meta_key' => 'class_section', 'meta_value' =>$data['class_section'],
					  'meta_query'=> array(array('key' => 'class_name','value' => $data['class_name'],'compare' => '=')),'role'=>'student'));
					}
					   
					$last=$wpdb->insert_id;
					$homeworstud['homework_id']=$last;
					foreach($studentdata as $student)
					{
						 $homeworstud['student_id']=$student->ID;
						 $result = $wpdb->insert($table_name2,$homeworstud);
					}
					if(empty($studentdata))
					{
						if($data['smgt_enable_homework_mail']== '1')
						{
							foreach($studentdata as $userdata)
							{
								$student_id = $userdata->ID;
								$student_name = $userdata->display_name;
								$student_email = $userdata->user_email;
								
								//send mail notification for parent//
								$parent 		= 	get_user_meta($student_id, 'parent_id', true);
								
								if(!empty($parent))
								{
									foreach($parent as $p)
									{
										$user_info	 	=    get_userdata($p);
										$email_to[] 	=	 $user_info->user_email;		
									}
									foreach($email_to as $eamil)
									{
										$searchArr = array();
										$parent_homework_mail_content = get_option('parent_homework_mail_content');
										$parent_homework_mail_subject = get_option('parent_homework_mail_subject');
										$parerntdata = get_user_by('email',$eamil);							
										$searchArr['{{parent_name}}']	=	$parerntdata->display_name;
										$searchArr['{{student_name}}']	=	$student_name;
										$searchArr['{{title}}']   =  MJ_smgt_address_description_validation($data['title']);
										$searchArr['{{submition_date}}']   = smgt_getdate_in_input_box($data['sdate']);
										$searchArr['{{school_name}}']	=	get_option('smgt_school_name');
										$message = string_replacement($searchArr,$parent_homework_mail_content);
										smgt_send_mail($eamil,$parent_homework_mail_subject,$message);
															
									}
								}
								//send mail notification for student//
								$string = array();
								$string['{{student_name}}']   = $student_name;
								$string['{{title}}']   =  MJ_smgt_address_description_validation($data['title']);
								$string['{{submition_date}}']   = smgt_getdate_in_input_box($data['sdate']);
								$string['{{school_name}}'] =  get_option('smgt_school_name');
								$msgcontent                =  get_option('homework_mailcontent');		
								$msgsubject				   =  get_option('homework_title');
								$message = string_replacement($string,$msgcontent);
								smgt_send_mail($student_email,$msgsubject,$message);  
							}
						}
					}
				}
				return $result;
			}
			else
			{
				$homeworkdata['homework_document']=json_encode($document_data);
				$result=$wpdb->insert($table_name,$homeworkdata);
				if($result)
				{
					if(empty($data['class_section']))
					{
						$class_id =$data['class_name'];
						$studentdata = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student'));
						
					}
					else
					{
					   $studentdata = get_users(array('meta_key' => 'class_section', 'meta_value' =>$data['class_section'],
					  'meta_query'=> array(array('key' => 'class_name','value' => $data['class_name'],'compare' => '=')),'role'=>'student'));
					}
					if(!empty($studentdata))
					{
						$last=$wpdb->insert_id;
						$homeworstud['homework_id']=$last;
						$homeworstud['status']='0';
						$homeworstud['created_by']=get_current_user_id();
						$homeworstud['created_date']=date('Y-m-d H:i:s');
						foreach($studentdata as $student)
						{
							$homeworstud['student_id']=$student->ID;
							$insert = $wpdb->insert($table_name2,$homeworstud);
						}
						if($insert)
						{
							if($data['smgt_enable_homework_mail']== '1')
							{
								foreach($studentdata as $userdata)
								{
									$student_id = $userdata->ID;
									$student_name = $userdata->display_name;
									$student_email = $userdata->user_email;
									
									//send mail notification for parent//
									$parent 		= 	get_user_meta($student_id, 'parent_id', true);
									
									if(!empty($parent))
									{
										foreach($parent as $p)
										{
											$user_info	 	=    get_userdata($p);
											$email_to[] 	=	 $user_info->user_email;		
										}
										foreach($email_to as $eamil)
										{
											$searchArr = array();
											$parent_homework_mail_content = get_option('parent_homework_mail_content');
											$parent_homework_mail_subject = get_option('parent_homework_mail_subject');
											$parerntdata = get_user_by('email',$eamil);							
											$searchArr['{{parent_name}}']	=	$parerntdata->display_name;
											$searchArr['{{student_name}}']	=	$student_name;
											$searchArr['{{title}}']   =  MJ_smgt_address_description_validation($data['title']);
											$searchArr['{{submition_date}}']   =  smgt_getdate_in_input_box($data['sdate']);
											$searchArr['{{school_name}}']	=	get_option('smgt_school_name');
											$message = string_replacement($searchArr,$parent_homework_mail_content);
											smgt_send_mail($eamil,$parent_homework_mail_subject,$message);
																
										}
									}
									//send mail notification for student//
									$string = array();
									$string['{{student_name}}']   = $student_name;
									$string['{{title}}']   =  MJ_smgt_address_description_validation($data['title']);
									$string['{{submition_date}}']   =  smgt_getdate_in_input_box($data['sdate']);
									$string['{{school_name}}'] =  get_option('smgt_school_name');
									$msgcontent                =  get_option('homework_mailcontent');		
									$msgsubject				   =  get_option('homework_title');
									$message = string_replacement($string,$msgcontent);
									smgt_send_mail($student_email,$msgsubject,$message);  
								}
							}
						}
						
					}
				}
				return $result;
			}
    }	
	function get_all_homeworklist()
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "mj_smgt_homework";
		return $rows = $wpdb->get_results("SELECT * from $table_name");
	}
	function get_teacher_homeworklist()
	{
		global $wpdb;
		$class_name = array();
		$table_name = $wpdb->prefix . "mj_smgt_homework";
		$class_name=get_user_meta(get_current_user_id (),'class_name',true);
		return $rows = $wpdb->get_results("SELECT * from $table_name where class_name IN(".implode($class_name,',').")");
	}	
	function get_edit_record($homework_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "mj_smgt_homework";
		return $rows = $wpdb->get_row("SELECT * from $table_name where homework_id=".$homework_id);
	}
	function get_delete_record($homework_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "mj_smgt_homework";
		return $rows = $wpdb->query("Delete from $table_name where homework_id=".$homework_id);
	}	
	
}
?>