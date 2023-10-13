<?php 
class ChangePassword{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
		//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='change-password')
			{					
				$response=$this->change_password($_REQUEST);	 
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
	public function change_password($data)
	{		
		$result=0;
		if($data['current_password']!="" && $data['new_password']!="" && $data['confirm_password']!="" && $data['current_user_id']!="" && $data['current_user_id']!=0){
		
		$user_data =get_userdata($data['current_user_id']);
		//var_dump($user_data);
		require_once ABSPATH . 'wp-includes/class-phpass.php';
		$wp_hasher = new PasswordHash( 8, true );
		if($wp_hasher->CheckPassword($data['current_password'],$user_data->user_pass))
		{
			
			if($data['new_password']==$data['confirm_password'])
			{
				 wp_set_password( $data['new_password'],$data['current_user_id']);
				$result=1;
			}
		
		}
		
		$response=array();
		if($result!=0){
				$message['message']=__("Password Successfully changed",'school-mgt');
				$response['status']=1;
				$response['resource']=$message;
				return $response;
			}	
		}
		else
		{
			$error['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['error']=$error;
			return $response;
		}
		
	}
} ?>