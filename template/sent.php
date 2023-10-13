<?php 
if($school_obj->role == 'student')
{
	$subjects = $school_obj->subject;	
}
else
$subjects = get_all_data('subject');
?>
 <ul class="nav nav-tabs" role="tablist">
      <li class="active">
          <a href="#examlist" role="tab" data-toggle="tab">
              <icon class="fa fa-home"></icon> <?php _e('Subject','school-mgt');?>
          </a>
      </li>
      <?php if($school_obj->role == 'teacher'){?>
      <li><a href="#add_subject" role="tab" data-toggle="tab">
          <i class="fa fa-user"></i><?php _e('Add Subject','school-mgt');?>
          </a>
      </li>
     <?php }?>
    </ul>
    
    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane fade active in" id="examlist">
          <h2><?php echo esc_html( __( 'Subject list', 'school-mgt' ) );?></h2>       
        <table id="subject_list" class="table table-bordered display dataTable" cellspacing="0" width="100%">
        	<thead>
				<tr>                
					 <th><?php _e('Class','school-mgt')?></th>
					<th><?php _e('Subject Name','school-mgt')?></th>
					<th><?php _e('Teacher Name','school-mgt')?></th>                               
				</tr>
			</thead>
 
			<tfoot>
				<tr>
				   <th><?php _e('Class','school-mgt')?></th>
					<th><?php _e('Subject Name','school-mgt')?></th>
					<th><?php _e('Teacher Name','school-mgt')?></th>        
				</tr>
			</tfoot>
 
        <tbody>
          <?php 
          if($school_obj->role !='parent')
          {
		 	foreach ($subjects as $retrieved_data){ 
			
		 ?>
            <tr>
                <td><?php echo get_class_name($retrieved_data->class_id);?></td>
                <td><?php echo $retrieved_data->sub_name;?></td>
                <td><?php echo get_user_name_byid($retrieved_data->teacher_id);?></td>              
               
            </tr> 
            <?php } 
          }
          else 
          {
          	$chid_array =$school_obj->child_list;
          	foreach ($chid_array as $child_id)
          	{
          		$class_info = $school_obj->get_user_class_id($child_id);
          		$subjects = $school_obj->subject_list($class_info->class_id);
          		//$subjects = $school_obj->;
          	foreach ($subjects as $retrieved_data){
          	?>
          	    <tr>
          	        <td><?php echo get_class_name($retrieved_data->class_id);?></td>
          	        <td><?php echo $retrieved_data->sub_name;?></td>
          	        <td><?php echo get_user_name_byid($retrieved_data->teacher_id);?></td>              
          	    </tr> 
          	 <?php } }
          }
        ?>     
        </tbody>        
        </table>          
      </div>
      <div class="tab-pane fade" id="add_subject">
        <?php
		if(isset($_POST['subject']))
		{
			if(isset($_POST['subject_syllabus']))
			{
				$sullabus='syllabus.pdf';
			}
			else
			{
				$sullabus=$_POST['old_syllabus'];
			}
			$subjects=array('sub_name'=>MJ_smgt_address_description_validation($_POST['subject_name']),
				'class_id'=>MJ_smgt_onlyNumberSp_validation($_POST['subject_class']),
				'teacher_id'=>$_POST['subject_teacher'],
				'edition'=>MJ_smgt_address_description_validation($_POST['subject_edition']),
				'author_name'=>MJ_smgt_onlyLetter_specialcharacter_validation($_POST['subject_author']),	
				'syllabus'=>$sullabus
			);
			$tablename="subject";
			if($_REQUEST['action']=='edit')
			{
				$subid=array('subid'=>$_REQUEST['subject_id']);
				update_record($tablename,$subjects,$subid);
			}
			else
			{
				insert_record($tablename,$subjects);
			}				
		}
		?>
		<h2>
			<?php
			$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
			{	
				$edit=1;
				echo esc_html( __( 'Edit Subject', 'school-mgt') );
				$subject=get_subject($_REQUEST['subject_id']);
			}
			else
			{
				echo esc_html( __( 'Add New Subject', 'school-mgt') );
			}
			?>
		</h2>
		<form name="student_form" action="" method="post">
			 <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<table class="form-table">	
				<tr class="user-user-login-wrap">
					<th><label><?php _e('Subject Name','school-mgt');?> </label></th>
					<td>
						<input type="text" name="subject_name"  class="regular-text ,custom[address_description_validation]" maxlength="50" value="<?php if($edit){ echo $subject->sub_name;}?>"/> 
					</td>
				</tr>
				<tr class="user-user-login-wrap">
					<th><label><?php _e('Class','school-mgt');?>  </label></th>
					<td>
						<?php if($edit){ $classval=$subject->class_id; }else{$classval='';}?>
							<select name="subject_class">
								<option value=""><?php _e('Select Class','school-mgt');?></option>
								<?php
									foreach(get_allclass() as $classdata)
									{ ?>
									 <option value="<?php echo $classdata['class_id'];?>" <?php selected($classval, $classdata['class_id']);  ?>><?php echo $classdata['class_name'];?></option>
								<?php }?>
							</select>
					</td>
				</tr>
				<tr class="user-user-login-wrap">
					<th ><label><?php _e('Teacher','school-mgt');?>  </label></th>
								<td>
									<?php if($edit){ $teachval=$subject->teacher_id; }else{$teachval='';}?>
									<select name="subject_teacher">
										<option value=""><?php _e('Select Teacher','school-mgt');?> </option>
									   <?php 
											foreach(get_usersdata('teacher') as $teacherdata)
											{ ?>
											 <option value="<?php echo $teacherdata->ID;?>" <?php selected($teachval, $teacherdata->ID);  ?>><?php echo $teacherdata->display_name;?></option>
										<?php }?>
									</select>
								</td>
							</tr>
							<tr class="user-user-login-wrap">
								<th >
									<label><?php _e('Edition','school-mgt');?>  </label></th>
								<td>
									 <input type="text" name="subject_edition"  class="regular-text validate[custom[address_description_validation]]"  maxlength="50" value="<?php if($edit){ echo $subject->edition;}?>"/> 
								</td>
							</tr>
							<tr class="user-user-login-wrap">
								<th >
									<label><?php _e('Author Name','school-mgt');?>  </label></th>
								<td>
									 <input type="text" name="subject_author"  class="regular-text validate[custom[onlyLetter_specialcharacter]]" maxlength="100" value="<?php if($edit){ echo $subject->author_name;}?>"/> 
								</td>
							</tr>
							 <tr class="user-user-login-wrap">
								<th >
									<label><?php _e('Syllabus','school-mgt');?>  </label></th>
								<td>
									 <input type="file" name="subject_syllabus" /> 
									 <input type="hidden" value="<?php if($edit){ $syllabusval=$subject->syllabus; }else{$syllabusval='';}?>" name="old_syllabus" />
								</td>
							</tr>
							<tr>
								<th ></th>
								<td><input type="submit" value="<?php if($edit){ _e('Save Subject','school-mgt'); }else{ _e('Add Subject','school-mgt');}?>" name="subject"/></td>
							</tr>						
					</table> 
					</form>
				</div>     
    </div>