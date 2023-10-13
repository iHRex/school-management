<?php 
class LibraryClass{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			//error_reporting(0);
			//-------------BOOK CATEGORY---------------------
			if($_REQUEST['smgt-json-api']=='add-book-cat')
			{	
				$response=$this->add_book_cat($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='book-cat-list')
			{	
				$response=$this->book_cat_list();	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='delete-book-cat')
			{	
				$response=$this->delete_book_cat($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			//-------------BOOK RACK LOCATION---------------------
			if($_REQUEST['smgt-json-api']=='add-rack-location')
			{	
				$response=$this->add_rack_location($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='rack-location-list')
			{	
				$response=$this->rack_location_list();	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='delete-rack-location')
			{	
				$response=$this->delete_rack_location($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			//-----------------------------------------
			//-------------ISSUE PERIOD----------------
			if($_REQUEST['smgt-json-api']=='add-book-period')
			{	
				$response=$this->add_issue_period($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='book-period-list')
			{	
				$response=$this->issue_period_list();	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='delete-book-period')
			{	
				$response=$this->delete_issue_period($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			//----------------------------------------------
			if($_REQUEST['smgt-json-api']=='add-book')
			{	
				$response=$this->api_add_book($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='book-listing')
			{	
				$response=$this->api_book_list();	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='edit-book')
			{	
				$response=$this->api_edit_book($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='delete-book')
			{	
				$school_obj = new School_Management($_REQUEST['current_user']);
				if($school_obj->role=='admin'){
					$response=$this->api_delete_book($_REQUEST);	
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
			//---------------ISSUE BOOK------------------
			if($_REQUEST['smgt-json-api']=='issue-book')
			{	
				$response=$this->api_issue_book($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='issue-book-listing')
			{	
				$response=$this->api_issue_book_list();	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='edit-issue-book')
			{	
				$response=$this->api_edit_issue_book($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='delete-issue-book')
			{	
				$school_obj = new School_Management($_REQUEST['current_user']);
				if($school_obj->role=='admin'){
					$response=$this->api_delete_issue_book($_REQUEST);	
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
			if($_REQUEST['smgt-json-api']=='student-library-history')
			{	
				
				$response=$this->api_view_student_history($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='return-book')
			{	
				
				$response=$this->api_return_book($_REQUEST);	
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
	
	public function add_book_cat($data)
	{
		if($data['book_category']!=""){
		
		$result = wp_insert_post( array(
						'post_status' => 'publish',
						'post_type' => 'smgt_bookcategory',
						'post_title' => $data['book_category']) );
		
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
	public function book_cat_list()
	{
		$args= array('post_type'=> 'smgt_bookcategory','posts_per_page'=>-1,'orderby'=>'post_title','order'=>'Asc');
		$bookcategorydata = get_posts( $args );	
		if(!empty($bookcategorydata)){
			$i=0;
		foreach($bookcategorydata as $book_cat){
				$result[$i]['book_category_id']=$book_cat->ID;
				$result[$i]['book_category']=$book_cat->post_title;
				$i++;
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
	public function delete_book_cat($data)
	{
		if($data['book_cat_id']!=0 && $data['book_cat_id']!=""){
			$postdata=get_post($data['book_cat_id']);
			
			if($postdata->post_type=='smgt_bookcategory'){
			$result=wp_delete_post($data['book_cat_id']);
			if($result)
			{
				$message['message']=__("Records Deleted Successfully!","school-mgt");
				$response['status']=1;
				$response['resource']=$message;
			}
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
	//------------RACK LOCATION----------------
	public function add_rack_location($data)
	{
		if($data['rack_location_name']!=""){
		
		$result = wp_insert_post( array(
						'post_status' => 'publish',
						'post_type' => 'smgt_rack',
						'post_title' => $data['rack_location_name']) );
		
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
	public function rack_location_list()
	{
		$args= array('post_type'=> 'smgt_rack','posts_per_page'=>-1,'orderby'=>'post_title','order'=>'Asc');
		$bookcategorydata = get_posts( $args );	
		if(!empty($bookcategorydata)){
			$i=0;
		foreach($bookcategorydata as $book_cat){
				$result[$i]['rack_location_id']=$book_cat->ID;
				$result[$i]['rack_location']=$book_cat->post_title;
				$i++;
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
	public function delete_rack_location($data)
	{
		if($data['location_id']!=0 && $data['location_id']!=""){
			$postdata=get_post($data['location_id']);
			
			if($postdata->post_type=='smgt_rack'){
			$result=wp_delete_post($data['location_id']);
			if($result)
			{
				$message['message']=__("Records Deleted Successfully!","school-mgt");
				$response['status']=1;
				$response['resource']=$message;
			}
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
	//-----------------------------------
	//------------Periods----------------
	public function add_issue_period($data)
	{
		if($data['period_title']!=""){
		
		$result = wp_insert_post( array(
						'post_status' => 'publish',
						'post_type' => 'smgt_bookperiod',
						'post_title' => $data['period_title']) );
		
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
	public function issue_period_list()
	{
		$args= array('post_type'=> 'smgt_bookperiod','posts_per_page'=>-1,'orderby'=>'post_title','order'=>'Asc');
		$bookcategorydata = get_posts( $args );	
		if(!empty($bookcategorydata)){
			$i=0;
		foreach($bookcategorydata as $book_cat){
				$result[$i]['book_period_id']=$book_cat->ID;
				$result[$i]['period_title']=$book_cat->post_title;
				$i++;
			}
			$response['status']=1;
			$response['resource']=$result;
			return $response;
		}
		else
		{
			$message['message']=__("Record empty",'school-mgt');
			$response['status']=0;
			$response['resource']=$message;
		}
			return $response;
			
	}
	public function delete_issue_period($data)
	{
		if($data['book_period_id']!=0 && $data['book_period_id']!=""){
			$postdata=get_post($data['book_period_id']);
			
			if($postdata->post_type=='smgt_bookperiod'){
			$result=wp_delete_post($data['book_period_id']);
			if($result)
			{
				$message['message']=__("Records Deleted Successfully!","school-mgt");
				$response['status']=1;
				$response['resource']=$message;
			}
			
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
	//-----------------------------------------
	public function api_add_book($data)
	{	
		if($data['isbn']!="" && $data['book_name']!="" && $data['author_name']!="" && $data['rack_id']!="" && $data['bookcat_id']!=""){		
		$data['action']='insert';
		$obj_lib= new Smgtlibrary();
		$result=$obj_lib->add_book($data);
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
	public function api_edit_book($data)
	{	
		
		if($data['isbn']!="" && $data['book_name']!="" && $data['author_name']!="" && $data['rack_id']!="" && $data['bookcat_id']!="" && $data['book_id']!=""){		
		$data['action']='edit';
		$obj_lib= new Smgtlibrary();
		$result=$obj_lib->add_book($data);
			if($result!=0){
					$message['message']=__("Record successfully Updated",'school-mgt');
					$response['status']=0;
					$response['resource']=$message;
				}
				else
				{
					$message['message']=__("Please change any field",'school-mgt');
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
	public function api_book_list()
	{	
		$obj_lib= new Smgtlibrary();
		$retrieve_books=$obj_lib->get_all_books(); 
		if(!empty($retrieve_books))
		{
			$i=0;
			foreach ($retrieve_books as $retrieved_data)
			{ 		
				$result[$i]['book_id']=$retrieved_data->id;;
				$result[$i]['ISBN']=$retrieved_data->ISBN;
				$result[$i]['book_name']=stripslashes($retrieved_data->book_name);
				$result[$i]['author_name']=stripslashes($retrieved_data->author_name);
				$result[$i]['rack_location']=get_the_title($retrieved_data->rack_location);
				$result[$i]['quentity']=$retrieved_data->quentity;
				$i++;
			}
			$response['status']=1;
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
	function api_delete_book($data)
	{		
		$response=array();
		$obj_lib= new Smgtlibrary();
		if($data['book_id']!=0 && $data['book_id']!=""){
			$result=$obj_lib->delete_book($data['book_id']);
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
	//---------------ISSUE BOOK---------------------------
	public function api_issue_book($data)
	{	
		if($data['class_id']!="" && $data['section_id']!="" && $data['student_id']!="" && $data['issue_date']!="" && $data['period_id']!="" && $data['bookcat_id']!="" && $data['book_ids']!="" && $data['return_date']!=""){		
		$data['action']='insert';
		$obj_lib= new Smgtlibrary();
		$data['book_id']=explode(',',$data['book_ids']);
		$result=$obj_lib->add_issue_book($data);
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
	public function api_edit_issue_book($data)
	{	
		
		if($data['class_id']!="" && $data['section_id']!="" && $data['student_id']!="" && $data['issue_date']!="" && $data['period_id']!="" && $data['bookcat_id']!="" && $data['book_ids']!="" && $data['return_date']!="" && $data['issue_id']!="" && $data['issue_id']!=0){	
		$data['action']='edit';
		
		$obj_lib= new Smgtlibrary();
		$data['book_id']=explode(',',$data['book_ids']);
		$result=$obj_lib->add_issue_book($data);
			if($result!=0){
					$message['message']=__("Record successfully Updated",'school-mgt');
					$response['status']=0;
					$response['resource']=$message;
				}
			else
				{
					$message['message']=__("Please change any field",'school-mgt');
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
	public function api_issue_book_list()
	{	
		$obj_lib= new Smgtlibrary();
		$retrieve_issuebooks=$obj_lib->get_all_issuebooks();
		if(!empty($retrieve_issuebooks)){
			$i=0;
			foreach ($retrieve_issuebooks as $retrieved_data){ 
					
			
				$result[$i]['book_issue_id']=$retrieved_data->id;;
				$result[$i]['student']=get_user_name_byid($retrieved_data->student_id);
				$result[$i]['book_name']=stripslashes(get_bookname($retrieved_data->book_id));
				$result[$i]['issue_date']=smgt_getdate_in_input_box($retrieved_data->issue_date);
				$result[$i]['return_date']=smgt_getdate_in_input_box($retrieved_data->end_date);
				$result[$i]['period']=get_the_title($retrieved_data->period);
				$i++;
			}
			$response['status']=1;						$response['date_formate']	= get_option('smgt_datepicker_format');			
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
	function api_delete_issue_book($data)
	{		
		$response=array();
		$obj_lib= new Smgtlibrary();
		if($data['issuebook_id']!=0 && $data['issuebook_id']!=""){
			$result=$obj_lib->delete_issuebook($data['issuebook_id']);
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
				$message['message']=__("Please Fill All Fields",'school-mgt');
				$response['status']=0;
				$response['resource']=$message;
			}
			return $response;
	}
	function api_view_student_history($data)
	{
		
		if($data['student_id']!="" && $data['student_id']!=0){
			$stud_id=$data['student_id'];
			global $wpdb;
			$table_issuebook=$wpdb->prefix.'smgt_library_book_issue';
			$booklist = $wpdb->get_results("SELECT * FROM $table_issuebook where student_id=$stud_id and status='Issue'");
			$student=get_userdata($stud_id);
			
			if(!empty($booklist)){
				$i=0;
				foreach ($booklist as $retrieved_data){ 
				
						/*$date2=date_create(date("Y-m-d", strtotime($retrieved_data->end_date)));
						$date3=date_create(date("Y-m-d", strtotime($retrieved_data->actual_return_date)));
						$date1=date_create(date("Y-m-d", strtotime($retrieved_data->actual_return_date)));
						$diff=date_diff($date1,$date2);
						
						if($retrieved_data->actual_return_date=='')
						{ 
							$overdue=__("No Returned","school-mgt");
						}
						elseif ($date2 > $date3 && $retrieved_data->actual_return_date!='')
						{
							$overdue= __("0 Days","school-mgt"); 
						}
						elseif($date3 > $date2)
						{ 
							$overdue=$diff->format("%a").__(" Days","school-mgt"); 
						} */
						
					$result[$i]['student']=$student->display_name;
					$result[$i]['book_name']=stripslashes(get_bookname($retrieved_data->book_id));
					$result[$i]['issue_date']=smgt_getdate_in_input_box($retrieved_data->issue_date);
					$result[$i]['return_date']=smgt_getdate_in_input_box($retrieved_data->end_date);
					$result[$i]['period']=get_the_title($retrieved_data->period);
					//$result[$i]['overdue_by']=$overdue;
					$i++;
					
				}
				$response['status']=1;								$response['date_formate']	= get_option('smgt_datepicker_format');				
				$response['resource']=$result;
				return $response;
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
	function api_return_book($data)
	{		
		$response=array();
		$obj_lib= new Smgtlibrary();
		
		if($data['books_return']!="" && $data['fine']!=""){
			$data['books_return']=explode(',',$data['books_return']);
			$data['fine']=explode(',',$data['fine']);
			
			$result=$obj_lib->submit_return_book($data);
			
			if($result)
			{
				$message['message']=__("Book Successfully Submitted!","school-mgt");
				$response['status']=1;
				$response['resource']=$message;
			}
			else
			{
				$message['message']=__("Book Not Submitted","school-mgt");
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