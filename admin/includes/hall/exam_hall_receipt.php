<script type="text/javascript">
		$(document).ready(function(){	
		/* alert("dssd");
		return false; */
		$('#receipt_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});		
			 
			 
				  jQuery('.exam_hall_table').DataTable({
					responsive: true,
					bPaginate: false,
					bFilter: false, 
					bInfo: false,
				});   
			 
			$("body").on("click", "#checkbox-select-all", function()
			{
				if($(this).is(':checked',true))  
				{
					$(".my_check").prop('checked', true);  
				}  
				else  
				{  
					$(".my_check").prop('checked',false);  
				}
			});
			$("body").on("click", ".my_check", function()
			{
				if(false == $(this).prop("checked"))
				{
					$("#checkbox-select-all").prop('checked', false);
				}
				if ($('.my_check:checked').length == $('.my_check').length )
				{
					$("#checkbox-select-all").prop('checked', true);
				}
			});
		});
</script>
<div class="panel-body">	
	<form name="exam_form" action="" method="post" class="form-horizontal" enctype="multipart/form-data" id="exam_form">
		<div class="form-group">
			<label for="exam_id" class="col-md-2 col-sm-2 col-xs-12 width_120"><?php _e('Select Exam','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-md-3 col-sm-3 col-xs-12">
			<?php
				$tablename="exam"; 
				$retrieve_class = get_all_data($tablename);
				$exam_id="";
				if(isset($_REQUEST['exam_id']))
				{
					$exam_id=$_REQUEST['exam_id']; 
				}
				?>
				<select name="exam_id" class="form-control validate[required] exam_hall_receipt" id="exam_id">
					<option value=" "><?php _e('Select Exam Name','school-mgt');?></option>
					<?php
					foreach($retrieve_class as $retrieved_data)
					{
						$cid=$retrieved_data->class_id;
						$clasname=get_class_name($cid);
						if($retrieved_data->section_id!=0)
						{
							$section_name=smgt_get_section_name($retrieved_data->section_id); 
						}
						else
						{
							$section_name=__('No Section', 'school-mgt');
						}
					?>
						<option value="<?php echo $retrieved_data->exam_id;?>" <?php selected($retrieved_data->exam_id,$exam_id)?>><?php echo $retrieved_data->exam_name.' ( '.$clasname.' )'.' ( '.$section_name.' )';?></option>
					<?php	
					}
					?>
				</select>
			</div>
		</div>
	</form>
	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="exam_hall_receipt_div"></div>
	</div>
<style>
.exam_timelist.info td, 
.exam_timelist.info>tbody>tr>td,
.exam_timelist.info>thead>tr>th,
.exam_timelist.info > tfoot > tr > th{
	padding: 8px;
}
.exam_timelist td, 
.exam_timelist>tbody>tr>td,
.exam_timelist>thead>tr>th,
.exam_timelist > tfoot > tr > th{
	padding: 12px;
}
.exam_timelist>thead>tr>th{
	border-bottom: medium none;
}
td .btn{
	margin-bottom: 0px;
    font-size: 9px;
    padding: 0px 6px;
	font-weight: bold;
}
input[type=checkbox]{
	margin: 0px;
}
.exam_hall label{
	padding: 7px;
}
.exam_timelist>thead>tr>th:first-child{
	padding-left: 18px;
}
.exam_timelist>thead>tr>th
{	
	border-bottom: 1px solid #000000;
}
.exam_timelist>tfoot>tr>th
{	
	border-top: 1px solid #000000;
}
.exam_timelist.dataTable thead .sorting{
	background: none;
}
.dataTables_empty{
	display: none;
}
.exam_timelist tr:nth-child(even){background-color: #f2f2f2;}

</style>	
</div> 
