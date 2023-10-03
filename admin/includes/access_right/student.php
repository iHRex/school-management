<?php 	
$result=get_option('smgt_access_right_student');
if(isset($_POST['save_access_right']))
{
	$role_access_right = array();
	$result=get_option('smgt_access_right_student');

	$role_access_right['student'] = [
									"teacher"=>["menu_icone"=>plugins_url('school-management/assets/images/icons/teacher.png'),
									'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/teacher.png'),
											   "menu_title"=>'Teacher',
											   "page_link"=>'teacher',
											   "own_data" =>isset($_REQUEST['teacher_own_data'])?$_REQUEST['teacher_own_data']:0,
											   "add" =>isset($_REQUEST['teacher_add'])?$_REQUEST['teacher_add']:0,
												"edit"=>isset($_REQUEST['teacher_edit'])?$_REQUEST['teacher_edit']:0,
												"view"=>isset($_REQUEST['teacher_view'])?$_REQUEST['teacher_view']:0,
												"delete"=>isset($_REQUEST['teacher_delete'])?$_REQUEST['teacher_delete']:0
												],
														
								   "student"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/student-icon.png'),
								   'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/student.png'),
											  "menu_title"=>'Student',
											  "page_link"=>'student',
											 "own_data" => isset($_REQUEST['student_own_data'])?$_REQUEST['student_own_data']:0,
											 "add" => isset($_REQUEST['student_add'])?$_REQUEST['student_add']:0,
											 "edit"=>isset($_REQUEST['student_edit'])?$_REQUEST['student_edit']:0,
											 "view"=>isset($_REQUEST['student_view'])?$_REQUEST['student_view']:0,
											 "delete"=>isset($_REQUEST['student_delete'])?$_REQUEST['student_delete']:0
								  ],
											  
									"parent"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/parents.png'),
									'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/parents.png'),
											"menu_title"=>'Parent',
											"page_link"=>'parent',
											 "own_data" => isset($_REQUEST['parent_own_data'])?$_REQUEST['parent_own_data']:0,
											 "add" => isset($_REQUEST['parent_add'])?$_REQUEST['parent_add']:0,
											"edit"=>isset($_REQUEST['parent_edit'])?$_REQUEST['parent_edit']:0,
											"view"=>isset($_REQUEST['parent_view'])?$_REQUEST['parent_view']:0,
											"delete"=>isset($_REQUEST['parent_delete'])?$_REQUEST['parent_delete']:0
								  ],
											  
									  "subject"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/subject.png'),
									  'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/subject.png'),
												"menu_title"=>'Subject',
												"page_link"=>'subject',
												"own_data" => isset($_REQUEST['subject_own_data'])?$_REQUEST['subject_own_data']:0,
												 "add" => isset($_REQUEST['subject_add'])?$_REQUEST['subject_add']:0,
												 "edit"=>isset($_REQUEST['subject_edit'])?$_REQUEST['subject_edit']:0,
												"view"=>isset($_REQUEST['subject_view'])?$_REQUEST['subject_view']:0,
												"delete"=>isset($_REQUEST['subject_delete'])?$_REQUEST['subject_delete']:0
									  ],
									  
									  "schedule"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/class-route.png'),
									  'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/class-route.png'),
												 "menu_title"=>'Class Routine',
												 "page_link"=>'schedule',
												 "own_data" => isset($_REQUEST['schedule_own_data'])?$_REQUEST['schedule_own_data']:1,
												 "add" => isset($_REQUEST['schedule_add'])?$_REQUEST['schedule_add']:0,
												"edit"=>isset($_REQUEST['schedule_edit'])?$_REQUEST['schedule_edit']:0,
												"view"=>isset($_REQUEST['schedule_view'])?$_REQUEST['schedule_view']:0,
												"delete"=>isset($_REQUEST['schedule_delete'])?$_REQUEST['schedule_delete']:0
									  ],
									  "virtual_classroom"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/virtual_classroom.png'),							       
												 "menu_title"=>'virtual_classroom',
												 "page_link"=>'virtual_classroom',
												 "own_data" => isset($_REQUEST['virtual_classroom_own_data'])?$_REQUEST['virtual_classroom_own_data']:0,
												 "add" => isset($_REQUEST['virtual_classroom_add'])?$_REQUEST['virtual_classroom_add']:0,
												"edit"=>isset($_REQUEST['virtual_classroom_edit'])?$_REQUEST['virtual_classroom_edit']:0,
												"view"=>isset($_REQUEST['virtual_classroom_view'])?$_REQUEST['virtual_classroom_view']:0,
												"delete"=>isset($_REQUEST['virtual_classroom_delete'])?$_REQUEST['virtual_classroom_delete']:0
									  ],
									  "attendance"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/attandance.png'),
									  'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/attandance.png'),
												   "menu_title"=>'Attendance',
												   "page_link"=>'attendance',
												 "own_data" => isset($_REQUEST['attendance_own_data'])?$_REQUEST['attendance_own_data']:0,
												 "add" => isset($_REQUEST['attendance_add'])?$_REQUEST['attendance_add']:0,
												"edit"=>isset($_REQUEST['attendance_edit'])?$_REQUEST['attendance_edit']:0,
												"view"=>isset($_REQUEST['attendance_view'])?$_REQUEST['attendance_view']:0,
												"delete"=>isset($_REQUEST['attendance_delete'])?$_REQUEST['attendance_delete']:0
									  ],
									  
										"exam"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/exam.png'),
										'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/exam.png'),
												 "menu_title"=>'Exam',
												 "page_link"=>'exam',
												 "own_data" => isset($_REQUEST['exam_own_data'])?$_REQUEST['exam_own_data']:0,
												 "add" => isset($_REQUEST['exam_add'])?$_REQUEST['exam_add']:0,
												"edit"=>isset($_REQUEST['exam_edit'])?$_REQUEST['exam_edit']:0,
												"view"=>isset($_REQUEST['exam_view'])?$_REQUEST['exam_view']:0,
												"delete"=>isset($_REQUEST['exam_delete'])?$_REQUEST['exam_delete']:0
									  ],
									  
									  
										"hostel"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/hostel.png'),
										'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/hostel.png'),
												 "menu_title"=>'Hostel',
												 "page_link"=>'hostel',
												 "own_data" => isset($_REQUEST['hostel_own_data'])?$_REQUEST['hostel_own_data']:0,
												 "add" => isset($_REQUEST['hostel_add'])?$_REQUEST['hostel_add']:0,
												"edit"=>isset($_REQUEST['hostel_edit'])?$_REQUEST['hostel_edit']:0,
												"view"=>isset($_REQUEST['hostel_view'])?$_REQUEST['hostel_view']:0,
												"delete"=>isset($_REQUEST['hostel_delete'])?$_REQUEST['hostel_delete']:0
									  ],
										"homework"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/homework.png'),
										'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/homework.png'),
												 "menu_title"=>'Home Work',
												 "page_link"=>'homework',
												 "own_data" => isset($_REQUEST['homework_own_data'])?$_REQUEST['homework_own_data']:1,
												 "add" => isset($_REQUEST['homework_add'])?$_REQUEST['homework_add']:0,
												"edit"=>isset($_REQUEST['homework_edit'])?$_REQUEST['homework_edit']:0,
												"view"=>isset($_REQUEST['homework_view'])?$_REQUEST['homework_view']:0,
												"delete"=>isset($_REQUEST['homework_delete'])?$_REQUEST['homework_delete']:0
									  ],
										"manage_marks"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/mark-manage.png'),
										'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/mark-manage.png'),
												  "menu_title"=>'Mark Manage',
												  "page_link"=>'manage_marks',
												 "own_data" => isset($_REQUEST['manage_marks_own_data'])?$_REQUEST['manage_marks_own_data']:0,
												 "add" => isset($_REQUEST['manage_marks_add'])?$_REQUEST['manage_marks_add']:0,
												"edit"=>isset($_REQUEST['manage_marks_edit'])?$_REQUEST['manage_marks_edit']:0,
												"view"=>isset($_REQUEST['manage_marks_view'])?$_REQUEST['manage_marks_view']:0,
												"delete"=>isset($_REQUEST['manage_marks_delete'])?$_REQUEST['manage_marks_delete']:0
									  ],
									  
									  "feepayment"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/fee.png'),
									  'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/fee_payment.png'),
												 "menu_title"=>'Fee Payment',
												 "page_link"=>'feepayment',
												 "own_data" => isset($_REQUEST['feepayment_own_data'])?$_REQUEST['feepayment_own_data']:1,
												 "add" => isset($_REQUEST['feepayment_add'])?$_REQUEST['feepayment_add']:0,
												"edit"=>isset($_REQUEST['feepayment_edit'])?$_REQUEST['feepayment_edit']:0,
												"view"=>isset($_REQUEST['feepayment_view'])?$_REQUEST['feepayment_view']:0,
												"delete"=>isset($_REQUEST['feepayment_delete'])?$_REQUEST['feepayment_delete']:0
									  ],
									  
									  "payment"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/payment.png'),
									  'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/payment.png'),
												 "menu_title"=>'Payment',
												 "page_link"=>'payment',
												 "own_data" => isset($_REQUEST['payment_own_data'])?$_REQUEST['payment_own_data']:1,
												 "add" => isset($_REQUEST['payment_add'])?$_REQUEST['payment_add']:0,
												"edit"=>isset($_REQUEST['payment_edit'])?$_REQUEST['payment_edit']:0,
												"view"=>isset($_REQUEST['payment_view'])?$_REQUEST['payment_view']:0,
												"delete"=>isset($_REQUEST['payment_delete'])?$_REQUEST['payment_delete']:0
									  ],
									  "transport"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/transport.png'),
									  'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/transport.png'),
											   "menu_title"=>'Transport',
											   "page_link"=>'transport',
												 "own_data" => isset($_REQUEST['transport_own_data'])?$_REQUEST['transport_own_data']:0,
												 "add" => isset($_REQUEST['transport_add'])?$_REQUEST['transport_add']:0,
												"edit"=>isset($_REQUEST['transport_edit'])?$_REQUEST['transport_edit']:0,
												"view"=>isset($_REQUEST['transport_view'])?$_REQUEST['transport_view']:0,
												"delete"=>isset($_REQUEST['transport_delete'])?$_REQUEST['transport_delete']:0
									  ],
									  "notice"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/notice.png'),
									  'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/notice.png'),
												  "menu_title"=>'Notice Board',
												  "page_link"=>'notice',
												 "own_data" => isset($_REQUEST['notice_own_data'])?$_REQUEST['notice_own_data']:0,
												 "add" => isset($_REQUEST['notice_add'])?$_REQUEST['notice_add']:0,
												"edit"=>isset($_REQUEST['notice_edit'])?$_REQUEST['notice_edit']:0,
												"view"=>isset($_REQUEST['notice_view'])?$_REQUEST['notice_view']:0,
												"delete"=>isset($_REQUEST['notice_delete'])?$_REQUEST['notice_delete']:0
									  ],
									  "message"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/message.png'),
									  'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/message.png'),
												"menu_title"=>'Message',
												"page_link"=>'message',
												 "own_data" => isset($_REQUEST['message_own_data'])?$_REQUEST['message_own_data']:1,
												 "add" => isset($_REQUEST['message_add'])?$_REQUEST['message_add']:0,
												"edit"=>isset($_REQUEST['message_edit'])?$_REQUEST['message_edit']:0,
												"view"=>isset($_REQUEST['message_view'])?$_REQUEST['message_view']:0,
												"delete"=>isset($_REQUEST['message_delete'])?$_REQUEST['message_delete']:0
									  ],
									  "holiday"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/holiday.png'),
									   'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/holiday.png'),
												 "menu_title"=>'Holiday',
												 "page_link"=>'holiday',
												 "own_data" => isset($_REQUEST['holiday_own_data'])?$_REQUEST['holiday_own_data']:0,
												 "add" => isset($_REQUEST['holiday_add'])?$_REQUEST['holiday_add']:0,
												"edit"=>isset($_REQUEST['holiday_edit'])?$_REQUEST['holiday_edit']:0,
												"view"=>isset($_REQUEST['holiday_view'])?$_REQUEST['holiday_view']:0,
												"delete"=>isset($_REQUEST['holiday_delete'])?$_REQUEST['holiday_delete']:0
									  ],
									  
									   "library"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/library.png'),
									   'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/library.png'),
											   "menu_title"=>'Library',
											   "page_link"=>'library',
												 "own_data" => isset($_REQUEST['library_own_data'])?$_REQUEST['library_own_data']:1,
												 "add" => isset($_REQUEST['library_add'])?$_REQUEST['library_add']:0,
												"edit"=>isset($_REQUEST['library_edit'])?$_REQUEST['library_edit']:0,
												"view"=>isset($_REQUEST['library_view'])?$_REQUEST['library_view']:0,
												"delete"=>isset($_REQUEST['library_delete'])?$_REQUEST['library_delete']:0
									  ],
									  
									   "account"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/account.png'),
									   'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/account.png'),
												"menu_title"=>'Account',
												"page_link"=>'account',
												 "own_data" => isset($_REQUEST['account_own_data'])?$_REQUEST['account_own_data']:1,
												 "add" => isset($_REQUEST['account_add'])?$_REQUEST['account_add']:0,
												"edit"=>isset($_REQUEST['account_edit'])?$_REQUEST['account_edit']:0,
												"view"=>isset($_REQUEST['account_view'])?$_REQUEST['account_view']:0,
												"delete"=>isset($_REQUEST['account_delete'])?$_REQUEST['account_delete']:0
									  ],
									  
									   "report"=>['menu_icone'=>plugins_url( 'school-management/assets/images/icons/report.png'),
									   'app_icone'=>plugins_url( 'school-management/assets/images/icons/app_icon/report.png'),							       
												 "menu_title"=>'Report',
												 "page_link"=>'report',
												 "own_data" => isset($_REQUEST['report_own_data'])?$_REQUEST['report_own_data']:0,
												 "add" => isset($_REQUEST['report_add'])?$_REQUEST['report_add']:0,
												"edit"=>isset($_REQUEST['report_edit'])?$_REQUEST['report_edit']:0,
												"view"=>isset($_REQUEST['report_view'])?$_REQUEST['report_view']:0,
												"delete"=>isset($_REQUEST['report_delete'])?$_REQUEST['report_delete']:0
									  ]

									];

	$result=update_option( 'smgt_access_right_student',$role_access_right);
	wp_redirect ( admin_url() . 'admin.php?page=smgt_access_right&tab=Student&message=1');
}
$access_right=get_option('smgt_access_right_student');
?>	
<div class="panel panel-white"><!--- PANEL WHITE DIV START -->
		<h2>
			<?php echo esc_html( __( 'Student Access Right', 'school-mgt')); ?>
		</h2>			
		<div class="panel-body"> <!--- PANEL BODY DIV START -->
			<form name="student_form" action="" method="post" class="form-horizontal" id="access_right_form">	
				<div class="row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15"><?php _e('Menu','school-mgt');?></div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 "><?php _e('OwnData','school-mgt');?></div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 "><?php _e('View','school-mgt');?></div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15"><?php _e('Add','school-mgt');?></div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15"><?php _e('Edit','school-mgt');?></div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15"><?php _e('Delete ','school-mgt');?></div>
				</div>
				<div class="access_right_menucroll row border_bottom_0">
					<!-- Teacher module code  -->
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label menu_left_6">
								<?php _e('Teacher','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['teacher']['own_data'],1);?> value="1" name="teacher_own_data">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['teacher']['view'],1);?> value="1" name="teacher_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['teacher']['add'],1);?> value="1" name="teacher_add" disabled >	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['teacher']['edit'],1);?> value="1" name="teacher_edit" disabled >	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['teacher']['delete'],1);?> value="1" name="teacher_delete" disabled >	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Teacher module code end -->
					
					<!-- Student module code  -->							
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Student','school-mgt');?>
							</span>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['student']['own_data'],1);?> value="1" name="student_own_data">	              
								</label>
							</div>
						</div>								
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['student']['view'],1);?> value="1" name="student_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['student']['add'],1);?> value="1" name="student_add" disabled >	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['student']['edit'],1);?> value="1" name="student_edit" disabled >	              
								</label>
							</div>
						</div>								
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['student']['delete'],1);?> value="1" name="student_delete" disabled >	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Student module code  -->
					
					<!-- Parent module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Parent','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['parent']['own_data'],1);?> value="1" name="parent_own_data">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['parent']['view'],1);?> value="1" name="parent_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['parent']['add'],1);?> value="1" name="parent_add" disabled >	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['parent']['edit'],1);?> value="1" name="parent_edit" disabled >	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['parent']['delete'],1);?> value="1" name="parent_delete" disabled >	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Parent module code end -->
					
					<!-- Subject module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Subject','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['subject']['own_data'],1);?> value="1" name="subject_own_data">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['subject']['view'],1);?> value="1" name="subject_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['subject']['add'],1);?> value="1" name="subject_add" disabled >	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['subject']['edit'],1);?> value="1" name="subject_edit" disabled >	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['subject']['delete'],1);?> value="1" name="subject_delete" disabled >	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Subject module code end -->
					<!-- Class Routine module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Class Routine','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['schedule']['own_data'],1);?> value="1" name="schedule_own_data" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['schedule']['view'],1);?> value="1" name="schedule_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['schedule']['add'],1);?> value="1" name="schedule_add" disabled >	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['schedule']['edit'],1);?> value="1" name="schedule_edit" disabled>	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['schedule']['delete'],1);?> value="1" name="schedule_delete" disabled>	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Class Routine module code end -->
					<!-- Attendance module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Attendance','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['attendance']['own_data'],1);?> value="1" name="attendance_own_data" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['attendance']['view'],1);?> value="1" name="attendance_view" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['attendance']['add'],1);?> value="1" name="attendance_add" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['attendance']['edit'],1);?> value="1" name="attendance_edit" disabled>	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['attendance']['delete'],1);?> value="1" name="attendance_delete" disabled>	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Attendance module code end -->
					<!-- Exam module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Exam','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['exam']['own_data'],1);?> value="1" name="exam_own_data">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['exam']['view'],1);?> value="1" name="exam_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['exam']['add'],1);?> value="1" name="exam_add" disabled >	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['exam']['edit'],1);?> value="1" name="exam_edit" disabled >	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['exam']['delete'],1);?> value="1" name="exam_delete" disabled >	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Exam module code end -->
					<!-- Hostel module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Hostel','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['hostel']['own_data'],1);?> value="1" name="hostel_own_data" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['hostel']['view'],1);?> value="1" name="hostel_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['hostel']['add'],1);?> value="1" name="hostel_add" disabled >	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['hostel']['edit'],1);?> value="1" name="hostel_edit" disabled >	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['hostel']['delete'],1);?> value="1" name="hostel_delete" disabled >	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Hostel module code end -->
					<!-- Home Work module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Home Work','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['homework']['own_data'],1);?> value="1" name="homework_own_data" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['homework']['view'],1);?> value="1" name="homework_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['homework']['add'],1);?> value="1" name="homework_add" disabled >	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['homework']['edit'],1);?> value="1" name="homework_edit" disabled >	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['homework']['delete'],1);?> value="1" name="homework_delete" disabled >	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Home Work module code end -->
					<!-- Manage Marks module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Manage Marks','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['manage_marks']['own_data'],1);?> value="1" name="manage_marks_own_data" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['manage_marks']['view'],1);?> value="1" name="manage_marks_view" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['manage_marks']['add'],1);?> value="1" name="manage_marks_add" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['manage_marks']['edit'],1);?> value="1" name="manage_marks_edit" disabled>	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['manage_marks']['delete'],1);?> value="1" name="manage_marks_delete" disabled>	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Manage Marks module code end -->
					<!-- Fee Payment module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Fee Payment','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['feepayment']['own_data'],1);?> value="1" name="feepayment_own_data" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['feepayment']['view'],1);?> value="1" name="feepayment_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['feepayment']['add'],1);?> value="1" name="feepayment_add" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['feepayment']['edit'],1);?> value="1" name="feepayment_edit" disabled>	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['feepayment']['delete'],1);?> value="1" name="feepayment_delete" disabled>	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Fee Payment module code end -->
					<!-- Payment module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
							<span class="menu-label">
								<?php _e('Payment','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['payment']['own_data'],1);?> value="1" name="payment_own_data" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['payment']['view'],1);?> value="1" name="payment_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['payment']['add'],1);?> value="1" name="payment_add" disabled >	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['payment']['edit'],1);?> value="1" name="payment_edit" disabled >	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['payment']['delete'],1);?> value="1" name="payment_delete" disabled >	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Payment module code end -->
					<!-- Transport module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Transport','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['transport']['own_data'],1);?> value="1" name="transport_own_data" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['transport']['view'],1);?> value="1" name="transport_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['transport']['add'],1);?> value="1" name="transport_add" disabled >	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['transport']['edit'],1);?> value="1" name="transport_edit" disabled >	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['transport']['delete'],1);?> value="1" name="transport_delete" disabled >	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Transport module code end -->
					<!-- Notice Board module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Notice Board','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['notice']['own_data'],1);?> value="1" name="notice_own_data">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['notice']['view'],1);?> value="1" name="notice_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['notice']['add'],1);?> value="1" name="notice_add" disabled >	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['notice']['edit'],1);?> value="1" name="notice_edit" disabled >	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['notice']['delete'],1);?> value="1" name="notice_delete" disabled >	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Notice Board module code end -->
					<!-- Message module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Message','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['message']['own_data'],1);?> value="1" name="message_own_data" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['message']['view'],1);?> value="1" name="message_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['message']['add'],1);?> value="1" name="message_add" >	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['message']['edit'],1);?> value="1" name="message_edit" disabled>	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['message']['delete'],1);?> value="1" name="message_delete" >	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Message module code end -->
					<!-- Holiday module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Holiday','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['holiday']['own_data'],1);?> value="1" name="holiday_own_data" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['holiday']['view'],1);?> value="1" name="holiday_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['holiday']['add'],1);?> value="1" name="holiday_add" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['holiday']['edit'],1);?> value="1" name="holiday_edit" disabled>	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['holiday']['delete'],1);?> value="1" name="holiday_delete" disabled>	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Holiday module code end -->
					<!-- Library module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Library','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['library']['own_data'],1);?> value="1" name="library_own_data" disabled> 	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['library']['view'],1);?> value="1" name="library_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['library']['add'],1);?> value="1" name="library_add" disabled >	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['library']['edit'],1);?> value="1" name="library_edit" disabled >	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['library']['delete'],1);?> value="1" name="library_delete" disabled >	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Library module code end -->
					
					<!-- Account module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Account','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['account']['own_data'],1);?> value="1" name="account_own_data" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['account']['view'],1);?> value="1" name="account_view">	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['account']['add'],1);?> value="1" name="account_add" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['account']['edit'],1);?> value="1" name="account_edit" disabled>	              
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['account']['delete'],1);?> value="1" name="account_delete" disabled >	              
								</label>
							</div>
						</div>								
					</div>							
					<!-- Account module code end -->
					<!-- Report module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Report','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['report']['own_data'],1);?> value="1" name="report_own_data" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['report']['view'],1);?> value="1" name="report_view" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['report']['add'],1);?> value="1" name="report_add" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['report']['edit'],1);?> value="1" name="report_edit" disabled>
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['report']['delete'],1);?> value="1" name="report_delete" disabled>
								</label>
							</div>
						</div>								
					</div>							
					<!-- Report module code end -->	

					<!-- Virtual Classroom module code  -->					
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<span class="menu-label">
								<?php _e('Virtual Classroom','school-mgt');?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['virtual_classroom']['own_data'],1);?> value="1" name="virtual_classroom_own_data" disabled>	              
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['virtual_classroom']['view'],1);?> value="1" name="virtual_classroom_view">
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_10">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['virtual_classroom']['add'],1);?> value="1" name="virtual_classroom_add" disabled>	              
								</label>
							</div>
						</div> 
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['virtual_classroom']['edit'],1);?> value="1" name="virtual_classroom_edit" disabled>
								</label>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left_15">
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo checked($access_right['student']['virtual_classroom']['delete'],1);?> value="1" name="virtual_classroom_delete" disabled>
								</label>
							</div>
						</div>								
					</div>							
					<!-- Virtual Classroom module code end -->	
														
				</div>						
				<div class="col-sm-8 row_bottom">	
					<input type="submit" value="<?php _e('Save', 'school-mgt' ); ?>" name="save_access_right" class="btn btn-success"/>
				</div>					
			</form>
		</div><!---END PANEL BODY DIV -->
</div> <!--- END PANEL WHITE DIV -->   