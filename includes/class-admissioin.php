<?php
set_time_limit(300);
class smgt_admission
{
	//----------- ADD NEW ADMISSION ------------------//
	public function smgt_add_admission($data,$father_document_data,$mother_document_data,$role)
	{
		$firstname	=	MJ_smgt_onlyLetter_specialcharacter_validation($data['first_name']);
		$lastname	=	smgt_strip_tags_and_stripslashes($data['last_name']);
		$userdata 	= 	array(
			'user_login'	=>	MJ_smgt_username_validation($data['email']),			
			'user_nicename'	=>	NULL,
			'user_email'	=>	MJ_smgt_email_validation($data['email']),
			'user_url'		=>	NULL,
			'display_name'	=>	$firstname." ".$lastname,
		);
		if($data['password'] != "")
		{
			$userdata['user_pass']=MJ_smgt_password_validation($data['password']);
		}
		else
		{ 
			$userdata['user_pass']=wp_generate_password();
		}
		 
		if(isset($data['smgt_user_avatar']) && $data['smgt_user_avatar'] != "")
		{
			$photo	=	$data['smgt_user_avatar'];
		}
		else
		{
			$photo	=	"";
		}
			
		// Add Sibling details //
		$sibling_value=array();			 
		if(!empty($data['siblingsname']))
		{
			foreach($data['siblingsname'] as $key=>$value)
			{
				$sibling_value[]=array("siblingsname" => MJ_smgt_onlyLetter_specialcharacter_validation($value), "siblingage" =>$data['siblingage'][$key],"sibling_standard" => $data['sibling_standard'][$key], "siblingsid" => $data['siblingsid'][$key]);				  
			}	
		}
		// ADD USER META //
		$usermetadata	=	array(
			'admission_no'	=>	MJ_smgt_address_description_validation($data['admission_no']),
			'admission_date'	=>$data['admission_date'],
			'role'	=> $data['role'],
			'status'	=>$data['status'],
			'roll_id'	=>"",
			'middle_name'	=>	MJ_smgt_onlyLetter_specialcharacter_validation($data['middle_name']),
			'gender'	=>	MJ_smgt_onlyLetterSp_validation($data['gender']),
			'birth_date'=>	$data['birth_date'],
			'address'	=>	MJ_smgt_address_description_validation($data['address']),
			'city'		=>	MJ_smgt_city_state_country_validation($data['city_name']),
			'state'		=>	MJ_smgt_city_state_country_validation($data['state_name']),
			'zip_code'	=>	MJ_smgt_onlyLetterNumber_validation($data['zip_code']),
			'preschool_name'	=>MJ_smgt_onlyLetter_specialcharacter_validation($data['preschool_name']),
			'phone_code'		=>$data['phone_code'],
			'phone'		=>	MJ_smgt_phone_number_validation($data['phone']),
			'alternet_mobile_number'	=>	MJ_smgt_phone_number_validation($data['alternet_mobile_number']),
			'sibling_information'	=>json_encode($sibling_value),
			'parent_status'	=>$data['pstatus'],
			'fathersalutation'	=>	MJ_smgt_onlyLetter_specialcharacter_validation($data['fathersalutation']),
			'father_first_name'	=>	MJ_smgt_onlyLetter_specialcharacter_validation($data['father_first_name']),
			'father_middle_name'	=>	MJ_smgt_onlyLetter_specialcharacter_validation($data['father_middle_name']),
			'father_last_name'	=>	MJ_smgt_onlyLetter_specialcharacter_validation($data['father_last_name']),
			'fathe_gender'	=>$data['fathe_gender'],
			'father_birth_date'	=>$data['father_birth_date'],
			'father_address'=>MJ_smgt_address_description_validation($data['father_address']),
			'father_city_name'=>MJ_smgt_city_state_country_validation($data['father_city_name']),
			'father_state_name'=>MJ_smgt_city_state_country_validation($data['father_state_name']),
			'father_zip_code'=>MJ_smgt_onlyLetterNumber_validation($data['father_zip_code']),
			'father_email'	=>	MJ_smgt_email_validation($data['father_email']),
			'father_mobile'	=>	MJ_smgt_phone_number_validation($data['father_mobile']),
			'father_school'	=>	MJ_smgt_onlyLetter_specialcharacter_validation($data['father_school']),
			'father_medium'	=>MJ_smgt_onlyLetter_specialcharacter_validation($data['father_medium']),
			'father_education'	=>MJ_smgt_onlyLetter_specialcharacter_validation($data['father_education']),
			'fathe_income'	=>$data['fathe_income'],
			'father_occuption'	=>MJ_smgt_onlyLetter_specialcharacter_validation($data['father_occuption']),
			'father_doc'	=>json_encode($father_document_data),
			'mothersalutation'	=>	MJ_smgt_onlyLetter_specialcharacter_validation($data['mothersalutation']),
			'mother_first_name'	=>	MJ_smgt_onlyLetter_specialcharacter_validation($data['mother_first_name']),
			'mother_middle_name'	=>	MJ_smgt_onlyLetter_specialcharacter_validation($data['mother_middle_name']),
			'mother_last_name'	=>	MJ_smgt_onlyLetter_specialcharacter_validation($data['mother_last_name']),
			'mother_gender'	=>$data['mother_gender'],
			'mother_birth_date'	=>$data['mother_birth_date'],
			'mother_address'=>MJ_smgt_address_description_validation($data['mother_address']),
			'mother_city_name'=>MJ_smgt_city_state_country_validation($data['mother_city_name']),
			'mother_state_name'=>MJ_smgt_city_state_country_validation($data['mother_state_name']),
			'mother_zip_code'=>MJ_smgt_onlyLetterNumber_validation($data['mother_zip_code']),
			'mother_email'	=>	MJ_smgt_email_validation($data['mother_email']),
			'mother_mobile'	=>	MJ_smgt_phone_number_validation($data['mother_mobile']),
			'mother_school'	=>	MJ_smgt_onlyLetter_specialcharacter_validation($data['mother_school']),
			'mother_medium'	=>MJ_smgt_onlyLetter_specialcharacter_validation($data['mother_medium']),
			'mother_education'	=>MJ_smgt_onlyLetter_specialcharacter_validation($data['mother_education']),
			'mother_income'	=>$data['mother_income'],
			'mother_occuption'	=>MJ_smgt_onlyLetter_specialcharacter_validation($data['mother_occuption']),
			'mother_doc'	=>json_encode($mother_document_data),
			'smgt_user_avatar'	=>$photo					
		);
		if ($data['action'] == 'edit')
		{
			$returnval;
			$userdata['ID'] = $data['user_id'];
			$user_id = wp_update_user( $userdata );
			foreach($usermetadata as $key=>$val)
			{
				$returnans=update_user_meta( $user_id, $key,$val, '' );	
			}

		}
		else
		{
			$returnval;
			$user_id = wp_insert_user( $userdata );
			$user = new WP_User($user_id);
			$user->set_role($role);
			foreach($usermetadata as $key=>$val)
			{
				$returnans=add_user_meta( $user_id, $key,$val, true );		
			}
		}
		
		if($user_id)
		{
			//---------- ADMISSION REQUEST MAIL ---------//
			$string = array();
			$string['{{student_name}}']   = get_display_name($user_id);
			$string['{{user_name}}']   =  $firstname .' '.$lastname;
			$string['{{email}}']   =  $userdata['user_email'];
			$string['{{school_name}}'] =  get_option('smgt_school_name');
			$MsgContent                =  get_option('admission_mailtemplate_content');
			$MsgSubject				   =  get_option('admissiion_title');
			$message = string_replacement($string,$MsgContent);
			$MsgSubject = string_replacement($string,$MsgSubject);
			
			$email= $userdata['user_email'];
			smgt_send_mail($email,$MsgSubject,$message);  
		}
		$returnval=update_user_meta( $user_id, 'first_name', $firstname );
		$returnval=update_user_meta( $user_id, 'last_name', $lastname );
		$hash = md5( rand(0,1000) );
		$returnval=update_user_meta( $user_id, 'hash', $hash );
		 
		return $returnval;	
	}
	
	//----------Parents ADD ---------//
	public function smgt_add_parent($student_id,$role_parents)
	{
		$student_data = get_userdata($student_id);
		if($student_data->parent_status == "Father")
		{
			//------------ FATHER DATA INSERT------------------//
			$userdata = array(
				'user_login'=>MJ_smgt_username_validation($student_data->father_email),			
				'user_nicename'=>NULL,
				'user_email'=>MJ_smgt_email_validation($student_data->father_email),
				'user_url'=>NULL,
				'user_pass'=>wp_generate_password(),
				'display_name'=>$student_data->father_first_name." ".$student_data->father_last_name,
			);
			// ADD USER META //
			$usermetadata	=	array(
				'middle_name'=>MJ_smgt_onlyLetter_specialcharacter_validation($student_data->father_middle_name),
				'gender'=>$student_data->fathe_gender,
				'birth_date'=>$student_data->father_birth_date,
				'address'=>MJ_smgt_address_description_validation($student_data->father_address),
				'city'=>MJ_smgt_city_state_country_validation($student_data->father_city_name),
				'state'=>MJ_smgt_city_state_country_validation($student_data->father_state_name),
				'zip_code'=>MJ_smgt_onlyLetterNumber_validation($student_data->father_zip_code),
				'phone'=>MJ_smgt_phone_number_validation($student_data->father_mobile),
				'mobile_number'=>MJ_smgt_phone_number_validation($student_data->father_mobile),
				'relation'=>"Father"
			);
			 
			$returnval;
			$user_id = wp_insert_user( $userdata );
			$user = new WP_User($user_id);
			$user->set_role($role_parents);
			foreach($usermetadata as $key=>$val)
			{		
				$returnans=add_user_meta( $user_id, $key,$val, true );		
			} 
			//---------- Mail For ADD Parents ----------//
			if($user_id)
			{  	
				$string = array();
				$string['{{user_name}}']   = $student_data->father_first_name.' '.$student_data->father_last_name;
				$string['{{school_name}}'] =  get_option('smgt_school_name');
				$string['{{role}}']        =  $role_parents;
				$string['{{login_link}}']  =  site_url() .'/index.php/school-management-login-page';
				$string['{{username}}']    =  $userdata['user_login'];
				$string['{{Password}}']    =  $userdata['user_pass'];
					
				$MsgContent                =  get_option('add_user_mail_content');		
				$MsgSubject				   =  get_option('add_user_mail_subject');
				$message = string_replacement($string,$MsgContent);
				$MsgSubject = string_replacement($string,$MsgSubject);
			
				$email= $userdata['user_email'];
				smgt_send_mail($email,$MsgSubject,$message);
			}
			
			$returnval=update_user_meta( $user_id, 'first_name',$student_data->father_first_name);
			$returnval=update_user_meta( $user_id, 'last_name',$student_data->father_last_name);
			
			$parant_id = array($user_id);
			$returnval=add_user_meta($student_id,'parent_id', $parant_id );
			
			$child_id = array($student_id);
			$returnval=add_user_meta($user_id,'child', $child_id );  
				 
			return $returnval;
		}
		elseif($student_data->parent_status == "Mother")
		{
		 
		 //------------ MOTHER DATA INSERT------------------//
			$userdata = array(
				'user_login'=>MJ_smgt_username_validation($student_data->mother_email),			
				'user_nicename'=>NULL,
				'user_email'=>MJ_smgt_email_validation($student_data->mother_email),
				'user_url'=>NULL,
				'user_pass'=>wp_generate_password(),
				'display_name'=>$student_data->mother_first_name." ".$student_data->mother_last_name,
			);
			// ADD USER META //
			$usermetadata	=	array(
				'middle_name'=>MJ_smgt_onlyLetter_specialcharacter_validation($student_data->mother_middle_name),
				'gender'=>$student_data->mother_gender,
				'birth_date'=>$student_data->mother_birth_date,
				'address'=>MJ_smgt_address_description_validation($student_data->motehr_address),
				'city'=>MJ_smgt_city_state_country_validation($student_data->mother_city_name),
				'state'=>MJ_smgt_city_state_country_validation($student_data->mother_state_name),
				'zip_code'=>MJ_smgt_onlyLetterNumber_validation($student_data->mother_zip_code),
				'phone'=>MJ_smgt_phone_number_validation($student_data->mother_mobile),
				'mobile_number'=>MJ_smgt_phone_number_validation($student_data->mother_mobile),
				'relation'=>"Mother"
			);
			 
			$returnval;
			$user_id = wp_insert_user( $userdata );
			$user = new WP_User($user_id);
			$user->set_role($role_parents);
			foreach($usermetadata as $key=>$val)
			{		
				$returnans=add_user_meta( $user_id, $key,$val, true );		
			}
			//---------- Mail For ADD Parents ----------//
			if($user_id)
			{	
				$string = array();
				$string['{{user_name}}']   = $student_data->mother_first_name.' '.$student_data->mother_last_name;
				$string['{{school_name}}'] =  get_option('smgt_school_name');
				$string['{{role}}']        =  $role_parents;
				$string['{{login_link}}']  =  site_url() .'/index.php/school-management-login-page';
				$string['{{username}}']    =  $userdata['user_login'];
				$string['{{Password}}']    =  $userdata['user_pass'];
					
				$MsgContent                =  get_option('add_user_mail_content');		
				$MsgSubject				   =  get_option('add_user_mail_subject');
				$message = string_replacement($string,$MsgContent);
				$MsgSubject = string_replacement($string,$MsgSubject);
			
				$email= $userdata['user_email'];
				smgt_send_mail($email,$MsgSubject,$message);
			}
			$returnval=update_user_meta( $user_id, 'first_name',$student_data->mother_first_name);
			$returnval=update_user_meta( $user_id, 'last_name',$student_data->mother_last_name);
			
			$parant_id = array($user_id);
			$returnval=add_user_meta($student_id,'parent_id', $parant_id );
			
			$child_id = array($student_id);
			$returnval=add_user_meta($user_id,'child', $child_id );
				 
			return $returnval;
		}
		else
		{
			
			//------------ FATHER DATA INSERT------------------//
			$fatherdata = array(
				'user_login'=>MJ_smgt_username_validation($student_data->father_email),			
				'user_nicename'=>NULL,
				'user_email'=>MJ_smgt_email_validation($student_data->father_email),
				'user_url'=>NULL,
				'user_pass'=>wp_generate_password(),
				'display_name'=>$student_data->father_first_name." ".$student_data->father_last_name,
			);
			// ADD USER META //
			$fathermetadata	=	array(
				'middle_name'=>MJ_smgt_onlyLetter_specialcharacter_validation($student_data->father_middle_name),
				'gender'=>$student_data->fathe_gender,
				'birth_date'=>$student_data->father_birth_date,
				'address'=>MJ_smgt_address_description_validation($student_data->father_address),
				'city'=>MJ_smgt_city_state_country_validation($student_data->father_city_name),
				'state'=>MJ_smgt_city_state_country_validation($student_data->father_state_name),
				'zip_code'=>MJ_smgt_onlyLetterNumber_validation($student_data->father_zip_code),
				'phone'=>MJ_smgt_phone_number_validation($student_data->father_mobile),
				'mobile_number'=>MJ_smgt_phone_number_validation($student_data->father_mobile),
				'relation'=>"Father"
			);
		 
			$returnval;
			$father_id = wp_insert_user( $fatherdata );
			$user = new WP_User($father_id);
			$user->set_role($role_parents);
			foreach($fathermetadata as $key=>$val)
			{		
				$returnans=add_user_meta( $father_id, $key,$val, true );		
			}
			//---------- Mail For ADD Parents ----------//
			if($father_id)
			{	
				$string = array();
				$string['{{user_name}}']   = $student_data->mother_first_name.' '.$student_data->mother_last_name;
				$string['{{school_name}}'] =  get_option('smgt_school_name');
				$string['{{role}}']        =  $role_parents;
				$string['{{login_link}}']  =  site_url() .'/index.php/school-management-login-page';
				$string['{{username}}']    =  $fatherdata['user_login'];
				$string['{{Password}}']    =  $fatherdata['user_pass'];
					
				$MsgContent                =  get_option('add_user_mail_content');		
				$MsgSubject				   =  get_option('add_user_mail_subject');
				$message = string_replacement($string,$MsgContent);
				$MsgSubject = string_replacement($string,$MsgSubject);
			
				$email= $fatherdata['user_email'];
				smgt_send_mail($email,$MsgSubject,$message);
			}
			$returnval=update_user_meta( $father_id, 'first_name',$student_data->father_first_name);
			$returnval=update_user_meta( $father_id, 'last_name',$student_data->father_last_name);
			
			//------------ MOTHER DATA INSERT------------------//
			
			$motherdata = array(
				'user_login'=>MJ_smgt_username_validation($student_data->mother_email),			
				'user_nicename'=>NULL,
				'user_email'=>MJ_smgt_email_validation($student_data->mother_email),
				'user_url'=>NULL,
				'user_pass'=>wp_generate_password(),
				'display_name'=>$student_data->mother_first_name." ".$student_data->mother_last_name,
			);
			// ADD USER META //
			$mothermetadata	=	array(
				'middle_name'=>MJ_smgt_onlyLetter_specialcharacter_validation($student_data->mother_middle_name),
				'gender'=>$student_data->mother_gender,
				'birth_date'=>$student_data->mother_birth_date,
				'address'=>MJ_smgt_address_description_validation($student_data->motehr_address),
				'city'=>MJ_smgt_city_state_country_validation($student_data->mother_city_name),
				'state'=>MJ_smgt_city_state_country_validation($student_data->mother_state_name),
				'zip_code'=>MJ_smgt_onlyLetterNumber_validation($student_data->mother_zip_code),
				'phone'=>MJ_smgt_phone_number_validation($student_data->mother_mobile),
				'mobile_number'=>MJ_smgt_phone_number_validation($student_data->mother_mobile),
				'relation'=>"Mother"
			);
			 
			$mother_id = wp_insert_user( $motherdata );
			$user1 = new WP_User($mother_id);
			$user1->set_role($role_parents);
			foreach($mothermetadata as $key=>$val)
			{		
				$returnans=add_user_meta( $mother_id, $key,$val, true );		
			}
			 
			//---------- Mail For ADD Parents ----------//
			 
			if($mother_id)
			{	
				$string = array();
				$string['{{user_name}}']   = $student_data->mother_first_name.' '.$student_data->mother_last_name;
				$string['{{school_name}}'] =  get_option('smgt_school_name');
				$string['{{role}}']        =  $role_parents;
				$string['{{login_link}}']  =  site_url() .'/index.php/school-management-login-page';
				$string['{{username}}']    =  $motherdata['user_login'];
				$string['{{Password}}']    =  $motherdata['user_pass'];
					
				$MsgContent                =  get_option('add_user_mail_content');		
				$MsgSubject				   =  get_option('add_user_mail_subject');
				$message = string_replacement($string,$MsgContent);
				$MsgSubject = string_replacement($string,$MsgSubject);
			
				$email= $motherdata['user_email'];
				smgt_send_mail($email,$MsgSubject,$message);
			}
			
			
			$returnval=update_user_meta( $mother_id, 'first_name',$student_data->mother_first_name);
			$returnval=update_user_meta( $mother_id, 'last_name',$student_data->mother_last_name);
			
			$parant_id = array($father_id,$mother_id);
			$returnval=add_user_meta($student_id,'parent_id', $parant_id );
			
			$child_id = array($student_id);
			$returnval=add_user_meta($father_id,'child', $child_id );
			$returnval=add_user_meta($mother_id,'child', $child_id );
			
			return $returnval;
			
		}
	}
	
}
?>