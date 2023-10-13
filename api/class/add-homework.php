<?php 
class AddHomework{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
			error_reporting(0);
			if($_REQUEST['smgt-json-api']=='add-homework')
			{

				if(isset($_REQUEST["homework_added_by"]))
				{
					$school_obj = new School_Management($_REQUEST["homework_added_by"]);
					if($school_obj->role=='teacher' || $school_obj->role=='admin'){
					$response=$this->homework_insert($_REQUEST);	
					}					
				}
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			
	}
	public function homework_insert($data)
	{	
		
		$created_date = date("Y-m-d H:i:s");
		
		if($data['class_id']!="" && $data['student_ids']!="" && $data['subject_id']!="" && $data['homework_title']!="" && $data['description']!=""){		
		$homeworkdata=array('class_id'=>$data['class_id'],	
		'section_id'=>$data['section_id'],
		'subject_id'=>$data['subject_id'],
		'homework_title'=>$data['homework_title'],
		'description'=>$data['description'],
		'to_date'=>date('Y-m-d',strtotime($data['homework_date'])),
		'created_by'=>$data['homework_added_by'],	
		'created_date'=>$created_date);	
		
		$response=array();
		global $wpdb;
		$table_name = $wpdb->prefix ."smgt_homework";
			$table1 = $wpdb->prefix."smgt_homework_assigned";
		$result=$wpdb->insert( $table_name, $homeworkdata);
		$homework_id = $wpdb->insert_id;
		$flag=0;
		if($data['student_ids']=='ALL'){
			$flag=1;
			if(isset($data['section_id']) && $data['section_id']!=""){
						$class_id =$data['class_id'];
						$class_section =$data['section_id'];
						 $student_list = get_users(array('meta_key' => 'class_section', 'meta_value' =>$class_section,'meta_query'=> array(array('key' => 'class_name','value' => $class_id,'compare' => '=')),'role'=>'student'));	
					}
					elseif(isset($data['class_id'])){
						
						$class_id =$data['class_id'];
						 $student_list = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student'));	
				   }	
		}
		else
		{
			$student_list=explode(',',$data['student_ids']);
		}
		
		foreach($student_list as $stu_id)
		{	
			if($flag==1)
			{
				$stu_id=$stu_id->ID;
			}
			
			$args1 = array(
						"homework_id" => $homework_id,
						"class_id" => $data['class_id'],
						"section_id" =>$data['section_id'],		
						"student_id" => $stu_id,
						"subject_id" =>$data['subject_id'],
						"status" => 1,					
						"created_by" =>$data['homework_added_by'],
						"created_date" => date('Y-m-d h:i:s')
						);			
				
			$chk = $wpdb->insert($table1,$args1);	
		}
		if($result!=0){
				$message['message']=__("Record successfully Inserted",'school-mgt');
				$response['status']=1;
				$response['resource']=$message;
			}
			return $response;	
		}
		else
		{
			$error['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['resource']=$error;
			return $response;
			
		}
		
	}
} ?>