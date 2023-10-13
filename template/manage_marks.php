<?php 
$school_obj = new School_Management ( get_current_user_id () );
if($school_obj->role == 'parent')
{
	echo "403 : Access Denied.";
	die;
}
$user_access=smgt_get_userrole_wise_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		MJ_smgt_access_right_page_not_access_message();
		die;
	}
}
$obj_marks = new Marks_Manage();
$exam_id = 0;
$class_id =0;
$subject_id = 0;
$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'result';
if(isset($_REQUEST['add_mark']))
{
	$user_id = $_REQUEST['add_mark'];
	$marks = $_REQUEST['marks_'.$user_id];
	
	$comment = $_REQUEST['comment_'.$user_id];
	$current_date = date("Y-m-d H:i:s");

	$grade_id = $obj_marks->get_grade_id($marks);
	if(!$grade_id)
	{
		$grade_id = 0;
	}
	$mark_data = array('exam_id'=>$_REQUEST['exam_id'],
			'class_id'=>$_REQUEST['class_id'],
			'subject_id'=>$_REQUEST['subject_id'],
			'marks'=>$marks,
			
			'grade_id'=>$grade_id,
			'student_id'=>$user_id,
			'marks_comment'=>$comment,
			'created_date'=>$current_date,
			'created_by'=>get_current_user_id());
			
	if(isset($_REQUEST['save_'.$user_id]))
	{
		$obj_marks->save_marks($mark_data);
		
	}
	else
	{
		
		$mark_id =$_REQUEST['mark_id_'.$user_id];
		$mark_id=array('mark_id'=>$mark_id);
		$result=$obj_marks->update_marks($mark_data,$mark_id);
		if($result)
		{
			?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<p><?php _e('Mark Successfully Updated!','school-mgt');?>
			</div>
			<?php 
		}

	}

}
if(isset($_REQUEST['save_all_marks']))
{
	$exam_id = $_REQUEST['exam_id'];
	$class_id = $_REQUEST['class_id'];
	$subject_id = $_REQUEST['subject_id'];
	
	$result=0;
	if(isset($_REQUEST['section_id']) && $_REQUEST['section_id'] != ""){
		$exlude_id = smgt_approve_student_list();
		$student = get_users(array('meta_key' => 'class_section', 'meta_value' =>$_REQUEST['section_id'],
			'meta_query'=> array(array('key' => 'class_name','value' => $class_id,'compare' => '=')),'role'=>'student','exclude'=>$exlude_id));	
		}
		else
		{ 
			$exlude_id = smgt_approve_student_list();
			$student = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
		} 		
	//$exlude_id = smgt_approve_student_list();
	//$student = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
	foreach ( $student as $user ) {
		$mark_detail = $obj_marks->subject_makrs_detail_byuser($exam_id,$class_id,$subject_id,$user->ID);
		$button_text = "inser";
		$user_id = $user->ID;
		$marks = $_REQUEST['marks_'.$user_id];
		
		$comment = $_REQUEST['comment_'.$user_id];
		$current_date = date("Y-m-d H:i:s");
			
		$grade_id = $obj_marks->get_grade_id($marks);
			if(!$grade_id)
	{
		$grade_id = 0;
	}
		$mark_data = array('exam_id'=>$_REQUEST['exam_id'],
				'class_id'=>$_REQUEST['class_id'],
				'section_id'=>$_REQUEST['section_id'],
				'subject_id'=>$_REQUEST['subject_id'],
				'marks'=>$marks,
				
				'grade_id'=>$grade_id,
				'student_id'=>$user_id,
				'marks_comment'=>$comment,
				'created_date'=>$current_date,
				'created_by'=>get_current_user_id());
		if($mark_detail)
		{
			$mark_id =$_REQUEST['mark_id_'.$user_id];
			$mark_id=array('mark_id'=>$mark_id);
			$result=$obj_marks->update_marks($mark_data,$mark_id);
				
		}
		else
		{
				
			$obj_marks->save_marks($mark_data);
				
		}

	}
	if($result)
				{?>
					<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<p><?php _e('Mark Successfully Updated!','school-mgt');?>
					</div>
		  <?php }
	
}
if(isset($_POST['export_marks']))
{
	$exam_id = $_REQUEST['exam_id'];
	$class_id = $_REQUEST['class_id'];
	$subject_list = $obj_marks->student_subject($class_id);
	if(isset($_REQUEST['section_id']) && $_REQUEST['section_id'] != "")
	{
		$exlude_id = smgt_approve_student_list();
		$student = get_users(array('meta_key' => 'class_section', 'meta_value' =>$_REQUEST['section_id'],
						 'meta_query'=> array(array('key' => 'class_name','value' => $class_id,'compare' => '=')),'role'=>'student','exclude'=>$exlude_id));	
		}
		else
		{ 
			$exlude_id = smgt_approve_student_list();
			$student = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
		} 		
	
	
	$header = array();
	$marks = array();
	$header[] = 'Roll No';
	$header[] = 'Student Name';
	$header[] = 'Class';
	$subject_array = array();
	if(!empty($subject_list))
	{
		foreach($subject_list as $result)
		{
			$header[]=$result->sub_name;
			$subject_array[] = $result->subid;
		}
	}
	$header[]= 'Total';
	$filename='Reports/export_marks.csv';
	$fh = fopen(SMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
	fputcsv($fh, $header);
	foreach($student as $user)
	{
		$row = array();
		$row[] =  get_user_meta($user->ID, 'roll_id',true);
		$row[] = get_user_name_byid($user->ID);
		$row[] = get_class_name($class_id);
		$total = 0;
		if(!empty($subject_array))
		{
			$total = 0;
			foreach($subject_array as $sub_id)
			{
				
				$marks = $obj_marks->export_get_subject_mark($exam_id,$class_id,$user->ID,$sub_id);
				if($marks)
				{
					$row[] =  $marks;
					$total += $marks;
				}
				else	
					$row[] = 0;
			}
			$row[] = $total ;
		}
		
		fputcsv($fh, $row);
		
	}
	fclose($fh);
	
		//download csv file.
		ob_clean();
		$file=SMS_PLUGIN_DIR.'/admin/Reports/export_marks.csv';//file location
		
		$mime = 'text/plain';
		header('Content-Type:application/force-download');
		header('Pragma: public');       // required
		header('Expires: 0');           // no cache
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
		header('Cache-Control: private',false);
		header('Content-Type: '.$mime);
		header('Content-Disposition: attachment; filename="'.basename($file).'"');
		header('Content-Transfer-Encoding: binary');
		//header('Content-Length: '.filesize($file_name));      // provide file size
		header('Connection: close');
		readfile($file);		
	exit;	
}
?>
	<?php
$active_tab = isset($_GET['tab'])?$_GET['tab']:'result';
if(isset($_REQUEST['exam_id']))
	$exam_id =$_REQUEST['exam_id'];

if(isset($_REQUEST['class_id']))
	$class_id =$_REQUEST['class_id'];

if(isset($_REQUEST['subject_id']))
	$subject_id =$_REQUEST['subject_id'];

	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{		
		case '4':
			$message_string = __('Marks Added Successfully','school-mgt');
			break;		
	}
	
	if($message)
	{ ?>
		<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php echo $message_string;?>
		</div>
<?php } 
	?>


<script>
$(document).ready(function() {
    $('#attendence_list').DataTable({
        responsive: true
    });
});

$(document).ready(function() {
	//alert("hello");
	 $('#Add_marks_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	 $('#marks_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
} );
</script>
<div class="panel-body panel-white">  	
	<ul class="nav nav-tabs panel_tabs" role="tablist">
		  <li class=" <?php echo $active_tab == 'result' ? 'active' : ''; ?>">
			 <a href="?dashboard=user&page=manage_marks&tab=result" class="nav-tab2"> <strong>
			 <i class="fa fa-pencil-square-o"> </i> <?php _e('Manage Marks', 'school-mgt'); ?></strong></a>
		  </li>
		   <li class="<?php echo $active_tab == 'export_marks' ? 'active' : ''; ?>">
			 <a href="?dashboard=user&page=manage_marks&tab=export_marks" class="nav-tab2"> <strong>
			 <i class="fa fa-upload"> </i> <?php _e('Export Marks', 'school-mgt'); ?></strong></a>
		  </li>
		  <li class="<?php echo $active_tab == 'multiple_subject_marks' ? 'active' : ''; ?>">
			 <a href="?dashboard=user&page=manage_marks&tab=multiple_subject_marks" class="nav-tab2 margin_bottom"> <strong>
			 <i class="fa fa-tasks"> </i> <?php _e('Add Multiple Subject Marks', 'school-mgt'); ?></strong></a>
		  </li>
	  
	</ul>	
	
    <?php
	$tablename="marks";
	if($active_tab == 'result')
	{
	?>	 
	<div class="tab-content">
	<div class="panel-body">
    <form method="post" id="Add_marks_form">  
    
	<?php  
		/*	$role = $school_obj->role;
			$enable=get_option('smgt_teacher_manage_allsubjects_marks');
			
				if($role =='teacher' && $enable=='no')
				{	
					$teacher_id=get_current_user_id();
					$allsubjects=get_teachers_subjects($teacher_id);
					?>
					<div class="form-group col-md-3">
					<label for="subject_id"><?php _e('Select Subject','school-mgt');?></label>
					<select name="subject_id"  class="form-control validate[required]" style="line-height: 28px;">
					<option value=" "><?php _e('Select Subject','school-mgt');?></option>
					<?php 
					if(isset($_POST['subject_id']))
							$subject_id=$_POST['subject_id'];
						else
							$subject_id=0;
						 if(!empty($allsubjects))
						     {
						     	foreach ($allsubjects as $ubject_data)
						     	{ ?>
						     			<option value="<?php echo $ubject_data->subid ;?>" <?php selected($subject_id, $ubject_data->subid);  ?>><?php echo $ubject_data->sub_name;?></option>
						    <?php }
						    }  ?>
                </select>
				
			</div>
			<?php }
				else
				{  */?>
		<div class="form-group col-md-2">
			<label for="class_id"><?php _e('Select Class','school-mgt');?><span class="require-field">*</span></label>
			<select name="class_id"  id="class_list" class="form-control class_id_exam validate[required]" style="line-height: 28px">
                	<option value=" "><?php _e('Select Class','school-mgt');?></option>
                    <?php foreach(get_allclass() as $classdata)
					  {  ?>
					   <option  value="<?php echo $classdata['class_id'];?>" <?php selected($classdata['class_id'],$class_id)?>><?php echo $classdata['class_name'];?></option>
				 <?php }?>
           </select>
    </div>
	<div class="form-group col-md-2">
			<label for="class_id"><?php _e('Select Section','school-mgt');?></label>			
			<?php 
			$class_section="";
			if(isset($_REQUEST['class_section'])){ $class_section=$_REQUEST['class_section']; }elseif(isset($_REQUEST['section_id'])){ $class_section=$_REQUEST['section_id']; } ?>
					<select name="class_section" class="form-control section_id_exam" id="class_section">
                        	<!-- <option value=""><?php _e('Select Section','school-mgt');?></option> -->
						<?php if(isset($_REQUEST['class_sectiona']))
						{
								$class_section=$_REQUEST['class_section']; 
								foreach(smgt_get_class_sections($_REQUEST['class_id']) as $sectiondata)
								{  ?>
								 <option value="<?php echo $sectiondata->id;?>" <?php selected($class_section,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
							<?php } 
						}	
						else 
						{ ?>
					<option value=""><?php _e('Select Section','school-mgt');?></option>
					<?php
					} ?>
                    </select>
	</div>
	<div class="form-group col-md-2">
    	<label for="exam_id"><?php _e('Select Exam','school-mgt');?><span class="require-field">*</span></label>
			<select name="exam_id" class="form-control validate[required] exam_list" style="line-height: 28px">
				<?php
				if(isset($_POST['exam_ida']))
				{
					$exam_data=get_all_exam_by_class_id_all($_POST['class_id']);
					if(!empty($exam_data))
					{
						foreach ($exam_data as $retrieved_data)
						{
						?>
							<option value="<?php echo $retrieved_data->exam_id;?>" <?php selected($_POST['exam_id'], $retrieved_data->exam_id);  ?>><?php echo $retrieved_data->exam_name;?></option>
						<?php 
						}
					}
					?>
				 <?php  
				}
				else 
				{?>
					<option value=""><?php _e('Select Exam','school-mgt');?></option>
					<?php
				}
				?>
            </select>
    </div>
    <div class="form-group col-md-3">
    	<label for="subject_id"><?php _e('Select Subject','school-mgt');?><span class="require-field">*</span></label>
		<select name="subject_id" id="subject_list" class="form-control validate[required]" style="line-height: 28px;">
			<?php
				if(isset($_POST['subject_ida']))
				{
					$subject=get_subject($_POST['subject_id']);
					$subject = smgt_get_subject_by_classid($_POST['class_id']);
					if(!empty($subject))
					{
						foreach ($subject as $ubject_data)
						{
							?>
							<option value="<?php echo $ubject_data->subid ;?>" <?php selected($_POST['subject_id'], $ubject_data->subid);  ?>><?php echo $ubject_data->sub_name;?></option>
						 	<?php 
						}
					}
					 ?>
					
		 <?php  }
				else 
				{?>
					<option value=""><?php _e('Select Subject','school-mgt');?></option>
			<?php
				}
			?>
		</select>
    </div>
	<?php
	if($user_access['add']=='1')
	{
	?>
    <div class="form-group col-md-3 button-possition">
    	<label for="subject_id">&nbsp;</label>
      	<input type="submit" value="<?php _e('Manage Marks','school-mgt');?>" name="manage_mark"  class="btn btn-success" id="manage_marks"/>
    </div>
   <?php
	}
   ?>
      </form>
	  </div>
      <div class="clearfix"> </div>
	  
     <?php 
	 if(isset($_REQUEST['manage_mark']) || isset($_REQUEST['add_mark']) || isset($_REQUEST['save_all_marks']) || isset($_REQUEST['upload_csv_file']))
	 {
		if($role =='teacher')
			$class_id=get_subject_class($_REQUEST['subject_id']);
		else
		 $class_id =$_REQUEST['class_id'];
		
		$subject_id=$_REQUEST['subject_id'];
		$exam_id = $_REQUEST['exam_id'];
		$error_message = "";
		
		if($subject_id == " ")
			$error_message= __('Select Subject ID','school-mgt');
		if($class_id == " ")
			$error_message= __('Select Class ID','school-mgt');
		if($exam_id == " ")
			$error_message= __('Select Exam ID','school-mgt');
		if($error_message != "")
		{
			echo $error_message;
			exit;
		}	
		//$exclude_id = smgt_approve_student_list();
		//$student = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exclude_id));
		
		if(isset($_REQUEST['class_section']) && $_REQUEST['class_section'] != ""){
		$subject_list = $obj_marks->student_subject($class_id,$_REQUEST['class_section']);
		$exlude_id = smgt_approve_student_list();
		$student = get_users(array('meta_key' => 'class_section', 'meta_value' =>$_REQUEST['class_section'],
						 'meta_query'=> array(array('key' => 'class_name','value' => $class_id,'compare' => '=')),'role'=>'student','exclude'=>$exlude_id));	
		}
		else
		{ 
			$subject_list = $obj_marks->student_subject($class_id);
			$exlude_id = smgt_approve_student_list();
			$student = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
		} 
	?>
	
	  <div class="panel-body clearfix">
    <form method="post" class="form-inline" id="marks_form" enctype="multipart/form-data">  
      <input type="hidden" name="exam_id" value="<?php echo $exam_id;?>" />
      <input type="hidden" name="subject_id" value="<?php echo $subject_id;?>" />
      <input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
      <input type="hidden" name="section_id" value="<?php echo $_REQUEST['class_section'];?>" />
      <input type="hidden" name="class_section" value="<?php echo $_REQUEST['class_section'];?>" />
     
     
    <label for="file"><?php _e('Select CSV file','school-mgt')?>:  </label>   <input type="file" name="csv_file" id="csv_file" style="display: inline;" />
      <input type="submit" name="upload_csv_file" value="<?php _e('Fill data from CSV File','school-mgt');?>" class="btn btn-info btn_top" /> 
	   <?php _e('CSV file Must have headers as follows','school-mgt');?>: roll_no, name, marks, comment
      <br /><p></p>
	<div class="table-responsive">
		<table class="table col-md-12">
			<tr>
				<th><?php _e('Roll No.','school-mgt');?></th>
				<th><?php _e('Name','school-mgt');?></th>
				<th><?php _e('Mark Obtained(out of 100)','school-mgt');?></th>
			  
				<th><?php _e('Comment','school-mgt');?></th>
				
				<th>&nbsp;</th>
			</tr>
			
		<?php

			if(isset($_REQUEST['upload_csv_file'])){ 
			
				if(isset($_FILES['csv_file'])){
					$errors= array();
					$file_name = $_FILES['csv_file']['name'];
					$file_size =$_FILES['csv_file']['size'];
					$file_tmp =$_FILES['csv_file']['tmp_name'];
					$file_type=$_FILES['csv_file']['type'];   
					//$file_ext=strtolower(end(explode('.',$_FILES['csv_file']['name'])));
					$value = explode(".", $_FILES['csv_file']['name']);
					$file_ext = strtolower(array_pop($value));
					$extensions = array("csv"); 
					$upload_dir = wp_upload_dir();
					if(in_array($file_ext,$extensions )=== false){		
						$err=__('this file not allowed, please choose a CSV file.','school-mgt');
						$errors[]=$err;
					}
					if($file_size > 2097152){
						$errors[]='File size limit 2 MB';
					}				
					if(empty($errors)==true){

						$rows = array_map('str_getcsv', file($file_tmp));
						$header = array_map('strtolower',array_shift($rows));
						$csv = array();
						foreach ($rows as $row) {
							$csv[] = array_combine($header, $row);
						}
					}else{
						foreach($errors as &$error) echo $error;
					}
				}
			}
		
			if(!function_exists("array_column")){
				function array_column($array,$column_name){
					return array_map(function($element) use($column_name){return $element[$column_name];}, $array);
				}
			}
			$i=0;
			foreach ( $student as $user ) {
				$mark_detail = $obj_marks->subject_makrs_detail_byuser($exam_id,$class_id,$subject_id,$user->ID);	
				$button_text = __('Add Mark','school-mgt');		
				if(isset($csv)){
					
					$key = array_search($user->roll_id, array_column($csv, 'roll_no'));
				}
				
				if($mark_detail)
				{
					$mark_id=$mark_detail->mark_id;
					$marks=$mark_detail->marks;
					
					$marks_comment=$mark_detail->marks_comment;
					$button_text = __('Update','school-mgt');
					$action = "edit";
				}
				else
				{
					$marks=0;
					$attendance=0;
					$marks_comment="";
					$action = "save";
					$mark_id="0";
				}
				
			
				echo '<tr>';
				echo '<td><span '.(isset($csv) && !(isset($key))? 'style="color:red;">': '>' ).$user->roll_id. '</span></td>';
				echo '<td><span>' .$user->first_name.' '.$user->last_name. '</span></td>';
				echo '<td>';
				echo '<input type="text" name="marks_'.$user->ID.'" value="'.(isset($csv)&& !(isset($key))? $csv[$key]['marks'] : $marks).'" class="form-control validate[required,custom[onlyNumberSp],min[0],max[100]] text-input">';
				echo '</td>';
				
				echo '<td>';
				echo '<input type="text" maxlength="50" name="comment_'.$user->ID.'" value="'.(isset($csv)&& !(isset($key))? $csv[$key]['comment'] : $marks_comment).'" class="form-control">';
				echo '</td>';
				echo '<td>';
				echo '<input type="hidden" name="'.$action.'_'.$user->ID.'" value="'.$marks_comment.'" class="form-control">';
				echo '<input type="hidden" name="mark_id_'.$user->ID.'" value="'.$mark_id.'">';
				echo '<button type="submit" name="add_mark" value="'.$user->ID.'" class="btn btn-success">'.$button_text.'</button>';			
				echo '</td>';
				echo '</tr>';
			}
		?>
		</table>
	</div>
    </div>
	<?php	
	$school_obj = new School_Management ( get_current_user_id () );
	if($school_obj->role == 'teacher' || $school_obj->role == 'supportstaff')
	{
		if($user_access['edit'] == '1')
		{
			$access = 1;
		}
		else
		{
			$access = 0;
		}
	}
	else
	{
		$access = 1;
	}		
	
	if($access == 1)
	{
		?>
		<div class="col-sm-12">
			<div class="pull-right">
				<input type="submit" class="btn btn-success" name="save_all_marks" value="<?php _e('Update All Marks','school-mgt')?>">
			</div>
	   </div>
		<?php
	}
	?>
    </form>
    </div>
    <?php
	 }
	}
	if($active_tab == 'export_marks')
	  {
		 require_once SMS_PLUGIN_DIR. '/admin/includes/mark/export_marks.php';
	  }
	
	 if($active_tab == 'multiple_subject_marks')
	  {
		 require_once SMS_PLUGIN_DIR. '/admin/includes/mark/add_multiple_subject_marks.php';
	  }
	 ?> 
	 </div>
	 </div>
<?php ?>	