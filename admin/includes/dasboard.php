<?php 
	// This is Dashboard at admin side!!!!!!!!! 
	$obj_attend=new Attendence_Manage();
	$all_notice = "";
	$args['post_type'] = 'notice';
	$args['posts_per_page'] = -1;
	$args['post_status'] = 'public';
	$q = new WP_Query();
	$all_notice = $q->query( $args );
	$notive_array = array ();
	if (! empty ( $all_notice )) {
		foreach ( $all_notice as $notice ) {
			 $notice_start_date=get_post_meta($notice->ID,'start_date',true);
			 $notice_end_date=get_post_meta($notice->ID,'end_date',true);
			$i=1;
			
			$notive_array [] = array (
				'title' => $notice->post_title,
				'start' => mysql2date('Y-m-d', $notice_start_date ),
				'end' => date('Y-m-d',strtotime($notice_end_date.' +'.$i.' days')),
				'color'=>'#22BAA0'
			);				
		}
	}
	$holiday_list = get_all_data ( 'holiday' );	
	if (! empty ( $holiday_list )) {
		foreach ( $holiday_list as $holiday ) {
			$notice_start_date=$holiday->date;
			$notice_end_date=$holiday->end_date;
			$i=1;
				
			$notive_array [] = array (
				'title' => $holiday->holiday_title,
				'start' => mysql2date('Y-m-d', $notice_start_date ),
				'end' => date('Y-m-d',strtotime($notice_end_date.' +'.$i.' days')),
				'color' => '#5BC0DE'
			);
		}
	}
	 
	?>
<script>
	$(document).ready(function()
	{
		$('#calendar').fullCalendar(
		{
			 
			 header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				editable: false,
				slotEventOverlap: false,
				timeFormat: 'h(:mm)a',
			eventLimit:2, // allow "more" link when too many events
			events: <?php echo json_encode($notive_array);?>,
			forceEventDuration : true,
			
	        eventMouseover: function (event, jsEvent, view) {
			//end date change with minus 1 day
			<?php $dformate=get_option('smgt_datepicker_format'); ?>
			var dateformate_value='<?php echo $dformate;?>';	
			if(dateformate_value == 'yy-mm-dd')
			{	
			var dateformate='YYYY-MM-DD';
			}
			if(dateformate_value == 'yy/mm/dd')
			{	
			var dateformate='YYYY/MM/DD';	
			}
			if(dateformate_value == 'dd-mm-yy')
			{	
			var dateformate='DD-MM-YYYY';
			}
			if(dateformate_value == 'mm-dd-yy')
			{	
			var dateformate='MM-DD-YYYY';
			}
			if(dateformate_value == 'mm/dd/yy')
			{	
			var dateformate='MM/DD/YYYY';	
			}
			 var newdate = event.end;
			 var type = event.type;
			 var date = new Date(newdate);
			 var newdate1 = new Date(date);
			 
			 if(type == 'reservationdata')
			 {
				newdate1.setDate(newdate1.getDate());
			 }
			 else
			 {
				 newdate1.setDate(newdate1.getDate() - 1);
			 }
			 var dateObj = new Date(newdate1);
			 var momentObj = moment(dateObj);
			 var momentString = momentObj.format(dateformate);
			 
			 var newstartdate = event.start;
			 var date = new Date(newstartdate);
			 var startdate = new Date(date);
			 var dateObjstart = new Date(startdate);
			 var momentObjstart = moment(dateObjstart);
			 var momentStringstart = momentObjstart.format(dateformate);
						tooltip = "<div class='tooltiptopicevent' style='width:auto;height:auto;background:#feb811;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%;'>" + "<?php _e("Title Name","school-mgt"); ?>" + " : " + event.title + "</br>" + " <?php _e("Start Date","school-mgt"); ?> " + " : " + momentStringstart + "</br>" + "<?php _e("End Date","school-mgt"); ?>" + " : " + momentString + "</br>" +  " </div>";						
						$("body").append(tooltip);
						$(this).mouseover(function (e) {
							$(this).css('z-index', 10000);
							$('.tooltiptopicevent').fadeIn('500');
							$('.tooltiptopicevent').fadeTo('10', 1.9);
						}).mousemove(function (e) {
							$('.tooltiptopicevent').css('top', e.pageY + 10);
							$('.tooltiptopicevent').css('left', e.pageX + 20);
						});

					},
					eventMouseout: function (data, event, view) {
						$(this).css('z-index', 8);

						$('.tooltiptopicevent').remove();

					}, 
		});
	});
</script>


 
<!--task-event POP up code -->
  <div class="popup-bg">
    <div class="overlay-content content_width">
		<div class="modal-content" style="border-top: 5px solid #22baa0;">
			<div class="task_event_list">
			</div>     
		</div>
    </div>     
  </div>
 <!-- End task-event POP-UP Code -->
<div class="page-inner">
	<div class="page-title page_title_dashboard">
		<h3 class="dashboard_display_inline_css"><img src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'smgt_school_name' );?>
		</h3>
		<h3 class="dashboard_with_lms_div"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/Thumbnail-img.png"?>" class="wplms_image head_logo" width="40" height="40" />
		<div class="dashboard_display_inline_css">
			<div><label class="dashboard_lable1"><a href=" https://ihrex.me/" target="_blank"><?php echo esc_html_e( __( 'Made with love by', 'school-mgt' ) );?></a></label></div>
			<div><label class="dashboard_lable2"><a href=" https://ihrex.me/" target="_blank"><?php echo esc_html_e( __( 'iHRex', 'school-mgt' ) );?></label></div>		
		</div>
		</h3>
	</div>
<div id="main-wrapper">
	<div class="row">
		<div class="responsivesort col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<a class="anchor_css" href="<?php print admin_url().'admin.php?page=smgt_student'; ?>">
				<div class="panel info-box panel-white">
					<div class="panel-body student">
					   <span class="info-box-icon bg-aqua">
						<i class="ion ion-ios-gear-outline"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/student.png"?>"></i>
						</span>
						<div class="info-box-stats">
							<?php
							$user_query = new WP_User_Query( array( 'role' => 'student' ) );
							$student_count = (int) $user_query->get_total();
							?>
							<span class="info-box-title all_box"><?php echo esc_html( __( 'Students', 'school-mgt' ) );?></span>
							<p class="counter"><?php echo $student_count;?></p>							
						</div>	
							
					</div>
				</div>
			</a>
		</div>
		
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<a class="anchor_css" href="<?php print admin_url().'admin.php?page=smgt_teacher'; ?>">
					<div class="panel info-box panel-white">
						<div class="panel-body teacher">
						    <span class="info-box-icon bg-aqua">
									<i class="ion ion-ios-gear-outline"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/teacher.png"?>"></i>
							</span>
							<div class="info-box-stats">
								<?php
								$user_query = new WP_User_Query( array( 'role' => 'teacher' ) );
								$teacher_count = (int) $user_query->get_total();
								?>
								<span class="info-box-title all_box"><?php echo esc_html( __( 'Teachers', 'school-mgt' ) );?></span>
								<p class="counter"><?php echo $teacher_count;?></p>
							</div>	
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<a class="anchor_css" href="<?php print admin_url().'admin.php?page=smgt_parent'; ?>">
					<div class="panel info-box panel-white">
						<div class="panel-body parent">
						    <span class="info-box-icon bg-aqua">
									<i class="ion ion-ios-gear-outline"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/parents.png"?>"></i>
							</span>
							<div class="info-box-stats">
							   <?php
								$user_query = new WP_User_Query( array( 'role' => 'parent' ) );
								$parent_count = (int) $user_query->get_total();
								?>
								<span class="info-box-title all_box"><?php echo esc_html( __( 'Parents', 'school-mgt' ) );?></span>
								<p class="counter"><?php echo $parent_count;?></p>
							</div>	
						</div>
					</div>
				</a>
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<a class="anchor_css" href="<?php print admin_url().'admin.php?page=smgt_supportstaff'; ?>">
					<div class="panel info-box panel-white">
						<div class="panel-body staff1">
							<span class="info-box-icon bg-aqua">
									<i class="ion ion-ios-gear-outline"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/support_staff.png"?>"></i>
							</span>
							<div class="info-box-stats">
							<?php 
								$user_query = new WP_User_Query( array( 'role' => 'supportstaff' ) );
								$support_count = (int) $user_query->get_total();
								?>
								<span class="info-box-title all_box"><?php echo esc_html( __( 'Support Staffs', 'school-mgt' ) );?></span>
								<p class="counter"><?php echo $support_count;?></p>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<a class="anchor_css" href="<?php print admin_url().'admin.php?page=smgt_notice'; ?>">
					<div class="panel info-box panel-white">
						<div class="panel-body notices">
							<span class="info-box-icon bg-aqua">
									<i class="ion ion-ios-gear-outline"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/notice_new.png"?>"></i>
							</span>
							<div class="info-box-stats">
							<?php 
								global $wpdb;
								$table_post= $wpdb->prefix. 'posts';
								$total_notice = $wpdb->get_row("SELECT COUNT(*) as  total_notice FROM $table_post where post_type='notice' ");	
								?>
								<span class="info-box-title all_box"><?php echo esc_html( __( 'Notice', 'school-mgt' ) );?></span>
								<p class="counter"><?php echo $total_notice->total_notice;;?></p>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<a class="anchor_css" href="<?php print admin_url().'admin.php?page=smgt_attendence'; ?>">
					<div class="panel info-box panel-white">
						<div class="panel-body attendence">
						    <span class="info-box-icon bg-aqua">
									<i class="ion ion-ios-gear-outline"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/attendance.png"?>"></i>
							</span>
							<div class="info-box-stats">
								<span class="info-box-title all_box"><?php echo esc_html( __( 'Today attendance', 'school-mgt' ) );?></span>
								<p class="counter"><?php echo $obj_attend->today_presents();?></p>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<a class="anchor_css" href="<?php print admin_url().'admin.php?page=smgt_message'; ?>">
					<div class="panel info-box panel-white">
						<div class="panel-body message">
							<span class="info-box-icon bg-aqua">
									<i class="ion ion-ios-gear-outline"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/email_new.png"?>"></i>
							</span>
							<div class="info-box-stats">
								<span class="info-box-title all_box"><?php echo esc_html( __( 'Messages', 'school-mgt' ) );?></span>
								<p class="counter"><?php echo count(smgt_count_inbox_item(get_current_user_id()));?></p>
							</div> 
						</div>
					</div>
				</a>
			</div>
			
			
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<a class="anchor_css" href="<?php print admin_url().'admin.php?page=smgt_gnrl_settings'; ?>">
					<div class="panel info-box panel-white">
						<div class="panel-body settings">
							<span class="info-box-icon bg-aqua">
									<i class="ion ion-ios-gear-outline"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/settings_new.png"?>"></i>
							</span>
							<div class="info-box-stats">
								<span class="info-box-title all_box"><?php echo esc_html( __( 'Settings', 'school-mgt' ) );?></span>
								<p class="counter"><?php echo " ";?></p>
							</div>
						</div>
					</div>
				</a>
			</div>
			
	</div>

	<div class="col-md-6 col-sm-6 col-xs-12 attandance_padding">
		<div class="col-md-12" style="padding: 0px;">
				<div class="panel panel-body panel-white payment_report ">
					<div class="panel-heading-report">
						<h3 class="panel-title-report"><i class="fa fa-file-text" aria-hidden="true"></i><?php _e('Last Week Attendance Report','school-mgt');?>	
						</h3>					
					</div>
					<?php 
					global $wpdb;
					$table_attendance = $wpdb->prefix .'attendence';
					$table_class = $wpdb->prefix .'smgt_class';
				
					$report_1 =$wpdb->get_results("SELECT  at.class_id,
							SUM(case when `status` ='Present' then 1 else 0 end) as Present,
							SUM(case when `status` ='Absent' then 1 else 0 end) as Absent
							from $table_attendance as at,$table_class as cl where at.attendence_date >  DATE_SUB(NOW(), INTERVAL 1 WEEK) AND at.class_id = cl.class_id AND at.role_name = 'student' GROUP BY at.class_id") ;
					$chart_array = array();
					$chart_array[] = array(__('Class','school-mgt'),__('Present','school-mgt'),__('Absent','school-mgt'));
					if(!empty($report_1))
						foreach($report_1 as $result)
						{
							$class_id =get_class_name($result->class_id);
							$chart_array[] = array("$class_id",(int)$result->Present,(int)$result->Absent);
						}
					
					$options = Array(
							'title' => __('Last Week Attendance Report','school-mgt'),
							'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
							'legend' =>Array('position' => 'right',
									'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')),
					
							'hAxis' => Array(
									'title' =>  __('Class','school-mgt'),
									'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
									'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
									'maxAlternation' => 2
					
					
							),
							'vAxis' => Array(
									'title' =>  __('No of Student','school-mgt'),
									'minValue' => 0,
									'maxValue' => 4,
									'format' => '#',
									'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
									'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')
							),
							'colors' => array('#22BAA0','#f25656')
							
					);
					require_once SMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
					$GoogleCharts = new GoogleCharts;
					if(!empty($report_1))
					{
						$chart = $GoogleCharts->load( 'column' , 'chart_div' )->get( $chart_array , $options );
					}
						if(isset($report_1) && count($report_1) >0)
						{
							
						?>
							<div id="chart_div" style="width: 100%; height: 500px;"></div>
					  
						  <!-- Javascript --> 
						  <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
						  <script type="text/javascript">
									<?php echo $chart;?>
							</script>
					  <?php 
						}
					 if(isset($report_1) && empty($report_1))
					 {?>
						<div class="clear col-md-12 error_msg"><?php _e("No data available.",'school-mgt');?></div>
					<?php }?>
					 
				</div>
		</div>
		
		<div class="col-md-12" style="padding: 0px;">
				<div class="panel panel-body panel-white month_attandance">
					<div class="panel-heading-report">
							<h3 class="panel-title-report"><i class="fa fa-file-text" aria-hidden="true"></i><?php _e('Last Month Attendance Report','school-mgt');?>
							</h3>
					</div>
					<?php 
					global $wpdb;
					
					$table_attendance = $wpdb->prefix .'attendence';
					$table_class = $wpdb->prefix .'smgt_class';
					$report_2 =$wpdb->get_results("SELECT  at.class_id,
							SUM(case when `status` ='Present' then 1 else 0 end) as Present,
							SUM(case when `status` ='Absent' then 1 else 0 end) as Absent
							from $table_attendance as at,$table_class as cl where at.attendence_date >  DATE_SUB(NOW(), INTERVAL 1 MONTH) AND at.class_id = cl.class_id AND at.role_name = 'student' GROUP BY at.class_id") ;
					$chart_array = array();
					$chart_array[] = array(__('Class','school-mgt'),__('Present','school-mgt'),__('Absent','school-mgt'));
					if(!empty($report_2))
						foreach($report_2 as $result)
						{
					
							$class_id =get_class_name($result->class_id);
							$chart_array[] = array("$class_id",(int)$result->Present,(int)$result->Absent);
						}
					
					 
					
					$options = Array(
							'title' => __('Last Month Attendance Report','school-mgt'),
							'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
							'legend' =>Array('position' => 'right',
									'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')),
					
							'hAxis' => Array(
									'title' =>  __('Class','school-mgt'),
									'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
									'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
									'maxAlternation' => 2
					
					
							),
							'vAxis' => Array(
									'title' =>  __('No of Student','school-mgt'),
									'minValue' => 0,
									'maxValue' => 4,
									'format' => '#',
									'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
									'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')
							),
							'colors' => array('#22BAA0','#f25656')
					);
					require_once SMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
					$GoogleCharts = new GoogleCharts;
					if(!empty($report_2))
					{
						$chart = $GoogleCharts->load( 'column' , 'chart_div_last_month' )->get( $chart_array , $options );
					}
						if(isset($report_2) && count($report_2) >0)
						{
							
						?>
							<div id="chart_div_last_month" style="width: 100%; height: 500px;"></div>
					  
						  <!-- Javascript --> 
						  <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
						  <script type="text/javascript">
									<?php echo $chart;?>
							</script>
					  <?php 
						}
					 if(isset($report_2) && empty($report_2))
					 {?>
						<div class="clear col-md-12 error_msg"><?php _e("No data available.",'school-mgt');?></div>
					<?php }?>
					 
				</div>
		</div>
		<div class="col-md-12" style="padding: 0px;">					
				<div class="panel panel-body panel-white result_report student_report">
					<div class="panel-heading-report">
							<h3 class="panel-title-report"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
							<?php _e('Student Fail Report','school-mgt');?>
							</h3>			
					</div>
					<?php 
					$chart_array = array();
					$chart_array[] = array( __('Class','school-mgt'),__('No. of Student Fail','school-mgt'));

						 
							global $wpdb;
							$table_marks = $wpdb->prefix .'marks';
							$table_users = $wpdb->prefix .'users';
							 
								$report_3 =$wpdb->get_results("SELECT * , count( student_id ) as count
								FROM $table_marks as m, $table_users as u
								WHERE m.marks <40
								AND m.student_id = u.id
								GROUP BY subject_id");
							 
						if(!empty($report_3))
						foreach($report_3 as $result)
						{
							
							$subject =get_single_subject_name($result->subject_id);
							$chart_array[] = array("$subject",(int)$result->count);
						}

						$options = Array(
								'title' => __('Exam Failed Report','school-mgt'),
								'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
								'legend' =>Array('position' => 'right',
										'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')),
									
								'hAxis' => Array(
										'title' =>  __('Subject','school-mgt'),
										'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
										'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
										'maxAlternation' => 2
								),
								'vAxis' => Array(
										'title' =>  __('No of Student','school-mgt'),
										'minValue' => 0,
										'maxValue' => 4,
										'format' => '#',
										'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
										'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')
								),
								'colors' => array('#22BAA0')
						);
						
					require_once SMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
					$GoogleCharts = new GoogleCharts;
					if(!empty($report_3))
					{
						$chart = $GoogleCharts->load( 'column' , 'chart_div_fail_report' )->get( $chart_array , $options );
					}
						if(isset($report_3) && count($report_3) >0)
						{
							
						?>
							<div id="chart_div_fail_report" style="width: 100%; height: 500px;"></div>
					  
						  <!-- Javascript --> 
						  <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
						  <script type="text/javascript">
									<?php echo $chart;?>
							</script>
					  <?php 
						}
					 if(isset($report_3) && empty($report_3))
					 {?>
						<div class="clear col-md-12 error_msg"><?php _e("No data available.",'school-mgt');?></div>
					<?php }?>
					 
				</div>
		</div>
							
		<div class="col-md-12" style="padding: 0px;">
				<div class="panel panel-body panel-white result_report">
					<div class="panel-heading-report">
							<h3 class="panel-title-report"><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php _e('Fees Payment','school-mgt');?>
							</h3>			
					</div>
					<?php 
					$month =array('1'=>__('January','school-mgt'),'2'=>__('February','school-mgt'),'3'=>__('March','school-mgt'),'4'=>__('April','school-mgt'),'5'=>__('May','school-mgt'),'6'=>__('June','school-mgt'),'7'=>__('July','school-mgt'),'8'=>__('August','school-mgt'),
					'9'=>__('September','school-mgt'),'10'=>__('October','school-mgt'),'11'=>__('November','school-mgt'),'12'=>__('December','school-mgt'),);
							$year =isset($_POST['year'])?$_POST['year']:date('Y');
							
							global $wpdb;
							$table_smgt_fees_payment = $wpdb->prefix."smgt_fee_payment_history";
							//$income="SELECT EXTRACT(MONTH FROM paid_by_date) as date,sum(total_amount) as count FROM ".$table_smgt_fees_payment." WHERE YEAR(paid_by_date) =".$year." group by month(paid_by_date) ORDER BY paid_by_date ASC";
							$income="SELECT EXTRACT(MONTH FROM paid_by_date) as date,sum(amount) as count FROM ".$table_smgt_fees_payment." WHERE YEAR(paid_by_date) =".$year." group by month(paid_by_date) ORDER BY paid_by_date ASC";
							$income_result=$wpdb->get_results($income);
							 
							$month_array = array("1","2","3","4","5","6","7","8","9","10","11","12");
							$data_array = array();
							foreach($month_array as $m)
							{
								$data_array[$m] = 0;
								foreach($income_result as $a)
								{
									if($a->date == $m){
										$data_array[$m] = $data_array[$m] + $a->count;
									}
								}
								 
								if($data_array[$m] == 0)
								{
									unset($data_array[$m]);
								}
							}
							
							$chart_array = array();
							$currency=get_currency_symbol();
							$chart_array[] = array( __('Month','school-mgt'),__('Payment','school-mgt'));
							$currency=get_currency_symbol();
							foreach($data_array as $key=>$value)
							{	
								foreach($month as $key1=>$value1)
								{	
									if($key1==$key)
									{		
										$chart_array[]=array( __($value1,'school-mgt'),$value);		
									}
								}
							} 
							 $options = Array(
										'title' => __('Payment by month','school-mgt'),
										'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
										'legend' =>Array('position' => 'right',
													'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')),
										
										'hAxis' => Array(
											'title' => __('Month','school-mgt'),
											'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
											'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
											'maxAlternation' => 2
																			
											),
										'vAxis' => Array(
											'title' => __('Payment','school-mgt'),
											 'minValue' => 0,
											'maxValue' => 5,
											 'format' =>  html_entity_decode($currency),
											'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
											'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')
											),
									'colors' => array('#22BAA0')
										);
										/* var_dump($options);
										die; */
					require_once SMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
					$GoogleCharts = new GoogleCharts;
					if(!empty($income_result))
					{
						$chart = $GoogleCharts->load( 'column' , 'chart_div_payment_report' )->get( $chart_array , $options );
					}
						if(isset($income_result) && count($income_result) >0)
						{
							
						?>
							<div id="chart_div_payment_report" style="width: 100%; height: 500px;"></div>
					  
						  <!-- Javascript --> 
						  <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
						  <script type="text/javascript">
									<?php echo $chart;?>
							</script>
					  <?php 
						}
					 if(isset($income_result) && empty($income_result))
					 {?>
						<div class="clear col-md-12 error_msg"><?php _e("No data available.",'school-mgt');?></div>
					<?php }?>
				</div>
		</div>
	</div>
	
	
	
	<div class="col-md-6 col-sm-6 col-xs-12 data_right">
	   
		
		<div class="panel panel-white exam list_en1">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-book" aria-hidden="true"></i> <?php _e('Exam List','school-mgt');?></h3>
					    <ul class="nav navbar-right panel_toolbox">
							<li class="margin_dasboard"><a href="<?php echo admin_url().'admin.php?page=smgt_exam';?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
							</li>                  
						</ul>
					</div>					
					<div class="panel-body">
						<div class="events">
								<?php 
								global $wpdb;
								$smgt_exam = $wpdb->prefix. 'exam';
								
								$result = $wpdb->get_results("SELECT * FROM $smgt_exam ORDER BY exam_id DESC limit 3");
													
								if(!empty($result)) 
								{
									foreach($result as $retrieved_data)
									{
									?>				
										<div class="calendar-event view-complaint"> 
											<p class="cursor_effect Bold show_task_event" id="<?php echo $retrieved_data->exam_id;?>" model="Exam Details" > <?php _e('Exam Title : ','school-mgt');?> 
											<?php echo 	$retrieved_data->exam_name;  ?>
											</p> 
											<p class="remainder_date"><?php echo smgt_getdate_in_input_box($retrieved_data->exam_start_date); ?> | <?php echo smgt_getdate_in_input_box($retrieved_data->exam_end_date);?></p>
											<p class="remainder_title_pr_new">
											<?php 
												$strlength= strlen($retrieved_data->exam_comment);
												if($strlength > 90)
												{
													echo substr($retrieved_data->exam_comment, 0,90).'...';
												}
												else
												{
													echo $retrieved_data->exam_comment; 
												}
												?>
											</p>
										</div>
								<?php
									}	
								} 
								else 
								{
									?>
									<div class="eror_msg"> 
									<?php
										_e("No Upcoming Exam",'school-mgt');
										
									?>
									</div>
									<?php
								}
								?>
						</div>	
					</div>
		</div>
		
		<div class="panel panel-white notification list_en2">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-bell" aria-hidden="true"></i> <?php _e('Notification','school-mgt');?></h3>	
						<ul class="nav navbar-right panel_toolbox">
							<li class="margin_dasboard"><a href="<?php echo admin_url().'admin.php?page=smgt_notification';?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
							</li>                  
						</ul>
					</div>					
					<div class="panel-body">
						<div class="events">
								<?php
										global $wpdb;
										$smgt_notification = $wpdb->prefix. 'smgt_notification';
										
										$result = $wpdb->get_results("SELECT * FROM $smgt_notification ORDER BY notification_id DESC limit 3");
										 
										  if(!empty($result)) 
											{
												foreach($result as $retrieved_data)
												{  
													?>	
													<div class="calendar-event view-complaint"> 
													<p class="remainder_title_pr Bold show_task_event" id="<?php echo $retrieved_data->notification_id;?>" model="Notification Details" >  <?php _e(' Notification Title :','school-mgt');?>
													<?php echo 	$retrieved_data->title;  ?>				
													</p>
													<p class="">
													<?php _e('Notification Message :','school-mgt');?>
													<?php
													$strlength= strlen($retrieved_data->message);
														if($strlength > 90)
														{
															echo substr($retrieved_data->message, 0,90).'...';
														}
														else
														{
															echo $retrieved_data->message; 
														}
													 ?></p>
													</div>	
													<?php
												}	
											}
											else 
											{
												?>
												<div class="eror_msg"> 
												<?php
													_e("No Upcoming Notification",'school-mgt');
													
												?>
												</div>
												<?php
											}
											?>											
						</div>
					</div>
				</div>
		<div class="panel panel-white nt list_en2">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php _e('Notice board','school-mgt');?></h3>
						<ul class="nav navbar-right panel_toolbox">
							<li class="margin_dasboard"><a href="<?php echo admin_url().'admin.php?page=smgt_notice';?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
							</li>                  
						</ul>
					</div>					
					<div class="panel-body">
						<div class="events">
							 <?php 
								  $args['post_type'] = 'notice';
								  $args['posts_per_page'] = 3;
								  $args['post_status'] = 'public';
								  $q = new WP_Query();
								  $retrieve_class = $q->query( $args );
									 
									$format =get_option('date_format') ;
								if(!empty($retrieve_class)) 
								{
									foreach ($retrieve_class as $retrieved_data)
									{	
								 ?>
										<div class="calendar-event"> 
											<p class="remainder_title Bold show_task_event" id="<?php echo $retrieved_data->ID;?>" model="Noticeboard Details">	
											<?php echo 	$retrieved_data->post_title;  ?>
											</p>
											<p class="remainder_date"><?php echo smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'start_date',true)); ?> | <?php echo smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'end_date',true));?></p>
											<p class="remainder_title_pr_new"><?php 
											$strlength= strlen($retrieved_data->post_content);
												if($strlength > 90)
												{
													echo substr($retrieved_data->post_content, 0,90).'...';
												}
												else
												{
													echo $retrieved_data->post_content; 
												}
											?>
											</p>
										</div>
								<?php
									}	
								} 
								else 
								{
									?>
									<div class="eror_msg"> 
									<?php
										_e("No Upcoming Notice",'school-mgt');
									?>
									</div>
									<?php
								}
								?>		
							</div>
						</div>
		</div>
		<div class="panel panel-white event list_en">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-calendar" aria-hidden="true"></i> <?php _e('Holiday List','school-mgt');?></h3>	
						<ul class="nav navbar-right panel_toolbox">
							<li class="margin_dasboard"><a href="<?php echo admin_url().'admin.php?page=smgt_holiday';?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
							</li>                  
						</ul>
					</div>
					<div class="panel-body">					
						<div class="events">
						 <?php 
								  global $wpdb;
									$smgt_holiday = $wpdb->prefix. 'holiday';
									
									$result_holidays = $wpdb->get_results("SELECT * FROM $smgt_holiday ORDER BY holiday_id DESC limit 3");
													
								if(!empty($result_holidays)) 
								{
									foreach ($result_holidays as $retrieved_data)
									{	
								 ?>
									<div class="calendar-event"> 
										<p class="cursor_effect Bold show_task_event" id="<?php echo $retrieved_data->holiday_id;?>" model="holiday Details" > 
										<?php echo 	$retrieved_data->holiday_title;  ?>
										</p>
										<p class="remainder_date"><?php echo smgt_getdate_in_input_box($retrieved_data->date); ?> | <?php echo smgt_getdate_in_input_box($retrieved_data->end_date);?></p>
										<p class="remainder_title_pr_new"><?php 
										$strlength= strlen($retrieved_data->description);
										if($strlength > 90)
										{
											echo substr($retrieved_data->description, 0,90).'...';
										}
										else
										{
											echo $retrieved_data->description; 
										}
										?></p>
									</div>
									<?php
									}	
								} 
								else 
								{
									?>
									<div class="eror_msg"> 
									<?php
										_e("No Upcoming Holiday",'school-mgt');
									?>
									</div>
									<?php
								}
								?>		

						</div>
					</div>
		</div>
		 <div class="panel panel-white class list_en1">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-building" aria-hidden="true"> </i><?php _e(' Class','school-mgt');?></h3>	
                        <ul class="nav navbar-right panel_toolbox">
							<li class="margin_dasboard"><a href="<?php echo admin_url().'admin.php?page=smgt_class';?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
							</li>                  
						</ul>						
					</div>					
					<div class="panel-body">
						<table class="table table-borderless">
						<?php 
						global $wpdb;
								$smgt_class = $wpdb->prefix. 'smgt_class';
								
								$result = $wpdb->get_results("SELECT * FROM $smgt_class ORDER BY class_id DESC limit 3");
								 
								  if(!empty($result)) 
									{ ?>
									<thead class="responsive_font">
								<tr>
								  <th scope="col" style="border-bottom: 0;border-bottom: 1px solid #f4f4f4;"><?php _e('Class Name','school-mgt');?></th>
								  <th scope="col" style="border-bottom: 0;border-bottom: 1px solid #f4f4f4;"><?php _e('Numeric Class Name','school-mgt');?></th>
								  <th scope="col" style="border-bottom: 0;border-bottom: 1px solid #f4f4f4;"><?php _e('Capacity','school-mgt');?></th>
								</tr>
							  </thead>
							  
										  <tbody>
										  <?php
										foreach($result as $retrieved_data)
										{  
										?>	
												<tr>
												  <td class="unit"><?php echo 	$retrieved_data->class_name;  ?></td>
												  <td class="unit"><?php echo 	$retrieved_data->class_num_name;  ?>	</td>
												  <td class="unit"><span class="btn btn-success btn-xs"><?php echo 	$retrieved_data->class_capacity;  ?>	</span></td>
												</tr>
												<?php
										}	?>
										  </tbody>
									  <?php
									} 
									else 
									{
										?>
										<div class="eror_msg"> 
										<?php
											_e("No Upcoming Class",'school-mgt');
										?>
										</div>
										<?php
									}
									?>		
									 		
						 </table>
					</div>
				
		</div>
		<div class="panel panel-white report_height cln">
			<div class="panel-body">
				<div id="calendar"></div><br>
				<mark style="height:5px;width:10px; background:rgb(34,186,160)">&nbsp;&nbsp;&nbsp;</mark><span> &nbsp;<?php _e('Notice','school-mgt') ?><span><br><br>
				<mark style="height:5px;width:10px; background:rgb(91,192,222)">&nbsp;&nbsp;&nbsp;</mark><span> &nbsp;<?php _e('Holiday','school-mgt') ?><span>
			</div>
		</div>
	</div>
		</div>		
	</div>
