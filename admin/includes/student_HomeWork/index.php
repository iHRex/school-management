<script type="text/javascript">
 $(document).ready(function() {
	  $('#class_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
 } );
</script> 
<?php 
    $obj_feespayment=new Smgt_Homework();
	 
// Save HomeWork !!!!!!!!! 
	if(isset($_POST['Save_Homework']))
	{
		$nonce = $_POST['_wpnonce'];
		if ( wp_verify_nonce( $nonce, 'save_homework_admin_nonce' ) )
		{
			$insert=new Smgt_Homework();
			if($_POST['action'] == 'edit')
			{
				if(isset($_FILES['homework_document']) && !empty($_FILES['homework_document']) && $_FILES['homework_document']['size'] !=0)
				{		
					if($_FILES['homework_document']['size'] > 0)
						$upload_docs1=smgt_load_documets_new($_FILES['homework_document'],$_FILES['homework_document'],$_POST['document_name']);		
				}
				else
				{
					if(isset($_REQUEST['old_hidden_homework_document']))
					$upload_docs1=$_REQUEST['old_hidden_homework_document'];
				}
				 
				$document_data=array();
				if(!empty($upload_docs1))
				{
					$document_data[]=array('title'=>$_POST['document_name'],'value'=>$upload_docs1);
				}
				else
				{
					$document_data[]='';
				}
				
				$update_data=$insert->add_homework($_POST,$document_data);
				if($update_data)
				{
					wp_redirect ( admin_url().'admin.php?page=smgt_student_homewrok&tab=homeworklist&message=2');
				}
			}
			else 
			{
				$args = array( 'meta_query' => array( array( 'key' => 'class_name', 'value' => $_POST['class_name'], 'compare' => '=' ) ), 'count_total' => true ); 
				$users = new WP_User_Query($args); 
				if ($users->get_total() == 0)
				{
					wp_redirect ( admin_url().'admin.php?page=smgt_student_homewrok&tab=homeworklist&message=4');
				}
				else
				{
					if(isset($_FILES['homework_document']) && !empty($_FILES['homework_document']) && $_FILES['homework_document']['size'] !=0)
					{		
						if($_FILES['homework_document']['size'] > 0)
							$upload_docs1=smgt_load_documets_new($_FILES['homework_document'],$_FILES['homework_document'],$_POST['document_name']);		
					}
					else
					{
						$upload_docs1='';
					}
					 
					$document_data=array();
					if(!empty($upload_docs1))
					{
						$document_data[]=array('title'=>$_POST['document_name'],'value'=>$upload_docs1);
					}
					else
					{
						$document_data[]='';
					}
					
					$insert_data=$insert->add_homework($_POST,$document_data);
					if($insert_data)
					{
						wp_redirect ( admin_url().'admin.php?page=smgt_student_homewrok&tab=homeworklist&message=1');
					}
				}
			}
		}
    }
	$tablename="mj_smgt_homework";
	/*Delete selected Subject*/
	if(isset($_REQUEST['delete_selected']))
	{		
	    $ojc=new Smgt_Homework();
		 if(!empty($_REQUEST['id']))
		 {
		   foreach($_REQUEST['id'] as $id)
		    {
			  $delete=$ojc->get_delete_records($tablename,$id);
		    }
			if($delete)
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_student_homewrok&tab=homeworklist&message=3');
			}
	    }
	}
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
	{
		$delete=new Smgt_Homework();
	    $dele=$delete->get_delete_record($_REQUEST['homework_id']);
		if($dele)
		{
			wp_redirect ( admin_url().'admin.php?page=smgt_student_homewrok&tab=homeworklist&message=3');
		}
	}

$active_tab = isset($_GET['tab'])?$_GET['tab']:'homeworklist';
	?>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
    <div class="modal-content">
    <div class="invoice_data">
     </div>
     
    </div>
    </div> 
</div>
<!-- End POP-UP Code -->
<div class="page-inner">
<div class="page-title">
		<h3><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?></h3>
</div>
<div  id="main-wrapper" class="class_list grade_page">
<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Homework Added Successfully.','school-mgt');
			break;
		case '2':
			$message_string = __('Homework Updated Successfully.','school-mgt');
			break;	
		case '3':
			$message_string = __('Homework Delete Successfully.','school-mgt');
			break;
		case '4':
			$message_string = __('No Student Available In This Class.','school-mgt');
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
    	<a href="?page=smgt_student_homewrok&tab=homeworklist" class="nav-tab <?php echo $active_tab == 'homeworklist' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span>'. __('Homework List', 'school-mgt'); ?></a>
         <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
          <a href="?page=smgt_student_homewrok&tab=homeworklist&&action=edit&homework_id=<?php echo $_REQUEST['homework_id'];?>" class="nav-tab <?php echo $active_tab == 'addhomework' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Homework', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{?>
			<a href="?page=smgt_student_homewrok&tab=addhomework" class="nav-tab <?php echo $active_tab == 'addhomework' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span>'.__('Add Homework', 'school-mgt'); ?></a>  
        <?php 
		} ?>
		
		<a href="?page=smgt_student_homewrok&tab=view_stud_detail" class="nav-tab <?php echo $active_tab == 'view_stud_detail' ? 'nav-tab-active' : ''; ?> ">
		<?php echo '<span class="fa fa-eye"></span>'. __('View Submission', 'school-mgt'); ?></a>
    
	</h2>
    
    <?php
	
	if($active_tab == 'homeworklist')
	{	
		require_once SMS_PLUGIN_DIR. '/admin/includes/student_HomeWork/homeworklist.php'; 
	}
	if($active_tab == 'addhomework')
	{
		require_once SMS_PLUGIN_DIR. '/admin/includes/student_HomeWork/add-studentHomework.php';
	}
	 
	// view student Status
	if($active_tab == 'view_stud_detail')
	{	
		$homework=new Smgt_Homework();
		$res=$homework->smgt_get_class_homework();
	
		?>
			<div class="panel-body">	
				<form name="class_form" action="" method="post" class="form-horizontal" id="class_form">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="homewrk"><?php _e('Select Homework','school-mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-4">
								<select name="homewrk" class="form-control validate[required]" id="homewrk">
								<option value=""><?php _e('Select Homework','school-mgt');?></option>
								<?php
								$classval='';
								if(isset($_POST['homewrk']))
								{
									$classval=$_POST['homewrk'];
								}
								foreach($res as $classdata)
								{  
								?>
									<option value="<?php echo $classdata->homework_id;?>" <?php selected($classdata->homework_id,$classval);  ?>><?php echo $classdata->title;?></option>
								<?php 
								}?>
							</select>
						</div>
						<div class="col-sm-4">
								<label for="subject_id">&nbsp;</label>
						<input type="submit" value="<?php _e('View','school-mgt');?>" name="view"  class="btn btn-info custom_class"/>
						  
						</div>
					</div>    
					<?php
					$obj=new Smgt_Homework();
					if(isset($_POST['homewrk']))
					{
					  $data=$_POST['homewrk'];
					  $retrieve_class=$obj-> view_submission($data);
						 require_once SMS_PLUGIN_DIR. '/admin/includes/student_HomeWork/viewsubmission.php';
					}
					else
					{
					  if(isset($_REQUEST['homework_id']))
					  {
						 $data=$_REQUEST['homework_id'];
						 $retrieve_class=$obj-> view_submission($data);
						 require_once SMS_PLUGIN_DIR. '/admin/includes/student_HomeWork/viewsubmission.php';
					  }
					}
					?>
				</form>
			</div>
     <?php
	}
	?>