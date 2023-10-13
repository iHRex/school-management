<script type="text/javascript">
$(document).ready(function() {
	$('#rout_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
} );
</script>
<div class="panel panel-white">
<?php 	
	$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		$edit=1;
		$route_data= get_route_by_id($_REQUEST['route_id']);
	}
?>
	<div class="panel-body">   
        <form name="route_form" action="" method="post" class="form-horizontal" id="rout_form">
        <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		
        <div class="form-group">
			<label class="col-sm-2 control-label" for="class_list"><?php _e('Class','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<?php if($edit){ $classval=$route_data->class_id; }elseif(isset($_POST['class_id'])){$classval=$_POST['class_id'];}else{$classval='';}?>
				 <select name="class_id"  id="class_list" class="form-control validate[required] max_width_100">
                	<option value=" "><?php _e('Select class Name','school-mgt');?></option>
                    <?php
					  foreach(get_allclass() as $classdata)
					  {  
					  ?>
					   <option  value="<?php echo $classdata['class_id'];?>" <?php   selected($classval, $classdata['class_id']);  ?>><?php echo $classdata['class_name'];?></option>
				 <?php }?>
                </select>
			</div>
		</div>
		<?php wp_nonce_field( 'save_root_admin_nonce' ); ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_name"><?php _e('Class Section','school-mgt');?></label>
			<div class="col-sm-8">
				<?php if($edit){ $sectionval=$route_data->section_name; }elseif(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
                    <select name="class_section" class="form-control max_width_100 section_id_exam" id="class_section">
                        <option value=""><?php _e('Select Class Section','school-mgt');?></option>
                        <?php
						if($edit){
							foreach(smgt_get_class_sections($route_data->class_id) as $sectiondata)
							{  ?>
								<option value="<?php echo $sectiondata->id;?>" <?php selected($sectionval,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
						<?php } 
						}?>
                    </select>
				</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="subject_list"><?php _e('Subject','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<?php if($edit){ $subject_id=$route_data->subject_id; }elseif(isset($_POST['subject_id'])){$subject_id=$_POST['subject_id'];}else{$subject_id='';}?>
				<select name="subject_id" id="subject_list" class="form-control validate[required] max_width_100">
                <?php
				if( $edit )
				{
				    $subject = smgt_get_subject_by_classid($route_data->class_id);
				    if(!empty($subject))
				    {
				    	foreach ($subject as $ubject_data)
				     	{
				     	?>
					     	<option value="<?php echo $ubject_data->subid ;?>" <?php selected($subject_id, $ubject_data->subid);  ?>><?php echo $ubject_data->sub_name;?></option>
				     	<?php 
						}
					}
				 }
				else 
				{
				?>
				 	<option value=""><?php _e('Select Subject','school-mgt');?></option>
				<?php
				}
				?>
                </select>
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="weekday"><?php _e('Day','school-mgt');?></label>
			<div class="col-sm-8">
			<?php if($edit){ $day_key=$route_data->weekday; }elseif(isset($_POST['weekday'])){$day_key=$_POST['weekday'];}else{$day_key='';}?>
				<select name="weekday" class="form-control validate[required] max_width_100" id="weekday">
                    <?php 
					foreach(sgmt_day_list() as $daykey => $dayname)
						echo '<option  value="'.$daykey.'" '.selected($day_key,$daykey).'>'.$dayname.'</option>';
					?>
                </select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="weekday"><?php _e('Start Time','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-2">
				<?php 
				if($edit)
				{
					$start_time_data = explode(":", $route_data->start_time);
					
				}
				?>
				<select name="start_time" class="form-control validate[required]">
				<?php 
				for($i =0 ; $i <= 12 ; $i++)
				{
				?>
					<option value="<?php echo $i;?>" <?php  if($edit) selected($start_time_data[0],$i);  ?>><?php echo $i;?></option>
				<?php
				}
				?>
				</select>
			</div>
			<div class="col-sm-2">
				 <select name="start_min" class="form-control validate[required] margin_top_10_res">
                         <?php 
						 	for($i =0 ; $i <= 59 ; $i++)
							{
							?>
							<option value="<?php echo $i;?>" <?php  if($edit) selected($start_time_data[1],$i);  ?>><?php echo $i;?></option>
							<?php
							}
						 ?>
                         </select>
			</div>
			<div class="col-sm-2">
				 <select name="start_ampm" class="form-control validate[required] margin_top_10_res">
                         	<option value="am" <?php  if($edit) if(isset($start_time_data[2])) selected($start_time_data[2],'am');  ?>><?php _e('A.M.','school-mgt');?></option>
                            <option value="pm" <?php  if($edit) if(isset($start_time_data[2])) selected($start_time_data[2],'pm');  ?>><?php _e('P.M.','school-mgt');?></option>
                </select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="weekday"><?php _e('End Time','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-2">
			<?php 
			if($edit)
			{
				$end_time_data = explode(":", $route_data->end_time);
			} ?>
				<select name="end_time" class="form-control validate[required]">
                   <?php 
					for($i =0 ; $i <= 12 ; $i++)
					{
					?>
						<option value="<?php echo $i;?>" <?php  if($edit) selected($end_time_data[0],$i);  ?>><?php echo $i;?></option>
					<?php
					}
					?>
                </select>
			</div>
			<div class="col-sm-2">
				<select name="end_min" class="form-control validate[required] margin_top_10_res">
                <?php 
					for($i =0 ; $i <= 59 ; $i++)
					{
					?>
						<option value="<?php echo $i;?>" <?php  if($edit) selected($end_time_data[1],$i);  ?>><?php echo $i;?></option>
					<?php
					}
					?>
                </select>
			</div>
			<div class="col-sm-2">
				<select name="end_ampm" class="form-control validate[required] margin_top_10_res">
					<option value="am" <?php  if($edit) if(isset($end_time_data[2])) selected($end_time_data[2],'am');  ?> ><?php _e('A.M.','school-mgt');?></option>
                     <option value="pm" <?php  if($edit) if(isset($end_time_data[2]))selected($end_time_data[2],'pm');  ?>><?php _e('P.M.','school-mgt');?></option>
                </select>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php if($edit){ _e('Save Route','school-mgt'); }else{ _e('Add Route','school-mgt');}?>" name="save_route" class="btn btn-success" />
        </div>        
     </form>
    </div>
</div>     
