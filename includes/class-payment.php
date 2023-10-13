<?php 
class Smgtinvoice
{
	
	public function generate_invoce_number()
	{
		global $wpdb;
		$table_invoice=$wpdb->prefix.'smgt_invoice';
		
		$result = $wpdb->get_row("SELECT * FROM $table_invoice ORDER BY invoice_id DESC");
		$year = date("y");
		$month = date("m");
		$date = date("d");
		$concat = $year.$month.$date;
		if(!empty($result))
		{	$res = $result->invoice_id + 1;
			return $concat.$res;
		}
		else 
		{
			
			$res = 1;
			return $concat.$res;
		}
	}
	public function smgt_get_invoice_data($invoice_id)
	{
		global $wpdb;
		$table_invoice=$wpdb->prefix.'smgt_invoice';
	
		$result = $wpdb->get_row("SELECT * FROM $table_invoice where invoice_id= ".$invoice_id);
		return $result;
	}
	public function get_all_invoice_data()
	{
		global $wpdb;
		$table_invoice=$wpdb->prefix.'smgt_invoice';
		
		$result = $wpdb->get_results("SELECT * FROM $table_invoice");
		return $result;
		
	}
	public function delete_invoice($invoice_id)
	{
		global $wpdb;
		$table_invoice=$wpdb->prefix.'smgt_invoice';
		$result = $wpdb->query("DELETE FROM $table_invoice where invoice_id= ".$invoice_id);
		return $result;
	}
	public function get_entry_records($data)
	{
			$all_income_entry=$data['income_entry'];
			 $all_income_amount=$data['income_amount'];
			
			$entry_data=array();
			$i=0;
			foreach($all_income_entry as $one_entry)
			{
				$entry_data[]= array('entry'=>smgt_strip_tags_and_stripslashes($one_entry),
							'amount'=>$all_income_amount[$i]);
					$i++;
			}
			return json_encode($entry_data);
	}
	//---------Income----------------
	public function add_income($data)
	{
		
		$entry_value=$this->get_entry_records($data);
		global $wpdb;
		$table_income=$wpdb->prefix.'smgt_income_expense';
		$incomedata['invoice_type']=$data['invoice_type'];
		if(isset($data['class_id']))
			$incomedata['class_id']=MJ_smgt_onlyNumberSp_validation($data['class_id']);
		if(isset($data['class_section']))
			$incomedata['section_id']=MJ_smgt_onlyNumberSp_validation($data['class_section']);
		$incomedata['supplier_name']=MJ_smgt_onlyNumberSp_validation($data['supplier_name']);
		
		
		$incomedata['income_create_date']=$data['invoice_date'];
		
		$incomedata['payment_status']=$data['payment_status'];
		$incomedata['entry']=$entry_value;
		$incomedata['create_by']=get_current_user_id();
		
		if($data['action']=='edit')
		{
			$income_dataid['income_id']=$data['income_id'];
			$result=$wpdb->update( $table_income, $incomedata ,$income_dataid);
			return $result;
		}
		else
		{
			
			$result=$wpdb->insert( $table_income,$incomedata);
			
			return $result;
		}
	}
	public function get_all_income_data()
	{
		global $wpdb;
		$table_income=$wpdb->prefix.'smgt_income_expense';
		
		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income'");
		return $result;
		
	}
	public function smgt_get_income_data($income_id)
	{
		global $wpdb;
		$table_income=$wpdb->prefix.'smgt_income_expense';
	
		$result = $wpdb->get_row("SELECT * FROM $table_income where income_id= ".$income_id);
		return $result;
	}
	public function delete_income($income_id)
	{
		global $wpdb;
		$table_income=$wpdb->prefix.'smgt_income_expense';
		$result = $wpdb->query("DELETE FROM $table_income where income_id= ".$income_id);
		return $result;
	}
	public function get_onepatient_income_data($patient_id)
	{
		global $wpdb;
		$table_income=$wpdb->prefix.'smgt_income_expense';
	
		$result = $wpdb->get_results("SELECT * FROM $table_income where supplier_name= '".$patient_id."' order by income_create_date desc");
		
		return $result;
	}
	//-----------Expense-----------------
	public function add_expense($data)
	{
		
		$entry_value=$this->get_entry_records($data);
		
		global $wpdb;
		$table_income=$wpdb->prefix.'smgt_income_expense';
		$incomedata['invoice_type']=$data['invoice_type'];
		$incomedata['supplier_name']=MJ_smgt_onlyLetter_specialcharacter_validation($data['supplier_name']);
		
		$incomedata['income_create_date']=$data['invoice_date'];
		
		$incomedata['payment_status']=MJ_smgt_onlyLetterSp_validation($data['payment_status']);
		$incomedata['entry']=$entry_value;
		$incomedata['create_by']=get_current_user_id();
		
		if($data['action']=='edit')
		{
			$expense_dataid['income_id']=$data['expense_id'];
			$result=$wpdb->update( $table_income, $incomedata ,$expense_dataid);
			return $result;
		}
		else
		{
			$result=$wpdb->insert( $table_income,$incomedata);
			return $result;
		}
	}
	public function delete_expense($expense_id)
	{
		global $wpdb;
		$table_income=$wpdb->prefix.'smgt_income_expense';
		$result = $wpdb->query("DELETE FROM $table_income where income_id= ".$expense_id);
		return $result;
	}
	public function get_all_expense_data()
	{
		global $wpdb;
		$table_income=$wpdb->prefix.'smgt_income_expense';
		
		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='expense'");
		return $result;
		
	}
	public function get_invoice_created_by($user_id)
	{
		global $wpdb;
		$table_income=$wpdb->prefix.'smgt_payment';
		
		$result = $wpdb->get_results("SELECT * FROM $table_income where created_by=".$user_id);
		return $result;
		
	}
}
?>