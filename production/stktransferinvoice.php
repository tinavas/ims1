<?php
       include "config.php";

       $query1 = "SELECT * FROM ims_stocktransfer where tid = '$_GET[tid]' group by tid ORDER BY id ASC ";
       $result1 = mysql_query($query1,$conn1);
       $hardness = mysql_num_rows($result1);
       while($row1 = mysql_fetch_assoc($result1))
       {
          $fromwarehouse = $row1['fromwarehouse'];
          $towarehouse = $row1['towarehouse'];
          $dc = $row1['tmno'];
          $date = date('d/m/Y',strtotime($row1['date']));
		  $vehicleno = $row1['vehicleno'];
		  $driver = $row1['driver'];
       }

    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Broiler Integration Management System</title>
<script type="text/javascript" src="jquery-1.2.1.pack.js"></script>
<script type="text/javascript">
function empty(a)
{
  document.getElementById(a).value = "";
}

	function lookup(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("queryname.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	} // lookup
	
	function lookup1(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions1').hide();
		} else {
			$.post("queryname1.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions1').show();
					$('#autoSuggestionsList1').html(data);
				}
			});
		}
	} // lookup

	function lookup2(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions2').hide();
		} else {
			$.post("queryname2.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions2').show();
					$('#autoSuggestionsList2').html(data);
				}
			});
		}
	} // lookup

	function fill(thisValue) {
            if(document.getElementById("inputString").value == "") { document.getElementById("inputString").value = "Edit Name"; }
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
	}

	function fill1(thisValue) {
            if(document.getElementById("inputString1").value == "") { document.getElementById("inputString1").value = "Edit Name"; }
		$('#inputString1').val(thisValue);
		setTimeout("$('#suggestions1').hide();", 200);
	}

	function fill2(thisValue) {
            if(document.getElementById("inputString2").value == "") { document.getElementById("inputString2").value = "Edit Name"; }
		$('#inputString2').val(thisValue);
		setTimeout("$('#suggestions2').hide();", 200);
	}
</script>

<style type="text/css">
	body {
		font-family: Helvetica;
		font-size: 12px;
		color: #000;
	}
	
	h3 {
		margin: 0px;
		padding: 0px;	
	}

	.suggestionsBox {
		position: relative;
		left: 30px;
		margin: 10px 0px 0px 0px;
		width: 200px;
		background-color: #212427;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid #000;	
		color: #fff;
	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionList li {
		text-align:left;
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: #659CD8;
	}
</style>
<style type="text/css" media="print">
.printbutton {
  visibility: hidden;
  display: none;
}
</style>

</head>
<body>
<br />
<center>
<script>
document.write("<input type='button' " +
"onClick='window.print()' " +
"class='printbutton' " +
"value='Print This Page'/><br class='printbutton' /><br class='printbutton' />");
</script>
</center>
<br />
<br />
<?php
session_start();
 include "config.php"; $query = "SELECT * FROM home_logo "; 
     $result = mysql_query($query,$conn1); 
      while($row1 = mysql_fetch_assoc($result)) { $address = $row1['address'];
$image = $row1['image'];}

if($_SESSION['db'] == "feedatives")
{ ?>
<table align="center" border="0" width="80%">
<tr>
<td width="60%" style="vertical-align:middle" align="left"  ><img src="../logo/thumbnails/<?php echo $image; ?>" border="0px" /></td>
<td width="40%" style="vertical-align:middle; font-family:Georgia, 'Times New Roman', Times, serif; font-size:16px; text-align:left"  align="right" ><?php echo html_entity_decode($address1); ?></td>
</tr>
</table>
<?php } else {?>
<table align="center" border="0">
<tr>
<td style="vertical-align:middle"><img src="../logo/thumbnails/<?php echo $image; ?>" border="0px" /></td>
<td style="vertical-align:middle"><?php echo html_entity_decode($address); ?></td>
</tr>
</table>
<?php }?>
<table width="825px" border="0px">
   <tr><td width="500px" style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Start Location : </strong><?php echo $fromwarehouse; ?></td><td width="700px" style="text-align:center" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Date :</strong> <?php echo $date; ?></td></tr>
   <tr><td width="1900px" style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Delivery Location :</strong> <?php echo $towarehouse; ?></td><td width="300px" style="text-align:center"><strong>DC No. :</strong> <?php echo $dc; ?></td></tr>
     <tr><td width="500px" style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Vehicle Number :</strong> <?php echo $vehicleno; ?></td><td width="350px" style="text-align:center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Driver :</strong> <?php echo $driver; ?></td></tr>
</table>
<br />

<table border="1px">
  <tr>
    <th width="100px">Sl . No</th>
    <th width="300px">Item Code</th>
    <th width="200px">Description</th>
    <th width="200px">Quantity</th>
    <th width="200px">Rate</th>
    <th width="200px">Amount</th>
  </tr>

<?php
       $no = 1;
       include "config.php";
       $query1 = "SELECT * FROM ims_stocktransfer where tid = '$_GET[tid]' ORDER BY id ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {  
	   $desc = ""; 
	  $query = "SELECT description  FROM ims_itemcodes where code  = '$row1[code]' ";
       $result = mysql_query($query,$conn1);
         while($row = mysql_fetch_assoc($result))
       {
	   $desc = $row['description'];
	   }
?>
  <tr>
     <td><?php echo $no; ?></td>
     <td><?php echo $row1['code']; ?></td>
     <td><?php echo $desc; ?></td>
     <td><?php echo $row1['quantity']; ?></td> 
     <td><?php echo $row1['price']; ?></td>
     <td><?php echo $row1['quantity'] * $row1['price']; ?></td> 
  </tr>
<?php $no = $no + 1; } ?>
</table>
	<br/>
<table align="center">
    <tr style="font-weight:bold"><td width="375px">Sender Signature</td><td width="375px">Driver Signature</td></tr>
   
</table>
<br /><br />
</div>
</center>
</body>
</html>