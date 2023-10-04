<?php require_once('../includes/db_connection.php');?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/form_functions.php"); ?>
<?php confirm_logged_in(); ?> 

<?php 
	if (isset($_POST['post'])){
		$sel_customer = mysql_prep($_GET['customer_id']);
		$result = mysql_query("SELECT * FROM customers WHERE customer_id=$sel_customer");
		$editcustomer = mysql_fetch_array($result);
		if ($sel_customer == $editcustomer['customer_id']){
			$customer_name = trim(mysql_prep($_POST['customer_name']));
			$customer_code = trim(mysql_prep($_POST['code']));
			$customer_contact = trim(mysql_prep($_POST['customer_contact']));
	//validation of entries 

	//to eliminate duplicate entries	
	$query = "UPDATE customers SET
				customer_code='{$customer_code}', 
				customer_name='{$customer_name}', 
				customer_contact='{$customer_contact}',
					WHERE
					 customer_id={$sel_customer}";
		if(mysql_query($query)){
			 redirect_to("addacc.php");
			}else{
				echo "&nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<font color='#FF0000'>Failed: " . mysql_error() . "</font>";
				}
			}else{
				echo "id not set";
				}	
		}
	?> 