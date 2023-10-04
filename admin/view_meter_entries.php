<?php require_once('../includes/db_connection.php');?>
<?php require_once("../includes/sessionadmin.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/form_functions.php");
	  require_once("../includes/formvalidator.php"); ?>
<?php confirm_logged_in(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Meter Readings</title>
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
    <?php require("../includes/header_inner.php");?>
  <div id="display">
    <div class="menuhead">Meter Transaction Entry</div>
    <form  id="formID" name="invoice" method="post" action="meter_form.php">
    <table width="658">
      <tr>
      <td width="111">Change Date:</td>
        <td width="172"><input type="text" name="date" id="datepicker" /> </td>
        <td width="164"><input type="submit" class="btn" name="post" value="View Entries" /></td>
       <td width="191">&nbsp;</td>
        </tr>
       </table>
                        
    </form>
    
    <div id="results"><br />
    Entry Date &nbsp;<?php 
	
	$daten = date("Y-m-d");
	print date('d/m/Y', strtotime($daten));
	echo " <a href='view_meter_entries.php?$view_date=". $daten ."'Check Previous Entries";
	
	if (isset($_GET['view_date'])){
		global $m,$d,$y;
		list($m,$d,$y) = explode("/",$_POST['date']);
		$date = mysql_real_escape_string("$y-$m-$d ");
	}
	?> 
    <div id="printer"><a href="printmeters.php" target="_blank" >Printer Friendly Version</a></div><br /><br />
    <table  class="displaytb" width="747">
        <tr class="tablehead">
          <td class="celltb" width="81" height="40">Date</td>
          <td class="celltb" width="98">Opening Meter</td>
          <td class="celltb" width="101">Changing Meter</td>
          <td class="celltb" width="127">Closing Meter</td>
          <td class="celltb" width="43">Pump</td>
          <td class="celltb" width="57">Product</td>
          <td class="celltb" width="57">Litres</td>
          <td class="celltb" width="95">Amount</td>
          <td width="48">Action</td>
        </tr>
     <?php
	 
			$result = mysql_query("SELECT * FROM meter_transaction WHERE date_of_entry = CURDATE()");
		while($row = mysql_fetch_array($result)){
			echo "
			<tr>
			  <td class='celltb' height=\"35\">". date('d/M/Y', strtotime($row['meter_date'])) ."</td>
			  <td class='celltb'>{$row["opening_meter"]}</td>
			  <td class='celltb'><font size='-2' color = '438787'>";
			  if($row['changing_meter1'] != 00000000000.00){
				  echo $row["changing_meter1"];
				  }elseif($row["changing_meter2"] != 00000000000.00 ){
					  echo $row["changing_meter2"];
					  }elseif($row["changing_meter3"] != 00000000000.00){
						  echo $row["changing_meter3"];
						  }else{
							  echo "Meter Not Changed</font>";
							  }
						  
			  echo "</td>
			  <td class='celltb'>{$row["closing_meter"]}</td>
			  <td class='celltb'>{$row["pump_no"]}</td>
			  <td class='celltb'>{$row["product_code"]}</td>
			  <td class='celltb'>{$row["total_sales"]}</td>
			  <td class='celltb'>";
			  $code = $row['product_code'];
			  $queryp = mysql_query("SELECT * FROM pump_price WHERE product_code = '{$code}'");//provision to pull the latest dates only
			  $pdt_price= mysql_fetch_array($queryp);
			  if($row['product_code'] ==  $pdt_price['product_code']){
				  $amount = (($row['total_sales'])*($pdt_price['current_price']));
				  echo $amount;
			  }
			  echo "</td>
			  <td><a href='editentrym.php?meter_id=". urlencode($row['meter_transaction_id']) ."'>Edit</a></td>
			</tr>
		";
		  }
			?>
      </table>
    </div>
    <?php include("../includes/footer.php");?>   
  </div>
 <?php include("../includes/mainmenu.php");?>
    
</div>
</body>
</html>
