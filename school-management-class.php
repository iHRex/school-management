<?php	
class School_Management
{
	public $student;
	public $teacher;
	public $exam;
	public $result;
	public $subject;
	public $schedule;
	public $transport;
	public $notice;
	public $message;
	public $role;
	public $class_info;
	public $parent_list;
	public $child_list;
	public $payment;
	public $feepayment;
	public $class_section;
	
	function __construct($user_id = NULL)
	{
		if($user_id)
		{
			
			if($this->get_current_user_role($user_id) == 'student')
			{
			
				$this->role= "student";
				$this->class_info = $this->get_user_class_id($user_id);
			
				$this->class_section_info = $this->get_user_class_id($user_id);
				$this->subject = $this->subject_list($this->class_info->class_id);
				
				$this->parent_list = $this->parants($user_id);
				 
				$this->student = $this->get_student_list($this->class_info->class_id);
				$this->payment_list = $this->payment('student');
				
				
				//$this->notice = $this->notice_board_student($user_id,$this->get_current_user_role());
				$this->notice = $this->notice_board($this->get_current_user_role());
			}
			if($this->get_current_user_role($user_id) == 'teacher')
			{
				$this->role= "teacher";
				$teacher_access = get_option( 'smgt_access_right_teacher');
				$teacher_access_data=$teacher_access['teacher'];
				foreach($teacher_access_data as $key=>$value)
				{
					if($key=='student')
					{
						$data=$value;
					}
				}
				if($data['own_data']=='1')
				{
					$class_id=get_user_meta($user_id,'class_name',true);
					$this->student =$this->get_teacher_student_list($class_id);
				}
				else
					$this->student = $this->get_all_student_list();
					$this->notice = $this->notice_board($this->get_current_user_role());
			}
			if($this->get_current_user_role($user_id) == 'supportstaff')
			{
				$this->role= "supportstaff";
				$this->student = $this->get_all_student_list();
				$this->notice = $this->notice_board($this->get_current_user_role());
				$this->payment_list = $this->payment('supportstaff');
			}
			
			if($this->get_current_user_role($user_id) == 'parent')
			{
				
				$this->role="parent";
				$this->child_list = $this->child($user_id);
				$this->student =$this->get_all_student_list();
				$this->payment_list = $this->payment('parent');
				$this->notice = $this->notice_board($this->get_current_user_role());
			}
			if($this->get_current_user_role($user_id) == 'administrator')
			{
				$this->role= "admin";
			}
			//$this->notice = $this->notice_board($this->get_current_user_role());
			$this->payment = $this->payment($this->get_current_user_role());
			$this->feepayment = $this->feepayment($this->get_current_user_role());
		}
	}

	public function get_current_user_role($userid=0) {
		if($userid!=0)
		{
			$current_user=get_userdata($userid);
			$user_roles = $current_user->roles;
		}
		else
		{
			global $current_user;
			$user_roles = $current_user->roles;
		}
		$user_role = array_shift($user_roles);
		
		return $user_role;
	}
	
	public function get_user_class_id($user_id)
	{
		$user =get_userdata( $user_id );
		$user_meta =get_user_meta($user_id);
		$class_id = $user_meta['class_name'][0];
		global $wpdb;
		$table_name = $wpdb->prefix .'smgt_class';
		$class_info =$wpdb->get_row("SELECT * FROM $table_name WHERE class_id=".$class_id);
		return $class_info;
	}
	public function get_user_sectio_id($user_id)
	{
		$user =get_userdata( $user_id );
		$user_meta =get_user_meta($user_id);
		$section_id = $user_meta['class_section'][0];
		global $wpdb;
		$table_name = $wpdb->prefix .'smgt_class_section';
		$section_info =$wpdb->get_row("SELECT * FROM $table_name WHERE id=".$class_id);
		return $section_info;
	}
	
	public function subject_list($class_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix .'subject';
		
		$result =$wpdb->get_results("SELECT * FROM $table_name WHERE class_id=".$class_id);
		return $result;
	}
	
	public function subject_list_with_calss_and_section($class_id,$section_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix .'subject';
		
		$result =$wpdb->get_results("SELECT * FROM $table_name WHERE class_id=$class_id and section_id=".$section_id);
		return $result;
	}
	
	
	public function notice_board($role,$limit = -1)
	{
	  
		$args['post_type'] = 'notice';
		$args['posts_per_page'] = $limit;
		$args['post_status'] = 'public';
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
		
		
		$retrieve_noticeData1=array();
			if($role=='student')				   
			{				
				$class_id=get_user_meta(get_current_user_id(),'class_name',true);
				$section_id=get_user_meta(get_current_user_id(),'class_section',true);				
				$args['meta_query'] = array(
					'relation' => 'OR',
						/*array(
							'key' => 'notice_for',
							'value' =>'student',	
							'compare' => '='
						),*/
						array(
							'relation' => 'OR',
								array(
									'key' => 'smgt_section_id',
									'value' =>get_user_meta(get_current_user_id(),'class_section',true),	
									'compare' => '='
								),
								array(
									'key' => 'smgt_class_id',
									'value' =>get_user_meta(get_current_user_id(),'class_name',true),
									'compare' => '='
								)
						)
				);
					$q = new WP_Query();
					$retrieve_class_notice = $q->query( $args );	
					//$retrieve_notice = $q->query( $args );	
					foreach($retrieve_class_notice as $notice)
					{
						$retrieve_noticeData1[]=$notice->ID;
					}
						//var_dump($retrieve_noticeData1);
						$retrieve_notice=$retrieve_noticeData1;
						
						/*$args = array(
							'meta_key' => 'notice_for',
							'meta_value' => 'student',
							'post_type' => 'notice');
					$retrieve_student_notice = get_posts($args);
					//$retrieve_noticeData=array_merge($retrieve_student_notice,$retrieve_noticeData1);	
					
					
					//$args['meta_query'] = array('key' => 'notice_for',
							//			'value' =>"student");	
						//$q = new WP_Query();
						//$retrieve_student_notice = $q->query( $args );	
						foreach($retrieve_student_notice as $notice)
						{
							$retrieve_noticeData1[]=$notice->ID;
						}
						//var_dump($retrieve_noticeData1);
						$retrieve_notice=array_unique($retrieve_noticeData1);	
						/*$args=  array(  'post_type'     => 'notice',
								   'post__in'           =>    $retrieve_noticeData1
						   );
						$retrieve_noticeData =   new WP_Query( $args);
						$retrieve_noticeData=array_unique($retrieve_noticeData);
						//$retrieve_noticeDate=array_merge($retrieve_noticeDate,$retrieve_notice);	*/
						
			}
			else
			{
				$args['meta_query'] = array(
						'relation' => 'OR' /*,
						array(
							 'key' => 'notice_for',
							  'value' =>"all",						           
							  ),
							array(
									'key' => 'notice_for',
									'value' =>"$role",
							) */
					);
					$q = new WP_Query();
					$retrieve_notice = $q->query( $args );
			}
		
		//var_dump($retrieve_notice);
		//exit;
		return $retrieve_notice;
		//return $retrieve_noticeData1;
		
	}
	
	
	private function notice_board_student($user_id,$role)
	{
	   
		/* $args['post_type'] = 'notice';
		$args['posts_per_page'] = -1;
		$args['post_status'] = 'public'; */
		$class_id=get_user_meta($user_id, 'class_name',true);
		global $wpdb;
		$table_post = $wpdb->prefix .'posts';
		$table_postmeta = $wpdb->prefix .'postmeta';
		/*
		 select * FROM wp_posts as post,wp_postmeta as post_meta where post.post_type='notice' AND 
		 (post.ID=post_meta.post_id AND (post_meta.meta_key = 'notice_for' AND 
		 (post_meta.meta_value = 'student' OR post_meta.meta_value = 'all')) OR 
		 (post_meta.meta_key = 'notice_for' AND post_meta.meta_key = 'smgt_class_id' AND
		  (post_meta.meta_value = 4 OR post_meta.meta_value = 'all'))) 
		 */
		/* echo $sql="select * FROM $table_post as post,$table_postmeta as post_meta where post.post_type='notice' AND post.ID=post_meta.post_id AND 
			(post_meta.meta_key = 'notice_for' AND (post_meta.meta_value = '$role' OR post_meta.meta_value = 'all')) 
		 OR (post_meta.meta_key = 'smgt_class_id' AND (post_meta.meta_value = $class_id OR post_meta.meta_value = 'all')) Limit 0,3"; */
		$notice_limit = "";
		if(!isset($_REQUEST['page']) )
			$notice_limit = "Limit 0,3";
		$sql=" select * FROM $table_post as post,$table_postmeta as post_meta where post.post_type='notice' AND 
		 (post.ID=post_meta.post_id AND (post_meta.meta_key = 'notice_for' AND 
		 (post_meta.meta_value = '$role' OR post_meta.meta_value = 'all')) OR 
		 (post_meta.meta_key = 'notice_for' AND post_meta.meta_key = 'smgt_class_id' AND
		  (post_meta.meta_value = '$class_id' OR post_meta.meta_value = 'all'))) $notice_limit";
		/* $args['meta_query'] = array(
				'relation' => 'OR',
				array(
						'key' => 'notice_for',
						'value' =>"all",
				),
				array(
						'key' => 'notice_for',
						'value' =>"$role",
				)
		);
		$q = new WP_Query(); */
	
		$retrieve_notice = $wpdb->get_results( $sql );
		return $retrieve_notice;
	
	}
	 function notice_board_parent($role)
	{
		$args['post_type'] = 'notice';
		$args['posts_per_page'] = -1;
		$args['post_status'] = 'public';
	
		$args['meta_query'] = array(
				'relation' => 'OR',
				array(
						'key' => 'notice_for',
						'value' =>"all",
				),
				array(
						'key' => 'notice_for',
						'value' =>"$role",
				)
		);
		$q = new WP_Query();
	
		$retrieve_notice = $q->query( $args );
		return $retrieve_notice;
	
	}
	private function notice_board_teacher($role)
	{
		$args['post_type'] = 'notice';
		$args['posts_per_page'] = -1;
		$args['post_status'] = 'public';
		$class_id = "";
		$args['meta_query'] = array(
				'relation' => 'OR',
				array(
						'key' => 'notice_for',
						'value' =>"all",
				),
				array(
						'key' => 'notice_for',
						'value' =>"$role",
				)
		);
		$q = new WP_Query();
	
		$retrieve_notice = $q->query( $args );
		return $retrieve_notice;
	
	}
	
	private function payment($user_role)
	{
		global $wpdb;
		$table_name = $wpdb->prefix .'smgt_payment as p';
		$table_users = $wpdb->prefix .'users as u';
		if($user_role == 'student')
		{
			$result =$wpdb->get_results("SELECT * FROM $table_name WHERE student_id=".get_current_user_id());
		}
		else if($user_role == 'parent')
		{
			$result =$wpdb->get_results("SELECT * FROM $table_name WHERE student_id in (".implode(',', $this->child_list).")");
			
		}
		else
			$result =$wpdb->get_results("SELECT * FROM $table_name,$table_users  where p.student_id = u.id ");
						
	 	return $result;
	}
	private function feepayment($user_role)
	{
		global $wpdb;
		$table_name = $wpdb->prefix .'smgt_fees_payment as p';
		$table_users = $wpdb->prefix .'users as u';
		if($user_role == 'student')
		{
			$result =$wpdb->get_results("SELECT * FROM $table_name WHERE student_id=".get_current_user_id());
		}
		else if($user_role == 'parent')
		{
			$result =$wpdb->get_results("SELECT * FROM $table_name WHERE student_id in (".implode(',', $this->child_list).")");
		}
		else
		{
			$result =$wpdb->get_results("SELECT * FROM $table_name,$table_users  where p.student_id = u.id ");
		}
		
	 	return $result;
	}
	public function get_teacher_student_list($class_id)
	{
		$exlude_id = smgt_approve_student_list();
		$students = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
		return $students;
	}
	public function get_student_list($class_id)
	{
		$exlude_id = smgt_approve_student_list();
		$student_access = get_option( 'smgt_access_right_student');
		
		$student_access_data=$student_access['student'];
		foreach($student_access_data as $key=>$value)
		{
			if($key=='student')
			{
				$data=$value;
			}
		}
		if($this->role == 'student' && $data['own_data']=='1')
		{
			$students = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id, 'role'=>'student','exclude'=>$exlude_id));
		}
		else{
			$students = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id, 'role'=>'student','exclude'=>$exlude_id));
		}
		return $students;
	}
	public function get_all_student_list()
	{
		$exlude_id = smgt_approve_student_list();
		$students = get_users(array('role'=>'student','exclude'=>$exlude_id));
		return $students;
	}
	private function parants($user_id)
	{
		
		$user_meta =get_user_meta($user_id, 'parent_id', true);
		return $user_meta;
	}
	private function child($user_id)
	{
		$user_meta =get_user_meta($user_id, 'child', true);
		return $user_meta;
	}
	
}
?>