<?php 
class Hostel {
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			//error_reporting(0);
			if($_REQUEST["smgt-json-api"]=='hostel-listing')
			{
				if(isset($_REQUEST["current_user"]))
				{
					$response=$this->hostel_list($_REQUEST);	 
				}
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
			
			if($_REQUEST["smgt-json-api"]=='room-listing')
			{
				if(isset($_REQUEST["current_user"]) && isset($_REQUEST["hostel_id"]))
				{
					$response=$this->room_list($_REQUEST);	 
				}
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
			if($_REQUEST["smgt-json-api"]=='bed-listing')
			{
				if(isset($_REQUEST["current_user"]) && isset($_REQUEST["room_id"]))
				{
					$response=$this->bed_list($_REQUEST);	 
				}
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
	public function hostel_list($data)


	{


		global $wpdb;


		$tablename="smgt_hostel";


		$response	=	array();


		$role= smgt_get_user_role($data["current_user"]);


		$menu_access_data=smgt_get_userrole_wise_access_right_array_in_api($data['current_user'],'homework');


		


		if($role=='student'){			


			if($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 1 )


			{


				$all_exam	= get_all_data($tablename);	
				


			}


			elseif($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 0 )


			{


				$all_exam	= get_all_data($tablename);		


			}


			else


			{


				$all_exam="";


			}


		}


		if($role=='student')


		{				


			if(!empty($all_exam))


			{				


				foreach ($all_exam as $retrieved_data)


				{					


					$hostel_id =$retrieved_data->id;
					
					$room_data= get_rooms_by_hostel_id($hostel_id);
					
					if(!empty($room_data))
					{
						$room_count=count($room_data);
					}
					else{
						
						$room_count=0;
					}
					
					$bed_data= get_beds_by_hostel_id($hostel_id);
					
					if(!empty($bed_data))
					{
						$bed_count=count($bed_data);
					}
					else{
						
						$bed_count=0;
					}
					
					$exam_array	=	array(


						'hostel_id'	=>$retrieved_data->id,
						
						'hostel_name'	=>$retrieved_data->hostel_name,

						'hostel_type'	=>$retrieved_data->hostel_type,
						
						'Description'	=>$retrieved_data->Description,
						
						'room_count'	=>$room_count,
						
						'bed_count'	=>$bed_count,

					);


					$result_array[]	=	$exam_array;		


				}


				$response['status']	=	1;
				
				$response['resource']	=	$result_array;


			}


			else


			{


				//$error['message']=__("Please Fill All Fields",'school-mgt');


				$response['status']	=	0;


				$response['message']	=__("Please Fill All Fields",'school-mgt');


			}


			


		}


		else


		{


			//$error['message']=__("No Record Found",'school-mgt');


			$response['status']=0;


			$response['message']=__("No Record Found",'school-mgt');


		}


		return $response;	


	}
	public function room_list($data)


	{


		global $wpdb;


		$tablename="smgt_room";


		$response	=	array();


		$role= smgt_get_user_role($data["current_user"]);


		$menu_access_data=smgt_get_userrole_wise_access_right_array_in_api($data['current_user'],'homework');

		$hostel_id= $data["hostel_id"];
		


		if($role=='student'){			


			if($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 1 )


			{


				$all_exam	= get_rooms_by_hostel_id($hostel_id);	
			

			}


			elseif($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 0 )


			{


				$all_exam	= get_rooms_by_hostel_id($hostel_id);		


			}


			else


			{


				$all_exam="";


			}


		}


		if($role=='student')


		{				


			if(!empty($all_exam))


			{				


				foreach ($all_exam as $retrieved_data)


				{					


					$room_id =$retrieved_data->id;
					
					$room_cnt =smgt_hostel_room_status_check($retrieved_data->id);
								
					$bed_capacity=(int)$retrieved_data->beds_capacity;
					
					if($room_cnt >= $bed_capacity)
					{
						$availability='Occupied';
					}
					else 
					{
						$availability='Available';
					
					}

					$exam_array	=	array(


						'room_id'	=>$retrieved_data->id,
						
						'room_unique_id'	=>$retrieved_data->room_unique_id,
						
						'hostel_name'	=>smgt_get_hostel_name_by_id($retrieved_data->hostel_id),
						
						'room_category'	=>get_the_title($retrieved_data->room_category),
						
						'beds_capacity'	=>$retrieved_data->beds_capacity,
						
						'availability'	=>$availability,
						
						'room_description'	=>$retrieved_data->room_description,
				

					);


					$result_array[]	=	$exam_array;		


				}


				$response['status']	=	1;
				
				$response['resource']	=	$result_array;


			}


			else


			{


				//$error['message']=__("Please Fill All Fields",'school-mgt');


				$response['status']	=	0;


				$response['message']	=__("Please Fill All Fields",'school-mgt');


			}


			


		}


		else


		{


			//$error['message']=__("No Record Found",'school-mgt');


			$response['status']=0;


			$response['message']=__("No Record Found",'school-mgt');


		}


		return $response;	


	}
	public function bed_list($data)


	{


		global $wpdb;


		$tablename="smgt_beds";


		$response	=	array();


		$role= smgt_get_user_role($data["current_user"]);


		$menu_access_data=smgt_get_userrole_wise_access_right_array_in_api($data['current_user'],'homework');

		$room_id= $data["room_id"];
		


		if($role=='student'){			


			if($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 1 )


			{


				$all_exam	= get_beds_by_room_id($room_id);




			}


			elseif($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 0 )


			{


				$all_exam	= get_beds_by_room_id($room_id);



			}


			else


			{


				$all_exam="";


			}


		}


		if($role=='student')


		{				


			if(!empty($all_exam))


			{				
			

				$hostel_name= get_hostel_name_by_room_id($room_id);
				
				foreach ($all_exam as $retrieved_data)


				{					


					$bed_id =$retrieved_data->id;
					
					
					if($retrieved_data->bed_status == '0')
					{
						$availability='Available';
					}
					else 
					{
						$availability='Occupied';
					
					}

					$exam_array	=	array(


						'bed_id'	=>$retrieved_data->id,
						
						'hostel_name'	=>$hostel_name,
						
						'bed_unique_id'	=>$retrieved_data->bed_unique_id,
						
						'room_id'	=>smgt_get_room_unique_id_by_id($retrieved_data->room_id),
						
						'availability'	=>$availability,
						
						'bed_description'	=>$retrieved_data->bed_description,
				

					);


					$result_array[]	=	$exam_array;		


				}


				$response['status']	=	1;
				
				$response['resource']	=	$result_array;


			}


			else


			{


				//$error['message']=__("Please Fill All Fields",'school-mgt');


				$response['status']	=	0;


				$response['message']	=__("Please Fill All Fields",'school-mgt');


			}


			


		}


		else


		{


			//$error['message']=__("No Record Found",'school-mgt');


			$response['status']=0;


			$response['message']=__("No Record Found",'school-mgt');


		}


		return $response;	


	}
	
} ?>