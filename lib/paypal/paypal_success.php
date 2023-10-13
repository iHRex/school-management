<?php
$obj_feespayment = new Smgt_feespayment();
$p 	= new Smgt_paypal_class(); // paypal class
	//$p->admin_mail 	= GMS_EMAIL_ADD; // set notification email
$action 		= $_REQUEST["fees_pay_id"];
$feepaydata = $obj_feespayment->smgt_get_single_fee_payment($fees_pay_id);
$user_id  = $feepaydata->student_id;
$user_info = get_userdata($feepaydata->student_id);
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$p->add_field('business', get_option('smgt_paypal_email')); // Call the facilitator eaccount

$p->add_field('cmd', '_cart'); // cmd should be _cart for cart checkout
$p->add_field('upload', '1');
$p->add_field('return', home_url().'/?dashboard=user&page=feepayment&action=success'); // return URL after the transaction got over
$p->add_field('cancel_return', home_url().'/?dashboard=user&page=feepayment&action=cancel'); // cancel URL if the trasaction was cancelled during half of the transaction
$p->add_field('notify_url', home_url().'/?dashboard=user&page=feepayment&action=ipn'); // Notify URL which received IPN (Instant Payment Notification)
$p->add_field('currency_code', 'USD');
$p->add_field('invoice', date("His").rand(1234, 9632));
$p->add_field('item_name_1', get_fees_term_name($feepaydata->fees_id));
$p->add_field('item_number_1', 4);
$p->add_field('quantity_1', 1);
//$p->add_field('amount_1', get_membership_price(get_user_meta($user_id,'membership_id',true)));
$p->add_field('amount_1', $_POST['amount']);
//$p->add_field('amount_1', 1);//Test purpose
$p->add_field('first_name',$user_info->first_name);
$p->add_field('last_name', $user_info->last_name);
$p->add_field('address1',$user_info->address);
$p->add_field('city', $user_info->city_name);

$p->add_field('custom', $user_id."_".$_REQUEST["fees_pay_id"]);
	
		
$p->add_field('state', get_user_meta($user_id,'state_name',true));
$p->add_field('country', get_option( 'smgt_contry' ));
$p->add_field('zip', get_user_meta($user_id,'zip_code',true));
$p->add_field('email',$user_info->user_email);
$p->submit_paypal_post(); // POST it to paypal
$p->dump_fields(); // Show the posted values for a reference, comment this line before app goes live
//echo "hello";
//exit;
?>