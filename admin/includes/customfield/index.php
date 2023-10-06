<?php 
$obj_custome_field=new Smgt_custome_field;

	//save Custom Field Data
	if(isset($_POST['add_custom_field']))
	{	
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='insert')
		{		
			//add Custom Field data
			$result=$obj_custome_field->Smgt_add_custom_field($_POST);		   
			if($result)
			{
				wp_redirect ( admin_url() . 'admin.php?&page=custom_field&tab=custome_field_list&message=1');
			}			
		}
		else
		{		
			//update Custom Field data
			$result=$obj_custome_field->Smgt_add_custom_field($_POST);			
			if($result)
			{
				wp_redirect ( admin_url() . 'admin.php?&page=custom_field&tab=custome_field_list&message=2');	
			}	
		}
	}
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
	{		
		$result=$obj_custome_field->Smgt_delete_custome_field($_REQUEST['id']);
		
		if($result)
		{
			wp_redirect ( admin_url() . 'admin.php?page=custom_field&tab=custome_field_list&message=3');
		}
	}
	if(isset($_POST['custome_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			foreach($_POST["selected_id"] as $custome_id)
			{		
				$record_id=$custome_id;
				$result=$obj_custome_field->Smgt_delete_selected_custome_field($record_id);
			}	
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','school-mgt');?>
				</div>
		<?php		
		}	
		if($result)
		{
			wp_redirect ( admin_url() . 'admin.php?page=custom_field&tab=custome_field_list&message=3');
		}	
	}
	$active_tab = isset($_GET['tab'])?$_GET['tab']:'custome_field_list';
?>
<div class="page-inner">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
	</div>
	<div  id="main-wrapper" class="grade_page">
	<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Custom Field Added Successfully.','school-mgt');
			break;
		case '2':
			$message_string = __('Custom Field  Updated Successfully.','school-mgt');
			break;	
		case '3':
			$message_string = __('Custom Field  Delete Successfully.','school-mgt');
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
    	<a href="?page=custom_field&tab=custome_field_list" class="nav-tab margin_bottom <?php echo $active_tab == 'custome_field_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Custom Field List', 'school-mgt'); ?></a>
         <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
       <a href="?page=custom_field&tab=add_custome_field&action=edit&id=<?php echo $_REQUEST['id'];?>" class="nav-tab margin_bottom<?php echo $active_tab == 'add_custome_field' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Custom Field', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{?>
    	<a href="?page=custom_field&tab=add_custome_field" class="nav-tab margin_bottom <?php echo $active_tab == 'addexam' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span>'.__('Add Custom Field', 'school-mgt'); ?></a>  
        <?php } ?>
    </h2>
    <?php
	
	if($active_tab == 'custome_field_list')
	{	
	?>	
   <?php 
		$retrieve_class=$obj_custome_field->Smgt_get_all_custom_field_data();
		?>
        <div class="panel-body">
		<div class="table-responsive">
		<script>
jQuery(document).ready(function() {
	var table =  jQuery('#custome_field_list').DataTable({
        responsive: true,
		"order": [[ 1, "asc" ]],
		"aoColumns":[	                  
	                  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},	                  
	                  {"bSortable": false}],
		language:<?php echo smgt_datatable_multi_language();?>
    });
	/*  jQuery('#checkbox-select-all').on('click', function(){
     
      var rows = table.rows({ 'search': 'applied' }).nodes();
      jQuery('input[type="checkbox"]', rows).prop('checked', this.checked);
   }); 
   
	jQuery('#delete_selected').on('click', function(){
		 var c = confirm('Are you sure to delete?');
		if(c){
			jQuery('#frm-example').submit();
		}
		
	}); */
	$(".delete_check").on('click', function()
		{	
			if ($('.sub_chk:checked').length == 0 )
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
$(document).ready(function()
	{
		jQuery('#select_all').on('click', function(e)
		{
			 if($(this).is(':checked',true))  
			 {
				$(".sub_chk").prop('checked', true);  
			 }  
			 else  
			 {  
				$(".sub_chk").prop('checked',false);  
			 } 
		});
		$('.sub_chk').on("change",function()
		{ 
			if(false == $(this).prop("checked"))
			{ 
				$("#select_all").prop('checked', false); 
			}
			if ($('.sub_chk:checked').length == $('.sub_chk').length )
			{	
				$("#select_all").prop('checked', true);
			}
		});
	});		
</script>
<form id="frm-example" name="frm-example" method="post">	
        <table id="custome_field_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>    
				<th style="width: 20px;"><input type="checkbox" id="select_all"></th>
                <th><?php _e('Form Name','school-mgt');?></th>
                <th><?php _e('Lable','school-mgt');?></th>
                <th><?php _e('Type','school-mgt');?></th>
                <th><?php _e('Validation','school-mgt');?></th>
                <th><?php _e('Action','school-mgt');?></th>               
            </tr>
        </thead>
 
        <tfoot>
            <tr>
				<th></th>
               <th><?php _e('Form Name','school-mgt');?></th>
                <th><?php _e('Lable','school-mgt');?></th>
                <th><?php _e('Type','school-mgt');?></th>
                <th><?php _e('Validation','school-mgt');?></th>
                <th><?php _e('Action','school-mgt');?></th>   
            </tr>
        </tfoot>
 
        <tbody>
          <?php 
		 	foreach ($retrieve_class as $retrieved_data){ 
			
		 ?>
            <tr>
				<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->id); ?>"></td>	
				<td class="added"><?php echo esc_html($retrieved_data->form_name);?></td>	
				<td class="added"><?php echo esc_html($retrieved_data->field_label);?></td>	
				<td class="added"><?php echo esc_html($retrieved_data->field_type);?></td>
				<td class="added"><?php echo esc_html($retrieved_data->field_validation);?></td>
                <td><a href="?page=custom_field&tab=add_custome_field&action=edit&id=<?php echo $retrieved_data->id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
               <a href="?page=custom_field&tab=custome_field_list&action=delete&id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
               onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"><?php _e('Delete','school-mgt');?></a></td>
            </tr>
            <?php } ?>
     
        </tbody>
        
        </table>
		 <div class="print-button pull-left">
			<input id="custome_delete_selected" type="submit" value="<?php _e('Delete Selected','school-mgt');?>" name="custome_delete_selected" class="btn btn-danger delete_selected"/>
			
		</div>
		</form>
       </div>
     <?php 
	 }
	if($active_tab == 'add_custome_field')
	 {
		require_once SMS_PLUGIN_DIR. '/admin/includes/customfield/add_customfield.php';
		
	 }
	 ?>
	 		</div>
		</div>
	 	</div>
	 </div>
</div>
<?php ?>