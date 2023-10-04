<?php require_once('../includes/db_connection.php');?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/form_functions.php"); ?>
<?php confirm_logged_in(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Invoice Entry</title>
<link href="../css/modify.css" rel="stylesheet" type="text/css" />
<link href="../css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<link rel="Shortcut icon" href="../img/newfav.ico" />

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
  <div id="display">
    <div class="menuhead">Query Customer</div>
    <form  id="formID" name="invoice" method="post" action="invoice_form.php">
    <table width="645">
      <tr>
      <td width="116">Date:</td>
        <td width="200"><input type="text" name="date" id="datepicker"/> </td>
        <td width="110">Changing Meter1:</td>
       <td width="199"><input type="text" name="cname" id="name"/></td>
       </tr>
      <tr>   
       <td>Opening Meter:</td>
        <td><input type="text" name="vehicle_no" id="vehicle" class="validate[required]"/></td>
         <td>Changing Meter2:</td>
        <td><input type="text" name="cname" id="name"/></td>
        </tr>
        <tr>  
          <td>Closing Meter:</td>
           <td><input type="text" name="amount" id="amount" class="validate[required]"/></td>
            <td>Changing Meter3:</td>
           <td><input type="text" name="cname" id="name"/></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
           <td>&nbsp;</td>
            <td>&nbsp;</td>
           <td>&nbsp; </td>
        </tr>
         <tr>
         <td>&nbsp;</td>
         <td><input type="submit" class="btn" name="post" value="Post" /></td>
             <td></td>
             <td></td>
        </tr>
       </table>
                        
    </form>
    <div id="results"></div>
  </div>
 <div id="mainmenu">
    <div class="menuhead"><?php 
	if($_SESSION['user_id'] == 1000){
		  echo "<a href=\"meter_readings.php\">";
		 }else{
			 echo "<a href=\"frontarea.php\">";
			 }
	 ?>Main Menu</a></div>
    <br />
  Transactions
        	<div class="submenu">
            <li> <div class="selected"><a href="invoice_form.php">Invoice</a></div></li>
            <li><div class="sublink"><a href="payment_form.php">Payment</a></div></li>
            <li><div class="sublink"><a href="#">Cash</a></div></li>
             <li><div class="sublink"><a href="#">Invoice Service</a></div></li>
            </div>
  Reports
        <div class="submenu">
            <li> <div class="sublink"><a href="query_customer.php">Customer</a></div></li>
            <li><div class="sublink"><a href="#">Product</a></div></li>
            <li><div class="sublink"><a href="#">Daily</a></div></li>
            </div>
  Change
      <div class="submenu">
            <li> <div class="sublink"><a href="change_price.php">Pump Price</a></div></li>
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
