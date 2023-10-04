<?php require_once('../includes/db_connection.php');?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/modify.css" rel="stylesheet" type="text/css" />
<link rel="Shortcut icon" href="../img/newfav.ico" />
<link href="../css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<title>Change Price</title>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<script  type="text/javascript">
  $(document).ready(function() {
    $("#datepicker").datepicker();
  });
</script>
</head>

<body>
<div id="wrapper">
    <?php require("../includes/header.php");?>
     <?php
    if ($_POST){
		global $m,$d,$y,$difference;
		list($m,$d,$y) = explode("/",$_POST['date']);
	/*1*/ $date = mysql_real_escape_string("$y-$m-$d ");
	/*2*/ $change_price = trim(mysql_prep($_POST['change_price']));
	/*3*/ $product = trim(mysql_prep($_POST['product'])) ;
	
	
	//selecting the values from the table to get the current price

		//inserting entries into the table 
		$query = "INSERT INTO pump_price (date_of_change, date_of_entry, product_code, current_price, old_price VALUES ('{$date}',CURDATE(),'{$product}',{$change_price},{$pump_current})";
		
		if(mysql_query($query)){
			echo " &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <font color=\"#438787\">Price of <strong>". $value_chaged ."</strong> Successfully</font>";
			}else{
				echo "&nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<font color='#FF0000'>Failed: " . mysql_error() . "</font>";
			}		
		}
		?>
    <div id="display">
    <div class="menuhead">Change Price Transaction</div>
    <form  id="formID" name="invoice" method="post" action="change_price.php">
    <table width="645">
      <tr>
      <td width="116" class="rightalign">Current  </td>
        <td width="200">Pump Prices</td>
        <td width="65">Date:</td>
       <td width="244"><input type="text" name="date" id="datepicker"/></td>
      </tr>
      <tr>   
       <td height="36" class="rightalign">PMS:</td>
        <td>
          <?php 
			$querycurrent = mysql_query("SELECT * FROM pump_price WHERE product_code='PMS'");
			$pms_current_price = mysql_fetch_array($querycurrent);
			echo "<strong>". $pms_current_price['current_price'] . "</strong>";?></td>
         <td>Change:</td>
        <td><select name="product" class="btn">
               <option value="">--Choose Product--</option>
                 <option value="PMS">PMS</option>
                   <option value="AGO">AGO</option>
                      <option value="BIK">BIK</option>
        </select></td>
      </tr>
        <tr>  
          <td height="33" class="rightalign">AGO:</td>
           <td><?php 
		   	$querycurrent1 = mysql_query("SELECT * FROM pump_price WHERE product_code='AGO'");
			$ago_current_price = mysql_fetch_array($querycurrent1);
		   echo "<strong>". $ago_current_price['current_price'] . "</strong>"?></td>
          <td>To:</td>
           <td><input type="text" name="change_price"/></td>
        </tr>
        <tr> 
          <td class="rightalign">BIK:</td>
           <td><?php 
		   $querycurrent2 = mysql_query("SELECT * FROM pump_price WHERE product_code='BIK'");
			$bik_current_price = mysql_fetch_array($querycurrent2);
		   echo "<strong>". $bik_current_price['current_price'] . "</strong>"?></td>
            <td>&nbsp;</td>
           <td><input type="submit" class="btn" name="post" value="Change" /> </td>
           </tr>
         <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
             <td></td>
             <td></td>
      </tr>
       </table>
       </form>
           <div id="results"><br />
    Today's Entries &nbsp; &nbsp; <?php 
	$daten = date("Y-m-d");
	print date('d/m/Y', strtotime($daten)); 
	?><br />
    <table  class="displaytb" width="747">
        <tr class="tablehead">
          <td class="celltb" width="106" height="38">Date</td>
          <td class="celltb" width="250">Product</td>
          <td class="celltb" width="108">From</td>
          <td class="celltb" width="98">To</td>
          <td class="celltb" width="94">Diffrence</td>
          <td width="63">Action</td>
        </tr>
     <?php
			$result = mysql_query("SELECT * FROM pump_price WHERE date_of_entry = CURDATE()");
		while($row = mysql_fetch_array($result)){
			echo "
			<tr>
			  <td class='celltb' width='70' height='35'>". date('d/M/Y', strtotime($row['date_of_change'])) ."</td>
			  <td class='celltb' width='250'>{$row["product_code"]}</td>
			  <td class='celltb' width='108'>{$row["old_price"]}</td>
			  <td class='celltb' width='196'>{$row["current_price"]}</td>
			  <td class='celltb' width='59'></td>
			  <td width='10'><a href='editentryprice.php?price_id=". urlencode($row['pump_price_id']) ."'>Edit</a></td>
			</tr>
		";
		  }
			?>
            </table>
    </div>
   
    <?php include("../includes/footer.php");?>   
    </div>
    
  <div id="mainmenu">
    <div class="menuhead"><a href="frontarea.php">Main Menu</a></div>
    <br />
  Transactions
        	<div class="submenu">
            <li> <div class="sublink"><a href="invoice_form.php">Invoice</a></div></li>
            <li><div class="sublink"><a href="payment_form.php">Payment</a></div></li>
            <li><div class="sublink"><a href="#">Cash</a></div></li>
             <li><div class="sublink"><a href="#">Invoice Service</a></div></li>
            </div>
  Reports
        <div class="submenu">
            <li> <div class="sublink"><a href="#">Customer</a></div></li>
            <li><div class="sublink"><a href="#">Product</a></div></li>
            <li><div class="sublink"><a href="#">Daily</a></div></li>
            </div>
  Change
      <div class="submenu">
            <li> <div class="selected"><a href="change_price.php">Pump Price</a></div></li>
            <li><div class="sublink"><a href="#">Entry</a></div></li>
            </div>
  Accounts
        <div class="submenu">
            <li><div class="sublink"><a href="#">Cash</a></div></li>
            <li>
              <div class="sublink"><a href="#">Account Balances</a></div></li>
    </div>
    </div>
</div>    
</body>
</html>