<?php 
class Smgt_custome_field
{  /*<---START Lmgt_custome_field  CLASS--->*/
	/*<--- ADD CustomeField FUNCTION --->*/
	function Smgt_add_custom_field($custome_data) 
	{
			
		global $wpdb;
		$wpnc_custom_fields = $wpdb->prefix . 'custom_field';
		$wpnc_custom_field_dropdown_metas = $wpdb->prefix . 'custom_field_dropdown_metas';		
		
		$custom_field_data['field_label']=$custome_data['field_label'];	
		$validation_array_filter=array_filter($custome_data['validation']);	
		 
		 
		$custom_field_data['field_validation']=implode('|',$validation_array_filter);
		
		if($custome_data['field_visibility']=='')
		{
			$custom_field_data['field_visibility']=0;
		}
		else
		{
			$custom_field_data['field_visibility']=$custome_data['field_visibility'];
		}	
		
		if($custome_data['action']=='edit')	
		{ 	
			$custom_field_data['updated_by']=get_current_user_id();
			$custom_field_data['updated_at']=date("Y-m-d H:i:s");
			
			$whereid['id']=$custome_data['custom_field_id'];
			
			$update_custom_field=$wpdb->update($wpnc_custom_fields, $custom_field_data, $whereid);
			
			// Dropdown Label Code
			if(isset($custome_data['d_label']))
			{
				$d_label = $custome_data['d_label'];
			}
            else
			{
				$d_label =null;
			}
			if(!empty($d_label))
			{
				//delete old value 
				$delete_custom_field_dropdown_data = $wpdb->query("DELETE FROM $wpnc_custom_field_dropdown_metas where custom_fields_id= ".$custome_data['custom_field_id']);
				
				foreach ($d_label as $key => $value)
				{
					$label = $d_label[$key];
										
					$custom_field_dropdown_data['custom_fields_id']=$custome_data['custom_field_id'];
					$custom_field_dropdown_data['option_label']=$label;
					$custom_field_dropdown_data['created_by']=get_current_user_id();
					$custom_field_dropdown_data['created_at']=date("Y-m-d H:i:s");
					$custom_field_dropdown_data['updated_by']=get_current_user_id();
					$custom_field_dropdown_data['updated_at']=date("Y-m-d H:i:s");
					
					$insert_custom_field_dropdown_data=$wpdb->insert($wpnc_custom_field_dropdown_metas, $custom_field_dropdown_data );
					
				}
			}
			
			// Checkbox Label Code
			if(isset($custome_data['c_label']))
			{
				$c_label =$custome_data['c_label'];
			}
            else
			{
				$c_label =null;
			}
			
			if(!empty($c_label))
			{
				//delete old value 
				$delete_custom_field_checkbox_data = $wpdb->query("DELETE FROM $wpnc_custom_field_dropdown_metas where custom_fields_id= ".$custome_data['custom_field_id']);
				
				foreach ($c_label as $key => $value)
				{
					$label = $c_label[$key];
					
					$custom_field_checkbox_data['custom_fields_id']=$custome_data['custom_field_id'];
					$custom_field_checkbox_data['option_label']=$label;
					$custom_field_checkbox_data['created_by']=get_current_user_id();
					$custom_field_checkbox_data['created_at']=date("Y-m-d H:i:s");
					$custom_field_checkbox_data['updated_by']=get_current_user_id();
					$custom_field_checkbox_data['updated_at']=date("Y-m-d H:i:s");
					
					$insert_custom_field_checkbox_data=$wpdb->insert($wpnc_custom_field_dropdown_metas, $custom_field_checkbox_data );
				}
			}
			
			// Radio Label Code
			if(isset($custome_data['r_label']))
			{
				$r_label = $custome_data['r_label'];
			}
            else
			{
				$r_label =null;
			}
			
			if(!empty($r_label))
			{
				//delete old value 
				$delete_custom_field_radio_data = $wpdb->query("DELETE FROM $wpnc_custom_field_dropdown_metas where custom_fields_id= ".$custome_data['custom_field_id']);
				
				foreach ($r_label as $key => $value)
				{
					$label = $r_label[$key];
					
					$custom_field_radio_data['custom_fields_id']=$custome_data['custom_field_id'];
					$custom_field_radio_data['option_label']=$label;
					$custom_field_radio_data['created_by']=get_current_user_id();
					$custom_field_radio_data['created_at']=date("Y-m-d H:i:s");
					$custom_field_radio_data['updated_by']=get_current_user_id();
					$custom_field_radio_data['updated_at']=date("Y-m-d H:i:s");
					
					$insert_custom_field_radio_data=$wpdb->insert($wpnc_custom_field_dropdown_metas, $custom_field_radio_data );
				}
			}
			return $custome_data['custom_field_id'];
		}
		else
		{ 
			$custom_field_data['form_name']=$custome_data['form_name'];
			$custom_field_data['field_type']=$custome_data['field_type'];
			 	
			 
			$custom_field_data['created_by']=get_current_user_id();
			$custom_field_data['created_at']=date("Y-m-d H:i:s");
			
			$insert_custom_field=$wpdb->insert($wpnc_custom_fields, $custom_field_data );	
            $custom_field_id = $wpdb->insert_id;		
			
			// Dropdown Label Code
		
			if(isset($custome_data['d_label']))
			{
				$d_label = $custome_data['d_label'];
			}
            else
			{
				$d_label =null;
			}

			if(!empty($d_label))
			{
				foreach ($d_label as $key => $value)
				{
					$label = $d_label[$key];
										
					$custom_field_dropdown_data['custom_fields_id']=$custom_field_id;
					$custom_field_dropdown_data['option_label']=$label;
					$custom_field_dropdown_data['created_by']=get_current_user_id();
					$custom_field_dropdown_data['created_at']=date("Y-m-d H:i:s");
					$custom_field_dropdown_data['updated_by']=get_current_user_id();
					$custom_field_dropdown_data['updated_at']=date("Y-m-d H:i:s");
					
					$insert_custom_field_dropdown_data=$wpdb->insert($wpnc_custom_field_dropdown_metas, $custom_field_dropdown_data );
				}
			}
			
			// Checkbox Label Code
			
			if(isset($custome_data['c_label']))
			{
				$c_label =$custome_data['c_label'];
			}
            else
			{
				$c_label =null;
			}
			if(!empty($c_label))
			{
				foreach ($c_label as $key => $value)
				{
					$label = $c_label[$key];
					
					$custom_field_checkbox_data['custom_fields_id']=$custom_field_id;
					$custom_field_checkbox_data['option_label']=$label;
					$custom_field_checkbox_data['created_by']=get_current_user_id();
					$custom_field_checkbox_data['created_at']=date("Y-m-d H:i:s");
					$custom_field_checkbox_data['updated_by']=get_current_user_id();
					$custom_field_checkbox_data['updated_at']=date("Y-m-d H:i:s");
					
					$insert_custom_field_checkbox_data=$wpdb->insert($wpnc_custom_field_dropdown_metas, $custom_field_checkbox_data );
				}
			}
			
			// Radio Label Code
			if(isset($custome_data['r_label']))
			{
				$r_label = $custome_data['r_label'];
			}
            else
			{
				$r_label =null;
			}
			
			if(!empty($r_label))
			{
				foreach ($r_label as $key => $value)
				{
					$label = $r_label[$key];
					
					$custom_field_radio_data['custom_fields_id']=$custom_field_id;
					$custom_field_radio_data['option_label']=$label;
					$custom_field_radio_data['created_by']=get_current_user_id();
					$custom_field_radio_data['created_at']=date("Y-m-d H:i:s");
					$custom_field_radio_data['updated_by']=get_current_user_id();
					$custom_field_radio_data['updated_at']=date("Y-m-d H:i:s");
					
					$insert_custom_field_radio_data=$wpdb->insert($wpnc_custom_field_dropdown_metas, $custom_field_radio_data );
				}
			}
		    
			return $custom_field_id;
		}
	}
	  //Get All Custom Field Data Function//
	function Smgt_get_all_custom_field_data()
	{
		global $wpdb;
		$wpnc_custom_fields = $wpdb->prefix . 'custom_field';
		$get_custom_field_data = $wpdb->get_results("SELECT * FROM $wpnc_custom_fields where field_visibility!=2");
		return $get_custom_field_data;
	}
	//Get Single Custom Field Data Function//
	function Smgt_get_single_custom_field_data($custom_fields_id)
	{
		global $wpdb;
		$wpnc_custom_fields = $wpdb->prefix . 'custom_field';
		$single_custom_field_data = $wpdb->get_row("SELECT * FROM $wpnc_custom_fields where id=".$custom_fields_id);
		return $single_custom_field_data;
	}
	//Get Single Custom Field Dropdown Meta Data By Custom Field Id Function//
	function Smgt_get_single_custom_field_dropdown_meta_data($custom_field_id)
	{
		global $wpdb;
		$wpnc_custom_field_dropdown_metas = $wpdb->prefix . 'custom_field_dropdown_metas';
		$custom_field_dropdown_meta_data = $wpdb->get_results("SELECT * FROM $wpnc_custom_field_dropdown_metas where custom_fields_id=".$custom_field_id);
		return $custom_field_dropdown_meta_data;
	}
	/*<---DELETE Custom Field  FUNCTION--->*/
	public function Smgt_delete_custome_field($id)
	{
		global $wpdb;
		$wpnc_custom_fields = $wpdb->prefix . 'custom_field';
		$custom_field['field_visibility']=2;
		$whereid['id']=$id;
		$delete_rules=$wpdb->update($wpnc_custom_fields, $custom_field, $whereid);
		return $delete_rules;
	}
	/*<---DELETE MULTIPLE RECORD  FUNCTION--->*/
	public function Smgt_delete_selected_custome_field($record_id)
	{	
	
		global $wpdb;
		$wpnc_custom_fields = $wpdb->prefix . 'custom_field';
		$custom_field['field_visibility']=2;
		$whereid['id']=$record_id;
		$result=$wpdb->update($wpnc_custom_fields, $custom_field, $whereid);
		return $result;
	}
	//Get Custom Field By Module Function//
	function Smgt_getCustomFieldByModule($module) 
	{		
		global $wpdb;
		$wpnc_custom_fields = $wpdb->prefix . 'custom_field';
 
		$get_data = $wpdb->get_results("SELECT * FROM $wpnc_custom_fields where form_name='$module' AND field_visibility=1");

		return $get_data;
	}
	//Get Single Custom Field Meta value BY Module and ID Function//
	function Smgt_get_single_custom_field_meta_value($module,$module_record_id,$custom_field_id) 
	{	
		/* var_dump($module);
		var_dump($module_record_id);
		var_dump($custom_field_id);
		die; */
		global $wpdb;
		$wpnc_custom_field_metas = $wpdb->prefix . 'custom_field_metas';
		$get_data = $wpdb->get_row("SELECT field_value FROM $wpnc_custom_field_metas where module='$module' AND module_record_id=$module_record_id AND custom_fields_id=".$custom_field_id);
		/* var_dump($get_data);
		die; */
		if(!empty($get_data))
		{			
			return $get_data->field_value;
		}
		else
		{
			return '';
		}
	}
	//Get Custom Field Dropdown value BY ID Function//
	function Smgt_getDropDownValue($custom_field_id) 
	{		
		global $wpdb;
		$wpnc_custom_field_dropdown_metas = $wpdb->prefix . 'custom_field_dropdown_metas';
		$get_data = $wpdb->get_results("SELECT * FROM $wpnc_custom_field_dropdown_metas where custom_fields_id=".$custom_field_id);
		return $get_data;
	}
	//Check The Label is Checkbox Or Not	
	function Smgt_getCheckedCheckbox($custom_field_id)
	{
		global $wpdb;
		$wpnc_custom_fields = $wpdb->prefix . 'custom_field';
		$get_data = $wpdb->get_row("SELECT * FROM $wpnc_custom_fields where id=".$custom_field_id);
		if(!empty($get_data))
		{
			$f_type = $get_data->field_type;
			if($f_type == 'checkbox')
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}	
	//Add Custom Field Meta Data Function//
	function Smgt_add_custom_field_metas($module,$custom,$module_record_id) 
	{		
		global $wpdb;
		$wpnc_custom_field_metas = $wpdb->prefix . 'custom_field_metas';
		
		if(!empty($custom))
		{
			foreach($custom as $key=>$value)
			{				
				$value = $custom[$key];
				$checkboxreturn =$this->Smgt_getCheckedCheckbox($key);
												
				$custom_meta_data['module']=$module;
				$custom_meta_data['module_record_id']=$module_record_id;
				$custom_meta_data['custom_fields_id']=$key;
				
				if (!empty($checkboxreturn)) 
				{
					$custom_meta_data['field_value']=implode(",",$value);
				} 				
				else 
				{
					$custom_meta_data['field_value']=$value;
				}
				
				$custom_meta_data['created_at']=date("Y-m-d H:i:s");
				$custom_meta_data['updated_at']=date("Y-m-d H:i:s");
				
				$insert_custom_meta_data=$wpdb->insert($wpnc_custom_field_metas, $custom_meta_data );	
			}			
		}	
		return $insert_custom_meta_data;
	}
	//Check Custom Field Old or New //	
	function Smgt_check_field_old_or_new($module,$module_record_id,$custom_field_id)
	{
		global $wpdb;
		$wpnc_custom_field_metas = $wpdb->prefix . 'custom_field_metas';
		
		$get_data = $wpdb->get_row("SELECT * FROM $wpnc_custom_field_metas where module='$module' AND module_record_id=$module_record_id AND custom_fields_id=".$custom_field_id);
		
		return $get_data;		
	}
	//Update Custom Field Meta Data Function//
	function Smgt_update_custom_field_metas($module,$custom,$module_record_id) 
	{		
		global $wpdb;
		$wpnc_custom_field_metas = $wpdb->prefix . 'custom_field_metas';
		
		if(!empty($custom))
		{
			foreach($custom as $key=>$value)
			{
				$value = $custom[$key];
				$checkboxreturn =$this->Smgt_getCheckedCheckbox($key);
				
				$check_field_old_or_new=$this->Smgt_check_field_old_or_new($module,$module_record_id,$key);
				
				if(!empty($check_field_old_or_new))
				{	
					if (!empty($checkboxreturn)) 
					{
						$field_value=implode(",",$value);
					} 
					else 
					{
						$field_value=$value;
					}
					$updated_at=date("Y-m-d H:i:s");
					
					$update_custom_meta_data =$wpdb->query($wpdb->prepare("UPDATE `$wpnc_custom_field_metas` SET `field_value` = '$field_value',updated_at='$updated_at' WHERE `$wpnc_custom_field_metas`.`module` = %s AND  `$wpnc_custom_field_metas`.`module_record_id` = %d AND `$wpnc_custom_field_metas`.`custom_fields_id` = %d",$module,$module_record_id,$key));
				}
				else
				{
					$custom_meta_data['module']=$module;
					$custom_meta_data['module_record_id']=$module_record_id;
					$custom_meta_data['custom_fields_id']=$key;
					
					if (!empty($checkboxreturn)) 
					{
						$custom_meta_data['field_value']=implode(",",$value);
					} 
					else 
					{
						$custom_meta_data['field_value']=$value;
					}
					$custom_meta_data['created_at']=date("Y-m-d H:i:s");
					$custom_meta_data['updated_at']=date("Y-m-d H:i:s");
					
					$insert_custom_meta_data=$wpdb->insert($wpnc_custom_field_metas, $custom_meta_data );	
				}
			}					
		}	
		return $update_custom_meta_data;
	}
	
}
?>