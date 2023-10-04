<?php require_once('../includes/db_connection.php');?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/form_functions.php"); ?>
<?php confirm_logged_in(); ?> 
<?php if ($_POST){
		$sel_payment = mysql_prep($_GET['payment_id']);
		$result=mysql_query("SELECT * FROM payment_transaction WHERE payment_transaction_id=$sel_payment");
		$editpayment = mysql_fetch_array($result);
	 	if ($sel_payment == $editpayment['payment_transaction_id']){	
		global $m,$d,$y;
		list($m,$d,$y) = explode("/",$_POST['date']);
	/*1*/ $date = mysql_real_escape_string("$y-$m-$d ");
	/*2*/ $payment_no = trim(mysql_prep($_POST['payment_no']));
	/*3*/ $particulars = trim(mysql_prep($_POST['particulars']));
	/*4*/ $customer_name = trim(mysql_prep($_POST['cname']));
	/*5*/ $customer_code = trim(mysql_prep($_POST['cacc']));
	/*6*/ $payment_type = trim(mysql_prep($_POST['payment_type']));
	/*7*/ $amount = trim(mysql_prep($_POST['amount'])) ; 
	
	//update
	$query = "UPDATE payment_transaction SET 
			payment_no={$payment_no}, 
			date_of_payment='{$date}', 
			particulars='{$particulars}', 
			customer_name='{$customer_name}', 
			customer_code='{$customer_code}', 
			payment_type='{$payment_type}', 
			amount={$amount}
				WHERE 
				payment_transaction_id={$sel_payment}";
		if(mysql_query($query)){
			 	if($_SESSION['user_id'] == 1000){
		  redirect_to("payment_form_admin.php");
		 }else{
			redirect_to("../front/payment_form.php");
			 }
			}else{
				echo "&nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<font color='#FF0000'>Failed: " . mysql_error() . "</font>";
				}
			}else{
				echo "id not set";
				}	
		}
	?> 