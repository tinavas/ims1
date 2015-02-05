<?php include "timepicker.php"; 
$id = $_GET['id'];

$query = "select * from servicerenewal where renewalno = '$id' and client = '$client' order by id";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows11 = mysql_fetch_assoc($result);
$date = date("d.m.Y",strtotime($rows11['date']));
$fdate = date("d.m.Y",strtotime($rows11['fdate']));
$tdate = date("d.m.Y",strtotime($rows11['tdate']));
$servicecode=$rows11['servicecode'];
$period=$rows11['period'];

?>
<section class="grid_8">
  <div class="block-border">
   <form class="block-content form" style="height:600px" id="complex_form" name="form1" method="post" onSubmit="return validate();"  action="updateservicerenewal.php">
	  <h1 id="title1">Service Renewal</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>

<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">


<table align="left">
<tr height="30px"></tr>
<tr>

<td align="left"><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td><td align="left"><input type="text" name="date" id="date" class="datepicker" value="<?php echo $date; ?>" size="10"></td>
<td width="10px"></td>
<td align="left"><strong>Period</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td><td align="left"><select name="period" id="period" style="width:100px">
<option value="<?php echo $rows11['period']; ?>"><?php echo $rows11['period']; ?></option>
</select>
</td>
</tr>
<tr height="30px"></tr>
<tr>
<td align="left" title="Customer Name"><strong>Cust.Name</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td><td align="left"><input type="text" name="cname" id="cname" value="<?php echo $rows11['cname']; ?> " readonly />
										</td>	
                                        <td width="10px"></td>
<td align="left" title="Customer Number"><strong>Cust.N0#</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td><td align="left"><select name="ccode" id="ccode" style="width:100px" onChange="selectcust(this.value);">
                                        <option value="<?php echo $rows11['ccode']; ?>"><?php echo $rows11['ccode']; ?></option>
										</select>
										</td>

																	
</tr>
<tr height="30px"></tr>
</table>
<table align="left">
<tr height="15px"></tr>
<tr height="30px">
<table width="940px;">
<tr height="30px" style="width:935px;font-weight:bold;height:25px;color:#000000;font-size:18px;"> <td align="left"><strong>Service Details</strong></td></tr><tr height="30px"></tr>

</table></tr>
<table align="left" id="tab" class="table sortable no-margin">
<tr>

<th style="text-align:center;border-left:none;
	background:none repeat scroll 0 0 #1366A9;font-weight:bold;color:#FFFFFF;" title="Service Category Description"   ><span  class="column-sort" >
									
								</span>Ser.Cat.Desc</th>


<th style="text-align:center;background:none repeat scroll 0 0 #1366A9;font-weight:bold;color:#FFFFFF;" title="Service Code"  ><span class="column-sort">
									
								</span>Ser.Code</th>

<th style="text-align:center;background:none repeat scroll 0 0 #1366A9;font-weight:bold;color:#FFFFFF;" title="Service Description"  ><span class="column-sort">
									
								</span>Ser.Desc</th>

<th style="text-align:center;background:none repeat scroll 0 0 #1366A9;font-weight:bold;color:#FFFFFF;" title="Registration Number"  ><span class="column-sort">
									
								</span>Regis.No#</th>
<th style="text-align:center;background:none repeat scroll 0 0 #1366A9;font-weight:bold;color:#FFFFFF;" title="Start Date"  ><span class="column-sort">
									
								</span>Start.Date</th>
                                 <th style="text-align:center;background:none repeat scroll 0 0 #1366A9;font-weight:bold;color:#FFFFFF;" title="Charge/Unit"  ><span class="column-sort">
									
								</span>Charge/Unit</th>
<th style="text-align:center;background:none repeat scroll 0 0 #1366A9;font-weight:bold;color:#FFFFFF;" title="Additional Charges"  ><span class="column-sort">
									
								</span>Additional<br>Charges</th>
                            
                                <th style="text-align:center;background:none repeat scroll 0 0 #1366A9;font-weight:bold;color:#FFFFFF;" title="Valuation Units"  ><span class="column-sort">
								
								</span>Valuation<br>Units</th> 
<th style="text-align:center;background:none repeat scroll 0 0 #1366A9;font-weight:bold;color:#FFFFFF;" title="Amount"  ><span class="column-sort">
								
								</span>Amount</th>
</tr>


<tr>
<td style="background:none repeat scroll 0 0 #e5effa;border-top:1px solid #CCC;box-shadow: inset 0 1px 0 #CCC; border-right: blank
;"><select name="type" id="type" style="width:120px">
<option value="<?php echo $rows11['servicecatdesc']; ?>"><?php echo $rows11['servicecatdesc']; ?></option>
</td>

<td style="background:none repeat scroll 0 0 #e5effa;border-top:1px solid #CCC;box-shadow: inset 0 1px 0 #CCC; border-right: blank
;"><select name="code" id="code" style="width:100px">
<option value="<?php echo $rows11['servicecode']; ?>"><?php echo $rows11['servicecode']; ?></option>
</select>
</td>

<td style="background:none repeat scroll 0 0 #e5effa;border-top:1px solid #CCC;box-shadow: inset 0 1px 0 #CCC; border-right: blank
;"><select name="desc" id="desc" style="width:100px">
<option value="<?php echo $rows11['servicedesc']; ?>"><?php echo $rows11['servicedesc']; ?></option>
</select>
</td>

<td align="left" style="background:none repeat scroll 0 0 #e5effa;border-top:1px solid #CCC;box-shadow: inset 0 1px 0 #CCC; border-right: blank
;"><select name="regno" id="regno" style="width:80px">
<option value="<?php echo $rows11['regno']; ?>"><?php echo $rows11['regno']; ?></option>
</select>
</td>	

<td align="left" style="background:none repeat scroll 0 0 #e5effa;border-top:1px solid #CCC;box-shadow: inset 0 1px 0 #CCC; border-right: blank
;"><input type="text" name="fdate" id="fdate" onChange="charge1(this.value,1);getamount(1);" class="datepicker"  value="<?php echo date("d.m.Y",strtotime($rows11['fdate'])); ?>" size="9"></td>

<td style="background:none repeat scroll 0 0 #e5effa;border-top:1px solid #CCC;box-shadow: inset 0 1px 0 #CCC; border-right: blank
;"><input type="hidden" name="mode" id="mode" value="<?php echo $rows11['mode']; ?>">
<input type="text" name="ucharges" id="ucharges" value="<?php echo $rows11['unitcharges']; ?>" onKeyUp="getamount();" size="8" onKeyPress="validatekey(event.keyCode)">
</td>

<td style="background:none repeat scroll 0 0 #e5effa;border-top:1px solid #CCC;box-shadow: inset 0 1px 0 #CCC; border-right: blank
;"><input type="text" name="acharges" readonly="true" id="acharges" value="<?php echo $rows11['acharges']; ?>" size="8"></td>

<td align="left" style="background:none repeat scroll 0 0 #e5effa;border-top:1px solid #CCC;box-shadow: inset 0 1px 0 #CCC; border-right: blank
;"><input type="text" name="vamt" id="vamt" onKeyUp="getamount();" value="<?php echo $rows11['vamt']; ?>" size="8" onKeyPress="validatekey(event.keyCode)"></td>																																			
									
<td align="left" style="background:none repeat scroll 0 0 #e5effa;border-top:1px solid #CCC;box-shadow: inset 0 1px 0 #CCC; border-right: blank
;"><input type="text" name="amt" id="amt" readonly="true" size="8" value="<?php echo $rows11['amt']; ?>" onKeyPress="validatekey(event.keyCode)"></td>
</tr>										 																							
</table>
</table>
<table align="left">
<tr height="10px"></tr>
<tr>
<td align="left"><strong>Narration</strong>&nbsp;&nbsp;&nbsp;</td><td align="left"><textarea rows="5" cols="70" id="return" name="return"><?php echo $rows11['narration']; ?></textarea></td>
</tr>
<tr height="25px"></tr>
<tr >

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td>&nbsp;&nbsp;&nbsp;</td><td align="center"><input type="submit" value="Update">&nbsp;&nbsp;&nbsp;

<input type="button" name="Cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=servicerenewal';"/></td>
</tr>																										
</table>


</center>
</form> 
</div>
</section>
<script type="text/javascript">
function charge1(d,m1)
{
	

	var startdate=d;
	var period=document.getElementById('period').value;
	<?php
	$query="select * from period ";
		$result=mysql_query($query,$conn) or die(mysql_error());	
		while($rows=mysql_fetch_assoc($result))
		{
			 $code=$rows['code'];
		?>
		if(period == "<?php echo $code;?>")	  
	{	
		
		<?php
	    
	 $query11="select tdate from period where code='$code'";
		$result11=mysql_query($query11,$conn) or die(mysql_error());	
		while($rows11=mysql_fetch_assoc($result11))
		{
			$t12date=$rows11['tdate'];
		}		
	?>
	var s34="<?php echo $t12date; ?>";
	
	}	 
			
	<?php } ?>
	
var second23=s34;


var split1=second23.split("-");

var split2=startdate.split(".");






Date.monthsDiff= function(day1,day2){
	var d1= day1,d2= day2;
	if(day1<day2){
		d1= day2;
		d2= day1;
	}
	var m= (d1.getFullYear()-d2.getFullYear())*12+(d1.getMonth()-d2.getMonth());
	if(d1.getDate()<d2.getDate()) --m;
	return m;
}

var d1= new Date(split2[2],split2[1],split2[0]);
var d2= new Date(split1[0],split1[1],split1[2]);

var diff=Date.monthsDiff(d1,d2); 


amount1(m1,diff);
	
}


function validatekey(a)
{ 
 if((a<48 || a>57) && a!=46 && a!=13)	//48-57 are for0-9; 46 is for .(dot-decimal); 13 for Enter key 
  event.keyCode=false;
} 

function validate()
{}

function script1() {
window.open('servicehelp/servicerenhelp.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
}

function getamount(m)
{
	
var ucharges = document.getElementById('ucharges' ).value;


var vamt = document.getElementById('vamt' ).value;
var mode = document.getElementById('mode' ).value;
var acharges = document.getElementById('acharges' ).value;

if(acharges == '')
acharges = 0;

if(mode == 'Flat')
{
var ht = ucharges;
var gt = Number(ht) + Number(acharges);

document.getElementById('amt' ).value = gt;
}
else if(mode == 'Per')
{

document.getElementById('amt' ).value = (((ucharges * vamt) / 100) + Number(acharges));
}
else if(mode == "Unit")
{
var th = (ucharges*vamt);
var kt = Number(th) + Number(acharges);


document.getElementById('amt' ).value = kt;
}
}
function amount1(m,diff)
{
	
var code = "<?php echo $servicecode ;?>";

var code = code;


<?php 
$query = "select distinct(code) from servicemasters order by code";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
?>
if(code == "<?php echo $rows['code']; ?>")
{

<?php 
if($period == '')
$q = "select charges,acharges from servicecharges where servicecode = '$rows[code]' and period = '$period' order by servicecode";
else
 $q = "select charges,acharges from servicecharges where servicecode = '$rows[code]' and period = '$period' order by servicecode";
$r = mysql_query($q,$conn) or die(mysql_error());
while($row = mysql_fetch_assoc($r))
{
$charges = $row['charges'];
if($charges == '')
$charges = 0;
$acharges = $row['acharges'];
if($acharges == '')
$acharges = 0;
?>

var total1="<?php echo $charges; ?>";

var t12=Number(total1/12);

var t13=t12*diff;
var t14=Math.round(t13,2);

document.getElementById('ucharges').value = t14;

document.getElementById('acharges' ).value = "<?php echo $acharges; ?>";
<?php } 
$query1 = "select distinct(mode) from servicemasters where code = '$rows[code]' order by code";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
document.getElementById('mode' ).value = "<?php echo $rows1['mode']; ?>";
<?php } ?>
}
<?php } ?>
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
<br><br>
<body>
</body>
</html>
