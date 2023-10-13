<?php 
class HallClass{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='add-hall')
			{	
				$response=$this->add_hall($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='hall-listing')
			{	
				$response=$this->hall_list($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='edit-hall')
			{	
				$response=$this->edit_hall($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='delete-hall')
			{	
				$school_obj = new School_Management($_REQUEST['current_user']);
				if($school_obj->role=='admin'){
					$response=$this->api_delete_hall($_REQUEST);	
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
	public function add_hall($data)
	{	
		$created_date = date("Y-m-d H:i:s");
		if($data['hall_name']!="" && $data['number_of_hall']!="" && $data['hall_capacity']!=""){		
		$hall_data=array('hall_name'=>$_POST['hall_name'],
						'number_of_hall'=>$_POST['number_of_hall'],
						'hall_capacity'=>$_POST['hall_capacity'],
						'description'=>$_POST['description'],
						'date'=>$created_date);
						
			global $wpdb;
			$table_name =$wpdb->prefix . "hall";			
			$result=$wpdb->insert( $table_name, $hall_data);
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
	public function edit_hall($data)
	{	
		$created_date = date("Y-m-d H:i:s");
		if($data['hall_name']!="" && $data['number_of_hall']!="" && $data['hall_capacity']!=""){		
		$hall_data=array('hall_name'=>$_POST['hall_name'],
						'number_of_hall'=>$_POST['number_of_hall'],
						'hall_capacity'=>$_POST['hall_capacity'],
						'description'=>$_POST['description'],
						'date'=>$created_date);
						
			global $wpdb;
			$table_name =$wpdb->prefix . "hall";
			$whereid['hall_id']=$data['hall_id'];
			$result=$wpdb->update( $table_name, $hall_data,$whereid);
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
	public function hall_list($data)
	{	
		$tablename="hall";
		$halldata= get_all_data($tablename);
		if(!empty($halldata)){
			$i=0;
			foreach ($halldata as $retrieved_data){ 
				$result[$i]['hall_id']=$retrieved_data->hall_id;
				$result[$i]['hall_name']=$retrieved_data->hall_name;
				$result[$i]['number_of_hall']=$retrieved_data->number_of_hall;
				$result[$i]['hall_capacity']=$retrieved_data->hall_capacity;
				$result[$i]['description']=$retrieved_data->description;
				$i++;
			}
			$response['status']=1;
			$response['resource']=$result;
			return $response;
		}
		else
		{
			$error['message']=__("Record Empty!",'school-mgt');
			$response['status']=0;
			$response['resource']=$error;
		}
			return $response;
		
	}
	function api_delete_hall($data)
	{		
		$response=array();
		global $wpdb;
		$tablename='hall';
		if($data['hall_id']!=0){
			$result=delete_hall($tablename,$data['hall_id']);
			if($result)
			{
				$message['message']=__("Records Deleted Successfully!",'school-mgt');
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
			$message['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['resource']=$message;
		}
			return $response;
	}
	
} ?>