<?php 
//-------- CHECK BROWSER JAVA SCRIPT ----------//
MJ_smgt_browser_javascript_check();
$active_tab = isset($_GET['tab'])?$_GET['tab']:'examlist';
$obj_exam=new smgt_exam;
require_once SMS_PLUGIN_DIR. '/school-management-class.php';
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
$tablename="exam";
 //----------------- DELETE EXAM ----------------//
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
	{
		$result=delete_exam($tablename,$_REQUEST['exam_id']);
		if($result){
			wp_redirect ( home_url() . '?dashboard=user&page=exam&tab=examlist&message=3'); 	
		}
	}
	//-----------SAVE EXAM -------------------------//
	if(isset($_POST['save_exam']))
	{	
        $nonce = $_POST['_wpnonce'];
		if ( wp_verify_nonce( $nonce, 'save_exam_admin_nonce' ) )
		{
			$created_date = date("Y-m-d H:i:s");
			$examdata=array('exam_name'=>MJ_smgt_popup_category_validation($_POST['exam_name']),
				'class_id'=>$_POST['class_id'],
				'section_id'=>$_POST['class_section'],
				'exam_term'=>$_POST['exam_term'],
				'passing_mark'=>$_POST['passing_mark'],
				'total_mark'=>$_POST['total_mark'],
				'exam_start_date'=>date('Y-m-d', strtotime($_POST['exam_start_date'])),
				'exam_end_date'=>date('Y-m-d', strtotime($_POST['exam_end_date'])),
				'exam_comment'=>MJ_smgt_address_description_validation($_POST['exam_comment']),					
				'exam_creater_id'=>get_current_user_id(),
				'created_date'=>$created_date						
			);		
			if ($_POST['passing_mark'] >= $_POST['total_mark'])
			{
				wp_redirect ( home_url() . '?dashboard=user&page=exam&tab=examlist&message=6');
			}
			else
			{
				//table name without prefix
				$tablename="exam";
				if($_REQUEST['action']=='edit')
				{
					if(isset($_FILES['exam_syllabus']) && !empty($_FILES['exam_syllabus']) && $_FILES['exam_syllabus']['size'] !=0)
					{		
						if($_FILES['exam_syllabus']['size'] > 0)
							$upload_docs1=smgt_load_documets_new($_FILES['exam_syllabus'],$_FILES['exam_syllabus'],$_POST['document_name']);		
					}
					else
					{
						if(isset($_REQUEST['old_hidden_exam_syllabus']))
						$upload_docs1=$_REQUEST['old_hidden_exam_syllabus'];
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
					 	
					$grade_id=array('exam_id'=>$_REQUEST['exam_id']);
					$modified_date_date = date("Y-m-d H:i:s");
					$examdata['modified_date']=$modified_date_date;
					$examdata['exam_syllabus']=json_encode($document_data);
					$result=update_record($tablename,$examdata,$grade_id);
					if($result)
					{
						wp_redirect ( home_url() . '?dashboard=user&page=exam&tab=examlist&message=2'); 	
					}
				}
				else
				{
					if(isset($_FILES['exam_syllabus']) && !empty($_FILES['exam_syllabus']) && $_FILES['exam_syllabus']['size'] !=0)
					{		
						if($_FILES['exam_syllabus']['size'] > 0)
							$upload_docs1=smgt_load_documets_new($_FILES['exam_syllabus'],$_FILES['exam_syllabus'],$_POST['document_name']);		
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
					$examdata['exam_syllabus']=json_encode($document_data);
				 				
					$result=insert_record($tablename,$examdata);
					if($result)
					{ 
						wp_redirect ( home_url() . '?dashboard=user&page=exam&tab=examlist&message=1'); 	
					}				
				}
			}
		}		
	}
?>
<script>
$(document).ready(function() {
    $('#examt_list').DataTable({
        responsive: true,
		language:<?php echo smgt_datatable_multi_language();?>	
    });
} );
</script>

<!-- Nav tabs -->
<div class="panel-body panel-white">
<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Exam Added Successfully.','school-mgt');
			break;
		case '2':
			$message_string = __('Exam Updated Successfully.','school-mgt');
			break;	
		case '3':
			$message_string = __('Exam Delete Successfully.','school-mgt');
			break;
		case '4':
			$message_string = __('This File Type Is Not Allowed, Please Upload Only Pdf File.','school-mgt');
			break;
		case '5':
			$message_string = __('Exam Time Table Successfully Save.','school-mgt');
			break;
		case '6':
			$message_string = __('Enter Total Marks Greater than Passing Marks.','school-mgt');
			break;
	}
	
	if($message)
	{ ?>
		<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<?php echo $message_string;?>
		</div>
<?php 
	} ?>
	<ul class="nav nav-tabs panel_tabs" role="tablist">
		<li class=" <?php echo $active_tab == 'examlist' ? 'active' : ''; ?>">
			<a href="?dashboard=user&page=exam&tab=examlist" class="nav-tab2"> <strong>
				<i class="fa fa-align-justify"> </i> <?php _e('Exam List', 'school-mgt'); ?></strong>
			</a>
		</li>
		<li class=" <?php echo $active_tab == 'addexam' ? 'active' : ''; ?>">
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
			<a href="?dashboard=user&page=exam&tab=addexam&action=edit&exam_id=<?php echo $_REQUEST['exam_id'];?>" class="nav-tab2 <?php echo $active_tab == 'addexam' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Exam', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{
			if($user_access['add']=='1')
			{ ?>
			<a href="?dashboard=user&page=exam&tab=addexam" class="nav-tab2  <?php echo $active_tab == 'addexam' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="fa fa-plus-circle"></span>'.__(' Add Exam', 'school-mgt'); ?></a>  
        <?php 
			}
		}?>
		</li>
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')
		{?>
		<li class="<?php echo $active_tab == 'exam_time_table' ? 'active' : ''; ?>">
			<a href="?dashboard=user&page=exam&tab=exam_time_table&action=view&exam_id=<?php echo $_REQUEST['exam_id'];?>"  class="nav-tab2"><strong>
				<i class="fa fa-align-justify"> </i> <?php _e('Exam Time Table', 'school-mgt'); ?></strong>
			</a>
		</li>
		<?php
		}
		?>
	</ul>
    <!-- Tab panes -->
	<?php
	if($active_tab == 'examlist')
	{
		$user_id=get_current_user_id();
		//------- EXAM DATA FOR STUDENT ---------//
		if($school_obj->role == 'student')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
				$class_id 	= 	get_user_meta(get_current_user_id(),'class_name',true);			
				$section_id 	= 	get_user_meta(get_current_user_id(),'class_section',true);	
				if(isset($class_id) && $section_id == '')
				{
					$retrieve_class	= 	get_all_exam_by_class_id($class_id);
				}
				else
				{
					$retrieve_class	= get_all_exam_by_class_id_and_section_id_array($class_id,$section_id);
				}
			}
			else
			{
				$retrieve_class = get_all_data($tablename);			
			}
		}
		//------- EXAM DATA FOR TEACHER ---------//
		elseif($school_obj->role == 'teacher')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
				$class_id 	= 	get_user_meta(get_current_user_id(),'class_name',true);	
				$retrieve_class	= $obj_exam->get_all_exam_by_class_id_created_by($class_id,$user_id);
			}
			else
			{
				$retrieve_class = get_all_data($tablename);			
			}
		}
		//------- EXAM DATA FOR PARENT ---------//
		elseif($school_obj->role == 'parent')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
				$user_meta =get_user_meta($user_id, 'child', true);
				
				foreach($user_meta as $c_id)
				{
					$classdata[]=get_user_meta($c_id,'class_name',true);
					$section_id[] = get_user_meta($c_id,'class_section',true);	
					if(!empty($classdata) && $section_id =='')
					{
						
						$retrieve_class	= get_all_exam_by_class_id_array($classdata);
					}
					else
					{
						
						$retrieve_class	= get_all_exam_by_class_id_and_section_id_array_parent($classdata,$section_id);
					}					
				}
			}
			else
			{
				$retrieve_class = get_all_data($tablename);			
			}
		}
		//------- EXAM DATA FOR SUPPORT STAFF ---------//
		else
		{ 
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
				$retrieve_class	= $obj_exam->get_all_exam_created_by($user_id);
			}
			else
			{
				$retrieve_class = get_all_data($tablename);	
			}
		} 
		?>
		<div class="panel-body">
			<div class="table-responsive">
				<table id="examt_list" class="display dataTable exam_datatable" cellspacing="0" width="100%">
					 <thead>
						<tr>                
							<th><?php _e('Exam Title','school-mgt');?></th>
							<th><?php _e('Class Name','school-mgt');?></th>
							<th><?php _e('Section Name','school-mgt');?></th>
							<th><?php _e('Term Name','school-mgt');?></th>
							<th><?php _e('Exam Start Date','school-mgt');?></th>
							<th><?php _e('Exam End Date','school-mgt');?></th>
							<th><?php _e('Exam Comment','school-mgt');?></th>
							<th><?php _e('Action','school-mgt');?></th>             
						</tr>
					</thead>
		 
					<tfoot>
						<tr>
							<th><?php _e('Exam Title','school-mgt');?></th>
							<th><?php _e('Class Name','school-mgt');?></th>
							<th><?php _e('Section Name','school-mgt');?></th>
							<th><?php _e('Term Name','school-mgt');?></th>
							<th><?php _e('Exam Start Date','school-mgt');?></th>
							<th><?php _e('Exam End Date','school-mgt');?></th>
							<th><?php _e('Exam Comment','school-mgt');?></th>
							<th><?php _e('Action','school-mgt');?></th>           
							
						</tr>
					</tfoot>
		 
					<tbody>
					  <?php 
						foreach ($retrieve_class as $retrieved_data)
						{ 			
					 ?>
					   <tr>
							<td><?php echo $retrieved_data->exam_name;?></td>
							<td><?php $cid=$retrieved_data->class_id;
							if(!empty($cid))
							{
								echo  $clasname=get_class_name($cid);
							}
							else
							{
								echo  "";
							}
							?></td>
							 <td><?php if($retrieved_data->section_id!=0){ echo smgt_get_section_name($retrieved_data->section_id); }else { _e('No Section','school-mgt');}?></td>
						   <td><?php 
							if(!empty($retrieved_data->exam_term))
							{
								echo get_the_title($retrieved_data->exam_term);
							}
							else
							{
								echo  "";
							}
							?></td>
							<td><?php echo smgt_getdate_in_input_box($retrieved_data->exam_start_date);?></td>
							<td><?php echo smgt_getdate_in_input_box($retrieved_data->exam_end_date);?></td>
							<td><?php echo $retrieved_data->exam_comment;?></td>              
							<td>
							   <a href="?dashboard=user&page=exam&tab=exam_time_table&action=view&exam_id=<?php echo $retrieved_data->exam_id;?>" class="btn btn-primary"><?php _e('View','school-mgt');?></a>
							   <?php
								if($user_access['edit']=='1')
								{
								?>
									<a href="?dashboard=user&page=exam&tab=addexam&action=edit&exam_id=<?php echo $retrieved_data->exam_id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
									<?php
								}
								if($user_access['delete']=='1')
								{
								?>
									<a href="?dashboard=user&page=exam&tab=examlist&action=delete&exam_id=<?php echo $retrieved_data->exam_id;?>" class="btn btn-danger" onclick="return confirm('<?php _e('will be lost all data for this exam. Are you sure you want to delete this record?','school-mgt');?>');"><?php _e('Delete','school-mgt');?></a>
								<?php  
								}
								$doc_data=json_decode($retrieved_data->exam_syllabus);
								if(!empty($doc_data[0]->value))
								{
								?>
									<a download href="<?php print content_url().'/uploads/school_assets/'.$doc_data[0]->value; ?>"  class="status_read btn btn-default" record_id="<?php echo $retrieved_data->exam_id;?>"><i class="fa fa-download"></i><?php esc_html_e(' Download Syllabus', 'school-mgt');?></a>
									<a target="blank" href="<?php print content_url().'/uploads/school_assets/'.$doc_data[0]->value; ?>" class="status_read btn btn-default" record_id="<?php echo $retrieved_data->exam_id;?>"><i class="fa fa-eye"></i><?php esc_html_e(' View Syllabus', 'school-mgt');?></a>
							   <?php
								}
								?>
							</td>
						</tr>
						<?php 
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php
	}
	if($active_tab == 'addexam')
	{ ?>
		<!--Group POP up code -->
		<div class="popup-bg">
			<div class="overlay-content admission_popup">
				<div class="modal-content">
					<div class="category_list">
					</div>     
				</div>
			</div>     
		</div>
		<script type="text/javascript">
		$(document).ready(function()
		 {
			 $('#exam_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
			 $("#exam_start_date").datepicker({
				dateFormat: "yy-mm-dd",
				minDate:0,
				onSelect: function (selected) {
					var dt = new Date(selected);
					dt.setDate(dt.getDate() + 0);
					$("#exam_end_date").datepicker("option", "minDate", dt);
				}
			});
			$("#exam_end_date").datepicker({
				minDate:0,
			   dateFormat: "yy-mm-dd",
				onSelect: function (selected) {
					var dt = new Date(selected);
					dt.setDate(dt.getDate() + 0);
					$("#exam_start_date").datepicker("option", "maxDate", dt);
				}
			});
			jQuery("body").on("change", ".input-file[type=file]", function ()
			{ 
				var file = this.files[0]; 
				var file_id = jQuery(this).attr('id'); 
				var ext = $(this).val().split('.').pop().toLowerCase(); 
				//Extension Check 
				if($.inArray(ext, ['pdf']) == -1)
				{
					  alert('<?php esc_html_e("Only pdf formate are allowed.","school-mgt") ?>');
					$(this).replaceWith('<input type="file" name="exam_syllabus" class="form-control file_validation input-file">');
					return false; 
				} 
				 //File Size Check 
				 if (file.size > 20480000) 
				 {
					alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','school-mgt');?>");
					$(this).replaceWith('<input type="file" name="exam_syllabus" class="form-control file_validation input-file">'); 
					return false; 
				 }
			 });	
				 
		} );
		</script>
		<script type="text/javascript">
	//alert("hello");
	jQuery('.onlyletter_number_space_validation').keypress(function(e) 
	{     
		var regex = new RegExp("^[0-9a-zA-Z \b]+$");
		var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
		if (!regex.test(key)) 
		{
			event.preventDefault();
			return false;
		} 
   });  
	</script>
		<?php
			$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
			{
				$edit=1;
				$exam_data= get_exam_by_id($_REQUEST['exam_id']);
			}
		?>
		<div class="panel-body">	
			<form name="exam_form" action="" method="post" class="form-horizontal" enctype="multipart/form-data" id="exam_form">
				 <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<div class="form-group">
					<label class="col-sm-2 control-label " for="exam_name"><?php _e('Exam Name','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="exam_name" class="form-control validate[required,custom[popup_category_validation]]" maxlength="50" type="text" value="<?php if($edit){ echo $exam_data->exam_name;}?>"  placeholder="<?php esc_html_e('Enter Exam Name','school-mgt');?>"  name="exam_name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="class_id"><?php _e('Class Name','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<select name="class_id" class="form-control validate[required] width_100" id="class_list">
							<option value=""><?php echo _e( 'Select Class', 'school-mgt' ) ;?></option>
							<?php $classval='';
							if($edit){  
								$classval=$exam_data->class_id; 
								foreach(get_allclass() as $class)
								{ ?>
								<option value="<?php echo $class['class_id'];?>" <?php selected($class['class_id'],$classval);  ?>>
								<?php echo get_class_name($class['class_id']);?></option> 
							<?php }
							}else
							{
								foreach(get_allclass() as $classdata)
								{ ?>
								<option value="<?php echo $classdata['class_id'];?>" <?php selected($classdata['class_id'],$classval);  ?>><?php echo $classdata['class_name'];?></option> 
							<?php }
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="class_name"><?php _e('Section Name','school-mgt');?></label>
					<div class="col-sm-8">
						<?php if($edit){ $sectionval=$exam_data->section_id; }elseif(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
							<select name="class_section" class="form-control width_100" id="class_section">
								<option value=""><?php _e('Select Class Section','school-mgt');?></option>
								<?php
								if($edit){
									foreach(smgt_get_class_sections($exam_data->class_id) as $sectiondata)
									{  ?>
									 <option value="<?php echo $sectiondata->id;?>" <?php selected($sectionval,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
								<?php } 
								}?>
							</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="Exam Term"><?php _e('Exam Term','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-md-8 col-sm-8 col-xs-12">	
						<?php if($edit){ $sectionval1=$exam_data->exam_term; }elseif(isset($_POST['exam_term'])){$sectionval1=$_POST['exam_term'];}else{$sectionval1='';}?>
						<select class="form-control validate[required] term_category margin_top_10 width_100" name="exam_term">
							<option value=""><?php esc_html_e('Select Term','school-mgt');?></option>
							<?php 
							$activity_category=smgt_get_all_category('term_category');
							if(!empty($activity_category))
							{
								foreach ($activity_category as $retrive_data)
								{ 		 	
								?>
									<option value="<?php echo $retrive_data->ID;?>" <?php selected($retrive_data->ID,$sectionval1);  ?>><?php echo esc_attr($retrive_data->post_title); ?> </option>
								<?php }
							} 
							?> 
						</select>			
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<button id="addremove_cat" class="btn btn-info sibling_add_remove margin_top_10" model="term_category"><?php _e('Add','school-mgt');?></button>		
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label " for="Passing Marks"><?php _e('Passing Marks','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-3">
						<input id="passing_mark" class="form-control  validate[required,custom[onlyNumberSp],maxSize[5]] text-input" type="number" value="<?php if($edit){ echo $exam_data->passing_mark;}?>" placeholder="<?php esc_html_e('Enter Passing Marks','school-mgt');?>"  name="passing_mark">
					</div>
					<label class="col-sm-2 control-label " for="Total Marks"><?php _e('Total Marks','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-3">
						<input id="total_mark" class="form-control validate[required,custom[onlyNumberSp],maxSize[5]] text-input" type="number" value="<?php if($edit){ echo $exam_data->total_mark;}?>" placeholder="<?php esc_html_e('Enter Total Marks','school-mgt');?>"  name="total_mark">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="exam_start_date"><?php _e('Exam Start Date','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-3">
						<input id="exam_start_date" class="datepicker form-control validate[required] text-input" type="text" placeholder="<?php esc_html_e('Enter Exam Start Date','school-mgt');?>" name="exam_start_date" value="<?php if($edit){ echo date("Y-m-d",strtotime($exam_data->exam_start_date)); }?>" readonly>
					</div>
					<label class="col-sm-2 control-label" for="exam_end_date"><?php _e('Exam End Date','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-3">
						<input id="exam_end_date" class="datepicker form-control validate[required] text-input" type="text" placeholder="<?php esc_html_e('Enter Exam End Date','school-mgt');?>" name="exam_end_date" value="<?php if($edit){ echo date("Y-m-d",strtotime($exam_data->exam_end_date)); }?>" readonly>
					</div>
				</div>
				<?php wp_nonce_field( 'save_exam_admin_nonce' ); ?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="exam_comment"><?php _e('Exam Comment','school-mgt');?></label>
					<div class="col-sm-8">
					 <textarea name="exam_comment" class="form-control validate[custom[address_description_validation]]" placeholder="<?php esc_html_e('Enter Exam Comment','school-mgt');?>" maxlength="150" id="exam_comment"><?php if($edit){ echo $exam_data->exam_comment;}?></textarea>
						
					</div>
				</div>
				<?php
				if($edit)
					{ 
						$doc_data=json_decode($exam_data->exam_syllabus);
					?>
						<div class="form-group">	
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Exam Syllabu"><?php _e('Exam Syllabus','school-mgt');?></label>		
								<div class="col-md-2 col-sm-2 col-xs-12 margin_bottom_5">
									<input type="text"  name="document_name" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','school-mgt');?>" value="<?php if(!empty($doc_data[0]->title)) { echo esc_attr($doc_data[0]->title);}elseif(isset($_POST['document_name'])) echo esc_attr($_POST['document_name']);?>"  class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-12">		
									<input type="file" name="exam_syllabus" class="form-control file_validation input-file"/>						
									<input type="hidden" name="old_hidden_exam_syllabus" value="<?php if(!empty($doc_data[0]->value)){ echo esc_attr($doc_data[0]->value);}elseif(isset($_POST['exam_syllabus'])) echo esc_attr($_POST['exam_syllabus']);?>">					
								</div>
								<?php
								if(!empty($doc_data[0]->value))
								{
								?>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<a target="blank"  class="status_read btn btn-default" href="<?php print content_url().'/uploads/document_upload/'.$doc_data[0]->value; ?>" record_id="<?php echo $exam_data->exam_id;?>">
									<i class="fa fa-download"></i><?php echo $doc_data[0]->value;?></a>
								</div>
									<?php
								}
							?>
							</div>
					<?php 
					}
					else 
					{
					?>
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Exam Syllabu"><?php _e('Exam Syllabus','school-mgt');?></label>	
					<div class="col-md-4 col-sm-4 col-xs-12 margin_bottom_5">
						<input type="text"  name="document_name" id="title_value"  placeholder="<?php esc_html_e('Enter Documents Title','school-mgt');?>"  class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<input type="file" name="exam_syllabus" class="col-md-2 col-sm-2 col-xs-12 form-control file_validation input-file ">	
					</div>
				</div>
					<?php 
					}
					?>
				<div class="col-sm-offset-2 col-sm-8">        	
					<input type="submit" id="save_exam" value="<?php if($edit){ _e('Save Exam','school-mgt'); }else{ _e('Add Exam','school-mgt');}?>" name="save_exam" class="btn btn-success" />
				</div>        
			</form>
	<?php
	} 
    if($active_tab == 'exam_time_table')
	{
		if($_REQUEST['action']=='view')
		{
			$exam_data= get_exam_by_id($_REQUEST['exam_id']);
			$start_date=$exam_data->exam_start_date;
			$end_date=$exam_data->exam_end_date;
			$obj_exam=new smgt_exam;
			$exam_time_table=$obj_exam->get_exam_time_table_by_exam($_REQUEST['exam_id']);
		}
	?>
		<script>
	$(document).ready(function(){		
		$('#exam_timelist').DataTable({
			responsive: true,
			bPaginate: false,
			bFilter: false, 
			bInfo: false,
			language:<?php echo smgt_datatable_multi_language();?>
		});
		$('.width_200').DataTable({
			responsive: true,
			bPaginate: false,
			bFilter: false, 
			bInfo: false,
		});

	});
	</script>
	<div class="panel-body">
		<div class="form-group">
			<div class="col-md-12">
				<div class="row">
					<table class="table width_200" style="border: 1px solid #000000;text-align: center;margin-bottom: 0px;border-collapse: separate;">
						<thead>
							<tr>
								<th  style="border-top: medium none;border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;"><?php  _e('Exam','school-mgt');?></th>
								<th  style="border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;"><?php  _e('Class','school-mgt');?></th>							
								<th  style="border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;"><?php  _e('Section','school-mgt');?></th>							
								<th  style="border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;"><?php  _e('Term','school-mgt');?></th>							
								<th  style="border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;"><?php  _e('Start Date','school-mgt');?></th>							
								<th  style="background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;"><?php  _e('End Date','school-mgt');?></th>							
							</tr>
						</thead>
						<tfoot></tfoot>
						<tbody>							
							<tr>
								<td style="border-right: 1px solid #000000;"><?php echo $exam_data->exam_name;?></td>							
								<td style="border-right: 1px solid #000000;"><?php echo get_class_name($exam_data->class_id);?></td>
								<td style="border-right: 1px solid #000000;"><?php if($exam_data->section_id!=0){ echo smgt_get_section_name($exam_data->section_id); }else { _e('No Section','school-mgt');}?></td>
								<td style="border-right: 1px solid #000000;"><?php echo get_the_title($exam_data->exam_term);?></td>
								<td style="border-right: 1px solid #000000;"><?php echo smgt_getdate_in_input_box($start_date);?></td>
								<td style=""><?php echo smgt_getdate_in_input_box($end_date);?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>			
		</div>
		<div class="col-md-12 margin_top_40">
			<div class="row">
				<table id="exam_timelist" class="display" cellspacing="0" width="100%" class="table width_200" style="border: 1px solid #000000;text-align: center;margin-bottom: 0px;border-collapse: separate;">
					<thead>
						<tr>    
							<th style="border-top: medium none;border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;"><?php _e('Subject Code','school-mgt');?></th>
							<th style="border-top: medium none;border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;"><?php _e('Subject Name','school-mgt');?></th>
							<th style="border-top: medium none;border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;"><?php _e('Exam Date','school-mgt');?></th>
							<th style="border-top: medium none;border-right: 1px solid #000000;background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;"><?php _e('Exam Start Time','school-mgt');?></th>
							<th style="background-color: #e5e5e5;border-bottom: 1px solid #000000;text-align: center;"> <?php _e('Exam End Time','school-mgt');?></th>
						</tr>
					</thead>
					<tbody>
					   <?php
						if(!empty($exam_time_table))
						{
							foreach($exam_time_table  as $retrieved_data)
							{
							?>
								<tr>
									<td style="border-right: 1px solid #000000;"><?php echo get_single_subject_code($retrieved_data->subject_id); ?> </td>
									<td style="border-right: 1px solid #000000;"><?php echo get_single_subject_name($retrieved_data->subject_id);  ?> </td>
									<td style="border-right: 1px solid #000000;"><?php echo smgt_getdate_in_input_box($retrieved_data->exam_date); ?> </td>
									<?php
									$start_time_data = explode(":", $retrieved_data->start_time);
									$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
									$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
									$start_am_pm=$start_time_data[2];
									$start_time=$start_hour.':'.$start_min.' '.$start_am_pm;
									
									$end_time_data = explode(":", $retrieved_data->end_time);
									$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
									$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
									$end_am_pm=$end_time_data[2];
									$end_time=$end_hour.':'.$end_min.' '.$end_am_pm;
									?>
									<td style="border-right: 1px solid #000000;"><?php echo $start_time;  ?> </td>
									<td><?php echo $end_time; ?> </td>
								</tr>
							<?php 
							}
						}
					   ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	}
	?>
 </div> 
<?php ?>