<?php
add_filter( 'login_redirect', 'smgt_login_redirect',10, 3 );

function smgt_login_redirect($redirect_to, $request, $user )
{
	if (isset($user->roles) && is_array($user->roles)) 
	{
		$roles = ['student','teacher','parent','supportstaff'];
		foreach($roles as $role)
		{
			if (in_array($role, $user->roles))
			{ 
				$redirect_to =  home_url('?dashboard=user');
				break;
			}
		} 
	}
	return $redirect_to;
}

function student_notice_board($class_name,$class_section)
{
  return $notice_list_student = get_posts(array(
			'post_type' => 'notice',
			'posts_per_page' =>3,
			'meta_query' =>  array(
			'relation' => 'OR',
			array(
			'key' => 'notice_for',
			'value' => 'all',
			'compare' => '='
			),
			array(
			'relation' => 'AND',
			array(
			'key' => 'smgt_class_id',
			'value' => $class_name,
			'compare' => '=',
			),
			array(
			'key' => 'smgt_section_id',
			'value' => $class_section,
			'compare' => '=',	
			)	

			), 
			array(
			'relation' => 'AND',
			array(
			'key' => 'notice_for',
			'value' => 'student',
			'compare' => '=',
			),
			array(
			'key' => 'smgt_class_id',
			'value' => $class_name,
			'compare' => '=',	
			)	
			),
			array(
			'relation' => 'AND',
			array(
			'key' => 'notice_for',
			'value' => 'student',
			'compare' => '=',
			)/* ,
			array(
			'key' => 'smgt_class_id',
			'value' => 'all',
			'compare' => '=',
			), */
			)
			)
			));
}
function student_notice_dashbord($class_name,$class_section)
{
  return $notice_list_student = get_posts(array(
			'post_type' => 'notice',
			'meta_query' =>  array(
			'relation' => 'OR',
			array(	
			'key' => 'notice_for',
			'value' => 'all',
			'compare' => '='
			),
			array(
			'relation' => 'AND',
			array(
			'key' => 'smgt_class_id',
			'value' => $class_name,
			'compare' => '=',
			),
			array(
			'key' => 'smgt_section_id',
			'value' => $class_section,
			'compare' => '=',	
			)	
			), 
			array(
			'relation' => 'AND',
			array(
			'key' => 'notice_for',
			'value' => 'student',
			'compare' => '=',
			),
			array(
			'key' => 'smgt_class_id',
			'value' => $class_name,
			'compare' => '=',	
			)	
			),
			array(
			'relation' => 'AND',
			array(
			'key' => 'notice_for',
			'value' => 'student',
			'compare' => '=',
			),
			array(
			'key' => 'smgt_class_id',
			'value' => 'all',
			'compare' => '=',
			),  
			)
			)
			));
}
function teacher_notice_board($class_name)
{
	$smgt_class_id=array('all',$class_name[0]);
	return $notice_list_teacher = get_posts(array(
			'post_type' => 'notice',
			'posts_per_page' =>3,
			'meta_query' =>  array(
				'relation' => 'OR',
				array(
				'key' => 'notice_for',
				'value' => 'all',
				'compare' => '='
				), 
				array(
					'relation' => 'AND',
					array(
					'key' => 'notice_for',
					'value' => 'teacher',
					'compare' => '=',
					),
					array(
					'key' => 'smgt_class_id',
					'value' => $smgt_class_id,
					'compare' => 'IN',	
					)	
				)
			)
			));
}
function teacher_notice_dashbord()
{
	$class_name=get_user_meta(get_current_user_id(),'class_name',true);	
  $smgt_class_id=array('all',$class_name[0]);
  return $notice_list_teacher = get_posts(array(
			'post_type' => 'notice',
			'meta_query' =>  array(
				'relation' => 'OR',
				array(
				'key' => 'notice_for',
				'value' => 'all',
				'compare' => '='
				), 
				array(
					'relation' => 'AND',
					array(
					'key' => 'notice_for',
					'value' => 'teacher',
					'compare' => '=',
					),
					array(
					'key' => 'smgt_class_id',
					'value' => $smgt_class_id,
					'compare' => 'IN',	
					)	
				)
			)
			));
}
function parent_notice_board()
{
  return $notice_list_parent = get_posts(array(
			'post_type' => 'notice',
			'posts_per_page' =>3,
			'meta_query' =>  array(
			'relation' => 'AND',
			array(
			'relation' => 'OR',
			array(
			'key' => 'notice_for',
			'value' => 'all',
			'compare' => '='
			),
			
			array(
			'key' => 'notice_for',
			'value' => 'parent',
			'compare' => '=',
			)
			),
			
			)));
}
function parent_notice_dashbord()
{
  return $notice_list_parent = get_posts(array(
			'post_type' => 'notice',
			'meta_query' =>  array(
			'relation' => 'AND',
			array(
			'relation' => 'OR',
			array(
			'key' => 'notice_for',
			'value' => 'all',
			'compare' => '='
			),
			array(
			'key' => 'notice_for',
			'value' => 'parent',
			'compare' => '=',
			)
			),
			
			)));
}
function supportstaff_notice_board()
{
  return $notice_list_supportstaff = get_posts(array(
			'post_type' => 'notice',
			'posts_per_page' =>3,
			'meta_query' =>  array(
			'relation' => 'AND',
			array(
			'relation' => 'OR',
			array(
			'key' => 'notice_for',
			'value' => 'all',
			'compare' => '='
			),
			
			array(
			'key' => 'notice_for',
			'value' => 'supportstaff',
			'compare' => '=',
			)
			),
			
			)));
}
function supportstaff_notice_dashbord()
{
  return $notice_list_supportstaff = get_posts(array(
			'post_type' => 'notice',
			'meta_query' =>  array(
			'relation' => 'AND',
			array(
			'relation' => 'OR',
			array(
			'key' => 'notice_for',
			'value' => 'all',
			'compare' => '='
			),
			array(
			'key' => 'notice_for',
			'value' => 'supportstaff',
			'compare' => '=',
			)
			),
			
			)));
}
function page_access_rolewise_and_accessright()
{
$menu = get_option( 'smgt_access_right');
global $current_user;
$user_roles 	= 	$current_user->roles;
$user_role 		= 	array_shift($user_roles);
	foreach ( $menu as $key=>$value ) 
	{
		 if($value['page_link']==$_REQUEST['page'])
		 {
			if($value[$user_role]==0)
			{
				//wp_redirect ( admin_url () . 'index.php' );
				$flage=0;
			}
			else
			{
			   $flage=1;
			}
		}
	}
	return $flage;
}
function cmgt_check_ourserver()
{
   return false; 
}
function cmgt_check_productkey($domain_name,$licence_key,$email)
{	
	$result = '0';
		
}
/* Setup form submit*/
function cmgt_submit_setupform($data)
{
	$domain_name= $data['domain_name'];
	$licence_key = $data['licence_key'];
	$email = $data['enter_email'];
	
	
	$result = cmgt_check_productkey($domain_name,$licence_key,$email);
	if($result == '1')
	{
		$message = __('Please provide correct Envato purchase key.','school-mgt');
			$_SESSION['cmgt_verify'] = '1';
	}
	elseif($result == '2')
	{
		$message = __('This purchase key is already registered with the different domain. If have any issue please contact us at sales@dasinfomedia.com','school-mgt');
			$_SESSION['cmgt_verify'] = '2';
	}
	elseif($result == '3')
	{
		$message = __('There seems to be some problem please try after sometime or contact us on sales@dasinfomedia.com','school-mgt');
			$_SESSION['cmgt_verify'] = '3';
	}
	elseif($result == '4')
	{
		$message = __('Please provide correct Envato purchase key for this plugin.','school-mgt');
			$_SESSION['cmgt_verify'] = '1';
	}
	else
	{
		update_option('domain_name',$domain_name,true);
		update_option('licence_key',$licence_key,true);
		update_option('cmgt_setup_email',$email,true);
		$message = 'Success fully register';
			$_SESSION['cmgt_verify'] = '0';
	}	
	$result_array = array('message'=>$message,'cmgt_verify'=>$_SESSION['cmgt_verify']);
	return $result_array;
}
/* check server live */
function cmgt_chekserver($server_name)
{return true;
	if($server_name == 'localhost')
	{
		return true;
	}		
}
/*Check is_verify*/
function cmgt_check_verify_or_not($result)
{return true;
	$server_name = $_SERVER['SERVER_NAME'];
	$current_page = isset($_REQUEST['page'])?$_REQUEST['page']:'';
	$pos = strrpos($current_page, "smgt_");	
	if($pos !== false)			
	{ 	 
		if($server_name == 'localhost')
		{
			return true;
		}
		else
		{ 
			if($result == '0')
			{
				return true;
			}
		}	
		return false;
	}
	
}
function cmgt_is_cmgtpage()
{
	$current_page = isset($_REQUEST['page'])?$_REQUEST['page']:'';
	$pos = strrpos($current_page, "smgt_");	
	
	if($pos !== false)			
	{
		return true;
	}
	return false;
}


//Function File
//-----------INSERT NEW RECORD IN CUSOTOM TABLE------------
$obj_attend=new Attendence_Manage();
function smgt_datatable_multi_language()
{
	$datatable_attr=array("sEmptyTable"=>__("No data available in table","school-mgt"),
		"sInfo"=>__("Showing _START_ to _END_ of _TOTAL_ entries","school-mgt"),
		"sInfoEmpty"=>__("Showing 0 to 0 of 0 entries","school-mgt"),
		"sInfoFiltered"=>__("(filtered from _MAX_ total entries)","school-mgt"),
		"sInfoPostFix"=> "",
		"sInfoThousands"=>",",
		"sLengthMenu"=>__("Show _MENU_ entries","school-mgt"),
		"sLoadingRecords"=>__("Loading...","school-mgt"),
		"sProcessing"=>__("Processing...","school-mgt"),
		"sSearch"=>__("Search:","school-mgt"),
		"sZeroRecords"=>__("No matching records found","school-mgt"),
		"Print"=> __("Print","school-mgt"),
		"oPaginate"=>array(
			"sFirst"=>__("First","school-mgt"),
			"sLast"=>__("Last","school-mgt"),
			"sNext"=>__("Next","school-mgt"),
			"sPrevious"=>__("Previous","school-mgt")
		),
		"oAria"=>array(
			"sSortAscending"=>__(": activate to sort column ascending","school-mgt"),
			"sSortDescending"=>__(": activate to sort column descending","school-mgt")
		)
	);
	
	return $data=json_encode( $datatable_attr);
}
function change_menutitle($key)
{
	$school_obj = new School_Management ( get_current_user_id () );
	$role = $school_obj->role;
	
	if($role=='parent' && $key=='student')
	{
		$key='child';
	}
	
	$menu_titlearray=array('virtual_classroom'=>__('Virtual Classroom','school-mgt'),'teacher'=>__('Teacher','school-mgt'),'student'=>__('Student','school-mgt'),'child'=>__('Child','school-mgt'),'parent'=>__('Parent','school-mgt'),'subject'=>__('Subject','school-mgt'),'class'=>__('Class','school-mgt'),'schedule'=>__('Class Routine','school-mgt'),'attendance'=>__('Attendance','school-mgt'),'exam'=>__('Exam','school-mgt'),'manage_marks'=>__('Manage Marks','school-mgt'),'feepayment'=>__('Fee Payment','school-mgt'),'payment'=>__('Payment','school-mgt'),'transport'=>__('Transport','school-mgt'),'hostel'=>__('Hostel','school-mgt'),'notice'=>__('Notice Board','school-mgt'),'message'=>__('Message','school-mgt'),'holiday'=>__('Holiday','school-mgt'),'library'=>__('Library','school-mgt'),'account'=>__('Account','school-mgt'),'report'=>__('Report','school-mgt'),'homework'=>__('Homework','school-mgt'));
		
	return $menu_titlearray[$key];
}
function smgt_approve_student_list()
{
	 $studentdata = get_users(array('meta_key' => 'hash','role'=>'student'));	
	 $inactive_student_id = wp_list_pluck( $studentdata, 'ID' );
	 return  $inactive_student_id;	 
}

function get_remote_file($url, $timeout = 30)
{
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$file_contents = curl_exec($ch);
	curl_close($ch);
	return ($file_contents) ? $file_contents : FALSE;
}
/*function subject_exists($tid,$class_id)
{
		
		global $wpdb;
		$table_name = $wpdb->prefix . "subject";
        
        $subjects = $wpdb->get_var('SELECT subid FROM $table_name WHERE teacher_id = $tid and class_id=$class_id' );
		if ( !empty($subjects) )
			return true;
		else
			return false;
		
}*/
function smgt_change_read_status($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_message";
	$data['status']=1;
	$whereid['message_id']=$id;
	$retrieve_message_status = $wpdb->update($table_name,$data,$whereid);
		
	return $retrieve_message_status;
}
function smgt_change_read_status_reply($id)
{
	global $wpdb;
	$smgt_message_replies = $wpdb->prefix . 'smgt_message_replies';
		
	$data['status']=1;
	$whereid['message_id']=$id;
	$whereid['receiver_id']=get_current_user_id();
	$retrieve_message_reply_status = $wpdb->update($smgt_message_replies,$data,$whereid);
	
	return $retrieve_message_reply_status;
}
function get_subject_class($subject_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	$result = $wpdb->get_row("SELECT class_id FROM $table_name where subid=$subject_id");
	return $result->class_id;
}
function get_teachers_subjects($tid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	$result = $wpdb->get_results("SELECT * FROM $table_name where teacher_id=$tid");
	return $result;
}
function get_all_student_list()
{
	$exlude_id = smgt_approve_student_list();
	$student = get_users(array('role'=>'student','exclude'=>$exlude_id));
	return $student;
}


function get_teacher_class_student($id)
{	
	$meta_val = get_user_meta($id,'class_name',true);	
	
	$meta_query_result =  get_users(	
		array(
			'meta_key' => 'class_name',
			'meta_value' =>$meta_val,	   
		)
	);
	return $meta_query_result;
}

function check_class_exits_in_teacher_class($id)
{	
	$TeacherData = get_users(array('role'=>'teacher'));
	$Teacher = array();
	if(!empty($TeacherData))
	{
		foreach($TeacherData as $teacher)
		{
			$TeacherClass = get_user_meta($teacher->ID,'class_name',true);
			if(in_array($id,$TeacherClass))
			{
				$Teacher[] = $teacher->ID;			
			}
		}
	}
	return $Teacher;
} 

function get_all_student_list_class()
{
	$exlude_id = smgt_approve_student_list();
	$student = get_users(array('role'=>'student','exclude'=>$exlude_id));
	return $student;
}

function smgt_get_all_user_in_message()
{
	$school_obj = new School_Management ( get_current_user_id () );
	$teacher = get_users(array('role'=>'teacher'));
	$parent = get_users(array('role'=>'parent'));
	$exlude_id = smgt_approve_student_list();
	$student = get_users(array('role'=>'student','exclude'=>$exlude_id));
	
	$supportstaff = get_users(array('role'=>'supportstaff'));
	
	$parents_child_list=get_user_meta(get_current_user_id(), 'child', true);
	//var_dump($user_meta);
	

	$all_user = array(
		'student'=>$student,
		'teacher'=>$teacher,
		'parent'=>$parent,
		'supportstaff'=>$supportstaff		
	);
	
	if($school_obj->role == 'administrator' || $school_obj->role == 'teacher')
	{
		$all_user = array(
			'student'=>$student,
			'teacher'=>$teacher,
			'parent'=>$parent,
			'supportstaff'=>$supportstaff
		);
	}
	if($school_obj->role == 'parent')
		if(get_option('parent_send_message'))
		{
			if(!empty($parents_child_list))
			{
				$class_array = array();
				foreach ($parents_child_list as $user)
				{
					$class_id=get_user_meta($user, 'class_name',true);
					$class_array[]= $class_id;
				}
				//print_r($class_array);
				//echo "<BR> Unique";
				$unique = array_unique($class_array);
				//print_r($unique);
				$student = array();
				if(!empty($unique))
					foreach($unique as $class_id)
						$student[]=get_users(array('role'=>'student','meta_key' => 'class_name', 'meta_value' => $class_id));
			
			
			}
			
			$all_user = array(
				'student'=>$student,
				'teacher'=>$teacher,
				'parent'=>$parent,
				'supportstaff'=>$supportstaff
			);			
		}
		else 
		{
			$all_user = array(
				'teacher'=>$teacher,
				'parent'=>$parent,
				'supportstaff'=>$supportstaff
			);
		}
		
	if(get_option('student_send_message'))
	if($school_obj->role == 'student')
	{
		$school_obj->class_info = $school_obj->get_user_class_id(get_current_user_id());
		$student = $school_obj->get_student_list($school_obj->class_info->class_id);
		$all_user = array('student'=>$student);
	}
	$return_array = array();
	//echo count($all_user['doctor']);
	//exit;
	foreach($all_user as $key => $value)
	{
		if(!empty($value))
		{
		 echo '<optgroup label="'.$key.'" style = "text-transform: capitalize;">';
		 foreach($value as $user)
		 {
		 	if(get_option('parent_send_message'))
			 	if($key == 'student' && $school_obj->role == 'parent')
			 	{
			 		foreach($user as $student_class)
			 		{
			 			//echo $student_class->ID;
			 			echo '<option value="'.$student_class->ID.'">'.$student_class->display_name.'</option>';
			 		}
			 	}
			 	else 
			 	echo '<option value="'.$user->ID.'">'.$user->display_name.'</option>';
			 else 
			 	echo '<option value="'.$user->ID.'">'.$user->display_name.'</option>';
		 }
		}
	}
}
function smgt_send_replay_message($data)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_message_replies";
	
	$upload_docs_array=array();	
	if(!empty($_FILES['message_attachment']['name']))
	{
		$count_array=count($_FILES['message_attachment']['name']);

		for($a=0;$a<$count_array;$a++)
		{			
			foreach($_FILES['message_attachment'] as $image_key=>$image_val)
			{		
				$document_array[$a]=array(
				'name'=>$_FILES['message_attachment']['name'][$a],
				'type'=>$_FILES['message_attachment']['type'][$a],
				'tmp_name'=>$_FILES['message_attachment']['tmp_name'][$a],
				'error'=>$_FILES['message_attachment']['error'][$a],
				'size'=>$_FILES['message_attachment']['size'][$a]
				);							
			}
		}				
		foreach($document_array as $key=>$value)		
		{	
			$get_file_name=$document_array[$key]['name'];	
			
			$upload_docs_array[]=smgt_load_multiple_documets($value,$value,$get_file_name);				
		} 				
	}
	$upload_docs_array_filter=array_filter($upload_docs_array);	
	if(!empty($upload_docs_array_filter))
	{
		$attachment=implode(',',$upload_docs_array_filter);
	}
	else
	{
		$attachment='';
	}
	$result='';
	
	if(!empty($data['receiver_id']))
	{
		foreach($data['receiver_id'] as $receiver_id)
		{
			$messagedata['message_id'] = $data['message_id'];
			$messagedata['sender_id'] = $data['user_id'];
			$messagedata['receiver_id'] = $receiver_id;
			$messagedata['message_comment'] = $data['replay_message_body'];
			$messagedata['message_attachment'] =$attachment;
			$messagedata['status'] =0;
			$messagedata['created_date'] = date("Y-m-d h:i:s");
			$result=$wpdb->insert( $table_name, $messagedata );
			if($result)	
			{
				$SchoolName 	=  	get_option('smgt_school_name');
				$SubArr['{{school_name}}'] 	= $SchoolName;
				$SubArr['{{from_mail}}'] = get_display_name($data['user_id']);
				$MailSub = string_replacement($SubArr,get_option('message_received_mailsubject'));
				
				$user_info = get_userdata($receiver_id);
				$to = $user_info->user_email;    
				
				$MailBody  = get_option('message_received_mailcontent');	
				$MesArr['{{receiver_name}}']	= 	get_display_name($receiver_id);	
				$MesArr['{{message_content}}']	=	$data['replay_message_body'];
				$MesArr['{{school_name}}']		=	$SchoolName;
				$messg = string_replacement($MesArr,$MailBody);
				if(get_option('smgt_mail_notification') == '1')
				{
					wp_mail($to, $MailSub, $messg); 
				}					
			}
		}
	}
			if($result)	
				return $result;
}
function smgt_get_all_replies($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_message_replies";
	return $result =$wpdb->get_results("SELECT * FROM $table_name where message_id = $id GROUP BY message_id,sender_id,message_comment ORDER BY id ASC");
	//return $result =$wpdb->get_results("SELECT *  FROM $table_name where message_id = $id");
}
function smgt_get_all_replies_frontend($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_message_replies";
	return $result =$wpdb->get_results("SELECT *  FROM $table_name where message_id = $id");
}

function smgt_delete_reply($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_message_replies";
	$reply_id['id']=$id;
	return $result=$wpdb->delete( $table_name, $reply_id);
}
function smgt_count_reply_item($id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$smgt_message_replies = $wpdb->prefix .'smgt_message_replies';	
	
	/* $result=$wpdb->get_var("SELECT count(*)  FROM $smgt_message_replies where message_id = $id");
	
	return $result;  */
	$user_id=get_current_user_id();
	$inbox_sent_box =$wpdb->get_results("SELECT *  FROM $tbl_name where ((receiver = $user_id) AND (sender != $user_id)) AND (post_id = $id) AND (status=0)");
	
	$reply_msg =$wpdb->get_results("SELECT *  FROM $smgt_message_replies where (receiver_id = $user_id) AND (message_id = $id) AND ((status=0) OR (status IS NULL))");
	
	$count_total_message=count($inbox_sent_box) + count($reply_msg); 
	
	return $count_total_message; 
}
function smgt_get_countery_phonecode($country_name)
{
	$url = plugins_url( 'countrylist.xml', __FILE__ );
	//$xml=simplexml_load_file(plugins_url( 'countrylist.xml', __FILE__ )) or die("Error: Cannot create object");
	$xml =simplexml_load_string(get_remote_file($url));
	foreach($xml as $country)
	{
		if($country_name == $country->name)
			return $country->phoneCode;
		
	}							
}

function smgt_get_roles($user_id){
	$roles = array();
	$user = new WP_User( $user_id );

	if ( !empty( $user->roles ) && is_array( $user->roles ) )
	{
		foreach ( $user->roles as $role )
			 return $role;
	}

	
}

function smgt_get_student_parent_id($student_id)
{
	$parent = get_user_meta($student_id, 'parent_id');
	$parent_idarray = array();
	if(!empty($parent))
	{
	foreach ($parent[0] as $parent_id)
		$parent_idarray[]=$parent_id;
	}
	return  $parent_idarray;
}
function get_bookname($id)
{
	global $wpdb;
		$table_book=$wpdb->prefix.'smgt_library_book';
		$result = $wpdb->get_row("SELECT * FROM $table_book where id=".$id);
		return $result->book_name;
}
function smgt_get_parents_child_id($parent_id)
{
	$parent = get_user_meta($parent_id, 'child');
	$parent_idarray = array();
	if(!empty($parent))
	{
		foreach ($parent[0] as $parent_id)
			$parent_idarray[]=$parent_id;
	}
	return  $parent_idarray;
}
function smgt_get_user_notice($role,$class_id,$section_id=0)
{
	if($role == 'all' )
	{
		$userdata = array();
		$roles = array('teacher', 'student', 'parent','supportstaff');
		
		foreach ($roles as $role) :
		$users_query = new WP_User_Query( array(
				'fields' => 'all_with_meta',
				'role' => $role,
				'orderby' => 'display_name'
		));
		$results = $users_query->get_results();
		if ($results) $userdata = array_merge($userdata, $results);
		endforeach;
	}
	elseif($role == 'parent' )
	{
		$new =array();
		if($class_id == 'all')
		{
			$userdata=get_users(array('role'=>$role));
			
		}
		else
		{
			$userdata=get_users(array('role'=>'student','meta_key' => 'class_name', 'meta_value' => $class_id));
			foreach($userdata as $users)
			{
				$parent = get_user_meta($users->ID, 'parent_id', true);
				//var_dump($parent);
				if(!empty($parent))
				foreach($parent as $p)
				{
					$new[]=array('ID'=>$p);
				}
			}
			$userdata =  $new;
		}
		
	}
	elseif($role == 'administrator' )
	{
		$userdata=get_users(array('role'=>$role));
	}
	else 
	{
		if($class_id == 'all'){
			$userdata=get_users(array('role'=>$role));
		}
		elseif($section_id!=0){
		$userdata = get_users(array('meta_key' => 'class_section', 'meta_value' =>$section_id,
				'meta_query'=> array(array('key' => 'class_name','value' => $class_id,'compare' => '=')),'role'=>'student'));	
		}
		else{
			$userdata=get_users(array('role'=>$role,'meta_key' => 'class_name', 'meta_value' => $class_id));
		}
	}
		
	return $userdata;
}
function get_feepayment_all_record()
{
	global $wpdb;
	$smgt_fees_payment = $wpdb->prefix .'smgt_fees_payment';
	$result = $wpdb->get_results("SELECT * FROM $smgt_fees_payment where start_year != '' AND end_year != '' group by start_year,end_year");
	return $result;
}
function get_payment_report($class_id,$fee_term,$payment_status,$sdate,$edate,$section_id)
{
	
	
	$where = '';
	$array_test = array();
	if($class_id != ' ')
		$array_test[] = 'class_id = '.$class_id; 
	if($section_id !=0)
		$array_test[] = 'section_id = '.$section_id; 
	if($fee_term != ' ')
		$array_test[] = 'fees_id = '.$fee_term; 
	if($payment_status != ' ')
		$array_test[] = 'payment_status = '.$payment_status; 
	/*if($year != '')
	{
		$array_test[] = 'start_year = '.$year_year[0]; 
		$array_test[] = 'end_year = '.$year_year[1]; 
	}*/
	//$sdate=date("Y-m-d h:i:s", strtotime($sdate));
	//$edate=date("Y-m-d h:i:s", strtotime($edate));
	global $wpdb;
	$smgt_fees_payment = $wpdb->prefix .'smgt_fees_payment';
	$sql = "SELECT * FROM $smgt_fees_payment  ";
	$test_string = implode(" AND ",$array_test);
	$date_string=" AND (paid_by_date BETWEEN '$sdate' AND '$edate')";
	$test_string .=$date_string;
	if(!empty($array_test))
	{
		$sql .= " Where "; 
	}
	 $sql .= $test_string;
	//echo $sql;
	
	$result = $wpdb->get_results($sql);
	return $result;
	
}
function insert_record($tablenm,$records)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	 
	return $result=$wpdb->insert( $table_name, $records);
	
}
function add_class_section($tablenm,$sectiondata)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->insert( $table_name, $sectiondata);
	
}
function smgt_get_class_sections($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'smgt_class_section';
	return $result = $wpdb->get_results("SELECT * FROM $table_name where class_id=$id");
	
}
function smgt_get_section_name($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'smgt_class_section';
	$result = $wpdb->get_row("SELECT *FROM $table_name where id=$id");
	return $result->section_name;
}
function delete_class_section($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix. 'smgt_class_section';
	$result = $wpdb->query("DELETE FROM $table_name where id= ".$id);
	return $result;
}
//-----------UPDATE RECORD IN CUSOTOM TABLE------------
function update_record($tablenm,$data,$record_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	$result=$wpdb->update($table_name, $data,$record_id);
	return $result;
	
}
//-----------DELETE RECORD IN CUSOTOM TABLE------------
function delete_subject($tablenm,$record_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	$teacher_table_name = $wpdb->prefix . 'teacher_subject';
	$wpdb->query($wpdb->prepare("DELETE FROM $teacher_table_name WHERE subject_id= %d",$record_id));
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE subid= %d",$record_id));
	
}
function delete_class($tablenm,$record_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE class_id= %d",$record_id));
}
function delete_grade($tablenm,$record_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE grade_id= %d",$record_id));
}
function delete_exam($tablenm,$record_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	$smgt_exam_hall_receipt = $wpdb->prefix .'smgt_exam_hall_receipt';
	$smgt_exam_time_table = $wpdb->prefix .'smgt_exam_time_table';
	
	$result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE exam_id= %d",$record_id));
	if($result)
	{
		$result_receipt_delete=$wpdb->query($wpdb->prepare("DELETE FROM $smgt_exam_hall_receipt WHERE exam_id= %d",$record_id));
		$result_timetable_delete=$wpdb->query($wpdb->prepare("DELETE FROM $smgt_exam_time_table WHERE exam_id= %d",$record_id));
	}
	return $result;
}
function delete_usedata($record_id)
{
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'usermeta';
	$result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE user_id= %d",$record_id));
	$retuenval=wp_delete_user( $record_id );
	return $retuenval;
}
function delete_message($tablenm,$record_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE message_id= %d",$record_id));

}
function get_class_name($cid)
{
	
	global $wpdb;
	$table_name = $wpdb->prefix .'smgt_class';
	
	$classname =$wpdb->get_row("SELECT class_name FROM $table_name WHERE class_id=".$cid);
	if(!empty($classname))
		return $classname->class_name;
	else
		return " ";
}

function get_fees_term_name($fees_id)
{
	
	global $wpdb;
	$table_smgt_fees = $wpdb->prefix .'smgt_fees';
	
	$classname =$wpdb->get_row("SELECT fees_title_id FROM $table_smgt_fees WHERE fees_id=".$fees_id);
	if(!empty($classname))
		return get_the_title($classname->fees_title_id);
	else
		return " ";
}
function get_payment_status($fees_pay_id)
{
	global $wpdb;
	$table_smgt_fees_payment = $wpdb->prefix .'smgt_fees_payment';
	
	$result =$wpdb->get_row("SELECT * FROM $table_smgt_fees_payment WHERE fees_pay_id=".$fees_pay_id);
	if(!empty($result))
	{	
		if($result->fees_paid_amount == 0)
		{
			return _e('Not Paid','school-mgt');
		}
		elseif($result->fees_paid_amount < $result->total_amount)
		{
			return _e('Partially Paid','school-mgt');
		}
		else
			return _e('Fully Paid','school-mgt');
	}
	else
		return " ";
}
function get_single_fees_payment_record($fees_pay_id)
{
	global $wpdb;
	$table_smgt_fees_payment = $wpdb->prefix .'smgt_fees_payment';
	
	$result =$wpdb->get_row("SELECT * FROM $table_smgt_fees_payment WHERE fees_pay_id=".$fees_pay_id);
	return $result;
}
function get_payment_history_by_feespayid($fees_pay_id)
{
	global $wpdb;
	$table_smgt_fee_payment_history = $wpdb->prefix .'smgt_fee_payment_history';
	
	$result =$wpdb->get_results("SELECT * FROM $table_smgt_fee_payment_history WHERE fees_pay_id=".$fees_pay_id);
	return $result;
}
function get_user_name_byid($user_id)
{
	$user_info = get_userdata($user_id);
	if($user_info)
	return  $user_info->display_name;
}
function get_display_name($user_id) {
	if (!$user = get_userdata($user_id))
		return false;
	return $user->data->display_name;
}
function get_emailid_byuser_id($id)
{
	if (!$user = get_userdata($id))
		return false;
	return $user->data->user_email;
}
function get_teacher($id)
{
	
	$user_info = get_userdata($id);
	if($user_info)
	 return  $user_info->first_name." ".$user_info->last_name;
}
function get_payment_list()
{
	global $wpdb;
	$table_users = $wpdb->prefix .'users';
	$table_payment = $wpdb->prefix .'smgt_payment';
	return  $retrieve_paymentlist = $wpdb->get_results( "SELECT * FROM $table_users as u ,$table_payment p where u.ID = p.student_id");
	
}
function get_all_data($tablenm)
{
	global $wpdb;
	$user_id=get_current_user_id ();
	$school_obj = new School_Management ($user_id);
	$table_name = $wpdb->prefix . $tablenm;
	
	return $retrieve_subjects = $wpdb->get_results( "SELECT * FROM ".$table_name);
}	

function smgt_get_teacher_subjects($teacher_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix .'teacher_subject';
	return $retrieve_subjects = $wpdb->get_results( "SELECT * FROM $table_name where teacher_id=$teacher_id");
}
function smgt_get_subject_by_classid($class_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id=".$class_id);
	return $retrieve_subject;	
}
function get_subject($sid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	$retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE subid=".$sid);	
	return $retrieve_subject;
}
function get_single_subject_name($subject_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	return $retrieve_subject = $wpdb->get_var( "SELECT sub_name FROM $table_name WHERE subid=".$subject_id);	
}
function get_single_subject_code($subject_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	return $retrieve_subject = $wpdb->get_var( "SELECT subject_code FROM $table_name WHERE subid=".$subject_id);	
}
function get_subject_name_by_teacher($teacher_id)
{
	global $wpdb;
    $table_name = $wpdb->prefix . "teacher_subject";
    $retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE teacher_id=".$teacher_id);    
    $subjec = '';
    if(!empty($retrieve_subject))
    {
        foreach($retrieve_subject as $retrive_data)
        {
            $sub_name = get_single_subject_name($retrive_data->subject_id);
            $subjec .= $sub_name.', ';
        }
    }
    return $subjec;
	
}

function get_subject_id_by_teacher($teacher_id)
{
	global $wpdb;
    $table_name = $wpdb->prefix . "teacher_subject";
    $retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE teacher_id=".$teacher_id);    
	 
    $subjects = array();
    if(!empty($retrieve_subject))
    {
        foreach($retrieve_subject as $retrive_data)
        {
            $count = is_subject($retrive_data->subject_id);
			if($count > 0)
			{
				$subjects[] = $retrive_data->subject_id;
			}
        }
    }
	 
    return $subjects;
	
}

function is_subject($subject_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	return $retrieve_subject = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE subid=".$subject_id);	
}

function get_class_by_id($sid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_class";
	 $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE class_id=".$sid);
	return $retrieve_subject;
}

function get_class_name_by_id($sid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_class";
	 $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE class_id=".$sid);
	return $retrieve_subject->class_name;
}

function get_grade_by_id($gid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "grade";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE grade_id = ".$gid);
	
}
function get_exam_by_id($eid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	$retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE exam_id = ".$eid);
	return $retrieve_subject;
}

function get_exam_by_class_id($class_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE class_id = ".$class_id);
	
}
function get_all_exam_by_class_id($class_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id =$class_id and section_id='0'");
	
}
function get_all_exam_by_class_id_all($class_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id =$class_id");
	
}
function get_all_class_data_by_class_array($class_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_class";
	return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id IN (".implode(',',$class_id).")");
	
}
function get_all_class_created_by($user_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_class";
	return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE create_by=".$user_id);
	
}
function get_all_exam_by_class_id_array($class_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id IN (".implode(',',$class_id).") and section_id='0'");
	
}
function get_all_exam_by_class_id_and_section_id_array($class_id,$section_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id=$class_id AND section_id=$section_id");
	//return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id IN (".implode(',',$class_id).") and section_id IN (".implode(',',$section_id).")");
}

function get_all_exam_by_class_id_and_section_id_array_parent($class_id,$section_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	
	return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id IN (".implode(',',$class_id).") and section_id IN (".implode(',',$section_id).")");
}
function get_exam_name_id($eid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	return $retrieve_subject = $wpdb->get_var( "SELECT exam_name FROM $table_name WHERE exam_id = ".$eid);

}

function get_transport_by_id($tid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "transport";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE transport_id = ".$tid);
	
}
function get_hall_by_id($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "hall";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE hall_id = ".$id);
}
function get_holiday_by_id($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "holiday";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE holiday_id = ".$id);
}

function get_route_by_id($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_time_table";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE route_id = ".$id);
}
function get_payment_by_id($id)
{
	
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_payment";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE payment_id = ".$id);
}
function delete_payment($tablenm,$tid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE payment_id= %d",$tid));
}
function delete_transport($tablenm,$tid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE transport_id= %d",$tid));

}
function delete_hall($tablenm,$id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE hall_id= %d",$id));
}
function delete_holiday($tablenm,$id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE holiday_id= %d",$id));
}
function delete_route($tablenm,$id)
{
	global $wpdb;
	$obj_virtual_classroom = new smgt_virtual_classroom();
	$table_name = $wpdb->prefix . $tablenm;
	$result = $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE route_id= %d",$id));
	if ($result)
	{
		$meeting_data = $obj_virtual_classroom->smgt_get_singal_meeting_by_route_data_in_zoom($id);
		if(!empty($meeting_data))
		{
			$obj_virtual_classroom->smgt_delete_meeting_in_zoom($meeting_data->meeting_id);
		}
	}
	return $result;
}
function get_teacherid_by_subjectid($id)
{
	global $wpdb;
    $teacher = array();
    
    $table_name = $wpdb->prefix . "teacher_subject";
    $retrieve_subject = $wpdb->get_results( "SELECT teacher_id FROM $table_name WHERE subject_id = ".$id);
    foreach($retrieve_subject as $subject)
    {
        $teacher[] = $subject->teacher_id;
    }
    return $teacher;
}

function smgt_get_user_role($user_id)
{
	$user = new WP_User( $user_id );
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
	foreach ( $user->roles as $role )
		return $role;
	}
}
//------------------------------

function smgt_get_teachers_class($teacher_id)
{
	global $wpdb;
		$table = $wpdb->prefix . 'smgt_teacher_class';
		$result = $wpdb->get_results('SELECT * FROM '.$table.' where teacher_id ='.$teacher_id);
		$return_r = array();
		foreach($result as $retrive_data)
		{
			$return_r[] = $retrive_data->class_id;
		}
		if(!empty($return_r))
			$class_idlist = implode(',',$return_r);
		else
			$class_idlist= '0';
		return $class_idlist;
}
function get_allclass($user_id=0)
{
	global $wpdb;
	$table_name = $wpdb->prefix .'smgt_class';
	if($user_id==0){
		$user_id=get_current_user_id();
	}
	//------------------------TEACHER ACCESS---------------------------------//
	$teacher_access = get_option( 'smgt_access_right_teacher');
	 
	$teacher_access_data=$teacher_access['teacher'];
	foreach($teacher_access_data as $key=>$value)
	{
		if($key=='class')
		{
			$data=$value;
		}
	}
	//------------------------TEACHER ACCESS END---------------------------------//
	 
	//------------------------TEACHER ACCESS---------------------------------//
	if($data['own_data']=='1' && smgt_get_roles($user_id)=='teacher')
	{
		$class_id=get_user_meta($user_id,'class_name',true);
		$class_id=smgt_get_teachers_class($user_id);	
		return $classdata =$wpdb->get_results("SELECT * FROM $table_name where class_id in ($class_id)", ARRAY_A);
	}
	else
	{
		return $classdata =$wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
	}
}

function smgt_get_role($user_id)
{
	$user_meta=get_userdata($user_id);	
	return $user_roles=$user_meta->roles;
}
function get_attendace_status($AttDate)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'holiday';	
	$sql = "SELECT * FROM $tbl_name WHERE '$AttDate' between date and end_date";
	return $result = $wpdb->get_results($sql);
	
}
function cheak_type_status($user_id,$type,$type_id)
{
	global $wpdb;	
	$tbl_smgt_check_status = $wpdb->prefix .'smgt_check_status';	
	
	 $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM $tbl_smgt_check_status WHERE user_id =$user_id AND type ='$type' AND type_id=$type_id");
	
	if($rowcount=="0")
	{
		$status ="Unread";		
	}
	else
	{
		$status = "Read";
	}
	return $status;
}


function get_student_payment_list($std_id)
{
	global $wpdb;	
	$table_payment = $wpdb->prefix .'smgt_payment';
	return $retrieve_paymentlist = $wpdb->get_results( "SELECT * FROM $table_payment WHERE student_id={$std_id}");	
	
}
//get all class   teacher id
function get_all_teacher_data($teacher_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix .'smgt_teacher_class';	
	return $classdata =$wpdb->get_results("SELECT * FROM $table_name where teacher_id in ($teacher_id)");
}
//-----------FOR GET USER DATA ROLE WISE------------------------------------------
function get_usersdata($role){
	global $wpdb;
	
	$capabilities = $wpdb->prefix .'capabilities';
	$this_role = "'[[:<:]]".$role."[[:>:]]'";
	$query = "SELECT * FROM $wpdb->users WHERE ID = ANY (SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '$capabilities' AND meta_value RLIKE $this_role)";
	$users_of_this_role = $wpdb->get_results($query);
	
	if(!empty($users_of_this_role))
		return $users_of_this_role;
	
}

function get_useraa_by_role($role)
{
	return get_users(array('role'=>$role));
}

function get_student_groupby_class()
{
	global $wpdb;
	$student_list = get_usersdata('student');
	$students = array();
	if(!empty($student_list))
	{
	foreach($student_list as $student_obj)
	{		
		$class_id=get_user_meta($student_obj->ID, 'class_name',true);
		if($class_id != '')
		{
			$classname=	get_class_name($class_id);
			$students[$classname][$student_obj->ID]=get_user_name_byid($student_obj->ID)." ( ".get_user_meta($student_obj->ID, 'roll_id',true)." )";
		}
	}
	}
	return $students;

}

//------------------FOR GET USER IMAGE------------------
function get_user_image($uid)
{
	global $wpdb;
	
	// $query = "SELECT meta_value FROM $wpdb->usermeta WHERE user_id = $uid AND meta_key = 'smgt_user_avatar'";
	 // $usersdata = $wpdb->get_results($query,ARRAY_A); 
	
	$usersdata = get_user_meta( $uid, 'smgt_user_avatar' , true );
	// var_dump($usersdata);
	// die();
	// foreach($usersdata as $data)
	// {
		return $usersdata;
	// }
}
function get_user_driver_image($tid)
{
	global $wpdb;
	$table_name = $wpdb->prefix .'transport';
	$query = "SELECT smgt_user_avatar FROM $table_name WHERE transport_id = $tid";
	$usersdata = $wpdb->get_results($query,ARRAY_A); 
	foreach($usersdata as $data)
	{
		return $data;
	}
	
}
 
//---------------FOR ADD NEW USER --------------------------
function add_newuser($userdata,$usermetadata,$firstname,$lastname,$role)
{	
	$Schoolname = 	 get_option('smgt_school_name');		
	$MailSub 	=	 get_option('student_assign_to_teacher_subject');
	$MailCon	=	 get_option('student_assign_to_teacher_content');

	$returnval;
	$user_id = wp_insert_user( $userdata );
 	$user = new WP_User($user_id);
	 $user->set_role($role);
	foreach($usermetadata as $key=>$val)
	{		
		$returnans=add_user_meta( $user_id, $key,$val, true );		
	}
	
	if($user_id)
	{		
		$string = array();
		$string['{{user_name}}']   =  $firstname .' '.$lastname;
		$string['{{school_name}}'] =  get_option('smgt_school_name');
		$string['{{role}}']        =  $role;
		$string['{{login_link}}']  =  site_url() .'/index.php/school-management-login-page';
		$string['{{username}}']    =  $userdata['user_login'];
		$string['{{Password}}']    =  $userdata['user_pass'];
			
		$MsgContent                =  get_option('add_user_mail_content');		
		$MsgSubject				   =  get_option('add_user_mail_subject');
		$message = string_replacement($string,$MsgContent);
		$MsgSubject = string_replacement($string,$MsgSubject);
	
		$email= $userdata['user_email'];
		smgt_send_mail($email,$MsgSubject,$message);
		
		
		// send mail when student assin to teacher.
		if($role=='student')
		{
			 $TeacherIDs = check_class_exits_in_teacher_class($usermetadata['class_name']);	
			$TeacherEmail = array();
			$string['{{school_name}}']  = $Schoolname;
			$string['{{student_name}}'] =  get_display_name($user_id);
			$subject = get_option('student_assign_teacher_mail_subject');
			$MessageContent = get_option('student_assign_teacher_mail_content');
			foreach($TeacherIDs as $teacher)
			{		
				$TeacherData = get_userdata($teacher);		
				//$TeacherData->user_email;
				$string['{{teacher_name}}']= get_display_name($TeacherData->ID);
				$message = string_replacement($string,$MessageContent);
				smgt_send_mail($TeacherData->user_email,$subject,$message);
			}			 
		}
	}
	
	$returnval=update_user_meta( $user_id, 'first_name', $firstname );
	$returnval=update_user_meta( $user_id, 'last_name', $lastname );
	if($role=='parent')
	{
		$child_list = $_REQUEST['chield_list'];
		 
		foreach($child_list as $child_id)
		{
			
			$student_data = get_user_meta($child_id, 'parent_id', true);
			$parent_data = get_user_meta($user_id, 'child', true); 
			 
			if($student_data)
			{
				if(!in_array($user_id, $student_data))
				{
					$update = array_push($student_data,$user_id);				
					$returnans=update_user_meta($child_id,'parent_id', $student_data);
					if($returnans)
					$returnval=$returnans;
				}				
			}
			else
			{
				$parant_id = array($user_id);
				$returnans=add_user_meta($child_id,'parent_id', $parant_id );
				if($returnans)
				$returnval=$returnans;
			}
			if ($parent_data)
			{
				if(!in_array($child_id, $parent_data))
				{
					$update = array_push($parent_data,$child_id);			
					$returnans=update_user_meta($user_id,'child', $parent_data);
					if($returnans)
					$returnval=$returnans;
				}
			}
			else 
			{		
				$child_id = array($child_id);
				$returnans=add_user_meta($user_id,'child', $child_id );
				if($returnans)
					$returnval=$returnans;
			}		
		}
	}
	
	if($role=="teacher")
	{
		/* $Schoolname = get_option('smgt_school_name');		
		$MailSub 	=	 get_option('student_assign_to_teacher_subject');
		$MailCon	=	 get_option('student_assign_to_teacher_content');
		if(!empty($usermetadata['class_name']))
		{			
			$std	= array();	
			foreach($usermetadata['class_name'] as $class)
			{			
				 $std = array_merge(get_student_by_class_id($class),$std);			
			}
			$student_name ='';
			foreach($std as $studentdata)
			{			
				if(!empty($studentdata))
				{
					$MailArr = array();		
					foreach($studentdata as $key=>$student)
					{					
						if(isset($student) && !empty($student))
						{
							$student_name = get_display_name($student->ID);							
							$MailArr['{{school_name}}'] 	= 	$Schoolname;				
							$MailArr['{{teacher_name}}'] 	= 	get_display_name($user_id);
							$MailArr['{{class_name}}'] 		= 	get_class_name(get_user_meta($student->ID,'class_name',true)); 
							$MailArr['{{student_name}}'] 	=  	$student_name; 					
							$MailSub = string_replacement($MailArr,$MailSub);
							$MailCon = string_replacement($MailArr,$MailCon);
							smgt_send_mail($student->user_email,$MailSub,$MailCon);  
						}
					}			
				} 			
			} 		
		}		 */
        $Schoolname = get_option('smgt_school_name');		
		$MailSub 	=	 get_option('student_assign_to_teacher_subject');
		$MailCon	=	 get_option('student_assign_to_teacher_content');
		
		if(!empty($usermetadata['class_name']))
		{			
			$std=array();	
			/* foreach($usermetadata['class_name'] as $class)
			{	 */		
				 $std = array_merge(get_student_by_class_id($usermetadata['class_name']),$std);			
		 //	}
			$student_name ='';
			foreach($std as $studentdata)
			{			
				if(!empty($studentdata))
				{
					//$MailArr = array();
					foreach($studentdata as $key=>$student)
					{		
						if(isset($student) && !empty($student) && $userdata['user_email']==$student->user_email)
						{
							$student_name = get_display_name($student->ID);							
							$MailArr['{{school_name}}'] 	= 	$Schoolname;				
							$MailArr['{{teacher_name}}'] 	= 	get_display_name($user_id);
							$MailArr['{{class_name}}'] 		= 	get_class_name(get_user_meta($student->ID,'class_name',true)); 
							$MailArr['{{student_name}}'] 	=  	$student_name; 					
							$MailSub = string_replacement($MailArr,$MailSub);
							$MailCon = string_replacement($MailArr,$MailCon);
							smgt_send_mail($student->user_email,$MailSub,$MailCon);  
						}
					}			
				} 			
			} 		
		}	
	}
	return $user_id;	
}
 
function smgt_load_documets($file,$type,$nm) 
{ 
	
	$parts = pathinfo($_FILES[$type]['name']);
	$inventoryimagename = time()."-".$nm."-"."in".".".$parts['extension'];
	$document_dir = WP_CONTENT_DIR ;
    $document_dir .= '/uploads/school_assets/';
	$document_path = $document_dir;
	 
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);
	}	
	if (move_uploaded_file($_FILES[$type]['tmp_name'], $document_path.$inventoryimagename)) 
	{
        $imagepath= $inventoryimagename;	
    }
	return $imagepath;
}
// LOAD DOCUMENTS 
function smgt_load_documets_new($file,$type,$nm)
{	
	$parts = pathinfo($type['name']);
	$inventoryimagename = time()."-".$nm."-"."in".".".$parts['extension'];
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/school_assets/';
	$document_path = $document_dir;
	if (!file_exists($document_path)) {
		mkdir($document_path, 0777, true);		
	}
	$imagepath="";	
	if (move_uploaded_file($type['tmp_name'], $document_path.$inventoryimagename)) 
	{
		 $imagepath= $inventoryimagename; 
	}
	return $imagepath;
}
 // LOAD Multiple DOCUMENTS 
function smgt_load_multiple_documets($file,$type,$nm)
{	
	$parts = pathinfo($type['name']);
	
	$inventoryimagename = time()."-".rand().".".$parts['extension'];
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/school_assets/';
	$document_path = $document_dir;
	if (!file_exists($document_path)) {
		mkdir($document_path, 0777, true);		
	}
	$imagepath="";	
	if (move_uploaded_file($type['tmp_name'], $document_path.$inventoryimagename)) 
	{
		 $imagepath= $inventoryimagename; 
	}
	return $imagepath;
}
//-----------------FOR UPDATE USER Profile- ---------------------------------
function update_user_profile($userdata,$usermetadata)
{
	$returnans='';
	$user_id= wp_update_user($userdata);
	
	foreach($usermetadata as $key=>$val)
	{	
		$returnans=update_user_meta($user_id,$key,$val);		
	}
	
	return $returnans;
}

function smgt_get_all_user_in_plugin()
{
	$all_user=array();
	$student = get_users(array('role'=>'student'));
	$teacher = get_users(array('role'=>'teacher'));
	$supportstaff = get_users(array('role'=>'supportstaff'));
	$parent = get_users(array('role'=>'parent'));
	$all_role = array_merge($student,$teacher,$supportstaff,$parent);
	$all_user = array($all_role);
	
	foreach($all_user as $key=>$values){
		return $values;
	}
}

//-----------------FOR UPDATE USER-------------------------------------------
function update_user($userdata,$usermetadata,$firstname,$lastname,$role)
{	
	
	$returnval;
	$user_id 	= 	wp_update_user($userdata);		
	$returnval	=	update_user_meta( $user_id, 'first_name', $firstname );
	$returnval	=	update_user_meta( $user_id, 'last_name', $lastname );
	foreach($usermetadata as $key=>$val)
	{		
		$returnans=update_user_meta( $user_id, $key,$val );
		if($returnans)
			$returnval=$returnans;
	}
	if($role=='parent')
	{
		$child_list = $_REQUEST['chield_list'];	
		$old_child 	= 	get_user_meta($user_id, 'child', true);
		if(!empty($old_child))
		{
			$different_insert_child 	= array_diff($child_list,$old_child);
		    $different_delete_child  	= array_diff($old_child,$child_list);
			
			if(!empty($different_insert_child))
			{
				
				foreach($different_insert_child as $key=>$child)
				{
					$parent 	=	array();
					$parent 	= 	get_user_meta($child, 'parent_id', true);
					$old_child  	= 	get_user_meta($user_id, 'child', true);
					
					array_push($old_child,$child);				
					update_user_meta($user_id,'child',$old_child);
					
					if(empty($parent))
					{					
						$parent1[] = $user_id;
						
						update_user_meta($child,'parent_id',$parent1);
					} 
					else
					{					
						array_push($parent,$user_id);
						update_user_meta($child,'parent_id',$parent);
					}				
				} 
			} 
			
			if(!empty($different_delete_child))
			{		
				
				$child  	= 	get_user_meta($user_id, 'child', true);			
				$childdata = array_diff($child,$different_delete_child);
				update_user_meta($user_id,'child',$childdata);			
				foreach($different_delete_child as $del_key=>$del_child)
				{
					$parent 	=	array();
					$parent 	= 	get_user_meta($del_child, 'parent_id', true);				
									
					if(!empty($parent))
					{
						if(in_array($user_id,$parent))
						{						
							unset($parent[array_search($user_id,$parent)]);
							update_user_meta($del_child,'parent_id',$parent); 
						}
					} 				
					
				} 
			}
		}
		else
		{
			foreach($child_list as $child_id)
			{
				$student_data = get_user_meta($child_id, 'parent_id', true);
				$parent_data = get_user_meta($user_id, 'child', true); 
				if($student_data)
				{
					if(!in_array($user_id, $student_data))
					{
						$update = array_push($student_data,$user_id);				
						$returnans=update_user_meta($child_id,'parent_id', $student_data);
						if($returnans)
						$returnval=$returnans;
					}				
				}
				else
				{
					$parant_id = array($user_id);
					$returnans=add_user_meta($child_id,'parent_id', $parant_id );
					if($returnans)
					$returnval=$returnans;
				}
				if ($parent_data)
				{
					if(!in_array($child_id, $parent_data))
					{
						$update = array_push($parent_data,$child_id);			
						$returnans=update_user_meta($user_id,'child', $parent_data);
						if($returnans)
						$returnval=$returnans;
					}
				}
				else 
				{		
					$child_id = array($child_id);
					$returnans=add_user_meta($user_id,'child', $child_id );
					if($returnans)
						$returnval=$returnans;
				}		
			}
		}
	}
	return $user_id;
}
function sgmt_day_list()
{
	$day_list = array('1' => __('Monday','school-mgt'),
		'2' => __('Tuesday','school-mgt'),
		'3' => __('Wednesday','school-mgt'),
		'4' => __('Thursday','school-mgt'),
		'5' => __('Friday','school-mgt'),
		'6' => __('Saturday','school-mgt'),
		'7' => __('Sunday','school-mgt'));
	return $day_list;
	
}
function sgmt_day_list_new()
{
	$day_list = array('1' =>'Monday',
		'2' =>'Tuesday',
		'3' =>'Wednesday',
		'4' =>'Thursday',
		'5' =>'Friday',
		'6' =>'Saturday',
		'7' =>'Sunday');
	return $day_list;
	
}
function smgt_menu()
{
	$user_menu = array();
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/student-icon.png' ),'menu_title'=>__( 'Student', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>0,'supportstaff' =>1,'page_link'=>'student');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/student-icon.png' ),'menu_title'=>__( 'Child', 'school-mgt' ),'teacher' => 0,'student' => 0,'parent' =>1,'supportstaff' =>0,'page_link'=>'child');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/teacher.png' ),'menu_title'=>__( 'Teacher', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>0,'page_link'=>'teacher');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/parents.png' ),'menu_title'=>__( 'Parent', 'school-mgt' ),'teacher' => 0,'student' => 0,'parent' =>0,'supportstaff' =>0,'page_link'=>'parent');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/subject.png' ),'menu_title'=>__( 'Subject', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>0,'supportstaff' =>0,'page_link'=>'subject');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/class-route.png' ),'menu_title'=>__( 'Class Routine', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>0,'page_link'=>'schedule');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/attandance.png' ),'menu_title'=>__( 'Attendance', 'school-mgt' ),'teacher' => 1,'student' => 0,'parent' =>0,'supportstaff' =>0,'page_link'=>'attendance');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/exam.png' ),'menu_title'=>__( 'Exam', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>0,'page_link'=>'exam');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/mark-manage.png' ),'menu_title'=>__( 'Manage Marks', 'school-mgt' ),'teacher' => 1,'student' => 0,'parent' =>0,'supportstaff' =>1,'page_link'=>'manage_marks');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/fee.png' ),'menu_title'=>__( 'Fee Payment', 'school-mgt' ),'teacher' => 0,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'feepayment');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/payment.png' ),'menu_title'=>__( 'Payment', 'school-mgt' ),'teacher' => 0,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'payment');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/transport.png' ),'menu_title'=>__( 'Transport', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'transport');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/notice.png' ),'menu_title'=>__( 'Notice Board', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'notice');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/message.png' ),'menu_title'=>__( 'Message', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'message');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/holiday.png' ),'menu_title'=>__( 'Holiday', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'holiday');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/library.png' ),'menu_title'=>__( 'Library', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>0,'supportstaff' =>1,'page_link'=>'library');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/account.png' ),'menu_title'=>__( 'Account', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'account');
	return  $user_menu;
}
//----------------- Exam data ------//
function get_exam_list()
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'exam';
	
	$exam =$wpdb->get_results("SELECT *  FROM $tbl_name");
	return $exam;
}
function get_exam_id()
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'exam';
	
	$exam =$wpdb->get_row("SELECT *  FROM $tbl_name");
	return $exam;
}
function get_subject_byid($id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'subject';
	
	$subject =$wpdb->get_row("SELECT * FROM $tbl_name where subid=".$id);
	return $subject->sub_name;
}
function get_student_by_class_id($id)
{
	global $wpdb;
	$student = get_users(array('meta_key' => 'class_name', 'meta_value' => $id));
	return $student;
}
function cheack_student_rollno_exist_or_not($r_no,$student_id)
{
	global $wpdb;
	$student = get_users(array('meta_key' => 'roll_id', 'meta_value' => $r_no));
	if (!empty($student))
	{
		if ($student[0]->ID == $student_id)
		{
			$status = 1;
		}
		else
		{
			$status = 0;
		}
	}
	else
	{
		$status = 1;
	}
	return $status;
}
//Migration
function fail_student_list($current_class,$next_class,$exam_id,$passing_marks)
{
	global $wpdb;
	$table_users = $wpdb->prefix . 'users';
	$table_usermeta = $wpdb->prefix . 'usermeta';
	$capabilities = $wpdb->prefix .'capabilities';
	$table_marks = $wpdb->prefix . 'marks';
	$sql ="SELECT DISTINCT u.id,u.user_login,um.meta_value FROM $table_users as u,$table_usermeta as um,$table_marks as m where
	(um.meta_key = 'class_name' AND um.meta_value = '$current_class') AND u.id = um.user_id
	AND u.ID = ANY (SELECT user_id FROM $table_usermeta WHERE meta_key = '$capabilities' AND meta_value RLIKE 'student')
	AND m.marks < $passing_marks AND u.id = m.student_id AND m.exam_id = $exam_id";
	$student =$wpdb->get_results($sql);
	$failed_list = array();
	if(!empty($student))
	{
	foreach ($student as $fail_student)
	{
		$failed_list[]=$fail_student->id;
	}
	}
	
	return $failed_list;
}

function smgt_migration($current_class,$next_class,$exam_id,$fail_list)
{
	global $wpdb;
	$studentdata=get_usersdata('student');
	$table_usermeta = $wpdb->prefix . 'usermeta';
	if(!empty($studentdata))
	{
		foreach (get_usersdata('student') as $retrieved_data)
		{
			if (!in_array($retrieved_data->ID,$fail_list))
			{
				$sql_update ="UPDATE $table_usermeta set meta_value = '$next_class' where user_id = $retrieved_data->ID AND meta_value = '$current_class' AND meta_key = 'class_name'";
				$student =$wpdb->query($sql_update);
			}			
		}
	}

	
}
//Message
function smgt_count_inbox_item($id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$inbox =$wpdb->get_results("SELECT *  FROM $tbl_name where receiver = $id");
	return $inbox;
}
function smgt_count_unread_message($user_id)
{
	
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$smgt_message_replies = $wpdb->prefix . 'smgt_message_replies';
	
	$inbox =$wpdb->get_results("SELECT *  FROM $tbl_name where ((receiver = $user_id) AND (sender != $user_id)) AND (status=0)");
	
	$reply_msg =$wpdb->get_results("SELECT *  FROM $smgt_message_replies where (receiver_id = $user_id) AND ((status=0) OR (status IS NULL))");
	
	$count_total_message=count($inbox) + count($reply_msg);
	
	return $count_total_message;
}
function get_inbox_message($user_id,$p=0,$lpm1=10)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$tbl_name_message_replies = $wpdb->prefix .'smgt_message_replies';
	
	$inbox =$wpdb->get_results("SELECT DISTINCT b.message_id, a.* FROM $tbl_name a LEFT JOIN $tbl_name_message_replies b ON a.post_id = b.message_id WHERE ( a.receiver = $user_id OR b.receiver_id =$user_id) AND (a.receiver = $user_id OR a.sender = $user_id) ORDER BY date DESC limit $p , $lpm1");

	return $inbox;
}

function get_send_message($user_id,$max=10,$offset=0)
{
	
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$class_obj=new School_Management($user_id);
	if($offset == 0)
	{
		$offset=$offset;
	}
	else
	{
		$offset=(int)$offset*10;
		$offset=$offset-10;	
	}	

	$args['post_type'] = 'message';
	$args['posts_per_page'] =$max;
	$args['offset'] = $offset;
	$args['post_status'] = 'public';
	$args['author'] = $user_id;
	
	$q = new WP_Query();
	$sent_message = $q->query( $args );

	return $sent_message;
}

function smgt_count_send_item($id)
{
	global $wpdb;
	$posts = $wpdb->prefix."posts";
	$total =$wpdb->get_var("SELECT Count(*) FROM ".$posts." Where post_type = 'message' AND post_author = $id");
	return $total;
}
function smgt_pagination($totalposts,$p,$lpm1,$prev,$next){
	$adjacents = 1;
	$page_order = "";
	$pagination = "";
	$form_id = 1;
	if(isset($_REQUEST['form_id']))
		$form_id=$_REQUEST['form_id'];
	if(isset($_GET['orderby']))
	{
		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];
	}
	if($totalposts > 1)
	{
		$pagination .= '<div class="btn-group">';
		
		if ($p > 1)
			$pagination.= "<a href=\"?page=smgt_message&tab=sentbox&form_id=$form_id&pg=$prev$page_order\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
		else
			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";
		
		if ($p < $totalposts)
			$pagination.= " <a href=\"?page=smgt_message&tab=sentbox&form_id=$form_id&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
		else
			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
		$pagination.= "</div>\n";
	}
	return $pagination;
}
function smgt_fronted_sentbox_pagination($totalposts,$p,$lpm1,$prev,$next){
	$adjacents = 1;
	$page_order = "";
	$pagination = "";
	$form_id = 1;
	if(isset($_REQUEST['form_id']))
		$form_id=$_REQUEST['form_id'];
	if(isset($_GET['orderby']))
	{
		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];
	}
	if($totalposts > 1)
	{
		$pagination .= '<div class="btn-group">';
		
		if ($p > 1)
			$pagination.= "<a href=\"?dashboard=user&page=message&tab=sentbox&pg=$prev$page_order\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
		else
			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";

		if ($p < $totalposts)
			$pagination.= " <a href=\"?dashboard=user&page=message&tab=sentbox&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
		else
			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
		$pagination.= "</div>\n";
	}
	return $pagination;
}
function smgt_admininbox_pagination($totalposts,$p,$lpm1,$prev,$next)
{
	$adjacents = 1;
	$page_order = "";
	$pagination = "";
	$form_id = 1;
	if(isset($_REQUEST['form_id']))
		$form_id=$_REQUEST['form_id'];
	if(isset($_GET['orderby']))
	{
		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];
	}
	if($totalposts > 1)
	{
		$pagination .= '<div class="btn-group">';
		
		if ($p > 1)
			$pagination.= "<a href=\"?page=smgt_message&tab=inbox&pg=$prev\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
		else
			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";

		if ($p < $totalposts)
			$pagination.= " <a href=\"?page=smgt_message&tab=inbox&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
		else
			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
		$pagination.= "</div>\n";
	}
	return $pagination;
}
function smgt_inbox_pagination($totalposts,$p,$lpm1,$prev,$next)
{
	$adjacents = 1;
	$page_order = "";
	$pagination = "";
	$form_id = 1;
	if(isset($_REQUEST['form_id']))
		$form_id=$_REQUEST['form_id'];
	if(isset($_GET['orderby']))
	{
		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];
	}
	if($totalposts > 1)
	{
		$pagination .= '<div class="btn-group">';
		
		if ($p > 1)
			$pagination.= "<a href=\"?dashboard=user&page=message&tab=inbox&pg=$prev\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
		else
			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";
	
		if ($p < $totalposts)
			$pagination.= " <a href=\"?dashboard=user&page=message&tab=inbox&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
		else
			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
		$pagination.= "</div>\n";
	}
	return $pagination;
}
function get_message_by_id($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_message";
	$qry = $wpdb->prepare("SELECT * FROM $table_name WHERE message_id= %d",$id);
	return $retrieve_subject = $wpdb->get_row($qry);

}
//add_action( 'wp_login_failed', 'smgt_login_failed' ); // hook failed login 

 function smgt_login_failed( $user ) {
	// check what page the login attempt is coming from
	$referrer = $_SERVER['HTTP_REFERER'];
	$curr_args = array(
			'page_id' => get_option('smgt_login_page'),
			'login' => 'failed'
	);
	//print_r($curr_args);
	$referrer_faild = add_query_arg( $curr_args, get_permalink( get_option('smgt_login_page') ) );
	// check that were not on the default login page
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) 
	{
		// make sure we don't already have a failed login attempt
		if ( !strstr($referrer, '&login=failed' )) 
		{
			// Redirect to the login page and append a querystring of login failed
			wp_redirect( $referrer_faild);
		} else 
		{
			wp_redirect( $referrer );
		}

		exit;
	}
}



 function pu_blank_login( $user ){
	// check what page the login attempt is coming from
	$referrer = $_SERVER['HTTP_REFERER'];

	$error = false;

	if($_POST['log'] == '' || $_POST['pwd'] == '')
	{
		$error = true;
	}

	// check that were not on the default login page
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $error ) {

		// make sure we don't already have a failed login attempt
		if ( !strstr($referrer, '&login=failed') ) {
			// Redirect to the login page and append a querystring of login failed
			wp_redirect( $referrer . '&login=failed' );
		} else {
			wp_redirect(site_url() );
		}

		exit;

	}
}

 /* add_action( 'authenticate', 'MJ_gmgt_check_username_password', 1, 3);
function MJ_smgt_check_username_password( $login, $username, $password ) 
{
// Getting URL of the login page
$referrer = $_SERVER['HTTP_REFERER'];

// if there's a valid referrer, and it's not the default log-in screen
if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) )
{
    if( $username == "" || $password == "" ){
        wp_redirect( get_permalink( get_option('smgt_login_page') ) . "?login=empty" ); 
     exit;
    }
} 

} */
 function smgt_login_link()
{

	$args = array( 'redirect' => site_url() );
	
	if(isset($_GET['login']) && $_GET['login'] == 'failed')
	{
		?>
		<div id="login-error" style="background-color: #FFEBE8;border:1px solid #C00;padding:5px;">
			<p>Login failed: You have entered an incorrect Username or password, please try again.</p>
		</div>
		<?php
	}
	if(isset($_GET['login']) && $_GET['login'] == 'empty')
	{?>

	<div id="login-error" class="login-error" style="background-color: #FFEBE8;border:1px solid #C00;padding:5px;" >
	  <p><?php _e('Login Failed: Username and/or Password is empty, please try again.','school-mgt');?></p>
	</div>
    <?php	
	}
	if(isset($_GET['smgt_activate']) && $_GET['smgt_activate'] == 'smgt_activate')
	{
	?>
		<div id="login-error" style="background-color: #FFEBE8;border:1px solid #C00;padding:5px;">
			<p><?php _e('Login failed: Your account is inactive. Contact your administrator to activate it.','school-mgt');?></p>
		</div>
	<?php
	}
	global $reg_errors;
	$reg_errors = new WP_Error;
		if ( is_wp_error( $reg_errors ) )
		{
			foreach ( $reg_errors->get_error_messages() as $error )
			{
				echo '<div>';
				echo '<strong>ERROR</strong>:';
				echo $error . '<br/>';
				echo '</div>';         
			}
		}
	 $args = array(
			'echo' => true,
			'redirect' => site_url( $_SERVER['REQUEST_URI'] ),
			'form_id' => 'loginform',
			'label_username' => __( 'Username' , 'school-mgt'),
			'label_password' => __( 'Password', 'school-mgt' ),
			'label_remember' => __( 'Remember Me' , 'school-mgt'),
			'label_log_in' => __( 'Log In' , 'school-mgt'),
			'id_username' => 'user_login',
			'id_password' => 'user_pass',
			'id_remember' => 'rememberme',
			'id_submit' => 'wp-submit',
			'remember' => true,
			'value_username' => NULL,
	        'value_remember' => false ); 
	 $args = array('redirect' => site_url('/?dashboard=user') );
	 
	 if ( is_user_logged_in() )
	 {
	 	?>
<a href="<?php echo home_url('/')."?dashboard=user"; ?>">
<?php _e('Dashboard','school-mgt');?>
</a>
<br /><a href="<?php echo wp_logout_url(); ?>"><?php _e('Logout','school-mgt');?></a> 
<?php 
	 }
	 else 
	 {
		wp_login_form( $args );	 
	 }
}
function smgt_view_student_attendance($start_date,$end_date,$user_id)
{
	
	global $wpdb;
	$tbl_name = $wpdb->prefix .'attendence';
	
	$result =$wpdb->get_results("SELECT *  FROM $tbl_name where user_id=$user_id AND role_name = 'student' and attendence_date between '$start_date' and '$end_date'");
	return $result;
}
function smgt_get_attendence($userid,$curr_date)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "attendence";	
	$result=$wpdb->get_var("SELECT status FROM $table_name WHERE attendence_date='$curr_date' and user_id=$userid");
	return $result;

}
function smgt_get_sub_attendence($userid,$curr_date,$sub_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_sub_attendance";
	
	$result=$wpdb->get_var("SELECT status FROM $table_name WHERE attendance_date='$curr_date' and user_id=$userid and sub_id=$sub_id");
	
	return $result;

}
function smgt_get_attendence_comment($userid,$curr_date)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "attendence";
	$result=$wpdb->get_row("SELECT comment FROM $table_name WHERE attendence_date='$curr_date'  and user_id=$userid");
	if(!empty($result))
	 return $result->comment;
	else
		return '';

}
function smgt_get_sub_attendence_comment($userid,$curr_date,$sub_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_sub_attendance";
	$result=$wpdb->get_row("SELECT comment FROM $table_name WHERE attendance_date='$curr_date'  and user_id=$userid and sub_id=$sub_id");
	if(!empty($result))
		return $result->comment;
	else
		return '';

}
//All AJAX Function
add_action( 'wp_ajax_smgt_load_subject_class_id_and_section_id',  'smgt_load_subject_class_id_and_section_id');
add_action( 'wp_ajax_smgt_load_subject',  'smgt_load_subject');
add_action( 'wp_ajax_nopriv_smgt_load_subject',  'smgt_load_subject');
add_action( 'wp_ajax_smgt_load_exam',  'smgt_load_exam');
add_action( 'wp_ajax_smgt_load_exam_by_section',  'smgt_load_exam_by_section');
add_action( 'wp_ajax_smgt_result',  'ajax_smgt_result');
add_action( 'wp_ajax_create_meeting',  'ajax_create_meeting');
add_action( 'wp_ajax_view_meeting_detail',  'ajax_view_meeting_detail');
add_action( 'wp_ajax_smgt_active_student',  'smgt_active_student');
add_action( 'wp_ajax_smgt_result_pdf',  'ajax_smgt_result_pdf');
add_action( 'wp_ajax_smgt_load_user',  'smgt_load_user');
add_action( 'wp_ajax_smgt_load_section_user',  'smgt_load_section_user');
add_action( 'wp_ajax_smgt_load_books',  'smgt_load_books');
add_action( 'wp_ajax_smgt_load_class_fee_type',  'smgt_load_class_fee_type');
add_action( 'wp_ajax_smgt_load_section_fee_type',  'smgt_load_section_fee_type');
add_action( 'wp_ajax_smgt_load_fee_type_amount',  'smgt_load_fee_type_amount');
add_action( 'wp_ajax_cmgt_verify_pkey', 'cmgt_verify_pkey');
add_action( 'wp_ajax_smgt_view_notice',  'ajax_smgt_view_notice');
add_action( 'wp_ajax_smgt_sms_service_setting',  'smgt_sms_service_setting');
add_action( 'wp_ajax_smgt_student_invoice_view',  'smgt_student_invoice_view');
add_action( 'wp_ajax_smgt_student_add_payment',  'smgt_student_add_payment');
add_action( 'wp_ajax_smgt_student_view_paymenthistory',  'smgt_student_view_paymenthistory');
add_action( 'wp_ajax_smgt_student_view_librarryhistory',  'smgt_student_view_librarryhistory');
add_action( 'wp_ajax_smgt_add_remove_feetype',  'smgt_add_remove_feetype');
add_action( 'wp_ajax_nopriv_smgt_add_remove_feetype',  'smgt_add_remove_feetype');
add_action( 'wp_ajax_smgt_add_fee_type',  'smgt_add_fee_type');
add_action( 'wp_ajax_smgt_remove_feetype',  'smgt_remove_feetype');
add_action( 'wp_ajax_nopriv_smgt_remove_feetype',  'smgt_remove_feetype');
add_action( 'wp_ajax_smgt_edit_section',  'smgt_edit_section');
add_action( 'wp_ajax_smgt_update_section',  'smgt_update_section');
add_action( 'wp_ajax_smgt_update_cancel_section',  'smgt_update_cancel_section');
add_action( 'wp_ajax_smgt_get_book_return_date',  'smgt_get_book_return_date');
add_action( 'wp_ajax_smgt_accept_return_book',  'smgt_accept_return_book');
add_action( 'wp_ajax_smgt_load_class_section',  'smgt_load_class_section');
add_action( 'wp_ajax_nopriv_smgt_load_class_section',  'smgt_load_class_section');
add_action( 'wp_ajax_nopriv_smgt_load_section_subject',  'smgt_load_section_subject');
add_action( 'wp_ajax_smgt_load_section_subject',  'smgt_load_section_subject');
add_action( 'wp_ajax_nopriv_smgt_load_class_student',  'smgt_load_class_student');
add_action( 'wp_ajax_smgt_load_class_student',  'smgt_load_class_student');
add_action( 'wp_ajax_smgt_notification_user_list','smgt_notification_user_list');


add_action( 'wp_ajax_smgt_class_by_teacher','smgt_class_by_teacher');
add_action( 'wp_ajax_smgt_teacher_by_class','smgt_teacher_by_class');
add_action( 'wp_ajax_smgt_sender_user_list','smgt_sender_user_list');

add_action( 'wp_ajax_smgt_frontend_sender_user_list','smgt_frontend_sender_user_list');
add_action( 'wp_ajax_smgt_change_profile_photo','smgt_change_profile_photo');

add_action( 'wp_ajax_smgt_count_student_in_class','smgt_count_student_in_class');
add_action( 'wp_ajax_smgt_count_student_in_class','smgt_count_student_in_class');
add_action('wp_ajax_smgt_show_event_task','smgt_show_event_task');
add_action('wp_ajax_nopriv_smgt_show_event_task','smgt_show_event_task');

add_action('wp_ajax_smgt_add_or_remove_category_new','smgt_add_or_remove_category_new');
add_action('wp_ajax_nopriv_smgt_add_or_remove_category_new','smgt_add_or_remove_category_new');

add_action('wp_ajax_smgt_add_category_new','smgt_add_category_new');
add_action('wp_ajax_nopriv_smgt_add_category_new','smgt_add_category_new');

add_action('wp_ajax_smgt_remove_category_new','smgt_remove_category_new');
add_action('wp_ajax_nopriv_smgt_remove_category_new','smgt_remove_category_new');

add_action( 'wp_ajax_smgt_admissoin_approved',  'smgt_admissoin_approved');
add_action( 'wp_ajax_smgt_view_all_relpy',  'smgt_view_all_relpy');
add_action( 'wp_ajax_nopriv_smgt_view_all_relpy',  'smgt_view_all_relpy');
add_action( 'wp_ajax_smgt_view_all_message',  'smgt_view_all_message');
add_action( 'wp_ajax_nopriv_smgt_view_all_message',  'smgt_view_all_message');
add_action( 'wp_ajax_nopriv_generate_access_token',  'generate_access_token');
add_action( 'wp_ajax_generate_access_token',  'generate_access_token');

function smgt_view_all_relpy()
{
	global $wpdb;
	$sTable = $wpdb->prefix .'smgt_message_replies';
      $sTable_wp_users = $wpdb->prefix . 'users';
	 $sLimit = "10";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch)
	   {	      
			$sQuery = "SELECT * FROM  $sTable INNER JOIN $sTable_wp_users ON ($sTable.sender_id = $sTable_wp_users.ID OR $sTable.receiver_id = $sTable_wp_users.ID) WHERE sender_id LIKE '%$ssearch%' OR $sTable_wp_users.display_name LIKE '%$ssearch%' OR receiver_id LIKE '%$ssearch%' OR message_comment LIKE '%$ssearch%' OR created_date LIKE '%$ssearch%' ORDER BY $sTable.created_date DESC $sLimit"; 
			
			$rResult = $wpdb->get_results($sQuery, ARRAY_A);
			
			$wpdb->get_results("SELECT * FROM  $sTable INNER JOIN $sTable_wp_users ON ($sTable.sender_id = $sTable_wp_users.ID OR $sTable.receiver_id = $sTable_wp_users.ID) WHERE sender_id LIKE '%$ssearch%' OR $sTable_wp_users.display_name LIKE '%$ssearch%' OR receiver_id LIKE '%$ssearch%' OR message_comment LIKE '%$ssearch%' OR created_date LIKE '%$ssearch%' ORDER BY $sTable.created_date DESC"); 
			$iFilteredTotal = $wpdb->num_rows;
			$wpdb->get_results("SELECT * FROM  $sTable INNER JOIN $sTable_wp_users ON ($sTable.sender_id = $sTable_wp_users.ID OR $sTable.receiver_id = $sTable_wp_users.ID) WHERE sender_id LIKE '%$ssearch%' OR $sTable_wp_users.display_name LIKE '%$ssearch%' OR receiver_id LIKE '%$ssearch%' OR message_comment LIKE '%$ssearch%' OR created_date LIKE '%$ssearch%' ORDER BY $sTable.created_date DESC");
			$iTotal = $wpdb->num_rows;          
	   }
	   else
	   {
			$sQuery = "SELECT * FROM $sTable ORDER BY created_date DESC $sLimit";
			$rResult = $wpdb->get_results($sQuery, ARRAY_A);
			$wpdb->get_results("SELECT * FROM $sTable Group BY id , id DESC"); 
			$iFilteredTotal = $wpdb->num_rows;
			$wpdb->get_results(" SELECT * FROM $sTable Group BY id , id DESC");
			$iTotal = $wpdb->num_rows;          
	   }
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );	  
 
		 foreach($rResult as $aRow)
		 {
			 $sender_info = get_userdata($aRow['sender_id']);
			
			$receiver_info = get_userdata($aRow['receiver_id']);
			
			$row[0] = '<input type="checkbox" class="select-checkbox sub_chk" name="id[]" value="'.$aRow['id'].'">';
			$row[1] = $sender_info->display_name;
			$row[2] = $receiver_info->display_name;
			$body_char=strlen($msg->message_body);
			$body_char=strlen($aRow['message_comment']);
            if($body_char <= 60)
            {
                $row[3] = $aRow['message_comment'];
            }
            else
            {
                $char_limit = 60;
                $msg_body= substr(strip_tags($aRow['message_comment']), 0, $char_limit)."...";
                $row[3] = $msg_body;
            }
			$attchment=$aRow['message_attachment'];
			
			if(!empty($attchment))
			{
				$attchment_array=explode(',',$attchment);
				$view_attchment='';
				foreach($attchment_array as $attchment_data)
				{					
					$view_attchment.='<a target="blank" href="'.content_url().'/uploads/school_assets/'.$attchment_data.'" class="btn btn-default"><i class="fa fa-download"></i>'.__('View Attachment','school-mgt').'</a></br>';
				}
				$row[4] =$view_attchment;
			}
			else
			{
				 $row[4] =__('No Attachment','school-mgt');
			}	
			$row[5] = convert_date_time($aRow['created_date']);
			$row[6] = '<a href="?page=smgt_message&tab=view_all_message_reply&action=delete_users_reply_message&users_reply_message_id='.$aRow['id'].'" class="btn btn-danger" onclick="return confirm('.__("'Are you sure you want to delete this message?'","'school-mgt'").')">'.__('Delete','school-mgt').'</a>';
			$output['aaData'][] = $row;
		}
	
 echo json_encode( $output );
 die();
}
function smgt_view_all_message()
{
	global $wpdb;
	$sTable = $wpdb->prefix .'smgt_message';
    $sTable_wp_users = $wpdb->prefix . 'users';
	$tablename="smgt_class";
	$retrieve_class = get_all_data($tablename);	
	$sLimit = "10";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch)
	   {	      
			$sQuery = "SELECT * FROM  $sTable INNER JOIN $sTable_wp_users ON ($sTable.sender = $sTable_wp_users.ID OR $sTable.receiver = $sTable_wp_users.ID) WHERE sender LIKE '%$ssearch%' OR $sTable_wp_users.display_name LIKE '%$ssearch%' OR receiver LIKE '%$ssearch%' OR subject LIKE '%$ssearch%' OR message_body LIKE '%$ssearch%' ORDER BY $sTable.date DESC $sLimit"; 
			
			$rResult = $wpdb->get_results($sQuery, ARRAY_A);
			
			$wpdb->get_results("SELECT * FROM  $sTable INNER JOIN $sTable_wp_users ON ($sTable.sender = $sTable_wp_users.ID OR $sTable.receiver = $sTable_wp_users.ID) WHERE sender LIKE '%$ssearch%' OR $sTable_wp_users.display_name LIKE '%$ssearch%' OR receiver LIKE '%$ssearch%' OR subject LIKE '%$ssearch%' OR message_body LIKE '%$ssearch%' ORDER BY $sTable.date DESC"); 
			$iFilteredTotal = $wpdb->num_rows;
			$wpdb->get_results("SELECT * FROM  $sTable INNER JOIN $sTable_wp_users ON ($sTable.sender = $sTable_wp_users.ID OR $sTable.receiver = $sTable_wp_users.ID) WHERE sender LIKE '%$ssearch%' OR $sTable_wp_users.display_name LIKE '%$ssearch%' OR receiver LIKE '%$ssearch%' OR subject LIKE '%$ssearch%' OR message_body LIKE '%$ssearch%' ORDER BY $sTable.date DESC");
			$iTotal = $wpdb->num_rows;          
	   }
	   else
	   {
			$sQuery = "SELECT * FROM $sTable ORDER BY date DESC $sLimit";
			$rResult = $wpdb->get_results($sQuery, ARRAY_A);
			$wpdb->get_results("SELECT * FROM $sTable Group BY message_id , message_id DESC"); 
			$iFilteredTotal = $wpdb->num_rows;
			$wpdb->get_results(" SELECT * FROM $sTable Group BY message_id , message_id DESC");
			$iTotal = $wpdb->num_rows;          
	   }
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );	  
 
		foreach($rResult as $aRow)
		{			 
			$user_id=$aRow['receiver'];
			$school_obj = new School_Management ($user_id);
						
			$attchment=get_post_meta( $aRow['post_id'], 'message_attachment',true);
			
			$sender_info = get_userdata($aRow['sender']);
			
			$receiver_info = get_userdata($aRow['receiver']);
			$row[0] = '<input type="checkbox" class="select-checkbox sub_chk" name="id[]" value="'.$aRow['message_id'].'">';
			$message_for=get_post_meta( $aRow['post_id'], 'message_for',true);
						
			$row[1] = $message_for;
			$row[2] = $sender_info->display_name;
			$row[3] = $receiver_info->display_name;
			
			if(get_post_meta( $aRow['post_id'], 'smgt_class_id',true) !="" && get_post_meta( $aRow['post_id'], 'smgt_class_id',true) == 'all')
			{					
				$row[4] =_e('All','school-mgt');
			}
			elseif(get_post_meta( $aRow['post_id'], 'smgt_class_id',true) !="")
			{
				$smgt_class_id=get_post_meta( $aRow['post_id'], 'smgt_class_id',true);
				$class_id_array=explode(',',$smgt_class_id);
				$class_name_array=array();
				foreach($class_id_array as $data)
				{						
					$class_name_array[]=get_class_name($data);
						
				}
				$row[4] =implode(',',$class_name_array);				
			}
			else
			{
				$row[4] ="NA";
			}
			$subject_char=strlen(get_the_title($aRow['post_id']));
	        if($subject_char <= 10)
	        {
	            $row[5] = get_the_title($aRow['post_id']);
	        }
	        else
	        {
	            $char_limit = 10;
	            $subject_body= substr(strip_tags(get_the_title($aRow['post_id'])), 0, $char_limit)."...";
	            $row[5] = $subject_body;
	        }
	        $content_post = get_post($aRow['post_id']);
	        $body_char=strlen($content_post->post_content);
            if($body_char <= 60)
            {
                $row[6] = $content_post->post_content;
            }
            else
            {
                $char_limit = 60;
                $msg_body= substr(strip_tags($content_post->post_content), 0, $char_limit)."...";
                $row[6] = $msg_body;
            }
			// $row[6] = $content_post->post_content; 
			if(!empty($attchment))
			{
				$attchment_array=explode(',',$attchment);
				$view_attchment='';
				
				foreach($attchment_array as $attchment_data)
				{		
					$view_attchment.='<a target="blank" href="'.content_url().'/uploads/school_assets/'.$attchment_data.'" class="btn btn-default"><i class="fa fa-download"></i>'.__('View Attachment','school-mgt').'</a>';
				}
				$row[7] =$view_attchment;
			}
			else
			{
				 $row[7] =__('No Attachment','school-mgt');
			}
			$created_date=$content_post->post_date_gmt;
			
			$row[8] = convert_date_time($created_date);
			
			$row[9] = '<a href="?page=smgt_message&tab=view_all_message&action=delete_users_message&users_message_id='.$aRow['message_id'].'" class="btn btn-danger" onclick="return confirm('.__("'Are you sure you want to delete this message?'","'school-mgt'").')">'.__('Delete','school-mgt').'</a>';
						
			$output['aaData'][] = $row;
		}
	
 echo json_encode( $output );
 die();
}
function cmgt_verify_pkey()
{
	//$api_server = '192.168.1.22';
	//$api_server = 'http://license.dasinfomedia.com';
	$api_server = 'license.dasinfomedia.com';
	$fp = fsockopen($api_server,80, $errno, $errstr, 2);
	$location_url = admin_url().'admin.php?page=smgt_school';
	if (!$fp)
              $server_rerror = 'Down';
        else
              $server_rerror = "up";
	if($server_rerror == "up")
	{
	$domain_name= $_SERVER['SERVER_NAME'];
	$licence_key = $_REQUEST['licence_key'];
	$email = $_REQUEST['enter_email'];
	$data['domain_name']= $domain_name;
	$data['licence_key']= $licence_key;
	$data['enter_email']= $email;

	//$verify_result = amgt_submit_setupform($data);
	$result = cmgt_check_productkey($domain_name,$licence_key,$email);
	if($result == '1')
	{
		$message = __('Please provide correct Envato purchase key.','school-mgt');
			$_SESSION['cmgt_verify'] = '1';
	}
	elseif($result == '2')
	{
		$message = 'This purchase key is already registered with the different domain. If have any issue please contact us at sales@dasinfomedia.com';
			$_SESSION['cmgt_verify'] = '2';
	}
	elseif($result == '3')
	{
		$message = 'There seems to be some problem please try after sometime or contact us on sales@dasinfomedia.com';
			$_SESSION['cmgt_verify'] = '3';
	}
	elseif($result == '4')
	{
		$message = __('Please provide correct Envato purchase key for this plugin.','school-mgt');
			$_SESSION['cmgt_verify'] = '4';
	}
	else{
		update_option('domain_name',$domain_name,true);
	update_option('licence_key',$licence_key,true);
	update_option('cmgt_setup_email',$email,true);
		$message = 'Success fully register';
			$_SESSION['cmgt_verify'] = '0';
	}
	
	
	$result_array = array('message'=>$message,'cmgt_verify'=>$_SESSION['cmgt_verify'],'location_url'=>$location_url);
	echo json_encode($result_array);
	}
	else
	{
		$message = 'Server is down Please wait some time';
		$_SESSION['cmgt_verify'] = '3';
		$result_array = array('message'=>$message,'cmgt_verify'=>$_SESSION['cmgt_verify'],'location_url'=>$location_url);
	echo json_encode($result_array);
	}
	die();
}
//section select to load subject
function smgt_load_subject_class_id_and_section_id()
{
		$class_id =$_POST['class_id'];
		$section_id =$_POST['section_id'];
		
		global $wpdb;
		$table_name = $wpdb->prefix . "subject";
		$table_name2 = $wpdb->prefix . "teacher_subject";
		$user_id=get_current_user_id();
		//------------------------TEACHER ACCESS---------------------------------//
		$teacher_access = get_option( 'smgt_access_right_teacher');
		$teacher_access_data=$teacher_access['teacher'];
		foreach($teacher_access_data as $key=>$value)
		{
			if($key=='subject')
			{
				$data=$value;
			}
		}
		if(smgt_get_roles($user_id)=='teacher' && $data['own_data']=='1')
		{
		    if($section_id =='')
			{
			  $retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name where  teacher_id=$user_id and class_id=".$class_id);
			}
			else
			{
			  $retrieve_subject = $wpdb->get_results( "SELECT p1.*,p2.* FROM $table_name p1 INNER JOIN $table_name2 p2 ON(p1.subid = p2.subject_id) WHERE p2.teacher_id = $user_id AND p1.class_id = $class_id AND p1.section_id=$section_id");
			}
			
		}
		elseif(smgt_get_roles($user_id)=='teacher')
		{
			  $retrieve_subject = $wpdb->get_results( "SELECT p1.*,p2.* FROM $table_name p1 INNER JOIN $table_name2 p2 ON(p1.subid = p2.subject_id) WHERE p2.teacher_id = $user_id AND p1.class_id = $class_id AND p1.section_id=$section_id");
		}
		elseif(is_admin())
		{
		  /* $retrieve_subject = $wpdb->get_results( "SELECT p1.*,p2.* FROM $table_name p1 INNER JOIN $table_name2 p2 ON(p1.subid = p2.subject_id) WHERE p1.class_id = $class_id AND p1.section_id=$section_id"); */
		  $retrieve_subject = $wpdb->get_results( "SELECT p1.* FROM $table_name p1 WHERE p1.class_id = $class_id AND p1.section_id=$section_id");
		}
		else
		{
			$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id=".$class_id);
		}
		$defaultmsg=__( 'Select subject' , 'school-mgt');
			
		echo "<option value=''>".$defaultmsg."</option>";	
		foreach($retrieve_subject as $retrieved_data)
		{
			echo "<option value=".$retrieved_data->subid."> ".$retrieved_data->sub_name ."</option>";
		}
		exit;
}
/*Delete Notification*/
function smgt_delete_notification($notification_id)
{
	global $wpdb;
	$smgt_notification = $wpdb->prefix. 'smgt_notification';
	$result = $wpdb->query("DELETE FROM $smgt_notification WHERE notification_id=$notification_id");
	return $result;
}
/* Notification user list*/
function smgt_notification_user_list()
{
	$school_obj = new School_Management ( get_current_user_id () );	
	
	
	$class_list = isset($_REQUEST['class_list'])?$_REQUEST['class_list']:'';
	$class_section = isset($_REQUEST['class_section'])?$_REQUEST['class_section']:'';
	$exlude_id = smgt_approve_student_list();

	
	//$results = get_users($query_data);
	$html_class_section = '';
	$return_results['section'] = '';
	$user_list = array();
	global $wpdb;
	$defaultmsg=__( 'All' , 'school-mgt');
	$html_class_section =  "<option value='All'>".$defaultmsg."</option>";	
	if($class_list != '')
	{
		$retrieve_data=smgt_get_class_sections($class_list);	
		if($retrieve_data)
		foreach($retrieve_data as $section)
		{
			$html_class_section .= "<option value='".$section->id."'>".$section->section_name."</option>";
		}
	}
		
	$query_data['exclude']=$exlude_id;
	if($class_section != 'All' && $class_section != ''){
		$query_data['meta_key'] = 'class_section';
		$query_data['meta_value'] = $class_section;
		$query_data['meta_query'] = array(array('key' => 'class_name','value' => $class_list,'compare' => '=') );
		$results = get_users($query_data);
	}
	elseif($class_list != ''){
		$query_data['meta_key'] = 'class_name';
		$query_data['meta_value'] = $class_list;
		$results = get_users($query_data);
	}
	
	if(isset($results))
	{
		foreach($results as $user_datavalue)
			$user_list[] = $user_datavalue->ID;
	}

	
	$user_data_list = array_unique($user_list);
	$return_results['section'] = $html_class_section;
	$return_results['users'] = '';
	$user_string  = '<select name="selected_users" id="notification_selected_users" class="form-control">';
	$user_string .= '<option value="All">'.__('All','school-mgt').'</option>';
	if(!empty($user_data_list))
	foreach($user_data_list as $retrive_data)
	{
		$user_string .= "<option value='".$retrive_data."'>".get_user_name_byid($retrive_data)."</option>";
	}
	$user_string .= '</select>';
	$return_results['users'] = $user_string;
	echo json_encode($return_results);
	die();
}

function check_book_issued($student_id)
{
	global $wpdb;
	$table_issuebook=$wpdb->prefix.'smgt_library_book_issue';
	$booklist = $wpdb->get_results("SELECT * FROM $table_issuebook where student_id=$student_id and ( status='Issue' OR status ='Submitted')");
	return $booklist;
}
function smgt_accept_return_book()
{
	$stud_id=$_REQUEST['student_id'];
	global $wpdb;
	$table_issuebook=$wpdb->prefix.'smgt_library_book_issue';
	$booklist = $wpdb->get_results("SELECT * FROM $table_issuebook where student_id=$stud_id and status='Issue'");
	$student=get_userdata($stud_id);
	//var_dump($result);?>
	<div class="modal-header">
		<a href="#" class="close-btn-cat badge badge-success pull-right">X</a>
		<h4 class="modal-title"><?php _e('Student Library History','school-mgt');?></h4>
	</div>
	<div class="modal-body">
	<div id="invoice_print"> 
		<?php
		if(!empty($booklist)){ ?>
			<h4><?php echo $student->display_name." Date: ".date('Y-m-d'); ?></h4>
			<hr>
			<form name="issue_book-return" method="post">
			<table class="table" width="100%" style="border-collapse:collapse;">
				<thead>
					<tr>
						<th></th>
						<th class="text-left"><?php _e('Book name','school-mgt');?></th>
						<th class="text-left"><?php _e('Overdue By','school-mgt');?></th>
						<th class="text-left"> <?php _e('Fine','school-mgt');?></th>
					</tr>
				</thead>
				<tbody>
				<?php 
					foreach($booklist as  $retrieved_data)
					{
						$date1=date_create(date('Y-m-d'));
						$date2=date_create(date("Y-m-d", strtotime($retrieved_data->end_date)));
						$diff=date_diff($date2,$date1);
					?>
					<tr>
						<td><input type="checkbox" value="<?php echo $retrieved_data->id;?>" name="books_return[]"></td>
						<td><?php echo stripslashes(get_bookname($retrieved_data->book_id));?></td>
						<td><?php if ($date1 > $date2) echo $diff->format("%a "). __("Days","school-mgt"); else echo __("0 Days","school-mgt");?></td>
						<td><input type="number" min="0" class="validate[required,min[0],maxSize[5]]" name="fine[]" value=""> </td>
					</tr>
				<?php } ?>
				</tbody>
					<tr><td colspan="4"><input type="submit" class="btn btn-success" name="submit_book" value="<?php _e("Submit Book","school-mgt");?>"></td></tr>
			</table>
			</form>
			<?php }
				else
				{
					_e('No Any Book Pending','school-mgt');
				}?>
	</div>
	</div>
	<?php 
	die();
}

function smgt_get_book_return_date()
{
	$period_days=get_the_title($_REQUEST['issue_period']);
	$date = date_create($_REQUEST['issue_date']);
	$olddate=date_format($date, 'Y-m-d');
	echo date('m/d/Y', strtotime($olddate. ' + '.$period_days.'Days'));
	die();
}

function smgt_load_subject()
{
	$class_id =$_POST['class_list'];
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	$table_name2 = $wpdb->prefix . "teacher_subject";
	$user_id=get_current_user_id();
	if(smgt_get_roles($user_id)=='teacher') 
	{
		$retrieve_subject = $wpdb->get_results( "SELECT p1.*,p2.* FROM $table_name p1 INNER JOIN $table_name2 p2 ON(p1.subid = p2.subject_id) WHERE p2.teacher_id = $user_id AND p1.class_id = $class_id");
	}
	else
	{
		$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id=".$class_id);
	}
	$defaultmsg=__( 'Select subject' , 'school-mgt');
		
	echo "<option value=''>".$defaultmsg."</option>";	
	foreach($retrieve_subject as $retrieved_data)
	{
		echo "<option value=".$retrieved_data->subid."> ".$retrieved_data->sub_name ."</option>";
	}
	exit;
}

function smgt_load_section_subject()
{
		
		$section_id =$_POST['section_id'];
		global $wpdb;
		$table_name = $wpdb->prefix . "subject";
		$user_id=get_current_user_id();
		//------------------------TEACHER ACCESS---------------------------------//
		$teacher_access = get_option( 'smgt_access_right_teacher');
		$teacher_access_data=$teacher_access['teacher'];
		foreach($teacher_access_data as $key=>$value)
		{
			if($key=='subject')
			{
				$data=$value;
			}
		}
		if(smgt_get_roles($user_id)=='teacher' && $data['own_data']=='1')
		{
			$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name where  teacher_id=$user_id and section_id=".$section_id);
		}
		else
		{
			$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE section_id=".$section_id);
		}
		$defaultmsg=__( 'Select subject' , 'school-mgt');
			
		echo "<option value=''>".$defaultmsg."</option>";	
		foreach($retrieve_subject as $retrieved_data)
		{
			echo "<option value=".$retrieved_data->subid."> ".$retrieved_data->sub_name ."</option>";
		}
		exit;
}

function smgt_load_class_student(){
	//$section_id = $_REQUEST['section_id'];
	$class_list = $_REQUEST['class_list'];
	$args = array(
		'role'=>'student',
		'meta_key'=>'class_name',
		'meta_value'=>$class_list

	);
	$result = get_users( $args );
	foreach($result as $key=>$value){
		print "Yes";
	}
exit;

}
function smgt_load_exam()
{
		
	$class_id =$_POST['class_id'];
	global $wpdb;
	
	$table_name_exam = $wpdb->prefix . "exam";
 
		$retrieve_exam = $wpdb->get_results( "SELECT * FROM $table_name_exam where  class_id=$class_id");
		 
		$defaultmsg=__( 'Select Exam' , 'school-mgt');
			
		echo "<option value=''>".$defaultmsg."</option>";	
		foreach($retrieve_exam as $retrieved_data)
		{
			echo "<option value=".$retrieved_data->exam_id."> ".$retrieved_data->exam_name ."</option>";
		}
		exit;
}

function smgt_load_exam_by_section()
{
	$class_id =$_POST['class_id'];
	$section_id =$_POST['section_id'];
	
	global $wpdb;
	$table_name_exam = $wpdb->prefix . "exam";
 
		$retrieve_exam = $wpdb->get_results( "SELECT * FROM $table_name_exam where  class_id=$class_id and section_id=$section_id");
		 
		$defaultmsg=__( 'Select Exam' , 'school-mgt');
			
		echo "<option value=''>".$defaultmsg."</option>";	
		if(!empty($retrieve_exam))
		{
			foreach($retrieve_exam as $retrieved_data)
			{
				echo "<option value=".$retrieved_data->exam_id."> ".$retrieved_data->exam_name ."</option>";
			}
		}
		
	exit;
}

function ajax_smgt_result()
{
	$obj_mark = new Marks_Manage(); 
	$uid = $_REQUEST['student_id'];
	$user =get_userdata( $uid );
	$user_meta =get_user_meta($uid);
	$class_id = $user_meta['class_name'][0];
	//var_dump($class_id);
	$section_id = $user_meta['class_section'][0];
	//var_dump($class_id);
	$subject = $obj_mark->student_subject_list($class_id,$section_id);
	$total_subject=count($subject);
	$total = 0;
	$grade_point = 0;
	//$all_exam = get_exam_list();
	if((int)$section_id !== 0)
	{
		$all_exam = get_all_exam_by_class_id_and_section_id_array($class_id,$section_id);
	}
	else
	{
		$all_exam = get_all_exam_by_class_id($class_id);
	}
	/* var_dump($all_exam);
	die; */
	?>
	<style>
	 .modal-header{
		 height:auto;
	 }
	</style>
<div class="modal-header"> <a href="#" class="close-btn badge badge-success pull-right">X</a>
	 <img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" />
 <?php echo get_option( 'smgt_school_name' );?> 
</div>
<hr class="hr_margin">
<div class="panel panel-white">
  <div class="panel-heading">
    <h4 class="panel-title"><i class="fa fa-user"></i> <?php echo get_user_name_byid($uid);?></h4>
  </div>
  <?php 
	if(!empty($all_exam))
	{ ?>
	  <div class="clearfix"></div>
	  <div id="accordion" class="panel-group" aria-multiselectable="true" role="tablist">
		<?php 
		$i=0;
		foreach ($all_exam as $exam) /* #### ALL EXAM LOOP STARTS  */
		{
			$exam_id =$exam->exam_id; ?>
			<div class="panel panel-default">
			  <div id="heading_<?php echo $i;?>" class="panel-heading" role="tab">
				<h4 class="panel-title"> <a class="collapsed" aria-controls="collapse_<?php echo $i;?>" aria-expanded="false" href="#collapse_<?php echo $i;?>" data-parent="#accordion" 
					data-toggle="collapse">
				  <?php _e('Exam Results','school-mgt'); ?>
				  : <?php echo $exam->exam_name; ?> </a> </h4>
			  </div>
			  <div id="collapse_<?php echo $i;?>" class="panel-collapse collapse" aria-labelledby="heading_<?php echo $i;?>" role="tabpanel" aria-expanded="false" style="height: 0px;">
				<div class="clearfix"></div>
				<?php
					if(is_super_admin( get_current_user_id() ))
					{ ?>
						<div class="print-button pull-right" style="margin-right: 35px;"> <a href="?page=smgt_student&print=pdf&student=<?php echo $uid;?>&exam_id=<?php echo $exam_id;?>" target="_blank" class="btn btn-info"><?php _e('PDF','school-mgt'); ?></a> <a href="?page=smgt_student&print=print&student=<?php echo $uid;?>&exam_id=<?php echo $exam_id;?>" target="_blank" class="btn btn-info"><?php _e('Print','school-mgt'); ?></a> </div>
						<?php
					}
					else 
					{ ?>
						<div class="print-button pull-right" style="margin-right: 40px;"> <a href="?dashboard=user&page=student&print=pdf&student=<?php echo $uid;?>&exam_id=<?php echo $exam_id;?>" target="_blank" class="btn btn-info"><?php _e('PDF','school-mgt'); ?></a> <a href="?dashboard=user&page=student&print=print&student=<?php echo $uid;?>&exam_id=<?php echo $exam_id;?>" target="_blank" class="btn btn-info"><?php _e('Print','school-mgt'); ?></a> </div>
						<?php 				
					} ?>
					<div class="clearfix"></div>
					<div class="panel-body view_result">
					  <div class="table-responsive">				  
						<table class="table table-bordered">
						  <tr>
							<th><?php _e('Subject','school-mgt')?></th>
							<th><?php _e('Obtain Mark','school-mgt')?></th>
							<th><?php _e('Grade','school-mgt')?></th>
							<th><?php _e('Grade Comment','school-mgt')?></th>
						  </tr>
						  <?php		
							$total=0;
							$grade_point = 0; 
							foreach($subject as $sub) /*** ####  SUBJECT LOOPS STARTS **/
							{
								$marks = $obj_mark->get_marks($exam_id,$class_id,$sub->subid,$uid);
								/* if($marks !=0 )
								{  */?>
							  <tr>
								<td><?php echo $sub->sub_name;?></td>
								<td><?php echo $marks;?> </td>
								<td><?php echo $obj_mark->get_grade($exam_id,$class_id,$sub->subid,$uid);?></td>
								<td><?php echo $obj_mark->get_grade_marks_comment($obj_mark->get_grade($exam_id,$class_id,$sub->subid,$uid));?></td>
							  </tr>
							  <?php
								$total +=  $marks;
								$grade_point += $obj_mark->get_grade_point($exam_id,$class_id,$sub->subid,$uid);
								/* }
								else 
								{ 
									_e("No Result","school-mgt");  ## IF MARKS IS "0" THEN IT WILL PRINT MESSAGE AND DIE. AN ISSUE
									die; 
								}   */
							}   /*####  SUBJECT LOOPS ENDS **/ ?>
						</table>
						  </div>
						  <hr />
						  <p class="result_total">
							<?php _e("Total Marks","school-mgt"); echo "=> ".$total; ?>
						  </p>
						  <hr />
						  <p class="result_point">
							<?php	_e("GPA(grade point average)","school-mgt");
							$GPA=$grade_point/$total_subject;
							echo " => ".round($GPA, 2);?>
						  </p>
						  <hr />
						</div>
			  </div>
			</div>
			<?php
			$i++;
		}  /* #### ALL EXAM LOOP ENDS  */ ?>
	  </div>
	</div>
		<?php 
	}
	else 
	{
		_e('No Result Found','school-mgt');
	}
	exit;
}
function smgt_active_student()
{
	$uid = $_REQUEST['student_id'];
	?>
<div class="modal-header"> <a href="#" class="close-btn badge badge-success pull-right">X</a>
	<h4 id="myLargeModalLabel" class="modal-title"><?php echo get_option( 'smgt_school_name' );?></h4>
</div>
<hr>
<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title"><?php echo get_user_name_byid($uid);?></h4>
	</div>
   <form name="expense_form" action="" method="post" class="form-horizontal" id="expense_form">
		<input type="hidden" name="act_user_id" value="<?php echo $uid;?>">
		<div class="form-group">
			<label class="col-sm-3 control-label" for="roll_id"><?php _e('Roll No.','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="roll_id" class="form-control validate[required,custom[onlyNumberSp]] text-input" maxlength="6" type="text" value="" name="roll_id">
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	 <input type="submit" value="<?php _e('Active Student','school-mgt');?>" name="active_user" class="btn btn-success"/>
        </div>
   </form>
</div>
  <?php
  die();
}
function downlosd_smgt_result_pdf($sudent_id)
{
	ob_start();
	$obj_mark = new Marks_Manage();
	$uid = $sudent_id;
	
	$user =get_userdata( $uid );
	$user_meta =get_user_meta($uid);
	$class_id = $user_meta['class_name'][0];
	$subject = $obj_mark->student_subject($class_id);
	$total_subject=count($subject);
	$exam_id =$_REQUEST['exam_id'];
	$total = 0;
	$grade_point = 0;
	$umetadata=get_user_image($uid); ?>
<center>
  <div style="float:left;width:100%;"> <img src="<?php echo get_option( 'smgt_school_logo' ) ?>"  style="max-height:50px;"/> <?php echo get_option( 'smgt_school_name' );?> </div>
  <div style="width:100%;float:left;border-bottom:1px solid red;"></div>
  <div style="width:100%;float:left;border-bottom:1px solid yellow;padding-top:5px;"></div>
  <br>
  <div style="float:left;width:100%;padding:10px 0;">
    <div style="width:70%;float:left;text-align:left;">
      <p>
        <?php _e('Surname','school-mgt');?>
        :
        <?php get_user_meta($uid, 'last_name',true);?>
      </p>
      <p>
        <?php _e('First Name','school-mgt');?>
        : <?php echo get_user_meta($uid, 'first_name',true);?></p>
      <p>
        <?php _e('Class','school-mgt');?>
        :
        <?php $class_id=get_user_meta($uid, 'class_name',true);
											echo $classname=	get_class_name($class_id);
						?>
      </p>
      <p>
        <?php _e('Exam Name','school-mgt');?>
        :
        <?php 
				echo get_exam_name_id($exam_id);?>
      </p>
    </div>
    <div style="float:right;width:30%;"> <img src="<?php echo $umetadata['meta_value'];?>" width="100" /> </div>
  </div>
  <br>
  <table style="float:left;width:100%;border:1px solid #000;" cellpadding="0" cellspacing="0">
    <thead>
      <tr style="border-bottom: 1px solid #000;">
        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('S/No','school-mgt');?></th>
        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('Subject','school-mgt')?></th>
        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('Obtain Mark','school-mgt')?></th>
        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('Grade','school-mgt')?></th>
      </tr>
    </thead>
    <tbody>
      <?php
	        $i=1;
			foreach($subject as $sub)
			{
			?>
      <tr style="border-bottom: 1px solid #000;">
        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $i;?></td>
        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $sub->sub_name;?></td>
        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->get_marks($exam_id,$class_id,$sub->subid,$uid);?> </td>
        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->get_grade($exam_id,$class_id,$sub->subid,$uid);?></td>
      </tr>
      <?php
			$i++;
			$total +=  $obj_mark->get_marks($exam_id,$class_id,$sub->subid,$uid);
			$grade_point += $obj_mark->get_grade_point($exam_id,$class_id,$sub->subid,$uid);
			} ?>
    </tbody>
  </table>
  <p class="result_total">
    <?php _e("Total Marks","school-mgt");
    echo " : ".$total;?>
  </p>
  <p class="result_point">
    <?php	_e("GPA(grade point average)1","school-mgt");
    $GPA=$grade_point/$total_subject;
    echo " : ".round($GPA, 2);	?>
  </p>
  <hr />
</center>
<?php
		$out_put = ob_get_contents();
		ob_clean();
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="result"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		require_once SMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';
			$mpdf = new Mpdf\Mpdf;
		
		
		$mpdf->WriteHTML($out_put);
		$mpdf->Output();
			
		unset( $out_put );
		unset( $mpdf );
		exit;
}

function downlosd_smgt_result_print($sudent_id)
{
	
   $obj_mark = new Marks_Manage();
	$uid = $sudent_id;
	$user =get_userdata( $uid );
	$user_meta =get_user_meta($uid);
	$class_id = $user_meta['class_name'][0];
	$subject = $obj_mark->student_subject($class_id);
	$total_subject=count($subject);
	$exam_id =$_REQUEST['exam_id'];
	$total = 0;
	$grade_point = 0;
	$umetadata=get_user_image($uid);
	ob_start();
	?>
<div style="float:left;width:70%;"> <img src="<?php echo get_option( 'smgt_school_logo' ) ?>"  style="max-height:50px;"/> <?php echo get_option( 'smgt_school_name' );
					
					?> </div>
<div style="width:100%;float:left;border-bottom:1px solid red;"></div>
<div style="width:100%;float:left;border-bottom:1px solid yellow;padding-top:5px;"></div>
<br>
<div style="float:left;width:100%;padding:10px 0;">
  <div style="width:70%;float:left;text-align:left;">
    <p>
      <?php _e('Surname','school-mgt');?>
      :
      <?php echo get_user_meta($uid, 'last_name',true);?>
    </p>
    <p>
      <?php _e('First Name','school-mgt');?>
      : <?php echo get_user_meta($uid, 'first_name',true);?></p>
    <p>
      <?php _e('Class','school-mgt');?>
      :
      <?php $class_id=get_user_meta($uid, 'class_name',true);
											echo $classname=	get_class_name($class_id);
						?>
    </p>
    <p>
      <?php _e('Exam Name','school-mgt');?>
      :
      <?php echo get_exam_name_id($exam_id);?>
    </p>
  </div>
  <div style="float:right;width:30%;"> 
  <?php 
		if(empty($umetadata['meta_value']))
		{
			echo '<img src='.get_option( 'smgt_student_thumb' ).'  width="100" />';
		}
		else
			echo '<img src='.$umetadata['meta_value'].' width="100" />';
		?>
  
  </div>
</div>
<br>
<table style="float:left;width:100%;border:1px solid #000;">
  <thead>
    <tr style="border-bottom: 1px solid #000;">
      <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('S/No','school-mgt');?></th>
      <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('Subject','school-mgt')?></th>
      <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('Obtain Mark','school-mgt')?></th>
      <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('Grade','school-mgt')?></th>
    </tr>
  </thead>
  <tbody>
    <?php
	$i=1;
	foreach($subject as $sub)
	{ ?>
    <tr style="border-bottom: 1px solid #000;">
      <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $i;?></td>
      <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $sub->sub_name;?></td>
      <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->get_marks($exam_id,$class_id,$sub->subid,$uid);?> </td>
      <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->get_grade($exam_id,$class_id,$sub->subid,$uid);?></td>
    </tr>
    <?php
		$i++;
		$total +=  $obj_mark->get_marks($exam_id,$class_id,$sub->subid,$uid);
		$grade_point += $obj_mark->get_grade_point($exam_id,$class_id,$sub->subid,$uid);
	} ?>
  </tbody>
</table>
<p class="result_total">
  <?php _e("Total Marks","school-mgt");
    echo " : ".$total;?>
</p>
<p class="result_point">
  <?php	_e("GPA(grade point average)","school-mgt");
  $GPA=$grade_point/$total_subject;
    echo " : ".round($GPA, 2);	?>
</p>
<hr />
<?php
	$out_put = ob_get_contents();	
}
function print_init_admin_side()
{
	if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'print' && $_REQUEST['page'] == 'smgt_student' )
	{
	?>
    <script>window.onload = function(){ window.print(); };</script>
    <?php 
		$sudent_id = $_REQUEST['student'];
		downlosd_smgt_result_print($sudent_id);
		exit;
	}			
}
function print_init_student_side()
{
	if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'print' && $_REQUEST['page'] == 'student' )
	{
	?>
    <script>window.onload = function(){ window.print(); };</script>
    <?php 
		$sudent_id = $_REQUEST['student'];
		downlosd_smgt_result_print($sudent_id);
		exit;
	}			
}

add_action('init','print_init_student_side');
add_action('init','print_init_admin_side');
function ajax_smgt_result_pdf()
{
	$obj_mark = new Marks_Manage();
	$uid = $_REQUEST['student_id'];
	
	$user =get_userdata( $uid );
	$user_meta =get_user_meta($uid);
	$class_id = $user_meta['class_name'][0];
	$subject = $obj_mark->student_subject($class_id);
	$exam_id =get_exam_id()->exam_id;
	$total = 0;
	$grade_point = 0;
	ob_start();
	?>
<div class="panel panel-white">
<form method="post">
  <input type="hidden" name="student_id" value = "<?php echo $uid;?>">
  <button id="pdf" type="button"><?php _e('PDF','school-mgt'); ?>  </button>
</form>
<p class="student_name">
  <?php _e('Result','school-mgt');?>
</p>
<div class="panel-heading clearfix">
  <h4 class="panel-title"><?php echo get_user_name_byid($uid);?></h4>
</div>
<div class="panel-body">
  <div class="table-responsive">
    <table class="table table-bordered">
      <tr>
        <th><?php _e('Subject','school-mgt');?></th>
        <th><?php _e('Obtain Mark','school-mgt');?></th>
        <th><?php _e('Grade','school-mgt');?></th>
        <th><?php _e('Attendance','school-mgt');?></th>
        <th><?php _e('Comment','school-mgt');?></th>
      </tr>
      <?php
		foreach($subject as $sub)
		{
		?>
      <tr>
        <td><?php echo $sub->sub_name;?></td>
        <td><?php echo $obj_mark->get_marks($exam_id,$class_id,$sub->subid,$uid);?> </td>
        <td><?php echo $obj_mark->get_grade($exam_id,$class_id,$sub->subid,$uid);?></td>
        <td><?php echo $obj_mark->get_attendance($exam_id,$class_id,$sub->subid,$uid);?></td>
        <td><?php echo $obj_mark->get_marks_comment($exam_id,$class_id,$sub->subid,$uid);?></td>
      </tr>
      <?php
		$total +=  $obj_mark->get_marks($exam_id,$class_id,$sub->subid,$uid);
		$grade_point += $obj_mark->get_grade_point($exam_id,$class_id,$sub->subid,$uid);
		}
		$GPA=$grade_point/$total_subject;?>
    </table>
  </div>
</div>
<hr />
<?php echo "GPA is".$GPA; ?>
<p class="result_total"><?php _e("Total Marks","school-mgt")."=>".$total;?></p>
<hr />
<p class="result_point">
  <?php _e("GPA(grade point average)","school-mgt") ."=> ".$grade_point;	?>
</p>
<hr />
<?php
	$out_put = ob_get_contents();
	ob_end_clean();
	require_once SMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';
	$mpdf = new Mpdf\Mpdf;
	
	$mpdf->WriteHTML($out_put);
	$mpdf->Output('filename.pdf','F');
		
	unset( $out_put );
	unset( $mpdf );
	exit;
	
}
function smgt_load_user()
{
	$class_id =$_REQUEST['class_list'];
	global $wpdb;		
	$exlude_id = smgt_approve_student_list();
	$retrieve_data = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
	//$retrieve_data = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student'));	
	$defaultmsg=__( 'Select student' , 'school-mgt');
	echo "<option value=''>".$defaultmsg."</option>";	
	foreach($retrieve_data as $users)
	{
		echo "<option value=".$users->id.">".$users->first_name." ".$users->last_name."</option>";
	}
	die();		
}

function smgt_load_section_user()
{		
	$section_id =$_POST['section_id'];	
	
	global $wpdb;	
	$exlude_id = smgt_approve_student_list();
	$retrieve_data = get_users(array('meta_key' => 'class_section', 'meta_value' => $section_id,'role'=>'student','exclude'=>$exlude_id));
	$defaultmsg=__( 'Select student' , 'school-mgt');
	echo "<option value=''>".$defaultmsg."</option>";	
	foreach($retrieve_data as $users)
	{
		echo "<option value=".$users->id.">".$users->first_name." ".$users->last_name."</option>";
	}
	die();		
}

function smgt_load_class_section()
{
		
		echo  $class_id =$_POST['class_id'];
		global $wpdb;
		$retrieve_data=smgt_get_class_sections($_POST['class_id']);
		$defaultmsg=__( 'Select Class Section' , 'school-mgt');
		echo "<option value=''>".$defaultmsg."</option>";	
		foreach($retrieve_data as $section)
		{
			echo "<option value='".$section->id."'>".$section->section_name."</option>";
		}
		die();
		
}
function smgt_teacher_by_subject($subject_id){
	global $wpdb;
	$teacher_rows = array();	
	if(isset($subject_id->subid))
	{
		$subid = (int)$subject_id->subid;	
		$table_smgt_subject = $wpdb->prefix. 'teacher_subject';	
		$result = $wpdb->get_results("SELECT * FROM $table_smgt_subject where subject_id = $subid");
		
		foreach($result as $tch_result)
		{
			$teacher_rows[] = $tch_result->teacher_id;
		}
	}
	return $teacher_rows;
	die();
}
function smgt_class_by_teacher(){
	
	
	$teacher_id = $_REQUEST['teacher_id'];
	$teacher_obj = new Smgt_Teacher;
	$classes = $teacher_obj->smgt_get_class_by_teacher($teacher_id);
	
	foreach($classes as $class)
	{
		$classdata = get_class_by_id($class['class_id']);
		echo "<option value={$class['class_id']}>{$classdata->class_name}</option>";
	}
	wp_die();
}
function smgt_teacher_by_class()
{
	$class_id = $_REQUEST['class_id'];
	$teacher_obj = new Smgt_Teacher;
	$classes = $teacher_obj->get_class_teacher($class_id);

	foreach($classes as $class)
	{
		
		echo "<option value={$class['teacher_id']}>".get_user_name_byid($class['teacher_id'])."</option>";
	}
	wp_die();
}
function smgt_load_books()
{
	$cat_id =$_POST['bookcat_id'];
	global $wpdb;
	$table_book=$wpdb->prefix.'smgt_library_book';
	//print "SELECT * FROM $table_book where cat_id=".$cat_id ."AND quentity !=". 0; die;
	$retrieve_data=$wpdb->get_results(" SELECT * FROM $table_book where cat_id=$cat_id AND quentity !=". 0);
	//$defaultmsg=__( 'Select Book' , 'school-mgt');
	//echo "<option value=''>".$defaultmsg."</option>";	
	foreach($retrieve_data as $book)
	{
		echo "<option value=".$book->id.">".stripslashes($book->book_name)."</option>";
	}
	die();
}

function smgt_load_class_fee_type()
{
	$class_list = $_POST['class_list'];
	global $wpdb;
	$table_smgt_fees = $wpdb->prefix. 'smgt_fees';	
	$result = $wpdb->get_results("SELECT * FROM $table_smgt_fees where class_id = $class_list");
	$defaultmsg=__( 'Select Fee Type' , 'school-mgt');
		echo "<option value=' '>".$defaultmsg."</option>";
	if(!empty($result))
	{
		foreach($result as $retrive_data)
		{
			echo '<option value="'.$retrive_data->fees_id.'">'.get_the_title($retrive_data->fees_title_id).'</option>';
		}
	}
	else
		return false;
	die();
}
function smgt_load_section_fee_type()
{
	$section_id = $_POST['section_id'];
	global $wpdb;
	$table_smgt_fees = $wpdb->prefix. 'smgt_fees';	
	$result = $wpdb->get_results("SELECT * FROM $table_smgt_fees where section_id = $section_id");
	$defaultmsg=__( 'Select Fee Type' , 'school-mgt');
		echo "<option value=' '>".$defaultmsg."</option>";
	if(!empty($result))
	{
		foreach($result as $retrive_data)
		{
			echo '<option value="'.$retrive_data->fees_id.'">'.get_the_title($retrive_data->fees_title_id).'</option>';
		}
	}
	else
		return false;
	die();
}
function smgt_load_fee_type_amount()
{
	$fees_id = $_POST['fees_id'];
	global $wpdb;
	$table_smgt_fees = $wpdb->prefix. 'smgt_fees';	
	$result = $wpdb->get_row("SELECT * FROM $table_smgt_fees where fees_id = $fees_id");
	echo $result->fees_amount;
	die();
}
function ajax_smgt_view_notice()
{
	 $notice = get_post($_REQUEST['notice_id']);
	 ?>
<div class="form-group"> <a class="close-btn badge badge-success pull-right" href="#">X</a>
  <h4 class="modal-title" id="myLargeModalLabel">
    <?php _e('Notice Detail','school-mgt'); ?>
  </h4>
</div>
<hr>
<div class="panel panel-white form-horizontal view_notice_overflow">
  <div class="form-group dis_flex_res">
    <label class="col-sm-3" for="notice_title">
    <?php _e('Notice Title','school-mgt');?>
    : </label>
    <div class="col-sm-9"> <?php echo $notice->post_title;?> </div>
  </div>
  <div class="form-group dis_flex_res">
    <label class="col-sm-3" for="notice_title">
    <?php _e('Notice Comment','school-mgt');?>
    : </label>
    <div class="col-sm-9"> <?php echo $notice->post_content;?> </div>
  </div>
  <div class="form-group dis_flex_res">
    <label class="col-sm-3" for="notice_title">
    <?php _e('Notice For','school-mgt');?>
    : </label>
    <div class="col-sm-9"> <?php echo get_post_meta( $notice->ID, 'notice_for',true);?> </div>
  </div>
  <div class="form-group dis_flex_res">
    <label class="col-sm-3" for="notice_title">
    <?php _e('Start Date','school-mgt');?>
    : </label>
    <div class="col-sm-9"> <?php echo smgt_getdate_in_input_box(get_post_meta( $notice->ID, 'start_date',true));?> </div>
  </div>
  <div class="form-group dis_flex_res">
    <label class="col-sm-3" for="notice_title">
    <?php _e('End Date','school-mgt');?>
    : </label>
    <div class="col-sm-9"> <?php echo smgt_getdate_in_input_box(get_post_meta( $notice->ID, 'end_date',true));?> </div>
  </div>
</div>
<?php 
	die();
}

function inventory_image_upload($file) {

	$type = "subject_syllabus";
	$imagepath =$file;
	$parts = pathinfo($_FILES[$type]['name']);
	$inventoryimagename = mktime(time())."-"."in".".".$parts['extension'];
	$document_dir = WP_CONTENT_DIR ;
    $document_dir .= '/uploads/school_assets/';
	$document_path = $document_dir;
	if($imagepath != "")
	{	
		if(file_exists(WP_CONTENT_DIR.$imagepath))
		unlink(WP_CONTENT_DIR.$imagepath);
	}
	if (!file_exists($document_path)) {
		mkdir($document_path, 0777, true);
	}	
    if (move_uploaded_file($_FILES[$type]['tmp_name'], $document_path.$inventoryimagename)) {
        $imagepath= $inventoryimagename;	
    }
return $imagepath;

}
function smgt_user_avatar_image_upload($type) {


$imagepath =$file;
     
$parts = pathinfo($_FILES[$type]['name']);


 $inventoryimagename = mktime()."-"."student".".".$parts['extension'];
 $document_dir = WP_CONTENT_DIR ;
           $document_dir .= '/uploads/school_assets/';
	
		$document_path = $document_dir;

 
if($imagepath != "")
{	
	if(file_exists(WP_CONTENT_DIR.$imagepath))
	unlink(WP_CONTENT_DIR.$imagepath);
}
if (!file_exists($document_path)) {
	mkdir($document_path, 0777, true);
}	
       if (move_uploaded_file($_FILES[$type]['tmp_name'], $document_path.$inventoryimagename)) {
          $imagepath= $inventoryimagename;	
       }


return $imagepath;

}
function smgt_register_post()
{
	register_post_type( 'message', array(
	
			'labels' => array(
	
					'name' => __( 'Message', 'school-mgt' ),
	
					'singular_name' => 'message'),
	
			'rewrite' => false,
	
			'query_var' => false ) );
	
}
function smgt_sms_service_setting()
{
	
	$select_serveice = $_POST['select_serveice'];
	
	if($select_serveice == 'clickatell')
	{
		$clickatell=get_option( 'smgt_clickatell_sms_service');
			?>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="username"><?php _e('Username','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="username" class="form-control validate[required]" type="text" value="<?php if(isset($clickatell['username'])) echo $clickatell['username'];?>" name="username">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="password"><?php _e('Password','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="password" class="form-control validate[required]" type="text" value="<?php if(isset($clickatell['password'])) echo $clickatell['password'];?>" name="password">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="api_key"><?php _e('API Key','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="api_key" class="form-control validate[required]" type="text" value="<?php if(isset($clickatell['api_key'])) echo $clickatell['api_key'];?>" name="api_key">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="sender_id"><?php _e('Sender Id','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="sender_id" class="form-control validate[required]" type="text" value="<?php echo $clickatell['sender_id'];?>" name="sender_id">
			</div>
		</div>
	<?php 
	}
	if($select_serveice == 'twillo')
	{
	$twillo=get_option( 'smgt_twillo_sms_service');
			?>
			<div class="form-group">
			<label class="col-sm-2 control-label " for="account_sid"><?php _e('Account SID','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="account_sid" class="form-control validate[required]" type="text" value="<?php if(isset($twillo['account_sid'])) echo $twillo['account_sid'];?>" name="account_sid">
			</div>
		</div>
	<div class="form-group">
			<label class="col-sm-2 control-label" for="auth_token"><?php _e('Auth Token','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="auth_token" class="form-control validate[required] text-input" type="text" name="auth_token" value="<?php if(isset($twillo['auth_token'])) echo $twillo['auth_token'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="from_number"><?php _e('From Number','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="from_number" class="form-control validate[required] text-input" type="text" name="from_number" value="<?php if(isset($twillo['from_number'])) echo $twillo['from_number'];?>">
			</div>
		</div>
		
	<?php }
	if($select_serveice == 'msg91')
	{
		$msg91=get_option( 'smgt_msg91_sms_service');
		?>
			<div class="form-group">
			<label class="col-sm-2 control-label " for="sms_auth_key"><?php _e('Authentication Key','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="sms_auth_key" class="form-control validate[required]" type="text" value="<?php echo $msg91['sms_auth_key'];?>" name="sms_auth_key">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="msg91_senderID"><?php _e('SenderID','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="msg91_senderID" class="form-control validate[required] text-input" type="text" name="msg91_senderID" value="<?php echo $msg91['msg91_senderID'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="wpnc_sms_route"><?php _e('Route','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="wpnc_sms_route" class="form-control validate[required] text-input" type="text" name="wpnc_sms_route" value="<?php echo $msg91['wpnc_sms_route'];?>">
			</div>
		</div>
	
	<?php 
	}
	die();
}

function smgt_student_invoice_view()
{
	$obj_invoice= new Smgtinvoice();
	if($_POST['invoice_type']=='invoice')
	{
		$invoice_data=get_payment_by_id($_POST['idtest']);
	}
	if($_POST['invoice_type']=='income'){
		$income_data=$obj_invoice->smgt_get_income_data($_POST['idtest']);
	}
	if($_POST['invoice_type']=='expense'){
		$expense_data=$obj_invoice->smgt_get_income_data($_POST['idtest']);	
	} ?>
	<div class="modal-header">
			<a href="#" class="close-btn-cat badge badge-success pull-right">X</a>
			<h4 class="modal-title"><?php echo get_option('smgt_school_name');?></h4>
	</div>
	<div class="modal-body" style="height:520px; overflow:hidden;">
		<div id="invoice_print"> 
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td width="50%">
							<img style="max-height:80px;" src="<?php echo get_option( 'smgt_school_logo' ); ?>">
						</td>
						<td align="right" width="24%">
							<h4><?php
							if(!empty($invoice_data)){
								//$invoice_no=$invoice_data->invoice_number;
								//_e('Invoice number','school-mgt');
								//echo " : ".$invoice_no;
								}
							?> </h4>
							<h5>
								<?php $issue_date='DD-MM-YYYY';
									if(!empty($income_data)){
										$issue_date=$income_data->income_create_date;
										$payment_status=$income_data->payment_status;}
									if(!empty($invoice_data)){
										$issue_date=$invoice_data->date;
										$payment_status=$invoice_data->payment_status;	}
									if(!empty($expense_data)){
										$issue_date=$expense_data->income_create_date;
										$payment_status=$expense_data->payment_status;}
							echo __('Issue Date','school-mgt')." : ".smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date)));?></h5><br>
							<h5><?php 
								if($payment_status=='Paid') 
								{ echo __('Status','school-mgt')." : ".__('Paid','school-mgt');}
								if($payment_status=='Part Paid')
								{ echo __('Status','school-mgt')." : ".__('Partially Paid','school-mgt');}
								if($payment_status=='Unpaid')
								{echo __('Status','school-mgt')." : ".__('Unpaid','school-mgt'); } ?></h5>
						</td>
					</tr>
				</tbody>
			</table>
			<hr>
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td class="col-md-6 padding_payment">
						
							<h4><?php if($_POST['invoice_type']=='expense'){ _e('Payment From','school-mgt'); }else { _e('Payment From','school-mgt'); }?> </h4>
						</td>
						<td class="col-md-6 padding_payment pull-right" style="text-align:right;">
							<h4><?php _e('Bill To','school-mgt');?> </h4>
						</td>
					</tr>
					<tr>
						<td valign="top" class="col-md-6 padding_payment">
							<?php echo get_option( 'smgt_school_name' )."<br>"; 
							 echo get_option( 'smgt_school_address' ).","; 
							 echo get_option( 'smgt_contry' )."<br>"; 
							 echo get_option( 'smgt_contact_number' )."<br>"; ?>
						</td>
						<td valign="top" class="col-md-6 padding_payment" style="text-align:right;">
							<?php 
							if(!empty($expense_data))
							{
							  echo $party_name=$expense_data->supplier_name; 
							}
							else
							{
								
								if(!empty($income_data))
								{
									$student_id=$income_data->supplier_name;
								}
							    if(!empty($invoice_data))
								{
								    $student_id=$invoice_data->student_id;
								}
								
								 $patient=get_userdata($student_id);
								 echo $patient->display_name."<br>";
								 echo 'Student ID'.' <b>'.get_user_meta( $student_id,'roll_id',true )."</b><br>"; 
								 echo get_user_meta( $student_id,'address',true ).","; 
								 echo get_user_meta( $student_id,'city',true ).","."<BR>"; ; 
								 echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
								 echo get_user_meta( $student_id,'state',true ).","; 
								 echo get_option( 'smgt_contry' ).","; 
								 echo get_user_meta( $student_id,'mobile',true )."<br>"; 
								 
							}
							?>
						</td>
					</tr>
				</tbody>
			</table>
			<hr>
			<h4><?php _e('Invoice Entries','school-mgt');?></h4>
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center"> <?php _e('Date','school-mgt');?></th>
							<th width="60%"><?php _e('Entry','school-mgt');?> </th>
							<th><?php _e('Price','school-mgt');?></th>
							<th class="text-center"> <?php _e('Issue By','school-mgt');?> </th>
						</tr>
					</thead>
					<tbody>
					<?php 
						$id=1;
						$total_amount=0;
						if(!empty($income_data) || !empty($expense_data)){
							if(!empty($expense_data))
								$income_data=$expense_data;
						
						$patient_all_income=$obj_invoice->get_onepatient_income_data($income_data->supplier_name);
						
						foreach($patient_all_income as $result_income){
							$income_entries=json_decode($result_income->entry);
							foreach($income_entries as $each_entry)
							{
								$total_amount+=$each_entry->amount;								
						?>
						<tr>
							<td class="text-center"><?php echo $id;?></td>
							<td class="text-center"><?php echo $result_income->income_create_date;?></td>
							<td><?php echo $each_entry->entry; ?> </td>
							<td class="text-right"> <?php echo "<span> ". get_currency_symbol() ."</span>" .number_format($each_entry->amount,2) ; ?></td>
							<td class="text-center"><?php echo get_display_name($result_income->create_by);?></td>
						</tr>
							<?php $id+=1;}
							}
					 
					}
					 if(!empty($invoice_data)){
						 $total_amount=$invoice_data->amount
						 ?>
						<tr>
							<td class="text-center"><?php echo $id;?></td>
							<td class="text-center"><?php echo date("Y-m-d", strtotime($invoice_data->date));?></td>
							<td><?php echo $invoice_data->payment_title; ?> </td>
							<td class="text-right"> <?php echo "<span> ". get_currency_symbol() ." </span>" .number_format($invoice_data->amount,2); ?></td>
							<td class="text-center"><?php echo get_display_name($invoice_data->payment_reciever_id);?></td>
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
			<table width="100%" border="0">
				<tbody>							
					<?php if(!empty($invoice_data))
					{								
						$grand_total= $total_amount;							
					}
					if(!empty($income_data))
					{
						$grand_total=$total_amount;
					}
					?>								
					<tr>
						<td width="80%" align="right"><?php _e('Grand Total :','school-mgt');?></td>
						<td align="right"><h4><?php echo "<span> ". get_currency_symbol() ." </span>" .number_format($grand_total,2); ?></h4></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="print-button pull-left">
			<a  href="?page=smgt_payment&print=print&invoice_id=<?php echo $_POST['idtest'];?>&invoice_type=<?php echo $_POST['invoice_type'];?>" target="_blank"class="btn btn-success"><?php _e('Print','school-mgt');?></a>
			&nbsp;&nbsp;&nbsp;
			<a  href="?page=smgt_payment&print=pdf&invoice_id=<?php echo $_POST['idtest'];?>&invoice_type=<?php echo $_POST['invoice_type'];?>" target="_blank"class="btn btn-success"><?php _e('PDF','school-mgt');?></a>
		</div>
	</div>
	<?php 
	 die();
}
function smgt_student_add_payment()
{
	$fees_pay_id = $_POST['idtest'];
	$due_amount = $_POST['due_amount'];
	$student_id = $_POST['student_id'];
	$max_due_amount = str_replace(",", "", $_POST['due_amount']);
?>
		<script type="text/javascript">
$(document).ready(function() {
	$('#expense_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});	
} );
</script>
	<div class="modal-header">
			<a href="#" class="close-btn-cat badge badge-success pull-right">X</a>
			<h4 class="modal-title"><?php echo get_option('smgt_school_name');?></h4>
	</div>
	<div class="modal-body">
		 <form name="expense_form" action="" method="post" class="form-horizontal" id="expense_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="student_id" value="<?php echo $student_id;?>">
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="fees_pay_id" value="<?php echo $fees_pay_id;?>">
		<div class="form-group">
			<label class="col-sm-3 control-label" for="amount"><?php _e('Paid Amount','school-mgt');?>(<?php echo get_currency_symbol();?>)<span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="amount" class="form-control validate[required,min[0],max[<?php echo $max_due_amount; ?>],maxSize[10]] text-input" type="number" step="0.01" value="<?php echo $max_due_amount; ?>" name="amount">
			</div>
		</div>	
		<div class="form-group">
			<input type="hidden" name="payment_status" value="paid">
			<label class="col-sm-3 control-label" for="payment_method"><?php _e('Payment By','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			 <?php global $current_user;
		        $user_roles = $current_user->roles;
		        $user_role = array_shift($user_roles);?>
				<select name="payment_method" id="payment_method" class="form-control">
				<?php if($user_role != 'parent')
				{?>
					<option value="Cash"><?php _e('Cash','school-mgt');?></option>
					<option value="Cheque"><?php _e('Cheque','school-mgt');?></option>
					<option value="Bank Transfer"><?php _e('Bank Transfer','school-mgt');?></option>
					<?php
				}
				else
				{					
					if(is_plugin_active('paymaster/paymaster.php') && get_option('smgt_paymaster_pack')=="yes")
					{ 
					  $payment_method = get_option('pm_payment_method');
					  print '<option value="'.$payment_method.'">'.$payment_method.'</option>';
					}
					else
					{ ?>
						<option value="Paypal"><?php _e('Paypal','school-mgt');?></option>
					<?php 
					} 
				}
				?>
				</select>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	 <input type="submit" value="<?php _e('Add Payment','school-mgt');?>" name="add_feetype_payment" class="btn btn-success"/>
        </div>
		</form>
	</div>
<?php
	die();
}
function smgt_student_view_paymenthistory()
{ ?>
<script type="text/javascript">
// function PrintElem(elem)
// {
  // Popup($(elem).html());
// }

// function Popup(data) 
// {
// var mywindow = window.open('', 'my div', 'height=500,width=700');
       // mywindow.document.write('<html><head><title></title>');
		// mywindow.document.write("<link rel='stylesheet' href='<?php echo $path;?>' type='text/css' />");

       // mywindow.document.write('</head><body >');
       // mywindow.document.write(data);
       // mywindow.document.write('</body></html>');

       // mywindow.document.close(); // necessary for IE >= 10
       // mywindow.focus(); // necessary for IE >= 10

       // mywindow.print();
       // mywindow.close();

       // return true;
   // }


</script>
<script>
function PrintElem(elem)
{
      Popup($('<div/>').append($(elem).clone()).html());
}
function Popup(data) 
{
    var mywindow = window.open('', 'my div', 'height=500,width=700');
    mywindow.document.write('<html><head><title>Fees Payment Invoice</title>');
    mywindow.document.write('<link rel="stylesheet" href="<?php echo $path;?>" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10
    mywindow.print();
	mywindow.focus();
   // mywindow.close();
    return true;
}
</script>
<?php
	$fees_pay_id = $_REQUEST['idtest'];
	$fees_detail_result = get_single_fees_payment_record($fees_pay_id);
	$fees_history_detail_result = get_payment_history_by_feespayid($fees_pay_id);
?>
<div class="modal-header">				
	<a href="#" class="close-btn-cat badge badge-success pull-right">X</a>
	<h4 class="modal-title"><?php echo get_option('smgt_school_name');?></h4>
</div>	
<div class="modal-body">	
	<div id="invoice_print" class="print-box" width="100%"> 
		<table width="100%" border="0">
			<tbody>
				<tr>
					<td width="70%">
						<img style="max-height:80px;" src="<?php echo get_option( 'smgt_school_logo' ); ?>">
					</td>
					<td align="right" width="24%">
						<h5><?php $issue_date='DD-MM-YYYY';
							$issue_date=$fees_detail_result->paid_by_date;						
							echo __('Issue Date','school-mgt')." : ". smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date)));?></h5><br>						
							<h5><?php echo __('Status','school-mgt')." : "; echo "<span class='btn btn-success btn-xs'>";
							$payment_status = get_payment_status($fees_detail_result->fees_pay_id);					
								if($payment_status=='Paid') 
									echo __('Paid','school-mgt');
								if($payment_status=='Partially Paid')
									echo __('Part Paid','school-mgt');
								if($payment_status=='Unpaid')
									echo __('Unpaid','school-mgt');		
							echo "</span>";?></h5>	
					</td>
				</tr>
			</tbody>
		</table>
		<hr class="hr_margin_new">
		<table width="100%" border="0">
			<tbody>
				<tr>
					<td class="col-md-6">
						<h4><?php _e('Payment From','school-mgt');?> </h4>
					</td>
					<td class="col-md-6 pull-right" style="text-align: right;">
						<h4><?php _e('Bill To','school-mgt');?> </h4>
					</td>
				</tr>
				<tr>
					<td valign="top"class="col-md-6">
						<?php echo get_option( 'smgt_school_name' )."<br>"; 
						 echo get_option( 'smgt_school_address' ).","; 
						 echo get_option( 'smgt_contry' )."<br>"; 
						 echo get_option( 'smgt_contact_number' )."<br>"; 
						?>
						
					</td>
					<td valign="top" class="col-md-6" style="text-align: right;">
						<?php
						$student_id=$fees_detail_result->student_id;						
						$patient=get_userdata($student_id);									
						 echo $patient->display_name."<br>";
						 echo 'Student ID'.' <b>'.get_user_meta( $student_id,'roll_id',true )."</b><br>"; 
						 echo get_user_meta( $student_id,'address',true ).","; 
						 echo get_user_meta( $student_id,'city',true ).","."<BR>"; ; 
						 echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
						 echo get_user_meta( $student_id,'state',true ).","; 
						 echo get_option( 'smgt_contry' ).","; 
						 echo get_user_meta( $student_id,'mobile',true )."<br>"; 						
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<hr class="hr_margin_new">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
				<thead>
					<tr>
						<th class="text-center padding_10">#</th>
						<th class="text-center padding_10"> <?php _e('Fees Type','school-mgt');?></th>
						<th class="padding_10"><?php _e('Total','school-mgt');?> </th>					
					</tr>
				</thead>
				<tbody>
					<td class="text-center">1</td>
					<td class="text-center"><?php echo get_fees_term_name($fees_detail_result->fees_id);?></td>
					<td><?php echo "<span> ". get_currency_symbol()." </span>" . number_format($fees_detail_result->total_amount,2); ?></td>
				</tbody>
			</table>
		</div>
		<table width="100%" border="0">
			<tbody>							
				<tr>
					<td  align="right"><?php _e('Sub Total :','school-mgt');?></td>
					<td align="right"><?php echo get_currency_symbol().number_format($fees_detail_result->total_amount,2); ?></td>
				</tr>
				<tr>
					<td width="80%" align="right"><?php _e('Payment Made :','school-mgt');?></td>
					<td align="right"><?php echo get_currency_symbol().number_format($fees_detail_result->fees_paid_amount,2);?></td>
				</tr>
				<tr>
					<td width="80%" align="right"><?php _e('Due Amount :','school-mgt');?></td>
					<?php $Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount; ?>
					<td align="right"><?php echo get_currency_symbol().number_format($Due_amount,2); ?></td>
				</tr>				
			</tbody>
		</table>
		<hr class="hr_margin_new">
		<?php if(!empty($fees_history_detail_result))
		{ ?>
		<h4><?php _e('Payment History','school-mgt');?></h4>
		<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
			<thead>
				<tr>
					<th class="text-center padding_10"><?php _e('Date','school-mgt');?></th>
					<th class="text-center padding_10"> <?php _e('Amount','school-mgt');?></th>
					<th class="padding_10"><?php _e('Method','school-mgt');?> </th>
					
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach($fees_history_detail_result as  $retrive_date)
				{
				?>
				<tr>
					<td class="text-center"><?php echo smgt_getdate_in_input_box($retrive_date->paid_by_date);?></td>
					<td class="text-center"><?php echo get_currency_symbol() .number_format($retrive_date->amount,2);?></td>
					<td><?php  $data=$retrive_date->payment_method;
						 echo __("$data","school-mgt");
						?>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<?php } ?>
	</div>
	<div class="print-button pull-left">
	  <input type="button" value="<?php _e('Print','school-mgt');?>" class="btn btn-success" onclick="PrintElem('#invoice_print')" />
		<!-- <a  href="#" onclick="PrintElem('.print-box')" target="_blank" class="btn btn-success"><?php _e('Print','school-mgt');?></a> -->
		&nbsp;&nbsp;&nbsp;
		<a href="?page=smgt_fees_payment&print=pdf&payment_id=<?php echo $_POST['idtest'];?>&fee_paymenthistory=<?php echo "fee_paymenthistory";?>" target="_blank"class="btn btn-success"><?php _e('PDF','school-mgt');?></a>
		
	</div>		
</div>
<?php
die();
}
function smgt_student_paymenthistory_pdf($id)
{ 

	$fees_pay_id = $id;
	$fees_detail_result = get_single_fees_payment_record($fees_pay_id);	
	$fees_history_detail_result = get_payment_history_by_feespayid($fees_pay_id);
	?>
	<div class="modal-body">
		<div id="invoice_print" style="width: 90%;margin:0 auto;"> 
		<div class="modal-header">
			<h4 class="modal-title"><?php echo get_option('smgt_school_name');?></h4>
		</div>	
	
		<table width="100%" border="0">
			<tbody>
				<tr>
					<td width="70%">
					
						<img style="max-height:80px;" src="<?php echo get_option( 'smgt_school_logo' ); ?>">
					</td>
					<td align="right" width="24%">
						<h5><?php $issue_date='DD-MM-YYYY';
								$issue_date=$fees_detail_result->paid_by_date;									
								echo __('Issue Date','school-mgt')." : ". smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date)));?></h5><br>
									
						<h5><?php echo __('Status','school-mgt')." : "; 
							echo "<span class='btn btn-success btn-xs'>";
							$payment_status = get_payment_status($fees_detail_result->fees_pay_id);
								if($payment_status=='Paid') 
									echo __('Paid','school-mgt');
								if($payment_status=='Partially Paid')
									echo __('Part Paid','school-mgt');
								if($payment_status=='Unpaid')
									echo __('Unpaid','school-mgt');	
							echo "</span>";?>
						</h5>
					</td>
				</tr>
			</tbody>
		</table>
		<hr>
		<?php
		if (is_rtl())
		{
		?>
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td>
							<h4><?php _e('Payment From','school-mgt');?> </h4>
						</td>
						<td align="left">
							<h4><?php _e('Bill To','school-mgt');?> </h4>
						</td>
					</tr>
					<tr>
						<td valign="top">
							<?php
								echo get_option( 'smgt_school_name' )."<br>"; 
								echo get_option( 'smgt_school_address' ).","; 
								echo get_option( 'smgt_contry' )."<br>"; 
								echo get_option( 'smgt_contact_number' )."<br>"; 
							?>
						</td>
						<td valign="top" align="left">
							<?php
								$student_id=$fees_detail_result->student_id;						
								$patient=get_userdata($student_id);
								 echo 'Student ID'.' <b>'.get_user_meta( $student_id,'roll_id',true )."</b><br>"; 
								echo $patient->display_name."<br>"; 
								echo get_user_meta( $student_id,'address',true ).","; 
								echo get_user_meta( $student_id,'city',true ).","; 
								echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
								echo get_user_meta( $student_id,'state',true ).","; 
								echo get_option( 'smgt_contry' ).","; 
								echo get_user_meta( $student_id,'mobile',true )."<br>"; 
							?>
						</td>
					</tr>
				</tbody>
			</table>
	<?php	
		}
			else{
			?>
			<table width="100%" border="0">
					<tbody>
						<tr>
							<td align="left">
								<h4><?php _e('Payment From','school-mgt');?> </h4>
							</td>
							<td align="right">
								<h4><?php _e('Bill To','school-mgt');?> </h4>
							</td>
						</tr>
						<tr>
							<td valign="top" align="left">
								<?php
									echo get_option( 'smgt_school_name' )."<br>"; 
									echo get_option( 'smgt_school_address' ).","; 
									echo get_option( 'smgt_contry' )."<br>"; 
									echo get_option( 'smgt_contact_number' )."<br>"; 
								?>
							</td>
							<td valign="top" align="right">
								<?php
									$student_id=$fees_detail_result->student_id;						
									$patient=get_userdata($student_id);
									 echo 'Student ID'.' <b>'.get_user_meta( $student_id,'roll_id',true )."</b><br>"; 
									echo $patient->display_name."<br>"; 
									echo get_user_meta( $student_id,'address',true ).","; 
									echo get_user_meta( $student_id,'city',true ).","; 
									echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
									echo get_user_meta( $student_id,'state',true ).","; 
									echo get_option( 'smgt_contry' ).","; 
									echo get_user_meta( $student_id,'mobile',true )."<br>"; 
								?>
							</td>
						</tr>
					</tbody>
				</table>
			<?php
			}
			?>
	<hr>
	<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
		<thead>
			<tr>
				<th class="text-center">#</th>
				<th class="text-center"> <?php _e('Fees Type','school-mgt');?></th>
				<th><?php _e('Total','school-mgt');?> </th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td><?php echo get_fees_term_name($fees_detail_result->fees_id);?></td>
				<td><?php echo "<span> ". get_currency_symbol() ." </span>" .number_format($fees_detail_result->total_amount,2); ?></td>
			</tr>
		</tbody>
	</table>
	<table width="100%" border="0">
		<tbody>
			<tr>
				<td width="80%" align="right"><?php _e( 'Sub Total :','school-mgt' ); ?></td>
				<td align="right"><?php echo "<span> ". get_currency_symbol() ." </span>" .number_format($fees_detail_result->total_amount,2); ?></td>
			</tr>
			<tr>
				<td width="80%" align="right"><?php _e('Payment Made :','school-mgt');?></td>
				<td align="right"><?php echo "<span> ". get_currency_symbol() ." </span>" . number_format($fees_detail_result->fees_paid_amount,2) ;?></td>
			</tr>
			<tr>
				<td width="80%" align="right"><?php _e( 'Due Amount :','school-mgt' ); ?></td>
				<?php $Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount;?>
				<td align="right"><?php echo "<span> ". get_currency_symbol() ." </span>" . number_format($Due_amount,2) ?></td>
			</tr>
		</tbody>
	</table>
	<hr>
	<?php if(!empty($fees_history_detail_result)){ ?>
		<h4><?php _e('Payment History','school-mgt');?></h4>
		<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
			<thead>
				<tr>
					<th class="text-center"><?php _e('Date','school-mgt');?></th>
					<th class="text-center"> <?php _e('Amount','school-mgt');?></th>
					<th><?php _e('Method','school-mgt');?> </th>				
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach($fees_history_detail_result as  $retrive_date)
				{
				?>
				<tr>
					<td><?php echo $retrive_date->paid_by_date;?></td>
					<td><?php echo number_format($retrive_date->amount,2);?></td>
					<td><?php $data_pay=$retrive_date->payment_method;
						echo __("$data_pay","school-mgt"); ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>
	</div>
	
	</div>
	<?php 
	//die();
}
function smgt_student_view_librarryhistory()
{
	?>
	
	<?php $student_id = $_REQUEST['student_id'];
	$booklist = get_student_lib_booklist($student_id);
	$student=get_userdata($student_id);
	?>
	<div class="modal-header">
			<a href="#" class="close-btn-cat badge badge-success pull-right">X</a>
			<h4 class="modal-title"><?php _e('Student Library History','school-mgt');?></h4>
	</div>
	<div class="modal-body">
	<div id="invoice_print"> 
	
		
					<?php if(!empty($booklist))
					{ ?>
					<h4><?php echo $student->display_name; ?></h4>
					<hr>
					<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
					<thead>
							<tr>
								<th class="text-center"><?php _e('Book name','school-mgt');?></th>
								<th class="text-center"> <?php _e('Issue Date','school-mgt');?></th>
								<th class="text-center"> <?php _e('Return Date','school-mgt');?></th>
								<th><?php _e('Period','school-mgt');?> </th>
								<th><?php _e('Overdue By','school-mgt');?> </th>
								<th><?php _e('Fine','school-mgt');?> </th>
								
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach($booklist as  $retrieved_data)
							{
							?>
							<tr>
							<td><?php echo stripslashes(get_bookname($retrieved_data->book_id));?></td>
							<td><?php echo $retrieved_data->issue_date;?></td>
							<td><?php echo $retrieved_data->end_date;?></td>
							<td><?php echo get_the_title($retrieved_data->period).__(" Days","school-mgt");?></td>
							<?php 
							/*$date2=date_create(date("Y-m-d", strtotime($retrieved_data->end_date)));
							$date3=date_create(date("Y-m-d", strtotime($retrieved_data->actual_return_date)));
							$date1=date_create(date("Y-m-d", strtotime($retrieved_data->actual_return_date)));
							$diff=date_diff($date1,$date2);*/
							
							$date1=date_create(date('Y-m-d'));
							$date2=date_create(date("Y-m-d", strtotime($retrieved_data->end_date)));
							$diff=date_diff($date2,$date1);							
							
						?>
							<td><?php 
							if($retrieved_data->actual_return_date=='' && $date1 < $date2)
							{ 
								/* echo __("No Returned","school-mgt"); */
								echo __("0 Days","school-mgt");
							}
							elseif ($date2 > $date3 && $retrieved_data->actual_return_date!='')
							{
								echo __("0 Days","school-mgt"); 
							}
							/* elseif($date3 > $date2) */
							elseif($date1 > $date2)
							{ 
								echo $diff->format("%a").__("0 Days","school-mgt"); 
							}?></td>
							<td><?php echo  ($retrieved_data->fine != "" || $retrieved_data->fine != 0) ? get_currency_symbol().$retrieved_data->fine : "NA";?></td>
							</tr>
							<?php }?>
						</tbody>
					</table>
					<?php }?>
	</div>
	</div>
	<?php
	die();
}
function get_student_lib_booklist($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'smgt_library_book_issue';
	$results=$wpdb->get_results("select *from $table_name where student_id=$id");
	return $results;
}
function smgt_add_remove_feetype()
{
	$model = $_REQUEST['model'];
	$class_id = $_REQUEST['class_id'];
	smgt_add_category_type($model,$class_id);
}
function smgt_add_category_type($model,$class_id) 
{
	$title = "Title here";
	$table_header_title ="Table head";
	$button_text= "Button Text"; 
	$label_text = "Label Text";
	if($model == 'feetype')
	{
		$obj_fees = new Smgt_fees();
		$cat_result = $obj_fees->get_all_feetype();
		$title = __("Fee type",'school-mgt');
		$table_header_title =  __("Fee Type",'school-mgt');
		$button_text=  __("Add Fee Type",'school-mgt');
		$label_text =  __("Fee Type",'school-mgt');
	}
	if($model == 'book_cat')
	{
		$obj_lib = new Smgtlibrary();
		$cat_result = $obj_lib->smgt_get_bookcat();
		$title = __("Category",'school-mgt');
		$table_header_title =  __("Category Name",'school-mgt');
		$button_text=  __("Add Category",'school-mgt');
		$label_text =  __("Category Name",'school-mgt');
	}
	if($model == 'rack_type')
	{
		$obj_lib = new Smgtlibrary();
		$cat_result = $obj_lib->smgt_get_racklist();
		$title = __("Rack Location",'school-mgt');
		$table_header_title =  __("Rack Location Name",'school-mgt');
		$button_text=  __("Add Rack Location",'school-mgt');
		$label_text =  __("Rack Location Name",'school-mgt');
	}
	/* if($model == 'period_type')
	{
		$obj_lib = new Smgtlibrary();
		$cat_result = $obj_lib->smgt_get_periodlist();
		$title = __("Issue Period",'school-mgt');
		$table_header_title =  __("Period Time",'school-mgt');
		$button_text=  __("Add Period Time",'school-mgt');
		$label_text =  __("Period Time",'school-mgt');
	} */
	if($model == 'class_sec')
	{
		//$obj_lib = new Smgtlibrary();
		//$cat_result = $obj_lib->smgt_get_periodlist();
		
		$title = __("Class Section",'school-mgt');
		$table_header_title =  __("Section Name",'school-mgt');
		$button_text=  __("Add Section Name",'school-mgt');
		$label_text =  __("Section Name",'school-mgt');
	}
	?>
	<div class="modal-header"> <a href="#" class="close-btn-cat badge badge-success pull-right">X</a>
  		<h4 id="myLargeModalLabel" class="modal-title"><?php echo $title;?></h4>
	</div>
	<hr>
	<div class="panel panel-white">
  	<div class="category_listbox">
  	<div class="table-responsive">
  	<table class="table">
  		<thead>
  			<tr>
                <!--  <th>#</th> -->
                <th><?php echo $table_header_title;?></th>
                <th><?php _e('Action','school-mgt');?></th>
            </tr>
        </thead>
        <?php 
			
        	$i = 1;
			if($model == 'class_sec'){
				$section_result=smgt_get_class_sections($class_id);
				//var_dump($section_result);
				
				if(!empty($section_result))
				{
					
					foreach ($section_result as $retrieved_data)
					{
					echo '<tr id="cat-'.$retrieved_data->id.'">';
					//echo '<td>'.$i.'</td>';
					echo '<td>'.$retrieved_data->section_name.'</td>';
					echo '<td id='.$retrieved_data->id.'>
					<a class="btn-delete-cat badge badge-delete" model='.$model.' href="#" id='.$retrieved_data->id.'>X</a>
					<a class="btn-edit-cat badge badge-edit" model='.$model.' href="#" id='.$retrieved_data->id.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
					</td>';
					echo '</tr>'; 
					$i++;		
					}
				}
			}
			else
			{
				if(!empty($cat_result))
				{
					
					foreach ($cat_result as $retrieved_data)
					{
					echo '<tr id="cat-'.$retrieved_data->ID.'">';
					//echo '<td>'.$i.'</td>';
					if($model == 'period_type')
						echo '<td>'.$retrieved_data->post_title.' '.__("Days","school-mgt") .'</td>';
					else
						echo '<td>'.$retrieved_data->post_title.'</td>';
					echo '<td id='.$retrieved_data->ID.'><a class="btn-delete-cat badge badge-delete" model='.$model.' href="#" id='.$retrieved_data->ID.'>X</a></td>';
					echo '</tr>';
					$i++;		
					}
				}
			}
        ?>
  	</table>
  	</div>
  	</div>
  	 <form name="fee_form" action="" method="post" class="form-horizontal" id="fee_form">
  	 	<div class="form-group" style="margin-top: 10px;">
			<label class="col-sm-4 control-label" for="fee_type"><?php echo $label_text;?><span class="require-field">*</span></label>
			<div class="col-sm-4">
				<?php 
				if($model == 'period_type')
				{
				?>					
					<input id="txtfee_type" class="form-control text-input validate[required]" maxlength="3" type="number" value=""  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="txtfee_type" placeholder="<?php _e('Must Be Enter Number of Days','school-mgt');?>">
				<?php
				}
				else
				{
				?>
					<input id="txtfee_type" class="form-control text-input validate[required,custom[popup_category_validation]]"  maxlength="50" type="text" 
					value="" name="txtfee_type">
				<?php	
				}
				?>				
			</div>
			<div class="col-sm-4" style="margin-bottom: 10px;">
				<input type="button" <?php if($model == 'class_sec'){?> class_id=<?php echo $class_id; }?> value="<?php echo $button_text;?>" name="save_category" class="btn btn_top btn-success" model="<?php echo $model;?>" id="btn-add-cat"/>
			</div>
		</div>
		</form>
  	</div>
	<?php 
	die();
}
function smgt_add_fee_type()
{
	global $wpdb;
	$model = $_REQUEST['model'];
	$class_id = $_REQUEST['class_id'];
	$array_var = array();
	$data['category_name'] = smgt_strip_tags_and_stripslashes($_REQUEST['fee_type']);
	if($model == 'feetype')
	{
		$obj_fees = new Smgt_fees();
		$obj_fees->smgt_add_feetype($data);
		$id = $wpdb->insert_id;
		$row1 = '<tr id="cat-'.$id.'"><td>'.stripslashes($_REQUEST['fee_type']).'</td><td><a class="btn-delete-cat badge badge-delete" href="#" id='.$id.'>X</a></td></tr>';
		$option = "<option value='$id'>".stripslashes($_REQUEST['fee_type'])."</option>";
	}
	if($model=='book_cat')
	{
		$obj_lib = new Smgtlibrary();
		$cat_result = $obj_lib->smgt_add_bookcat($data);
		$id = $wpdb->insert_id;
		$row1 = '<tr id="cat-'.$id.'"><td>'.stripslashes($_REQUEST['fee_type']).'</td><td><a class="btn-delete-cat badge badge-delete" href="#" id='.$id.'>X</a></td></tr>';
		$option = "<option value='$id'>".stripslashes($_REQUEST['fee_type'])."</option>";
	}
	if($model=='rack_type')
	{
		$obj_lib = new Smgtlibrary();
		$cat_result = $obj_lib->smgt_add_rack($data);
		$id = $wpdb->insert_id;
		$row1 = '<tr id="cat-'.$id.'"><td>'.stripslashes($_REQUEST['fee_type']).'</td><td><a class="btn-delete-cat badge badge-delete" href="#" id='.$id.'>X</a></td></tr>';
		$option = "<option value='$id'>".stripslashes($_REQUEST['fee_type'])."</option>";
	}
	if($model=='period_type')
	{
		$obj_lib = new Smgtlibrary();
		$cat_result = $obj_lib->smgt_add_period($data);
		$id = $wpdb->insert_id;
		$row1 = '<tr id="cat-'.$id.'"><td>'.stripslashes($_REQUEST['fee_type']).' '.__('Days','school-mgt').'</td><td><a class="btn-delete-cat badge badge-delete" href="#" id='.$id.'>X</a></td></tr>';
		$option = "<option value='$id'>".stripslashes($_REQUEST['fee_type'])." ".__('Days','school-mgt')."</option>";
	}
	if($model=='class_sec')
	{
		$tablename="smgt_class_section";
		
		$sectiondata['class_id']=$_REQUEST['class_id'];
		$sectiondata['section_name']=stripslashes($_REQUEST['fee_type']);
		
		$result=add_class_section($tablename,$sectiondata);
		$id = $wpdb->insert_id;
		$row1 = '<tr id="cat-'.$id.'"><td>'.stripslashes($_REQUEST['fee_type']).'</td>
		<td>
		<a class="btn-delete-cat badge badge-delete" href="#" id="'.$id.'">X</a>
		<a class="btn-edit-cat badge badge-edit" model="section" href="#" id="'.$id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
		</td></tr>';
		$option = "<option value='$id'>".stripslashes($_REQUEST['fee_type'])."</option>";
	}
	$array_var[] = $row1;
	$array_var[] = $option;
	echo json_encode($array_var);
	die();
}
function smgt_remove_feetype()
{
	
	$model = $_REQUEST['model'];
	if($model == 'feetype')
	{
		$obj_fees = new Smgt_fees();
		$obj_fees->delete_fee_type($_POST['cat_id']);
		die();
	}
	if($model == 'book_cat')
	{
		$obj_lib = new Smgtlibrary();
		$obj_lib->delete_cat_type($_POST['cat_id']);
		die();
	}
	if($model == 'rack_type')
	{
		$obj_lib = new Smgtlibrary();
		$obj_lib->delete_rack_type($_POST['cat_id']);
		die();
	}
	if($model == 'period_type')
	{
		$obj_lib = new Smgtlibrary();
		$obj_lib->delete_period($_POST['cat_id']);
		die();
	}
	if($model == 'class_sec')
	{
		$result=delete_class_section($_POST['cat_id']);
		die();
	}
}
function smgt_single_section($section_id)
{
	global $wpdb;
	$smgt_class_section = $wpdb->prefix. 'smgt_class_section';
	$result = $wpdb->get_row('Select * from '.$smgt_class_section.' where id = '.$section_id);
	
	return $result;
}
function smgt_update_section()
{
	global $wpdb;
	$smgt_class_section = $wpdb->prefix. 'smgt_class_section';
	$data['section_name']=$_POST['section_name'];
	$data_id['id']=$_POST['cat_id'];	
	$result=$wpdb->update( $smgt_class_section, $data ,$data_id);
	$retrieved_data = smgt_single_section($_POST['cat_id']);
		echo '<td>'.$retrieved_data->section_name.'</td>';
					echo '<td id='.$retrieved_data->id.'>
					<a class="btn-delete-cat badge badge-delete" model='.$model.' href="#" id='.$retrieved_data->id.'>X</a>
					<a class="btn-edit-cat badge badge-edit" model='.$model.' href="#" id='.$retrieved_data->id.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
					</td>';
	die();
}
function smgt_update_cancel_section()
{
	global $wpdb;
	$smgt_class_section = $wpdb->prefix. 'smgt_class_section';	
	$retrieved_data = smgt_single_section($_POST['cat_id']);
		echo '<td>'.$retrieved_data->section_name.'</td>';
					echo '<td id='.$retrieved_data->id.'>
					<a class="btn-delete-cat badge badge-delete" model='.$model.' href="#" id='.$retrieved_data->id.'>X</a>
					<a class="btn-edit-cat badge badge-edit" model='.$model.' href="#" id='.$retrieved_data->id.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
					</td>';
	die();
}
function smgt_edit_section()
{
	
	$model = $_REQUEST['model'];
	$cat_id = $_REQUEST['cat_id'];
	$retrieved_data = smgt_single_section($cat_id);
	//echo '<td>'.$i.'</td>';
					echo '<td><input type="text" class="validate[required,custom[popup_category_validation]]" name="section_name" maxlength="50" value="'.$retrieved_data->section_name.'" id="section_name"></td>';
					echo '<td id='.$retrieved_data->id.'>
					<a class="btn-cat-update-cancel btn btn-danger" model='.$model.' href="#" id='.$retrieved_data->id.'>'.__('Cancel','school-mgt').'</a>
					<a class="btn-cat-update btn btn-primary" model='.$model.' href="#" id='.$retrieved_data->id.'>'.__('Save','school-mgt').'</a>
					</td>';
	die();
}
function smgt_student_invoice_print($invoice_id)
{
	$obj_invoice= new Smgtinvoice();
	if($_REQUEST['invoice_type']=='invoice')
	{
		$invoice_data=get_payment_by_id($invoice_id);
	}
	if($_REQUEST['invoice_type']=='income'){
		$income_data=$obj_invoice->smgt_get_income_data($invoice_id);
	}
	if($_REQUEST['invoice_type']=='expense'){
		$expense_data=$obj_invoice->smgt_get_income_data($invoice_id);
	}
	
	?>
		<html moznomarginboxes mozdisallowselectionprint>
		<?php
		if (is_rtl()){
			?>
		<div class="modal-body" style="direction: rtl;">
			<div id="invoice_print" style="width: 90%;margin:0 auto;"> 
			<div class="modal-header">
				
				<h4 class="modal-title"><?php echo get_option('smgt_school_name');?></h4>
			</div>
				<table width="100%" border="0">
							<tbody>
								<tr>
									<td width="70%">
										<img style="max-height:80px;" src="<?php echo get_option( 'smgt_school_logo' ); ?>">
									</td>
									<td align="right" width="24%">
										<h4><?php
										if(!empty($invoice_data)){
											//$invoice_no=$invoice_data->invoice_number;
											//_e('Invoice number','school-mgt');
											//echo " : ".$invoice_no;
											}
										?> </h4>
										<h5><?php $issue_date='DD-MM-YYYY';
													if(!empty($income_data)){
														$issue_date=$income_data->income_create_date;
														$payment_status=$income_data->payment_status;}
													if(!empty($invoice_data)){
														$issue_date=$invoice_data->date;
														$payment_status=$invoice_data->payment_status;	}
													if(!empty($expense_data)){
														$issue_date=$expense_data->income_create_date;
														$payment_status=$expense_data->payment_status;}
										
										echo __('Issue Date','school-mgt')." : ".smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date)));?></h5>
										<h5><?php if($payment_status=='Paid') 
											echo __('Status','school-mgt')." : ".__('Paid','school-mgt');
										elseif($payment_status=='Part Paid')
											echo __('Status','school-mgt')." : ".__('Part Paid','school-mgt');
										else
											echo __('Status','school-mgt')." : ".__('Unpaid','school-mgt');	?></h5>
									</td>
								</tr>
							</tbody>
						</table>
						<hr>
						<table width="100%" border="0">
							<tbody>
								<tr>
									<td>
										<h4><?php _e('Payment From','school-mgt');?> </h4>
									</td>
									<td align="left">
										<h4><?php _e('Bill To','school-mgt');?> </h4>
									</td>
								</tr>
								<tr>
									<td valign="top">
										<?php echo get_option( 'smgt_school_name' )."<br>"; 
										 echo get_option( 'smgt_school_address' ).","; 
										 echo get_option( 'smgt_contry' )."<br>"; 
										 echo get_option( 'smgt_contact_number' )."<br>"; 
										?>
										
									</td>
									<td valign="top" align="left">
										<?php 
										if(!empty($expense_data))
										{
											echo $party_name=$expense_data->supplier_name; 
										}
										else
										{
											if(!empty($income_data))
												$student_id=$income_data->supplier_name;
											 if(!empty($invoice_data))
												$student_id=$invoice_data->student_id;
											
											
											
											$patient=get_userdata($student_id);
											 echo $patient->display_name."<br>";
											 echo 'Student ID'.' <b>'.get_user_meta( $student_id,'roll_id',true )."</b><br>"; 
											 echo get_user_meta( $student_id,'address',true ).","; 
											 echo get_user_meta( $student_id,'city',true ).","."<BR>"; ; 
											 echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
											 echo get_user_meta( $student_id,'state',true ).","; 
											 echo get_option( 'smgt_contry' ).","; 
											 echo get_user_meta( $student_id,'mobile',true )."<br>";
										}
										?>
									</td>
								</tr>
							</tbody>
						</table>
						<hr>
						<h4><?php _e('Invoice Entries222','school-mgt');?></h4>
						<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center"> <?php _e('Date','school-mgt');?></th>
									<th width="60%"><?php _e('Entry','school-mgt');?> </th>
									<th><?php _e('Price','school-mgt');?></th>
									<th class="text-center"> <?php _e('Username','school-mgt');?> </th>
								</tr>
							</thead>
							<tbody>
							<?php 
								$id=1;
								$total_amount=0;
							if(!empty($income_data) || !empty($expense_data)){
								if(!empty($expense_data))
									$income_data=$expense_data;
								
								$patient_all_income=$obj_invoice->get_onepatient_income_data($income_data->supplier_name);
								foreach($patient_all_income as $result_income){
									$income_entries=json_decode($result_income->entry);
									foreach($income_entries as $each_entry){
									$total_amount+=$each_entry->amount;
									
							?>
								<tr>
									<td class="text-center"><?php echo $id;?></td>
									<td class="text-center"><?php echo $result_income->income_create_date;?></td>
									<td><?php echo $each_entry->entry; ?> </td>
									<td class="text-right"> <?php echo "<span> ". get_currency_symbol() ."</span>" .number_format($each_entry->amount,2); ?></td>
									<td class="text-center"><?php echo get_display_name($result_income->create_by);?></td>
								</tr>
									<?php $id+=1;}
									}
							 
							}
							 if(!empty($invoice_data)){
								 $total_amount=$invoice_data->amount
								 ?>
								<tr>
									<td class="text-center"><?php echo $id;?></td>
									<td class="text-center"><?php echo date("Y-m-d", strtotime($invoice_data->date));?></td>
									<td><?php echo $invoice_data->payment_title; ?> </td>
									<td class="text-right"> <?php echo "<span> ". get_currency_symbol() ." </span>" .number_format($invoice_data->amount,2); ?></td>
									<td class="text-center"><?php echo get_display_name($invoice_data->payment_reciever_id);?></td>
								</tr>
								<?php }?>
							</tbody>
						</table>
						<table width="100%" border="0">
							<tbody>
								
								<?php if(!empty($invoice_data)){								
									$grand_total= $invoice_data->amount;
									?>
								
								<?php
								}
								if(!empty($income_data)){
									$grand_total=$total_amount;
								}
								?>								
								<tr>
									<td width="80%" align="right">&nbsp;</td>
									<td align="right"><h4><?php _e('Grand Total :','school-mgt');?><?php echo "<span>". get_currency_symbol() ."</span>" .number_format($grand_total,2); ?></h4></td>
								</tr>
							</tbody>
						</table>
			</div>
		</div>
		<?php
		}
		else {
			?>
			<div class="modal-body">
			<div id="invoice_print" style="width: 90%;margin:0 auto;"> 
			<div class="modal-header">
				
				<h4 class="modal-title"><?php echo get_option('smgt_school_name');?></h4>
			</div>
				<table width="100%" border="0">
							<tbody>
								<tr>
									<td width="70%">
										<img style="max-height:80px;" src="<?php echo get_option( 'smgt_school_logo' ); ?>">
									</td>
									<td align="right" width="24%">
										<h4><?php
										if(!empty($invoice_data)){
											//$invoice_no=$invoice_data->invoice_number;
											//_e('Invoice number','school-mgt');
											//echo " : ".$invoice_no;
											}
										?> </h4>
										<h5><?php $issue_date='DD-MM-YYYY';
													if(!empty($income_data)){
														$issue_date=$income_data->income_create_date;
														$payment_status=$income_data->payment_status;}
													if(!empty($invoice_data)){
														$issue_date=$invoice_data->date;
														$payment_status=$invoice_data->payment_status;	}
													if(!empty($expense_data)){
														$issue_date=$expense_data->income_create_date;
														$payment_status=$expense_data->payment_status;}
										
										echo __('Issue Date','school-mgt')." : ".smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date)));?></h5>
										<h5><?php if($payment_status=='Paid') 
											echo __('Status','school-mgt')." : ".__('Paid','school-mgt');
										elseif($payment_status=='Part Paid')
											echo __('Status','school-mgt')." : ".__('Part Paid','school-mgt');
										else
											echo __('Status','school-mgt')." : ".__('Unpaid','school-mgt');	?></h5>
									</td>
								</tr>
							</tbody>
						</table>
						<hr>
						<table width="100%" border="0">
							<tbody>
								<tr>
									<td align="left">
										<h4><?php _e('Payment From','school-mgt');?> </h4>
									</td>
									<td align="right">
										<h4><?php _e('Bill To','school-mgt');?> </h4>
									</td>
								</tr>
								<tr>
									<td valign="top" align="left">
										<?php echo get_option( 'smgt_school_name' )."<br>"; 
										 echo get_option( 'smgt_school_address' ).","; 
										 echo get_option( 'smgt_contry' )."<br>"; 
										 echo get_option( 'smgt_contact_number' )."<br>"; 
										?>
										
									</td>
									<td valign="top" align="right">
										<?php 
										if(!empty($expense_data))
										{
											echo $party_name=$expense_data->supplier_name; 
										}
										else
										{
											if(!empty($income_data))
												$student_id=$income_data->supplier_name;
											 if(!empty($invoice_data))
												$student_id=$invoice_data->student_id;
											
											
											
											$patient=get_userdata($student_id);
											 echo $patient->display_name."<br>";
											 echo 'Student ID'.' <b>'.get_user_meta( $student_id,'roll_id',true )."</b><br>"; 
											 echo get_user_meta( $student_id,'address',true ).","; 
											 echo get_user_meta( $student_id,'city',true ).","."<BR>"; ; 
											 echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
											 echo get_user_meta( $student_id,'state',true ).","; 
											 echo get_option( 'smgt_contry' ).","; 
											 echo get_user_meta( $student_id,'mobile',true )."<br>";
										}
										?>
									</td>
								</tr>
							</tbody>
						</table>
						<hr>
						<h4><?php _e('Invoice Entries222','school-mgt');?></h4>
						<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center"> <?php _e('Date','school-mgt');?></th>
									<th width="60%"><?php _e('Entry','school-mgt');?> </th>
									<th><?php _e('Price','school-mgt');?></th>
									<th class="text-center"> <?php _e('Username','school-mgt');?> </th>
								</tr>
							</thead>
							<tbody>
							<?php 
								$id=1;
								$total_amount=0;
							if(!empty($income_data) || !empty($expense_data)){
								if(!empty($expense_data))
									$income_data=$expense_data;
								
								$patient_all_income=$obj_invoice->get_onepatient_income_data($income_data->supplier_name);
								foreach($patient_all_income as $result_income){
									$income_entries=json_decode($result_income->entry);
									foreach($income_entries as $each_entry){
									$total_amount+=$each_entry->amount;
									
							?>
								<tr>
									<td class="text-center"><?php echo $id;?></td>
									<td class="text-center"><?php echo $result_income->income_create_date;?></td>
									<td><?php echo $each_entry->entry; ?> </td>
									<td class="text-right"> <?php echo "<span> ". get_currency_symbol() ."</span>" .number_format($each_entry->amount,2); ?></td>
									<td class="text-center"><?php echo get_display_name($result_income->create_by);?></td>
								</tr>
									<?php $id+=1;}
									}
							 
							}
							 if(!empty($invoice_data)){
								 $total_amount=$invoice_data->amount
								 ?>
								<tr>
									<td class="text-center"><?php echo $id;?></td>
									<td class="text-center"><?php echo date("Y-m-d", strtotime($invoice_data->date));?></td>
									<td><?php echo $invoice_data->payment_title; ?> </td>
									<td class="text-right"> <?php echo "<span> ". get_currency_symbol() ." </span>" .number_format($invoice_data->amount,2); ?></td>
									<td class="text-center"><?php echo get_display_name($invoice_data->payment_reciever_id);?></td>
								</tr>
								<?php }?>
							</tbody>
						</table>
						<table width="100%" border="0">
							<tbody>
								
								<?php if(!empty($invoice_data)){								
									$grand_total= $invoice_data->amount;
									?>
								
								<?php
								}
								if(!empty($income_data)){
									$grand_total=$total_amount;
								}
								?>								
								<tr>
									<td width="80%" align="right">&nbsp;</td>
									<td align="right"><h4><?php _e('Grand Total :','school-mgt');?><?php echo "<span>". get_currency_symbol() ."</span>" .number_format($grand_total,2); ?></h4></td>
								</tr>
							</tbody>
						</table>
			</div>
		</div>
			<?php	
		}
}
function smgt_student_invoice_pdf($invoice_id)
{
	$obj_invoice= new Smgtinvoice();
	if($_REQUEST['invoice_type']=='invoice')
	{
		$invoice_data=get_payment_by_id($invoice_id);
	}
	if($_REQUEST['invoice_type']=='income'){
		$income_data=$obj_invoice->smgt_get_income_data($invoice_id);
	}
	if($_REQUEST['invoice_type']=='expense'){
		$expense_data=$obj_invoice->smgt_get_income_data($invoice_id);
	}
	
	?>
		
		<div class="modal-body">
			<div id="invoice_print" style="width: 90%;margin:0 auto;"> 
			<div class="modal-header">				
				<h4 class="modal-title"><?php echo get_option('smgt_school_name');?></h4>
			</div>
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td width="70%">
							<img style="max-height:80px;" src="<?php echo get_option( 'smgt_school_logo' ); ?>">
						</td>
						<td align="right" width="24%">
						<h5><?php $issue_date='DD-MM-YYYY';
							if(!empty($income_data)){
								$issue_date=$income_data->income_create_date;
								$payment_status=$income_data->payment_status;}
								if(!empty($invoice_data)){
									$issue_date=$invoice_data->date;
									$payment_status=$invoice_data->payment_status;	}
									if(!empty($expense_data)){
										$issue_date=$expense_data->income_create_date;
										$payment_status=$expense_data->payment_status;
									}
										
									echo __('Issue Date','school-mgt').":".smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date)));?></h5><br>
									<h5><?php if($payment_status=='Paid') 
										echo __('Status','school-mgt')." : ".__('Paid','school-mgt');
									elseif($payment_status=='Part Paid')
										echo __('Status','school-mgt')." : ".__('Part Paid','school-mgt');
									else
										echo __('Status','school-mgt')." : ".__('Unpaid','school-mgt');	?></h5>
						</td>
					</tr>
				</tbody>
			</table>
			<hr>
			<?php
			if (is_rtl()){
			?>
				<table width="100%" border="0">
				<tbody>
					<tr>
						<td>
							<h4><?php _e('Payment From','school-mgt');?> </h4>
						</td>
						<td align="left">
							<h4><?php _e('Bill To','school-mgt');?> </h4>
						</td>
					</tr>
					<tr>
						<td valign="top">
							<?php echo get_option( 'smgt_school_name' )."<br>"; 
								echo get_option( 'smgt_school_address' ).","; 
								echo get_option( 'smgt_contry' )."<br>"; 
								echo get_option( 'smgt_contact_number' )."<br>"; 
							?>
						</td>
						<td valign="top" align="left">
							<?php 
								if(!empty($expense_data)){
									echo $party_name=$expense_data->supplier_name; 
								}
								else
								{
									if(!empty($income_data))
										$student_id=$income_data->supplier_name;
									 if(!empty($invoice_data))
										$student_id=$invoice_data->student_id;											
										$patient=get_userdata($student_id);
													
										echo $patient->display_name."<br>"; 
										echo 'Student ID'.' <b>'.get_user_meta( $student_id,'roll_id',true )."</b><br>"; 
										echo get_user_meta( $student_id,'address',true ).","; 
										echo get_user_meta( $student_id,'city',true ).","."<BR>"; ; 
										echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
										echo get_user_meta( $student_id,'state',true ).","; 
										echo get_option( 'smgt_contry' ).","; 
										echo get_user_meta( $student_id,'mobile',true )."<br>"; 
								}
							?>
							</td>
						</tr>
					</tbody>
				</table>
			<?php	
			}
			else{
			?>
			
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td align="left">
							<h4><?php _e('Payment From','school-mgt');?> </h4>
						</td>
						<td align="right">
							<h4><?php _e('Bill To','school-mgt');?> </h4>
						</td>
					</tr>
					<tr>
						<td valign="top" align="left">
							<?php echo get_option( 'smgt_school_name' )."<br>"; 
								echo get_option( 'smgt_school_address' ).","; 
								echo get_option( 'smgt_contry' )."<br>"; 
								echo get_option( 'smgt_contact_number' )."<br>"; 
							?>
						</td>
						<td valign="top" align="right">
							<?php 
								if(!empty($expense_data)){
									echo $party_name=$expense_data->supplier_name; 
								}
								else
								{
									if(!empty($income_data))
										$student_id=$income_data->supplier_name;
									 if(!empty($invoice_data))
										$student_id=$invoice_data->student_id;											
										$patient=get_userdata($student_id);
													
										echo $patient->display_name."<br>"; 
										echo 'Student ID'.' <b>'.get_user_meta( $student_id,'roll_id',true )."</b><br>"; 
										echo get_user_meta( $student_id,'address',true ).","; 
										echo get_user_meta( $student_id,'city',true ).","."<BR>"; ; 
										echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
										echo get_user_meta( $student_id,'state',true ).","; 
										echo get_option( 'smgt_contry' ).","; 
										echo get_user_meta( $student_id,'mobile',true )."<br>"; 
								}
							?>
						</td>
					</tr>
				</tbody>
			</table>
			<?php
			}
			?>
			<hr>
						<h4><?php _e('Invoice Entries','school-mgt');?></h4>
						<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center"> <?php _e('Date','school-mgt');?></th>
									<th width="60%"><?php _e('Entry','school-mgt');?> </th>
									<th><?php _e('Price','school-mgt');?></th>
									<th class="text-center"> <?php _e('Username','school-mgt');?> </th>
								</tr>
							</thead>
							<tbody>
							<?php 
								$id=1;
								$total_amount=0;
							if(!empty($income_data) || !empty($expense_data)){
								if(!empty($expense_data))
									$income_data=$expense_data;
								
								$patient_all_income=$obj_invoice->get_onepatient_income_data($income_data->supplier_name);
								foreach($patient_all_income as $result_income){
									$income_entries=json_decode($result_income->entry);
									foreach($income_entries as $each_entry){
									$total_amount+=$each_entry->amount;
									
							?>
								<tr>
									<td class="text-center"><?php echo $id;?></td>
									<td class="text-center"><?php echo $result_income->income_create_date;?></td>
									<td><?php echo $each_entry->entry; ?> </td>
									<td class="text-right"> <?php echo "<span>". get_currency_symbol() ."</span>" .number_format($each_entry->amount,2); ?></td>
									<td class="text-center"><?php echo get_display_name($result_income->create_by);?></td>
								</tr>
									<?php $id+=1;}
									}
							 
							}
							 if(!empty($invoice_data)){
								 $total_amount=$invoice_data->amount
								 ?>
								<tr>
									<td class="text-center"><?php echo $id;?></td>
									<td class="text-center"><?php echo date("Y-m-d", strtotime($invoice_data->date));?></td>
									<td><?php echo $invoice_data->payment_title; ?> </td>
									<td class="text-right"> <?php echo "<span> ". get_currency_symbol() ."</span>" .number_format($invoice_data->amount,2); ?></td>
									<td class="text-center"><?php echo get_display_name($invoice_data->payment_reciever_id);?></td>
								</tr>
								<?php }?>
							</tbody>
						</table>
						<table width="100%" border="0">
							<tbody>
								
								<?php if(!empty($invoice_data)){								
									$grand_total= $invoice_data->amount;
									?>
								
								<?php
								}
								if(!empty($income_data)){
									$grand_total=$total_amount;
								}
								?>								
								<tr>
									<td width="60%" align="right">&nbsp;</td>
									<td align="right"><h4><?php _e('Grand Total :','school-mgt');?>  <?php echo "<span>". get_currency_symbol() ."</span>" .number_format($grand_total,2); ?></h4></td>
								</tr>
							</tbody>
						</table>
			</div>
		</div>
	
	<?php 
}
function smgt_print_invoice()
{
	if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'print' && $_REQUEST['page'] == 'smgt_payment')
	{
		?>
<script>window.onload = function(){ window.print(); };</script>
<?php 
				smgt_student_invoice_print($_REQUEST['invoice_id']);
				exit;
	}			
}
add_action('init','smgt_print_invoice');

function install_tables()
{
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	global $wpdb;
	 
	$table_attendence = $wpdb->prefix . 'attendence';//register attendence table
	
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_attendence." (
			  `attendence_id` int(50) NOT NULL AUTO_INCREMENT,
			  `user_id` int(50) NOT NULL,
			  `class_id` int(50) NOT NULL,
			  `attend_by` int(11) NOT NULL,
			  `attendence_date` date NOT NULL,
			  `status` varchar(50) NOT NULL,
			  `role_name` varchar(20) NOT NULL,
			  `comment` text NOT NULL,
			  PRIMARY KEY (`attendence_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
		
		
		$table_exam = $wpdb->prefix . 'exam';//register exam table
		
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_exam." (
		  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
		  `exam_name` varchar(200) NOT NULL,
		  `exam_start_date` date NOT NULL,
		  `exam_end_date` date NOT NULL,
		  `exam_comment` text NOT NULL,
		  `created_date` datetime NOT NULL,
		  `modified_date` datetime NOT NULL,
		  `exam_creater_id` int(11) NOT NULL,
		  PRIMARY KEY (`exam_id`)
		)DEFAULT CHARSET=utf8";
	dbDelta($sql);
		
		$table_grade = $wpdb->prefix . 'grade';//register grade table
		
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_grade." (
			  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
			  `grade_name` varchar(20) NOT NULL,
			  `grade_point` float NOT NULL,
			  `mark_from` tinyint(3) NOT NULL,
			  `mark_upto` tinyint(3) NOT NULL,
			  `grade_comment` text NOT NULL,
			  `created_date` datetime NOT NULL,
			  `creater_id` int(11) NOT NULL,
			  PRIMARY KEY (`grade_id`)
			)DEFAULT CHARSET=utf8";
	dbDelta($sql);
	
	
		$table_hall = $wpdb->prefix . 'hall';//register hall table
		
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_hall." (
			  `hall_id` int(11) NOT NULL AUTO_INCREMENT,
			  `hall_name` varchar(200) NOT NULL,
			  `number_of_hall` int(11) NOT NULL,
			  `hall_capacity` int(11) NOT NULL,
			  `description` text NOT NULL,
			  `date` datetime NOT NULL,
			  PRIMARY KEY (`hall_id`)
			)DEFAULT CHARSET=utf8";
				dbDelta($sql);
				
	$table_holiday = $wpdb->prefix . 'holiday';//register holiday table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_holiday." (
			  `holiday_id` int(11) NOT NULL AUTO_INCREMENT,
			  `holiday_title` varchar(200) NOT NULL,
			  `description` text NOT NULL,
			  `date` date NOT NULL,
			  `end_date` date NOT NULL,
			  `created_by` int(11) NOT NULL,
			  PRIMARY KEY (`holiday_id`)
			) DEFAULT CHARSET=utf8 ";
		dbDelta($sql);	
			
		$table_marks = $wpdb->prefix . 'marks';//register marks table
		
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_marks." (
			  `mark_id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `exam_id` int(11) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `subject_id` int(11) NOT NULL,
			  `marks` tinyint(3) NOT NULL,
			  `attendance` tinyint(4) NOT NULL,
			  `grade_id` int(11) NOT NULL,
			  `student_id` int(11) NOT NULL,
			  `marks_comment` text NOT NULL,
			  `created_date` datetime NOT NULL,
			  `modified_date` datetime NOT NULL,
			  `created_by` int(11) NOT NULL,
			  PRIMARY KEY (`mark_id`)
			) DEFAULT CHARSET=utf8 ";
		dbDelta($sql);	
		
	$table_smgt_class = $wpdb->prefix . 'smgt_class';//register smgt_class table		
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_class." (
			  `class_id` int(11) NOT NULL AUTO_INCREMENT,
			  `class_name` varchar(100) NOT NULL,
			  `class_num_name` varchar(5) NOT NULL,
			  `class_section` varchar(50) NOT NULL,
			  `class_capacity` tinyint(4) NOT NULL,
			  `creater_id` int(11) NOT NULL,
			  `created_date` datetime NOT NULL,
			  `modified_date` datetime NOT NULL,
			  PRIMARY KEY (`class_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);	
		
	$table_smgt_fees = $wpdb->prefix . 'smgt_fees';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_fees." (			  
			  `fees_id` int(11) NOT NULL AUTO_INCREMENT,
			  `fees_title_id` bigint(20) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `fees_amount` float NOT NULL,
			  `description` text NOT NULL,
			  `created_date` datetime NOT NULL,
			  `created_by` int(11) NOT NULL,
			  PRIMARY KEY (`fees_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
			
	$table_smgt_fees_payment = $wpdb->prefix . 'smgt_fees_payment';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_fees_payment." (			  
			  `fees_pay_id` int(11) NOT NULL AUTO_INCREMENT,
			  `class_id` int(11) NOT NULL,
			  `student_id` bigint(20) NOT NULL,
			  `fees_id` int(11) NOT NULL,
			  `total_amount` float NOT NULL,
			  `fees_paid_amount` float NOT NULL,
			  `payment_status` tinyint(4) NOT NULL,
			  `description` text NOT NULL,
			  `start_year` varchar(20) NOT NULL,
			  `end_year` varchar(20) NOT NULL,
			  `paid_by_date` date NOT NULL,
			  `created_date` datetime NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  PRIMARY KEY (`fees_pay_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
	
	$table_smgt_fee_payment_history = $wpdb->prefix . 'smgt_fee_payment_history';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_fee_payment_history." (			  
			  `payment_history_id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `fees_pay_id` int(11) NOT NULL,
			  `amount` float NOT NULL,
			  `payment_method` varchar(50) NOT NULL,
			  `paid_by_date` date NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  `trasaction_id` varchar(50) NOT NULL,
			  PRIMARY KEY (`payment_history_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
		
	$table_message = $wpdb->prefix . 'smgt_message';//register smgt_message table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_message." (
				  `message_id` int(11) NOT NULL AUTO_INCREMENT,
				  `sender` int(11) NOT NULL,
				  `receiver` int(11) NOT NULL,
				  `date` datetime NOT NULL,
				  `subject` varchar(150) NOT NULL,
				  `message_body` text NOT NULL,
				  `status` int(11) NOT NULL,
				  `post_id` int(11) NOT NULL,
				  PRIMARY KEY (`message_id`)
				)DEFAULT CHARSET=utf8";
		dbDelta($sql);	
		
	$table_smgt_payment = $wpdb->prefix . 'smgt_payment';//register smgt_payment table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_payment." (
			  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
			  `student_id` int(11) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `payment_title` varchar(100) NOT NULL,
			  `description` text NOT NULL,
			  `amount` int(11) NOT NULL,
			  `payment_status` varchar(10) NOT NULL,
			  `date` datetime NOT NULL,
			  `payment_reciever_id` int(11) NOT NULL,
			  PRIMARY KEY (`payment_id`)
			) DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 
			";
		dbDelta($sql);	
		
	$table_smgt_time_table = $wpdb->prefix . 'smgt_time_table';//register smgt_time_table table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_time_table." (
			  `route_id` int(11) NOT NULL AUTO_INCREMENT,
			  `subject_id` int(11) NOT NULL,
			  `teacher_id` int(11) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `start_time` varchar(10) NOT NULL,
			  `end_time` varchar(10) NOT NULL,
			  `weekday` tinyint(4) NOT NULL,
			  PRIMARY KEY (`route_id`)
			)DEFAULT CHARSET=utf8";
		dbDelta($sql);	
		
		
	$table_subject = $wpdb->prefix . 'subject';//register subject table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_subject." (
			  `subid` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `sub_name` varchar(255) NOT NULL,
			  `teacher_id` int(11) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `author_name` varchar(255) NOT NULL,
			  `edition` varchar(255) NOT NULL,
			  `syllabus` varchar(255) DEFAULT NULL,
			  `created_by` int(11) NOT NULL,
			  PRIMARY KEY (`subid`)
			)  DEFAULT CHARSET=utf8";
		dbDelta($sql);	
		
	$table_transport = $wpdb->prefix .'transport';//register transport table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_transport." (
			  `transport_id` int(11) NOT NULL AUTO_INCREMENT,
			  `route_name` varchar(200) NOT NULL,
			  `number_of_vehicle` tinyint(4) NOT NULL,
			  `vehicle_reg_num` varchar(50) NOT NULL,
			  `smgt_user_avatar` varchar(5000) NOT NULL,
			  `driver_name` varchar(100) NOT NULL,
			  `driver_phone_num` varchar(15) NOT NULL,
			  `driver_address` text NOT NULL,
			  `route_description` text NOT NULL,
			  `route_fare` int(11) NOT NULL,
			  `status` tinyint(4) NOT NULL DEFAULT '1',
			  PRIMARY KEY (`transport_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);	
		
	$table_smgt_income_expense = $wpdb->prefix .'smgt_income_expense';//register transport table
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_income_expense." (
			 `income_id` int(11) NOT NULL AUTO_INCREMENT,
			  `invoice_type` varchar(50) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `supplier_name` varchar(100) NOT NULL,
			  `entry` text NOT NULL,
			  `payment_status` varchar(50) NOT NULL,
			  `create_by` int(11) NOT NULL,	
			  `income_create_date` date NOT NULL,
			  PRIMARY KEY (`income_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
		
	$table_smgt_library_book = $wpdb->prefix . 'smgt_library_book';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_library_book." (			  
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `ISBN` varchar(50) NOT NULL,
			  `book_name` varchar(200) CHARACTER SET utf8 NOT NULL,
			  `author_name` varchar(100) CHARACTER SET utf8 NOT NULL,
			  `cat_id` int(11) NOT NULL,
			  `rack_location` int(11) NOT NULL,
			  `price` varchar(10) NOT NULL,
			  `quentity` int(11) NOT NULL,
			  `description` text CHARACTER SET utf8 NOT NULL,
			  `added_by` int(11) NOT NULL,
			  `added_date` varchar(20) NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
		
	$table_smgt_library_book_issue = $wpdb->prefix . 'smgt_library_book_issue';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_library_book_issue." (			  
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `class_id` int(11) NOT NULL,
			  `student_id` int(11) NOT NULL,
			  `cat_id` int(11) NOT NULL,
			  `book_id` int(11) NOT NULL,
			  `issue_date` varchar(20) NOT NULL,
			  `end_date` varchar(20) NOT NULL,
			  `actual_return_date` varchar(20) NOT NULL,
			  `period` int(11) NOT NULL,
			  `fine` varchar(20) NOT NULL,
			  `status` varchar(50) NOT NULL,
			  `issue_by` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
	
	$smgt_sub_attendance = $wpdb->prefix . 'smgt_sub_attendance';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_sub_attendance." (			  
			  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `sub_id` int(11) NOT NULL,
			  `attend_by` int(11) NOT NULL,
			  `attendance_date` date NOT NULL,
			  `status` varchar(50) NOT NULL,
			  `role_name` varchar(50) NOT NULL,
			  `comment` text NOT NULL,
			  PRIMARY KEY (`attendance_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
	 
	$mj_smgt_homework = $wpdb->prefix . 'mj_smgt_homework';//homework table
		$sql = "CREATE TABLE IF NOT EXISTS ".$mj_smgt_homework." (
			  `homework_id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(250) NOT NULL,
			  `class_name` int(11) NOT NULL,
			  `section_id` int(11) NOT NULL,
			  `subject` int(11) NOT NULL,
			  `content` text NOT NULL,
			  `submition_date` date NOT NULL,
			  `createdby` int(11) NOT NULL,
			  `created_date` datetime NOT NULL,
			  PRIMARY KEY (`homework_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
		
	$mj_smgt_student_homework = $wpdb->prefix . 'mj_smgt_student_homework';//Student Homework table
		$sql = "CREATE TABLE IF NOT EXISTS ".$mj_smgt_student_homework." (
			  `stu_homework_id` int(50) NOT NULL AUTO_INCREMENT,
			  `homework_id` int(11) NOT NULL,
			  `student_id` int(11) NOT NULL,
			  `status` tinyint(4) NOT NULL,
			  `uploaded_date` datetime DEFAULT NULL,
			  `file` text NOT NULL,
			  `created_by` int(11) NOT NULL,
		      `created_date` datetime NOT NULL,
			  PRIMARY KEY (`stu_homework_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
		
	
	$smgt_message_replies = $wpdb->prefix . 'smgt_message_replies';//register smgt_class table		
		$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_message_replies." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `message_id` int(11) NOT NULL,
			  `sender_id` int(11) NOT NULL,
			  `receiver_id` int(11) NOT NULL,
			  `message_comment` text NOT NULL,
			  `message_attachment` text,
			  `status` int(11),
			  `created_date` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);	
	
	$smgt_class_section = $wpdb->prefix . 'smgt_class_section';//register smgt_class table		
		$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_class_section." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `class_id` int(11) NOT NULL,
			  `section_name` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
			
		dbDelta($sql);

	$smgt_teacher_sub = $wpdb->prefix . 'teacher_subject';		
		$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_teacher_sub." (
			  `teacher_subject_id` int(11) NOT NULL AUTO_INCREMENT,
			  `teacher_id` bigint(20) NOT NULL,
			  `subject_id` bigint(20) NOT NULL,
			  `created_date` datetime NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  PRIMARY KEY (`teacher_subject_id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	
	
	$smgt_notification = $wpdb->prefix . 'smgt_notification';		
		$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_notification." (
			  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
			 `student_id` int(11) NOT NULL,
			 `title` varchar(500) DEFAULT NULL,
			 `message` varchar(5000) DEFAULT NULL,
			 `device_token` varchar(255) DEFAULT NULL,
			 `device_type` tinyint(4) NOT NULL,
			 `bicon` int(11) DEFAULT NULL,
			 `created_date` date DEFAULT NULL,
			 `created_by` int(11) DEFAULT NULL,
			 PRIMARY KEY (`notification_id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	
	
	$table_smgt_exam_time_table = $wpdb->prefix . 'smgt_exam_time_table';//register smgt_exam_time_table
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_exam_time_table." (			  
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `class_id` int(11) NOT NULL,
			  `exam_id` int(11) NOT NULL,
			  `subject_id` int(11) NOT NULL,
			  `exam_date` date NOT NULL,
			  `start_time`  text NOT NULL,
			  `end_time`  text NOT NULL,
			  `created_date` date NOT NULL,
			  `created_by`  int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
		
	$table_smgt_exam_hall_receipt = $wpdb->prefix . 'smgt_exam_hall_receipt';//register smgt_exam_hall_receipt
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_exam_hall_receipt." (			  
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `exam_id` int(11) NOT NULL,
			  `user_id` int(11) NOT NULL,
			  `hall_id` int(11) NOT NULL,
			  `exam_hall_receipt_status` int(11) NOT NULL,
			  `created_date` date NOT NULL,
			  `created_by`  int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);

		
	$smgt_smgt_hostel = $wpdb->prefix . 'smgt_hostel';//register smgt_hostel		
	$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_smgt_hostel." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `hostel_name` varchar(255) NOT NULL,
			  `hostel_type` varchar(255) NOT NULL,
			  `Description` text NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  `created_date` datetime NOT NULL,
			  `updated_by` bigint(20) NOT NULL,
			  `updated_date` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	
	
	$smgt_smgt_room = $wpdb->prefix . 'smgt_room';//register smgt_room	
	$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_smgt_room." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `room_unique_id` varchar(20) NOT NULL,
			   `hostel_id` int(11) NOT NULL,
			   `room_status` int(11) NOT NULL,
			  `room_category` int(11) NOT NULL,
			  `beds_capacity` int(11) NOT NULL,
			  `room_description` text NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  `created_date` datetime NOT NULL,
			  `updated_by` bigint(20) NOT NULL,
			  `updated_date` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	
	
	$smgt_smgt_beds = $wpdb->prefix . 'smgt_beds';//register smgt_beds 		
	$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_smgt_beds." (
			   `id` int(11) NOT NULL AUTO_INCREMENT,
			   `bed_unique_id` varchar(20) NOT NULL,
			   `room_id` int(11) NOT NULL,
			   `bed_status` int(11) NOT NULL,
			   `bed_description` text NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  `created_date` datetime NOT NULL,
			  `updated_by` bigint(20) NOT NULL,
			  `updated_date` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	
	
	$smgt_smgt_assign_beds = $wpdb->prefix . 'smgt_assign_beds';//register smgt_beds 		
	$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_smgt_assign_beds." (
			   `id` int(11) NOT NULL AUTO_INCREMENT,
			   `hostel_id` int(11) NOT NULL ,
			   `room_id` int(11) NOT NULL,
			   `bed_id` int(11) NOT NULL,
			   `bed_unique_id` varchar(20) NOT NULL,
			   `student_id` int(11) NOT NULL,
			   `assign_date` datetime NOT NULL,
			   `created_by` bigint(20) NOT NULL,
			   `created_date` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	
	
	$table_custom_field = $wpdb->prefix .'custom_field';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_custom_field." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,				 
				 `form_name` varchar(255),							 
				 `field_type` varchar(100) NOT NULL,			  
				 `field_label` varchar(100) NOT NULL,			  
				 `field_visibility` int(10),
				 `field_validation` varchar(100),	
				 `created_by` 	int(11),
				 `created_at` datetime NOT NULL,
				 `updated_by` 	int(11),
				 `updated_at` datetime NOT NULL,		 
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			dbDelta($sql);		
			
		$table_custom_field_dropdown_metas = $wpdb->prefix . 'custom_field_dropdown_metas';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_custom_field_dropdown_metas ." (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `custom_fields_id` int(11) NOT NULL,
				  `option_label` varchar(255) NOT NULL,		
				  `created_by` 	int(11),
				  `created_at` datetime NOT NULL,
				  `updated_by` 	int(11),
				  `updated_at` datetime NOT NULL,
				  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=utf8";	
		dbDelta($sql);	
		
		$table_custom_field_metas = $wpdb->prefix . 'custom_field_metas';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_custom_field_metas ." (
				  `id` int(11) NOT NULL AUTO_INCREMENT,				 
				  `module` varchar(100) NOT NULL,		
				  `module_record_id` int(11) NOT NULL,		
				  `custom_fields_id` int(11) NOT NULL,		
				  `field_value` text,		
				  `created_at` datetime NOT NULL,				  
				  `updated_at` datetime NOT NULL,
				  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=utf8";	
		dbDelta($sql);

    $smgt_check_status = $wpdb->prefix . 'smgt_check_status';
		$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_check_status ." (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `type` varchar(50) NULL,		
				  `user_id` int(11) NOT NULL,
				  `type_id` int(11) NOT NULL,
				  `status` int(11) NOT NULL,
				  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=utf8";	
		dbDelta($sql);

	$smgt_zoom_meeting = $wpdb->prefix . 'smgt_zoom_meeting';
		$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_zoom_meeting ." (
				  `meeting_id` int(11) NOT NULL AUTO_INCREMENT,
				  `title` varchar(255) NOT NULL,		
				  `route_id` int(11) NOT NULL,
				  `zoom_meeting_id` varchar(50) NOT NULL,
				  `uuid` varchar(100) NOT NULL,
				  `class_id` int(11) NOT NULL,
				  `section_id` int(11) NULL,
				  `subject_id` int(11) NOT NULL,
				  `teacher_id` int(11) NOT NULL,
				  `weekday_id` int(11) NOT NULL,
				  `password` varchar(50) NULL,
				  `agenda` varchar(2000) NULL,
				  `start_date` date NOT NULL,
				  `end_date` date NOT NULL,
				  `meeting_join_link` varchar(1000) NOT NULL,
				  `meeting_start_link` varchar(1000) NOT NULL,
				  `created_by` 	int(11),
				  `created_date` datetime NOT NULL,
				  `updated_by` 	int(11),
				  `updated_date` datetime NULL,
				  PRIMARY KEY (`meeting_id`)
				) DEFAULT CHARSET=utf8";	
		dbDelta($sql);

	$table_smgt_reminder_zoom_meeting_mail_log = $wpdb->prefix . 'smgt_reminder_zoom_meeting_mail_log';
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_reminder_zoom_meeting_mail_log." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NOT NULL,
			  `meeting_id` int(11) NOT NULL,
			  `class_id` varchar(20) NOT NULL,
			  `alert_date` date NOT NULL,
			  PRIMARY KEY (`id`)
			)DEFAULT CHARSET=utf8";
			
	$wpdb->query($sql);			
		
	global $wpdb;
    $section_row = $wpdb->get_results("SELECT *from $smgt_class_section");
	
    if(empty($section_row))
    {
		
		$tablename="smgt_class";
		$retrieve_class = get_all_data($tablename);
		foreach ($retrieve_class as $retrieved_data){ 
			$tablename_section="smgt_class_section";
			$sectiondata['class_id']=$retrieved_data->class_id;
			$sectiondata['section_name']=$retrieved_data->class_section;
			$result=add_class_section($tablename_section,$sectiondata);
			$studentdata = get_users(array('meta_key' => 'class_name', 'meta_value' => $retrieved_data->class_id,'role'=>'student'));
			if(!empty($studentdata))
			{
				foreach($studentdata as $student)
				{
					add_user_meta( $student->ID, "class_section",$retrieved_data->class_section);
				}
			}
			
		}
    }	
	
	$smgt_teacher_class = $wpdb->prefix . 'smgt_teacher_class';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_teacher_class." (
			  `id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `teacher_id` bigint(20) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  `created_date` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	
	
	
    $teacher_class = $wpdb->get_results("SELECT *from $smgt_teacher_class");	
	if(empty($teacher_class))
	{
		$teacherlist = get_users(array('role'=>'teacher'));		
		if(!empty($teacherlist))
		{
			foreach($teacherlist as $retrieve_data)
			{
				
				$created_by = get_current_user_id();
				$created_date = date('Y-m-d H:i:s');
				$class_id = get_user_meta($retrieve_data->ID,'class_name',true);				
				$success = $wpdb->insert($smgt_teacher_class,array('teacher_id'=>$retrieve_data->ID,
					'class_id'=>$class_id,
					'created_by'=>$created_by,
					'created_date'=>$created_date));
			}
		}		
	}
	$table_smgt_holiday = $wpdb->prefix . 'holiday';		
	$created_date_holiday =  'created_date';
	if (!in_array($created_date_holiday, $wpdb->get_col( "DESC " . $table_smgt_holiday, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_holiday  ADD   $created_date_holiday  datetime NULL");
	}
	$table_smgt_transport = $wpdb->prefix . 'transport';		
	$creted_by =  'created_by';
	if (!in_array($creted_by, $wpdb->get_col( "DESC " . $table_smgt_transport, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_transport  ADD   $creted_by   text");}	
	$comment_field =  'comment';
	if (!in_array($comment_field, $wpdb->get_col( "DESC " . $smgt_sub_attendance, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $smgt_sub_attendance  ADD   $comment_field   text");}	
	$table_attendance = $wpdb->prefix . 'attendence';
	if (!in_array($comment_field, $wpdb->get_col( "DESC " . $table_attendance, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_attendance  ADD   $comment_field   text");}	
	$new_field='post_id';
	$table_smgt_message = $wpdb->prefix . 'smgt_message';	
	if (!in_array($new_field, $wpdb->get_col( "DESC " . $table_smgt_message, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_message  ADD   $new_field   int(11)");}

	$section_id='section_id';
	$created_by='created_by';
	$table_subject = $wpdb->prefix . 'subject';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_subject, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_subject  ADD   $section_id   int(11) NOT NULL");}	

	$table_smgt_fees = $wpdb->prefix . 'smgt_fees';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_smgt_fees, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_fees  ADD   $section_id   int(11) NOT NULL");}	

	$table_smgt_fees_payment = $wpdb->prefix . 'smgt_fees_payment';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_smgt_fees_payment, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_fees_payment  ADD   $section_id   int(11) NOT NULL");}		

   $table_smgt_income_expense = $wpdb->prefix . 'smgt_income_expense';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_smgt_income_expense, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_income_expense  ADD   $section_id   int(11) NOT NULL");}

	$table_smgt_library_book_issue = $wpdb->prefix . 'smgt_library_book_issue';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_smgt_library_book_issue, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_library_book_issue  ADD   $section_id   int(11) NOT NULL");}

	$table_smgt_payment = $wpdb->prefix . 'smgt_payment';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_smgt_payment, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_payment  ADD   $section_id   int(11) NOT NULL");}	
	$table_smgt_payment = $wpdb->prefix . 'smgt_payment';	
	if (!in_array($created_by, $wpdb->get_col( "DESC " . $table_smgt_payment, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_payment  ADD   $created_by   int(11) NOT NULL");}	
			
	if (!in_array($created_by, $wpdb->get_col( "DESC " . $table_smgt_payment, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_payment  ADD   $created_by   int(11) NOT NULL");}	
			
	$section_name="section_name";
	$table_smgt_time_table = $wpdb->prefix . 'smgt_time_table';	
	if (!in_array($section_name, $wpdb->get_col( "DESC " . $table_smgt_time_table, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_time_table  ADD   $section_name   int(11) NOT NULL");
	}	

	$table_marks = $wpdb->prefix . 'marks';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_marks, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_marks  ADD   $section_id   int(11) NOT NULL");}				
	
	$table_smgt_class = $wpdb->prefix . 'smgt_class';//register smgt_class table	
	$wpdb->query(
			"ALTER     TABLE $table_smgt_class  MODIFY   class_capacity  int");
	

		smgt_transfer_sectionid();
		
	$exam_start_date="exam_start_date";
	$exam_end_date="exam_end_date";
	$class_id="class_id";
	$section_id1="section_id";
	$exam_term="exam_term";
	$passing_mark="passing_mark";
	$total_mark="total_mark";
	$exam_syllabus="exam_syllabus";
	$table_smgt_exam = $wpdb->prefix . 'exam';	
	if (!in_array($class_id, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $class_id  int(11) NOT NULL AFTER exam_name");
	}
	if (!in_array($section_id1, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $section_id1  int(11) NOT NULL AFTER class_id");
	}
	if (!in_array($exam_term, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $exam_term  int(11) NOT NULL AFTER section_id");
	}
	if (!in_array($passing_mark, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $passing_mark  tinyint(3) NOT NULL AFTER exam_term");
	}
	if (!in_array($total_mark, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $total_mark  tinyint(3) NOT NULL AFTER passing_mark");
	}
	if (!in_array($exam_start_date, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $exam_start_date  date NOT NULL");
	}
	
	if (!in_array($exam_end_date, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $exam_end_date  date NOT NULL");
	}
	if (!in_array($exam_syllabus, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $exam_syllabus  varchar(255) DEFAULT NULL AFTER exam_end_date");
	}
	$homework_document='homework_document';
	$mj_smgt_homework = $wpdb->prefix . 'mj_smgt_homework';
	if (!in_array($homework_document, $wpdb->get_col( "DESC " . $mj_smgt_homework, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $mj_smgt_homework  ADD   $homework_document  varchar(255) DEFAULT NULL AFTER content");
	}
	$subject_code='subject_code';
	$table_subject = $wpdb->prefix . 'subject';	
	if (!in_array($subject_code, $wpdb->get_col( "DESC " . $table_subject, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_subject  ADD   $subject_code   varchar(255)  DEFAULT NULL");}		
	$smgt_message_replies = $wpdb->prefix . 'smgt_message_replies';
	$message_attachment='message_attachment';
	$status_reply='status';
	if (!in_array($message_attachment, $wpdb->get_col( "DESC " . $smgt_message_replies, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $smgt_message_replies  ADD $message_attachment  text");
	}
	if (!in_array($status_reply, $wpdb->get_col( "DESC " . $smgt_message_replies, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $smgt_message_replies ADD $status_reply int(11)");
	}
}

function smgt_transfer_sectionid()
{	
	$allclass=get_all_data('smgt_class');	
	foreach($allclass as $class)
	{		
		$allsections=smgt_get_class_sections($class->class_id);
		foreach($allsections as $section)
		{		
			     $usersdata = get_users(array('meta_key' => 'class_section', 'meta_value' =>$section->section_name,
				'meta_query'=> array(array('key' => 'class_name','value' => $class->class_id,'compare' => '=')),'role'=>'student'));	
				
				foreach($usersdata as $user)
				{					
					update_user_meta( $user->ID, "class_section", $section->id);
				}
		}
	}
}

function smgt_datepicker_dateformat()
{
	$date_format_array = array(
	'Y-m-d'=>'yy-mm-dd',
	'Y/m/d'=>'yy/mm/dd',
	'd-m-Y'=>'dd-mm-yy',
	//'d/m/Y'=>'dd/mm/yy',
	//'m-d-Y'=>'mm-dd-yy',
	'm/d/Y'=>'mm/dd/yy');
	return $date_format_array;
}
function smgt_get_phpdateformat($dateformat_value)
{
	$date_format_array = smgt_datepicker_dateformat();
	$php_format = array_search($dateformat_value, $date_format_array);  
	return  $php_format;	
}

function smgt_getdate_in_input_box($date)
{ 	
	return date(smgt_get_phpdateformat(get_option('smgt_datepicker_format')),strtotime($date));	
}
function smgt_sender_user_list()
{
	$school_obj = new School_Management ( get_current_user_id () );	
	$login_user_role = $school_obj->role;	
	$role = $_REQUEST['send_to'];
	$login_user_role = $school_obj->role;
	
	$class_list = isset($_REQUEST['class_list'])?$_REQUEST['class_list']:'';
	$class_section = isset($_REQUEST['class_section'])?$_REQUEST['class_section']:'';
	
	$query_data['role']=$role;
	$exlude_id = smgt_approve_student_list();
	
	$html_class_section = '';
	$return_results['section'] = '';
	$user_list = array();
	global $wpdb;
	$defaultmsg=__( 'Select Class Section' , 'school-mgt');
	$html_class_section =  "<option value=''>".$defaultmsg."</option>";	
	if($class_list != '')
	{
		$retrieve_data=smgt_get_class_sections($class_list);	
		if($retrieve_data)
		foreach($retrieve_data as $section)
		{
			$html_class_section .= "<option value='".$section->id."'>".$section->section_name."</option>";
		}
	}
	if($role == 'student')
	{		
		$query_data['exclude']=$exlude_id;
		if($class_section)
		{
			$query_data['meta_key'] = 'class_section';
			$query_data['meta_value'] = $class_section;
			$query_data['meta_query'] = array(array('key' => 'class_name','value' => $class_list,'compare' => '=') );
			$results = get_users($query_data);
		}
		elseif($class_list != '')
		{
			$query_data['meta_key'] = 'class_name';
			$query_data['meta_value'] = $class_list;
			$results = get_users($query_data);
		}			
		else
		{
			if($login_user_role=="parent")
			{
				$parentdata = get_user_meta(get_current_user_id(),'child',true);				
				foreach($parentdata as $key=>$val)
				{					
					$studentdata[]= get_userdata($val);					
				}
				$results = $studentdata;			
			}
			
			if($login_user_role=="teacher")
			{				
			    $teacher_class_data = get_all_teacher_data(get_current_user_id());			
				foreach($teacher_class_data as $data_key=>$data_val)
				{
					$course_id[]=$data_val->class_id;						
					$query_data['meta_key'] = 'class_name';
					$query_data['meta_value'] = $course_id;
					$result= get_users($query_data);
				}
				$results =$result;				 
			}			
		}		
		//$results = get_users($query_data);	
	}
	
	if($role == 'teacher')
	{
		if($class_list != '')
		{
			global $wpdb;
			$table_smgt_teacher_class = $wpdb->prefix. 'smgt_teacher_class';	
			$teacher_list = $wpdb->get_results("SELECT * FROM $table_smgt_teacher_class where class_id = $class_list");
			if($teacher_list)
			{
				foreach($teacher_list as $teacher)
				{
					$user_list[] = $teacher->teacher_id;
				}
			}			
		}
		else
		$results = get_users($query_data);
	}
	if($role == 'supportstaff' || $role == 'administrator')
	{		
		$results = get_users($query_data);
	}
	
	if($role == 'parent')
	{			
		if($class_list == '')
		{
			$results = get_users($query_data);
		}
		else
		{
			$query_data['role'] = 'student';
			$query_data['exclude']=$exlude_id;
		if($class_section)
		{
			$query_data['meta_key'] = 'class_section';
			$query_data['meta_value'] = $class_section;
			$query_data['meta_query'] = array(array('key' => 'class_name','value' => $class_list,'compare' => '=')
			);
		}
		elseif($class_list != '')
		{
			$query_data['meta_key'] = 'class_name';
			$query_data['meta_value'] = $class_list;
		}			
			$userdata=get_users($query_data);
			foreach($userdata as $users)
			{
				$parent = get_user_meta($users->ID, 'parent_id', true);
				
				if(!empty($parent))
				{
					foreach($parent as $p)
					{
						$user_list[]=$p;
					}
				}
			}
			//$userdata =  $user_list;
		}
	}
	if(isset($results))
	{
		foreach($results as $user_datavalue)
		{
			$user_list[] = $user_datavalue->ID;
		}
	}

	$user_data_list = array_unique($user_list);
	
	$return_results['section'] = $html_class_section;
	$return_results['users'] = '';
	$user_string  = '<select name="selected_users[]" id="selected_users" class="form-control" multiple="true">';
	//$user_string .= '<option value=""> Select User</option>';
	if(!empty($user_data_list))
	foreach($user_data_list as $retrive_data)
	{
		if($retrive_data != get_current_user_id())
		{
			$check_data=get_user_name_byid($retrive_data);
			if($check_data != '')
			{	
				$user_string .= "<option value='".$retrive_data."'>".get_user_name_byid($retrive_data)."</option>";
			}
		}
	}
	$user_string .= '</select>';
	$return_results['users'] = $user_string;
	echo json_encode($return_results);
	die();
}

/* ==================  Frantend Tessage Template  ===============*/
/*function smgt_frontend_sender_user_list()
{
	
	$school_obj = new School_Management ( get_current_user_id () );		
	echo $login_user_role = $school_obj->role;
	die();
	$role = $_REQUEST['send_to'];	
	$class_list = isset($_REQUEST['class_list'])?$_REQUEST['class_list']:'';
	$class_section = isset($_REQUEST['class_section'])?$_REQUEST['class_section']:'';
	//$class_section = 1;
	$query_data['role']=$role;
	$exlude_id = smgt_approve_student_list();

	
	//$results = get_users($query_data);
	$html_class_section = '';
	$return_results['section'] = '';
	$user_list = array();
	global $wpdb;
		$defaultmsg=__( 'Select Class Section' , 'school-mgt');
		$html_class_section =  "<option value=''>".$defaultmsg."</option>";	
	if($class_list != '')
	{
		$retrieve_data=smgt_get_class_sections($class_list);	
		if($retrieve_data)
		foreach($retrieve_data as $section)
		{
			$html_class_section .= "<option value='".$section->id."'>".$section->section_name."</option>";
		}
	}
	if($role == 'student'){
		$query_data['exclude']=$exlude_id;
		if($class_section)
		{
			$query_data['meta_key'] = 'class_section';
			$query_data['meta_value'] = $class_section;
			$query_data['meta_query'] = array(array('key' => 'class_name','value' => $class_list,'compare' => '=')
						 );
		}
		elseif($class_list != '')
		{
			$query_data['meta_key'] = 'class_name';
			$query_data['meta_value'] = $class_list;
		}
		$results = get_users($query_data);
		/* $current_role = get_user_role(get_current_user_id());
		if($current_role=="teacher"){
			return $results = "yes";
		}else{
			return $results = get_users($query_data);
		} 
	}
	if($role == 'teacher')
	{
	
		if($class_list != ''){			
			global $wpdb;
			$table_smgt_teacher_class = $wpdb->prefix. 'smgt_teacher_class';	
			$teacher_list = $wpdb->get_results("SELECT * FROM $table_smgt_teacher_class where class_id = $class_list");
			if($teacher_list){
				foreach($teacher_list as $teacher){
					$user_list[] = $teacher->teacher_id;
				}
			}
			
		}
		else
		$results = get_users($query_data);
	}
	if($role == 'supportstaff')
	{
		
		$results = get_users($query_data);
	}
	if($role == 'parent')
	{
		
		if($class_list == '')
		$results = get_users($query_data);
		else{
			$query_data['role'] = 'student';
			$query_data['exclude']=$exlude_id;
		if($class_section)
		{
			$query_data['meta_key'] = 'class_section';
			$query_data['meta_value'] = $class_section;
			$query_data['meta_query'] = array(array('key' => 'class_name','value' => $class_list,'compare' => '=')
						 );
		}
		elseif($class_list != '')
		{
			$query_data['meta_key'] = 'class_name';
			$query_data['meta_value'] = $class_list;
		}
		
			
			
		$userdata=get_users($query_data);
			foreach($userdata as $users)
			{
				$parent = get_user_meta($users->ID, 'parent_id', true);
				//var_dump($parent);
				if(!empty($parent))
				foreach($parent as $p)
				{
					$user_list[]=$p;
				}
			}
			//$userdata =  $user_list;
		}
	}
	if(isset($results))
	{
		foreach($results as $user_datavalue)
			$user_list[] = $user_datavalue->ID;
	}

	
	$user_data_list = array_unique($user_list);
	
	$return_results['section'] = $html_class_section;
	$return_results['users'] = '';
	$user_string  = '<select name="selected_users[]" id="selected_users" class="form-control" multiple="true">';
	//$user_string .= '<option value=""> Select User</option>';
	if(!empty($user_data_list))
	foreach($user_data_list as $retrive_data)
	{
		$user_string .= "<option value='".$retrive_data."'>".get_user_name_byid($retrive_data)."</option>";
	}
	$user_string .= '</select>';
	$return_results['users'] = $user_string;
	echo json_encode($return_results);
	die();
}
*/


function string_replacement($arr,$MsgContent)
{
	$data = str_replace(array_keys($arr),array_values($arr),$MsgContent);
	return $data;
}

add_filter( 'wp_mail_from_name', function( $name ) {
	$from = get_option('smgt_school_name');
	$fromemail = get_option('smgt_email');
	return "{$from}";
});

function smgt_send_mail($email,$subject,$message)
{
	$from		= 	get_option('smgt_school_name');
	$fromemail		= 	get_option('smgt_email');
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
	 
	if(get_option('smgt_mail_notification') == '1')
	{
		wp_mail($email,$subject,$message,$headers);	
	}
}

function get_user_role($id){	
	$result = get_userdata($id);
	$role = implode(', ', $result->roles);
	return $role;
}
//geting teacher class studet
//get currency symbol
function get_currency_symbol( $currency = '' ) 
{			
    $currency = get_option('smgt_currency_code');
			switch ( $currency ) {
			case 'AED' :
			$currency_symbol = 'د.إ';
			break;
			case 'AUD' :
			$currency_symbol = '&#36;';
			break;
			case 'CAD' :
			$currency_symbol = 'C&#36;';
			break;
			case 'CLP' :
			case 'COP' :
			case 'HKD' :
			$currency_symbol = '&#36';
			break;
			case 'MXN' :
			$currency_symbol = '&#36';
			break;
			case 'NZD' :
			$currency_symbol = '&#36;';
			break;
			case 'SGD' :
			case 'USD' :
			$currency_symbol = '&#36;';
			break;
			case 'BDT':
			$currency_symbol = '&#2547;&nbsp;';
			break;
			case 'BGN' :
			$currency_symbol = '&#1083;&#1074;.';
			break;
			case 'BRL' :
			$currency_symbol = '&#82;&#36;';
			break;
			case 'CHF' :
			$currency_symbol = '&#67;&#72;&#70;';
			break;
			case 'CNY' :
			case 'JPY' :
			case 'RMB' :
			$currency_symbol = '&yen;';
			break;
			case 'CZK' :
			$currency_symbol = '&#75;&#269;';
			break;
			case 'DKK' :
			$currency_symbol = 'kr.';
			break;
			case 'DOP' :
			$currency_symbol = 'RD&#36;';
			break;
			case 'EGP' :
			$currency_symbol = '£';
			break;
			case 'EUR' :
			$currency_symbol = '&euro;';
			break;
			/* case 'INR' :
			$currency_symbol = '&#x20B9;';
			break; */
			case 'GBP' :
			$currency_symbol = '&pound;';
			break;
			case 'HRK' :
			$currency_symbol = 'Kn';
			break;
			case 'HUF' :
			$currency_symbol = '&#70;&#116;';
			break;
			case 'IDR' :
			$currency_symbol = 'Rp';
			break;
			case 'ILS' :
			$currency_symbol = '&#8362;';
			break;
			case 'INR' :
			//$currency_symbol = '&#8377';
			$currency_symbol = '₹';
			break;
			case 'PKR' :
			//$currency_symbol = '&#8377';
			$currency_symbol = '₨';
			break;
			case 'ISK' :
			$currency_symbol = 'Kr.';
			break;
			case 'KIP' :
			$currency_symbol = '&#8365;';
			break;
			case 'KRW' :
			$currency_symbol = '&#8361;';
			break;
			case 'MYR' :
			$currency_symbol = '&#82;&#77;';
			break;
			case 'NGN' :
			$currency_symbol = '&#8358;';
			break;
			case 'NOK' :
			$currency_symbol = '&#107;&#114;';
			break;
			case 'NPR' :
			$currency_symbol = 'Rs.';
			break;
			case 'PHP' :
			$currency_symbol = '&#8369;';
			break;
			case 'PLN' :
			$currency_symbol = '&#122;&#322;';
			break;
			case 'PYG' :
			$currency_symbol = '&#8370;';
			break;
			case 'RON' :
			$currency_symbol = 'lei';
			break;
			case 'RUB' :
			$currency_symbol = '&#1088;&#1091;&#1073;.';
			break;
			case 'SEK' :
			$currency_symbol = '&#107;&#114;';
			break;
			case 'THB' :
			$currency_symbol = '&#3647;';
			break;
			case 'TRY' :
			$currency_symbol = '&#8378;';
			break;
			case 'TWD' :
			$currency_symbol = '&#78;&#84;&#36;';
			break;
			case 'UAH' :
			$currency_symbol = '&#8372;';
			break;
			case 'VND' :
			$currency_symbol = '&#8363;';
			break;
			case 'ZAR' :
			$currency_symbol = '&#82;';
			break;
			case 'GHC' :
	        $currency_symbol = '&#8373;';
	        break;
			default :
			$currency_symbol = $currency;
			break;
	}
	return $currency_symbol;

}

function get_teacher_by_class_id($class_id)
{	
	global $wpdb;
	$tbl_name 	= 	$wpdb->prefix .'smgt_teacher_class';	
	$teachers	=	$wpdb->get_results("SELECT * FROM $tbl_name where class_id=".$class_id);
	foreach($teachers as $key=>$teacher)
	{		
		$teachersdata[] = get_userdata($teacher->teacher_id);		
	}
	return $teachersdata;
}

function GetHTMLContent($fees_pay_id)
{		
	$schooName 	= 	get_option('smgt_school_name');
	$schooLogo 	= 	get_option('smgt_school_logo');
	$schooAddress	= 	get_option( 'smgt_school_address' );
	$schoolCountry	= 	get_option( 'smgt_contry' );
	$schoolNo 	=  get_option( 'smgt_contact_number' );
			
	$fees_detail_result = get_single_fees_payment_record($fees_pay_id);	
	$fees_history_detail_result = get_payment_history_by_feespayid($fees_pay_id);
	
	$student_id=$fees_detail_result->student_id;
		$abc="";
	if($student_id !=0)
	{
		$patient=get_userdata($student_id);												
		$patient->display_name."<br>"; 
		$abc = get_user_meta( $student_id,'address',true ).",".get_user_meta( $student_id,'city',true ).",". get_user_meta( $student_id,'zip_code',true ).",<BR>". get_user_meta( $student_id,'state',true ).",".get_option( 'smgt_contry' ).",".get_user_meta( $student_id,'mobile',true )."<br>";
	}
	
	$content	='';
	$content	.='';
	
	$content='	
	<div style="background-color:aliceblue; padding:20px"; class="modal-body">
		<div class="modal-header">
			<h4 class="modal-title">'.$schooName.'</h4>
		</div>
		<div id="invoice_print" class="print-box"> 
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td width="70%">
							<img style="max-height:80px;" src='.get_option( 'smgt_school_logo' ).'/>
						</td>
						<td align="right" width="24%">
							<h5>'; ?>
							<?php 
							$payment_status = get_payment_status($fees_detail_result->fees_pay_id);					
							if($payment_status=='Paid') 
								$PStatus= 'Paid';
							if($payment_status=='Partially Paid')
								$PStatus =  'Part Paid';
							else
								$PStatus = 'Unpaid';
							
							$issue_date="DD-MM-YYYY";
							$issue_date=$fees_detail_result->paid_by_date;	
							$Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount; 
							$content .= 'Issue Date: '. smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))).'</h5>';					
							$content .= '<h5>Status : <span class="btn btn-success btn-xs">'. $PStatus .'</span></h5>';	
							$content .= '</td></tr><tbody></table>
							
							<table width="100%" border="0">
								<tbody>
									<tr>
										<td align="left">
											<h4>Payment From</h4>
										</td>
										<td align="right">
											<h4>Bill To</h4>
										</td>
									</tr>
									<tr>
										<td valign="top" align="left">
											'.$schooName.'<br>
											'.$schooAddress.',
											'.$schoolCountry .'<br>
											'.$schoolNo.'<br>		
										</td>
										<td valign="top" align="right">'.$abc.'</td>
								</tr>
							</tbody>
						</table><hr>
						<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center"> Fees Type</th>
									<th>Total</th>					
								</tr>
							</thead>
							<tbody>
								<td>1</td>
								<td>'.get_fees_term_name($fees_detail_result->fees_id).'</td>
								<td><span>'. get_currency_symbol() ." </span>" . number_format($fees_detail_result->total_amount,2).'</td>
							</tbody>
						</table>
						
						<table width="100%" border="0">
							<tbody>							
								<tr>
									<td width="80%" align="right">Sub Total :</td>
									<td align="right"><span>'.get_currency_symbol() ." </span>" .number_format($fees_detail_result->total_amount,2) .'</td>
								</tr>
								<tr>
									<td width="80%" align="right">Payment Made :</td>
									<td align="right"><span>'. get_currency_symbol() ." </span>" . number_format($fees_detail_result->fees_paid_amount,2) .'</td>
								</tr>
								<tr>
									<td width="80%" align="right">Due Amount  :</td>
									<td align="right"><span>'. get_currency_symbol() ." </span>" . number_format($Due_amount,2) .'</td>';
								$content .='</tr>				
							</tbody>
						</table></div></div>';
						return $content;
}
//strip tags and slashes
function smgt_strip_tags_and_stripslashes($string)
{
	$new_string=stripslashes(strip_tags($string));
	return $new_string;
}	
//dashboard page access right
function page_access_rolewise_accessright_dashboard($page)
{
	$school_obj = new School_Management ( get_current_user_id () );	
	$role = $school_obj->role;
	if($role=='student')
	{
		$menu = get_option( 'smgt_access_right_student');
	}
	elseif($role=='parent')
	{
		$menu = get_option( 'smgt_access_right_parent');
	}
	elseif($role=='supportstaff')
	{
		$menu = get_option( 'smgt_access_right_supportstaff');
	}
	elseif($role=='teacher')
	{
		$menu = get_option( 'smgt_access_right_teacher');
	}
	
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{	
			if ($page == $value['page_link'])
			{				
				if($value['view']=='0')
				{			
					$flage=0;
				}
				else
				{
				  $flage=1;
				}
			}
		}
	}	
	
	return $flage;
}
//user role wise access right array In Filter Data
function smgt_get_userrole_wise_filter_access_right_array($page_name)
{
	$school_obj = new School_Management ( get_current_user_id () );	
	$role = $school_obj->role;
	if($role=='student')
	{
		$menu = get_option( 'smgt_access_right_student');
	}
	elseif($role=='parent')
	{
		$menu = get_option( 'smgt_access_right_parent');
	}
	elseif($role=='supportstaff')
	{
		$menu = get_option( 'smgt_access_right_supportstaff');
	}
	elseif($role=='teacher')
	{
		$menu = get_option( 'smgt_access_right_teacher');
	}
		
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{				
			if ($page_name == $value['page_link'])
			{				
				return $value;
			}
		}
	}	
} 
//user role wise access right array
function smgt_get_userrole_wise_access_right_array()
{
	$school_obj = new School_Management ( get_current_user_id () );	
	$role = $school_obj->role;
	if($role=='student')
	{
		$menu = get_option( 'smgt_access_right_student');
	}
	elseif($role=='parent')
	{
		$menu = get_option( 'smgt_access_right_parent');
	}
	elseif($role=='supportstaff')
	{
		$menu = get_option( 'smgt_access_right_supportstaff');
	}
	elseif($role=='teacher')
	{
		$menu = get_option( 'smgt_access_right_teacher');
	}
	
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{				
			if ($_REQUEST ['page'] == $value['page_link'])
			{				
				return $value;
			}
		}
	}	
}
//user role wise access right array by fix page
function smgt_get_userrole_wise_access_right_array_by_page($page)
{
	$school_obj = new School_Management ( get_current_user_id () );	
	$role = $school_obj->role;
	if($role=='student')
	{
		$menu = get_option( 'smgt_access_right_student');
	}
	elseif($role=='parent')
	{
		$menu = get_option( 'smgt_access_right_parent');
	}
	elseif($role=='supportstaff')
	{
		$menu = get_option( 'smgt_access_right_supportstaff');
	}
	elseif($role=='teacher')
	{
		$menu = get_option( 'smgt_access_right_teacher');
	}
	
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{	
			if ($page == $value['page_link'])
			{				
				if($value['own_data']=='0')
				{			
					$flage=0;
				}
				else
				{
				  $flage=1;
				}
			}
		}
	}	
	return $flage;
}
// CHANGE PROFILE PHOTO IN USER DASHBOARD //
function smgt_change_profile_photo()
{
	?>
	<div class="modal-header"> <a href="#" class="close-btn-cat badge badge-danger pull-right">X</a>
	</div>
	<form class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
	<div class="form-group">
	<label for="inputEmail" class="control-label col-sm-3"><?php _e('Select Profile Picture','school-mgt');?></label>
		<div class="col-xs-8">	
			<input id="input-1" name="profile" type="file" onchange="fileCheck(this);" style="border:0px;"  class="form-control file">
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-offset-2 col-sm-10" style="margin-bottom: 5px;">
				<button type="submit" class="btn btn-success" name="save_profile_pic"><?php _e('Save','school-mgt');?></button>
		</div>
	</div>
	</form>
    <?php 
	die();
}
function MJ_smgt_password_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	//$replase_string=preg_replace('/[^0-9a-zA-Z\ \_\,\`\.\'\^\-\&\@\()\{}\[]\|\|\=\%\*\%\#\!\~\$\<>\+\n]/s', '', $string);
	return $replase_string;
}

//REMOVE HTML ENTITY STRING FUNCTION 

function MJ_smgt_email_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	//$replase_string=preg_replace('/[^0-9a-zA-Z\ \_\,\`\.\'\^\-\&\@\+\n]/s', '', $string);
	return $replase_string;
}
//REMOVE HTML ENTITY STRING FUNCTION //
 //1)roll_id 2)address_description
function MJ_smgt_address_description_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	//$replase_string=preg_replace('/[^0-9a-zA-Z\ \_\,\`\.\'\^\-\&\@\+\n]/s', '', $string);
	return $replase_string;
}

function MJ_smgt_phone_number_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	//$replase_string=preg_replace('/[^0-9\ \-\+]/s', '', $string);
	return $replase_string;
}

function MJ_smgt_username_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	//$replase_string=preg_replace('/[^0-9a-zA-Z\_\.\-\@]/s', '', $string);
	return $replase_string;
}


function MJ_smgt_popup_category_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	//$replase_string=preg_replace('/[^0-9a-zA-Z\ \_\,\`\.\'\^]/s', '', $string);
	return $replase_string;
}
function MJ_smgt_city_state_country_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	//$replase_string=preg_replace('/[^\x00-\x80]|[^a-zA-Z\ \_\,\`\.\'\^\-\&]/s', '', $string);
	return $replase_string;
}

function MJ_smgt_onlyLetter_specialcharacter_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	//$replase_string=preg_replace('/[^\x00-\x80]|[^a-zA-Z\ \_\,\`\.\'\^\-]/s', '', $string);
	return $replase_string;
}

function MJ_smgt_onlyLetterNumber_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	//$replase_string=preg_replace('/[^0-9a-zA-Z]/s', '', $string);
	return $replase_string;
}
function MJ_smgt_onlyLetterSp_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	//$replase_string=preg_replace('/[^\x00-\x80]|[^a-zA-Z\ \']/s', '', $string);
	return $replase_string;
}

function MJ_smgt_onlyNumberSp_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	//$replase_string=preg_replace('/[^0-9\ ]/s', '', $string);
	return $replase_string;
}
function smgt_count_student_in_class()
{
	global $wpdb;
	$table_name = $wpdb->prefix .'smgt_class';
	$class_id=$_POST['class_id'];
	$student_list =count( get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id, 'role'=>'student')));
	$class_capacity_data =$wpdb->get_row("SELECT class_capacity FROM $table_name WHERE class_id=".$class_id);
	$class_capacity=intval($class_capacity_data->class_capacity);
	
	$class_data=array();
	
	if($class_capacity > $student_list)
	{
		echo "class_empt";
		
		$class_data[0]='class_empt';
	}
	else
	{
		
		$class_data[0]='class_full';
		$class_data[1]=$class_capacity;
		$class_data[2]=$student_list;
	}
	echo json_encode($class_data);
	die;
}

function convert_date_time($date_time)
{
	$format = get_option( 'smgt_datepicker_format' );
	
	if($format == 'yy-mm-dd')
	{
		$change_formate='Y-m-d';
	}
	elseif($format == 'yy/mm/dd')
	{
		$change_formate='Y/m/d';
		
	}
	elseif($format == 'dd-mm-yy')
	{
		$change_formate='d-m-Y';
		
	}
	elseif($format == 'mm/dd/yy')
	{
		$change_formate='m/d/Y';
	}
	else
	{
		$change_formate='Y-m-d';
	}
	//$date='2019-08-22 10:29:56';
	$timestamp = strtotime( $date_time ); // Converting time to Unix timestamp
	$offset = get_option( 'gmt_offset' ) * 60 * 60; // Time offset in seconds
	$local_timestamp = $timestamp + $offset;
	$local_time = date_i18n($change_formate .' H:i:s', $local_timestamp );
	return $local_time;
}
  
//show event and task model code
function smgt_show_event_task()
{	
	$id = $_REQUEST['id'];	
	 
	$model = $_REQUEST['model'];
	 
	if($model=='Notification Details')
	{
		$notification=new Smgt_dashboard;
		$notification_data=$notification->get_signle_notification_by_id($id);
	}
	if($model=='Noticeboard Details')
	{
		$retrieve_class =get_post($id);
	}
	if($model=='Exam Details')
	{
		$exam_data= get_exam_by_id($id);
	}
	if($model=='holiday Details')
	{
		$holiday_data= get_holiday_by_id($id);
	}
?>
     <div class="modal-header model_header_padding"> <a href="#" class="event_close-btn badge badge-success pull-right">X</a>
  		<h4 id="myLargeModalLabel" class="modal-title"><?php if($model=='Notification Details'){ _e('Notification Details','school-mgt'); } elseif($model=='Noticeboard Details'){ _e('Notice Board Details','school-mgt'); } elseif($model=='Exam Details'){ _e('Exam Details','school-mgt'); } elseif($model=='holiday Details'){ _e('holiday Details','school-mgt'); }?></h4>
	</div>
	<div class="panel panel-white">
	<?php
	if($model=='Notification Details')
	{
	?>
		<div class="modal-body">
			<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
				<tbody>
					<tr>
						<td><?php _e('Student Name','school-mgt'); ?></td>
						<td><?php echo get_user_name_byid($notification_data->student_id); ?></td>
					</tr>
					<tr>
						<td><?php _e('Title','school-mgt'); ?></td>
						<td><?php echo $notification_data->title; ?></td>
					</tr>
					<tr>
						<td><?php _e('Message','school-mgt'); ?></td>
						<td><?php echo $notification_data->message; ?></td>
					</tr>
				</tbody>
			</table>
        </div>  		
	 <?php
	
	}
	?>
	<?php
	if($model=='Noticeboard Details')
	{
	?>
		<div class="modal-body">
			<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
				<tbody>
					<tr>
						<td><?php _e('Notice Title','school-mgt'); ?></td>
						<td><?php echo $retrieve_class->post_title; ?></td>
					</tr>
					<tr>
						<td><?php _e('Notice Comment','school-mgt'); ?></td>
						<td><?php $strlength= strlen($retrieve_class->post_content);
								if($strlength > 60)
									echo $retrieve_class->post_content;
								else
									echo $retrieve_class->post_content; ?>
						</td>
					</tr>
					<tr>
						<td><?php _e('Notice Start Date','school-mgt'); ?></td>
						<td><?php echo smgt_getdate_in_input_box(get_post_meta($retrieve_class->ID,'start_date',true)); ?></td>
					</tr>
					<tr>
						<td><?php _e('Notice End Date','school-mgt'); ?></td>
						<td><?php echo smgt_getdate_in_input_box(get_post_meta($retrieve_class->ID,'end_date',true)); ?></td>
					</tr>
					<tr>
						<td><?php _e('Notice For','school-mgt'); ?></td>
						<td><?php echo get_post_meta( $retrieve_class->ID, 'notice_for',true); ?></td>
					</tr>
				</tbody>
			</table>
        </div>  		
	 <?php
	
	}
	?>
	<?php
	if($model=='Exam Details')
	{
	?>
		<div class="modal-body">
			<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
				<tbody>
					<tr>
						<td><?php _e('Exam Title','school-mgt'); ?></td>
						<td><?php echo $exam_data->exam_name; ?></td>
					</tr>
					<tr>
						<td><?php _e('Exam Start Date','school-mgt'); ?></td>
						<td><?php echo smgt_getdate_in_input_box($exam_data->exam_start_date); ?>
						</td>
					</tr>
					<tr>
						<td><?php _e('Exam End Date','school-mgt'); ?></td>
						<td><?php echo smgt_getdate_in_input_box($exam_data->exam_end_date); ?></td>
					</tr>
					<tr>
						<td><?php _e('Exam Comment','school-mgt'); ?></td>
						<td><?php echo $exam_data->exam_comment; ?></td>
					</tr>
				</tbody>
			</table>
        </div>  		
	 <?php
	}
	?>
	<?php
	if($model=='holiday Details')
	{
	?>
		<div class="modal-body">
			<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
				<tbody>
					<tr>
						<td><?php _e('Holiday Title','school-mgt'); ?></td>
						<td><?php echo $holiday_data->holiday_title; ?></td>
					</tr>
					<tr>
						<td><?php _e('Description','school-mgt'); ?></td>
						<td><?php echo $holiday_data->description; ?></td>
					</tr>
					<tr>
						<td><?php _e('Start Date','school-mgt'); ?></td>
						<td><?php echo smgt_getdate_in_input_box($holiday_data->date); ?>
						</td>
					</tr>
					<tr>
						<td><?php _e('End Date','school-mgt'); ?></td>
						<td><?php echo smgt_getdate_in_input_box($holiday_data->end_date); ?></td>
					</tr>
					
				</tbody>
			</table>
        </div>  		
	 <?php
	}
	?>
    </div> 
	<?php   
	die();	 
}
function get_all_date_of_holidays()
{
	global $wpdb;
	$tbl_holiday = $wpdb->prefix.'holiday';
	$holiday ="SELECT * FROM $tbl_holiday";
	$HolidayData = $wpdb->get_results($holiday);		
	$holidaydates= array();
		
		foreach($HolidayData as $holiday)
		{
			$holidaydates[] = $holiday->date;
			$holidaydates[] = $holiday->end_date;
			$start_date = strtotime($holiday->date);
			$end_date =strtotime($holiday->end_date);
			if($holiday->date != $holiday->end_date)
			{
				for($i=$start_date; $i<$end_date; $i+=86400)
				{
					$holidaydates[] = date("Y-m-d",$i);
				}
			}
		}
		
	$holidaydates = array_unique($holidaydates);
	return $holidaydates;
}
 //-------- Generate Admission Number ------------//
function smgt_generate_admission_number()
{
	global $wpdb;
	$table_wp_users=$wpdb->prefix.'wp_users';
	 				
	$userdata =get_users();
	if(empty($userdata))
	{							
		return $admission_no='00001';
	}
	else
	{
		$all_user = count($userdata);							
		// foreach($userdata as $user) 
		// {
		// 	$all_user=$user->ID;
		// }
		$admission_no=$all_user+1;
		return $admission_no;
	} 
 }
 //ADD OR REMOVE CATEGORUY //
function smgt_add_or_remove_category_new()//smgt_add_or_remove_category_new
{	 
	$model = $_REQUEST['model'];
	/* var_dump($model);
	die; */
	$title = esc_html__("title",'school-mgt');

	$table_header_title =  esc_html__("header",'school-mgt');

	$button_text=  esc_html__("Add category",'school-mgt');

	$label_text =  esc_html__("category Name",'school-mgt');

	
	if($model == 'school_category')//school_category
	{
	
		$title = esc_html__("Add School Name",'school-mgt');

		$table_header_title =  esc_html__("School Name",'school-mgt');

		$button_text=  esc_html__("Add School Name",'school-mgt');

		$label_text =  esc_html__("School Name",'school-mgt');	

	}
	if($model == 'standard_category')//standard_category
	{
	
		$title = esc_html__("Add Standard Name",'school-mgt');

		$table_header_title =  esc_html__("Standard Name",'school-mgt');

		$button_text=  esc_html__("Add Standard",'school-mgt');

		$label_text =  esc_html__("Standard Name",'school-mgt');	

	}
	if($model == 'term_category')//term_category
	{
	
		$title = esc_html__("Add Term Category",'school-mgt');

		$table_header_title =  esc_html__("Term Category Name",'school-mgt');

		$button_text=  esc_html__("Add Term Category Name",'school-mgt');

		$label_text =  esc_html__("Term Category Name",'school-mgt');	

	}
	if($model == 'room_category')//term_category
	{
	
		$title = esc_html__("Add Room Category",'school-mgt');

		$table_header_title =  esc_html__("Room Category Name",'school-mgt');

		$button_text=  esc_html__("Add Room Category Name",'school-mgt');

		$label_text =  esc_html__("Room Category Name",'school-mgt');	

	}
	if($model == 'smgt_feetype')//term_category
	{
	
		$title = esc_html__("Add Fees Category",'school-mgt');

		$table_header_title =  esc_html__("Fees Category Name",'school-mgt');

		$button_text=  esc_html__("Add Fees Category Name",'school-mgt');

		$label_text =  esc_html__("Fees Category Name",'school-mgt');	

	}
	if($model == 'smgt_bookcategory')//term_category
	{
	
		$title = esc_html__("Add Book Category",'school-mgt');

		$table_header_title =  esc_html__("Book Category Name",'school-mgt');

		$button_text=  esc_html__("Add Book Category Name",'school-mgt');

		$label_text =  esc_html__("Book Category Name",'school-mgt');	

	}
	if($model == 'smgt_rack')//term_category
	{
	
		$title = esc_html__("Add Rack Location",'school-mgt');

		$table_header_title =  esc_html__("Rack Location Name",'school-mgt');

		$button_text=  esc_html__("Add Rack Location Name",'school-mgt');

		$label_text =  esc_html__("Rack Location Name",'school-mgt');	

	}
	if($model == 'period_type')//term_category
	{
	
		$title = __("Issue Period",'school-mgt');
		$table_header_title =  __("Period Time",'school-mgt');
		$button_text=  __("Add Period Time",'school-mgt');
		$label_text =  __("Period Time",'school-mgt');
	}
	
	if($model == 'period_type')//term_category
	{
		$obj_lib = new Smgtlibrary();
		$cat_result1 = $obj_lib->smgt_get_periodlist();  
	}
	else
	{
		$cat_result = smgt_get_all_category( $model );
	}	 
	/*  var_dump($cat_result);
	die;   */ 
	?>
	<script src="jquery.maxlength.min.js"></script>

	<script type="text/javascript">
	jQuery(document).ready(function()
	{
		jQuery('#category_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	});
	jQuery('.onlyletter_number_space_validation').keypress(function(e) 
	{     
		var regex = new RegExp("^[0-9a-zA-Z \b]+$");
		var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
		if (!regex.test(key)) 
		{
			event.preventDefault();
			return false;
		} 
   });  
	</script>
	<div class="modal-header" style="padding:15px!important;"> <a href="#" class="close-btn badge badge-success pull-right">X</a><!--MODAL-HEADER--->

  		<h4 id="myLargeModalLabel" class="modal-title"><?php echo $title;?></h4>

	</div>

	<div class="panel panel-white"><!---PANEL-WHITE--->

  		<div class="category_listbox_new"><!---CATEGORY_LISTBOX----->

  			<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12"><!---TABLE-RESPONSIVE----->

		  		<table class="table">
			  		<thead>
			  			<tr>
							<th><?php echo $table_header_title;?></th>
			                <th><?php esc_html_e('Action','school-mgt');?></th>
			            </tr>
			        </thead>
					<?php 
					$i = 1;

					if($model == 'period_type') 
					{			
						foreach ($cat_result1 as $retrieved_data)
						{
							echo '<tr id="cat_new-'.$retrieved_data->ID.'">';
							echo '<td>'.$retrieved_data->post_title.' '. __("Days","school-mgt").'</td>';
							echo '<td id='.$retrieved_data->ID.'><a class="btn-delete-cat_new badge badge-delete" model='.$model.' href="#" id='.$retrieved_data->ID.'>X</a></td>';
							echo '</tr>';
							$i++;		
						}
					}
					else
					{
						foreach ($cat_result as $retrieved_data)
						{
							echo '<tr id="cat_new-'.$retrieved_data->ID.'">';
							echo '<td>'.$retrieved_data->post_title.'</td>';
							echo '<td id='.$retrieved_data->ID.'><a class="btn-delete-cat_new badge badge-delete" model='.$model.' href="#" id='.$retrieved_data->ID.'>X</a><a class="btn-edit-cat_popup badge badge-edit"  model="'.$model.'" href="#" id="'.$retrieved_data->ID.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>';
							echo '</tr>'; 
							$i++;		
						}
					}  
					 ?>
		        </table>
			</div><!---END TABLE-RESPONSIVE----->
		</div><!---END CATEGORY_LISTBOX----->	
		<form name="category_form" action="" method="post" class="form-horizontal" id="category_form"><!---CATEGORY_FORM----->
	  	 	<div class="form-group">
				<label class="col-sm-4 control-label" for="category_name"><?php echo $label_text;?><span class="require-field">*</span></label>
				<div class="col-sm-4" style="padding-bottom: 10px;">
					<?php 
					if($model == 'period_type')
					{
					?>					
						<input id="category_name" maxlength="50" class="form-control text-input onlyletter_number_space_validation" type="number"  value=""  name="category_name"  placeholder="<?php _e('Must Be Enter Number of Days','school-mgt');?>">
					<?php
					}
					else
					{
					?>
						<input id="category_name" maxlength="50" class="form-control text-input onlyletter_number_space_validation"  value="" name="category_name" <?php if(isset($placeholder_text)){?> type="number" placeholder="<?php  echo $placeholder_text;}else{?>" type="text" <?php }?>>

					<?php
					}
					?>
				</div>
				<div class="col-sm-4" style="padding-bottom: 10px;">
					<input type="button" value="<?php echo $button_text;?>" name="save_category" class="btn btn-success" model="<?php echo $model;?>" id="btn-add-cat_new"/>
				</div>
			</div>
		</form>
	</div><!---END PANEL-WHITE--->
	<?php 
	die();	
}
//ADD CATEGORY POPUP //
function smgt_add_category_new($data)
{

	global $wpdb;
	$model = $_REQUEST['model'];
	
	$array_var = array();
	$data = array();
	$data['category_name'] = $_POST['category_name'];
	$data['category_type'] = $_POST['model'];
   /* var_dump($data['category_name']);
   var_dump($data['category_type']);
   die; */
	$id =smgt_add_categorytype($data);
	if($model == 'period_type')
	{
		$row1 = '<tr id="cat_new-'.$id.'"><td>'.$_REQUEST['category_name'].' '. __("Days","school-mgt").'</td><td><a class="btn-delete-cat_new badge badge-delete" href="#" id='.$id.' model="'.$model.'">X</a></td></tr>';
		$option = "<option value='$id'>".$_REQUEST['category_name'].' Days'."</option>";
	}
	else
	{
		$row1 = '<tr id="cat_new-'.$id.'"><td>'.$_REQUEST['category_name'].'</td><td><a class="btn-delete-cat_new badge badge-delete" href="#" id='.$id.' model="'.$model.'">X</a><a class="btn-edit-cat_popup badge badge-edit"  model="'.$model.'" href="#" id="'.$id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td></tr>';
		$option = "<option value='$id'>".$_REQUEST['category_name']."</option>";
	}

	$array_var[] = $row1;

	$array_var[] = $option;
   
	echo json_encode($array_var);

	die();
}
//-- Add Dynamic Category
function smgt_add_categorytype($data)
{
	global $wpdb;
	if($data['category_type'] == 'period_type')
	{
		$result = wp_insert_post( array(

			'post_status' => 'publish',

			'post_type' =>'smgt_bookperiod',

			'post_title' => $data['category_name']) );
	}
	else
	{
		$result = wp_insert_post( array(

			'post_status' => 'publish',

			'post_type' => $data['category_type'],

			'post_title' => $data['category_name']) );
	}
	$id = $wpdb->insert_id;
	return $id;
}
 //remove category 
function smgt_remove_category_new()
{
 
	wp_delete_post($_REQUEST['cat_id']);
	
	die();
}
//-- Get Dynamic Categories
function smgt_get_all_category($model){

	$args= array('post_type'=> $model,'posts_per_page'=>-1,'orderby'=>'post_title','order'=>'Asc');

	$cat_result = get_posts( $args );

	return $cat_result;

}

function smgt_admissoin_approved()
{
	$uid = $_REQUEST['student_id'];
	$user_info=get_userdata($uid);
	?>
<script type="text/javascript">
jQuery(document).ready(function() {
	    jQuery('#admission_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});	 
} );
</script>
   
<style>
	 .modal-header{
		 height:auto;
	 }
	</style>
<div class="modal-header"> <a href="#" class="close-btn badge badge-success pull-right">X</a>
	 <img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" />
 <?php echo get_option( 'smgt_school_name' );?> 
</div>
<hr class="hr_margin">
<div class="panel panel-white admission_div_responsive">
	<div class="panel-heading">
		<h4 class="panel-title"><i class="fa fa-user"></i> <?php echo get_user_name_byid($uid);?></h4>
	</div>
   <form name="admission_form" action="" method="post" class="form-horizontal" id="admission_form">
		<input type="hidden" name="act_user_id" value="<?php echo $uid;?>">
		<div class="form-group">
			<label class="col-sm-2 control-label " for="email"><?php _e('Email','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="email" class="form-control validate[required,custom[email]] text-input email" maxlength="100" value="<?php  echo $user_info->user_email;?>"type="text"  name="email" readonly>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="password"><?php _e('Password','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="password" class="form-control validate[required]" type="password"  name="password" value="">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_name"><?php _e('Class','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select name="class_name" class="form-control validate[required] class_in_student width_515" id="class_list">
					<option value=""><?php _e('Select Class','school-mgt');?></option>
					<?php
						foreach(get_allclass() as $classdata)
						{  
						?>
						 <option value="<?php echo $classdata['class_id'];?>"><?php echo $classdata['class_name'];?></option>
					<?php }?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Section','school-mgt');?></label>
			<div class="col-sm-8">
				<select name="class_section" class="form-control width_515" id="class_section">
					<option value=""><?php _e('Select Class Section','school-mgt');?></option>
					<?php
					if($edit){
						foreach(smgt_get_class_sections($user_info->class_name) as $sectiondata)
						{  ?>
						 <option value="<?php echo $sectiondata->id;?>"><?php echo $sectiondata->section_name;?></option>
					<?php } 
					}?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="roll_id"><?php _e('Roll No.','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="roll_id" class="form-control validate[required,custom[username_validation]] text-input" maxlength="50" type="text" value="" name="roll_id">
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	 <input type="submit" value="<?php _e('Active Student','school-mgt');?>" name="active_user_admission" class="btn btn-success margin_top_20"/>
        </div>
   </form>
</div>
  <?php
  die();
}

add_action('wp_ajax_datatable_homework_data_ajax_to_load','datatable_homework_data_ajax_to_load');

add_action( 'wp_ajax_smgt_load_students_homework','smgt_load_students_homework');

add_action( 'wp_ajax_nopriv_smgt_load_students_homework','smgt_load_students_homework');

add_action( 'wp_ajax_smgt_load_sections_students_homework','smgt_load_sections_students_homework');

add_action( 'wp_ajax_nopriv_smgt_load_sections_students_homework','smgt_load_sections_students_homework');

function datatable_homework_data_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'mj_smgt_homework';
	 $sLimit = '10';
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $sQuery = "
	   SELECT * FROM  $sTable  WHERE homework_title LIKE '%$ssearch%' OR to_date LIKE '%$ssearch%'"; 
	   }
	   else
	   {
	   $sQuery = "SELECT * FROM $sTable";
	   }
	
		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  
		  $wpdb->get_results(" SELECT * FROM $sTable"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  
		  $wpdb->get_results(" SELECT * FROM $sTable ");
		  $iTotal = $wpdb->num_rows;

		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
 
		 foreach($rResult as $aRow)
		 {
			 
			if(isset($aRow['section_id']) && $aRow['section_id']!=0)
			{
			 $section_name=smgt_get_section_name($aRow['section_id']); 
			}
			else
			{
			   $section_name='No Section';
			}
			$row[0] = '<input type="checkbox" class="select-checkbox" name="id[]" value='.$aRow['homework_id'].'">';
			$row[1]=$aRow['homework_title'];
			$row[2]=get_class_name($aRow['class_id']);
			$row[3]=$section_name;
			$row[4]=get_single_subject_name($aRow['subject_id']);
			$row[5]=$aRow['to_date'];
			$row[6] = '
		    <a href="?page=smgt_homework&tab=addhomework&action=edit&homework_id='.$aRow['homework_id'].'" class="btn btn-info"><i class="fa fa-pencil-square-o"></i>&nbsp; '.__("Edit","school-mgt").' </a>&nbsp;&nbsp;
		    <a id="delete_selected" href="?page=smgt_homework&tab=homeworklist&action=delete&del_homework_id='.$aRow['homework_id'].'" class="btn btn-danger delete_selected" Onclick="ConfirmDelete()"><i class="fa fa-times"></i>&nbsp; '.__("Delete","school-mgt").' </a>&nbsp;&nbsp;
		    <a href="?page=smgt_homework&tab=submission&homework_id='.$aRow['homework_id'].'" class="btn btn-default"><i class="fa fa-eye"></i>&nbsp; '.__("View Submissions","school-mgt").' </a>
            ';
		    $output['aaData'][] = $row;
		 } 
 echo json_encode( $output );
 die();
}
function smgt_load_students_homework()
{
	$class_id =$_POST['class_list'];
    global $wpdb;
	$exlude_id = smgt_approve_student_list();
	$retrieve_data = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
	$resoinse=array();
	$student="";
	$sections="";
	$subjects="";
	foreach($retrieve_data as $users)
	{
		$student.="<option value=".$users->id.">".$users->first_name." ".$users->last_name."</option>";
	}
		$resoinse[0]=$student;
		/*---------SECTION-------------*/
		$retrieve_data=smgt_get_class_sections($class_id);

		$defaultmsg=__( 'Select Class Section' , 'school-mgt');

		$sections="<option value=''>".$defaultmsg."</option>";	

		foreach($retrieve_data as $section)
		{
			$teacher_access = get_option( 'smgt_access_right_teacher');
			$teacher_access_data=$teacher_access['teacher'];
			foreach($teacher_access_data as $key=>$value)
			{
				if($key=='student')
				{
					$data=$value;
				}
			}
			if($data['own_data']=='1' && smgt_get_roles(get_current_user_id())=='teacher')
			{
				$section=smgt_get_section($section);
			}
			$sections.="<option value='".$section->id."'>".$section->section_name."</option>";
		}
		$resoinse[1]=$sections;
		/*----------subjects--------------*/
		$table_name = $wpdb->prefix . "subject";
		$user_id=get_current_user_id();
		//------------------------TEACHER ACCESS---------------------------------//
		$teacher_access = get_option( 'smgt_access_right_teacher');
		$teacher_access_data=$teacher_access['teacher'];
		foreach($teacher_access_data as $key=>$value)
		{
			if($key=='subject')
			{
				$data=$value;
			}
		}
		if(smgt_get_roles($user_id)=='teacher' && $data['own_data']=='1')
		{
			$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name where  teacher_id=$user_id and class_id=".$class_id);
		}
		else
		{
			$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id=".$class_id);
		}
		$defaultmsg=__( 'Select subject' , 'school-mgt');
		$subjects="<option value=''>".$defaultmsg."</option>";	
		foreach($retrieve_subject as $retrieved_data)
		{
			$subjects.="<option value=".$retrieved_data->subid."> ".$retrieved_data->sub_name ."</option>";
		}
		$resoinse[2]=$subjects;
		echo json_encode($resoinse);
		die();
}
function smgt_load_sections_students_homework()
{
	global $wpdb;
	$resoinse=array();
	$student="";
	$subjects="";
	$section_id =$_POST['section_id'];
	$exlude_id = smgt_approve_student_list();
	$retrieve_data = get_users(array('meta_key' => 'class_section', 'meta_value' => $section_id,'role'=>'student','exclude'=>$exlude_id));
	foreach($retrieve_data as $users)
	{
		$student.="<option value=".$users->id.">".$users->first_name." ".$users->last_name."</option>";
	}
	$resoinse[0]=$student;
	/*----------subjects--------------*/
	$table_name = $wpdb->prefix . "subject";
	$user_id=get_current_user_id();
	//------------------------TEACHER ACCESS---------------------------------//
		$teacher_access = get_option( 'smgt_access_right_teacher');
		$teacher_access_data=$teacher_access['teacher'];
		foreach($teacher_access_data as $key=>$value)
		{
			if($key=='subject')
			{
				$data=$value;
			}
		}
	if(smgt_get_roles($user_id)=='teacher' && $data['own_data']=='1')
	{
		$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name where  teacher_id=$user_id and class_id=".$class_id);
	}
	else
	{
		$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE section_id=".$section_id);
	}
	$defaultmsg=__( 'Select subject' , 'school-mgt');
	$subjects="<option value=''>".$defaultmsg."</option>";	
	foreach($retrieve_subject as $retrieved_data)
	{
		$subjects.="<option value=".$retrieved_data->subid."> ".$retrieved_data->sub_name ."</option>";
	}
	$resoinse[1]=$subjects;
	echo json_encode($resoinse);
	die();
}
function insert_exam_reciept($user_id,$exam_hall,$exam_id)
{
	$current_user=get_current_user_id();
	$created_date = date("Y-m-d");
	$status=1;
	$tablename="smgt_exam_hall_receipt";
	$hall_data=array('exam_id'=>MJ_smgt_onlyNumberSp_validation($exam_id),
					'user_id'=>MJ_smgt_onlyNumberSp_validation($user_id),
					'hall_id'=>MJ_smgt_onlyNumberSp_validation($exam_hall),
					'exam_hall_receipt_status'=>$status,
					'created_date'=>$created_date,
					'created_by'=>$current_user
					);
	global $wpdb;
	$table_name = $wpdb->prefix . $tablename;
	$result=$wpdb->insert($table_name, $hall_data);
			
	return $user_id;
}
add_action( 'wp_ajax_smgt_load_exam_hall_receipt_div','smgt_load_exam_hall_receipt_div');
add_action( 'wp_ajax_nopriv_smgt_load_exam_hall_receipt_div','smgt_load_exam_hall_receipt_div');

function smgt_load_exam_hall_receipt_div()
{  
 
	global $wpdb;
	$exam_data= get_exam_by_id($_REQUEST['exam_id']);
   
	$exam_id=$_REQUEST['exam_id'];
	$array_var=array();
	$start_date=$exam_data->exam_start_date;
	$end_date=$exam_data->exam_end_date; 
	$class_id=$exam_data->class_id;
	$section_id=$exam_data->section_id;
	 
	//----------- All Student Data ------------//
	$exlude_id = smgt_approve_student_list();
	if(isset($class_id) &&  $section_id!=0)
	{
		$student_data = get_users(
            array(
                'role' => 'student',
				'exclude'=>$exlude_id,
                'meta_query' => array(
                    array(
                        'key' => 'class_name',
                        'value' => $class_id,
                        'compare' => '=='
                    ),
                    array(
                        'key' => 'class_section',
                        'value' => $section_id,
                        'compare' => '=='
                    )
                )
            )
        );
		//$student_data = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'class_section', 'meta_value' => $section_id,'role'=>'student','exclude'=>$exlude_id));
	}
	else
	{
		$student_data = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
		
	}
	/* var_dump($student_data);
	die;   */
	if(!empty($student_data))
	{
		foreach($student_data as $s_id)
		{
			$student_id[]=$s_id->ID;
		}
	}
 
	//---------- Asigned Student Data --------//
	$table_name_smgt_exam_hall_receipt = $wpdb->prefix . "smgt_exam_hall_receipt";
	$student_data_asigned = $wpdb->get_results( "SELECT user_id FROM $table_name_smgt_exam_hall_receipt where exam_id=".$exam_id);
	
	if(!empty($student_data_asigned))
	{
		foreach($student_data_asigned as $s_id1)
		{
			$student_id1[]=$s_id1->user_id;
		}
	}
	if(empty($student_data_asigned))
	{
		$student_show_data=$student_id;
	}
	else
	{
		$student_show_data=array_diff($student_id,$student_id1);
	}
	  
	$array_var='<div class="main_div">
	<form name="receipt_form" action="" method="post" class="form-horizontal" id="receipt_form">
		<input type="hidden" name="exam_id" value="'.$exam_id.'">
		<div class="form-group">
			 
					<div class="table-responsive">
						<table class="table exam_hall_table" id="exam_hall_table" style="border: 1px solid #000000;text-align: center;margin-bottom: 0px;border-collapse: separate;">
							<thead>
								<tr>
									<th  style="border-top: medium none;border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;">'.__('Exam','school-mgt').'</th>
									<th  style="border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;">'.__('Class','school-mgt').'</th>							
									<th  style="border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;">'.__('Section','school-mgt').'</th>							
									<th  style="border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;">'.__('Term','school-mgt').'</th>							
									<th  style="border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;">'.__('Start Date','school-mgt').'</th>							
									<th  style="background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;">'.__('End Date','school-mgt');'</th>							
								</tr>
							</thead>
							<tfoot></tfoot>
							<tbody>';						
								$array_var.='<tr>
									<td style="border-right: 1px solid #000000;">'.$exam_data->exam_name.'</td>							
									<td style="border-right: 1px solid #000000;">'.get_class_name($exam_data->class_id);
									$array_var.='</td>
									<td style="border-right: 1px solid #000000;">';
									if($exam_data->section_id!=0)
									{ 
										$array_var.=smgt_get_section_name($exam_data->section_id); 
									}else
									{ 
										$array_var.=__('No Section','school-mgt');
									}
									$array_var.='</td>
									<td style="border-right: 1px solid #000000;">'.get_the_title($exam_data->exam_term);
									$array_var.='</td>
									<td style="border-right: 1px solid #000000;">'. smgt_getdate_in_input_box($start_date);
									$array_var.='</td>
									<td style="">'.smgt_getdate_in_input_box($end_date);
									$array_var.='</td>
								</tr>
							</tbody>
						</table>
					</div>
				 
		</div>	
		<div class="form-group">
			<label for="exam_id" class="col-md-2 col-sm-2 col-xs-12">'.__('Select Exam Hall','school-mgt').'<span class="require-field">*</span></label>
			<div class="col-md-3 col-sm-3 col-xs-12">';
				$table_name = $wpdb->prefix . "hall";
				$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name");
				$array_var.='<select name="exam_hall" class="form-control validate[required]" id="exam_hall">';
				$defaultmsg=__( 'Select Exam Hall' , 'school-mgt');
				$array_var.='<option value="">'.$defaultmsg.'</option>';	
				foreach($retrieve_subject as $retrieved_data)
				{
					// '<input type="hidden" name="hall_capacity" id="hall_capacity" value="'.$retrieved_data->hall_capacity.'">';
					$array_var.='<option id="exam_hall_capacity_'.$retrieved_data->hall_id.'" hall_capacity="'.$retrieved_data->hall_capacity.'" value="'.$retrieved_data->hall_id.'"> '.$retrieved_data->hall_name .'</option>';
				}
				$array_var.='</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<div class="row">';
					if(!empty($student_show_data) || !empty($student_data_asigned))
					{  
						$array_var.="<div class='col-md-6 col-sm-6 col-xs-12'>";
						$array_var.='<h4>'.__('Not Assign Exam Hall Student List' , 'school-mgt').'</h4>';
						if(isset($student_show_data))
						{
							$array_var.='<table id="not_approve_table" class="display exam_timelist" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" type="checkbox" /></th>
										<th>'.__('Student Name' , 'school-mgt').'</th>
										<th>'. __('Student Roll No', 'school-mgt').'</th>
									</tr>
								</thead>
								<tfoot>
									<tr>					
										<th></th>
										<th>'.__('Student Name' , 'school-mgt').'</th>
										<th>'. __('Student Roll No', 'school-mgt').'</th>
								</tfoot>
								<tbody>';
								if(!empty($student_show_data))
								{
									foreach($student_show_data as $retrieve_data)
									{
										$userdata=get_userdata($retrieve_data);
										$array_var.='<tr id="'.$retrieve_data.'">
											<td><input type="checkbox" class="select-checkbox my_check" name="id[]" dataid="'.$retrieve_data.'"  value="'.$retrieve_data.'"></td>
											<td>'.$userdata->display_name.'</td>
											<td>'.get_user_meta($retrieve_data, 'roll_id',true);
											$array_var.='</td>
										</tr>';
									}
								}
								else
								{
									$array_var.='<td class="no_data_td_remove" style="text-align:center;" colspan="3">'.__('No Student Available' , 'school-mgt').'</td>';
								}
								$array_var.='</tbody>
						</table>
							<tr> 
								<td> 
									<button type="button" class="btn btn-success assign_exam_hall" name="assign_exam_hall" id="assign_exam_hall">'.__('Assign Exam Hall', 'school-mgt').'</button>
								</td>
							</tr>';
						}
					$array_var.='</div>';
					$array_var.="<div class='col-md-6 col-sm-6 col-xs-12'>";
						$array_var.='<h4>'.__('Assign Exam Hall Student List' , 'school-mgt').'</h4>';
						if(isset($student_data_asigned))
						{  
							$array_var.='<table id="approve_table" class="display exam_timelist" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th></th>
										<th>'.__('Student Name' , 'school-mgt').'</th>
										<th>'. __('Student Roll No', 'school-mgt').'</th>
									</tr>
								</thead>
								<tfoot>
									<tr>					
										<th></th>
										<th>'.__('Student Name' , 'school-mgt').'</th>
										<th>'. __('Student Roll No', 'school-mgt').'</th>
								</tfoot>
								<tbody>';	
								if(!empty($student_data_asigned))
								{
									foreach($student_data_asigned as $retrieve_data1)
									{
										$userdata=get_userdata($retrieve_data1->user_id);
										$array_var.='<tr id="'.$retrieve_data1->user_id.'">
										<td><a class="delete_receipt_record badge badge-delete" href="#" dataid="'.$retrieve_data1->user_id.'"  id='.$retrieve_data1->user_id.'>X</a></td>
										<td>'.$userdata->display_name.'</td>
										<td>'.get_user_meta($retrieve_data1->user_id, 'roll_id',true);
										$array_var.='</td>
									</tr>';
									}
								}
								else
								{
									$array_var.='<td  class="no_data_td_remove1" style="text-align:center;" colspan="3">'.__('No Student Available' , 'school-mgt').'</td>';
								}
								$array_var.='</tbody>
						</table>
							<tr>
								<td>
									<button type="submit" class="btn btn-success" name="send_mail_exam_receipt" id="send_mail_exam_receipt">'.__('Send Mail', 'school-mgt').'</button>
								</td>
							</tr>';
						}
					$array_var.='</div>';
					}
					else
					{
						$array_var.='<div><h4 class="text-danger">'.__('No Student Available', 'school-mgt').'</h4></div>';
					}
				$array_var.='</div>
			</div>
		</div>
	</form>
</div>';	 
		$data[]=$array_var;
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_smgt_delete_receipt_record','smgt_delete_receipt_record');
add_action( 'wp_ajax_nopriv_smgt_delete_receipt_record','smgt_delete_receipt_record');
function smgt_delete_receipt_record()
{
	$array_var=array();
	$id=$_POST['record_id'];
	$exam_id=$_POST['exam_id'];
	global $wpdb;
	$table_name_smgt_exam_hall_receipt = $wpdb->prefix . "smgt_exam_hall_receipt";
	$user_id = $wpdb->query("Delete from $table_name_smgt_exam_hall_receipt where exam_id=$exam_id and user_id=".$id);
	 //$lastInsertId = $wpdb->insert_id;  
	if($user_id)
	{
		$userdata=get_userdata($id);
		$array_var.='<tr id="'.$id.'">
			<td><input type="checkbox" class="select-checkbox my_check" name="id[]" dataid="'.$id.'"  value="'.$id.'"></td>
			<td>'.$userdata->display_name.'</td>
			<td>'.get_user_meta($id, 'roll_id',true);
			$array_var.='</td>
		</tr>';
	}
	$data[]=$array_var;
	echo json_encode($data);
	die();
}

add_action( 'wp_ajax_smgt_add_receipt_record','smgt_add_receipt_record');
add_action( 'wp_ajax_nopriv_smgt_add_receipt_record','smgt_add_receipt_record');
function smgt_add_receipt_record()
{
	$array_var=array();
	$user_id_array=$_POST['id_array'];
	$exam_hall=$_POST['exam_hall'];
	$exam_id=$_POST['exam_id'];
	if(!empty($user_id_array))
	{
		// if (count($user_id_array) >= $exam_hall_data->hall_capacity)
		// {
		// 	esc_html_e('No Student Available', 'school-mgt');
		// }
		// else
		// {
			foreach($user_id_array as $id)
			{
				$user_id=insert_exam_reciept($id,$exam_hall,$exam_id);
				$userdata=get_userdata($user_id);

				if($user_id)
				{
					$array_var.='<tr id="'.$user_id.'">
						<td><a class="delete_receipt_record badge badge-delete" href="#" id='.$user_id.'>X</a></td>
						<td>'.$userdata->display_name.'</td>
						<td>'.get_user_meta($user_id, 'roll_id',true);
						$array_var.='</td>
					</tr>';

				}
			} 
		// }
	}
	$data[]=$array_var;
	echo json_encode($data);
	// echo count($user_id_array);
	die();
}
function smgt_student_exam_receipt_check($student_id)
{
	global $wpdb;
	$table_name_smgt_exam_hall_receipt = $wpdb->prefix . "smgt_exam_hall_receipt";
	$result = $wpdb->get_results("Select * from $table_name_smgt_exam_hall_receipt where user_id=".$student_id);
	return $result;
}

//-------------------- PRINT EXAM RECEIPT -----------------------//
 
function smgt_print_exam_receipt()
{
/* 	var_dump($_REQUEST);
	die; */
	if(isset($_REQUEST['student_exam_receipt']) && $_REQUEST['student_exam_receipt'] == 'student_exam_receipt')
	{
		?>
<script>window.onload = function(){ window.print(); };</script>
<?php 
		smgt_student_exam_receipt_print($_REQUEST['student_id'],$_REQUEST['exam_id']);
		exit;
	}			
}
add_action('init','smgt_print_exam_receipt');
function smgt_student_exam_receipt_print($student_id,$exam_id)
{
	$student_data=get_userdata($student_id);
	
	$umetadata=get_user_image($student_id);
	
	$exam_data= get_exam_by_id($exam_id);
	
	$exam_hall_data=smgt_get_exam_hall_name($student_id,$exam_id);
	$exam_hall_name=smgt_get_hall_name($exam_hall_data->hall_id);
	
	$obj_exam=new smgt_exam;
	$exam_time_table=$obj_exam->get_exam_time_table_by_exam($_REQUEST['exam_id']);
  
?>
<style>
 table, .header, span.sign {
    font-family: sans-serif;
    font-size: 12px;
    color: #444;
}
.borderpx {
    border: 1px solid #97C4E7;
}
.count td, .count th {
    padding-left: 10px;
    height: 40px;
}
.resultdate {
    float: left;
    width: 200px;
    padding-top: 100px;
    text-align: center;
}
.signature {
    float: right;
    width: 200px;
    padding-top: 100px;
    text-align: center;
}
.exam_receipt_print{
	width: 90%;
	margin:0 auto;
}
.header_logo{
	float:left;
	width: 100%;
	text-align:center;
}
.font_22
{
	font-size:22px;
}
.Examination_header
{
	float:left; 
	width: 100%;
	font-size:18px;
	text-align:center;
	padding-bottom: 20px;
}
.Examination_header_color{
	color:#970606;
}
.float_width
{
	float:left; 
	width: 100%;
}
.padding_top_20
{
	padding-top:20px;
}
.img_td
{
	text-align:center;
	border-right : 1px solid #97C4E7;
}
.border_bottom{
	border-bottom : 1px solid #97C4E7;
}
.border_bottom_0{
	border-bottom : 0px;
}
.border_bottom_rigth{
	border-bottom : 1px solid #97C4E7;
	border-right : 1px solid #97C4E7;
}
.border_rigth{
	border-right : 1px solid #97C4E7;
}
.main_td
{
	text-align:center;
	border-bottom : 1px solid #97C4E7;
}
.hr_color{
	color:#97C4E7;
}
.header_color{
	color:#204759;
}
.max_height_100
{
	max-height:100px;
}
</style>
		<?php	
		if (is_rtl()){
		?>
		<div class="modal-body" style="direction: rtl;">
			<div id="exam_receipt_print" class="exam_receipt_print"> 
				
				<div class="header_logo">
					<div class="header_logo"><img class="max_height_100" src="<?php echo get_option( 'smgt_school_logo' ) ?>"></div>
					<h4 class="header_logo font_22"><strong class="header_color"><?php  echo get_option( 'smgt_school_name' );?></strong></h4>
				</div>	
				<div class="header Examination_header">
					<span><strong class="Examination_header_color"><?php echo _e( 'Examination Hall Ticket', 'school-mgt' ) ;?></strong></span>
				</div>
				
				<div class="float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td rowspan="4" class="img_td">
								<?php
								if(empty($umetadata['meta_value']))
								{?>
									<img src="<?php echo get_option( 'smgt_student_thumb' ); ?>" width="100px" height="100px">
								<?php
								}
								else
								{
								?>
									<img src="<?php echo $umetadata['meta_value']; ?>" width="100px" height="100px">
								<?php
								}
								?>
								</td>
								<td colspan="2" class="border_bottom">
									<strong><?php echo _e( 'Student Name : ', 'school-mgt' ) ;?></strong><?php echo $student_data->display_name;?></a>
								</td>			
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
									<strong><?php echo _e( 'Roll No : ', 'school-mgt' ) ;?></strong><?php echo $student_data->roll_id;?>
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo _e( 'Exam Name : ', 'school-mgt' ) ;?></strong><?php echo $exam_data->exam_name;?>									
									
								</td>
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
								<strong><?php echo _e( 'Class Name : ', 'school-mgt' ) ;?></strong><?php echo get_class_name($student_data->class_name);?>
									
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo _e( 'Section Name : ', 'school-mgt' ) ;?></strong>
									<?php 
										$section_name=$student_data->class_section;
										if($section_name!=""){
											echo smgt_get_section_name($section_name); 
										}
										else
										{
											_e('No Section','school-mgt');;
										}
									?> 				
								</td>
							</tr>
							<tr>
								<td class="border_rigth" align="left">
									<strong><?php echo _e( 'Start Date : ', 'school-mgt' ) ;?></strong><?php echo smgt_getdate_in_input_box($exam_data->exam_start_date);?>
								</td>
								<td class="border_bottom_0" align="left">
									<strong><?php echo _e( 'End Date : ', 'school-mgt' ) ;?></strong><?php echo smgt_getdate_in_input_box($exam_data->exam_end_date);?>	
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td class="border_bottom">
									<strong><?php echo _e( 'Examination Centre : ', 'school-mgt' ) ;?></strong>
									<?php echo $exam_hall_name;?>, <?php echo get_option( 'smgt_school_name' ) ;?>				
								</td>
							</tr>
							<tr>
								<td class="border_bottom_0">
									<strong><?php echo _e( 'Examination Centre Address : ', 'school-mgt' ) ;?></strong><?php echo get_option( 'smgt_school_address' ); ?>
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
							<tr>
								<th colspan="5" class="border_bottom">
									<?php echo _e( 'Time Table For Exam Hall', 'school-mgt' ) ;?>								
								</th>
							</tr>
							<tr>
								<th class="main_td border_rigth"><?php echo _e( 'Subject Code', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo _e( 'Subject', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo _e( 'Exam Date', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo _e( 'Exam Time', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo _e( 'Examiner Sign.', 'school-mgt' ) ;?></th>
							</tr>
						</thead>
						<tbody>
					   <?php
						if(!empty($exam_time_table))
						{
							foreach($exam_time_table  as $retrieved_data)
							{
							?>
							<tr>
								<td class="main_td border_rigth"><?php echo get_single_subject_code($retrieved_data->subject_id); ?> </td>
								<td class="main_td border_rigth"><?php echo get_single_subject_name($retrieved_data->subject_id);  ?></td>
								<td class="main_td border_rigth"><?php echo smgt_getdate_in_input_box($retrieved_data->exam_date); ?> </td>
								<?php 
								$start_time_data = explode(":", $retrieved_data->start_time);
								$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
								$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
								$start_am_pm=$start_time_data[2];
								$start_time=$start_hour.':'.$start_min.' '.$start_am_pm;
									
								$end_time_data = explode(":", $retrieved_data->end_time);
								$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
								$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
								$end_am_pm=$end_time_data[2];
								$end_time=$end_hour.':'.$end_min.' '.$end_am_pm;
								?>
								
								<td class="main_td border_rigth"><?php echo $start_time;  ?> <?php echo _e( 'To', 'school-mgt' ) ;?> <?php echo $end_time; ?></td>
								<td class="main_td border_rigth"></td>
							</tr>
								<?php 
							}
						}
						else
						{ ?>
							<tr>
								<td class="main_td" colspan="5"><?php echo _e( 'No Data Available', 'school-mgt' ) ;?> </td>
							</tr>
						<?php 
						}
					   ?>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>	
				<div class="resultdate">
					<hr color="#97C4E7">
					<span><?php echo _e( 'Student Signature', 'school-mgt' ) ;?></span>
				</div>
				<div class="signature">
					<hr color="#97C4E7">
					<span><?php echo _e( 'Authorized Signature', 'school-mgt' ) ;?></span>
				</div>
			
			</div>
		</div>
		<!---RTL ENDS-->
		<?php
		} 
		else 
		{
			?>
			<div class="modal-body">
			<div id="exam_receipt_print" class="exam_receipt_print"> 
				
				<div class="header_logo">
					<div class="header_logo"><img class="max_height_100" src="<?php echo get_option( 'smgt_school_logo' ) ?>"></div>
					<h4 class="header_logo font_22"><strong class="header_color"><?php  echo get_option( 'smgt_school_name' );?></strong></h4>
				</div>	
				<div class="header Examination_header">
					<span><strong class="Examination_header_color"><?php echo _e( 'Examination Hall Ticket', 'school-mgt' ) ;?></strong></span>
				</div>
				
				<div class="float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td rowspan="4" class="img_td">
								<?php
								if(empty($umetadata['meta_value']))
								{?>
									<img src="<?php echo get_option( 'smgt_student_thumb' ); ?>" width="100px" height="100px">
								<?php
								}
								else
								{
								?>
									<img src="<?php echo $umetadata['meta_value']; ?>" width="100px" height="100px">
								<?php
								}
								?>
								</td>
								<td colspan="2" class="border_bottom">
									<strong><?php echo _e( 'Student Name : ', 'school-mgt' ) ;?></strong><?php echo $student_data->display_name;?></a>
								</td>			
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
									<strong><?php echo _e( 'Roll No : ', 'school-mgt' ) ;?></strong><?php echo $student_data->roll_id;?>
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo _e( 'Exam Name : ', 'school-mgt' ) ;?></strong><?php echo $exam_data->exam_name;?>									
									
								</td>
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
								<strong><?php echo _e( 'Class Name : ', 'school-mgt' ) ;?></strong><?php echo get_class_name($student_data->class_name);?>
									
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo _e( 'Section Name : ', 'school-mgt' ) ;?></strong>
									<?php 
										$section_name=$student_data->class_section;
										if($section_name!=""){
											echo smgt_get_section_name($section_name); 
										}
										else
										{
											_e('No Section','school-mgt');;
										}
									?> 				
								</td>
							</tr>
							<tr>
								<td class="border_rigth" align="left">
									<strong><?php echo _e( 'Start Date : ', 'school-mgt' ) ;?></strong><?php echo smgt_getdate_in_input_box($exam_data->exam_start_date);?>
								</td>
								<td class="border_bottom_0" align="left">
									<strong><?php echo _e( 'End Date : ', 'school-mgt' ) ;?></strong><?php echo smgt_getdate_in_input_box($exam_data->exam_end_date);?>	
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td class="border_bottom">
									<strong><?php echo _e( 'Examination Centre : ', 'school-mgt' ) ;?></strong>
									<?php echo $exam_hall_name;?>, <?php echo get_option( 'smgt_school_name' ) ;?>				
								</td>
							</tr>
							<tr>
								<td class="border_bottom_0">
									<strong><?php echo _e( 'Examination Centre Address : ', 'school-mgt' ) ;?></strong><?php echo get_option( 'smgt_school_address' ); ?>
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
							<tr>
								<th colspan="5" class="border_bottom">
									<?php echo _e( 'Time Table For Exam Hall', 'school-mgt' ) ;?>								
								</th>
							</tr>
							<tr>
								<th class="main_td border_rigth"><?php echo _e( 'Subject Code', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo _e( 'Subject', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo _e( 'Exam Date', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo _e( 'Exam Time', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo _e( 'Examiner Sign.', 'school-mgt' ) ;?></th>
							</tr>
						</thead>
						<tbody>
					   <?php
						if(!empty($exam_time_table))
						{
							foreach($exam_time_table  as $retrieved_data)
							{
							?>
							<tr>
								<td class="main_td border_rigth"><?php echo get_single_subject_code($retrieved_data->subject_id); ?> </td>
								<td class="main_td border_rigth"><?php echo get_single_subject_name($retrieved_data->subject_id);  ?></td>
								<td class="main_td border_rigth"><?php echo smgt_getdate_in_input_box($retrieved_data->exam_date); ?> </td>
								<?php 
								$start_time_data = explode(":", $retrieved_data->start_time);
								$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
								$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
								$start_am_pm=$start_time_data[2];
								$start_time=$start_hour.':'.$start_min.' '.$start_am_pm;
									
								$end_time_data = explode(":", $retrieved_data->end_time);
								$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
								$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
								$end_am_pm=$end_time_data[2];
								$end_time=$end_hour.':'.$end_min.' '.$end_am_pm;
								?>
								
								<td class="main_td border_rigth"><?php echo $start_time;  ?> <?php echo _e( 'To', 'school-mgt' ) ;?> <?php echo $end_time; ?></td>
								<td class="main_td border_rigth"></td>
							</tr>
								<?php 
							}
						}
						else
						{ ?>
							<tr>
								<td class="main_td" colspan="5"><?php echo _e( 'No Data Available', 'school-mgt' ) ;?> </td>
							</tr>
						<?php 
						}
					   ?>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>	
				<div class="resultdate">
					<hr color="#97C4E7">
					<span><?php echo _e( 'Student Signature', 'school-mgt' ) ;?></span>
				</div>
				<div class="signature">
					<hr color="#97C4E7">
					<span><?php echo _e( 'Authorized Signature', 'school-mgt' ) ;?></span>
				</div>
			
			</div>
		</div>
			<?php
		}
		?>
		
	<?php 
}
 
function smgt_get_exam_hall_name($student_id,$exam_id)
{
	global $wpdb;
	$table_name_smgt_exam_hall_receipt = $wpdb->prefix . "smgt_exam_hall_receipt";
	$result = $wpdb->get_row("select * from $table_name_smgt_exam_hall_receipt where exam_id=$exam_id and user_id=".$student_id);
	return $result;
}
function smgt_get_hall_name($hall_id)
{
	global $wpdb;
	$table_name_hall = $wpdb->prefix . "hall";
	$result = $wpdb->get_row("select * from $table_name_hall where hall_id=".$hall_id);
	return $result->hall_name;
}
function smgt_get_hall_capacity($hall_id)
{
	global $wpdb;
	$table_name_hall = $wpdb->prefix . "hall";
	$result = $wpdb->get_row("select hall_capacity from $table_name_hall where hall_id=".$hall_id);
	return $result->hall_name;
}
function smgt_student_exam_receipt_pdf($student_id,$exam_id)
{
	$student_data=get_userdata($student_id);
	
	$umetadata=get_user_image($student_id);
	
	$exam_data= get_exam_by_id($exam_id);
	
	$exam_hall_data=smgt_get_exam_hall_name($student_id,$exam_id);
	$exam_hall_name=smgt_get_hall_name($exam_hall_data->hall_id);
	
	$obj_exam=new smgt_exam;
	$exam_time_table=$obj_exam->get_exam_time_table_by_exam($exam_id);
  
?>
<style>
 table, .header, span.sign {
    font-family: sans-serif;
    font-size: 12px;
    color: #444;
}
.borderpx {
    border: 1px solid #97C4E7;
}
.count td, .count th {
    padding-left: 10px;
    height: 40px;
}
.resultdate {
    float: left;
    width: 200px;
    padding-top: 100px;
    text-align: center;
}
.signature {
    float: right;
    width: 200px;
    padding-top: 100px;
    text-align: center;
}
.exam_receipt_print{
	width: 90%;
	margin:0 auto;
}
.header_logo{
	float:left;
	width: 100%;
	text-align:center;
}
.font_22
{
	font-size:22px;
}
.Examination_header
{
	float:left; 
	width: 100%;
	font-size:18px;
	text-align:center;
	padding-bottom: 20px;
}
.Examination_header_color{
	color:#970606;
}
.float_width
{
	float:left; 
	width: 100%;
}
.padding_top_20
{
	padding-top:20px;
}
.img_td
{
	text-align:center;
	border-right : 1px solid #97C4E7;
}
.border_bottom{
	border-bottom : 1px solid #97C4E7;
}
.border_bottom_0{
	border-bottom : 0px;
}
.border_bottom_rigth{
	border-bottom : 1px solid #97C4E7;
	border-right : 1px solid #97C4E7;
}
.border_rigth{
	border-right : 1px solid #97C4E7;
}
.main_td
{
	text-align:center;
	border-bottom : 1px solid #97C4E7;
}
.hr_color{
	color:#97C4E7;
}
.header_color{
	color:#204759;
}
.max_height_100
{
	max-height:100px;
}
.tr_back_color
{
	background-color:#337AB7;
}
.color_white{
	color:white;
}
</style>
		<?php
		if (is_rtl()){
		?>	
		<div class="modal-body" style="direction: rtl;">
			<div id="exam_receipt_print" class="exam_receipt_print"> 
				
				<div class="header_logo" style="">
					<div class="header_logo" style=""><img class="max_height_100" src="<?php echo get_option( 'smgt_school_logo' ) ?>"></div>
					<h4 class="header_logo font_22" style=""><strong class="header_color"><?php  echo get_option( 'smgt_school_name' );?></strong></h4>
				</div>	
				<div class="header Examination_header">
					<span><strong class="Examination_header_color"><?php echo _e( 'Examination Hall Ticket', 'school-mgt' ) ;?></strong></span>
				</div>
				
				<div class="float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td rowspan="4" class="img_td">
								<?php
								if(empty($umetadata['meta_value']))
								{?>
									<img src="<?php echo get_option( 'smgt_student_thumb' ); ?>" width="100px" height="100px">
								<?php
								}
								else
								{
								?>
									<img src="<?php echo $umetadata['meta_value']; ?>" width="100px" height="100px">
								<?php
								}
								?>
								</td>
								<td colspan="2" class="border_bottom">
									<strong><?php echo _e( 'Student Name : ', 'school-mgt' ) ;?></strong><?php echo $student_data->display_name;?></a></td>			
								</td>
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
									<strong><?php echo _e( 'Roll No : ', 'school-mgt' ) ;?></strong><?php echo $student_data->roll_id;?>
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo _e( 'Exam Name : ', 'school-mgt' ) ;?></strong><?php echo $exam_data->exam_name;?>									
									
								</td>
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
								<strong><?php echo _e( 'Class Name : ', 'school-mgt' ) ;?></strong><?php echo get_class_name($student_data->class_name);?>
									
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo _e( 'Section Name : ', 'school-mgt' ) ;?></strong>
									<?php 
										$section_name=$student_data->class_section;
										if($section_name!=""){
											echo smgt_get_section_name($section_name); 
										}
										else
										{
											_e('No Section','school-mgt');;
										}
									?> 				
								</td>
							</tr>
							<tr>
								<td class="border_rigth" align="left">
									<strong><?php echo _e( 'Start Date : ', 'school-mgt' ) ;?></strong><?php echo smgt_getdate_in_input_box($exam_data->exam_start_date);?>
								</td>
								<td class="border_bottom_0" align="left">
									<strong><?php echo _e( 'End Date : ', 'school-mgt' ) ;?></strong><?php echo smgt_getdate_in_input_box($exam_data->exam_end_date);?>	
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0" >
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td class="border_bottom">
									<strong><?php echo _e( 'Examination Centre : ', 'school-mgt' ) ;?></strong>
									<?php echo $exam_hall_name;?>, <?php echo get_option( 'smgt_school_name' ) ;?>				
								</td>
							</tr>
							<tr>
								<td class="border_bottom_0">
									<strong><?php echo _e( 'Examination Centre Address : ', 'school-mgt' ) ;?></strong><?php echo get_option( 'smgt_school_address' ); ?>
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" cellspacing ="0" cellpadding="0" class="count borderpx">
						<thead>
							<tr>
								<th colspan="5" class="border_bottom">
									<?php echo _e( 'Time Table For Exam Hall', 'school-mgt' ) ;?>								
								</th>
							</tr>
							<tr class="tr_back_color">
								<th class="main_td color_white border_rigth border_rigth"><?php echo _e( 'Subject Code', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo _e( 'Subject', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo _e( 'Exam Date', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo _e( 'Exam Time', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo _e( 'Examiner Sign.', 'school-mgt' ) ;?></th>
							</tr>
						</thead>
						<tbody>
					   <?php
						if(!empty($exam_time_table))
						{
							foreach($exam_time_table  as $retrieved_data)
							{
							?>
							<tr>
								<td class="main_td border_rigth"><?php echo get_single_subject_code($retrieved_data->subject_id); ?> </td>
								<td class="main_td border_rigth"><?php echo get_single_subject_name($retrieved_data->subject_id);  ?></td>
								<td class="main_td border_rigth"><?php echo smgt_getdate_in_input_box($retrieved_data->exam_date); ?> </td>
								<?php 
								
								$start_time_data = explode(":", $retrieved_data->start_time);
								$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
								$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
								$start_am_pm=$start_time_data[2];
								$start_time=$start_hour.':'.$start_min.' '.$start_am_pm;
									
								$end_time_data = explode(":", $retrieved_data->end_time);
								$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
								$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
								$end_am_pm=$end_time_data[2];
								$end_time=$end_hour.':'.$end_min.' '.$end_am_pm;
								?>
								<td class="main_td border_rigth"><?php echo $start_time;  ?> <?php echo _e( 'To', 'school-mgt' ) ;?> <?php echo $end_time; ?></td>
								<td class="main_td border_rigth"></td>
							</tr>
								<?php 
							}
						}
					   ?>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>	
				<div class="resultdate">
					<hr color="#97C4E7">
					<span><?php echo _e( 'Student Signature', 'school-mgt' ) ;?></span>
				</div>
				<div class="signature">
					<hr color="#97C4E7">
					<span><?php echo _e( 'Authorized Signature', 'school-mgt' ) ;?></span>
				</div>
			
			</div>
		</div>
		<!-- RTL END --->
		<?php
		}
		else {
			?>
		<div class="modal-body">
			<div id="exam_receipt_print" class="exam_receipt_print"> 
				
				<div class="header_logo" style="">
					<div class="header_logo" style=""><img class="max_height_100" src="<?php echo get_option( 'smgt_school_logo' ) ?>"></div>
					<h4 class="header_logo font_22" style=""><strong class="header_color"><?php  echo get_option( 'smgt_school_name' );?></strong></h4>
				</div>	
				<div class="header Examination_header">
					<span><strong class="Examination_header_color"><?php echo _e( 'Examination Hall Ticket', 'school-mgt' ) ;?></strong></span>
				</div>
				
				<div class="float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td rowspan="4" class="img_td">
								<?php
								if(empty($umetadata['meta_value']))
								{?>
									<img src="<?php echo get_option( 'smgt_student_thumb' ); ?>" width="100px" height="100px">
								<?php
								}
								else
								{
								?>
									<img src="<?php echo $umetadata['meta_value']; ?>" width="100px" height="100px">
								<?php
								}
								?>
								</td>
								<td colspan="2" class="border_bottom">
									<strong><?php echo _e( 'Student Name : ', 'school-mgt' ) ;?></strong><?php echo $student_data->display_name;?></a></td>			
								</td>
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
									<strong><?php echo _e( 'Roll No : ', 'school-mgt' ) ;?></strong><?php echo $student_data->roll_id;?>
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo _e( 'Exam Name : ', 'school-mgt' ) ;?></strong><?php echo $exam_data->exam_name;?>									
									
								</td>
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
								<strong><?php echo _e( 'Class Name : ', 'school-mgt' ) ;?></strong><?php echo get_class_name($student_data->class_name);?>
									
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo _e( 'Section Name : ', 'school-mgt' ) ;?></strong>
									<?php 
										$section_name=$student_data->class_section;
										if($section_name!=""){
											echo smgt_get_section_name($section_name); 
										}
										else
										{
											_e('No Section','school-mgt');;
										}
									?> 				
								</td>
							</tr>
							<tr>
								<td class="border_rigth" align="left">
									<strong><?php echo _e( 'Start Date : ', 'school-mgt' ) ;?></strong><?php echo smgt_getdate_in_input_box($exam_data->exam_start_date);?>
								</td>
								<td class="border_bottom_0" align="left">
									<strong><?php echo _e( 'End Date : ', 'school-mgt' ) ;?></strong><?php echo smgt_getdate_in_input_box($exam_data->exam_end_date);?>	
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0" >
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td class="border_bottom">
									<strong><?php echo _e( 'Examination Centre : ', 'school-mgt' ) ;?></strong>
									<?php echo $exam_hall_name;?>, <?php echo get_option( 'smgt_school_name' ) ;?>				
								</td>
							</tr>
							<tr>
								<td class="border_bottom_0">
									<strong><?php echo _e( 'Examination Centre Address : ', 'school-mgt' ) ;?></strong><?php echo get_option( 'smgt_school_address' ); ?>
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" cellspacing ="0" cellpadding="0" class="count borderpx">
						<thead>
							<tr>
								<th colspan="5" class="border_bottom">
									<?php echo _e( 'Time Table For Exam Hall', 'school-mgt' ) ;?>								
								</th>
							</tr>
							<tr class="tr_back_color">
								<th class="main_td color_white border_rigth border_rigth"><?php echo _e( 'Subject Code', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo _e( 'Subject', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo _e( 'Exam Date', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo _e( 'Exam Time', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo _e( 'Examiner Sign.', 'school-mgt' ) ;?></th>
							</tr>
						</thead>
						<tbody>
					   <?php
						if(!empty($exam_time_table))
						{
							foreach($exam_time_table  as $retrieved_data)
							{
							?>
							<tr>
								<td class="main_td border_rigth"><?php echo get_single_subject_code($retrieved_data->subject_id); ?> </td>
								<td class="main_td border_rigth"><?php echo get_single_subject_name($retrieved_data->subject_id);  ?></td>
								<td class="main_td border_rigth"><?php echo smgt_getdate_in_input_box($retrieved_data->exam_date); ?> </td>
								<?php 
								
								$start_time_data = explode(":", $retrieved_data->start_time);
								$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
								$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
								$start_am_pm=$start_time_data[2];
								$start_time=$start_hour.':'.$start_min.' '.$start_am_pm;
									
								$end_time_data = explode(":", $retrieved_data->end_time);
								$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
								$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
								$end_am_pm=$end_time_data[2];
								$end_time=$end_hour.':'.$end_min.' '.$end_am_pm;
								?>
								<td class="main_td border_rigth"><?php echo $start_time;  ?> <?php echo _e( 'To', 'school-mgt' ) ;?> <?php echo $end_time; ?></td>
								<td class="main_td border_rigth"></td>
							</tr>
								<?php 
							}
						}
					   ?>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>	
				<div class="resultdate">
					<hr color="#97C4E7">
					<span><?php echo _e( 'Student Signature', 'school-mgt' ) ;?></span>
				</div>
				<div class="signature">
					<hr color="#97C4E7">
					<span><?php echo _e( 'Authorized Signature', 'school-mgt' ) ;?></span>
				</div>
			
			</div>
		</div>
		<?php
		}
}
//Generate Room ID
function generate_room_code()
{
	global $wpdb;
	$user_tbl = $wpdb->prefix . "smgt_room";
	$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '{$user_tbl}'");
	$lastid = $last->Auto_increment; 
	$code = 'RM'.''.sprintf('00'.$lastid);
	return $code;	
}
//Generate Room ID
function generate_bed_code()
{
	global $wpdb;
	$smgt_beds = $wpdb->prefix . "smgt_beds";
	$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '{$smgt_beds}'");
	$lastid = $last->Auto_increment; 
	$code = 'BD'.''.sprintf('00'.$lastid);
	return $code;	
}
function smgt_get_hostel_name_by_id($id)
{
	global $wpdb;
	$smgt_hostel = $wpdb->prefix . "smgt_hostel";
	$result = $wpdb->get_row("SELECT * From $smgt_hostel where id=".$id);
	return $hostel_name = $result->hostel_name; 
}
function smgt_get_room_unique_id_by_id($id)
{
	global $wpdb;
	$smgt_room = $wpdb->prefix . "smgt_room";
	$result = $wpdb->get_row("SELECT * From $smgt_room where id=".$id);
	return $room_unique_id = $result->room_unique_id; 
}
function smgt_get_bed_capacity_by_id($id)
{
	global $wpdb;
	$smgt_room = $wpdb->prefix . "smgt_room";
	$result = $wpdb->get_row("SELECT * From $smgt_room where id=".$id);
	return $bed_capacity = $result->beds_capacity; 
}
function smgt_hostel_room_bed_count($id)
{
	global $wpdb;
	$smgt_beds = $wpdb->prefix . "smgt_beds";
	$result_bed=$wpdb->get_results("SELECT * FROM $smgt_beds where room_id=".$id);
	$bed_count= count($result_bed);
	return $bed_count; 
}
function smgt_hostel_room_status_check($room_id)
{
	global $wpdb;
	$smgt_room = $wpdb->prefix . "smgt_room";
	$smgt_beds = $wpdb->prefix . "smgt_beds";
	$result=$wpdb->get_results("SELECT * FROM $smgt_room where id=".$room_id);
	$final_cnt=0;
	if(!empty($result))
	{
		foreach($result as $data)
		{
			$bed_capacity=$data->beds_capacity;
			$room_id_id=$data->id;
			$result_room=$wpdb->get_results("SELECT * FROM $smgt_beds where room_id=$room_id_id and bed_status=1");
		}
		$final_cnt = count($result_room);
	}
	
	return $final_cnt;
}

//send invoice generated pdf in mail
function smgt_send_mail_receipt_pdf($emails,$subject,$message,$student_id,$exam_id)
{	
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/exam_receipt/';
	$document_path = $document_dir;
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);		
	}
	$student_data=get_userdata($student_id);
	
	$umetadata=get_user_image($student_id);
	
	$exam_data= get_exam_by_id($exam_id);
	
	$exam_hall_data=smgt_get_exam_hall_name($student_id,$exam_id);
	$exam_hall_name=smgt_get_hall_name($exam_hall_data->hall_id);
	
	$obj_exam=new smgt_exam;
	$exam_time_table=$obj_exam->get_exam_time_table_by_exam($exam_id);
	require_once SMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';
	$mpdf = new Mpdf\Mpdf;
	//$mpdf=new mPDF();
	echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/bootstrap.min.css', __FILE__).'"></link>';
  
	echo '<script  rel="javascript" src="'.plugins_url( '/assets/js/bootstrap.min.js', __FILE__).'"></script>'; 

		
	$stylesheet = file_get_contents(SMS_PLUGIN_DIR. '/assets/css/receipt_pdf_mail.css'); // Get css content
	$mpdf->WriteHTML('<html>');
	$mpdf->WriteHTML('<head>');
	$mpdf->WriteHTML('<style></style>');
	$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
	$mpdf->WriteHTML('</head>');
	$mpdf->WriteHTML('<body>');		
	//$mpdf->SetTitle('Invoice');
		$mpdf->WriteHTML('<div class="modal-body">');
			$mpdf->WriteHTML('<div id="exam_receipt_print" class="exam_receipt_print">');
				$mpdf->WriteHTML('<div class="header_logo" style="">');
					$mpdf->WriteHTML('<div class="header_logo" style=""><img class="max_height_100" src="'.get_option( 'smgt_school_logo' ).'"></div>');
					$mpdf->WriteHTML('<h4 class="header_logo font_22" style=""><strong class="header_color">'.get_option( 'smgt_school_name' ).'</strong></h4></div>');
				$mpdf->WriteHTML('<div class="header Examination_header"><span><strong class="Examination_header_color">'.__( 'Examination Hall Ticket', 'school-mgt' ).'</strong></span></div>');
				
				$mpdf->WriteHTML('<div class="float_width">');
					$mpdf->WriteHTML('<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">');
						$mpdf->WriteHTML('<thead>');
						$mpdf->WriteHTML('</thead>');
						$mpdf->WriteHTML('<tbody>');
						$mpdf->WriteHTML('<tr>');					
								$mpdf->WriteHTML('<td rowspan="4" class="img_td">');
								if(empty($umetadata['meta_value']))
								{ 
									$mpdf->WriteHTML('<img src="'.get_option( 'smgt_student_thumb' ).'" width="100px" height="100px">');
								}
								else
								{
									$mpdf->WriteHTML('<img src="'.$umetadata['meta_value'].'" width="100px" height="100px">');
								}
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td colspan="2" class="border_bottom">');
									$mpdf->WriteHTML('<strong>'.__( 'Student Name : ', 'school-mgt' ).'</strong>'.$student_data->display_name.'</td>');
								$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="border_bottom_rigth" align="left">');
									$mpdf->WriteHTML('<strong>'.__( 'Roll No : ', 'school-mgt' ).'</strong>'.$student_data->roll_id.'
								</td>');
								$mpdf->WriteHTML('<td class="border_bottom" align="left">');
									$mpdf->WriteHTML('<strong>'.__( 'Exam Name : ', 'school-mgt' ).'</strong>'.$exam_data->exam_name.'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="border_bottom_rigth" align="left">');
							$mpdf->WriteHTML('<strong>'.__( 'Class Name : ', 'school-mgt' ).'</strong>'.get_class_name($student_data->class_name).'</td>');
								$mpdf->WriteHTML('<td class="border_bottom" align="left">');
									$mpdf->WriteHTML('<strong>'.__( 'Section Name : ', 'school-mgt' ).'</strong>');
										$section_name=$student_data->class_section;
										if($section_name!=""){
											$mpdf->WriteHTML(''.smgt_get_section_name($section_name).'');
										}
										else
										{
											$mpdf->WriteHTML(''.__('No Section','school-mgt'.''));
										}
								$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="border_rigth" align="left">');
									$mpdf->WriteHTML('<strong>'.__( 'Start Date : ', 'school-mgt' ).'</strong>'.smgt_getdate_in_input_box($exam_data->exam_start_date).'</td>');
								$mpdf->WriteHTML('<td class="border_bottom_0" align="left">');
									$mpdf->WriteHTML('<strong>'.__( 'End Date : ', 'school-mgt' ).'</strong>'.smgt_getdate_in_input_box($exam_data->exam_end_date).'</td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
						$mpdf->WriteHTML('<tfoot>');
						$mpdf->WriteHTML('</tfoot>');
					$mpdf->WriteHTML('</table>');
				$mpdf->WriteHTML('</div>');
				$mpdf->WriteHTML('<div class="padding_top_20 float_width">');
					$mpdf->WriteHTML('<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0" >');
						$mpdf->WriteHTML('<thead>');
						$mpdf->WriteHTML('</thead>');
						$mpdf->WriteHTML('<tbody>');
							$mpdf->WriteHTML('<tr>');					
								$mpdf->WriteHTML('<td class="border_bottom">');
									$mpdf->WriteHTML('<strong>'.__( 'Examination Centre : ', 'school-mgt' ).'</strong>'.$exam_hall_name.','.get_option( 'smgt_school_name' ).'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="border_bottom_0">');
									$mpdf->WriteHTML('<strong>'.__( 'Examination Centre Address : ', 'school-mgt' ).'</strong>'.get_option( 'smgt_school_address' ).'</td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
						$mpdf->WriteHTML('<tfoot>');
						$mpdf->WriteHTML('</tfoot>');
					$mpdf->WriteHTML('</table>');
				$mpdf->WriteHTML('</div>');
				$mpdf->WriteHTML('<div class="padding_top_20 float_width">');
				$mpdf->WriteHTML('<table width="100%" cellspacing ="0" cellpadding="0" class="count borderpx">');
					$mpdf->WriteHTML('<thead>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th colspan="5" class="border_bottom">'.__( 'Time Table For Exam Hall', 'school-mgt' ).'</th>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr class="tr_back_color">');
								$mpdf->WriteHTML('<th class="main_td border_rigth color_white">'.__( 'Subject Code', 'school-mgt' ).'</th>');
								$mpdf->WriteHTML('<th class="main_td border_rigth color_white">'.__( 'Subject', 'school-mgt' ).'</th>');
								$mpdf->WriteHTML('<th class="main_td border_rigth color_white">'.__( 'Exam Date', 'school-mgt' ).'</th>');
								$mpdf->WriteHTML('<th class="main_td border_rigth color_white">'.__( 'Exam Time', 'school-mgt' ).'</th>');
								$mpdf->WriteHTML('<th class="main_td border_rigth color_white">'.__( 'Examiner Sign.', 'school-mgt' ).'</th>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</thead>');
						$mpdf->WriteHTML('<tbody>');
						if(!empty($exam_time_table))
						{
							foreach($exam_time_table  as $retrieved_data)
							{
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="main_td border_rigth">'.get_single_subject_code($retrieved_data->subject_id).'</td>');
								$mpdf->WriteHTML('<td class="main_td border_rigth">'.get_single_subject_name($retrieved_data->subject_id).'</td>');
								$mpdf->WriteHTML('<td class="main_td border_rigth">'.smgt_getdate_in_input_box($retrieved_data->exam_date).'</td>');
								
								$start_time_data = explode(":", $retrieved_data->start_time);
								$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
								$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
								$start_am_pm=$start_time_data[2];
								$start_time=$start_hour.':'.$start_min.' '.$start_am_pm;
								
								$end_time_data = explode(":", $retrieved_data->end_time);
								$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
								$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
								$end_am_pm=$end_time_data[2];
								$end_time=$end_hour.':'.$end_min.' '.$end_am_pm;
								$mpdf->WriteHTML('<td class="main_td border_rigth">'.$start_time.''.__( 'To', 'school-mgt' ).''.$end_time.'</td>');
								$mpdf->WriteHTML('<td class="main_td border_rigth"></td>');
							$mpdf->WriteHTML('</tr>');
							}
						}
						$mpdf->WriteHTML('</tbody>');
						$mpdf->WriteHTML('<tfoot>');
						$mpdf->WriteHTML('</tfoot>');
					$mpdf->WriteHTML('</table>');
			$mpdf->WriteHTML('</div>');
				$mpdf->WriteHTML('<div class="resultdate"><hr color="#97C4E7"><span>'.__( 'Student Signature', 'school-mgt' ).'</span></div>');
				$mpdf->WriteHTML('<div class="signature"><hr color="#97C4E7"><span>'.__( 'Authorized Signature', 'school-mgt' ).'</span></div>');
			$mpdf->WriteHTML('</div>');
		$mpdf->WriteHTML('</div>');
			
	$mpdf->WriteHTML('</body>');
	$mpdf->WriteHTML('</html>');	
	$mpdf->Output($document_path.'exam receipt'.$student_id.'.pdf','F');
	$mail_attachment = array($document_path.'exam receipt'.$student_id.'.pdf'); 
	
	$school=get_option('smgt_school_name');
	$headers="";
	$headers .= 'From: '.$school.' <noreplay@gmail.com>' . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
	if(get_option('smgt_mail_notification') == '1')
	{
		wp_mail($emails,$subject,$message,$headers,$mail_attachment);
	}			
	unlink($document_path.'exam receipt'.$student_id.'.pdf');
}
function smgt_student_assign_bed_data($id)
{
	global $wpdb;
	$table_smgt_assign_beds=$wpdb->prefix.'smgt_assign_beds';
	$result=$wpdb->get_row("SELECT * FROM $table_smgt_assign_beds where bed_id=".$id);
	return $result;
}
function get_room_unique_id_by_room_id($room_id)
{
	global $wpdb;
	$table_smgt_room=$wpdb->prefix.'smgt_room';
	$result=$wpdb->get_row("SELECT * FROM $table_smgt_room where id=".$room_id);
	return $result->room_unique_id;
}
function smgt_hostel_name_by_id($hostel_id)
{
	global $wpdb;
	$table_smgt_hostel=$wpdb->prefix.'smgt_hostel';
	$result=$wpdb->get_row("SELECT * FROM $table_smgt_hostel where id=".$hostel_id);
	return $result->hostel_name;
}
function smgt_all_assign_student_data()
{
	global $wpdb;
	$table_smgt_assign_beds=$wpdb->prefix.'smgt_assign_beds';
	$result=$wpdb->get_results("SELECT * FROM $table_smgt_assign_beds");
	return $result;
}
function send_message_check_single_user_or_multiple($post_id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$sent_message =$wpdb->get_var("SELECT COUNT(*) FROM $tbl_name where post_id = $post_id ");
	return $sent_message;
}
//-------------------- VIEW PAGE POPUP -----------------------//

add_action( 'wp_ajax_smgt_view_details_popup','smgt_view_details_popup');
add_action( 'wp_ajax_nopriv_smgt_view_details_popup','smgt_view_details_popup');
//VIEW DETAILS POPUP FUNCTION
function smgt_view_details_popup()
{	?>
<style>
.table td, .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 15px !important;
}
</style>
<?php

	$recoed_id = $_REQUEST['record_id'];
	$type= $_REQUEST['type'];
	 
	if($type == 'transport_view')
	{ 		
		$transport_data= get_transport_by_id($recoed_id);
		?>
		<div class="form-group"> 	
			<a href="#" class="close-btn badge badge-success pull-right">X</a>
			<h4 class="modal-title" id="myLargeModalLabel">
				<?php _e('Transport Details','school-mgt'); ?>
			</h4>
		</div>
		<hr>		
		<div class="panel-body view_details_popup_body">
			<table id="transport_list" class="table table-striped" cellspacing="0" width="100%" align="center">
				<tbody>
					<tr>
						<td width="40%">
							<b><?php _e('Route Name','school-mgt'); ?></b> : 
						</td>
						<td width="60%">
							<?php echo $transport_data->route_name; ?>
						</td>
					</tr>
					<tr>
						<td width="40%">
							<b><?php _e('Vehicle Identifier','school-mgt'); ?></b> :
						</td>
						<td width="60%">
							<?php echo $transport_data->number_of_vehicle; ?>
						</td>
					</tr>
					<tr>
						<td width="40%">
							<b><?php _e('Vehicle Registration Number','school-mgt'); ?></b> :
						</td>
                        <td width="60%">
							<?php echo $transport_data->vehicle_reg_num; ?>
						</td>						
					</tr>
			 
				<tr>
					<td width="40%">
						<b><?php _e('Driver Name','school-mgt'); ?></b> :
					</td>
					<td width="70%">
							<?php echo $transport_data->driver_name; ?>
					</td>
				</tr>	
				 
				<tr>
					<td width="40%">
						<b><?php _e('Driver Phone Number','school-mgt'); ?></b> :
					</td>
					<td width="60%">
							<?php echo $transport_data->driver_phone_num; ?>
					</td>
				</tr>	
				<tr>
					<td width="40%">
						<b><?php _e('Driver Address','school-mgt'); ?></b> :
					</td>
					<td width="60%">
						<?php echo $transport_data->driver_address; ?>
					</td>
				</tr>
				<tr>
					<td width="40%">
						<b><?php _e('Route fare','school-mgt'); ?></b> :
					</td>
					<td width="60%">
						<?php echo "<span> ". get_currency_symbol() ." </span>" . number_format($transport_data->route_fare,2); ?>
					</td>
				</tr>
				
				<tr>
					<td width="40%">
						<b><?php _e('Route Description','school-mgt'); ?></b> : 
					</td>
					<td width="60%">
						<?php if(!empty($transport_data->route_description)) { echo $transport_data->route_description; } else { echo "-";} ?>
					</td>
				</tr>
				</tbody>
			</table>
			</div>
		</div>	
	<?php 
	}
	elseif($type == 'booklist_view')
	{ 	
		$obj_lib = new Smgtlibrary();	
		$book_data=$obj_lib->get_single_books($recoed_id);
		?>
		<div class="form-group"> 	
			<a href="#" class="close-btn badge badge-success pull-right">X</a>
			<h4 class="modal-title" id="myLargeModalLabel">
				<?php _e('Book Details','school-mgt'); ?>
			</h4>
		</div>
		<hr>		
		<div class="panel-body view_details_popup_body">
			<table id="transport_list" class="table table-striped" cellspacing="0" width="100%" align="center">
				<tbody>
					<tr>
						<td>
							<b><?php _e('ISBN','school-mgt'); ?></b> : &nbsp;
							<?php echo $book_data->ISBN; ?>
						</td>
					</tr>
					<tr>
						<td>
							<b><?php _e('Book Name','school-mgt'); ?></b> : &nbsp;
							<?php 					
								echo $book_data->book_name;
							?>
						</td>
					</tr>
					<tr>
						<td>
							<b><?php _e('Book Category','school-mgt'); ?></b> : &nbsp;
							<?php 					
								echo get_the_title($book_data->cat_id);
							?>
						</td>
					</tr>
					<tr>
						<td>
							<b><?php _e('Author Name','school-mgt'); ?></b> : &nbsp;
							<?php echo $book_data->author_name; ?>	
						</td>							
					</tr>
			 
				<tr>
					<td>
						<b><?php _e('Rack Location','school-mgt'); ?></b> : &nbsp;
						<?php echo get_the_title($book_data->rack_location); ?>
					</td>
				</tr>	
				 
				<tr>
					<td>
						<b><?php _e('Price','school-mgt'); ?></b> : &nbsp;
						<?php echo "<span> ". get_currency_symbol() ." </span>" . number_format($book_data->price,2); ?>
					</td>
				</tr>	
				<tr>
					<td>
						<b><?php _e('Quantity','school-mgt'); ?></b> : &nbsp;
						<?php echo $book_data->quentity;?>
					</td>
				</tr>
				 
				<tr>
					<td>
						<b><?php _e('Description','school-mgt'); ?></b> : &nbsp;
						<?php if(!empty($book_data->description)) { echo $book_data->description; } else { echo "-";} ?>
					</td>
				</tr>
				</tbody>
			</table>
			</div>
		</div>	
	<?php 
	}
	die();
}
//---------- EDIT POPUP ------------//
add_action( 'wp_ajax_smgt_edit_popup_value','smgt_edit_popup_value');
add_action( 'wp_ajax_nopriv_smgt_edit_popup_value','smgt_edit_popup_value');
function smgt_edit_popup_value()
{
	
	$model = $_REQUEST['model'];
	$cat_id = $_REQUEST['cat_id'];
	 
				echo '<td><input type="text" class="validate[required,custom[popup_category_validation]]" name="category_name" maxlength="50" value="'.get_the_title($cat_id).'" id="category_name"></td>';
				echo '<td id='.$cat_id.'>
				<a class="btn-cat-update-cancel_popup btn btn-danger" model='.$model.' href="#" id='.$cat_id.'>'.__('Cancel','school-mgt').'</a>
				<a class="btn-cat-update_popup btn btn-primary" model='.$model.' href="#" id='.$cat_id.'>'.__('Save','school-mgt').'</a>
				</td>';
	die();
}
add_action( 'wp_ajax_smgt_update_cancel_popup','smgt_update_cancel_popup');
add_action( 'wp_ajax_nopriv_smgt_update_cancel_popup','smgt_update_cancel_popup');
//------------ CANCEL POPUP --------//
function smgt_update_cancel_popup()
{
	$model=$_REQUEST['model'];
	$cat_result = smgt_get_all_category( $model );	

		$i = 1;

		if(!empty($cat_result))
		{
			foreach ($cat_result as $retrieved_data)
			{
				echo '<tr id="cat_new-'.$retrieved_data->ID.'">';
				echo '<td>'.$retrieved_data->post_title.'</td>';
				echo '<td id='.$retrieved_data->ID.'><a class="btn-delete-cat_new badge badge-delete" model='.$model.' href="#" id='.$retrieved_data->ID.'>X</a><a class="btn-edit-cat_popup badge badge-edit"  model="'.$model.'" href="#" id="'.$retrieved_data->ID.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>';
				echo '</tr>';
				$i++;		
			}
		}
					 
	die();
}
//-------------------- UPDATE POPUP VALUE CATEGORY ---------//
add_action( 'wp_ajax_smgt_update_cetogory_popup_value','smgt_update_cetogory_popup_value');
add_action( 'wp_ajax_nopriv_smgt_update_cetogory_popup_value','smgt_update_cetogory_popup_value');
function smgt_update_cetogory_popup_value()
{
	$model=$_REQUEST['model'];
	$cat_id=$_REQUEST['cat_id'];
	$category_name=$_REQUEST['category_name'];
	 
		$edited_post = array(
			'ID'           => $cat_id,
			'post_title' => $category_name
		);
	$result=wp_update_post( $edited_post);
			if($model == 'smgt_bookperiod')
			{
				$row1='<td>'.get_the_title($cat_id).'Days'.'</td>';
				$row1.='<td id='.$cat_id.'><a class="btn-delete-cat_new badge badge-delete" model='.$model.' href="#" id='.$cat_id.'>X</a><a class="btn-edit-cat_popup badge badge-edit"  model="'.$model.'" href="#" id="'.$cat_id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>';
				$option = "<option value='$cat_id'>".$_REQUEST['category_name'].'Days'."</option>";
			}
			else
			{
				$row1='<td>'.get_the_title($cat_id).'</td>';
				$row1.='<td id='.$cat_id.'><a class="btn-delete-cat_new badge badge-delete" model='.$model.' href="#" id='.$cat_id.'>X</a><a class="btn-edit-cat_popup badge badge-edit"  model="'.$model.'" href="#" id="'.$cat_id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>';
				$option = "<option value='$cat_id'>".$_REQUEST['category_name']."</option>";
			}

			$array_var[] = $row1;

			$array_var[] = $option;
				
		echo json_encode($array_var);
	die();
}
//SEND SMS NOTIFICTION FUNCTION FOR MSG91 SMS//
function smgt_msg91_send_mail_function($mobiles,$message,$countary_code)
{
	$sender= get_option( 'msg91_senderID');
	$authkey= get_option('sms_auth_key');
	$route= get_option( 'wpnc_sms_route');
	 
	$curl = curl_init();
	$curl_url="http://api.msg91.com/api/sendhttp.php?route=$route&sender=$sender&mobiles=$mobiles&authkey=$authkey&encrypt=1&message=$message&country=$countary_code";
	 //$curl_url= "https://api.msg91.com/api/sendhttp.php?authkey=206167AWz6IEnWpcs5ab9fa1e&mobiles=$mobiles&country=$countary_code&message=$message&sender=TESTIN&route=4";
	 curl_setopt_array($curl, array(
	 CURLOPT_URL =>$curl_url ,
	 CURLOPT_RETURNTRANSFER => true,
	 CURLOPT_ENCODING => "",
	 CURLOPT_MAXREDIRS => 10,
	 CURLOPT_TIMEOUT => 30,
	 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	 CURLOPT_CUSTOMREQUEST => "GET",
	 CURLOPT_SSL_VERIFYHOST => 0,
	 CURLOPT_SSL_VERIFYPEER => 0,
     ));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
		echo "err";
	  echo "cURL Error #:" . $err;
	} 
}
function MJ_smgt_browser_javascript_check()
{
	$plugins_url = plugins_url( 'school-management/ShowErrorPage.php' );
?>
	<noscript><meta http-equiv="refresh" content="0;URL=<?php echo $plugins_url;?>"></noscript> 
<?php
}
//access right page not access message
function MJ_smgt_access_right_page_not_access_message()
{
	?>
	<script type="text/javascript">
		$(document).ready(function() 
		{	
			alert('<?php _e('You do not have permission to perform this operation.','hospital_mgt');?>');
			window.location.href='?dashboard=user';
		});
	</script>
<?php
}	
function get_all_transport_created_by($user_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "transport";
	return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE  created_by=".$user_id);
}
function get_all_holiday_created_by($user_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "holiday";
	return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE  created_by=".$user_id);
}
function get_all_holiday_created_by_dashboard($user_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "holiday";
	return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE  created_by=$user_id ORDER BY holiday_id DESC limit 3");
}	
add_action( 'wp_ajax_smgt_load_teacher_by_class',  'smgt_load_teacher_by_class');
add_action( 'wp_ajax_nopriv_smgt_load_teacher_by_class',  'smgt_load_teacher_by_class');
function smgt_load_teacher_by_class()
{
	$class_id =$_POST['class_list'];
	$teacherdata	= 	get_teacher_by_class_id($class_id);	
	foreach($teacherdata as $retrieved_data)
	{
		if($retrieved_data->ID != "")
		{
			echo "<option value=".$retrieved_data->ID."> ".$retrieved_data->display_name ."</option>";
		}
	}
	exit;
}
//user role wise access right array
function smgt_get_userrole_wise_access_right_array_in_api($user_id,$page_link)
{
	$school_obj = new School_Management ($user_id);	
	$role = $school_obj->role;
	if($role=='student')
	{
		$menu = get_option( 'smgt_access_right_student');
	}
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{				
			if ($page_link == $value['page_link'])
			{				
			   $menu_array1['view'] = $value['view'];
			   $menu_array1['own_data'] = $value['own_data'];
			   $menu_array1['add'] = $value['add'];
			   $menu_array1['edit'] = $value['edit'];
			   $menu_array1['delete'] = $value['delete'];
			   return $menu_array1;
			}
		}
	}	
}
// Function to get all the dates in given range 
function getDatesFromRange($start, $end) { 
      
    // Declare an empty array 
    $array = array(); 
    // Variable that store the date interval 
    // of period 1 day 
    $interval = new DateInterval('P1D'); 
  
    $realEnd = new DateTime($end); 
    $realEnd->add($interval); 
  
    $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
  
    // Use loop to store date into array 
    foreach($period as $date) {                  
        $array[] = $date->format('Y-m-d');  
    } 
  
    // Return the array elements 
    return $array; 
}
//add_action( 'authenticate', 'MJ_smgt_check_username_password', 1, 3);
function MJ_smgt_check_username_password( $login, $username, $password ) 
{
// Getting URL of the login page
$referrer = $_SERVER['HTTP_REFERER'];

// if there's a valid referrer, and it's not the default log-in screen
if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) {
    if( $username == "" || $password == "" )
    {
        wp_redirect( get_permalink( get_option('smgt_login_page') ) . "?login=empty" ); 
     exit;
    }
} 

}
//--------------- SEND PAID INVOICE PDF SEND IN MAIL --------------------//
//send invoice generated pdf in mail
function smgt_send_mail_paid_invoice_pdf($emails,$subject,$message,$fees_pay_id)
{
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/invoices/';
	$document_path = $document_dir;
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);		
	}
	$fees_detail_result = get_single_fees_payment_record($fees_pay_id);
	$fees_history_detail_result = get_payment_history_by_feespayid($fees_pay_id);

	require_once SMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';
	$mpdf = new Mpdf\Mpdf;
	//$mpdf=new mPDF();
	echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/bootstrap.min.css', __FILE__).'"></link>';
  
	echo '<script  rel="javascript" src="'.plugins_url( '/assets/js/bootstrap.min.js', __FILE__).'"></script>'; 

		
	$stylesheet = file_get_contents(SMS_PLUGIN_DIR. '/assets/css/style.css'); // Get css content
	$mpdf->WriteHTML('<html>');
	$mpdf->WriteHTML('<head>');
	$mpdf->WriteHTML('<style></style>');
	$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
	$mpdf->WriteHTML('</head>');
	$mpdf->WriteHTML('<body>');		
	//$mpdf->SetTitle('Invoice');
					$mpdf->WriteHTML('<div class="modal-body">');
				$mpdf->WriteHTML('<div id="invoice_print" class="print-box" width="100%">'); 
					$mpdf->WriteHTML('<table width="100%" border="0">');
						$mpdf->WriteHTML('<tbody>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td width="70%">');
								$mpdf->WriteHTML('<img style="max-height:80px;" src="'.get_option( 'smgt_school_logo' ).'">');
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td align="right" width="24%">');
									$mpdf->WriteHTML('<h5>');
										$issue_date='DD-MM-YYYY';
										$issue_date=$fees_detail_result->paid_by_date;						
										$mpdf->WriteHTML(''.__('Issue Date','school-mgt')." : ".smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))).'</h5>');
										$mpdf->WriteHTML('<h5>');
										$payment_status = get_payment_status($fees_detail_result->fees_pay_id);	
										$mpdf->WriteHTML(''.__('status','school-mgt')." : ".$payment_status.'</h5>');
								$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
					$mpdf->WriteHTML('<hr class="hr_margin_new">');
					$mpdf->WriteHTML('<table width="100%" border="0">');
						$mpdf->WriteHTML('<tbody>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="col-md-6">');
									$mpdf->WriteHTML('<h4>');
									$mpdf->WriteHTML(''.__('Payment From','school-mgt').'');
									$mpdf->WriteHTML('</h4>');
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td class="col-md-6 pull-right" style="text-align: right;">');
									$mpdf->WriteHTML('<h4>');
									$mpdf->WriteHTML(''.__('Bill To','school-mgt').'');
									 $mpdf->WriteHTML('</h4>');
								$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td valign="top"class="col-md-6">');
									$mpdf->WriteHTML(''.get_option( 'smgt_school_name')."<br>".'');
									$mpdf->WriteHTML(''.get_option( 'smgt_school_address' ).",".'');
									$mpdf->WriteHTML(''.get_option( 'smgt_contry' )."<br>".''); 
									$mpdf->WriteHTML(''.get_option( 'smgt_contact_number' )."<br>".'');
								
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td valign="top" class="col-md-6" style="text-align: right;">');

									$student_id=$fees_detail_result->student_id;						
									$patient=get_userdata($student_id);									
									 $mpdf->WriteHTML(''.$patient->display_name."<br>".'');
									  $mpdf->WriteHTML('Student ID '.'<b>'.get_user_meta( $student_id,'roll_id',true )."</b><br>".'');
									 $mpdf->WriteHTML(''.get_user_meta( $student_id,'address',true ).",".'');
									 $mpdf->WriteHTML(''.get_user_meta( $student_id,'city',true )."<br>".'');
									 $mpdf->WriteHTML(''.get_user_meta( $student_id,'zip_code',true )."<br>".'');
									  $mpdf->WriteHTML(''.get_user_meta( $student_id,'state',true ).",".'');
									 $mpdf->WriteHTML(''.get_option( 'smgt_contry' ).",".'');
									  $mpdf->WriteHTML(''.get_user_meta( $student_id,'mobile',true )."<br>".'');
								 $mpdf->WriteHTML('</td>');
							 $mpdf->WriteHTML('</tr>');
						 $mpdf->WriteHTML('</tbody>');
					 $mpdf->WriteHTML('</table>');
					 $mpdf->WriteHTML('<hr class="hr_margin_new">');
					 $mpdf->WriteHTML('<div class="table-responsive">');
						 $mpdf->WriteHTML('<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">');
							 $mpdf->WriteHTML('<thead>');
								 $mpdf->WriteHTML('<tr>');
									 $mpdf->WriteHTML('<th class="text-center padding_10">#</th>');
									 $mpdf->WriteHTML('<th class="text-center padding_10">'.__('Fees Type','school-mgt').'</th>');
									 $mpdf->WriteHTML('<th class="padding_10">'.__('Total','school-mgt').'</th>');	
								 $mpdf->WriteHTML('</tr>');
							 $mpdf->WriteHTML('</thead>');
							 $mpdf->WriteHTML('<tbody>');
							 $mpdf->WriteHTML('<tr>');
								 $mpdf->WriteHTML('<td class="text-center">1</td>');
								 $mpdf->WriteHTML('<td class="text-center">');
								$mpdf->WriteHTML(''.get_fees_term_name($fees_detail_result->fees_id).'</td>');
								$mpdf->WriteHTML('<td>');
								$mpdf->WriteHTML('<span>'.get_currency_symbol().'</span>'.number_format($fees_detail_result->total_amount,2).'</td>');
								 $mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('</tbody>');
						$mpdf->WriteHTML('</table>');
					$mpdf->WriteHTML('</div>');
					$mpdf->WriteHTML('<table width="100%" border="0">');
						$mpdf->WriteHTML('<tbody>');						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td  align="right">'.__('Sub Total : ','school-mgt').'</td>');
								$mpdf->WriteHTML('<td align="right">'.get_currency_symbol().number_format($fees_detail_result->total_amount,2).'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td width="80%" align="right">'.__('Payment Made :','school-mgt').'</td>');
								$mpdf->WriteHTML('<td align="right">'.get_currency_symbol().number_format($fees_detail_result->fees_paid_amount,2).'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td width="80%" align="right">'.__('Due Amount :','school-mgt').'</td>');
								$Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount;
								$mpdf->WriteHTML('<td align="right">'.get_currency_symbol().number_format($Due_amount,2).'</td>');
							$mpdf->WriteHTML('</tr>');			
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
					$mpdf->WriteHTML('<hr class="hr_margin_new">');
					if(!empty($fees_history_detail_result))
					{ 
					$mpdf->WriteHTML('<h4>'.__('Payment History','school-mgt').'</h4>');
					$mpdf->WriteHTML('<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">');
						$mpdf->WriteHTML('<thead>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="text-center padding_10">'.__('Date','school-mgt').'</th>');
								$mpdf->WriteHTML('<th class="text-center padding_10">'.__('Amount','school-mgt').'</th>');
								$mpdf->WriteHTML('<th class="padding_10">'.__('Method','school-mgt').'</th>');
								
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</thead>');
						$mpdf->WriteHTML('<tbody>');
							foreach($fees_history_detail_result as  $retrive_date)
							{
							
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="text-center">'.smgt_getdate_in_input_box($retrive_date->paid_by_date).'</td>');
								$mpdf->WriteHTML('<td class="text-center">'.get_currency_symbol() .number_format($retrive_date->amount,2).'</td>');
								$mpdf->WriteHTML('<td>'.$retrive_date->payment_method.'</td>');
							$mpdf->WriteHTML('</tr>');
							}
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
					}
				$mpdf->WriteHTML('</div>');		
			$mpdf->WriteHTML('</div>');
			
	$mpdf->WriteHTML('</body>');
	$mpdf->WriteHTML('</html>');	
	$mpdf->Output($document_path.'invoice.pdf','F');
	$mail_attachment = array($document_path.'invoice.pdf'); 
	
	$school=get_option('smgt_school_name');
	$headers="";
	$headers .= 'From: '.$school.' <noreplay@gmail.com>' . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
	if(get_option('smgt_mail_notification') == '1')
	{
		wp_mail($emails,$subject,$message,$headers,$mail_attachment);
	}			
	unlink($document_path.'invoice.pdf');
}
//--------------- SEND INVOICE TRANSLATE PDF LINK --------------------//
//send invoice translate pdf link
function smgt_api_translate_invoice_pdf($id,$student)
{
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/translate_invoice_pdf/';
	$document_path = $document_dir;
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);		
	}
	$fees_pay_id = $id;
	$fees_detail_result = get_single_fees_payment_record($fees_pay_id);
	$fees_history_detail_result = get_payment_history_by_feespayid($payment_id);
	require_once SMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';
	$mpdf = new Mpdf\Mpdf;
	$mpdf->autoScriptToLang = true;
	$mpdf->autoLangToFont = true;
	//$mpdf=new mPDF();
	echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/bootstrap.min.css', __FILE__).'"></link>';
	echo '<script  rel="javascript" src="'.plugins_url( '/assets/js/bootstrap.min.js', __FILE__).'"></script>'; 		
	$stylesheet = file_get_contents(SMS_PLUGIN_DIR. '/assets/css/style.css'); // Get css content
	$mpdf->WriteHTML('<html>');
	$mpdf->WriteHTML('<head>');
	$mpdf->WriteHTML('<style></style>');
	$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
	$mpdf->WriteHTML('</head>');
	$mpdf->WriteHTML('<body>');		
	//$mpdf->SetTitle('Invoice');
					$mpdf->WriteHTML('<div class="modal-body">');
				$mpdf->WriteHTML('<div id="invoice_print" class="print-box" width="100%">'); 
					$mpdf->WriteHTML('<table width="100%" border="0">');
						$mpdf->WriteHTML('<tbody>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td width="70%">');
								$mpdf->WriteHTML('<img style="max-height:80px;" src="'.get_option( 'smgt_school_logo' ).'">');
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td align="right" width="24%">');
									$mpdf->WriteHTML('<h5>');
										$issue_date='DD-MM-YYYY';
										$issue_date=$fees_detail_result->paid_by_date;						
										$mpdf->WriteHTML(''.__('Issue Date','school-mgt')." : ".smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))).'</h5>');
										$mpdf->WriteHTML('<br>');
										$mpdf->WriteHTML('<h5>');
										$payment_status = get_payment_status($fees_detail_result->fees_pay_id);	
										$mpdf->WriteHTML(''.__('status','school-mgt')." : ".$payment_status.'</h5>');
								$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
					$mpdf->WriteHTML('<hr class="hr_margin_new">');
					$mpdf->WriteHTML('<table width="100%" border="0">');
						$mpdf->WriteHTML('<tbody>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="col-md-6">');
									$mpdf->WriteHTML('<h4>');
									$mpdf->WriteHTML(''.__('Payment From','school-mgt').'');
									$mpdf->WriteHTML('</h4>');
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td class="col-md-6 pull-right" style="text-align: right;">');
									$mpdf->WriteHTML('<h4>');
									$mpdf->WriteHTML(''.__('Bill To','school-mgt').'');
									 $mpdf->WriteHTML('</h4>');
								$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td valign="top"class="col-md-6">');
									$mpdf->WriteHTML(''.get_option( 'smgt_school_name')."<br>".'');
									$mpdf->WriteHTML(''.get_option( 'smgt_school_address' ).",".'');
									$mpdf->WriteHTML(''.get_option( 'smgt_contry' )."<br>".''); 
									$mpdf->WriteHTML(''.get_option( 'smgt_contact_number' )."<br>".'');
								
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td valign="top" class="col-md-6" style="text-align: right;">');

									$student_id=$fees_detail_result->student_id;						
									$patient=get_userdata($student_id);									
									 $mpdf->WriteHTML(''.$patient->display_name."<br>".'');
									  $mpdf->WriteHTML('Student ID '.'<b>'.get_user_meta( $student_id,'roll_id',true )."</b><br>".'');
									 $mpdf->WriteHTML(''.get_user_meta( $student_id,'address',true ).",".'');
									 $mpdf->WriteHTML(''.get_user_meta( $student_id,'city',true )."<br>".'');
									 $mpdf->WriteHTML(''.get_user_meta( $student_id,'zip_code',true )."<br>".'');
									  $mpdf->WriteHTML(''.get_user_meta( $student_id,'state',true ).",".'');
									 $mpdf->WriteHTML(''.get_option( 'smgt_contry' ).",".'');
									  $mpdf->WriteHTML(''.get_user_meta( $student_id,'mobile',true )."<br>".'');
								 $mpdf->WriteHTML('</td>');
							 $mpdf->WriteHTML('</tr>');
						 $mpdf->WriteHTML('</tbody>');
					 $mpdf->WriteHTML('</table>');
					 $mpdf->WriteHTML('<hr class="hr_margin_new">');
					 $mpdf->WriteHTML('<div class="table-responsive">');
						 $mpdf->WriteHTML('<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">');
							 $mpdf->WriteHTML('<thead>');
								 $mpdf->WriteHTML('<tr>');
									 $mpdf->WriteHTML('<th class="text-center padding_10">#</th>');
									 $mpdf->WriteHTML('<th class="text-center padding_10">'.__('Fees Type','school-mgt').'</th>');
									 $mpdf->WriteHTML('<th class="padding_10">'.__('Total','school-mgt').'</th>');	
								 $mpdf->WriteHTML('</tr>');
							 $mpdf->WriteHTML('</thead>');
							 $mpdf->WriteHTML('<tbody>');
							 $mpdf->WriteHTML('<tr>');
								 $mpdf->WriteHTML('<td class="text-center">1</td>');
								 $mpdf->WriteHTML('<td class="text-center">');
								$mpdf->WriteHTML(''.get_fees_term_name($fees_detail_result->fees_id).'</td>');
								$mpdf->WriteHTML('<td>');
								$mpdf->WriteHTML('<span>'.get_currency_symbol().'</span>'.number_format($fees_detail_result->total_amount,2).'</td>');
								 $mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('</tbody>');
						$mpdf->WriteHTML('</table>');
					$mpdf->WriteHTML('</div>');
					$mpdf->WriteHTML('<table width="100%" border="0">');
						$mpdf->WriteHTML('<tbody>');						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td  align="right">'.__('Sub Total : ','school-mgt').'</td>');
								$mpdf->WriteHTML('<td align="right">'.get_currency_symbol().number_format($fees_detail_result->total_amount,2).'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td width="80%" align="right">'.__('Payment Made :','school-mgt').'</td>');
								$mpdf->WriteHTML('<td align="right">'.get_currency_symbol().number_format($fees_detail_result->fees_paid_amount,2).'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td width="80%" align="right">'.__('Due Amount :','school-mgt').'</td>');
								$Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount;
								$mpdf->WriteHTML('<td align="right">'.get_currency_symbol().number_format($Due_amount,2).'</td>');
							$mpdf->WriteHTML('</tr>');			
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
					$mpdf->WriteHTML('<hr class="hr_margin_new">');
					if(!empty($fees_history_detail_result))
					{ 
					$mpdf->WriteHTML('<h4>'.__('Payment History','school-mgt').'</h4>');
					$mpdf->WriteHTML('<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">');
						$mpdf->WriteHTML('<thead>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="text-center padding_10">'.__('Date','school-mgt').'</th>');
								$mpdf->WriteHTML('<th class="text-center padding_10">'.__('Amount','school-mgt').'</th>');
								$mpdf->WriteHTML('<th class="padding_10">'.__('Method','school-mgt').'</th>');
								
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</thead>');
						$mpdf->WriteHTML('<tbody>');
							foreach($fees_history_detail_result as  $retrive_date)
							{
							
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="text-center">'.smgt_getdate_in_input_box($retrive_date->paid_by_date).'</td>');
								$mpdf->WriteHTML('<td class="text-center">'.get_currency_symbol() .number_format($retrive_date->amount,2).'</td>');
								$mpdf->WriteHTML('<td>'.$retrive_date->payment_method.'</td>');
							$mpdf->WriteHTML('</tr>');
							}
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
					}
				$mpdf->WriteHTML('</div>');		
			$mpdf->WriteHTML('</div>');
			
	$mpdf->WriteHTML('</body>');
	$mpdf->WriteHTML('</html>');	
	$mpdf->Output($document_path.'invoice_'.$fees_pay_id.'_'.$student.'.pdf','F');
	$result = get_site_url().'/wp-content/uploads/translate_invoice_pdf/'.'invoice_'.$fees_pay_id.'_'.$student.'.pdf';
	
	return $result;
}
//--------------- SEND INVOICE TRANSLATE PDF LINK --------------------//
//send invoice translate pdf link
function api_translate_result_pdf($s_id,$e_id)
{
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/translate_invoice_pdf/';
	$document_path = $document_dir;
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);		
	}
	ob_start();
	$obj_mark = new Marks_Manage();
	$uid = $s_id;
	$user =get_userdata( $uid );
	$user_meta =get_user_meta($uid);
	$class_id = $user_meta['class_name'][0];
	//$subject = $obj_mark->student_subject($class_id);
	$section_id=get_user_meta($uid,'class_section',true);
	//$subject = $obj_mark->student_subject($class_id);
	if($section_id)
	{
		$subject = $obj_mark->student_subject($class_id,$section_id);
	}
	else
	{
		$subject = $obj_mark->student_subject($class_id);
	}
	$total_subject=count($subject);
	$exam_id =$e_id;
	$total = 0;
	$grade_point = 0;
	$umetadata=get_user_image($uid); ?>
	<center>
	  <div style="float:left;width:100%;"> <img src="<?php echo get_option( 'smgt_school_logo' ) ?>"  style="max-height:50px;"/> <?php echo get_option( 'smgt_school_name' );?> </div>
	  <div style="width:100%;float:left;border-bottom:1px solid red;"></div>
	  <div style="width:100%;float:left;border-bottom:1px solid yellow;padding-top:5px;"></div>
	  <br>
	  <div style="float:left;width:100%;padding:10px 0;">
	    <div style="width:70%;float:left;text-align:left;">
	      <p>
	        <?php _e('Surname','school-mgt');?>
	        :
	        <?php echo get_user_meta($uid, 'last_name',true);?>
	      </p>
	      <p>
	        <?php _e('First Name','school-mgt');?>
	        : <?php echo get_user_meta($uid, 'first_name',true);?></p>
	      <p>
	        <?php _e('Class','school-mgt');?>
	        :
	        <?php $class_id=get_user_meta($uid, 'class_name',true);
												echo $classname=	get_class_name($class_id);
							?>
	      </p>
	      <p>
	        <?php _e('Exam Name','school-mgt');?>
	        :
	        <?php 
					echo get_exam_name_id($exam_id);?>
	      </p>
	    </div>
	    <!-- <div style="float:right;width:30%;"> <img src="<?php echo $umetadata['meta_value'];?>" width="100" /> </div> -->
	  </div>
	  <br>
	  <table style="float:left;width:100%;border:1px solid #000;" cellpadding="0" cellspacing="0">
	    <thead>
	      <tr style="border-bottom: 1px solid #000;">
	        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('S/No','school-mgt');?></th>
	        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('Subject','school-mgt')?></th>
	        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('Obtain Mark','school-mgt')?></th>
	        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php _e('Grade','school-mgt')?></th>
	      </tr>
	    </thead>
	    <tbody>
	      <?php
		        $i=1;
				foreach($subject as $sub)
				{
				?>
	      <tr style="border-bottom: 1px solid #000;">
	        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $i;?></td>
	        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $sub->sub_name;?></td>
	        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->get_marks($exam_id,$class_id,$sub->subid,$uid);?> </td>
	        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->get_grade($exam_id,$class_id,$sub->subid,$uid);?></td>
	      </tr>
	      <?php
				$i++;
				$total +=  $obj_mark->get_marks($exam_id,$class_id,$sub->subid,$uid);
				$grade_point += $obj_mark->get_grade_point($exam_id,$class_id,$sub->subid,$uid);
				} ?>
	    </tbody>
	  </table>
	  <p class="result_total">
	    <?php _e("Total Marks","school-mgt");
	    echo " : ".$total;?>
	  </p>
	  <p class="result_point">
	    <?php	_e("GPA(grade point average)","school-mgt");
	    $GPA=$grade_point/$total_subject;
	    echo " : ".round($GPA, 2);	?>
	  </p>
	  <hr />
	</center>
	<?php
	$out_put = ob_get_contents();
	ob_clean();
	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="result"');
	header('Content-Transfer-Encoding: binary');
	header('Accept-Ranges: bytes');
	require_once SMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';
	$mpdf = new Mpdf\Mpdf;
	$mpdf->autoScriptToLang = true;
	$mpdf->autoLangToFont = true;
	$mpdf->WriteHTML($out_put);
	$mpdf->Output($document_path.'invoice_'.$exam_id.'_'.$uid.'.pdf','F');
	$result = get_site_url().'/wp-content/uploads/translate_invoice_pdf/'.'invoice_'.$exam_id.'_'.$uid.'.pdf';
	return $result;
}
//---------------- GET ROOM BY HOSTEL ID --------//
function get_rooms_by_hostel_id($hostel_id)
{
	global $wpdb;
	$table_smgt_room=$wpdb->prefix.'smgt_room';
	$result=$wpdb->get_results("SELECT * FROM $table_smgt_room where hostel_id=".$hostel_id);
	return $result;
}
//---------------- GET Beds BY ROOM ID --------//
function get_beds_by_room_id($room_id)
{
	global $wpdb;
	$table_smgt_beds=$wpdb->prefix.'smgt_beds';
	$result=$wpdb->get_results("SELECT * FROM $table_smgt_beds where room_id=".$room_id);
	return $result;
}
//---------------- GET ROOM BY HOSTEL ID --------//
function get_beds_by_hostel_id($hostel_id)
{
	global $wpdb;
	$room_id=array();
	$table_smgt_room=$wpdb->prefix.'smgt_room';
	$table_smgt_beds=$wpdb->prefix.'smgt_beds';
	$result=$wpdb->get_results("SELECT * FROM $table_smgt_room where hostel_id=".$hostel_id);
	if(!empty($result))
	{
		foreach($result as $data)
		{
			$room_id[]=$data->id;
		}
	}
	
	$implode_room=implode(",",$room_id);
	$result_beds=$wpdb->get_results("SELECT * FROM $table_smgt_beds where room_id IN ($implode_room)");
	return $result_beds;
}
//---------------- GET Hostel Name BY ROOM ID --------//
function get_hostel_name_by_room_id($room_id)
{
	global $wpdb;
	$table_smgt_room=$wpdb->prefix.'smgt_room';
	$table_smgt_hostel=$wpdb->prefix.'smgt_hostel';
	$result=$wpdb->get_row("SELECT hostel_id FROM $table_smgt_room where id=".$room_id);
	$hostel_id=$result->hostel_id;
	$result_hostel=$wpdb->get_row("SELECT hostel_name FROM $table_smgt_hostel where id=".$hostel_id);
	return $result_hostel->hostel_name;
}
// Comparison function 
function date_compare($element1, $element2) { 
    $datetime1 = strtotime($element1['notification_date']); 
    $datetime2 = strtotime($element2['notification_date']); 
    return $datetime2 - $datetime1; 
}
// add_action('init','generate_access_token');
function generate_access_token()
{
	$CLIENT_ID = get_option('smgt_virtual_classroom_client_id');
	$REDIRECT_URI = site_url().'?page=callback';
	// $a = $_SERVER['REQUEST_URI'];
	// var_dump($a);
	// die(); 
	wp_redirect ("https://zoom.us/oauth/authorize?response_type=code&client_id=".$CLIENT_ID."&redirect_uri=".$REDIRECT_URI);

}

// CREATE MEETING FUNCTION
function ajax_create_meeting()
{
	$obj_mark = new Class_routine(); 
	$route_id = $_REQUEST['route_id'];
	$route_data = get_route_by_id($route_id);
	// var_dump($route_data);
	$start_time_data = explode(":", $route_data->start_time);
	$end_time_data = explode(":", $route_data->end_time);
	if ($start_time_data[1] == 0 OR $end_time_data[1] == 0)
	{
		$start_time_minit = '00';
		$end_time_minit = '00';
	}
	else
	{
		$start_time_minit = $start_time_data[1];
		$end_time_minit = $end_time_data[1];
	}
	$start_time  = date("h:i A", strtotime("$start_time_data[0]:$start_time_minit $start_time_data[2]"));
	$end_time  = date("h:i A", strtotime("$end_time_data[0]:$end_time_minit $end_time_data[2]"));
	?>
	<style>
	 .modal-header{
		 height:auto;
	 }
	</style>
	<script type="text/javascript">
	$(document).ready(function() {
		$('#meeting_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
		$("#start_date").datepicker({
	        dateFormat: "yy-mm-dd",
			minDate:0,
	        onSelect: function (selected) {
	            var dt = new Date(selected);
	            dt.setDate(dt.getDate() + 0);
	            $("#end_date").datepicker("option", "minDate", dt);
	        }
	    });
	    $("#end_date").datepicker({
	       dateFormat: "yy-mm-dd",
		   minDate:0,
	        onSelect: function (selected) {
	            var dt = new Date(selected);
	            dt.setDate(dt.getDate() + 0);
	            $("#start_date").datepicker("option", "maxDate", dt);
	        }
	    });
	} );
	</script>
	<div class="modal-header"> <a href="#" class="close-btn badge badge-success pull-right">X</a>
		 <h4 class="margin_0px"><?php _e('Create Virtual Class','school-mgt');?></h4> 
	</div>
	<hr class="hr_margin">
	<div class="panel panel-white">
	  	<div class="panel-body">   
        <form name="route_form" action="" method="post" class="form-horizontal" id="meeting_form">
        <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="route_id" value="<?php echo $route_id;?>">
		<input type="hidden" name="class_id" value="<?php echo $route_data->class_id;?>">
		<input type="hidden" name="subject_id" value="<?php echo $route_data->subject_id;?>">
		<input type="hidden" name="class_section_id" value="<?php echo $route_data->section_name;?>">
		<input type="hidden" name="duration" value="<?php echo $duration;?>">
		<input type="hidden" name="weekday" value="<?php echo $route_data->weekday;?>">
		<input type="hidden" name="start_time" value="<?php echo $start_time;?>">
		<input type="hidden" name="end_time" value="<?php echo $end_time;?>">
		<input type="hidden" name="teacher_id" value="<?php echo $route_data->teacher_id;?>">
        <div class="form-group">
			<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Name','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="class_name" class="form-control" maxlength="50" type="text" value="<?php echo get_class_name($route_data->class_id); ?>" name="class_name" disabled>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_section"><?php _e('Class Section','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="class_section" class="form-control" maxlength="50" type="text" value="<?php echo smgt_get_section_name($route_data->section_name); ?>" name="class_section" disabled>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Subject"><?php _e('Subject','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="subject" class="form-control" type="text" value="<?php echo get_single_subject_name($route_data->subject_id); ?>" name="class_section" disabled>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="start_time"><?php _e('Start Time','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="start_time" class="form-control" type="text" value="<?php echo $start_time; ?>" name="start_time" disabled>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_time"><?php _e('End Time','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="end_time" class="form-control" type="text" value="<?php echo $end_time; ?>" name="end_time" disabled>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="start_date"><?php _e('Start Date','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="start_date" class="datepicker form-control validate[required] text-input" type="text" placeholder="<?php esc_html_e('Enter Start Date','school-mgt');?>" name="start_date" value="" readonly>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_date"><?php _e('End Date','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="end_date" class="datepicker form-control validate[required] text-input" type="text" placeholder="<?php esc_html_e('Enter Exam Date','school-mgt');?>" name="end_date" value="" readonly>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label" for="agenda"><?php _e('Topic','school-mgt');?></label>
			<div class="col-sm-8">
				<textarea name="agenda" class="form-control validate[custom[address_description_validation]]" placeholder="<?php esc_html_e('Enter Topic','school-mgt');?>" maxlength="250" id=""></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="title"><?php _e('Password','school-mgt');?></label>
			<div class="col-sm-8">
				<input id="password" class="form-control validate[minSize[8],maxSize[12]]" type="password" value="" name="password">
			</div>
		</div>
		<?php wp_nonce_field( 'create_meeting_admin_nonce' ); ?>
		
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php if($edit){ _e('Save Virtual Class','school-mgt'); }else{ _e('Create Virtual Class','school-mgt');}?>" name="create_meeting" class="btn btn-success" />
        </div>        
     </form>
    </div>
	</div>
	<?php
	exit;
}
// VIEW MEETING DATA FUNCTION
function ajax_view_meeting_detail()
{
	$obj_virtual_classroom = new smgt_virtual_classroom;
	$meeting_id = $_REQUEST['meeting_id'];
	$class_data = $obj_virtual_classroom->smgt_get_singal_meeting_data_in_zoom($meeting_id);
	?>
	<script type="text/javascript">
		function copy_text()
		{

			var temp = $("<input>");
		  	$("body").append(temp);
		 	temp.val($('.copy_text').text()).select();
		  	document.execCommand("copy");

		}
	</script>
	<div class="modal-header"> <a href="#" class="close-btn badge badge-success pull-right">X</a>
		 <h4><?php _e('View Virtual Class Details','school-mgt');?></h4> 
	</div>
	<hr>
	<div class="panel panel-white form-horizontal view_notice_overflow">
		<div class="copy_text">
			<p><?php _e('Meeting ID','school-mgt');?> : <?php echo $class_data->zoom_meeting_id; ?></p>
			<p><?php _e('Password','school-mgt');?> : <?php echo $class_data->password; ?></p>
			<p><?php _e('Join Virtual Class Link','school-mgt');?> : <?php echo $class_data->meeting_join_link; ?></p>
		</div>
		<button type="button" onclick="copy_text();" class="btn btn-success margin_5px"><?php _e('Copy','school-mgt');?></button>
	</div>
	<?php
	exit;
}
// add_action('init','refresh_token');
function refresh_token()
{
	require_once SMS_PLUGIN_DIR. '/lib/vendor/autoload.php'; 
	$CLIENT_ID = get_option('smgt_virtual_classroom_client_id');
	$CLIENT_SECRET = get_option('smgt_virtual_classroom_client_secret_id');
	$arr_token = get_option('smgt_virtual_classroom_access_token');
    $token_decode = json_decode($arr_token);
    $refresh_token = $token_decode->refresh_token;
	$client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
    $response = $client->request('POST', '/oauth/token', [
        'headers' => [
            "Authorization" => "Basic ". base64_encode($CLIENT_ID.':'.$CLIENT_SECRET)
        ],
        'query' => [
            "grant_type" => "refresh_token",
            "refresh_token" => $refresh_token
        ],
    ]); 
    $token = $response->getBody()->getContents();
    update_option( 'smgt_virtual_classroom_access_token', $token );

}

// ACCESS TOKAN REAFRESH FUNCTION
add_filter( 'cron_schedules', 'isa_add_every_thirty_minutes' );
function isa_add_every_thirty_minutes( $schedules ) 
{
    $schedules['every_thirty_minutes'] = array(
            'interval'  => 1800,
            'display'   => __( 'Every 30 Minutes', 'textdomain' )
    );
    return $schedules;
}

// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'isa_add_every_thirty_minutes' ) ) 
{
    wp_schedule_event( time(), 'every_thirty_minutes', 'isa_add_every_thirty_minutes' );
}

// Hook into that action that'll fire every three minutes
add_action( 'isa_add_every_thirty_minutes', 'every_thirty_minutes_event_func' );
function every_thirty_minutes_event_func() 
{
    refresh_token();
}
function smgt_get_receiver_name_array($message_id,$sender_id,$created_date,$message_comment)
{
	$message_id=(int)$message_id;
	$sender_id=(int)$sender_id;
	global $wpdb;
	$new_name_array=array();
	$receiver_name=array();
	$tbl_name = $wpdb->prefix .'smgt_message_replies';
	$reply_msg =$wpdb->get_results("SELECT receiver_id  FROM $tbl_name where message_id = $message_id AND sender_id = $sender_id AND message_comment='$message_comment' OR created_date='$created_date'");
	if (!empty($reply_msg)) {
		foreach ($reply_msg as $receiver_id) {
			$receiver_name[]=get_display_name($receiver_id->receiver_id);
		}
	}
	$new_name_array=implode(", ",$receiver_name);
	return $new_name_array;
}
// VIRCHUAL CLASSROOM REMINDER MAIN CROM FUNCTION
add_filter( 'cron_schedules', 'isa_add_every_five_minutes' );
function isa_add_every_five_minutes( $schedules ) 
{
    $schedules['every_five_minutes'] = array(
            'interval'  => 300,
            'display'   => __( 'Every 5 Minutes', 'textdomain' )
    );
    return $schedules;
}

// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'isa_add_every_five_minutes' ) ) 
{
    wp_schedule_event( time(), 'every_five_minutes', 'isa_add_every_five_minutes' );
}

// Hook into that action that'll fire every three minutes
add_action( 'isa_add_every_five_minutes', 'every_five_minutes_event_func' );
function every_five_minutes_event_func() 
{
    smgt_virtual_class_mail_reminder();
}
// VIRTUAL CLASS MAIL REMINDER FUNCTION
// add_action('init','smgt_virtual_class_mail_reminder');
function smgt_virtual_class_mail_reminder()
{
	$obj_virtual_classroom = new smgt_virtual_classroom;
	$virtual_classroom_enable = get_option('smgt_enable_virtual_classroom');
	$virtual_classroom_reminder_enable = get_option('smgt_enable_virtual_classroom_reminder');
	$virtual_classroom_reminder_time = get_option('smgt_virtual_classroom_reminder_before_time');
	if($virtual_classroom_enable == 'yes' AND $virtual_classroom_reminder_enable == 'yes')
	{
		// day code counvert zoom data wise
		$today_day = date('w');
		if ($today_day == '1')
		{
			$weekday = 2;
		}
		elseif($today_day == '2')
		{
			$weekday = 3;
		}
		elseif($today_day == '3')
		{
			$weekday = 4;
		}
		elseif($today_day == '4')
		{
			$weekday = 5;
		}
		elseif($today_day == '5')
		{
			$weekday = 6;
		}
		elseif($today_day == '6')
		{
			$weekday = 7;
		}
		elseif($today_day == '7')
		{
			$weekday = 1;
		}
		$virtual_classroom_data = $obj_virtual_classroom->smgt_get_meeting_data_by_day_in_zoom($weekday);
		if (!empty($virtual_classroom_data))
		{
			foreach ($virtual_classroom_data as $data)
			{
				$route_data = get_route_by_id($data->route_id);
				// time class start counver in formate
				$stime = explode(":",$route_data->start_time);
				$start_hour=str_pad($stime[0],2,"0",STR_PAD_LEFT);
				$start_min=str_pad($stime[1],2,"0",STR_PAD_LEFT);
				$start_am_pm=$stime[2];
				$start_time = $start_hour.':'.$start_min.' '.$start_am_pm;
				// class start time counvert in 24 hours fourmet
				$starttime = date("H:i", strtotime($start_time));
				// git cuurunt time
				$currunt_time = current_time('h:i:s');
				// minuse time in minutes
				$duration = '-'.$virtual_classroom_reminder_time.' minutes';
				$class_time = strtotime($duration, strtotime($starttime));
				$befour_class_time = date('h:i:s', $class_time);
				// check time cundition
				if($currunt_time >= $befour_class_time)
				{
					smgt_virtual_class_teacher_mail_reminder($data->meeting_id);
					smgt_virtual_class_students_mail_reminder($data->meeting_id);
				}
			}
		}
	}
}
// VIRTUAL CLASS TEACHER MAIL REMINDER FUNCTION
function smgt_virtual_class_teacher_mail_reminder($meeting_id)
{
	// define virtual classroom object
	$obj_virtual_classroom = new smgt_virtual_classroom;
	// get singal virtual classroom data by meeting id
	$meeting_data = $obj_virtual_classroom->smgt_get_singal_meeting_data_in_zoom($meeting_id);
	// get class name by class id
	$clasname = get_class_name($meeting_data->class_id);
	// get subject name by subject id
	$subjectname = get_single_subject_name($meeting_data->subject_id);
	// today date function
	$today_date = date(get_option('date_format'));
	// teacher name
	$teacher_name = get_display_name($meeting_data->teacher_id);
	// teacher all data
	$teacher_all_data = get_userdata($meeting_data->teacher_id);
	// get route data by rout id
	$route_data = get_route_by_id($meeting_data->route_id);
	// class start time data 
	$stime = explode(":",$route_data->start_time);
	$start_hour=str_pad($stime[0],2,"0",STR_PAD_LEFT);
	$start_min=str_pad($stime[1],2,"0",STR_PAD_LEFT);
	$start_am_pm=$stime[2];
	$start_time = $start_hour.':'.$start_min.' '.$start_am_pm;
	$start_time_data = new DateTime($start_time); 
	$starttime=date_format($start_time_data,'h:i A');
	// class end time function
	$etime = explode(":",$route_data->end_time);
	$end_hour=str_pad($etime[0],2,"0",STR_PAD_LEFT);
	$end_min=str_pad($etime[1],2,"0",STR_PAD_LEFT);
	$end_am_pm=$etime[2];
	$end_time = $end_hour.':'.$end_min.' '.$end_am_pm;
	$end_time_data = new DateTime($end_time); 
	$edittime=date_format($end_time_data,'h:i A');
	// concat start time and end time
	$time = $starttime.' TO '.$edittime;
	// start zoom virtual class link data
	$start_zoom_virtual_class_link = "<p><a href=".$meeting_data->meeting_start_link." class='btn btn-primary'>".__('Start Virtual Class','school-mgt')."</a></p><br><br>";
	$log_date = date("Y-m-d", strtotime($today_date));
	$mail_reminder_log_data = smgt_cheack_virtual_class_mail_reminder_log_data($meeting_data->teacher_id,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);
	if(empty($mail_reminder_log_data))
	{
		// send mail data
		$string = array();
		$string['{{teacher_name}}'] = "<span>".$teacher_name."</span><br><br>";
		$string['{{class_name}}'] = "<span>".$clasname."</span><br><br>";
		$string['{{subject_name}}'] = "<span>".$subjectname."</span><br><br>";
		$string['{{date}}'] = "<span>".$today_date."</span><br><br>";
		$string['{{time}}'] = "<span>".$time."</span><br><br>";
		$string['{{virtual_class_id}}'] = "<span>".$meeting_data->zoom_meeting_id."</span><br><br>";
		$string['{{password}}'] = "<span>".$meeting_data->password."</span><br><br>";
		$string['{{start_zoom_virtual_class}}'] = $start_zoom_virtual_class_link;
		$string['{{school_name}}'] = "<span>".get_option('smgt_school_name')."</span><br><br>";
		$MsgContent = get_option('virtual_class_teacher_reminder_mail_content');
		$MsgSubject	= get_option('virtual_class_teacher_reminder_mail_subject');
		$message = string_replacement($string,$MsgContent);
		$MsgSubject = string_replacement($string,$MsgSubject);
		$email= 'vijay.rathod@dasinfomedia.com';
		$email= $teacher_all_data->user_email;
		// $from = get_option('smgt_school_name');
		$fromemail = get_option('smgt_email');
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
		if(get_option('smgt_mail_notification') == '1')
		{
			wp_mail($email,$MsgSubject,$message,$headers);	
		}
		smgt_insert_virtual_class_mail_reminder_log($meeting_data->teacher_id,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);
	}
}
// VIRTUAL CLASS STUDENTS MAIL REMINDER FUNCTION
function smgt_virtual_class_students_mail_reminder($meeting_id)
{
	// define virtual classroom object
	$obj_virtual_classroom = new smgt_virtual_classroom;
	// get singal virtual classroom data by meeting id
	$meeting_data = $obj_virtual_classroom->smgt_get_singal_meeting_data_in_zoom($meeting_id);
	$sections_data = smgt_get_class_sections($meeting_data->class_id);
	if(!empty($sections_data))
	{
		foreach($sections_data as $data)
		{
			if($meeting_data->section_id == $data->id)
			{
				$student_data = get_users(array('meta_key' => 'class_section', 'meta_value' =>$data->id,'meta_query'=> array(array('key' => 'class_name','value' => $data->class_id,'compare' => '=')),'role'=>'student'));
			}
		}
	}
	else
	{
		$student_data = get_student_by_class_id($meeting_data->class_id);
	}
	// get class name by class id
	$clasname = get_class_name($meeting_data->class_id);
	// get subject name by subject id
	$subjectname = get_single_subject_name($meeting_data->subject_id);
	// today date function
	$today_date = date(get_option('date_format'));
	// teacher name
	$teacher_name = get_display_name($meeting_data->teacher_id);
	// get route data by rout id
	$route_data = get_route_by_id($meeting_data->route_id);
	// class start time data 
	$stime = explode(":",$route_data->start_time);
	$start_hour=str_pad($stime[0],2,"0",STR_PAD_LEFT);
	$start_min=str_pad($stime[1],2,"0",STR_PAD_LEFT);
	$start_am_pm=$stime[2];
	$start_time = $start_hour.':'.$start_min.' '.$start_am_pm;
	$start_time_data = new DateTime($start_time); 
	$starttime=date_format($start_time_data,'h:i A');
	// class end time function
	$etime = explode(":",$route_data->end_time);
	$end_hour=str_pad($etime[0],2,"0",STR_PAD_LEFT);
	$end_min=str_pad($etime[1],2,"0",STR_PAD_LEFT);
	$end_am_pm=$etime[2];
	$end_time = $end_hour.':'.$end_min.' '.$end_am_pm;
	$end_time_data = new DateTime($end_time); 
	$edittime=date_format($end_time_data,'h:i A');
	// concat start time and end time
	$time = $starttime.' TO '.$edittime;
	// start zoom virtual class link data
	$join_zoom_virtual_class_link = "<p><a href=".$meeting_data->meeting_join_link." class='btn btn-primary'>".__('Join Virtual Class','school-mgt')."</a></p><br><br>";
	if(!empty($student_data))
	{
		foreach($student_data as $data)
		{
			$log_date = date("Y-m-d", strtotime($today_date));
			$mail_reminder_log_data = smgt_cheack_virtual_class_mail_reminder_log_data($data->ID,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);
			if(empty($mail_reminder_log_data))
			{
				$student_name = get_display_name($data->ID);
				$string = array();
				$string['{{student_name}}'] = "<span>".$student_name."</span><br><br>";
				$string['{{class_name}}'] = "<span>".$clasname."</span><br><br>";
				$string['{{subject_name}}'] = "<span>".$subjectname."</span><br><br>";
				$string['{{teacher_name}}'] = "<span>".$teacher_name."</span><br><br>";
				$string['{{date}}'] = "<span>".$today_date."</span><br><br>";
				$string['{{time}}'] = "<span>".$time."</span><br><br>";
				$string['{{virtual_class_id}}'] = "<span>".$meeting_data->zoom_meeting_id."</span><br><br>";
				$string['{{password}}'] = "<span>".$meeting_data->password."</span><br><br>";
				$string['{{join_zoom_virtual_class}}'] = $join_zoom_virtual_class_link;
				$string['{{school_name}}'] = "<span>".get_option('smgt_school_name')."</span><br><br>";
				$MsgContent = get_option('virtual_class_student_reminder_mail_content');
				$MsgSubject	= get_option('virtual_class_student_reminder_mail_subject');
				$message = string_replacement($string,$MsgContent);
				$MsgSubject = string_replacement($string,$MsgSubject);
				$email= 'vijay.rathod@dasinfomedia.com';
				$email= $data->user_email;
				// $from = get_option('smgt_school_name');
				$fromemail = get_option('smgt_email');
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
				if(get_option('smgt_mail_notification') == '1')
				{
					wp_mail($email,$MsgSubject,$message,$headers);
				}
				smgt_insert_virtual_class_mail_reminder_log($data->ID,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);
			}
		}
	}
}
// INSERT VIRTUAL CLASS MAIL REMINDER LOG FUNCTION
function smgt_insert_virtual_class_mail_reminder_log($user_id,$meeting_id,$class_id,$date)
{
	global $wpdb;
	$table_zoom_meeting_mail_reminder_log= $wpdb->prefix. 'smgt_reminder_zoom_meeting_mail_log';
	$meeting_log_data['user_id'] = $user_id;
	$meeting_log_data['meeting_id'] = $meeting_id;
	$meeting_log_data['class_id'] = $class_id;
	$meeting_log_data['alert_date'] = $date;
	$result=$wpdb->insert( $table_zoom_meeting_mail_reminder_log, $meeting_log_data );
}
// CHEACK VIRTUAL CLASS MAIL REMINDER LOG FUNCTION
function smgt_cheack_virtual_class_mail_reminder_log_data($user_id,$meeting_id,$class_id,$date)
{
	global $wpdb;
	$table_zoom_meeting_mail_reminder_log= $wpdb->prefix. 'smgt_reminder_zoom_meeting_mail_log';
	$result = $wpdb->get_row("SELECT * FROM $table_zoom_meeting_mail_reminder_log WHERE user_id=$user_id AND meeting_id=$meeting_id AND class_id=$class_id AND alert_date='$date'");
	return $result;
}
?>