<?php 
class MessageClass
{
	public function __construct()
	{
		add_action('template_redirect', array($this,'redirectMethod'), 1);		
	}
	
	public function redirectMethod()
	{
		if($_REQUEST['smgt-json-api']=='compose-message')
		{				
			$response=$this->send_message($_REQUEST);	
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
		
		if($_REQUEST['smgt-json-api']=='sendbox')
		{	
			$response=$this->sendbox($_REQUEST);	
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
		
		if($_REQUEST['smgt-json-api']=='inbox')
		{	
			$response=$this->inbox($_REQUEST);	
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
		
		if($_REQUEST['smgt-json-api']=='view-message')
		{	
			$response=$this->view_message($_REQUEST);	
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
		
		if($_REQUEST['smgt-json-api']=='delete-message')
		{	
			$response=$this->api_delete_message($_REQUEST);	
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

	public function send_message($data)
	{
		if($data['message_body']!="" && $data['receiver']!="" && $data['subject']!="")
		{
			global $wpdb;
			$created_date = date("Y-m-d H:i:s");
			$subject = $data['subject'];
			$message_body = $data['message_body'];
			$tablename=$wpdb->prefix."smgt_message";
			$role=$data['receiver'];
			$flage=0;
			if(isset($data['class_id']))
				$class_id = $data['class_id'];
			if($role == 'parent' || $role == 'student' || $role == 'teacher' || $role == 'supportstaff' )
			{
				if($data['class_section_id']!="")
				{
					$userdata=smgt_get_user_notice($role,$data['class_id'],$data['class_section_id']);
				}
				else
				{
					$userdata=smgt_get_user_notice($role,$data['class_id']);
				}
				if(!empty($userdata))
				{
					$post_id = wp_insert_post( array(
						'post_status' => 'publish',
						'post_type' => 'message',
						'post_author' => $data['current_user'],
						'post_title' => $subject,
						'post_content' =>$message_body));
						foreach($userdata as $user)
						{
							if($role == 'parent' && $class_id != 'all')
								$user_id=$user['ID'];
							else 
								$user_id=$user->ID;
							
							$message_data=array('sender'=>$data['current_user'],
									'receiver'=>$user_id,
									'subject'=>$subject,
									'message_body'=>$message_body,
									'date'=>$created_date,
									'post_id'=>$post_id,
									'status' =>0);
							
								$result=$wpdb->insert( $tablename, $message_data);	
								$result=add_post_meta($post_id, 'message_for','user');
								$result=add_post_meta($post_id, 'message_smgt_user_id',$user_id);
								if($result!=0)
								{
									$flage=1;
								}
						}		
				}
						
			}
			else
			{
				$user_id = $data['receiver'];
				$post_id = wp_insert_post( array(
					'post_status' => 'publish',
					'post_type' => 'message',
					'post_author' => $data['current_user'],
					'post_title' => $subject,
					'post_content' =>$message_body));
					
				$message_data=array(
					'sender'=>$data['current_user'],
					'receiver'=>$user_id,
					'subject'=>$subject,
					'message_body'=>$message_body,
					'date'=>$created_date,
					'post_id'=>$post_id,
					'status' =>0);
						
				$result=$wpdb->insert( $tablename, $message_data);	
				$result=add_post_meta($post_id, 'message_for','user');
				$result=add_post_meta($post_id, 'message_smgt_user_id',$user_id);
				if($result!=0)
				{
					$flage=1;
				}
			}
			if($flage==1)
			{
				$message['message']=__("Message sent successfully","school-mgt");
				$response['status']=1;
				$response['resource']=$message;
			}
			return $response;
		}
		else
		{
			$message['message']=__("Please Fill All Fields","school-mgt");
			$response['status']=0;
			$response['resource']=$message;
		}
			return $response;
	}

	public function sendbox($data)
	{	
		if($data['current_user']!="")
		{
			$max=15;
			$offset=0;
			$messagedata=get_send_message($data['current_user']);
			$args['post_type'] = 'message';
			$args['posts_per_page'] =$max;
			$args['offset'] = $offset;
			$args['post_status'] = 'public';
			$args['author'] = $data['current_user'];
			$q = new WP_Query();
			//$sent_message = $q->query( $args );
			$messagedata = $q->query( $args );
		}
		if(!empty($messagedata))
		{
			$i=0;
			$message_for="";
			$class="";
		
			foreach ($messagedata as $msg_post)
			{ 
				if($msg_post->post_author==$data['current_user'])
				{
					if(get_post_meta( $msg_post->ID, 'message_for',true) == 'user')
					{
						$message_for=get_display_name(get_post_meta( $msg_post->ID, 'message_smgt_user_id',true));
					}
					else
					{
						$message_for= get_post_meta( $msg_post->ID, 'message_for',true);
					}
					if(get_post_meta( $msg_post->ID, 'smgt_class_id',true) !="" && get_post_meta( $msg_post->ID, 'smgt_class_id',true) == 'all')
					{
						$class=__('All','school-mgt');
					}
					elseif(get_post_meta( $msg_post->ID, 'smgt_class_id',true) !="")
					{
						$class=get_class_name(get_post_meta( $msg_post->ID, 'smgt_class_id',true)); 
					}
					
					$result[$i]['message_id']=$msg_post->ID;
					$result[$i]['message_for']=$message_for;
					$result[$i]['standard']=$class;
					$result[$i]['subject']=$msg_post->post_title;
					$result[$i]['description']=$msg_post->post_content;
					$i++;
				}
			}
			$response['status']=1;
			$response['resource']=$result;
			return $response;
		}
		else
		{
			$message['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['resource']=$message;
		}
			return $response;
	}

	public function inbox($data)
	{
		$menu_access_data=smgt_get_userrole_wise_access_right_array_in_api($data['current_user'],'message');
		if($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 1 )
		{
			$messagedata=get_inbox_message($data['current_user']);
		}
		elseif($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 0 )
		{
			$messagedata=get_inbox_message($data['current_user']);
		}
		else
		{
			$messagedata="";
		}
		if(!empty($messagedata))
		{
			$i=0;
			$message_for="";
			$class="";
			$post_id=0;
			foreach ($messagedata as $msg)
			{ 
				$message_for=get_post_meta($msg->post_id,'message_for',true);
				if($message_for=='student' || $message_for=='supportstaff' || $message_for=='teacher' || $message_for=='parent')
				{ 
					if($post_id==$msg->post_id)
					{
						continue;
					}
					else
					{
						$message_for=get_display_name($msg->sender);
						$subject=$msg->subject;
						$message_content=$msg->message_body;
                        $message_date= smgt_getdate_in_input_box($msg->date);
						//$message_date=mysql2date('d M Y', $msg->date );
					}
				}
				else
				{
					$message_for=get_display_name($msg->sender);
					$subject=$msg->subject;
					$message_content=$msg->message_body;
					//$message_date=mysql2date('d M Y', $msg->date );
					$message_date=smgt_getdate_in_input_box($msg->date);
				}
					
					$result[$i]['id']=$msg->message_id;
					$result[$i]['message_id']=$msg->post_id;
					$result[$i]['message_from']=$message_for;
					$result[$i]['subject']=$subject;
					$result[$i]['description']=$message_content;
					$result[$i]['Date']=$message_date;
					$result[$i]['Status']=cheak_type_status($data['current_user'],'message',$msg->message_id);
					$i++;
					$post_id=$msg->post_id;
			}
			
			$response['status']=1;						$response['date_formate']	= get_option('smgt_datepicker_format');			
			$response['resource']=$result;
			return $response;
		}
		else
		{
			//$message['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['message']=__("Record not found",'school-mgt');
		}
		return $response;
	}

	public function view_message($data)
	{		
		if($data['message_id']!="")
		{
			$message = get_post($data['message_id']);		
			if(!empty($message))
			{	
				$sender=get_display_name($message->post_author);
				$message_date=mysql2date('d/m/y', $message->date);
				$message_for=get_post_meta($data['message_id'],'message_for',true);
				if($message_for == 'user')
				{
					$receiver=get_display_name(get_post_meta($data['message_id'],'message_smgt_user_id',true));
				}
				else
				{
					$receiver=__('Group','school-mgt');
				}
				$result['message_id']=$message->ID;
				$result['subject']=$message->post_title;
				$result['from']=$sender;
				$result['to']=$receiver;
				$result['description']=$message->post_content; 
				$response['status']=1;
				$response['resource']=$result;
				return $response;
			}
			else
			{
				$message['message']=__("Record not found",'school-mgt');
				$response['status']=0;
				$response['resource']=$message;
			}
		}
		else
		{
			$message['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['resource']=$message;
		}
			return $response;
	}

	function api_delete_message($data)
	{		
		global $wpdb;
		if($data['message_id']!=0 && $data['message_id']!="")
		{
			$result=wp_delete_post($data['message_id']);
			if($result)
			{
				$table_name = $wpdb->prefix . 'smgt_message';
				$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE post_id= %d",$data['message_id']));
				//$message['message']=__("Records Deleted Successfully!",'school-mgt');
				$response['status']=1;
				$response['message']=__("Records Deleted Successfully!",'school-mgt');
			}
			else
			{
				//$message['message']=__("Records Not Delete","school-mgt");
				$response['status']=0;
				$response['message']=__("Records Not Delete","school-mgt");
			}
			return $response;
		}
		else
		{
			//$message['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['message']=__("Please Fill All Fields",'school-mgt');
		}
		return $response;
	}

}
?>