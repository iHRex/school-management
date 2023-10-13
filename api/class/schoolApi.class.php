<?php 

if ( ! class_exists( 'SchoolApi' ) )
{

class SchoolApi

{
	public function load()

	{

		$this->activateStudentRegistrationAPI();


		$this->activateStudentListingAPI();



		$this->activateSchoolLoginAPI();



		$this->activateTeacherListAPI();



		$this->activateAddGradesAPI();



		$this->activateClassRoutinAPI();



		$this->activateGradeListAPI();



		$this->activateGradeDeleteAPI();



		$this->activateGradeEditAPI();



		$this->activateHomeworkAddAPI();



		$this->activateHomeworkListingAPI();



		$this->activateHomeworkEditAPI();



		$this->activateHomeworkDeleteAPI();



		$this->activateHomeworkSubmissionAPI();



		$this->activateHomeworkviewAPI();



		$this->activateChangePasswordAPI();



		$this->activateResultViewAPI();



		$this->activateAddMarksAPI();



		$this->activateEditMarksAPI();



		$this->activateActivityListAPI();



		$this->activateExamListAPI();



		$this->activateActivityStudentListAPI();



		$this->activateActivityStudentAuthoriseAPI();



		$this->activateViewActivityStudentAPI();



		$this->activateAddActivityAPI();



		$this->activateEditActivityAPI();



		$this->activateDeleteActivityAPI();



		$this->activateTeacherRoutineAPI();



		$this->activateParentListAPI();



		$this->activateSupportStaffListAPI();



		$this->activateClassListAPI();



		$this->activateSubjectListAPI();



		$this->activateAddSubjectAPI();



		$this->activateSaveAttendanceAPI();



		$this->activateTransportAPI();



		$this->activateHallAPI();



		$this->activateNoticeAPI();



		$this->activateHolidayAPI();



		$this->activateMessageAPI();



		$this->activatePaymentAPI();



		$this->activateFeePaymentAPI();



		$this->activateLibraryAPI();



		$this->activateViewProfileAPI();



		$this->activateCircularAPI();

		$this->activateQuizzesAPI();
		
		$this->AllUserListingAPI();
		
		$this->UserAccountantAPI();
		
		$this->UserReadStatusAPI();


		$this->activateNotificationUpdateAPI();
		

		$this->classAccessRigthsAPI();
		
		
		$this->activateHostelListAPI();

		$this->activateVirtualclasslistAPI();

	}

	function activateStudentRegistrationAPI()
	{

		$stud_register=new StudentRegistration;

	}


	function activateStudentListingAPI()
	{

		$stud_listing=new StudentListing;

	}


	function activateSchoolLoginAPI(){



		$school_login=new SchoolLogin;



	}



	function activateTeacherListAPI(){



		$teacher_register=new TeacherListing;



	}



	function activateAddGradesAPI(){	



		$addgrade=new AddGrades;	



	}



	function activateClassRoutinAPI(){



		$class_routine=new ClassRoutine;



	}	



	function activateGradeListAPI(){



		$grade_list=new GradesList;



	}	



	function activateGradeDeleteAPI(){



		$grade_delete=new GradesDelete;



	}



	function activateGradeEditAPI(){



		$grade_edit=new EditGrades;



	}



	function activateHomeworkAddAPI(){



		$homework_add=new AddHomework;



	}



	function activateHomeworkListingAPI(){



		$homework_list=new HomeworkListing;



	}



	function activateHomeworkEditAPI(){



		$homework_edit=new EditHomework;



	}



	function activateHomeworkDeleteAPI(){



		$homework_delete=new HomeworkDelete;



	}



	function activateHomeworkSubmissionAPI(){



		$homework_submission=new HomeworkSubmissionListing;



	}



	function activateHomeworkviewAPI(){



		$homework_view=new HomeworkView;



	}



	function activateChangePasswordAPI(){



		$change_pass=new ChangePassword;



	}



	function activateResultViewAPI(){



		$result_view=new StudentResult;



	}



	function activateAddMarksAPI(){



		$add_marks=new AddMarks;



	}



	function activateEditMarksAPI(){



		$edit_marks=new EditMarks;



	}



	function activateActivityListAPI(){



		$activity_list=new ActivityListing;



	}



	function activateExamListAPI(){



		$exam_list=new ExamList;



	}



	function activateActivityStudentListAPI(){



		$activityStudent_list=new ActivityStudentListing;



	}



	function activateActivityStudentAuthoriseAPI(){



		$activityStudent_autho=new ActivityStudentAuthorise;



	}



	function activateViewActivityStudentAPI(){



		$viewActivityStudent=new ViewActivityStudent;



	}



	function activateAddActivityAPI(){



		$addActivity=new AddActivity;



	}



	function activateEditActivityAPI(){



		$editActivity=new EditActivity;



	}



	function activateDeleteActivityAPI(){



		$deleteActivity=new ActivityDelete;



	}



	function activateTeacherRoutineAPI(){



		$teacheRoutine=new TeacherRoutine;



	}



	function activateParentListAPI(){



		$parentlist=new ParentListing;



	}



	function activateSupportStaffListAPI(){



		$supportstafflist=new SupportListing;



	}



	function activateClassListAPI(){



		$classlist=new ClassListing;



	}



	function activateSubjectListAPI(){



		$subjectlist=new SubjectListing;



	}



	function activateAddSubjectAPI(){



		$addsubject=new AddSubject;



	}



	function activateSaveAttendanceAPI(){



		$attendance_obj=new Attendance;



	}



	function activateTransportAPI(){



		$transport_obj=new TransportClass;



	}



	function activateHallAPI(){



		$hall_obj=new HallClass;



	}



	function activateNoticeAPI(){



		$notice_obj=new NoticeClass;



	}



	function activateHolidayAPI(){



		$holiday_obj=new HolidayClass;



	}



	function activateMessageAPI(){



		$message_obj=new MessageClass;



	}



	function activatePaymentAPI(){



		$payment_obj=new PaymentClass;



	}



	function activateFeePaymentAPI(){



		$feepayment_obj=new FeePaymentClass;



	}



	function activateLibraryAPI()
	{


		$library_obj=new LibraryClass;


	}



	function activateViewProfileAPI(){



		$viewprofile_obj=new ViewProfile;



	}



	function activateCircularAPI(){



		$circular_obj=new Circulars;



	}

function activateHostelListAPI(){



		$hostel_obj=new Hostel;



	}

function activateVirtualclasslistAPI(){



		$virtualclass_obj=new Virtualclass_list;



	}



	



	function activateQuizzesAPI(){



		$quizzes_obj=new QuizzesClass;



	}
	
	function AllUserListingAPI(){
		$AllUserListing_obj=new AllUserListing;
	}
	
	function UserAccountantAPI(){
		$UserAccountant_obj=new UserAccountantAPI;
	}
	
	function UserReadStatusAPI()
	{
		$ReadStatusAPI_Obj = new UserReadStatusAPI();
	}
	
	function activateNotificationUpdateAPI()
	{
		$Notificationupdate=new Notification;
	}


	function classAccessRigthsAPI()
	{
		$ClassAccessRigths = new ClassAccessRigths;
	}

}

}

 ?>