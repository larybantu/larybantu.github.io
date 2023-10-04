<?php require_once('../includes/db_connection.php');?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/form_functions.php"); ?>
<?php confirm_logged_in(); ?> 

<?php 
	if (isset($_POST['post'])){
		$sel_pprice = mysql_prep($_GET['pprice_id']);
		$result=mysql_query("SELECT * FROM pump_price WHERE pump_price_id = $sel_pprice");
		$editpprice = mysql_fetch_array($result);
		
	 	if ($sel_pprice == $editpprice['pump_price_id']){	
				global $m,$d,$y;
				list($m,$d,$y) = explode("/",$_POST['date']);
				/*1*/ $date = mysql_real_escape_string("$y-$m-$d ");
				/*2*/ $change_price = trim(mysql_prep($_POST['change_price']));
				/*3*/ $product = trim(mysql_prep($_POST['product'])) ;
				/*4*/ $old_price = trim(mysql_prep($_POST['old_price']));
				//getting the current price
	//update
	$query = "UPDATE pump_price SET 
			current_price={$change_price}, 
			date_of_change='{$date}',  
			product_code='{$product}',
			old_price='{$old_price}'
				WHERE 
				pump_price_id={$sel_pprice}";
		if(mysql_query($query))
		  redirect_to("change_price_admin.php");
			}else{
				echo "&nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<font color='#FF0000'>Failed: " . mysql_error() . "</font>";
				}
			}else{
				echo "id not set";
				}	
	?> 