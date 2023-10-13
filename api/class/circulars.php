<?php 
class Circulars{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			
			//error_reporting(0);
			
			if($_REQUEST["smgt-json-api"]=='circular-listing')
			{
				if(isset($_REQUEST["current_user"]))
				{
					$response=$this->circulars_listing($_REQUEST["current_user"]);	 
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
			if($_REQUEST["smgt-json-api"]=='public-circulars')
			{
				
				$response=$this->public_circulars_listing($_REQUEST["current_user"]);	 
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='add-circular')
			{	
				$response=$this->circular_save($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='edit-circular')
			{	
				$response=$this->circular_edit($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='view-circular')
			{	
				$response=$this->view_circular($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='delete-circular')
			{	
				
				$response=$this->api_delete_circular($_REQUEST['circular_id']);	
			
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
	public function circulars_listing($userid=0)
	{
		if($userid!=0){
			$circulars_obj = new Smgt_Circulars;
			$school_obj = new School_Management($userid);
			$homework_obj = new Smgt_Homework;
			$retrieve_circulars = $this->smgt_get_all_circulars();
		}
		
		if(!empty($retrieve_circulars)){
			$response=array();
			
			$i=0;
			if($school_obj->role=='student'){
				foreach ($retrieve_circulars as $retrieved_data){
				$circular_content="";
				$class_name="";
				/*$strlength= strlen($retrieved_data->post_content);
					if($strlength > 60)
						$circular_content=substr($retrieved_data->post_content, 0,60).'...';
					else
						$circular_content=$retrieved_data->post_content;
					*/
					if(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) =="all")
					{
						$class_name=__('All','school-mgt');
					}
					elseif(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !=""){
						$class_name=get_class_name(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true));
					}
				
					
					$curr_user=$userid;
					$class=get_user_meta($curr_user,'class_name',true);
					$section=get_user_meta($curr_user,'class_section',true);
					
					
					$circular_for=get_post_meta( $retrieved_data->ID, 'circular_for',true);	
					
					$class_circular=get_post_meta($retrieved_data->ID,'smgt_class_id',true);
					$section_circular=get_post_meta($retrieved_data->ID,'smgt_section_id',true);
					if($circular_for=='private'){
					$selected_students = $circulars_obj->smgt_get_students_by_circular($retrieved_data->ID);
					if(!empty($selected_students)){
						if(in_array($curr_user,$selected_students)){
							$circular_data=get_post($retrieved_data->ID);
						}
						else
						{
							continue;
						}
					}
					elseif($section_circular!="")
					{
						if($section_circular==$section)
							$circular_data=get_post($retrieved_data->ID);
						else
							continue;
					}
					elseif($class_circular==$class)
					{
						$circular_data=get_post($retrieved_data->ID);
					}
					
					
					/*elseif($circular_for=='public'){
						$circular_data=get_post($retrieved_data->ID);	
					} */
					if(!empty($circular_data))
						$retrieved_data=$circular_data;
					
					$result[$i]['circular_id']=$retrieved_data->ID;
					$result[$i]['circular_title']=$retrieved_data->post_title;
					$result[$i]['circular_content']=$retrieved_data->post_content;
					$result[$i]['start_date']=smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'start_date',true));
					$result[$i]['end_date']=smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'end_date',true));
					$result[$i]['circular_for']=get_post_meta($retrieved_data->ID, 'circular_for',true);
					$result[$i]['class']=$class_name;
					$circularfile = get_post_meta($retrieved_data->ID, 'circular_file',true);
					if($circularfile!=""){
						$result[$i]['circular_file']=content_url().'/uploads/school_assets/'.$circularfile;
					}
					else{
						$result[$i]['circular_file']="";
					}	
					$i++;
					}
					}
					if(!empty($result))
						$response['resource']=$result;
					else
						$response="";
					return $response;
				}	
				else
				{
					foreach ($retrieve_circulars as $retrieved_data){
					$circular_content="";
					$class_name="";
					/*$strlength= strlen($retrieved_data->post_content);
					if($strlength > 60)
						$circular_content=substr($retrieved_data->post_content, 0,60).'...';
					else
						$circular_content=$retrieved_data->post_content;
						*/
					if(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) =="all")
					{
						$class_name=__('All','school-mgt');
					}
					elseif(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !=""){
						$class_name=get_class_name(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true));
					}
					$circular_for=get_post_meta($retrieved_data->ID,'circular_for',true);
					if($circular_for=='private'){
					$result[$i]['circular_id']=$retrieved_data->ID;
					$result[$i]['circular_title']=$retrieved_data->post_title;
					$result[$i]['circular_content']=$retrieved_data->post_content;
					$result[$i]['start_date']=smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'start_date',true));
					$result[$i]['end_date']=smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'end_date',true));
					$result[$i]['circular_for']=$circular_for;
					$result[$i]['class']=$class_name;
					$circularfile = get_post_meta($retrieved_data->ID, 'circular_file',true);
					if($circularfile!=""){
						$result[$i]['circular_file']=content_url().'/uploads/school_assets/'.$circularfile;
					}
					else{
						$result[$i]['circular_file']="";
					}
					}
					$i++;
					}
					$response['status']=1;
					$response['resource']=$result;
					return $response;
				}
			
			
		}
		else
			{
				$error['message']=__("Please Fill All Fields",'school-mgt');
				$response['status']=0;
				$response['resource']=$error;
			}
			return $response;
	}
	public function public_circulars_listing()
	{
			$retrieve_circulars = $this->smgt_get_all_circulars();
		if(!empty($retrieve_circulars)){
			$i=0;
			foreach ($retrieve_circulars as $retrieved_data){
					$circular_content="";
					$class_name="";
					/*$strlength= strlen($retrieved_data->post_content);
					if($strlength > 60)
						$circular_content=substr($retrieved_data->post_content, 0,60).'...';
					else
						$circular_content=$retrieved_data->post_content; */
			
					
					if(get_post_meta($retrieved_data->ID, 'circular_for',true)=='public'){
						$result[$i]['circular_id']=$retrieved_data->ID;
						$result[$i]['circular_title']=$retrieved_data->post_title;
						$result[$i]['circular_content']=$retrieved_data->post_content;
						$result[$i]['start_date']=smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'start_date',true));
						$result[$i]['end_date']=smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'end_date',true));
						$result[$i]['circular_for']=get_post_meta($retrieved_data->ID, 'circular_for',true);
						$circularfile = get_post_meta($retrieved_data->ID, 'circular_file',true);
						if($circularfile!=""){
							$result[$i]['circular_file']=content_url().'/uploads/school_assets/'.$circularfile;
						}
						else{
							$result[$i]['circular_file']="";
						}
					$i++;
					}
					
					}
					$response['status']=1;
					$response['resource']=$result;
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
	public function smgt_get_all_circulars()
	{
		 $args['post_type'] = 'smgt_circular';
		  $args['posts_per_page'] = -1;
		  $args['post_status'] = 'public';
		  $q = new WP_Query();
		  return $retrieve_class = $q->query( $args );
	}
	
	public function circular_save($data)
	{
		if($data['circular_title']!="" && $data['circular_content']!="" && $data['circular_for']!="" && $data['start_date']!=""&& $data['end_date']!=""){
		
		global $wpdb;
		$table_name=$wpdb->prefix.'smgt_circulars_students';		
		$post_id = wp_insert_post( array(
						'post_status' => 'publish',
						'post_type' => 'smgt_circular',
						'post_title' => $data['circular_title'],
						'post_content' => $data['circular_content']
						
					) );
			if(!empty($data['circular_for']))
			{
				 delete_post_meta($post_id, 'circular_for');
				 $result=add_post_meta($post_id, 'circular_for',$data['circular_for']);
				 $result=add_post_meta($post_id, 'start_date',$data['start_date']);
				 $result=add_post_meta($post_id, 'end_date',$data['end_date']);
				 $result=add_post_meta($post_id, 'circular_file',$data['circular_file_url']);
				
				 if(isset($data['class_id']))
				 $result=add_post_meta($post_id, 'smgt_class_id',$data['class_id']);
				if(isset($data['class_section_id']))
				$result6=update_post_meta($post_id, 'smgt_section_id',$data['class_section_id']);
				$students=array();
				if(isset($data['student_ids']))
					$students=explode(",",$data['student_ids']);
				if(!empty($students)){
					foreach($students as $studentid)
					{
						$circulardata=array('circular_id'=>$post_id,
								 'student_id'=>$studentid);
						$wpdb->insert( $table_name, $circulardata);
					}
				}
			}
			if($result){
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
	public function circular_edit($data)
	{
		if($data['circular_title']!="" && $data['circular_content']!="" && $data['circular_for']!="" && $data['start_date']!=""&& $data['end_date']!="" && $data['circular_id']!=""){
		$circulars_obj = new Smgt_Circulars;	
		global $wpdb;
		$table_name=$wpdb->prefix.'smgt_circulars_students';		
		$args = array('ID'           => $data['circular_id'],
					  'post_title'   => $data['circular_title'],
					  'post_content' =>  $data['circular_content']);
			$result=wp_update_post( $args );
			$post_id=$data['circular_id'];
			if($post_id!=0)
			{
				update_post_meta($post_id, 'circular_for',$data['circular_for']);
				update_post_meta($post_id, 'start_date',$data['start_date']);
				 update_post_meta($post_id, 'end_date',$data['end_date']);
				 update_post_meta($post_id, 'circular_file',$data['circular_file_url']);
				
				 if(isset($data['class_id']))
					update_post_meta($post_id, 'smgt_class_id',$data['class_id']);
				if(isset($data['class_section_id']))
					update_post_meta($post_id, 'smgt_section_id',$data['class_section_id']);
				$students=array();
				if(isset($data['student_ids']))
					$students=explode(",",$data['student_ids']);
				if(!empty($students)){
					 
						 $old_students=$circulars_obj->smgt_get_students_by_circular($post_id);
						 $new_students=$students;
						 $different_insert = array_diff($new_students,$old_students);
						$different_delete = array_diff($old_students,$new_students);	
						if(!empty($different_insert))
						 foreach($different_insert as $studentid)
						 {
							 $circulardata=array('circular_id'=>$post_id,
							 'student_id'=>$studentid);
							 $wpdb->insert( $table_name, $circulardata);
						 }
						 if(!empty($different_delete))
						 foreach($different_delete as $studentid)
						 {
							 $circulardata=array('circular_id'=>$post_id,
							 'student_id'=>$studentid);
							 $wpdb->delete( $table_name, $circulardata);
						 }
				}
			}
			if($result){
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
	function api_delete_circular($circular_id)
	{		
		$response=array();
		$circulars_obj = new Smgt_Circulars;
		if($circular_id!=0){
			$result=$circulars_obj->smgt_delete_circulars($circular_id);
			if($result)
			{
				$message['message']=__("Records Deleted Successfully!","school-mgt");
				$response['status']=1;
				$response['resource']=$message;
			}
			else
			{
				$message['message']=__("Records Not Delete","school-mgt");
				$response['status']=0;
				$response['error']=$message;
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
	public function view_circular($data)
	{	
		$retrieved_data=get_post($data['circular_id']);
		if(!empty($retrieved_data)){
		
				$class_name="";
				
				$circlar_for=get_post_meta($retrieved_data->ID, 'circular_for',true);
				if($retrieved_data->post_type=='smgt_circular' && $circlar_for=='private'){
					$class_name=get_class_name(get_post_meta($retrieved_data->ID, 'smgt_class_id',true));
					$section=get_post_meta($retrieved_data->ID, 'smgt_section_id',true);
				}
					
				$result['circular_id']=$retrieved_data->ID;
				$result['circular_title']=$retrieved_data->post_title;
				$result['circular_content']=$retrieved_data->post_content;
				$result['start_date']=smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'start_date',true));
				$result['end_date']=smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'end_date',true));
				$result['circular_for']=ucfirst($circlar_for);
				if($circlar_for=='private'){
					$result['class']=$class_name;
					$result['section']=smgt_get_section_name($section);
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
} ?>