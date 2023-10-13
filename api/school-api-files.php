<?php 

require_once SMS_PLUGIN_DIR. "/api/class/schoolApi.class.php";

require_once SMS_PLUGIN_DIR. "/api/class/student-registration.php";

require_once SMS_PLUGIN_DIR. "/api/class/student-listing.php";

require_once SMS_PLUGIN_DIR. "/api/class/school-login.php";

require_once SMS_PLUGIN_DIR. "/api/class/teacher-listing.php";

require_once SMS_PLUGIN_DIR. "/api/class/class-routine.php";

require_once SMS_PLUGIN_DIR. "/api/class/add-grades.php";

require_once SMS_PLUGIN_DIR. "/api/class/grades-list.php";

require_once SMS_PLUGIN_DIR. "/api/class/delete-grade.php";

require_once SMS_PLUGIN_DIR. "/api/class/edit-grades.php";

require_once SMS_PLUGIN_DIR. "/api/class/add-homework.php";

require_once SMS_PLUGIN_DIR. "/api/class/homework-listing.php";

require_once SMS_PLUGIN_DIR. "/api/class/edit-homework.php";

require_once SMS_PLUGIN_DIR. "/api/class/delete-homework.php";

require_once SMS_PLUGIN_DIR. "/api/class/homework-submission-listing.php";

require_once SMS_PLUGIN_DIR. "/api/class/view-homework.php";

require_once SMS_PLUGIN_DIR. "/api/class/change-password.php";

require_once SMS_PLUGIN_DIR. "/api/class/student-result.php";

require_once SMS_PLUGIN_DIR. "/api/class/add-marks.php";

require_once SMS_PLUGIN_DIR. "/api/class/edit-marks.php";

require_once SMS_PLUGIN_DIR. "/api/class/activity-listing.php";

require_once SMS_PLUGIN_DIR. "/api/class/examlist.php";

require_once SMS_PLUGIN_DIR. "/api/class/activity-students-listing.php";

require_once SMS_PLUGIN_DIR. "/api/class/activity-students-authorise.php";

require_once SMS_PLUGIN_DIR. "/api/class/view-students-activity.php";

require_once SMS_PLUGIN_DIR. "/api/class/add-activity.php";

require_once SMS_PLUGIN_DIR. "/api/class/edit-activity.php";

require_once SMS_PLUGIN_DIR. "/api/class/delete-activity.php";

require_once SMS_PLUGIN_DIR. "/api/class/teacher-routine.php";

require_once SMS_PLUGIN_DIR. "/api/class/parent-listing.php";

require_once SMS_PLUGIN_DIR. "/api/class/supportstaff-listing.php";

require_once SMS_PLUGIN_DIR. "/api/class/class-listing.php";

require_once SMS_PLUGIN_DIR. "/api/class/subject-listing.php";

require_once SMS_PLUGIN_DIR. "/api/class/add-subject.php";

require_once SMS_PLUGIN_DIR. "/api/class/add-subject.php";

require_once SMS_PLUGIN_DIR. "/api/class/attendance.php";

require_once SMS_PLUGIN_DIR. "/api/class/transport.php";

require_once SMS_PLUGIN_DIR. "/api/class/hall.php";

require_once SMS_PLUGIN_DIR. "/api/class/notice.php";

require_once SMS_PLUGIN_DIR. "/api/class/holiday.php";

require_once SMS_PLUGIN_DIR. "/api/class/message.php";

require_once SMS_PLUGIN_DIR. "/api/class/payment.php";

require_once SMS_PLUGIN_DIR. "/api/class/fee-payment.php";

require_once SMS_PLUGIN_DIR. "/api/class/library.php";

require_once SMS_PLUGIN_DIR. "/api/class/view-profile.php";

require_once SMS_PLUGIN_DIR. "/api/class/circulars.php";

require_once SMS_PLUGIN_DIR. "/api/class/quizzes.php";

require_once SMS_PLUGIN_DIR. "/api/class/all-user.php";

require_once SMS_PLUGIN_DIR. "/api/class/accountant.php";

require_once SMS_PLUGIN_DIR. "/api/class/check-status.php";

require_once SMS_PLUGIN_DIR. "/api/class/notification.php";

require_once SMS_PLUGIN_DIR. "/api/class/access_right.php";

require_once SMS_PLUGIN_DIR. "/api/class/hostel.php";

require_once SMS_PLUGIN_DIR. "/api/class/virtual_class_room.php";

$school= new SchoolApi();

$school->load();	

?>