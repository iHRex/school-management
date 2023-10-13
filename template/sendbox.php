<div class="mailbox-content">
	<div class="table-responsive">
 	<table class="table">
 		<thead>
 			<tr>
 				<th class="text-right" colspan="5">
               	<?php 
               	$max = 10;
               	if(isset($_GET['pg']))
				{
               		$p = $_GET['pg'];
               	}
				else
				{
               		$p = 1;
               	}
               	$limit = ($p - 1) * $max;
				$prev = $p - 1;
               	$next = $p + 1;
               	$limits = (int)($p - 1) * $max;
               	$totlal_message1 = smgt_count_send_item(get_current_user_id());
               	$totlal_message = ceil($totlal_message1 / $max);
               	$lpm1 = $totlal_message - 1;               	
               	$offest_value = ($p-1) * $max;
               	echo smgt_fronted_sentbox_pagination($totlal_message,$p,$lpm1,$prev,$next);               	
               	?>
                </th>
 			</tr>
 		</thead>
 		<tbody>
 		<tr>
 			<th>
            	<span><?php _e('Message For','school-mgt');?></span>
            </th>
			<th>
            	<span><?php _e('Class','school-mgt');?></span>
            </th>
            <th><?php _e('Subject','school-mgt');?></th>
             <th>
                  <?php _e('Description','school-mgt');?>
            </th>
			<th>
                  <?php _e('Attachment','school-mgt');?>
            </th>
			<th>
                  <?php _e('Date & Time','school-mgt');?>
            </th>
            </tr>
 		<?php 
 		$offset = 0;
 		if(isset($_REQUEST['pg']))
 			$offset = $_REQUEST['pg'];
 		
 		$message = get_send_message(get_current_user_id(),$max,$offset); 		
		
 		foreach($message as $msg_post)
 		{ 	
			
 			if($msg_post->post_author==get_current_user_id())
 			{ 	
 			?>
 			<tr>
 			<td><a href="?dashboard=user&page=message&tab=view_message&from=sendbox&id=<?php echo $msg_post->ID;?>" class="text_decoration_none">
            	<span>
				<?php 
				$check_message_single_or_multiple=send_message_check_single_user_or_multiple($msg_post->ID);	
				if($check_message_single_or_multiple == 1)
				{	
					global $wpdb;
					$tbl_name = $wpdb->prefix .'smgt_message';
					$post_id=$msg_post->ID;
					$get_single_user = $wpdb->get_row("SELECT * FROM $tbl_name where post_id = $post_id");
					
					echo get_display_name($get_single_user->receiver);
				}
				else
				{	
					echo get_post_meta( $msg_post->ID, 'message_for',true);
				}
				?>
				</span></a>
            </td>
			<td><a href="?dashboard=user&page=message&tab=view_message&from=sendbox&id=<?php echo $msg_post->ID;?>" class="text_decoration_none">
            <span>
				<?php 
				if(get_post_meta( $msg_post->ID, 'smgt_class_id',true) !="" && get_post_meta( $msg_post->ID, 'smgt_class_id',true) == 'all')
				{					
					_e('All','school-mgt');
				}
				elseif(get_post_meta( $msg_post->ID, 'smgt_class_id',true) !="")
				{
					$smgt_class_id=get_post_meta( $msg_post->ID, 'smgt_class_id',true);
					$class_id_array=explode(',',$smgt_class_id);
					$class_name_array=array();
					foreach($class_id_array as $data)
					{						
						$class_name_array[]=get_class_name($data);
							
					}
					echo implode(',',$class_name_array);				
				}
				else
				{
					echo "NA";
				}
				?>
				</span></a>
            </td>
            <td class="width_100px">
			<a href="?dashboard=user&page=message&tab=view_message&from=sendbox&id=<?php echo $msg_post->ID;?>" class="text_decoration_none">
			<?php 
			$subject_char=strlen($msg_post->post_title);
            if($subject_char <= 10)
            {
                echo $msg_post->post_title;
            }
            else
            {
                $char_limit = 10;
                $subject_body= substr(strip_tags($msg_post->post_title), 0, $char_limit)."...";
                echo $subject_body;
            }
			?>
			<?php if(smgt_count_reply_item($msg_post->ID)>=1){?><span class="badge badge-success pull-right"><?php echo smgt_count_reply_item($msg_post->ID);?></span><?php } ?></a>
			</td>
             <td class="width_400px"><a href="?dashboard=user&page=message&tab=view_message&from=sendbox&id=<?php echo $msg_post->ID;?>" class="text_decoration_none">
         	<?php
				$body_char=strlen($msg_post->post_content);
	            if($body_char <= 60)
	            {
	                echo $msg_post->post_content;
	            }
	            else
	            {
	                $char_limit = 60;
	                $msg_body= substr(strip_tags($msg_post->post_content), 0, $char_limit)."...";
	                echo $msg_body;
	            }
			?>
            </a></td>
			<td>	
				<?php
				$attchment=get_post_meta( $msg_post->ID, 'message_attachment',true);
				
				if(!empty($attchment))
				{
					$attchment_array=explode(',',$attchment);
					foreach($attchment_array as $attchment_data)
					{	
						?>
						<a target="blank" href="<?php echo content_url().'/uploads/school_assets/'.$attchment_data; ?>" class="btn btn-default"><i class="fa fa-download"></i><?php _e('View Attachment','school-mgt');?></a></br>
						<?php
					}
				}
				else
				{
					 _e('No Attachment','school-mgt');
				}
				?>				
			</td>
			<td><a href="?dashboard=user&page=message&tab=view_message&from=sendbox&id=<?php echo $msg_post->ID;?>" class="text_decoration_none">	
                <?php		
				$created_date=$msg_post->post_date_gmt;
				echo  convert_date_time($created_date);
				?>
            </a></td>
            </tr>
 			<?php 
 			}
 		}
 		?>
 		</tbody>
 	</table>
 	</div>
 </div>
