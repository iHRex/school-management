<?php 
class StudentRegistrationImageUpload{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			//error_reporting(0);
			
			if(isset($_REQUEST['smgt-json-api']) && $_REQUEST['smgt-json-api']=='student-registration-image-upload')
			{	
				foreach($_REQUEST as $key=>$val)
				{
					$_REQUEST[$key]=urldecode($val);
				}
				
				echo json_encode($this->student_insert($_REQUEST,$_FILES['smgt_user_avatar']));	 
				
				die();
			}
			
	}
	public function student_insert($data,$file)
	{
		
		$response=array();
		$error=array();
		if ( username_exists( $data['username'] ) ){
			
			$error['message']=__('Sorry, that username already exists!','school-mgt');
			$error['code']="2";
			$response['error']=$error;
		}
		if ( email_exists( $data['email']) ) {
			if(!empty($error))
				$error['message'].=__(' Email Already in use','school-mgt');
			else
				$error['message']=__(' Email Already in use','school-mgt');
			$error['code']="3";
			$response['error']=$error;
			
		}		
		if(!isset($response['error']) || $response['error']==""){
					
			//$file=$data['smgt_user_avatar'];	
			
			//smgt_registration_validation($data['class_name'],$data['first_name'],$data['middle_name'],$data['last_name'],$data['gender'],$data['birth_date'],$data['address'],$data['city_name'],$data['state_name'],$data['zip_code'],$data['mobile_number'],$data['alternet_mobile_number'],$data['phone'],$data['email'],$data['username'],$data['password'],$file );	
			
			$result=smgt_complete_registration($data['class_name'],$data['first_name'],$data['middle_name'],$data['last_name'],$data['gender'],$data['birth_date'],$data['address'],$data['city_name'],$data['state_name'],$data['zip_code'],$data['mobile_number'],$data['alternet_mobile_number'],$data['phone'],$data['email'],$data['username'],$data['password'],$file);			
			
			if($result!=0){	
			
				$retrived_data=get_userdata($result);
				$student['ID']=$retrived_data->ID;
				$student['display_name']=$retrived_data->display_name;
				$student['email']=$retrived_data->user_email;
				$student['image']=$retrived_data->smgt_user_avatar;
				
				$response['status']=1;
				$response['resource']=$student;
			}
			else
			{
				$error['message']=__("No data insert.",'school-mgt');
				$response['status']=0;
				$response['resource']=$error;
				
			}
			
		}
		else
		{
			$error['message']=__("There is no data available.",'school-mgt');
			$response['status']=0;
			$response['resource']=$error;
			
		}	
		return $response;
	}
} ?>