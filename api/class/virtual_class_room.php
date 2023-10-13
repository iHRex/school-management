<?php 

class Virtualclass_list
{

	public function __construct()
    {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
	}
	public function redirectMethod()
	{
        if($_REQUEST["smgt-json-api"]=='virtualclass-list')
        {
            if(isset($_REQUEST["user_id"]))
            {
                $response=$this->virtualclass_list($_REQUEST["user_id"]);	 
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
	}
	public function virtualclass_list($user_id)
	{
        $obj_virtual_classroom = new smgt_virtual_classroom;
        $class_id = get_user_meta($user_id,'class_name',true);
        $section_id = get_user_meta($user_id,'class_section',true);
        if($section_id)
        {
            $meeting_list_data = $obj_virtual_classroom->smgt_get_meeting_by_class_id_and_section_id_data_in_zoom($class_id,$section_id);
        }
        else
        {
            $meeting_list_data = $obj_virtual_classroom->smgt_get_meeting_by_class_id_data_in_zoom($class_id);
        }
        if(!empty($meeting_list_data))
        {
            foreach ($meeting_list_data as $retrieved_data)
            {
                if($retrieved_data->weekday_id == '2')
                {
                    $day = __('Monday','school-mgt');
                }
                elseif($retrieved_data->weekday_id == '3')
                {
                    $day = __('Tuesday','school-mgt');
                }
                elseif($retrieved_data->weekday_id == '4')
                {
                    $day = __('Wednesday','school-mgt');
                }
                elseif($retrieved_data->weekday_id == '5')
                {
                    $day = __('Thursday','school-mgt');
                }
                elseif($retrieved_data->weekday_id == '6')
                {
                    $day = __('Friday','school-mgt');
                }
                elseif($retrieved_data->weekday_id == '7')
                {
                    $day = __('Saturday','school-mgt');
                }
                elseif($retrieved_data->weekday_id == '1')
                {
                    $day = __('Sunday','school-mgt');
                }
                $route_data = get_route_by_id($retrieved_data->route_id);
                $stime = explode(":",$route_data->start_time);
                $start_hour=str_pad($stime[0],2,"0",STR_PAD_LEFT);
                $start_min=str_pad($stime[1],2,"0",STR_PAD_LEFT);
                $start_am_pm=$stime[2];
                $start_time = $start_hour.':'.$start_min.' '.$start_am_pm;

                $etime = explode(":",$route_data->end_time);
                $end_hour=str_pad($etime[0],2,"0",STR_PAD_LEFT);
                $end_min=str_pad($etime[1],2,"0",STR_PAD_LEFT);
                $end_am_pm=$etime[2];
                $end_time = $end_hour.':'.$end_min.' '.$end_am_pm;

                $subid=$retrieved_data->subject_id;
                $subject= get_single_subject_name($subid);

                $cid=$retrieved_data->class_id;
                $class_name=get_class_name($cid);

                if ($retrieved_data->section_id != 0) 
                {
                    $section_name = smgt_get_section_name($retrieved_data->section_id);
                }
                else 
                {
                    $section_name = __('No Section', 'school-mgt');
                }

                $teacher=get_teacher($retrieved_data->teacher_id);

                $start_date=smgt_getdate_in_input_box($retrieved_data->start_date);

                $end_date=smgt_getdate_in_input_box($retrieved_data->end_date);

                $result['subject']=$subject;
                $result['class_name']=$class_name;
                $result['class_section']=$section_name;
                $result['teacher']=$teacher;
                $result['day']=$day;
                $result['start_date']=$start_date;
                $result['end_date']=$end_date;
                $result['start_time']=$start_time;
                $result['end_time']=$end_time;
                $result['join_meeting_link']=$retrieved_data->meeting_join_link;
                
                $response['status']=1;
                $response['resource']=$result;
            }
        }
        else
        {
            $error['message']=__("Records Not Found",'school-mgt');
            $response['status']=0;
            $response['error']=$error;
        }
        return $response;
	}
}
 ?>