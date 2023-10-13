<?php 
class ClassAccessRigths{

	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
	}
	public function redirectMethod()
	{
			//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='menu-accessrigths')
			{
				$response=$this->class_accessrigths($_REQUEST);	 
				if(is_array($response))
				{
					header("HTTP/1.1 200");
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
	}
	public function class_accessrigths($data)
	{
		$response=array();
		$menu = get_option( 'smgt_access_right_student');
		$menu_array = array();
		if($menu)
		{
			foreach ( $menu as $key1=>$value1 ) 
			{
				$i=1;
				foreach ( $value1 as $key=>$value ) 
				{
				   $menu_array1['id'] = $i;
				   $menu_array1['page_link'] = $value['page_link'];
				   $menu_array1['menu_title'] = $value['menu_title'];
				   $menu_array1['menu_icone'] = $value['menu_icone'];
				   $menu_array1['app_icone'] = $value['app_icone'];
				   $menu_array1['view'] = $value['view'];
				   $menu_array1['own_data'] = $value['own_data'];
				   $menu_array1['add'] = $value['add'];
				   $menu_array1['edit'] = $value['edit'];
				   $menu_array1['delete'] = $value['delete'];
				   if($value['view'] == '1')
					{
						$menu_array1['flag'] = true;
					}
					else
					{
						$menu_array1['flag'] = false;
					}
				   $menu_array[]= $menu_array1;
				   $i++;
				}
				$lancode=get_locale();
				$code=substr($lancode,0,2);
				$response['status']=1;
				$response['language']=$code;
				$response['resource']= $menu_array;
				$response['message']=__("You have AccessRigths","school-mgt");
		    }
		}
		else
		{
			$response['status']=0;
			$response['resource']= '';
			$response['message']=__("You have not AccessRigths","school-mgt");
			
		}
		return $response;
	}

} ?>