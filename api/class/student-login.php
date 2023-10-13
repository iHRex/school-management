<?php 
class StudentLogin{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			
			error_reporting(0);
			if($_REQUEST['smgt-json-api']=='student-login')
			{
				echo json_encode($this->userLogin($_REQUEST['username'],$_REQUEST['password']));	 
				die();
			}
			
	}
	public function userLogin($username,$password)
	{
		
		$response=array();
		
		$loginresult=wp_login($username,$password);
		if($loginresult==1)
		{
			
			$user = get_userdatabylogin($username);
			if($user){
					$retrived_data=get_userdata($user->ID);
					$student['ID']=$retrived_data->ID;
					$student['display_name']=$retrived_data->display_name;
					$student['email']=$retrived_data->user_email;
					$student['image']=$retrived_data->smgt_user_avatar;
					$response['resource']=$student;
				}
		}
		else
		{
			$error['message']=__("Username Password incorrect",'school-mgt');
			$error['code']="1";
			$response['error']=$error;
			
		}
		
		
		return $response;
	}
} ?>