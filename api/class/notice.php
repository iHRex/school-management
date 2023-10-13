<?php 
class NoticeClass{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
	}
	public function redirectMethod()
	{
			if($_REQUEST['smgt-json-api']=='add-notice')
			{	
				$response=$this->notice_save($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='notice-list')
			{	
				$school_obj = new School_Management($_REQUEST['current_user']);
				//if($school_obj->role=='student'){
					$response=$this->view_notice_list($_REQUEST);
				//}			
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='edit-notice')
			{	
				$response=$this->edit_notice($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='delete-notice')
			{	
				$school_obj = new School_Management($_REQUEST['current_user']);
				if($school_obj->role=='admin'){
					$response=$this->api_delete_notice($_REQUEST);	
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
			if($_REQUEST['smgt-json-api']=='view-notice')
			{	
				$response=$this->view_notice($_REQUEST);	
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
	public function notice_save($data)
	{	
		
		if($data['notice_title']!="" && $data['notice_content']!="" && $data['notice_for']!="" && $data['start_date']!=""&& $data['end_date']!="")
		{
			$post_id = wp_insert_post( array(
				'post_status' => 'publish',
				'post_type' => 'notice',
				'post_title' => $data['notice_title'],
				'post_content' => $data['notice_content']
			) );
		
			if(!empty($_POST['notice_for']))
			{
				 delete_post_meta($post_id, 'notice_for');
				 $result=add_post_meta($post_id, 'notice_for',$data['notice_for']);
				 $result=add_post_meta($post_id, 'start_date',$data['start_date']);
				 $result=add_post_meta($post_id, 'end_date',$data['end_date']);
				 if(isset($data['class_id']))
				 $result=add_post_meta($post_id, 'smgt_class_id',$data['class_id']);
				 if(isset($data['class_section_id']))
				 $result6=update_post_meta($post_id, 'smgt_section_id',$data['class_section_id']);
			}
			if($result)
			{
				$message['message']=__("Record successfully Inserted",'school-mgt');
				$response['status']=1;
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
	
	
	public function edit_notice($data)
	{	
		if($data['notice_id']!="" && $data['notice_title']!="" && $data['notice_content']!="" && $data['notice_for']!="" && $data['start_date']!=""&& $data['end_date']!=""){		
		$args = array(
						  'ID'           => $data['notice_id'],
						  'post_title'   => $data['notice_title'],
						  'post_content' =>  $data['notice_content'],
						 
					  	);
			$result=wp_update_post( $args );
			$result2=update_post_meta($data['notice_id'], 'notice_for', $data['notice_for']);
			$result3=update_post_meta($data['notice_id'], 'start_date',$data['start_date']);
			$result4=update_post_meta($data['notice_id'], 'end_date',$data['end_date']);
			if(isset($_POST['class_id']))
			$result5=update_post_meta($data['notice_id'], 'smgt_class_id',$data['class_id']);
			if(isset($_POST['class_section']))
			$result6=update_post_meta($data['notice_id'], 'smgt_section_id',$data['class_section']);
			if($result!=0){
				
					$message['message']=__("Record successfully Updated",'school-mgt');
					$response['status']=1;
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
public function view_notice_list($data)
{	
	$role = smgt_get_role($data['current_user']);
	$menu_access_data=smgt_get_userrole_wise_access_right_array_in_api($data['current_user'],'notice');	
 	if($role[0]=='student')
	{
		if($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 1 )
		{
			$class_name  	= 	get_user_meta($data['current_user'],'class_name',true);		
			$class_section  = 	get_user_meta($data['current_user'],'class_section',true);	
			$noticedata = student_notice_dashbord($class_name,$class_section);
		}
		elseif($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 0 )
		{
			$args['post_type'] = 'notice';
			$args['posts_per_page'] = -1;
			$args['post_status'] = 'public';
			$q = new WP_Query();
			$noticedata = $q->query( $args );
		}
		else
		{
			$noticedata="";
		}
		$i=0;
		if(!empty($noticedata))
		{	
			$result =array();
			foreach ($noticedata as $retrieved_data)
			{
				$notice_content="";
				$class_name="";
				$strlength= strlen($retrieved_data->post_content);
				if($strlength > 60)
				{
					$notice_content=substr($retrieved_data->post_content, 0,60).'...';
				}
				else
				{
					$notice_content=$retrieved_data->post_content;
				}
				if(get_post_meta($retrieved_data->ID, 'smgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) =="all")
				{
					$class_name=__('all','school-mgt');
					 
				}
				elseif(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !="")
				{
					$class_name=get_class_name(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true));
				} 		
				$result[$i]['notice_id']	=	$retrieved_data->ID;
				$result[$i]['notice_title']	=	$retrieved_data->post_title;
				$result[$i]['notice_content']	=	$notice_content;
				$result[$i]['start_date']	=	smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'start_date',true));
				$result[$i]['start_month']	=	date("m",strtotime(get_post_meta($retrieved_data->ID,'start_date',true)));
				$result[$i]['start_year']	=	date("Y",strtotime(get_post_meta($retrieved_data->ID,'start_date',true)));
				$result[$i]['end_date']	   =	smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'end_date',true));
				$result[$i]['end_month']	=	date("m",strtotime(get_post_meta($retrieved_data->ID,'end_date',true)));
				$result[$i]['end_year']		=	date("Y",strtotime(get_post_meta($retrieved_data->ID,'end_date',true)));
				$result[$i]['notice_for']	=	get_post_meta($retrieved_data->ID , 'notice_for',true);
				$result[$i]['standard']		=	$class_name;
				$result[$i]['Status']		=	cheak_type_status($data["current_user"],'notice',$retrieved_data->ID);
				$i++;
			}
			$response['status']=1;						$response['date_formate']	= get_option('smgt_datepicker_format');
			$response['resource']=$result;	
			return $response;
		}
		else
		{
			$response['status']=0;
			$response['message']=__("Record Not Found",'school-mgt');
		} 
		/* global $wpdb;
		$usemeta=get_userdata($data["current_user"]);
		$user_class_id = get_user_meta($usemeta->ID,'class_name',true);
		$args['post_type'] = 'notice';
		$args['posts_per_page'] = -1;
		$args['post_status'] = 'public';		 
		$q = new WP_Query();
		$noticedata = $q->query( $args );
		$i=0;
		if(!empty($noticedata))
		{	
			$result =array();
			foreach ($noticedata as $retrieved_data)
			{
				$notice_for=get_post_meta($retrieved_data->ID , 'notice_for',true);	
			 
				if($notice_for=='student')
				{				
					$notice_content="";
					$class_name="";
					$strlength= strlen($retrieved_data->post_content);
					if($strlength > 60)
						$notice_content=substr($retrieved_data->post_content, 0,60).'...';
					else
						$notice_content=$retrieved_data->post_content;
					
					if(get_post_meta($retrieved_data->ID, 'smgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) =="all")
					{
						$class_name=__('all','school-mgt');
						 
					}
					elseif(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !="")
					{
						$class_name=get_class_name(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true));
					} 				
					if($user_class_id == get_post_meta( $retrieved_data->ID, 'smgt_class_id',true))
					{
						$result[$i]['notice_id']	=	$retrieved_data->ID;
						$result[$i]['notice_title']	=	$retrieved_data->post_title;
						$result[$i]['notice_content']	=	$notice_content;
						$result[$i]['start_date']	=	date('d-m-Y',strtotime(get_post_meta($retrieved_data->ID,'start_date',true)));
						$result[$i]['start_month']	=	date("m",strtotime(get_post_meta($retrieved_data->ID,'start_date',true)));
						$result[$i]['start_year']	=	date("Y",strtotime(get_post_meta($retrieved_data->ID,'start_date',true)));
						$result[$i]['end_date']	=	date('d-m-Y',strtotime(get_post_meta($retrieved_data->ID,'end_date',true)));
						$result[$i]['end_month']	=	date("m",strtotime(get_post_meta($retrieved_data->ID,'end_date',true)));
						$result[$i]['end_year']		=	date("Y",strtotime(get_post_meta($retrieved_data->ID,'end_date',true)));
						$result[$i]['notice_for']	=	get_post_meta($retrieved_data->ID , 'notice_for',true);
						$result[$i]['standard']		=	$class_name;
						$result[$i]['Status']		=	cheak_type_status($data["current_user"],'notice',$retrieved_data->ID);
						 $i++;						
					}
					elseif($class_name=="all" && $notice_for=='student')
					{
						$result[$i]['notice_id']	=	$retrieved_data->ID;
						$result[$i]['notice_title']	=	$retrieved_data->post_title;
						$result[$i]['notice_content']	=	$notice_content;
						$result[$i]['start_date']	=	date('d-m-Y',strtotime(get_post_meta($retrieved_data->ID,'start_date',true)));
						$result[$i]['start_month']	=	date("m",strtotime(get_post_meta($retrieved_data->ID,'start_date',true)));
						$result[$i]['start_year']	=	date("Y",strtotime(get_post_meta($retrieved_data->ID,'start_date',true)));
						$result[$i]['end_date']	=	    date('d-m-Y',strtotime(get_post_meta($retrieved_data->ID,'end_date',true)));
						$result[$i]['end_month']	=	date("m",strtotime(get_post_meta($retrieved_data->ID,'end_date',true)));
						$result[$i]['end_year']		=	date("Y",strtotime(get_post_meta($retrieved_data->ID,'end_date',true)));
						$result[$i]['notice_for']	=	get_post_meta($retrieved_data->ID , 'notice_for',true);
						$result[$i]['standard']		=	$class_name;
						$result[$i]['Status']		=	cheak_type_status($data["current_user"],'notice',$retrieved_data->ID);
						$i++;
					}
					
				}
				elseif($notice_for=='all')
				{
					$result[$i]['notice_id']	=	$retrieved_data->ID;
					$result[$i]['notice_title']	=	$retrieved_data->post_title;
					$result[$i]['notice_content']	=	$notice_content;
					$result[$i]['start_date']	=	date('d-m-Y',strtotime(get_post_meta($retrieved_data->ID,'start_date',true)));
					$result[$i]['start_month']	=	date("m",strtotime(get_post_meta($retrieved_data->ID,'start_date',true)));
				    $result[$i]['start_year']	=	date("Y",strtotime(get_post_meta($retrieved_data->ID,'start_date',true)));
					$result[$i]['end_date']	=	date('d-m-Y',strtotime(get_post_meta($retrieved_data->ID,'end_date',true)));
					$result[$i]['end_month']	=	date("m",strtotime(get_post_meta($retrieved_data->ID,'end_date',true)));
					$result[$i]['end_year']		=	date("Y",strtotime(get_post_meta($retrieved_data->ID,'end_date',true)));
					$result[$i]['notice_for']	=	get_post_meta($retrieved_data->ID , 'notice_for',true);
					$result[$i]['standard']		=	$class_name;
					$result[$i]['Status']		=	cheak_type_status($data["current_user"],'notice',$retrieved_data->ID);
					$i++;
				}
			}
			 
			$response['status']=1;
			$response['resource']=$result;	
			 
			return $response;
		}
		else
		{
			$response['status']=0;
			$response['message']=__("Record Not Found",'school-mgt');
		} */
	} 
	else
	{
		$response['status']=0;
		$response['message']=__("Record Not Found",'school-mgt');
	}
	return $response;
}
	
	function api_delete_notice($data)
	{		
		$response=array();
		if($data['notice_id']!=0){
			$result=wp_delete_post($data['notice_id']);
			if($result)
			{
				$response['status']=1;
				$message['message']=__("Records Deleted Successfully!",'school-mgt');
				$response['resource']=$message;
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
			$message['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['resource']=$message;
		}
			return $response;
	}
	public function view_notice($data)
	{	
		$retrieved_data=get_post($data['notice_id']);
		if(!empty($retrieved_data)){
		
				$class_name="";
				if(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) =="all")
				{
					$class_name=__('All','school-mgt');
				}
				elseif(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !=""){
					$class_name=get_class_name(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true));
				}
					
				$result['notice_id']=$retrieved_data->ID;
				$result['notice_title']=$retrieved_data->post_title;
				$result['notice_content']=$retrieved_data->post_content;
				$result['start_date']=smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'start_date',true));
				$result['end_date']=smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'end_date',true));
				$result['notice_for']=get_post_meta($retrieved_data->ID, 'notice_for',true);
				$result['class']=$class_namel;
			
			$response['status']=1;			$response['date_formate']	= get_option('smgt_datepicker_format');			
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
} ?>