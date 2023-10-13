<?php
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete_users_message')	
{		
	global $wpdb;
	$tablename		=	"smgt_message";
	$table_name = $wpdb->prefix . $tablename;
	
	$result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE message_id= %d",$_REQUEST['users_message_id']));
	if($result)
	{	
		wp_redirect ( admin_url().'admin.php?page=smgt_message&tab=view_all_message&message=2');
	}
}
if(isset($_POST['delete_selected']))
{		
	global $wpdb;
	$tablename		=	"smgt_message";
	$table_name = $wpdb->prefix . $tablename;
		
	if(!empty($_REQUEST['id']))
	{
		foreach($_REQUEST['id'] as $id)
		{
			$result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE message_id= %d",$id));			
		}
		if($result)
		{ 
			wp_redirect ( admin_url().'admin.php?page=smgt_message&tab=view_all_message&message=2');
		}
	}
}
?>
<div class="mailbox-content">
	<script type='text/javascript' src='https://code.jquery.com/jquery-3.3.1.js'></script>
 <script type='text/javascript' src='https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'></script>
 <script type='text/javascript' src='https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js'></script>
 <script type='text/javascript' src='https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js'></script>
 <script type='text/javascript' src='https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js'></script>
 <script type='text/javascript' src='https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js'></script>
 <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
 <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
 <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
 <script type='text/javascript' src='https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js'></script>
		
	<script>
	jQuery(document).ready(function() 
	{
		var table = jQuery('#all_message_list').DataTable({
		 "responsive": true,
		 dom: 'Bfrtip',
         buttons: [
			{
                extend: 'print',
                text:'<?php _e("Print","school-mgt");?>',
				title: 'Message Data',
				exportOptions: 
				{
                    columns: [1,2,3,4,5,6,8],
					modifier: {
                        selected: null
                    }
                }
            }
        ], 
		"bProcessing": true,
		 "bServerSide": true,
		 "sAjaxSource": ajaxurl+'?action=smgt_view_all_message',
		 "bDeferRender": true, 		
		responsive: true,
		"order": [[ 1, "asc" ]],
	    "aoColumns":[
		  {"bSortable": false},
		  {"bSortable": false},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},              	                 
		  {"bSortable": true},       
		  {"bSortable": true},              	                 
		  {"bSortable": false},              	                 
		  {"bSortable": true},              	                 
		  {"bSortable": false}],
		  language:<?php echo smgt_datatable_multi_language();?>
		  });
		  
		table.on('page.dt', function() {
		  $('html, body').animate({
			scrollTop: $(".dataTables_wrapper").offset().top
		   }, 'slow');
		}); 
		
		$(".delete_check").on('click', function()
		{	
			if ($('.sub_chk:checked').length == 0 )
			{
				 alert("<?php esc_html_e('Please select atleast one message','school-mgt');?>");
				return false;
			}
			else{
				alert("<?php esc_html_e('Are you sure you want to delete this message?','school-mgt');?>");
				return true;
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
		$("body").on("change", ".sub_chk", function(event)
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
        <table id="all_message_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr> 
				<th style="width: 20px;"><input name="select_all" value="all" id="select_all" 
				type="checkbox" /></th> 
                <th><?php _e('Message For','school-mgt');?></th>
                <th><?php _e('Sender','school-mgt');?></th>
                <th><?php _e('Receiver','school-mgt');?></th>
                <th><?php _e('Class','school-mgt');?></th>
                <th class="width_100px"><?php _e('Subject','school-mgt');?></th>
                <th class="width_400px"><?php _e('Description','school-mgt');?></th>
                <th><?php _e('Attachment','school-mgt');?></th>
                <th class="width_200px"><?php _e('Date & Time','school-mgt');?></th>
                <th><?php _e('Action','school-mgt');?></th>               
            </tr>
        </thead>
 
        <tfoot>
            <tr>
				<th></th>
                <th><?php _e('Message For','school-mgt');?></th>
				<th><?php _e('Sender','school-mgt');?></th>
                <th><?php _e('Receiver','school-mgt');?></th>
                <th><?php _e('Class','school-mgt');?></th>
                <th><?php _e('Subject','school-mgt');?></th>
                <th><?php _e('Description','school-mgt');?></th>
                <th><?php _e('Attachment','school-mgt');?></th>
                <th><?php _e('Date & Time','school-mgt');?></th>  
                <th><?php _e('Action','school-mgt');?></th>  
            </tr>
        </tfoot>
        </table>
		<div class="form-group">		
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0px;">	
				<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="delete_selected"  value="<?php esc_html_e('Delete Selected', 'school-mgt' ) ;?> " />
			</div>
		</div>			
		</form>
</div>