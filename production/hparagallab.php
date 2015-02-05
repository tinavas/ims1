<?php
       include "config.php";

       $query1 = "SELECT * FROM lab_hparagalab where trid = '$_GET[trid]' group by trid ORDER BY id ASC ";
       $result1 = mysql_query($query1,$conn1);
       $hardness = mysql_num_rows($result1);
       while($row1 = mysql_fetch_assoc($result1))
       {
          $source = $row1['source'];
          $collectedby = $row1['collectedby'];
          $sampledate = $row1['sampledate'];
          $sampledate = date('j/m/y',strtotime($sampledate));
          $reportdate = $row1['reportdate'];
          $reportdate = date('j/m/y',strtotime($reportdate));
		  $remarks = $row1['remarks'];
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
   <tr><td width="500px" style="text-align:left"><strong>Sampled on : </strong><?php echo $sampledate; ?></td><td width="300px" style="text-align:right" ><strong>Reported on :</strong> <?php echo $reportdate; ?></td></tr>
   <tr><td width="500px" style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Source :</strong> <?php echo $source; ?></td><td width="300px" style="text-align:right"><strong>Collected By :</strong> <?php echo $collectedby; ?></td></tr>
</table>
<br />

<table border="1px">
  <tr>
    <th width="100px">Sl . No</th>
    <th width="300px">Sample</th>
    <th width="200px">Mac Agar Plate</th>
    <th width="200px">Blood Agar Satellitism</th>
    <th width="200px">Choclate Agar Growth</th>
    <th width="200px">Catalase</th>
  </tr>

<?php
       $no = 1;
       include "config.php";
       $query1 = "SELECT * FROM lab_hparagalab where trid = '$_GET[trid]' ORDER BY id ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {   
?>
  <tr>
     <td><?php echo $no; ?></td>
     <td><?php echo $row1['sample']; ?></td>
     <td><?php echo $row1['macagar']; ?></td>
     <td><?php echo $row1['bloodagar']; ?></td> 
     <td><?php echo $row1['choclateagar']; ?></td>
     <td><?php echo $row1['catalase']; ?></td> 
  </tr>
<?php $no = $no + 1; } ?>
</table>
<br />
<table width="825px"><tr><td style="text-align:left">Note : </td><td style="text-align:left"><?php echo $remarks; ?></td></tr></table>
<br /><br />
<table>
    <tr style="font-weight:bold"><td width="275px">Analysed</td><td width="275px">Checked By</td><td width="275px">Lab Incharge</td></tr>
    <tr height="10px"><td></td></tr>
    <tr style="font-weight:bold">
      <td width="275px" valign="top">
          <div>
		<form name="form1" id="form1">
			<div>
				<input type="text" size="30" style="text-align:center;border:0px" value="Edit Name" id="inputString" onkeyup="lookup(this.value);" onblur="fill();" onfocus="empty(this.id)" />
			</div>
			
			<div class="suggestionsBox" id="suggestions" style="display: none;">
				<img src="upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsList">
					&nbsp;
				</div>
			</div>
		</form>      
          </div>
      </td>
      <td width="275px" valign="top">
          <div>
		<form name="form2" id="form2">
			<div>
				<input type="text" size="30" style="text-align:center;border:0px" value="Edit Name" id="inputString1" onkeyup="lookup1(this.value);" onblur="fill1();" onfocus="empty(this.id)" />
			</div>
			
			<div class="suggestionsBox" id="suggestions1" style="display: none;">
				<img src="upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsList1">
					&nbsp;
				</div>
			</div>
		</form>      
          </div>
      </td>
      <td width="275px" valign="top">
          <div>
		<form name="form3" id="form3">
			<div>
				<input type="text" size="30" style="text-align:center;border:0px" value="Edit Name" id="inputString2" onkeyup="lookup2(this.value);" onblur="fill2();" onfocus="empty(this.id)" />
			</div>
			
			<div class="suggestionsBox" id="suggestions2" style="display: none;">
				<img src="upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsList2">
					&nbsp;
				</div>
			</div>
		</form>      
          </div>
      </td>
   </tr>
</table>
<br /><br />
</div>
</center>
</body>
</html>