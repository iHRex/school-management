<?php 

	$active_tab = isset($_GET['tab'])?$_GET['tab']:'view_exam_receipt';
	{
		$student_id=$_REQUEST['student_id'];
		$exam_data=smgt_student_exam_receipt_check($student_id);
	/*   var_dump($exam_data);
		die;  */
?>
 <div class="panel-body">
	<div class="row">
		<div class="col-md-12">
			<form method="post">  
				<script>
					jQuery(document).ready(function() {
						var table =  jQuery('#exam_list').DataTable({
						responsive: true,
						"aoColumns":[	                  
							{"bSortable": true},
							{"bSortable": false}],
						language:<?php echo smgt_datatable_multi_language();?>
						});
				});
				</script>
					<form id="frm-example" name="frm-example" method="post">
						<div class="table-responsive">
							<table id="exam_list" class="display admin_student_datatable" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th><?php echo _e( 'Exam Name', 'school-mgt' ) ;?></th>
										<th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>
									</tr>
								</thead>
					 
								<tfoot>
									<tr>
										<th> <?php echo _e( 'Exam Name', 'school-mgt' ) ;?></th>
										<th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>
									</tr>
								</tfoot>
					 
								<tbody>
									<?php
										if(!empty($exam_data))
										{
											foreach($exam_data as $retrived_data)
											{
											?>
												<tr>
													<td> <?php echo get_exam_name_id($retrived_data->exam_id) ;?></td>
													<td class="action">
														<a  href="?page=smgt_student&student_exam_receipt=student_exam_receipt&student_id=<?php echo $student_id;?>&exam_id=<?php echo $retrived_data->exam_id;?>" target="_blank"class="btn btn-success"><?php _e('Print','school-mgt');?></a>
														<a  href="?page=smgt_student&student_exam_receipt_pdf=student_exam_receipt_pdf&student_id=<?php echo $student_id;?>&exam_id=<?php echo $retrived_data->exam_id;?>" target="_blank"class="btn btn-success"><?php _e('PDF','school-mgt');?></a>
													</td>
												</tr>
											<?php
											}
										}
									?>
								</tbody>        
							</table>
						</div>
				</form>
		</div>
	</div>
</div>
	<?php 
	}	
	?>