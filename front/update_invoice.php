<?php require_once('../includes/db_connection.php');?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/form_functions.php"); ?>
<?php confirm_logged_in(); ?> 
<?php if ($_POST){
		$sel_invoice = mysql_prep($_GET['invoice_id']);
		$result=mysql_query("SELECT * FROM invoice_transaction WHERE invoice_transaction_id=$sel_invoice");
		$editinvoice = mysql_fetch_array($result);
	 	if ($sel_invoice == $editinvoice['invoice_transaction_id']){	
		global $m,$d,$y;
		list($m,$d,$y) = explode("/",$_POST['date']);
	/*1*/ $date = mysql_real_escape_string("$y-$m-$d ");
	/*2*/ $invoice_no = trim(mysql_prep($_POST['invoice_no']));
	/*3*/ $vehicle = trim(mysql_prep($_POST['vehicle_no']));
	/*4*/ $customer_name = trim(mysql_prep($_POST['cname']));
	/*5*/ $customer_code = trim(mysql_prep($_POST['cacc']));
	/*6*/ $ltrs = trim(mysql_prep($_POST['ltrs']));
	/*7*/ $amount = trim(mysql_prep($_POST['amount'])) ; 
	/*8*/ $product = trim(mysql_prep($_POST['product'])) ;
	
	//update
	$query = "UPDATE invoice_transaction SET 
			invoice_no={$invoice_no}, 
			date_of_invoice='{$date}', 
			vehicle_no='{$vehicle}', 
			product_code='{$product}', 
			customer_name='{$customer_name}', 
			customer_code='{$customer_code}', 
			litres={$ltrs}, 
			amount={$amount} 
				WHERE 
				invoice_transaction_id={$sel_invoice}";
		if(mysql_query($query)){
			 	if($_SESSION['user_id'] == 1000){
		  redirect_to("invoice_form_admin.php");
		 }else{
			redirect_to("invoice_form.php");
			 }
			}else{
				echo "&nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<font color='#FF0000'>Failed: " . mysql_error() . "</font>";
				}
			}else{
				echo "id not set";
				}	
		}
	?> 