<?php 
//Subject
if($_REQUEST['from']=='sendbox')
{
	$message = get_post($_REQUEST['id']);
	smgt_change_read_status_reply($_REQUEST['id']);
	$author = $message->post_author;	
	$box='sendbox';
	if(isset($_REQUEST['delete']))
	{
		echo $_REQUEST['delete'];
		wp_delete_post($_REQUEST['id']);
		wp_safe_redirect(admin_url()."admin.php?page=smgt_message&tab=sentbox&message=2" );
		exit();
	}
}
if($_REQUEST['from']=='inbox')
{
	$message = get_message_by_id($_REQUEST['id']);
	$message1 = get_post($message->post_id);
	$author = $message1->post_author;	
	smgt_change_read_status($_REQUEST['id']);
	smgt_change_read_status_reply($message->post_id);
	$box='inbox';

	if(isset($_REQUEST['delete']))
	{
		echo $_REQUEST['delete'];
			
		delete_message('smgt_message',$_REQUEST['id']);
		wp_safe_redirect(admin_url()."admin.php?page=smgt_message&tab=inbox" );
		exit();
	}
}
if(isset($_POST['replay_message']))
{
	$message_id=$_REQUEST['id'];
	$message_from=$_REQUEST['from'];
	
	$result=smgt_send_replay_message($_POST);
	if($result)
		wp_safe_redirect(admin_url()."admin.php?page=smgt_message&tab=view_message&from=".$message_from."&id=$message_id&message=1" );
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete-reply')
{
	$message_id=$_REQUEST['id'];
	$message_from=$_REQUEST['from'];
	$result=smgt_delete_reply($_REQUEST['reply_id']);
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_message&tab=view_message&action=delete-reply&from='.$message_from.'&id='.$message_id.'&message=2');
	}
}
?>
<script>
jQuery(document).ready(function()
{
	jQuery('#message-replay').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	jQuery('span.timeago').timeago();
	jQuery("body").on("change", ".input-file[type=file]", function ()
	{ 
		"use strict";
		var file = this.files[0]; 		
		var ext = $(this).val().split('.').pop().toLowerCase(); 
		//Extension Check 
		if($.inArray(ext, [,'pdf','doc','docx','xls','xlsx','ppt','pptx','gif','png','jpg','jpeg']) == -1)
		{
			  alert('<?php _e("Only pdf,doc,docx,xls,xlsx,ppt,pptx,gif,png,jpg,jpeg formate are allowed. '  + ext + ' formate are not allowed.","school-mgt") ?>');
			$(this).replaceWith('<input class="btn_top input-file" name="message_attachment[]" type="file" />');
			return false; 
		} 
		//File Size Check 
		if (file.size > 20480000) 
		{
			alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','school-mgt');?>");
			$(this).replaceWith('<input class="btn_top input-file" name="message_attachment[]" type="file" />'); 
			return false; 
		}
	});
	
});
function add_new_attachment()
{
	$(".attachment_div").append('<div class="form-group" ><label class="col-sm-2 control-label" for="photo"><?php _e('Attachment ','school-mgt');?></label><div class="col-sm-3" style="margin-bottom: 5px;"><input  class="btn_top input-file" name="message_attachment[]" type="file" /></div><div class="col-sm-7" style="margin-bottom: 5px;"><input type="button" value="<?php _e('Delete','school-mgt');?>" onclick="delete_attachment(this)" class="remove_cirtificate doc_label btn btn-danger"></div></div>');
}
function delete_attachment(n)
{
	n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);				
}
</script>
<div class="mailbox-content">	
 	<div class="message-header">
		<h3><span><?php _e('Subject','school-mgt')?> :</span>  <?php if($box=='sendbox'){ echo $message->post_title; } else{ echo $message->subject; } ?></h3>
       
		<p class="message-date">
		<?php  		
		if($box=='sendbox')
		{ 
			$date_view=$message->post_date;
		}
		else
		{
			$date_view=$message->date;
		}
		echo convert_date_time($date_view); 
		?>
		</p>
	</div>
	<div class="message-sender">                                
    	<p>
		<?php 
		if($box=='sendbox')
		{ 
			$message_for=get_post_meta($_REQUEST['id'],'message_for',true);
			echo "From: ".get_display_name($message->post_author)."<span>&lt;".get_emailid_byuser_id($message->post_author)."&gt;</span><br>";
			
			$check_message_single_or_multiple=send_message_check_single_user_or_multiple($_REQUEST['id']);	
					
			if($check_message_single_or_multiple == 1)
			{
				global $wpdb;
				$tbl_name = $wpdb->prefix .'smgt_message';
				$post_id=$_REQUEST['id'];
				$get_single_user = $wpdb->get_row("SELECT * FROM $tbl_name where post_id = $post_id");
				
				echo "To: ".get_display_name($get_single_user->receiver)."<span>&lt;".get_emailid_byuser_id($get_single_user->receiver)."&gt;</span><br>";
			}
			else
			{				
				echo "To: ".get_post_meta($_REQUEST['id'], 'message_for',true);
			}
		} 
		else
		{ 
			echo "From: ".get_display_name($message->sender)."<span>&lt;".get_emailid_byuser_id($message->sender)."&gt;</span><br>";
			
			$check_message_single_or_multiple=send_message_check_single_user_or_multiple($message->post_id);	
					
			if($check_message_single_or_multiple == 1)
			{
				global $wpdb;
				$tbl_name = $wpdb->prefix .'smgt_message';
				$post_id=$message->post_id;
				$get_single_user = $wpdb->get_row("SELECT * FROM $tbl_name where post_id = $post_id");
				
				echo "To: ".get_display_name($get_single_user->receiver)."<span>&lt;".get_emailid_byuser_id($get_single_user->receiver)."&gt;</span><br>";
			}
			else
			{				
				echo "To: ".get_post_meta($message->post_id, 'message_for',true);
			}			
		} 
		?>
		</p>
    </div>
    <div class="message-content">			
    	<p>
		<?php 
		$receiver_id=0;
		if($box=='sendbox')
		{ 
			echo $message->post_content; 
			echo '</br>';
			echo '</br>';			
			$attchment=get_post_meta( $message->ID, 'message_attachment',true);
			if(!empty($attchment))
			{
				$attchment_array=explode(',',$attchment);
				
				foreach($attchment_array as $attchment_data)
				{
					?>
						<a target="blank" href="<?php echo content_url().'/uploads/school_assets/'.$attchment_data; ?>" class="btn btn-default"><i class="fa fa-download"></i><?php _e('View Attachment','school-mgt');?></a>
					<?php								
				}
			}
			$receiver_id=(get_post_meta($_REQUEST['id'],'message_smgt_user_id',true));
		} 
		else
		{ 				
			echo $message->message_body; 
			echo '</br>';
			echo '</br>';			
			$attchment=get_post_meta( $message->post_id, 'message_attachment',true);
			if(!empty($attchment))
			{
				$attchment_array=explode(',',$attchment);
				
				foreach($attchment_array as $attchment_data)
				{
					?>
						<a target="blank" href="<?php echo content_url().'/uploads/school_assets/'.$attchment_data; ?>" class="btn btn-default"><i class="fa fa-download"></i><?php _e('View Attachment','school-mgt');?></a>
					<?php								
				}
			}
			$receiver_id=$message->sender;
		}
		?>
	</p>
   
    <div class="message-options pull-right">
    	<a class="btn btn-default" href="?page=smgt_message&tab=view_message&id=<?php echo $_REQUEST['id'];?>&from=<?php echo $box;?>&delete=1" onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"><i class="fa fa-trash m-r-xs"></i><?php _e('Delete','school-mgt')?></a> 
   </div>
    </div>
	<?php 
	if(isset($_REQUEST['from']) && $_REQUEST['from']=='inbox')
	{
		$allreply_data=smgt_get_all_replies($message->post_id);
	}
	else
	{
		$allreply_data=smgt_get_all_replies($_REQUEST['id']);
	}
	if(!empty($allreply_data))
	{
		foreach($allreply_data as $reply)
		{	
			$receiver_name=smgt_get_receiver_name_array($reply->message_id,$reply->sender_id,$reply->created_date,$reply->message_comment);		
			if($reply->sender_id == get_current_user_id() || $reply->receiver_id == get_current_user_id())
			{
				?>
				<div class="message-content">
				
					<p><?php echo $reply->message_comment;?>
					<?php
					
					$reply_attchment=$reply->message_attachment;				
					if(!empty($reply_attchment))
					{
						echo '</br>';
						echo '</br>';
						$reply_attchment_array=explode(',',$reply_attchment);
						
						foreach($reply_attchment_array as $attchment_data1)
						{
							?>
								<a target="blank" href="<?php echo content_url().'/uploads/school_assets/'.$attchment_data1; ?>" class="btn btn-default"><i class="fa fa-download"></i><?php _e('View Attachment','school-mgt');?></a>
							<?php								
						}
					}
					?>
					<br><h5>
					<?php
					_e('Reply By : ','school-mgt'); 
					echo get_display_name($reply->sender_id); 
					_e(' || ','school-mgt'); 	
					_e('Reply To : ','school-mgt'); 
					echo $receiver_name; 
					_e(' || ','school-mgt'); 	
					?>
					<span class="timeago"  title="<?php echo convert_date_time($reply->created_date);?>"></span>
					<?php
					if($reply->sender_id == get_current_user_id())
					{
						?>	
						<span class="comment-delete">
						<a href="admin.php?page=smgt_message&tab=view_message&action=delete-reply&from=<?php echo $_REQUEST['from'];?>&id=<?php echo $_REQUEST['id'];?>&reply_id=<?php echo $reply->id;?>"><?php _e('Delete','school-mgt');?></a></span> 
						<?php 
					} 
					?>
					</h5> 
					</p>
				</div>
				<?php 
			}
		}
	}		
   ?>
    <script type="text/javascript">
	$(document).ready(function() 
	{			
		  $('#selected_users').multiselect({ 
			 nonSelectedText :'<?php _e("Select users to reply","school-mgt");?>',
			 includeSelectAllOption: true           
		 });
		 $("body").on("click","#check_reply_user",function()
		 {
			var checked = $(".dropdown-menu input:checked").length;

			if(!checked)
			{
				alert("<?php esc_html_e('Please select atleast one users to reply','school-mgt');?>");
				return false;
			}		
		});  
	 	$("body").on("click","#replay_message_btn",function()
		 {
			$(".replay_message_div").show();	
			$(".replay_message_btn").hide();	
		});   
	});
	</script>
	 <form name="message-replay" method="post" id="message-replay" enctype="multipart/form-data">
   <input type="hidden" name="message_id" value="<?php if($_REQUEST['from']=='sendbox') {echo $_REQUEST['id'];} else { echo $message->post_id; }?>">
   <input type="hidden" name="user_id" value="<?php echo get_current_user_id();?>">
   <!--<input type="hidden" name="receiver_id" value="<?php echo $receiver_id;?>">-->
	<?php
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$current_user_id=get_current_user_id();
	if((string)$current_user_id == $author)
	{		
		if($_REQUEST['from']=='sendbox')
		{
			$msg_id=$_REQUEST['id']; 
			$msg_id_integer=(int)$msg_id;
			$reply_to_users =$wpdb->get_results("SELECT *  FROM $tbl_name where post_id = $msg_id_integer");			
		}
		else
		{
			$msg_id=$message->post_id;			
			$msg_id_integer=(int)$msg_id;
			$reply_to_users =$wpdb->get_results("SELECT *  FROM $tbl_name where post_id = $msg_id_integer");			
		}		
	}
	else
	{
		$reply_to_users=array();
		$reply_to_users[]=(object)array('receiver'=>$author);
	}
	?>
	<div class="message-options pull-right">
		<button type="button" name="replay_message_btn" class="btn btn-default replay_message_btn" id="replay_message_btn"><i class="fa fa-reply m-r-xs"></i><?php esc_html_e('Reply','school-mgt')?></button>
 	</div>
    <div class="message-content float_left_width_100 replay_message_div">
		<div class="col-sm-12">
			<div class="form-group" >
				<label class="col-sm-2 control-label" ><?php _e('Select user to reply','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-10" style="margin-bottom:20px;">			
					 <select name="receiver_id[]" class="form-control" id="selected_users" multiple="true">
						<?php						
						foreach($reply_to_users as $reply_to_user)
						{  	
							$user_data=get_userdata($reply_to_user->receiver);
							if(!empty($user_data))
							{								
								if($reply_to_user->receiver != get_current_user_id())
								{
									?>
									<option  value="<?php echo $reply_to_user->receiver;?>" ><?php echo get_display_name($reply_to_user->receiver); ?></option>
									<?php
								}
							}							
						} 
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="photo"><?php _e('Message Comment','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8" style="margin-bottom: 10px;">
					<textarea name="replay_message_body" id="replay_message_body" class="validate[required] form-control text-input"></textarea>
				</div>
			</div>
		</div>	  
		<div class="attachment_div col-sm-12">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="photo"><?php _e('Attachment','school-mgt');?></label>
				<div class="col-sm-10" style="margin-bottom: 10px;">
				 <input  class="btn_top input-file" name="message_attachment[]" type="file" />
				</div>					
			</div>							
       	</div>	
		<div class="col-sm-offset-2 col-sm-10" style="margin-bottom: 5px;">
			<input type="button" value="<?php esc_attr_e('Add More Attachment','school-mgt') ?>"  onclick="add_new_attachment()" class="btn more_attachment">
		</div>	
	   <div class="message-options pull-right reply-message-btn">
			<button type="submit" name="replay_message" class="btn btn-success" id="check_reply_user"><?php _e('Send Message','school-mgt')?></button>
		
	   </div>
    </div>
	</form>
 </div>
<?php ?>