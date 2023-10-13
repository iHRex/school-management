<?php 
class UserAccountantAPI 
{
	public function __construct() 
	{
		add_action('template_redirect', array($this,'redirectMethod'),1);		
	}	
	
	public function redirectMethod()
	{
		if($_REQUEST["smgt-json-api"]=='user-accoutant')
		{	
			$response=$this->edit_students_profile($_REQUEST,$_FILES);	 
			if(is_array($response))
			{
				echo json_encode($response);
			}
			else
			{
				header("HTTP/1.1 401 Unauthorized");
			}
			die();
		}
	}
	
	
	
	public function edit_students_profile($data,$file)
	{
		$response=array();			
		if(!empty($data['current_user_id']))
		{
			if(!empty($file))
			{
				$smgt_avatar_image = smgt_user_avatar_image_upload('smgt_user_avatar');		
				$smgt_avatar = content_url().'/uploads/school_assets/'.$smgt_avatar_image;	
			}
			else
			{
				$smgt_avatar = get_user_meta($data['current_user_id'],'smgt_user_avatar',true);
			}
												
			$stddata = get_userdata($data['current_user_id']);						
			$userdata = array(
				'ID'=>$data['current_user_id'],
				'user_login'=>$stddata->user_login,				
				'user_email'=>$data['email']			
			);
			
			if(!empty($data['current_pass']) && !empty($data['password']) && !empty($data['conform_pass']))
			{
				require_once ABSPATH . 'wp-includes/class-phpass.php';
				$wp_hasher = new PasswordHash( 8, true );			
				if($wp_hasher->CheckPassword($data['current_pass'],$stddata->user_pass))
				{
					if($data['password']===$data['conform_pass'])
					{						
						$userdata['user_pass'] = $data['conform_pass'];
						$user_id = wp_update_user($userdata);						
						$flag=0;					
						if($user_id==$data['current_user_id'])
							$flag=1;
						$usermetadata=array(
							'address'=>$data['address'],
							'city'=>$data['city_name'],
							'state'=>$data['state_name'],					
							'phone'=>$data['phone'],
							'smgt_user_avatar'=>$smgt_avatar
						);							
						
						foreach($usermetadata as $key=>$val)
						{
							$returnans=update_user_meta( $data['current_user_id'], $key,$val );
							if($returnans)
							{
								$returnval=$returnans;
								$flag=1;
							}
						}
						if($flag==1)
						{
							//$message=__("Record successfully Updated!","school-mgt");
							$response['status']=1;
							$response['message']=__("Record successfully Updated!","school-mgt");
							return $response;
						}
						else
						{
							//$error['message']=__("Please Fill Password Fields",'school-mgt');
							$response['status']=0;
							$response['message']=__("Please Fill Password Fields","school-mgt");
							return $response;
						} 
					}
					else
					{
						//$message=__("Password is not metch","school-mgt");
						$response['status']=0;
						$response['message']=__("Password is not metch","school-mgt");
						return $response;
					}
				} 
				else
				{
					//$message=__("current password does not match","school-mgt");
					$response['status']=0;
					$response['message']=__("current password does not match","school-mgt");
					return $response;
				}
			} 
			else
			{
				$user_id = wp_update_user($userdata);
				$usermetadata=array(				
					'address'=>$data['address'],
					'city'=>$data['city_name'],
					'state'=>$data['state_name'],					
					'phone'=>$data['phone'],
					'smgt_user_avatar'=>$smgt_avatar
				); 
					
				$flag=0;
				if($user_id)
				{
					$flag=1;
				}
				foreach($usermetadata as $key=>$val)
				{		
					$returnans=update_user_meta( $data['current_user_id'], $key,$val );
					if($returnans)
					{	
						$returnval=$returnans;
						$flag=1;
					}
				}
				
				if(empty($data['current_pass']) && !empty($data['password']) && !empty($data['conform_pass']))
				{
					$flag=2;
				}
				
				if($flag==1)
				{
					//$message=__("Record successfully Updated!","school-mgt");
					$response['status']=1;
					$response['message']=__("Record successfully Updated!","school-mgt");
					return $response;
				}
				elseif($flag==2)
				{
					//$message=__("Please Fill current Password Field ","school-mgt");
					$response['status']=1;
					$response['message']=__("Please Fill current Password Field ","school-mgt");
					return $response;
				}
				else
				{
					//$message=__("You have not update any field value","school-mgt");
					$response['status']=0;
					$response['message']=__("You have not update any field value","school-mgt");
					return $response;
				}
			}			
			return $response; 				
		} 
		else
		{
			//$error['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['message']=__("Please Fill All Fields","school-mgt");
		} 
		return $response;			
	}
}
?>