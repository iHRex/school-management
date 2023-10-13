<?php 
class HolidayClass{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='add-holiday')
			{	
				$response=$this->add_holiday($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='holiday-listing')
			{	
				$response=$this->holiday_list($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='edit-holiday')
			{	
				$response=$this->edit_holiday($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='delete-holiday')
			{	
				$school_obj = new School_Management($_REQUEST['current_user']);
				if($school_obj->role=='admin'){
					$response=$this->api_delete_holiday($_REQUEST);	
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
	public function add_holiday($data)
	{	
		
		if($data['holiday_title']!="" && $data['start_date']!="" && $data['end_date']!=""){		
		$haliday_data=array('holiday_title'=>$data['holiday_title'],
						'description'=>$data['description'],
						'date'=>date('Y-m-d', strtotime(str_replace('-', '/',$data['start_date']))),
						'end_date'=>date('Y-m-d', strtotime(str_replace('-', '/',$data['end_date']))),
						'created_by'=>$data['current_user']);
						
			global $wpdb;
			$table_name =$wpdb->prefix . "holiday";			
			$result=$wpdb->insert( $table_name, $haliday_data);
			if($result!=0){
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
	public function edit_holiday($data)
	{	
		
		if($data['holiday_title']!="" && $data['start_date']!="" && $data['end_date']!=""){				
		$haliday_data=array('holiday_title'=>$data['holiday_title'],
			'description'=>$data['description'],
			'date'=>date('Y-m-d', strtotime(str_replace('-', '/',$data['start_date']))),
			'end_date'=>date('Y-m-d', strtotime(str_replace('-', '/',$data['end_date']))),
			'created_by'=>$data['current_user']);
						
			global $wpdb;
			$table_name =$wpdb->prefix . "holiday";
			$whereid['holiday_id']=$data['holiday_id'];
			$result=$wpdb->update( $table_name, $haliday_data,$whereid);
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
	public function holiday_list($data)
	{	
		$tablename="holiday";
		 
		$holidaydata= get_all_data($tablename);		
		 
		if(!empty($holidaydata)){
			$i=0;
			foreach ($holidaydata as $retrieved_data){ 
				$result[$i]['holiday_id']=$retrieved_data->holiday_id;
				$result[$i]['holiday_title']=$retrieved_data->holiday_title;
				$result[$i]['start_date']=smgt_getdate_in_input_box($retrieved_data->date);
				//$result[$i]['start_date']=smgt_getdate_in_input_box($retrieved_data->date);
				$result[$i]['start_month']=date("m",strtotime($retrieved_data->date));
				$result[$i]['start_year']=date("Y",strtotime($retrieved_data->date));
				//$result[$i]['end_date']=smgt_getdate_in_input_box($retrieved_data->end_date);
				$result[$i]['end_date']=smgt_getdate_in_input_box($retrieved_data->end_date);
				$result[$i]['end_month']=date("m",strtotime($retrieved_data->end_date));
				$result[$i]['end_year']=date("Y",strtotime($retrieved_data->end_date));
				$result[$i]['description']=$retrieved_data->description;
				$result[$i]['status']=cheak_type_status(get_current_user_id(),'holiday',$retrieved_data->holiday_id);
				$i++;
			}
			$response['status']=1;						$response['date_formate']	= get_option('smgt_datepicker_format');			
			$response['resource']=$result;
			return $response;
		}
		else
		{
			//$message['message']=__("Record empty",'school-mgt');
			$response['status']=0;
			$response['message']=__("Record Not Found",'school-mgt');
		}
			return $response;
		
	}
	function api_delete_holiday($data)
	{		
		$response=array();
		global $wpdb;
		$tablename='holiday';
		if($data['holiday_id']!=0){
			$result=delete_holiday($tablename,$data['holiday_id']);
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
	
} ?>