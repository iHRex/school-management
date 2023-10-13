<?php 

class PaymentClass{

	public function __construct() {

		add_action('template_redirect', array($this,'redirectMethod'), 1);

		

	}

	public function redirectMethod()

	{

			//error_reporting(0);

			if($_REQUEST['smgt-json-api']=='add-payment')

			{	

				$response=$this->add_payment($_REQUEST);	

				if(is_array($response)){

					echo json_encode($response);

				}

				else

				{

					header("HTTP/1.1 401 Unauthorized");

				}

				die();

			}

			if($_REQUEST['smgt-json-api']=='payment-listing')

			{						

				//$role = smgt_get_role($_REQUEST['current_user']);		

				

				$response	=	$this->payment_list($_REQUEST);			

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

			if($_REQUEST['smgt-json-api']=='edit-payment')

			{	

				$response=$this->edit_payment($_REQUEST);	

				if(is_array($response)){

					echo json_encode($response);

				}

				else

				{

					header("HTTP/1.1 401 Unauthorized");

				}

				die();

			}

			if($_REQUEST['smgt-json-api']=='delete-payment')

			{	

				$school_obj = new School_Management($_REQUEST['current_user']);

				if($school_obj->role=='admin'){

					$response=$this->api_delete_payment($_REQUEST);	

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

			if($_REQUEST['smgt-json-api']=='view-payment')

			{	

				$response=$this->view_payment($_REQUEST);	

				if(is_array($response)){

					echo json_encode($response);

				}

				else

				{

					header("HTTP/1.1 401 Unauthorized");

				}

				die();

			}

			//---------------INCOME --------------------------

			if($_REQUEST['smgt-json-api']=='add-income')

			{	

				$response=$this->add_income($_REQUEST);	

				if(is_array($response)){

					echo json_encode($response);

				}

				else

				{

					header("HTTP/1.1 401 Unauthorized");

				}

				die();

			}

			if($_REQUEST['smgt-json-api']=='income-listing')

			{	

				$response=$this->income_list($_REQUEST);	

				if(is_array($response)){

					echo json_encode($response);

				}

				else

				{

					header("HTTP/1.1 401 Unauthorized");

				}

				die();

			}

			if($_REQUEST['smgt-json-api']=='edit-income')

			{	

				$response=$this->edit_income($_REQUEST);	

				if(is_array($response)){

					echo json_encode($response);

				}

				else

				{

					header("HTTP/1.1 401 Unauthorized");

				}

				die();

			}

			if($_REQUEST['smgt-json-api']=='delete-income')

			{	

				$school_obj = new School_Management($_REQUEST['current_user']);

				if($school_obj->role=='admin'){

					$response=$this->api_delete_income($_REQUEST);	

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

			if($_REQUEST['smgt-json-api']=='view-income')

			{	

				$response=$this->view_income($_REQUEST);	

				if(is_array($response)){

					echo json_encode($response);

				}

				else

				{

					header("HTTP/1.1 401 Unauthorized");

				}

				die();

			}

			

		//---------------EXPENSE --------------------------

			if($_REQUEST['smgt-json-api']=='add-expense')

			{	

				$response=$this->add_expense($_REQUEST);	

				if(is_array($response)){

					echo json_encode($response);

				}

				else

				{

					header("HTTP/1.1 401 Unauthorized");

				}

				die();

			}

			if($_REQUEST['smgt-json-api']=='expense-listing')

			{	

				$response=$this->expense_list($_REQUEST);	

				if(is_array($response)){

					echo json_encode($response);

				}

				else

				{

					header("HTTP/1.1 401 Unauthorized");

				}

				die();

			}

			if($_REQUEST['smgt-json-api']=='edit-expense')

			{	

				$response=$this->edit_expense($_REQUEST);	

				if(is_array($response)){

					echo json_encode($response);

				}

				else

				{

					header("HTTP/1.1 401 Unauthorized");

				}

				die();

			}

			if($_REQUEST['smgt-json-api']=='delete-expense')

			{	

				$school_obj = new School_Management($_REQUEST['current_user']);

				if($school_obj->role=='admin'){

					$response=$this->api_delete_expense($_REQUEST);	

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

			if($_REQUEST['smgt-json-api']=='view-expense')

			{	

				$response=$this->view_expense($_REQUEST);	

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

	public function add_payment($data)

	{	

		if($data['payment_title']!="" && $data['class_id']!="" && $data['student_id']!="" && $data['amount']!="" && $data['payment_status']!=""){		

		$created_date = date("Y-m-d H:i:s");

		$payment_data=array('student_id'=>$data['student_id'],

						'class_id'=>$data['class_id'],

						'section_id'=>$data['section_id'],

						'payment_title'=>$data['payment_title'],

						'description'=>$data['description'],

						'amount'=>$data['amount'],

						'payment_status'=>$data['payment_status'],

						'date'=>$created_date,					

						'payment_reciever_id'=>$data['current_user']);

			global $wpdb;

			$table_name =$wpdb->prefix . "smgt_payment";			

			$result=$wpdb->insert( $table_name, $payment_data);

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

	public function edit_payment($data)

	{	

		

		if($data['payment_title']!="" && $data['class_id']!="" && $data['student_id']!="" && $data['amount']!="" && $data['payment_status']!=""){

		$created_date = date("Y-m-d H:i:s");

		$payment_data=array('student_id'=>$data['student_id'],

						'class_id'=>$data['class_id'],

						'section_id'=>$data['section_id'],

						'payment_title'=>$data['payment_title'],

						'description'=>$data['description'],

						'amount'=>$data['amount'],

						'payment_status'=>$data['payment_status'],

						'date'=>$created_date,					

						'payment_reciever_id'=>$data['current_user']);

						

			global $wpdb;

			$table_name =$wpdb->prefix . "smgt_payment";

			$whereid['payment_id']=$data['payment_id'];

			$result=$wpdb->update( $table_name, $payment_data,$whereid);

			if($result!=0){

					$message['message']=__("Record successfully Updated",'school-mgt');

					$response['status']=0;

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

	public function payment_list($data)

	{			

		

		global $wpdb;		

		$usemeta	=	get_userdata($data["current_user"]);		

		$role= smgt_get_user_role($data["current_user"]);

		$menu_access_data=smgt_get_userrole_wise_access_right_array_in_api($data['current_user'],'feepayment');

		$class_id = get_user_meta($_REQUEST['current_user'],'class_name',true);	

		

		if($role=='student'){			

			if($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 1 )

			{

				$paymentdata	= get_student_payment_list($data["current_user"]);

			}

			elseif($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 0 )

			{

				$paymentdata	= get_student_payment_list($data["current_user"]);

			}

			else

			{

				$paymentdata="";

			}

		}

		

		if(!empty($paymentdata))

		{

			$i=0;

			foreach ($paymentdata as $retrieved_data){ 

				if($retrieved_data->payment_status=='Paid') 

					$status=__('Paid','school-mgt');

				elseif($retrieved_data->payment_status=='Part Paid')

				 	$status=__('Part Paid','school-mgt');

				else

					$status=__('Unpaid','school-mgt');								

				

				$result[$i]['payment_id']=$retrieved_data->payment_id;

				$result[$i]['student']=get_user_name_byid($retrieved_data->student_id);

				$result[$i]['roll_no']=get_user_meta($retrieved_data->student_id, 'roll_id',true);

				$result[$i]['class']=get_class_name($retrieved_data->class_id);

				$result[$i]['payment_title']=$retrieved_data->payment_title;

				$result[$i]['amount']=$retrieved_data->amount;

				$result[$i]['status']=$status;

				$result[$i]['date']= smgt_getdate_in_input_box($retrieved_data->date);

				$i++;

			}

			$response['status']=1;
			
			$response['date_formate']	= get_option('smgt_datepicker_format');
			
			$response['resource']=$result;

			return $response;

		}

		else

		{

			//$message['message']=__("Record not Found","school-mgt");

			$response['status']=0;

			$response['message']=__("Record not Found","school-mgt");

		}

			return $response;

		

	}

	function api_delete_payment($data)

	{		

		$response=array();

		global $wpdb;

		$tablename='smgt_payment';

		if($data['payment_id']!=0 && $data['payment_id']!=""){

			$result=delete_payment($tablename,$data['payment_id']);

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

	public function view_payment($data)

	{	

		

		$retrieved_data=get_payment_by_id($data['payment_id']);

		if(!empty($retrieved_data)){

			$i=0;

			

					if($retrieved_data->payment_status=='Paid') 

								$status=__('Paid','school-mgt');

							elseif($retrieved_data->payment_status=='Part Paid')

							 	$status=__('Part Paid','school-mgt');

							else

								$status=__('Unpaid','school-mgt');

			

			

				$result['payment_id']=$retrieved_data->payment_id;

				$result['student']=get_user_name_byid($retrieved_data->student_id);

				$result['roll_no']=get_user_meta($retrieved_data->student_id, 'roll_id',true);

				$result['class']=get_class_name($retrieved_data->class_id);

				$result['payment_title']=$retrieved_data->payment_title;

				$result['amount']=$retrieved_data->amount;

				$result['status']=$status;

				$result['date']=smgt_getdate_in_input_box($retrieved_data->date);

			

			$response['status']=1;
			
			$response['date_formate']	= get_option('smgt_datepicker_format');


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

	//-----------INCOME---------------

	public function add_income($data)

	{	

		if($data['income_entry']!="" && $data['class_id']!="" && $data['student_id']!="" && $data['payment_status']!=""){		

		$created_date = date("Y-m-d H:i:s");

		global $wpdb;

		$income_data=array('invoice_type'=>'income',

						'class_id'=>$data['class_id'],

						'section_id'=>$data['section_id'],

						'supplier_name'=>$data['student_id'],

						'payment_status'=>$data['payment_status'],

						'entry'=>smgt_strip_tags_and_stripslashes($data['income_entry']),

						'income_create_date'=>$created_date,					

						'create_by'=>$data['current_user']);

			

			$table_name =$wpdb->prefix.'smgt_income_expense';

			$result=$wpdb->insert( $table_name, $income_data);

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

	public function edit_income($data)

	{	

		if($data['income_entry']!="" && $data['class_id']!="" && $data['student_id']!="" && $data['payment_status']!=""){		

		$created_date = date("Y-m-d H:i:s");

		global $wpdb;

		$income_data=array('invoice_type'=>'income',

						'class_id'=>$data['class_id'],

						'section_id'=>$data['section_id'],

						'supplier_name'=>$data['student_id'],

						'payment_status'=>$data['payment_status'],

						'entry'=>stripslashes($data['income_entry']),

						'income_create_date'=>$created_date,					

						'create_by'=>$data['current_user']);

			

			$table_name =$wpdb->prefix.'smgt_income_expense';

			$whereid['income_id']=$data['income_id'];

			$result=$wpdb->update( $table_name, $income_data,$whereid);

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

	public function income_list($data)

	{	

		$obj_invoice= new Smgtinvoice();

		$incomedata=$obj_invoice->get_all_income_data();

		if(!empty($incomedata)){

			$i=0;

			foreach ($incomedata as $retrieved_data){ 

					if($retrieved_data->payment_status=='Paid') 

								$status=__('Paid','school-mgt');

							elseif($retrieved_data->payment_status=='Part Paid')

							 	$status=__('Part Paid','school-mgt');

							else

								$status=__('Unpaid','school-mgt');

			

					$all_entry=json_decode($retrieved_data->entry);

					$total_amount=0;

					foreach($all_entry as $entry){

						$total_amount+=$entry->amount;

					}

				$result[$i]['income_id']=$retrieved_data->income_id;

				$result[$i]['student']=get_user_name_byid($retrieved_data->supplier_name);

				$result[$i]['amount']=$total_amount;

				$result[$i]['date']=smgt_getdate_in_input_box($retrieved_data->income_create_date);

				$i++;

			}

			$response['status']=1;
			
			$response['date_formate']	= get_option('smgt_datepicker_format');


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

	function api_delete_income($data)

	{		

		$response=array();

		$obj_invoice= new Smgtinvoice();

		if($data['income_id']!=0 && $data['income_id']!=""){

			$result=$obj_invoice->delete_income($data['income_id']);

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

	

	public function view_income($data)

	{	

		$obj_invoice= new Smgtinvoice();

		$retrieved_data=$obj_invoice->smgt_get_income_data($data['income_id']);

		if(!empty($retrieved_data)){

				if($retrieved_data->payment_status=='Paid') 

								$status=__('Paid','school-mgt');

							elseif($retrieved_data->payment_status=='Part Paid')

							 	$status=__('Part Paid','school-mgt');

							else

								$status=__('Unpaid','school-mgt');

			

					$all_entry=json_decode($retrieved_data->entry);

					$total_amount=0;

					foreach($all_entry as $entry){

						$total_amount+=$entry->amount;

					}

				$result['income_id']=$retrieved_data->income_id;

				$result['student']=get_user_name_byid($retrieved_data->supplier_name);

				$result['amount']=$total_amount;

				$result['date']=smgt_getdate_in_input_box($retrieved_data->income_create_date);

			

			$response['status']=1;	
			
			$response['date_formate']	= get_option('smgt_datepicker_format');


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

	//-----------EXPENSE---------------

	public function add_expense($data)

	{	

		if($data['expense_entry']!="" && $data['supplier_name']!="" && $data['payment_status']!=""){		

		$created_date = date("Y-m-d H:i:s");

		global $wpdb;

		$expense_data=array('invoice_type'=>'expense',

						'supplier_name'=>$data['supplier_name'],

						'payment_status'=>$data['payment_status'],

						'entry'=>smgt_strip_tags_and_stripslashes($data['expense_entry']),

						'income_create_date'=>$created_date,					

						'create_by'=>$data['current_user']);

			

			$table_name =$wpdb->prefix.'smgt_income_expense';

			$result=$wpdb->insert( $table_name, $expense_data);

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

	public function edit_expense($data)

	{	

		if($data['expense_entry']!="" && $data['supplier_name']!="" && $data['payment_status']!=""){				

		$created_date = date("Y-m-d H:i:s");

		global $wpdb;

		$expense_data=array('invoice_type'=>'expense',

						'supplier_name'=>$data['supplier_name'],

						'payment_status'=>$data['payment_status'],

						'entry'=>stripslashes($data['expense_entry']),

						'income_create_date'=>$created_date,					

						'create_by'=>$data['current_user']);

			

			$table_name =$wpdb->prefix.'smgt_income_expense';

			$whereid['income_id']=$data['expense_id'];

			$result=$wpdb->update( $table_name, $expense_data,$whereid);

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

	public function expense_list($data)

	{	

		$obj_invoice= new Smgtinvoice();

		$expensedata=$obj_invoice->get_all_expense_data();

		if(!empty($expensedata)){

			$i=0;

			foreach ($expensedata as $retrieved_data){ 

					if($retrieved_data->payment_status=='Paid') 

								$status=__('Paid','school-mgt');

							elseif($retrieved_data->payment_status=='Part Paid')

							 	$status=__('Part Paid','school-mgt');

							else

								$status=__('Unpaid','school-mgt');

			

					$all_entry=json_decode($retrieved_data->entry);

					$total_amount=0;

					foreach($all_entry as $entry){

						$total_amount+=$entry->amount;

					}

				$result[$i]['expense_id']=$retrieved_data->income_id;

				$result[$i]['supplier_name']=$retrieved_data->supplier_name;

				$result[$i]['amount']=$total_amount;

				$result[$i]['date']=smgt_getdate_in_input_box($retrieved_data->income_create_date);

				$i++;

			}

			$response['status']=1;
			
			$response['date_formate']	= get_option('smgt_datepicker_format');

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

	function api_delete_expense($data)

	{		

		$response=array();

		$obj_invoice= new Smgtinvoice();

		if($data['expense_id']!=0 && $data['expense_id']!=""){

			$result=$obj_invoice->delete_expense($data['expense_id']);

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

	

	public function view_expense($data)

	{	

		$obj_invoice= new Smgtinvoice();

		$retrieved_data=$obj_invoice->smgt_get_income_data($data['expense_id']);

		if(!empty($retrieved_data)){

				if($retrieved_data->payment_status=='Paid') 

								$status=__('Paid','school-mgt');

							elseif($retrieved_data->payment_status=='Part Paid')

							 	$status=__('Part Paid','school-mgt');

							else

								$status=__('Unpaid','school-mgt');

			

					$all_entry=json_decode($retrieved_data->entry);

					$total_amount=0;

					foreach($all_entry as $entry){

						$total_amount+=$entry->amount;

					}

				$result['expense_id']=$retrieved_data->income_id;

				$result['supplier_name']=$retrieved_data->supplier_name;

				$result['amount']=$total_amount;

				$result['date']=smgt_getdate_in_input_box($retrieved_data->income_create_date);

			

			$response['status']=1;	
			
			$response['date_formate']	= get_option('smgt_datepicker_format');

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