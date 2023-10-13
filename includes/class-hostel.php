<?php
class smgt_hostel
{
	public function smgt_insert_hostel($data)
	{
		global $wpdb;
		$table_smgt_hostel=$wpdb->prefix.'smgt_hostel';
		$hostel_data['hostel_name']=MJ_smgt_onlyLetter_specialcharacter_validation($data['hostel_name']);
		$hostel_data['hostel_type']=MJ_smgt_onlyLetter_specialcharacter_validation($data['hostel_type']);
		$hostel_data['Description']=MJ_smgt_address_description_validation($data['Description']);
		
		if($data['action']=='edit')
		{
			$hostel_data['updated_by']=get_current_user_id();
			$hostel_data['updated_date']=date('Y-m-d');
			$hostel_id['id']=$data['hostel_id'];
			$result=$wpdb->update( $table_smgt_hostel, $hostel_data ,$hostel_id);
			return $result;
		}
		else
		{
			$hostel_data['created_by']=get_current_user_id();
			$hostel_data['created_date']=date('Y-m-d');
			$result=$wpdb->insert( $table_smgt_hostel,$hostel_data);
			return $result;
		}
	}
	public function get_hostel_by_id($hostel_id)
	{
		global $wpdb;
		$table_smgt_hostel=$wpdb->prefix.'smgt_hostel';
		$result=$wpdb->get_row("SELECT * FROM $table_smgt_hostel where id=".$hostel_id);
		return $result;
	}
	public function smgt_delete_hostel($hostel_id)
	{
		global $wpdb;
		$table_smgt_hostel=$wpdb->prefix.'smgt_hostel';
		return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_smgt_hostel WHERE id= %d",$hostel_id));
	}
	public function smgt_get_all_hostel()
	{
		global $wpdb;
		$table_smgt_hostel=$wpdb->prefix.'smgt_hostel';
		$result=$wpdb->get_results("SELECT * FROM $table_smgt_hostel");
		return $result;
	}
	public function smgt_insert_room($data)
	{
		/* var_dump($data);
		die;   */
		global $wpdb;
		$table_smgt_room=$wpdb->prefix.'smgt_room';
		$room_data['room_unique_id']=MJ_smgt_onlyLetter_specialcharacter_validation($data['room_unique_id']);
		$room_data['hostel_id']=$data['hostel_id'];
		$room_data['room_status']='0';
		$room_data['room_category']=$data['room_category'];
		$room_data['beds_capacity']=$data['beds_capacity'];
		$room_data['room_description']=MJ_smgt_address_description_validation($data['room_description']);
		
		if($data['action']=='edit_room')
		{
			$room_data['updated_by']=get_current_user_id();
			$room_data['updated_date']=date('Y-m-d');
			$room_id['id']=$data['room_id'];
			$result=$wpdb->update( $table_smgt_room, $room_data ,$room_id);
			return $result;
		}
		else
		{
			$room_data['created_by']=get_current_user_id();
			$room_data['created_date']=date('Y-m-d');
			$result=$wpdb->insert( $table_smgt_room,$room_data);
			return $result;
		}
	}
	public function smgt_delete_room($room_id)
	{
		global $wpdb;
		$table_smgt_room=$wpdb->prefix.'smgt_room';
		return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_smgt_room WHERE id= %d",$room_id));
	}
	public function get_room_by_id($room_id)
	{
		global $wpdb;
		$table_smgt_room=$wpdb->prefix.'smgt_room';
		$result=$wpdb->get_row("SELECT * FROM $table_smgt_room where id=".$room_id);
		return $result;
	}
	public function smgt_get_all_room()
	{
		global $wpdb;
		$table_smgt_room=$wpdb->prefix.'smgt_room';
		$result=$wpdb->get_results("SELECT * FROM $table_smgt_room");
		return $result;
	}
	public function smgt_insert_bed($data)
	{
		/* var_dump($data);
		die;   */
		global $wpdb;
		$table_smgt_beds=$wpdb->prefix.'smgt_beds';
		$bed_data['bed_unique_id']=MJ_smgt_onlyLetter_specialcharacter_validation($data['bed_unique_id']);
		$bed_data['room_id']=$data['room_id'];
		$bed_data['bed_status']='0';
		$bed_data['bed_description']=MJ_smgt_address_description_validation($data['bed_description']);
		
		if($data['action']=='edit_bed')
		{
			$bed_data['updated_by']=get_current_user_id();
			$bed_data['updated_date']=date('Y-m-d');
			$bed_id['id']=$data['bed_id'];
			$result=$wpdb->update( $table_smgt_beds, $bed_data ,$bed_id);
			return $result;
		}
		else
		{
			$bed_data['created_by']=get_current_user_id();
			$bed_data['created_date']=date('Y-m-d');
			$result=$wpdb->insert( $table_smgt_beds,$bed_data);
			return $result;
		}
	}
	public function get_bed_by_id($bed_id)
	{
		global $wpdb;
		$table_smgt_beds=$wpdb->prefix.'smgt_beds';
		$result=$wpdb->get_row("SELECT * FROM $table_smgt_beds where id=".$bed_id);
		return $result;
	}
	public function get_all_bed_by_room_id($room_id)
	{
		global $wpdb;
		$table_smgt_beds=$wpdb->prefix.'smgt_beds';
		 
		$result=$wpdb->get_results("SELECT * FROM $table_smgt_beds where room_id=".$room_id);
		return $result;
	}
	public function smgt_delete_bed($bed_id)
	{
		global $wpdb;
		$table_smgt_beds=$wpdb->prefix.'smgt_beds';
		return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_smgt_beds WHERE id= %d",$bed_id));
	}
	public function get_assign_bed_by_id($bed_id)
	{
		global $wpdb;
		$table_smgt_assign_beds=$wpdb->prefix.'smgt_assign_beds';
		$result=$wpdb->get_row("SELECT * FROM $table_smgt_assign_beds where bed_id=".$bed_id);
		return $result;
	}
	public function smgt_get_hostel_id_by_room_id($room_id)
	{
		global $wpdb;
		$table_smgt_room=$wpdb->prefix.'smgt_room';
		$result=$wpdb->get_row("SELECT * FROM $table_smgt_room where id=".$room_id);
		return $result->hostel_id;
	}
	public function smgt_assign_room($data)
	{
		global $wpdb;
		$table_smgt_beds=$wpdb->prefix.'smgt_beds';
		$table_smgt_assign_beds=$wpdb->prefix.'smgt_assign_beds';
		if(!empty($data['room_id_new']))
		{
			foreach($data['room_id_new'] as $key=>$value)
			{
				$student_unique=$data['student_id'][$key];
			 
				if(!empty($student_unique))
				{  
					$bed_id=$data['bed_id'][$key];
					
					$bed_data=$this->get_bed_by_id($bed_id);
					$assign_bed_data=$this->get_assign_bed_by_id($bed_id);
					
					if(!empty($assign_bed_data))
					{			
						$assign_bed_id['id'] =$assign_bed_data->id;
						$assign_data['hostel_id']=$data['hostel_id'];
						$assign_data['room_id']=$value;
						$assign_data['bed_id']=$bed_id;
						$assign_data['bed_unique_id']=$data['bed_unique_id'][$key];
						$assign_data['student_id']=$data['student_id'][$key];
						$assign_data['assign_date']=date("Y-m-d", strtotime($data['assign_date'][$key]));
						$assign_data['created_date']=date("Y-m-d");						
						$assign_data['created_by']=get_current_user_id();
						
						$result=$wpdb->update( $table_smgt_assign_beds, $assign_data ,$assign_bed_id);
						if($result)
						{
							$bed_data_update['bed_status']=1;
							$assign_bed_id_update['id']=$assign_bed_id;
							$result_update=$wpdb->update( $table_smgt_beds, $bed_data_update ,$assign_bed_id_update);
						}
					}
					else
					{
						$assign_data['hostel_id']=$data['hostel_id'];
						$assign_data['room_id']=$value;
						$assign_data['bed_id']=$bed_id;
						$assign_data['bed_unique_id']=$data['bed_unique_id'][$key];
						$assign_data['student_id']=$data['student_id'][$key];
						$assign_data['assign_date']=date("Y-m-d", strtotime($data['assign_date'][$key]));
						$assign_data['created_date']=date("Y-m-d");						
						$assign_data['created_by']=get_current_user_id();
					 
						$result=$wpdb->insert( $table_smgt_assign_beds,$assign_data);
						if($result)
						{ 
							//---------- Hostel BED ASSIGNED MAIL ---------//
							$userdata=get_userdata($student_unique);
							$string = array();
							$string['{{student_name}}']   = get_display_name($student_unique);
							$string['{{hostel_name}}']   =smgt_hostel_name_by_id($data['hostel_id']);
							$string['{{room_id}}']   = get_room_unique_id_by_room_id($value);
							$string['{{bed_id}}']   =$data['bed_unique_id'][$key];
							$string['{{school_name}}'] =  get_option('smgt_school_name');
							$MsgContent                =  get_option('bed_content');		
							$MsgSubject				   =  get_option('bed_subject');
							$message = string_replacement($string,$MsgContent);
							$MsgSubject = string_replacement($string,$MsgSubject);
						
							$email= $userdata->user_email;
							smgt_send_mail($email,$MsgSubject,$message);  
						}							
						$assign_bed_id_update['id']=$bed_id;
						$bed_data_update['bed_status']=1;
						$result_update=$wpdb->update( $table_smgt_beds, $bed_data_update ,$assign_bed_id_update);					
					}
				}
			}
		}
		return $result;
	}
	public function smgt_delete_assigned_bed($room_id,$bed_id,$student_id)
	{
		global $wpdb;
		$table_smgt_beds=$wpdb->prefix.'smgt_beds';
		$table_smgt_assign_beds=$wpdb->prefix.'smgt_assign_beds';
		$result=$wpdb->query($wpdb->prepare("DELETE FROM $table_smgt_assign_beds WHERE room_id=$room_id and bed_id=$bed_id and student_id =".$student_id));
		if($result)
		{
			$assign_bed_id_update['id']=$bed_id;
			$bed_data_update['bed_status']=0;
			$result_update=$wpdb->update( $table_smgt_beds, $bed_data_update ,$assign_bed_id_update);
		} 
		return $result_update;
	}
}
?>