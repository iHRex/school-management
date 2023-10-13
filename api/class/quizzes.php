<?php 
class QuizzesClass{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
		//error_reporting(0);
			
			if($_REQUEST['smgt-json-api']=='add-quiz-mark')
			{	
				$response=$this->add_quiz_mark($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='show-quiz-mark')
			{	
				
				$response=$this->show_quiz_mark($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='load-child-subjects')
			{	
				$response=$this->load_child_subjects($_REQUEST);	
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
	public function add_quiz_mark($data)
	{		
		
		
		if($data['quize_date']!="" && $data['class_id']!="" && $data['student_id']!="" && $data['subject_id']!="" && $data['marks']!=""){		
		$marksdata=array('quize_date'=>$data['quize_date'],	
		'class_id'=>$data['class_id'],
		'section_id'=>$data['section_id'],
		'student_id'=>$data['student_id'],
		'subject_id'=>$data['subject_id'],
		'marks'=>$data['marks'],
		'marks_comment'=>$data['marks_comment'],
		'created_by'=>$data['current_user_id'],	
		'created_date'=>$created_date);	
		
		$response=array();
		global $wpdb;
		$table_name =$wpdb->prefix . "smgt_quize_marks";
		$result=$wpdb->insert( $table_name, $marksdata);
		
		if($result!=0){
				$message['message']=__("Record successfully Inserted",'school-mgt');
				$response['status']=1;
				$response['resource']=$message;
			}
		else
			{
				$message['message']=__("Record Not Inserted",'school-mgt');
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
	function show_quiz_mark($data)
	{
		
		if($data['child_id']!=""){	
		
			$userid=$data['child_id'];
				
				$subject_id=$data['subject_id'];
				$userid=$data['child_id'];
				
				  $where = '';
				$array_test = array();
				if($userid !="")
					$array_test[] = 'student_id = '.$userid;
				if($subject_id!="")
					$array_test[] = 'subject_id = '.$subject_id;
				
				
				if($data['start_date']!="" && $data['end_date']!="" ){
					$sdate=date("Y-m-d", strtotime($data['start_date']));
					$edate=date("Y-m-d", strtotime($data['end_date']));
					$date_string=" AND (quize_date BETWEEN '$sdate' AND '$edate')";
					$test_string = implode(" AND ",$array_test);
					$test_string .=$date_string;
				}
				elseif($data['start_date']!="" && $data['end_date']=="")
				{
					$startdate=date("Y-m-d", strtotime($data['start_date']));
					$array_test[] = 'quize_date >= "'.$startdate.'"';
					$test_string = implode(" AND ",$array_test);
				}
				elseif($data['start_date']=="" && $data['end_date']!="")
				{
					$startdate=date("Y-m-d", strtotime($data['end_date']));
					$array_test[] = 'quize_date <= "'.$startdate.'"';
					$test_string = implode(" AND ",$array_test);
					
				}
				else
				{
					$test_string = implode(" AND ",$array_test);
				}
				global $wpdb;
				$table_name = $wpdb->prefix . "smgt_quize_marks";
				$sql = "SELECT * FROM $table_name  ";
				if(!empty($array_test))
				{
					$sql .= " Where ";
				}
				$sql .= $test_string;
				
				$result_detail = $wpdb->get_results( $sql);
				
				
				if(!empty($result_detail)){
					$i=0;
					foreach ( $result_detail as $mark_detail ) {
						
						$student_id=$mark_detail->student_id;
						$student=get_userdata($student_id);
						
						$result[$i]['mark_id']=$mark_detail->mark_id;
						$result[$i]['child']=$student->display_name;
						$result[$i]['marks']=$mark_detail->marks;
						$result[$i]['subject_id']=$mark_detail->subject_id;
						$result[$i]['Subject_name']=get_single_subject_name($mark_detail->subject_id);
						$result[$i]['quize_date']=$mark_detail->quize_date;
						$result[$i]['marks_comment']=$mark_detail->marks_comment;
						$i++;
					}
					$response['status']=1;
					$response['resource']=$result;
				}
				else
				{
					$message['message']=__("Record empty",'school-mgt');
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
	function load_child_subjects($data)
	{
		$child_id=$data['child_id'];
		global $wpdb;
		
		
		$school_obj = new School_Management ( get_current_user_id () );
		$class_info = $school_obj->get_user_class_id($child_id);
		
        $retrieve_subject = $school_obj->subject_list($class_info->class_id);
		
		$defaultmsg=__( 'Select subject' , 'school-mgt');
			
		if(!empty($retrieve_subject)){
			$i=1;
		foreach($retrieve_subject as $retrieved_data)
		{
		
			$result[$i]['subject_id']=$retrieved_data->subid;
			$result[$i]['subject_name']=$retrieved_data->sub_name;
			$i++;
		}
		$response['status']=1;
		$response['resource']=$result;
		}
		else
		{
			$message['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['resource']=$message;
		}
			return $response;
	}
	
	
}  ?>