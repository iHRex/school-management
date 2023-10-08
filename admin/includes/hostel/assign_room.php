<?php
$obj_hostel=new smgt_hostel;
 ?>
 <style>
 .btn-success[disabled]
 {
	 color:white;
 }
 </style>
<script type="text/javascript">
	$(document).ready(function() {
		 $('#bed_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	} );
</script>
<?php 
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view_assign_room')
	{
		$room_id=$_REQUEST['room_id'];
	}
	$bed_data=$obj_hostel->get_all_bed_by_room_id($room_id);
	$hostel_id=$obj_hostel->smgt_get_hostel_id_by_room_id($room_id);

	$exlude_id = smgt_approve_student_list();
	$student_all= get_users(array('role'=>'student','exclude'=>$exlude_id));
	
	foreach($student_all as $aa)
	{
		$student_id[]=$aa->ID;
	}
	//--------- GET ASSIGNED STUDENT DATA -------//
	$assign_data=smgt_all_assign_student_data();
	
	if(!empty($assign_data))
	{
		foreach($assign_data as $bb)
		{
			$student_new_id[]=$bb->student_id;
		} 
		$Student_result=array_diff($student_id,$student_new_id);
	}
	else
	{
		$Student_result=$student_id;
	}
?>
	<div class="panel-body">
	<?php
	$i=0;
	if(!empty($bed_data))
	{
		foreach($bed_data as $data)
		{
			$student_data =smgt_student_assign_bed_data($data->id);
		?>
       <script>
		$(document).ready(function() {
			$('.datepicker').datepicker({
				defaultDate: null,
				changeMonth: true,
				changeYear: true,
				yearRange:'-75:+10',
				dateFormat: 'yy-mm-dd',
				
			 });
			$('#assigndate_<?php echo $i ; ?>').hide();
			$("#Assign_bed").prop("disabled", true);	
			$('.students_list_<?php echo $i ;?>').change(function () {
				var optionSelected = $(this).find("option:selected");
				var valueSelected  = optionSelected.val();
				var i  = '<?php echo $i ;?>';
	          checkselectvalue(valueSelected,i);
			 });
		
			function checkselectvalue(value,i) {
			
				$('#assigndate_'+i).hide();
				$('.students_list_'+i).removeClass('student_check');
				$(".student_check").each(function()
				{
					var valueSelected1=$(this).val();
					if(valueSelected1 == value)
					{
						alert("<?php esc_html_e('Please Select Different Student','school-mgt');?>");
						$('.students_list_'+i).val('0');	
						return false;	
					}
				});
				var value=$('.students_list_'+i).val();
				if(value =='0' )
				{
					$('#assigndate_'+i).hide();
					var name=0;
					$(".new_class").each(function()
					{
						var new_class=$(this).val();
						if(new_class != '0')
						{
							name=name+1;
						}
					});
					if(name < 1)
					{
						$("#Assign_bed").prop("disabled", true);
					}
				}
				else
				{
					$('#assigndate_'+i).show();
					$("#Assign_bed").prop("disabled", false);
				} 
				$('.students_list_'+i).addClass('student_check');
			}	
		});
		</script>
		<form name="bed_form" action="" method="post" class="form-horizontal" id="bed_form">
				<input type="hidden" name="room_id_new[]" value="<?php echo $data->room_id;?>">
				<input type="hidden" name="bed_id[]" value="<?php echo $data->id;?>">
				<input type="hidden" name="hostel_id" value="<?php echo $hostel_id;?>">
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 col-sm-2 col-xs-12 control-label" for="bed_unique_id"><?php _e( 'Bed Unique ID', 'school-mgt' ) ;?><span class="require-field"></span></label>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<input id="bed_unique_id_<?php echo $i;?>" class="form-control validate[required]" type="text" value="<?php echo $data->bed_unique_id;;?>" name="bed_unique_id[]" readonly>
						</div>
						<?php
								if(!empty($student_data))
								{
									$new_class='';
								}
								else
								{
									$new_class='new_class';
								}
								?>

						<div class="col-md-2 col-sm-2 col-xs-12">
							<select name="student_id[]" id="students_list_<?php echo $i ;?>" class="form-control max_width_margin_top_10 student_check <?php echo $new_class; ?> students_list_<?php echo $i ;?>">
								<?php
								if(!empty($student_data))
								{
									$roll_no = get_user_meta( $student_data->student_id, 'roll_id' , true );
									$class_id = get_user_meta( $student_data->student_id, 'class_name' , true );
								?>
									<option value="<?php echo $student_data->student_id; ?>" ><?php echo get_display_name($student_data->student_id).' ('.$roll_no.') ('.get_class_name($class_id).')'; ?></option>
									<?php 
								}
								else
								{?>
									<option value="0"><?php  _e( 'Select Student', 'school-mgt' );?></option>
									<?php foreach($Student_result as $student)
									{
										$roll_no = get_user_meta( $student, 'roll_id' , true );
										$class_id = get_user_meta( $student, 'class_name' , true );
									?>
										<option value="<?php echo $student; ?>"><?php echo get_display_name($student).' ('.$roll_no.') ('.get_class_name($class_id).')'; ?></option>
									<?php 
									}
								}
								?>
							</select>
						</div>
						<?php
						if(!empty($student_data))
						{
						?>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<input id="assign_date_<?php echo $i ;?>"  value="<?php  echo smgt_getdate_in_input_box($student_data->assign_date); ?>" class="form-control text-input margin_top_10_res" type="text" name="assign_date[]" readonly>
							</div>
						<?php
						}
						else
						{?>
						<div class="col-md-2 col-sm-2 col-xs-12 assigndate_<?php echo $i;?>" id="assigndate_<?php echo $i ;?>" name="assigndate" >
							<input id="assign_date_<?php echo $i;?>" placeholder="<?php _e( 'Enter Date', 'school-mgt' );?>" class="validate[required] datepicker form-control text-input margin_top_10_res" type="text" name="assign_date[]" autocomplete="off">
						</div>
						<?php
						}
						if($student_data)
						{
						?>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<label class="col-md-2 col-sm-2 col-xs-12 control-label occupied" for="available" ><?php _e( 'Occupied', 'school-mgt' );?></label>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<a href="?page=smgt_hostel&tab=room_list&action=delete_assign_bed&room_id=<?php echo $data->room_id;?>&bed_id=<?php echo $data->id;?>&student_id=<?php echo $student_data->student_id;?>" class="btn btn-danger" 
							onclick="return confirm('<?php _e('Are you sure you want to delete this bed?','school-mgt');?>');"><?php _e('Delete','school-mgt');?></a>
						</div>
						<?php
						}
						else
						{?>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<label class="col-md-2 col-sm-2 col-xs-12 control-label available" for="available" ><?php _e( 'Available', 'school-mgt' );?></label>
						</div>
						<?php
						}
						?>
					</div>
				</div>
			<?php
			$i++;
		}
		?>
		<?php wp_nonce_field( 'save_assign_room_admin_nonce' ); ?>
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" id="Assign_bed" value="<?php _e('Assign Room','school-mgt');?>" name="assign_room" class="btn btn-success" />
        </div>
	</form>
    <?php
	}
	else
	{ ?>
		<h4 class="require-field"><?php _e('No Bed Available','school-mgt');?></h4>
	<?php
	}
	?>
    </div>