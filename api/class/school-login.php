<?php 
class SchoolLogin{
	public function __construct() {
		
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			
			//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='school-login')
			{
				
				//echo json_encode($this->userLogin($_REQUEST['username'],$_REQUEST['password']));	 
				$response=$this->userLogin($_REQUEST['username'],$_REQUEST['password']);
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
	public function userLogin($username,$password)
	{		
		
		$response=array();		
		$loginresult=wp_login($username,$password);
		
		$user = get_userdatabylogin($username);
		
		if( get_user_meta($user->ID, 'hash', true))
		{
				//$error['message']=__("Your Account is not activated.",'school-mgt');
				$response['status']=0;
				$response['resource']=__("Your Account is not activated.",'school-mgt');
				return $response;
		} 
		else{
			if($loginresult==1)
			{	
				
				$user = get_userdatabylogin($username);
				if($user){
					$school_obj = new School_Management($user->ID);				
					$retrived_data=get_userdata($user->ID);
					$student['ID']=$retrived_data->ID;
					$student['display_name']=$retrived_data->display_name;
					$student['email']=$retrived_data->user_email;
					$student['image']=$retrived_data->smgt_user_avatar;
					$student['user_role']=$school_obj->role;					
					$student['currency']=get_option('smgt_currency_code');					
					$response['status']=1;
					$response['resource']=$student;
				}
				return $response;
			}
			else
			{
				//$error['message']=__("Incorrect Username or Password.",'school-mgt');
				$response['status']=0;
				$response['resource']=__("Incorrect Username or Password.",'school-mgt');
				return $response;
			}
		}	
		
	}
} ?>