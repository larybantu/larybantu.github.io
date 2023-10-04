<?php require_once('../includes/db_connection.php');?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/form_functions.php"); ?>
<?php confirm_logged_in(); ?> 

<?php 
	if (isset($_POST['post'])){
		$sel_cash = mysql_prep($_GET['cash_id']);
		$result=mysql_query("SELECT * FROM cash_transaction WHERE cash_transaction_id=$sel_cash");
		$editcash = mysql_fetch_array($result);
		
			if ($sel_cash == $editcash['cash_transaction_id']){
			global $m,$d,$y;
			 $pms_cash = trim(mysql_prep($_POST['pms_cash']));
			 $ago_cash = trim(mysql_prep($_POST['ago_cash']));
			 $bik_cash = trim(mysql_prep($_POST['bik_cash']));
			 $payment_cash_1 = trim(mysql_prep($_POST['payment_cash_1']));
			 $payment_cash_2 = trim(mysql_prep($_POST['payment_cash_2']));
			 $cashier = trim(mysql_prep($_POST['cashier']));
			 list($m,$d,$y) = explode("/",$_POST['date']);
			 $date = mysql_real_escape_string("$y-$m-$d ");
			 $total_cash= ($pms_cash + $ago_cash + $bik_cash + $payment_cash_1 + $payment_cash_2);
		//validation of entries 

	//to eliminate duplicate entries	
	$query = "UPDATE cash_transaction SET
				date_of_cash='{$date}', 
				cashier_name='{$cashier}', 
				pms_cash='{$pms_cash}', 
				ago_cash='{$ago_cash}', 
				bik_cash='{$bik_cash}', 
				payment_cash_1='{$payment_cash_1}', 
				payment_cash_2='{$payment_cash_2}',  
				total_cash='{$total_cash}'
					WHERE
					 cash_transaction_id={$sel_cash}";
		if(mysql_query($query)){
			 redirect_to("cashentry.php");
			}else{
				echo "&nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<font color='#FF0000'>Failed: " . mysql_error() . "</font>";
				echo "<a href='editentrycash.php'><<Go Back</a>";
				}
			}else{
				echo "id not set";
				}	
		}
	?> 