<?php 

class Notification

{

	public function __construct() 

	{

		add_action('template_redirect', array($this,'redirectMethod'), 1);

	}

	public function redirectMethod()

	{

		

		//error_reporting(0);

			if($_REQUEST['smgt-json-api']=='update_device')

			{			

				//die("Called");

				$response=$this->update_notification($_REQUEST);	 

				if(is_array($response)){

					echo json_encode($response);

				}

				else

				{

					header("HTTP/1.1 401 Unauthorized");

				}

				die();

			}

			if($_REQUEST['smgt-json-api']=='reset_count')

			{					

				$response=$this->count_notification_bicon($_REQUEST);	 

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

	public function update_notification($data)

	{	

            $user_id = get_current_user_id();

			$created_date = date("Y-m-d H:i:s");

			$response=array();

			if($data['student_id']!=null)

			{

				// global $wpdb;

			    // $table_name = "wp_smgt_notification";

				// $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE student_id = %d",$data['student_id']));

				// if($count!=0)

				// {

					// if($data['device_token']!="" && $data['device_type']!="")

					// {		

						// $notification_data=array(

						// 'device_token'=>$data['device_token'],

						// 'device_type'=>$data['device_type']

						// );	

						

						// $response=array();

						

						// $student_id=array('student_id'=>$data['student_id']);

						// $result=$wpdb->update($table_name,$notification_data,$student_id);

						// $response=array();

						// if($result!=0)

						// {

							// $message['message']=__("Record successfully Updated","school-mgt");

							// $response['status']=1;

							// $response['resource']=$message;

						// }

					// }

					// else

					// {

						// $message['message']=__("Please Fill All Fields","school-mgt");

						// $response['status']=0;

						// $response['error']=$message;

					// }

				// }

				// else

				// {

					// $message['message']=__("Student Id Doesn't Exits","school-mgt");

					// $response['status']=0;

					// $response['error']=$message;

				// }

				

				$student_data = get_userdata( $data['student_id'] );

				if(!empty($student_data))

				{

					if($data['device_token']!="" && $data['device_type']!="")

					{

						

						$result=update_user_meta($data['student_id'],'token_id',$data['device_token']);

						$result1=update_user_meta($data['student_id'],'device_type',$data['device_type']);

						

						if($result!=0 || $result1!=0)

						{

							$message['message']=__("Record successfully Updated","school-mgt");

							$response['status']=1;

							$response['resource']=$message;

						}else{

							$message['message']=__("Please Change Data","school-mgt");

							$response['status']=0;

							$response['resource']=$message;

						}

					}

					else

					{

						$message['message']=__("Please Fill All Fields","school-mgt");

						$response['status']=0;

						$response['error']=$message;

					}

				}else

				{

					$message['message']=__("Student Id Doesn't Exits","school-mgt");

					$response['status']=0;

					$response['error']=$message;

				}

		 }

		else

		{

			$message['message']=__("Student Id Doesn't Exits","school-mgt");

			$response['status']=0;

			$response['error']=$message;

		}

		return $response;

	}



	public function count_notification_bicon($data)

	{	

            $response=array();

			if($data['student_id']!=null)

			{

				// global $wpdb;

				// $table_name = "wp_smgt_notification";

				// $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE student_id = %d",$data['student_id']));

				// if($count!=0)

				// {

					// $notification_data1=array('bicon'=>0);	

					// $response=array();

					

					// $student_id=array('student_id'=>$data['student_id']);

					// $result=$wpdb->update($table_name,$notification_data1,$student_id);

					// $response=array();

					// if(false === $result){

						// $message['message']=__("Please Fill All Fields","school-mgt");

						// $response['status']=0;

						// $response['resource']=$message;

					// }

					// else

					// {

						// $message['message']=__("Record successfully Updated","school-mgt");

						// $response['status']=1;

						// $response['resource']=$message;					

					// }

				// }

				// else

				// {

					// $message['message']=__("Student Id Doesn't Exits","school-mgt");

					// $response['status']=0;

					// $response['error']=$message;

				// }

				

				$student_data = get_userdata( $data['student_id'] );

				if(!empty($student_data))

				{

					$icon = get_user_meta($data['student_id'],'bicon',true);

					if($icon != 0)

					{

						$result=update_user_meta($data['student_id'],'bicon','0');

						if(false === $result){

							$message['message']=__("Please Fill All Fields","school-mgt");

							$response['status']=0;

							$response['resource']=$message;

						}

						else

						{

							$message['message']=__("Record successfully Updated","school-mgt");

							$response['status']=1;

							$response['resource']=$message;					

						}

					}

					else{

							$message['message']=__("Record successfully Updated","school-mgt");

							$response['status']=1;

							$response['resource']=$message;	

					}

					

				}else{

					$message['message']=__("Student Id Doesn't Exits","school-mgt");

					$response['status']=0;

					$response['error']=$message;

				}

					

		}

		else

		{

			$message['message']=__("Please Enter Student Id","school-mgt");

			$response['status']=0;

			$response['error']=$message;

		}

		return $response;

	}

} ?>