<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content top_color">
		<div class="modal-content">
			<div class="view_popup"></div>     
		</div>
    </div>    
</div>
<!-- End POP-UP Code -->
<?php 
	// This is Class at admin side!!!!!!!!! 
	//----------Add-update record---------------------//
	$tablename="transport";
	if(isset($_POST['save_transport']))
	{	
        $nonce = $_POST['_wpnonce'];
		if ( wp_verify_nonce( $nonce, 'save_transpoat_admin_nonce' ) )
		{
			if(isset($_POST['smgt_user_avatar']) && $_POST['smgt_user_avatar'] != "")
			{
				$photo=$_POST['smgt_user_avatar'];
			}
			else
			{
				$photo="";
			}
			
			$route_data=array(
				'route_name'=>MJ_smgt_address_description_validation($_POST['route_name']),
				'number_of_vehicle'=>MJ_smgt_onlyNumberSp_validation($_POST['number_of_vehicle']),
				'vehicle_reg_num'=>MJ_smgt_address_description_validation($_POST['vehicle_reg_num']),
				'smgt_user_avatar'=>$photo,
				'driver_name'=>MJ_smgt_onlyLetter_specialcharacter_validation($_POST['driver_name']),
				'driver_phone_num'=>MJ_smgt_phone_number_validation($_POST['driver_phone_num']),
				'driver_address'=>MJ_smgt_address_description_validation($_POST['driver_address']),
				'route_description'=>MJ_smgt_address_description_validation($_POST['route_description']),					
				'route_fare'=>MJ_smgt_address_description_validation($_POST['route_fare']),
				'created_by'=>get_current_user_id()
			);
					
			//table name without prefix
			$tablename="transport";
			if($_REQUEST['action']=='edit')
			{
				$transport_id=	array('transport_id'=>$_REQUEST['transport_id']);
				$result	=	update_record($tablename,$route_data,$transport_id);
				/* if($result)
				{ */
					wp_redirect ( admin_url().'admin.php?page=smgt_transport&tab=transport&message=2');
				 /* } */
			}
			else
			{		
				$result	=	insert_record($tablename,$route_data);
				
				if($result)
				{	
					$SearchArr['{{route_name}}']	=	$_POST['route_name'];
					$SearchArr['{{vehicle_identifier}}']	=	$_POST['number_of_vehicle'];
					$SearchArr['{{vehicle_registration_number}}']	=	$_POST['vehicle_reg_num'];
					$SearchArr['{{driver_name}}']	=	$_POST['driver_name'];
					$SearchArr['{{driver_phone_number}}']	=	$_POST['driver_phone_num'];
					$SearchArr['{{driver_address}}']	=	$_POST['driver_address'];
					$SearchArr['{{route_fare}}']	=	$_POST['route_fare'];
					$SearchArr['{{school_name}}']	=	 get_option('smgt_school_name');
					$MSG = string_replacement($SearchArr,get_option('school_bus_alocation_mail_content'));
					
					$AllUsr = smgt_get_all_user_in_plugin();
					foreach($AllUsr as $key=>$usr)
					{
						 $to[] = $usr->user_email;
						//$to[] = "meru@dasinfomedia.com";
					}
					smgt_send_mail($to,get_option('school_bus_alocation_mail_subject'),$MSG);
				   wp_redirect ( admin_url().'admin.php?page=smgt_transport&tab=transport&message=1');
				 }
			}
	    }
	}
	if(isset($_REQUEST['delete_selected']))
	{		
		if(!empty($_REQUEST['id']))
		foreach($_REQUEST['id'] as $id)
			$result=delete_transport($tablename,$id);
		if($result)
			{ 
				wp_redirect ( admin_url().'admin.php?page=smgt_transport&tab=transport&message=3');				
			}
	}
	//----------Delete record---------------------------
		$tablename="transport";
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
	{
		$result=delete_transport($tablename,$_REQUEST['transport_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_transport&tab=transport&message=3');					
			}
	}
$active_tab = isset($_GET['tab'])?$_GET['tab']:'transport';
	?>
<div class="page-inner">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
	</div>

<div class=" transport_list" id="main-wrapper"> 
<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Transport Added successfully','school-mgt');
			break;
		case '2':
			$message_string = __('Transport Updated successfully','school-mgt');
			break;	
		case '3':
			$message_string = __('Transport Delete Successfully','school-mgt');
			break;
	}
	
	if($message)
	{ ?>
		<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
			<p><?php echo $message_string;?></p>
			<button type="button" class="notice-dismiss" data-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
<?php } ?>
	<div class="panel panel-white">
					<div class="panel-body"> 
	<h2 class="nav-tab-wrapper">
    	<a href="?page=smgt_transport&tab=transport" class="nav-tab <?php echo $active_tab == 'transport' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Transport List', 'school-mgt'); ?></a>
         <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
       <a href="?page=smgt_transport&tab=addtransport&action=edit&transport_id=<?php echo $_REQUEST['transport_id'];?>" class="nav-tab <?php echo $active_tab == 'addtransport' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Transport', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{?>
    	<a href="?page=smgt_transport&tab=addtransport" class="nav-tab margin_bottom <?php echo $active_tab == 'addtransport' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span>'.__('Add Transport', 'school-mgt'); ?></a>  
        <?php } ?>
    </h2>
    <?php
	
	if($active_tab == 'transport')
	{	
	?>	
   <?php 
		 	$retrieve_class = get_all_data($tablename);
			
		?>
		<div class="panel-body">
		<script>
jQuery(document).ready(function() {
	var table =  jQuery('#transport_list').DataTable({
        responsive: true,
		"order": [[ 1, "asc" ]],
		"aoColumns":[	                  
	                  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},	                  
	                  {"bSortable": false}],
		language:<?php echo smgt_datatable_multi_language();?>
    });
	 jQuery('#checkbox-select-all').on('click', function(){
     
      var rows = table.rows({ 'search': 'applied' }).nodes();
      jQuery('input[type="checkbox"]', rows).prop('checked', this.checked);
   }); 
   
	 $("#delete_selected").on('click', function()
		{	
			if ($('.select-checkbox:checked').length == 0 )
			{
				alert("<?php esc_html_e('Please select atleast one record','school-mgt');?>");
				return false;
			}
		else{
				var alert_msg=confirm("<?php esc_html_e('Are you sure you want to delete this record?','school-mgt');?>");
							if(alert_msg == false)
							{
								return false;
							}
							else
							{
								return true;
							}
			}
	});
   
});

</script>
        	<div class="table-responsive">
			<form id="frm-example" name="frm-example" method="post">	
        <table id="transport_list" class="display admin_transport_datatable" cellspacing="0" width="100%">
        	 <thead>
            <tr>         
				<th style="width: 20px;"><input name="select_all" value="all" id="checkbox-select-all" 
				type="checkbox" /></th>      
				<th><?php echo _e( 'Photo', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Route Name', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Vehicle Identifier', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Vehicle Registration Number', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Driver Name', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Driver Phone Number', 'school-mgt' ) ;?></th>
				<th><?php echo _e( 'Route Fare', 'school-mgt' ) ;?>(<?php echo get_currency_symbol();?>)</th>
                <th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>               
            </tr>
        </thead>
 
        <tfoot>
            <tr>
				<th></th>
				<th><?php echo _e( 'Photo', 'school-mgt' ) ;?></th>
            	<th><?php echo _e( 'Route Name', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Vehicle Identifier', 'school-mgt' ) ;?></th>
                <th width="150px"><?php echo _e( 'Vehicle Registration Number', 'school-mgt' ) ;?></th>				
                <th><?php echo _e( 'Driver Name', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Driver Phone Number', 'school-mgt' ) ;?></th>
                <th><?php echo _e( 'Route Fare', 'school-mgt' ) ;?>(<?php echo get_currency_symbol();?>)</th>
                <th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>  
            </tr>
        </tfoot>
 
        <tbody>
          <?php 
		 foreach ($retrieve_class as $retrieved_data){ 
		?>
            <tr>
				<td><input type="checkbox" class="select-checkbox" name="id[]" 
				value="<?php echo $retrieved_data->transport_id;?>"></td>
				
				
						<td class="user_image"><?php $tid=$retrieved_data->transport_id;
							$umetadata=get_user_driver_image($tid);
						
							if(empty($umetadata) || $umetadata['smgt_user_avatar'] == "")
							{	
								echo '<img src="'.get_option( 'smgt_driver_thumb' ).'" height="50px" width="50px" class="img-circle" />';
							}
							else
							echo '<img src='.$umetadata['smgt_user_avatar'].' height="50px" width="50px" class="img-circle" />';?>				
				
				</td>
				<td><?php echo $retrieved_data->route_name;?></td>
                <td><?php echo $retrieved_data->number_of_vehicle;?></td> 
				<td><?php echo $retrieved_data->vehicle_reg_num;?></td>				
                 <td><?php echo $retrieved_data->driver_name;?></td>
                  <td><?php echo $retrieved_data->driver_phone_num;?></td>
               <td><?php echo $retrieved_data->route_fare;?></td>         
               <td>
			   <a href="#" id="<?php echo $retrieved_data->transport_id;?>" type="transport_view" class="view_details_popup btn btn-success"><?php _e('View','school-mgt');?></a>
			   <a href="?page=smgt_transport&tab=addtransport&action=edit&transport_id=<?php echo $retrieved_data->transport_id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
               <a href="?page=smgt_transport&tab=transport&action=delete&transport_id=<?php echo $retrieved_data->transport_id;?>" class="btn btn-danger" 
               onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"> <?php _e('Delete','school-mgt');?></a></td>
            </tr>
            <?php } ?>
     
        </tbody>
        
        </table>
		<div class="print-button pull-left">
			<input id="delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="delete_selected" class="btn btn-danger delete_selected"/>
			
		</div>
		</form>
        </div>
        </div>
       
     <?php 
	 }
	if($active_tab == 'addtransport')
	 {
		require_once SMS_PLUGIN_DIR. '/admin/includes/transport/add-transport.php';
		
	 }
	 ?>
	 </div>
	 </div>
	 </div>
</div>
<?php ?>