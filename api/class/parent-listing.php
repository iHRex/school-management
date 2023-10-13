<?php
class ParentListing
{
public	function __construct()
{
	add_action('template_redirect', array($this,'redirectMethod'),1);
}
public	function redirectMethod()
{
	if ($_REQUEST["smgt-json-api"] == 'parent-listing')
	{
		$response = $this->parent_listing($_REQUEST);
		if (is_array($response))
		{
			echo json_encode($response);
		}
		 else
		{
			header("HTTP/1.1 401 Unauthorized");
		}
		die();
	}
	if ($_REQUEST['smgt-json-api'] == 'add-parent')
	{
		$response = $this->add_parent($_REQUEST);
		if (is_array($response))
		{
			echo json_encode($response);
		}
		else
		{
			header("HTTP/1.1 401 Unauthorized");
		}
		die();
	}

	if ($_REQUEST['smgt-json-api'] == 'edit-parent')
	{
		$response = $this->edit_parent($_REQUEST);
		if (is_array($response))
		{
			echo json_encode($response);
		}
		else
		{
			header("HTTP/1.1 401 Unauthorized");
		}
		die();
	}

		if ($_REQUEST['smgt-json-api'] == 'delete-parent')
			{
			$school_obj = new School_Management($_REQUEST['current_user']);
			if ($school_obj->role == 'admin')
				{
				$response = $this->delete_parent($_REQUEST);
				}

			if (is_array($response))
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

	public function parent_listing($data)
		{
		$response = array();
		$parentdata = array();
		$school_obj = new School_Management ($data['current_user']);
		$menu_access_data=smgt_get_userrole_wise_access_right_array_in_api($data['current_user'],'parent');
			
			if($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 1 )
			{
				$parentdata1=$school_obj->parent_list;
				foreach($parentdata1 as $pid)
				{
					$parentdata[]=get_userdata($pid);
				}
			}
			elseif($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 0 )
			{
				$parentdata	=	get_usersdata('parent');
			}
			else
			{
				$parentdata="";
			}

		if (!empty($parentdata))
			{
				$i = 0;
				foreach($parentdata as $retrieved_data)
				{
				$userimagedata = get_user_image($retrieved_data->ID);
				if (empty($userimagedata['meta_value']))
					{
					$imageurl = get_option('smgt_parent_thumb');
					}
				  else
					{
					$imageurl = $userimagedata['meta_value'];
					}

					$result[$i]['ID'] = $retrieved_data->ID;
					$result[$i]['image'] = $imageurl;
					$result[$i]['name'] = $retrieved_data->display_name;
					$result[$i]['email'] = $retrieved_data->user_email;
					$i++;
				}

			$response['status'] = 1;
			$response['resource'] = $result;
			return $response;
			}
		  else
			{
			$error['message'] = __("Please Fill All Fields", 'school-mgt');
			$response['status'] = 0;
			$response['resource'] = $error;
			}

		return $response;
		}

	public function add_parent($data)
		{
		$response = array();
		$teacher_obj = new Smgt_Teacher;
		$role = 'parent';
		$firstname = $data['first_name'];
		$lastname = $data['last_name'];
		$userdata = array(
			'user_login' => $data['username'],
			'user_nicename' => NULL,
			'user_email' => $data['email'],
			'user_url' => NULL,
			'display_name' => $firstname . " " . $lastname,
		);
		if ($data['password'] != "") $userdata['user_pass'] = $data['password'];
		if ($data['child_ids'] != "")
			{
			$childs_array = explode(',', $data['child_ids']);
			foreach($childs_array as $child)
				{
				$childs[] = $user->ID;
				}
			}
		  else
			{
			$childs = array(
				'0' => 0
			);
			}

		$usermetadata = array(
			'middle_name' => $data['middle_name'],
			'gender' => $data['gender'],
			'birth_date' => $data['birth_date'],
			'address' => $data['address'],
			'city' => $data['city_name'],
			'state' => $data['state_name'],
			'zip_code' => $data['zip_code'],
			'phone' => $data['phone'],
			'mobile_number' => $data['mobile_number'],
			'relation' => $data['relation'],
			'child' => $childs,
			'smgt_user_avatar' => $data['smgt_user_avatar']
		);
		if (!email_exists($data['email']) && !username_exists($data['username']))
			{
			$result = add_newuser($userdata, $usermetadata, $firstname, $lastname, $role);
			}
		  else
			{
			$message = __("Username Or Emailid All Ready Exist.", "school-mgt");
			$response['status'] = 0;
			$response['resource'] = $message;
			return $response;
			}

		if ($result)
			{
			$message['message'] = __("Record successfully inserted!", "school-mgt");
			$response['status'] = 1;
			$response['resource'] = $message;
			return $response;
			}
		  else
			{
			$error['message'] = __("Please Fill All Fields", 'school-mgt');
			$response['status'] = 0;
			$response['resource'] = $error;
			}

		return $response;
		}

	public function edit_parent($data)
	{
		
		$response = array();
		$role = 'parent';
		$firstname = $data['first_name'];
		$lastname = $data['last_name'];
		$userdata = array(
			'user_login' => $data['username'],
			'user_nicename' => NULL,
			'user_email' => $data['email'],
			'user_url' => NULL,
			'display_name' => $firstname . " " . $lastname,
		);
		if ($data['password'] != "") $userdata['user_pass'] = $data['password'];
		$userdata['ID'] = $data['parent_id'];
		
		if ($data['child_ids'] != "")
		{
			$childs_array = explode(',', $data['child_ids']);
			foreach($childs_array as $child)
			{
				$childs[] = $child;
			}
		}
		else
		{
			$childs = array('0' => 0);
		}

		$usermetadata = array(
			'middle_name' => $data['middle_name'],
			'gender' => $data['gender'],
			'birth_date' => $data['birth_date'],
			'address' => $data['address'],
			'city' => $data['city_name'],
			'state' => $data['state_name'],
			'zip_code' => $data['zip_code'],
			'phone' => $data['phone'],
			'mobile_number' => $data['mobile_number'],
			'relation' => $data['relation'],
			'child' => $childs,
			'smgt_user_avatar' => $data['smgt_user_avatar']
		);
		$user_id = wp_update_user($userdata);
		$flag = 0;
		foreach($usermetadata as $key => $val)
			{
			$returnans = update_user_meta($data['parent_id'], $key, $val);
			if ($returnans)
				{
				$returnval = $returnans;
				$flag = 1;
				}
			}

		if ($flag = 1)
			{
			$message['message'] = __("Record successfully Updated!", 'school-mgt');
			$response['status'] = 1;
			$response['resource'] = $message;
			return $response;
			}
		  else
			{
			$error['message'] = __("Please Fill All Fields", 'school-mgt');
			$response['status'] = 0;
			$response['resource'] = $error;
			}

		return $response;
		}

	public	function delete_parent($data)
		{
		$response = array();
		if ($data['parent_id'] != 0)
			{
			$result = delete_usedata($data['parent_id']);
			if ($result)
				{
				$message['message'] = __("Record successfully Deleted!", 'school-mgt');
				$response['status'] = 1;
				$response['resource'] = $message;
				return $response;
				}
			  else
				{
				$message['message'] = __("Records Not Delete", "school-mgt");
				$response['status'] = 0;
				$response['resource'] = $message;
				}

			return $response;
			}
		  else
			{
			$error['message'] = __("Please Fill All Fields", 'school-mgt');
			$response['status'] = 0;
			$response['resource'] = $error;
			}

		return $response;
		}
} ?>