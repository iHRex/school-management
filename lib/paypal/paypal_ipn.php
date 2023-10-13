<?php
$obj_feespayment = new Smgt_feespayment();
$trasaction_id  = $_POST["txn_id"];
$custom_array = explode("_",$_POST['custom']);
$feedata['fees_pay_id']=$custom_array[1];
$feedata['amount']=$_POST['[mc_gross_1'];
$feedata['payment_method']='paypal';	
$feedata['trasaction_id']=$trasaction_id ;
$obj_feespayment->add_feespayment_history($feedata);
?>