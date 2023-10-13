<?php 
class TransportClass{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='save-transport')
			{	
				$response=$this->transport_save($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='transport-list')
			{	
				$response=$this->view_transport_list($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='edit-transport')
			{	
				$response=$this->edit_transport($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='delete-transport')
			{	
				$school_obj = new School_Management($_REQUEST['current_user']);
				if($school_obj->role=='admin'){
					$response=$this->api_delete_transport($_REQUEST);	
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
	public function transport_save($data)
	{	
		if($data['route_name']!="" && $data['number_of_vehicle']!="" && $data['vehicle_reg_num']!="" && $data['driver_phone_num']!=""&& $data['driver_name']!="" && $data['driver_address']!="" && $data['route_fare']!=""){		
		$transport_data=array('route_name'=>$data['route_name'],
						'number_of_vehicle'=>$data['number_of_vehicle'],
						'vehicle_reg_num'=>$data['vehicle_reg_num'],
						'smgt_user_avatar'=>$data['smgt_user_avatar'],
						'driver_name'=>$data['driver_name'],
						'driver_phone_num'=>$data['driver_phone_num'],
						'driver_address'=>$data['driver_address'],
						'route_description'=>$data['route_description'],					
						'route_fare'=>$data['route_fare']);
						
			global $wpdb;
			$table_name =$wpdb->prefix . "transport";			
			$result=$wpdb->insert( $table_name, $transport_data);
			if($result!=0){
					$response['status']=1;
					$message['message']=__("Record successfully Inserted",'school-mgt');
					$response['resource']=$message;
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
	public function edit_transport($data)
	{	
		if($data['route_name']!="" && $data['number_of_vehicle']!="" && $data['vehicle_reg_num']!="" && $data['driver_phone_num']!=""&& $data['driver_name']!="" && $data['driver_address']!="" && $data['route_fare']!="" && $data['transport_id']!=""){		
		$transport_data=array('route_name'=>$data['route_name'],
						'number_of_vehicle'=>$data['number_of_vehicle'],
						'vehicle_reg_num'=>$data['vehicle_reg_num'],
						'smgt_user_avatar'=>$data['smgt_user_avatar'],
						'driver_name'=>$data['driver_name'],
						'driver_phone_num'=>$data['driver_phone_num'],
						'driver_address'=>$data['driver_address'],
						'route_description'=>$data['route_description'],					
						'route_fare'=>$data['route_fare']);
						
			global $wpdb;
			$table_name =$wpdb->prefix . "transport";
			$whereid['transport_id']=$data['transport_id'];
			$result=$wpdb->update( $table_name, $transport_data,$whereid);
			if($result!=0){
					$response['status']=1;
					$message['message']=__("Record successfully Updated",'school-mgt');
					$response['resource']=$message;
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
	public function view_transport_list($data)
	{
		$tablename="transport";
		$role= smgt_get_user_role($data["current_user"]);
		$transportdata= get_all_data($tablename);
			 
			if(!empty($transportdata)){
				$i=0;
				foreach ($transportdata as $retrieved_data){ 
					$result[$i]['transport_id']=$retrieved_data->transport_id;
					$result[$i]['route_name']=$retrieved_data->route_name;
					$result[$i]['vehicle_reg_num']=$retrieved_data->vehicle_reg_num;
					$result[$i]['number_of_vehicle']=$retrieved_data->number_of_vehicle;
					$result[$i]['smgt_user_avatar']=$retrieved_data->smgt_user_avatar;
					$result[$i]['driver_name']=$retrieved_data->driver_name;
					$result[$i]['driver_phone_num']=$retrieved_data->driver_phone_num;
					$result[$i]['driver_address']=$retrieved_data->driver_address;
					$result[$i]['route_description']=$retrieved_data->route_description;
					$result[$i]['route_fare']=$retrieved_data->route_fare;
					$i++;
				}
				$response['status']=1;
				$response['resource']=$result;
			}
			else
			{
				//$error['message']=__("Please Fill All Fields",'school-mgt');
				$response['status']=0;
				$response['message']=__("Record not found",'school-mgt');
			}
		 
			return $response;	
	}
	function api_delete_transport($data)
	{		
		$response=array();
		global $wpdb;
		$table_name=$wpdb->prefix.'transport';
		if($data['transport_id']!=0){
			$result = $wpdb->query("DELETE FROM $table_name where transport_id= ".$data['transport_id']);
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
	
} ?>