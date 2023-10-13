<?php class StudentRegistration{
	public function __construct() 	{
		add_action('template_redirect', array($this,'redirectMethod'), 1);	}
	public function redirectMethod()
	{
		error_reporting(0);		if(isset($_REQUEST['smgt-json-api']) && $_REQUEST['smgt-json-api']=='student-registration')		{				$response=$this->student_registration($_REQUEST);	 			if(is_array($response))			{				echo json_encode($response);			}			else			{				header("HTTP/1.1 401 Unauthorized");			}			die();
		}	}
	public function student_insert($data)
	{		$response=array();
		$error=array();
		if ( username_exists( $data['username'] ) )		{
			//$error['message']=__('Sorry, that username already exists!','school-mgt');
			$error['code']="2";
			$response['error']=__('Sorry, that username already exists!','school-mgt');
		}
		if ( email_exists( $data['email']) ) 		{
			if(!empty($error))
				$error=__(' Email Already in use','school-mgt');
			else
				$error=__(' Email Already in use','school-mgt');			
			$error['code']="3";			$response['message']=$error;		}		
		if(!isset($response['error']) || $response['error']=="")		{
			$file=$data['smgt_user_avatar'];
			$result=smgt_complete_registration($data['class_name'],$data['first_name'],$data['middle_name'],$data['last_name'],$data['gender'],$data['birth_date'],$data['address'],$data['city_name'],$data['state_name'],$data['zip_code'],$data['mobile_number'],$data['alternet_mobile_number'],$data['phone'],$data['email'],$data['username'],$data['password'],$file);
			if($result!=0)			{
				$retrived_data=get_userdata($result);
				$student['ID']=$retrived_data->ID;
				$student['display_name']=$retrived_data->display_name;
				$student['email']=$retrived_data->user_email;
				$student['image']=$retrived_data->smgt_user_avatar;
				$response['status']=1;
				$response['message']=$student;
			}
			else
			{
				//$error['message']=__("No data insert.",'school-mgt');
				$response['status']=0;
				$response['message']=__("No data insert.",'school-mgt');
			}		}
		else
		{
			//$error['message']=__("There is no data available.",'school-mgt');
			$response['status']=0;			$response['message']=__("There is no data available.",'school-mgt');
		}
		return $response;
	}
	function student_registration($data)
	{
		$response=array();
		if( !email_exists( $data['email'] ) && !username_exists( $data['username'] )) 
		{
			$role='student';	
			$userdata = array(
				'user_login'=>$data['username'],
				'user_email'=>$data['email'],
				'user_url'=> NULL,
				'first_name'=>$data['first_name'],
				'last_name'=>$data['last_name'],
				'nickname'=>NULL
			);			if($data['password'] != "")				$userdata['user_pass']=$data['password'];						$user_id = wp_insert_user( $userdata );				
			$user = new WP_User($user_id);			$user->set_role('student');
			$smgt_avatar = '';
			if($_FILES['smgt_user_avatar']['size'] > 0)			{
				$smgt_avatar_image = smgt_user_avatar_image_upload('smgt_user_avatar');
				$smgt_avatar = content_url().'/uploads/school_assets/'.$smgt_avatar_image;
			}
			else 			{
				if(isset($_REQUEST['smgt_user_avatar']))
					$smgt_avatar_image=$_REQUEST['smgt_user_avatar'];
					$smgt_avatar=$smgt_avatar_image;
			}
			
			$usermetadata=array(				'roll_id' => '',				'middle_name'=>$data['middle_name'],				'gender'=>$data['gender'],				'birth_date'=>$data['birth_date'],				'address'=>$data['address'],				'city'=>$data['city_name'],				'state'=>$data['state_name'],				'zip_code'=>$data['zip_code'],				'class_name'=>$data['class_name'],				'class_section'=>$data['class_section'],				'phone'=>$data['phone'],				'mobile_number'=>$data['mobile_number'],				'alternet_mobile_number'=>$data['alternet_mobile_number'],				'smgt_user_avatar'=>$smgt_avatar			);			foreach($usermetadata as $key=>$val)			{					$result=update_user_meta( $user_id, $key,$val );
			}
			$hash = md5( rand(0,1000) );
			$result=update_user_meta($user_id, 'hash', $hash);				
			if($result)			{
				
				$response['status']=1;
				$response['message']=__("Record successfully inserted!","school-mgt");
				
			}
			else
			{
				$response['status']=0;
				$response['message']=__("Please Fill All Fields",'school-mgt');
			}
		}
		else
		{
			$response['status']=0;
			$response['message']=__("Username Or Emailid All Ready Exist.","school-mgt");
		}
			return $response;
	}
}?>