<?php class SubjectListing{
	
	public function __construct(){
		add_action('template_redirect', array($this,'redirectMethod'), 1);
	}
	
	public function redirectMethod()
	{
		error_reporting(0);
		if($_REQUEST['smgt-json-api']=='subject-listing')
		{
			$school_obj = new School_Management($_REQUEST['current_user']);
			if($school_obj->role=='student')
			{
				$response=$this->subject_listing($_REQUEST);
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
	public function subject_listing($data)
	{
		global $wpdb;
		$response=array();
		$tablename="subject";
		$teacherid=0;
		$usemeta=get_userdata($data["current_user"]);
		$array_test = array();
		/* if($data['teacher_id']!="" && $data['teacher_id']!=0)
		$array_test[] = 'teacher_id = '.$data['teacher_id'];
		if($data['class_id']!="" && $data['class_id']!=0)
		$array_test[] = 'class_id = '.$data['class_id'];
		if($data['section_id']!="" && $data['section_id']!=0)
		$array_test[] = 'section_id = '.$data['section_id'];  */
		/* $table_name1 =$wpdb->prefix ."usermeta";		$qqq = "SELECT * FROM $table_name1 where user_id=.'"$data['current_user']."' AND meta_key='class_name'";		var_dump($qqq);die; */
		$class_id=get_user_meta($data['current_user'],'class_name',true);
		$class_section=get_user_meta($data['current_user'],'class_section',true);
		$array_test[] = 'class_id = '.$class_id;
		$array_test[] = 'section_id = '.$class_section;	
		$table_name = $wpdb->prefix ."subject";
		$sql ="SELECT * FROM $table_name";
		$test_string = implode(" AND ",$array_test);
		if(!empty($array_test))
		{
			$sql .= " Where ";
		}
		$sql .= $test_string;
		$subjectdata  = $wpdb->get_results($sql);
		if(!empty($subjectdata))
		{
			$i=0;
			foreach ($subjectdata as $retrieved_data)
			{	
				$result[$i]['id']=$retrieved_data->subid;
				$result[$i]['subject_name']=$retrieved_data->sub_name;
				$uid=$retrieved_data->teacher_id;
				$result[$i]['teacher_id']=$uid;	
				$result[$i]['teacher']=get_teacher($uid);
				$cid=$retrieved_data->class_id;	
				$result[$i]['class_id']=$cid;	
				$result[$i]['class']=get_class_name($cid);
				if($retrieved_data->section_id!=0)
				{ 			
					$result[$i]['section_id']=$retrieved_data->section_id;
					$section_name=smgt_get_section_name($retrieved_data->section_id);
				}
				else
				{ 
					$section_name=__('No Section','school-mgt');
				}
				$result[$i]['section']=$section_name;
				$result[$i]['author_name']=$retrieved_data->author_name;
				$result[$i]['edition']=$retrieved_data->edition;
				$syllabus="";
				if($retrieved_data->syllabus!="")
					$syllabus=content_url().'/uploads/school_assets/'.$retrieved_data->syllabus;				$result[$i]['syllabus_url']=$syllabus;				$i++;			}			$response['status']=1;			$response['resource']=$result;			return $response;		}		else		{			$error['message']=__("Please Fill All Fields",'school-mgt');			$response['status']=0;			$response['resource']=$error;		}			return $response;	}} ?>