<?php require_once('../includes/db_connection.php');?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/form_functions.php"); ?>
<?php confirm_logged_in(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Edit Invoice Entry</title>
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
    <div class="menuhead"> Invoice Entry</div>
    <?php 
			$sel_invoice = $_GET['invoice_id'];
			$result=mysql_query("SELECT * FROM invoice_transaction WHERE invoice_transaction_id=$sel_invoice");
			$editinvoice = mysql_fetch_array($result);
			$printdate = date('d/m/Y', strtotime($editinvoice['date_of_invoice']));
			$printinvoice_no = $editinvoice['invoice_no'];
			$printvehicle_no = $editinvoice['vehicle_no'];
			$printcustomer_name = $editinvoice['customer_name'];
			$printcustomer_code = $editinvoice['customer_code'];
			$printltrs = $editinvoice['litres'];
			$printamount = $editinvoice['amount'];
			$printproduct = $editinvoice['product_code'];
		?>
    <form  id="formID" name="invoice" method="post" action="<?php echo "../update_invoice.php?invoice_id=". urlencode($editinvoice['invoice_transaction_id']) .""?>">
    <table width="645">
      <tr>
      <td width="116">Date:</td>
        <td width="200"><input type="text" name="date" id="datepicker" value="<?php echo "$printdate"?>"/> </td>
        <td width="110"> Invoice No:</td>
       <td width="199"><input type="text" id="invoice_no" name="invoice_no" class="validate[required]" value="<?php echo $printinvoice_no?>" /></td>
       </tr>
      <tr>   
       <td>Vehicle No:</td>
        <td><input type="text" name="vehicle_no" id="vehicle" class="validate[required]" value="<?php echo $printvehicle_no?>" /></td>
         <td>Customer Name:</td>
        <td><input type="text" name="cname" id="name" value="<?php echo $printcustomer_name?>"/></td>
        </tr>
        <tr>  
          <td>Customer Account:</td>
           <td><select name="cacc" class="btn"<?php //we are going to do some complex shyte here?>>
               <option value="">--Select Account--</option>
               <?php 
			   		$queryacc = mysql_query("SELECT * FROM customers");
					while($customer = mysql_fetch_array($queryacc)){
						echo "<option value='{$customer["customer_code"]}'>{$customer["customer_name"]} " . $customer['customer_code'] . "</option>";
						}
			 ?>
              </select></td>
            <td>Litres(2dp):</td>
           <td><input type="text" id="litres" name="ltrs" value="<?php echo $printltrs?>" /></td>
          </tr>
        <tr> 
          <td>Amount:</td>
           <td><input type="text" name="amount" id="amount" class="validate[required]" value="<?php echo $printamount?>"/></td>
            <td>Product Price</td>
           <td> &nbsp; &nbsp; <?php echo 3200; ?></td>
           </tr>
         <tr>
         <td>Product:</td>
         <td><select name="product" class="btn">
               <?php 
			   	if($printproduct == 'PMS'){
					echo "
					<option value=\"PMS\">PMS</option>
					<option value=\"AGO\">AGO</option>
                    <option value=\"BIK\">BIK</option>";
					
					}elseif($printproduct == 'AGO'){
						echo "
						<option value=\"AGO\">AGO</option>
						<option value=\"PMS\">PMS</option>
						<option value=\"BIK\">BIK</option>";
						}elseif($printproduct == 'BIK'){
							echo "
							<option value=\"BIK\">BIK</option>
							<option value=\"AGO\">AGO</option>
							<option value=\"PMS\">PMS</option>";
						}
                 ?>
             </select></td>
             <td class="del"><a href="<?php 
			 	echo "../delete_invoice.php?invoice_id=". urlencode($editinvoice['invoice_transaction_id']) ."";
			 ?>" onclick="return confirm('Are you sure you want to delete this Invoice Entry?');">Delete Entry</a></td>
             <td><input type="submit" class="btn" name="post" value="Update" /></td>
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
          <td class="celltb" width="72" height="38">Date</td>
          <td class="celltb" width="68">Invoice No.</td>
          <td class="celltb" width="58">Account</td>
          <td class="celltb" width="196">Name</td>
          <td class="celltb" width="59">Veh. No.</td>
          <td class="celltb" width="59">Product</td>
          <td class="celltb" width="47">Litres</td>
          <td class="celltb" width="134">Amount</td>
          <td width="10">Action</td>
        </tr>
     <?php
			$result = mysql_query("SELECT * FROM invoice_transaction WHERE date_of_entry = CURDATE()");
		while($row = mysql_fetch_array($result)){
			echo "
			<tr>
			  <td class='celltb' width='70' height='35'>". date('d/M/Y', strtotime($row['date_of_invoice'])) ."</td>
			  <td class='celltb' width='68'>{$row["invoice_no"]}</td>
			  <td class='celltb' width='55'>{$row["customer_code"]}</td>
			  <td class='celltb' width='196'>{$row["customer_name"]}</td>
			  <td class='celltb' width='59'>{$row["vehicle_no"]}</td>
			  <td class='celltb' width='59'>{$row["product_code"]}</td>
			  <td class='celltb' width='47'>{$row["litres"]}</td>
			  <td class='celltb' width='134'>{$row["amount"]}</td>
			  <td width='30'>
			  <a href='editentryi.php?invoice_id=". urlencode($row['invoice_transaction_id']) ."'>Edit</a></td>
			</tr>
		";
		  }
			?>
            </table>
    </div>
    <?php include("../includes/footer.php");?>   
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
            <li> <div class="sublink"><a href="#">Customer</a></div></li>
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
