<?php require_once('../includes/db_connection.php');?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/form_functions.php"); ?>
<?php confirm_logged_in(); ?> 

<?php 
	if (isset($_POST['post'])){
		$sel_meter = mysql_prep($_GET['meter_id']);
		$result=mysql_query("SELECT * FROM meter_transaction WHERE meter_transaction_id=$sel_meter");
		$editmeter = mysql_fetch_array($result);
		if ($sel_meter == $editmeter['meter_transaction_id']){
			global $m,$d,$y;
			$pump_no = trim(mysql_prep($_POST['pump_no']));
			$product = trim(mysql_prep($_POST['product']));
			$opening = trim(mysql_prep($_POST['opening']));
			$cm1 = trim(mysql_prep($_POST['cm1']));
			$cm2 = trim(mysql_prep($_POST['cm2']));
			$rtt = trim(mysql_prep($_POST['rtt']));
			$cm3 = trim(mysql_prep($_POST['cm3']));
			$closing = trim(mysql_prep($_POST['closing']));
			list($m,$d,$y) = explode("/",$_POST['date']);
			$date = mysql_real_escape_string("$y-$m-$d ");
			$litres_sold = ($closing - $opening - $rtt);

	//validation of entries 

	//to eliminate duplicate entries	
	$query = "UPDATE meter_transaction SET
				pump_no='{$pump_no}', 
				product_code='{$product}', 
				opening_meter='{$opening}', 
				changing_meter1='{$cm1}', 
				changing_meter2='{$cm2}', 
				changing_meter3='{$cm3}', 
				closing_meter='{$closing}',  
				meter_date='{$date}', 
				total_sales='{$litres_sold}',
				rtt='{$rtt}'
					WHERE
					 meter_transaction_id={$sel_meter}";
		if(mysql_query($query)){
			 redirect_to("meter_form.php");
			}else{
				echo "&nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<font color='#FF0000'>Failed: " . mysql_error() . "</font>";
				}
			}else{
				echo "id not set";
				}	
		}
	?> 