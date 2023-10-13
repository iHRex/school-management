<?php
require_once (ABSPATH .'wp-admin/includes/user.php');
class TeacherListing 
{
	public function __construct()
	{
		add_action('template_redirect', array($this,'redirectMethod'));
	}
	public function redirectMethod()
	{
		
		if($_REQUEST['smgt-json-api']=='teacher-listing')
		{			
			$response=$this->teacher_listing($_REQUEST);	 
			if(is_array($response)){
				echo json_encode($response);
			}
			else
			{
				header("HTTP/1.1 401 Unauthorized");
			}
			die();
		}
		
		if($_REQUEST['smgt-json-api']=='add-teacher'){
			$response=$this->add_teacher($_REQUEST);	 
			if(is_array($response)){
				echo json_encode($response);
			}
			else{
				header("HTTP/1.1 401 Unauthorized");
			}
			die();
		}
		
		if($_REQUEST['smgt-json-api']=='edit-teacher'){
			$response=$this->edit_teacher($_REQUEST);	 
			if(is_array($response)){
				echo json_encode($response);
			}
			else {
				header("HTTP/1.1 401 Unauthorized");
			}
			die();
		}
		
		if($_REQUEST['smgt-json-api']=='delete-teacher'){
			$school_obj = new School_Management($_REQUEST['current_user']);
			
			if($school_obj->role=='admin'){
				$response=$this->delete_teacher($_REQUEST);	 
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
	public function teacher_listing($data)
	{
		$teacher_obj 	= 	new Smgt_Teacher;	
		//Get User Acsess //
		$menu_access_data=smgt_get_userrole_wise_access_right_array_in_api($data['current_user'],'teacher');
		if($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 1 )
		{			
			$class_id 	= 	get_user_meta($data['current_user'],'class_name',true);		
		    $teacherdata 	= 	get_teacher_by_class_id($class_id);
		}
		elseif($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 0 )
		{
			$teacherdata	=	get_usersdata('teacher');
		}
		else
		{
			$teacherdata="";
		}		
		$response	=	array();
		if(!empty($teacherdata))
		{	
			$i=0;
			foreach ($teacherdata as $retrieved_data)
			{
				$userimagedata=get_user_image($retrieved_data->ID);
				if(empty($userimagedata['meta_value']))
				{
					$imageurl=get_option( 'smgt_teacher_thumb');
				}
				else
				{
					$imageurl=$userimagedata['meta_value'];
				}
				$result[$i]['ID']	=	$retrieved_data->ID;
				$result[$i]['image']=$imageurl;
				$result[$i]['name']	=	$retrieved_data->display_name;
				$result[$i]['email']=$retrieved_data->user_email;
			    $classes="";
			    $classes = $teacher_obj->smgt_get_class_by_teacher($retrieved_data->ID);
				$classname = "";
				foreach($classes as $class)
				{
					$classname .= get_class_name($class['class_id']).",";
			      }
				$classname = trim($classname,",");
				$result[$i]['class']=$classname; 
				$subjectname=rtrim(get_subject_name_by_teacher($retrieved_data->ID),', ');
				$result[$i]['subjects']=$subjectname;

				$i++;
			}
			$response['status']=1;
			$response['resource']=$result;
			return $response;
		}
		else
		{
			$response['status']=0;
			$response['message']=__("Record not found",'school-mgt');
		}	
		return $response;
	}
	public function add_teacher($data)
	{
		$response=array();
		$teacher_obj = new Smgt_Teacher;
		$role='teacher';
		
		$firstname=$data['first_name'];
			$lastname=$data['last_name'];
			$userdata = array(
			'user_login'=>$data['username'],			
			'user_nicename'=>NULL,
			'user_email'=>$data['email'],
			'user_url'=>NULL,
			'display_name'=>$firstname." ".$lastname,
			);
			if($data['password'] != "")
				$userdata['user_pass']=$data['password'];
		
			$usermetadata=array('middle_name'=>$data['middle_name'],
						'gender'=>$data['gender'],
						'birth_date'=>$data['birth_date'],
						'address'=>$data['address'],
						'city'=>$data['city_name'],
						'state'=>$data['state_name'],
						'zip_code'=>$data['zip_code'],
						//'class_name'=>$data['class_name'],
						'phone'=>$data['phone'],
						'mobile_number'=>$data['mobile_number'],
						'alternet_mobile_number'=>$data['alternet_mobile_number'],
						'working_hour'=>$data['working_hour'],
						'possition'=>$data['possition'],
						'smgt_user_avatar'=>$data['smgt_user_avatar'],
						'attachment'=>$data['attachment']);
		$classdata=explode(',',$data['class_name']);				
		if( !email_exists( $data['email'] ) && !username_exists( $data['username'] )) {
		 $result=add_newuser($userdata,$usermetadata,$firstname,$lastname,$role);
		  $result1 = $teacher_obj->smgt_add_muli_class($classdata,$data['username']);	
		}
		else
		{
			$message['message']=__("Username Or Emailid All Ready Exist.","school-mgt");
			$response['status']=0;
			$response['resource']=$message;
			return $response;
		}
		if($result)
		{
			$message['message']=__("Record successfully inserted!","school-mgt");
			$response['status']=1;
			$response['resource']=$message;
			return $response;
		}
		else
		{
			$error['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['resource']=$error;
		}
			return $response;
		
	}
	public function edit_teacher($data)
	{
		$response=array();
		$teacher_obj = new Smgt_Teacher;
		$role='teacher';
		
		$firstname=$data['first_name'];
			$lastname=$data['last_name'];
			$userdata = array(
			'user_login'=>$data['username'],			
			'user_nicename'=>NULL,
			'user_email'=>$data['email'],
			'user_url'=>NULL,
			'display_name'=>$firstname." ".$lastname,
			);
			if($data['password'] != "")
				$userdata['user_pass']=$data['password'];
			$userdata['ID']=$data['teacher_id'];
			$usermetadata=array('middle_name'=>$data['middle_name'],
						'gender'=>$data['gender'],
						'birth_date'=>$data['birth_date'],
						'address'=>$data['address'],
						'city'=>$data['city_name'],
						'state'=>$data['state_name'],
						'zip_code'=>$data['zip_code'],
						//'class_name'=>$data['class_name'],
						'phone'=>$data['phone'],
						'mobile_number'=>$data['mobile_number'],
						'alternet_mobile_number'=>$data['alternet_mobile_number'],
						'working_hour'=>$data['working_hour'],
						'possition'=>$data['possition'],
						'smgt_user_avatar'=>$data['smgt_user_avatar'],
						'attachment'=>$data['attachment']);
		
		$classdata=explode(',',$data['class_name']);				
		$user_id = wp_update_user($userdata);
		$flag=0;
		foreach($usermetadata as $key=>$val){
		
			$returnans=update_user_meta( $data['teacher_id'], $key,$val );
			if($returnans){
				$returnval=$returnans;
				$flag=1;
			}
		}
		$result1 = $teacher_obj->smgt_update_multi_class($classdata,$data['teacher_id']);	
		if($flag=1)
		{
			$message['message']=__("Record successfully Updated!","school-mgt");
			$response['status']=1;
			$response['resource']=$message;
			return $response;
		}
		else
		{
			$error['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['resource']=$error;
		}
			return $response;
		
	}
	public function delete_teacher($data)
	{
		$response=array();
		if($data['teacher_id']!=0){
			$result=delete_usedata($data['teacher_id']);
			if($result)
			{
				$message['message']=__("Record successfully Deleted!","school-mgt");
				$response['status']=1;
				$response['resource']=$message;
				return $response;
			}
			else
			{
				$message['message']=__("Records Not Delete","school-mgt");
				$response['status']=0;
				$response['resource']=$message;
			}
			return $response;
			
		}
		else
		{
			$error['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['resource']=$error;
		}
			return $response;
	}

} 