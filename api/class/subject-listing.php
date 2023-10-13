<?php

class SubjectListing

{

    public function __construct()

    {

        add_action('template_redirect', array($this,'redirectMethod'), 1);

    }

    public function redirectMethod()

    {

        error_reporting(0);

        if ($_REQUEST['smgt-json-api'] == 'subject-listing') 

		{

            $school_obj = new School_Management($_REQUEST['current_user']);

            //if ($school_obj->role == 'student') 

			//{				

                $response = $this->subject_listing($_REQUEST);

            //}

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

		

		if ($_REQUEST['smgt-json-api'] == 'all-subject-listing') 

		{

            $response = $this->all_subject_listing();

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

       

        $response      = array();

		$school_obj = new School_Management ($data['current_user']);

		$role= smgt_get_user_role($data["current_user"]);

		$menu_access_data=smgt_get_userrole_wise_access_right_array_in_api($data['current_user'],'subject');

		 

		if($role=='student'){			

			if($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 1 )

			{

				$subjectdata = $school_obj->subject;	

			}

			elseif($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 0 )

			{

				$subjectdata = get_all_data('subject');

			}

			else

			{

				$subjectdata="";

			}

		}

        if (!empty($subjectdata)) 

		{
            /* var_dump($subjectdata);
                die;*/

            $i = 0;

            foreach ($subjectdata as $retrieved_data) 

			{

                $teacher_group = array();

                $teacher_ids = smgt_teacher_by_subject($retrieved_data);

                foreach($teacher_ids as $teacher_id)
                {
                    $teacher_group[] = get_teacher($teacher_id);
                }
                $teachers = implode(',',$teacher_group);

                $result[$i]['id']           = $retrieved_data->subid;

                $result[$i]['subject_name'] = $retrieved_data->sub_name;

               // $uid                        = $retrieved_data->teacher_id;

                //$result[$i]['teacher_id']   = $uid;

                $result[$i]['teacher']      = $teachers;

                $cid                        = $retrieved_data->class_id;

                $result[$i]['class_id']     = $cid;

                $result[$i]['class']        = get_class_name($cid);

                if ($retrieved_data->section_id != 0) 

				{

                    $result[$i]['section_id'] = $retrieved_data->section_id;

                    $section_name             = smgt_get_section_name($retrieved_data->section_id);

                }

				else 

				{

                    $section_name = __('No Section', 'school-mgt');

                }

                $result[$i]['section']     = $section_name;

                $result[$i]['author_name'] = $retrieved_data->author_name;

                $result[$i]['edition']     = $retrieved_data->edition;

                $syllabus                  = "";

                if ($retrieved_data->syllabus != "")

                    $syllabus = content_url() . '/uploads/school_assets/' . $retrieved_data->syllabus;

                $result[$i]['syllabus_url'] = $syllabus;

                $i++;

            }

            $response['status']   = 1;

            $response['resource'] = $result;

            return $response;

        }

		else 

		{

           // $error['message']     = __("Please Fill All Fields", 'school-mgt');

            $response['status']   = 0;

            $response['message'] =  __("Record not found", 'school-mgt');

        }

        return $response;

    }

	

	public function all_subject_listing()

    {

        global $wpdb;

        $response      = array();

        $table_name    = $wpdb->prefix . "subject";

        $sql           = "SELECT * FROM $table_name";

        $subjectdata   = $wpdb->get_results($sql);

        if (!empty($subjectdata)) 

		{

            $i = 0;

            foreach ($subjectdata as $retrieved_data) 

			{

                $result[$i]['id']           = $retrieved_data->subid;

                $result[$i]['subject_name'] = $retrieved_data->sub_name;

                $i++;

            }

            $response['status']   = 1;

            $response['resource'] = $result;

            return $response;

        }

		else 

		{

            $response['status']   = 0;

            $response['message'] =  __("Record not found", 'school-mgt');

        }

        return $response;

    }

}

?>