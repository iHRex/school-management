<?php 
class ClassDateFormate
{
	public function __construct() 
	{
		add_action('template_redirect', array($this,'redirectMethod'), 1);
	}
	public function redirectMethod()
	{
		//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='get_web_dateformate')
			{
				$date_format = get_option( 'smgt_datepicker_format' );
				$response['status']=1;
			    $response['resource']=$date_format;
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
}  
?>