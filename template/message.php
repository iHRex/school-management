<?php
//-------- CHECK BROWSER JAVA SCRIPT ----------//
MJ_smgt_browser_javascript_check();
//--------------- ACCESS WISE ROLE -----------//
$user_access=smgt_get_userrole_wise_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		MJ_smgt_access_right_page_not_access_message();
		die;
	}
	if(!empty($_REQUEST['action']))
	{
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
		{
			if($user_access['edit']=='0')
			{	
				MJ_smgt_access_right_page_not_access_message();
				die;
			}			
		}
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
		{
			if($user_access['delete']=='0')
			{	
				MJ_smgt_access_right_page_not_access_message();
				die;
			}	
		}
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
		{
			if($user_access['add']=='0')
			{	
				MJ_smgt_access_right_page_not_access_message();
				die;
			}	
		} 
	}
}
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'inbox'; 
?>
<div class="row mailbox-header">
	<div class="col-md-2">
	<?php
	if($user_access['add']=='1')
	{  ?>
		<a class="btn btn-success btn-block" href="?dashboard=user&page=message&tab=compose">
			<?php _e("Compose","school-mgt");?>
		</a>
	<?php
	} ?>
	</div>
	<div class="col-md-6">
		<h2>
			<?php
			if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox'))
			{
				echo esc_html( __( 'Inbox', 'school-mgt' ) );
			}
			else if(isset($_REQUEST['page']) && $_REQUEST['tab'] == 'sentbox')
			{
				echo esc_html( __( 'Sent Item', 'school-mgt' ) );
			}
			else if(isset($_REQUEST['page']) && $_REQUEST['tab'] == 'compose')
			{
				echo esc_html( __( 'Compose', 'school-mgt' ) );
			}
			else if(isset($_REQUEST['page']) && $_REQUEST['tab'] == 'view_message')
			{
				echo esc_html( __( 'View Message', 'school-mgt' ) );
			}
			?>                                   
		</h2>
	</div>
</div>
<div class="col-md-2">
	<ul class="list-unstyled mailbox-nav">
		<li <?php if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox')){?>class="active"<?php }?>>
			<a href="?dashboard=user&page=message&tab=inbox">
				<i class="fa fa-inbox"></i><?php _e("Inbox","school-mgt");?> <span class="badge badge-success pull-right">
				<?php echo smgt_count_unread_message(get_current_user_id());?></span>
			</a>
		</li>		
		<li <?php if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'sentbox'){?>class="active"<?php }?>><a href="?dashboard=user&page=message&tab=sentbox"><i class="fa fa-sign-out"></i><?php _e("Sent","school-mgt");?></a></li>
	</ul>
</div>
 <div class="col-md-10">
 <?php  
 	if($active_tab == 'sentbox')
 		require_once SMS_PLUGIN_DIR. '/template/sendbox.php';
 	if($active_tab == 'inbox')
 		require_once SMS_PLUGIN_DIR. '/template/inbox.php';
 	if($active_tab == 'compose')
 		require_once SMS_PLUGIN_DIR. '/template/composemail.php';
 	if($active_tab == 'view_message')
 		require_once SMS_PLUGIN_DIR. '/template/view_message.php';
 	?>
 </div>
<?php  ?>