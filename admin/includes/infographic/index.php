<?php 
$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'show_infographic';
if(isset($_REQUEST['save_infographic']))
{
	update_option('smgt_enable_total_student',$_REQUEST['smgt_enable_total_student']);
	update_option('smgt_enable_total_teacher',$_REQUEST['smgt_enable_total_teacher']);	
	update_option('smgt_enable_total_parent',$_REQUEST['smgt_enable_total_parent']);	
	update_option('smgt_enable_total_attendance',$_REQUEST['smgt_enable_total_attendance']);	
	
} ?>

<div class="page-inner">
	<div class="page-title"> 
		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
	</div>
		 <?php if(isset($_REQUEST['save_registration_template']) || isset($_REQUEST['save_activation_mailtemplate']))
					{ ?>
						<div class="alert alert-success" role="alert">
							<h3>
							<span class="dashicons dashicons-yes"></span>
							<?php _e('Saved Successfully ','school-mgt');?>
							</h3>
						</div>
			<?php } ?>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper">
			    			<a href="?page=smgt_show_infographic&tab=show_infographic" class="nav-tab <?php echo $active_tab == 'show_infographic' ? 'nav-tab-active' : ''?>">
							<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Show Infographic', 'school-mgt'); ?></a>
						</h2> 
					<div class="clearfix"></div>
    	<?php require_once SMS_PLUGIN_DIR. '/admin/includes/infographic/'.$active_tab.'.php';?>
			</div>
	</div>
</div>

