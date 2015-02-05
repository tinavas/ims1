<?php include "jquery.php";
      include "getemployee.php";
      include "config.php"; 
	  
$q1 = "SELECT max(fdate) as fdate from ac_definefy ";
$result = mysql_query($q1,$conn);
while($row1 = mysql_fetch_assoc($result))
 {
 $fromdate = $row1['fdate'];
 $fromdate = date("d.m.Y",strtotime($fromdate));
 }
  	  
?>
<center>
<br />
<h1>Balance Sheet</h1> 
<br /><br /><br />
<form target="_new" action="production/balancesheet.php">
<?php if($_SESSION['db'] == "higain") { ?>
<table align="center">
<tr>
<td align="right"><strong>Location&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><select name="warehouse" id="warehouse" style="width:108px;">
           <option>-Select-</option>
           <option>All</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM tbl_sector where type1 = 'Warehouse' ORDER BY type ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['sector']; ?>" ><?php echo $row1['sector']; ?></option>
           <?php } ?>
         </select></td>
</tr>
</table>
<?php } ?>
<table align="center">
<tr>
<td align="right"><strong>From&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="date2" class="datepicker" name="date2" value="<?php echo $fromdate; ?>" onChange="datecomp();"></td>
<td width="10px"></td>
<td><strong align="right">To&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="date3" class="datepicker" name="date3" value="<?php echo date("d.m.o"); ?>" onChange="datecomp();" ></td>
</tr>
</table>
<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="report" value="Report" onclick="openreport();"/>
</form>
</center>


<script type="text/javascript">
function openreport()
{
var fromdate = document.getElementById('date2').value;
var todate = document.getElementById('date3').value;
<?php if($_SESSION['db'] == "albustan") { ?>
window.open('production/balancesheet_horizontal.php?fromdate=' + fromdate + '&todate=' + todate); 
<?php } else { ?>
window.open('production/balancesheet.php?fromdate=' + fromdate + '&todate=' + todate); 
<?php } ?>
}

function datecomp()
{
 

var dd = document.getElementById('date2').value;
var temp =  dd.split('.');
temp = temp[1] + '/' + temp[0] + '/' + temp[2];
var temp1 = new Date(temp);

var dd1 = document.getElementById('date3').value;
var temp3 =  dd1.split('.');
temp3 = temp3[1] + '/' + temp3[0] + '/' + temp3[2];
var temp4 = new Date(temp3);

 

if(temp1 > temp4)
{
 alert('To date must be greater than or equal to From date');
 document.getElementById('report').disabled = true;
}
else
{
 <?php 
 include "config.php"; 
$query1 = "select * from ac_definefy ";
$result1 = mysql_query($query1,$conn);
$num1 = mysql_num_rows($result1);
?>
<?php
while($row1 = mysql_fetch_assoc($result1))
{
  $tdate = date("d.m.Y",strtotime($row1['tdate']));
  $fdate = date("d.m.Y",strtotime($row1['fdate']));
  
  $detfdate = explode('.',$fdate);
  $dettdate = explode('.',$tdate);
  ?>
 var tempnew = document.getElementById('date2').value;
 var temp3new = document.getElementById('date3').value;
 tempnew = tempnew.split('.');
 temp3new = temp3new.split('.');
 
   if ( (tempnew[2] >= '<?php echo $detfdate[2]; ?>') && (tempnew[2] <= '<?php echo $dettdate[2]; ?>') ) { 
     
	   if ( temp3new[2] == '<?php echo $dettdate[2];  ?>' ) {
	      if ( temp3new[1] <= '<?php echo $dettdate[1]; ?>' ) 
		  {
		    document.getElementById('report').disabled = false;
		  }
		  else
		  {
		   alert("To date and From date are not of same financial year");
		   document.getElementById('report').disabled = true;
		  }
		  }
		else if ( temp3new[2] == '<?php echo $detfdate[2]; ?>' ) {
		  
		   if ( temp3new[1] >= '<?php echo $detfdate[1]; ?>' ) 
		  {
		    document.getElementById('report').disabled = false;
		  }
		  else
		  {
		   alert("To date and From date are not of same financial year");
		   document.getElementById('report').disabled = true;
		  }
		}
	     
	  }
	 
<?php 

    } ?>

}
 

}

function description()
{

	<?php
		$q = "select * from ims_itemcodes order by code";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(document.getElementById('code').value == '$qr[code]') { ";
		$q1 = "select code,description from ims_itemcodes where code = '$qr[code]'";
		$q1rs = mysql_query($q1) or die(mysql_error());
		if($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
	    document.getElementById('desc').value = "<?php echo $q1r['description']; ?>";
		
		<?php 
		}
		echo " } "; 
		}
		?>
		
}

function reloadpur()
{
 date2 = document.getElementById('date2').value;
 date2 = temp =  date2.split('.');
 var fdate =(date1[2] + '-' + date2[1] + '-' + date2[0]).toString();
 
 date3 = document.getElementById('date3').value;
 date3 = temp =  date3.split('.');
 var tdate =(date3[2] + '-' + date3[1] + '-' + date3[0]).toString();
}

</script>
<script type="text/javascript">
function script1() {
window.open('GLHelp/help_balancesheet.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
}
</script>


	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>
	

