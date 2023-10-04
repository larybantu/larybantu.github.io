<?php require_once('../includes/db_connection.php');?>
<?php require_once("../includes/sessionadmin.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/form_functions.php");
	  require_once("../includes/formvalidator.php"); ?>
<?php confirm_logged_in();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Account Statement</title>
<link href="../css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href="../css/print.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="Shortcut icon" href="../img/newfav.ico" />
</head>

<body>
<?php 
	if(isset($_GET['c_acc']) && isset($_GET['from']) && isset($_GET['to']) && isset($_GET['bfd']) ){
		//prepare the get values
		$c_account = mysql_prep($_GET['c_acc']); 
		$fromdate = mysql_prep($_GET['from']); 
		$todate = mysql_prep($_GET['to']); 
		$balancebfd = mysql_prep($_GET['bfd']); 
		
		echo "<div id ='tableheading'><hr />
		NEW MBARARA SERVICE STATION<br />";
		$queryacc2 = mysql_query("SELECT * FROM customers");
		$result = mysql_fetch_array($queryacc2);
		if($result["customer_code"]== $c_account ){
			echo "<strong> {$result["customer_code"]} - ". $result["customer_name"] ."</strong><br />";
			}
		echo "Account Statement <br /> From <strong>". date('d/m/Y', strtotime($fromdate)) ."</strong> to <strong>".  date('d/m/Y', strtotime($todate)) ."</strong><hr />";

			 ?>
             
<table  class="displaytb" width="700">
        <tr class="tablehead">
          <td class='celltb' width='73' height='30'>Date</td>
          <td class='center' width='83'>Ref</td>
          <td class='left' width='140'>Account Name</td>
          <td class='celltb' width='70'>Vehc No.</td>
          <td class='celltb' width='63'>Litres</td>
          <td class='right' width='86'>Debit</td>
		  <td class='right' width='89'>Credit</td>
		  <td class='right' width='100'>Balance</td>
  </tr>
  <?php 
  //what we need to arrange
		$bal = 0;
		$ttltrs = 0;
		$ttdbt = 0;
		$ttcdt = 0;
		//1 Select account......... the account exists since its selected from the drop down menu so no need to verify
		//3 select invoices................ 
		/*BACKUP SELECT STATEMENT */
		
		$invoice_data = mysql_query("
		SELECT *
		FROM display_data
		WHERE customer_code = '{$c_account}'
		AND date BETWEEN '{$fromdate}' AND '{$todate}'  
		ORDER BY date ASC"); 
		
		
		while($row = mysql_fetch_array($invoice_data)){
		//4 display the results for the invoice
		if($row['acc_type'] == 'D'){
		echo "<tr>
          <td class='celltb' width='81' height='20'>". date('d/m/Y', strtotime($row["date"]))."</td>
          <td class='center' width='98'>".$row['ref']."</td>
          <td class='celltb' width='101'>{$row["customer_name"]}</td>
          <td class='celltb' width='70'>{$row["vehicle_no"]}</td>
          <td class='center' width='57'>{$row["ltrs"]}</td>
          <td class='right' width='95'>".number_format($row["debit"])."</td>
		  <td class='right' width='95'>0.00</td>";
		  
		  //4 calculate the total Debit less the Credit...........
		  $bal = $bal + $row['debit'];
		  //5 Summations for the last total row.......
		  $ttltrs = $ttltrs + $row['ltrs'];
		  $ttdbt = $ttdbt + $row['debit'];
		  echo"
		  <td class='right' width='95'>". number_format($bal) ."</td>";
		  echo"
        </tr>";
		}elseif($row['acc_type'] == 'C'){
			echo "<tr class='paymt'>
          <td class='celltb' width='81' height='20'>". date('d/m/Y', strtotime($row["date"]))."</td>
          <td class='center' width='98'>".$row['ref']."</td>
          <td class='celltb' width='101'>{$row["customer_name"]}</td>
          <td class='celltb' width='70'>{$row["vehicle_no"]}</td>
          <td class='center' width='57'>{$row["litres"]}</td>
          <td class='right' width='95'>0.00</td>
		  <td class='right' width='95'>".number_format($row["credit"])."</td>";
		  
		  $bal = $bal - $row['credit'];
		  $ttcdt = $ttcdt + $row['credit'];
		  echo"
		  <td class='right' width='95'>". number_format($bal) ."</td>";
		  echo"
        </tr>";
		  
			}
		}
		echo "             
        <tr class='tablehead'>
          <td class='celltb' width='73' height='30'>TOTAL</td>
          <td class='center' width='83'>-</td>
          <td class='celltb' width='140'>-</td>
          <td class='celltb' width='70'>-</td>
          <td class='center' width='63'>".$ttltrs."</td>
          <td class='right' width='86'>".number_format($ttdbt)."</td>
		  <td class='right' width='89'>".number_format($ttcdt)."</td>
		  <td class='right' width='100'>".number_format($bal)."</td>";
  
  }//end of if get is set
  ?>
</table>
<br />
<?php $daten = date("Y-m-d H:i:s");
			echo "Print Date " . date('d/m/Y H:i:s', strtotime($daten));?>
</body>
</html>