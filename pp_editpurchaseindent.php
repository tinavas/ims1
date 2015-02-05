
<body>
<?php 
 include "config.php";
 include "jquery.php";
 
 $q1=mysql_query("SET group_concat_max_len=10000000");
$query="select sector,group_concat(distinct(name)) as name from hr_employee group by sector";
$result=mysql_query($query,$conn);
$i=0;
while($r=mysql_fetch_array($result))
{
$sec[$i]=array("sector"=>"$r[sector]","name"=>"$r[name]");
$i++;
} 
$sectors=json_encode($sec);





	    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
	 $i=0;
		if($sectorlist=="")  
$q1 = "SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 =  'warehouse'";
else

$q1 = "SELECT GROUP_CONCAT( DISTINCT (sector) ORDER BY sector ) as sector FROM tbl_sector WHERE type1 =  'warehouse' and sector in ($sectorlist)";


 $res1 = mysql_query($q1,$conn); 


$rows1 = mysql_fetch_assoc($res1);
     {
	 
 $sec1=explode(",",$rows1["sector"]);	
			
			
	 }
	 
	 $sector=json_encode($sec1);

 ?>
 
 <script type="text/javascript">

var items=<?php if(empty($item)){ echo "0";} else{ echo $item;}?>;
var sectors=<?php if(empty($sectors)){ echo "0";} else{ echo $sectors;}?>;
var sectors1=<?php if(empty($sector)){ echo "0";} else{ echo $sector;}?>;

</script>

<center>

<section class="grid_8">
  <div class="block-border">

<form action="pp_updatepurchaseindent.php" method="post" onsubmit="return checkform()" class="block-content form">

<h1>Purchase Request</h1>

<br />

<b>Purchase Request(Edit) &nbsp;&nbsp;&nbsp;&nbsp;</b>
<br />


(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />




<table border="0" align="center">
<tr>
<td><strong>Requisition No&nbsp;&nbsp;&nbsp;</strong></td>
<td><?php $pi = $_GET['pi']; $query1 = "SELECT * FROM pp_purchaseindent where pi = '$pi' "; $result1 = mysql_query($query1,$conn);
    while($row1 = mysql_fetch_assoc($result1)) {
	 $piincr = $row1['piincr']; $m = $row1['m']; $y = $row1['y']; $date = $row1['date'];  $empname=$row1['empname'];
	 $remarks = $row1['remarks'];
     }
   $date = date("j.m.Y", strtotime($date));
   ?>
<input type="text" name="rno" id="rno" value="<?php echo $pi; ?>" readonly style="border:0px;background:none"   />
</td>
<td><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" size="15" id="ddate" name="ddate" readonly class="datepicker" value="<?php echo $date ?>" onchange="pi();" ></td>
</tr>
<tr style="height:20px"></tr>
</table>

<input type="hidden" id="oldpi" name="oldpi" value="<?php echo $pi;?>" />
<input type="hidden" name="m" id="m" value="<?php echo $m; ?>" />
<input type="hidden" name="y" id="y" value="<?php echo $y; ?>" />
<input type="hidden" name="piincr" id="piincr" value="<?php echo $piincr; ?>" />
<input type="hidden" name="cuser" id="cuser" value="<?php echo $empname;?>" /><br />
<br />
<br />

<table id="test" border="0" align="center">
<tr>
<th><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Item Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Quantity</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Units</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th title="Requesting Delivery Date"><strong>Req. Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Delivery Office</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Receiver</strong></th>
<th width="10px"></th>

</tr>

<tr style="height:20px"></tr>
<?php $index = 0; $query = "SELECT * FROM pp_purchaseindent where pi = '$pi' ORDER BY id ASC "; $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result)) { $index =  $index + 1; ?>
<tr>
<td>
<select name="type[]" id="type<?php echo $index; ?>" readonly style="width:90px;">

<option value="<?php echo $row1['cat']; ?>" selected="selected"><?php echo $row1['cat']; ?></option>


</select></td>
<td width="10px"></td>
<td><select name="code[]" id="code<?php echo $index; ?>" readonly style="width:80px;">
    <option value="<?php echo $row1['icode']; ?>" selected="selected"><?php echo $row1['icode']; ?></option>
    </select></td>
<td width="10px"></td>
<td><input type="text" name="ing[]" id="ing<?php echo $index;?>" value="<?php echo $row1['name'];?>" readonly size="25"  /></td>
<td width="10px"></td>
<td><input type="text" name="ingweight[]" id="ingweight<?php echo $index;?>"  value="<?php echo $row1['quantity']; ?>" size="8" onkeypress="return num(event.keyCode)"  /></td>
<td width="10px"></td>
<td width="30px"><input type="text" name="unit[]" id="unit<?php echo $index;?>" value="<?php echo $row1['units']; ?>" readonly size="8"  style="background:none; border:0px;" /></td>
<td width="10px"></td>
<?php
 $rdate = $row1['rdate'];
 $rdate = date("d.m.Y",strtotime($rdate));
 ?>
<td width="70px"><input type="text" size="15" id="rdate<?php echo $index;?>" name="rdate[]" class="datepicker" value="<?php echo $rdate; ?>"></td>
<td width="10px"></td>
<td><select name="doffice[]" id="doffice<?php echo $index;?>" onchange = "getemp(this.id);" style="width:150px;">
       <option value="">-Select-</option>
<?php 


 for($j=0;$j<count($sec1);$j++)
		   {

 if ( $row1['doffice'] == $sec1[$j] ) {
	  ?><option value="<?php echo $sec1[$j]; ?>" selected="selected" title="<?php echo $sec1[$j]; ?>"><?php echo $sec1[$j]; ?></option>
<?php }
 else { 
 ?><option value="<?php echo $sec1[$j]; ?>" title="<?php echo $sec1[$j]; ?>"><?php echo $sec1[$j]; ?></option>
 
<?php } 

	} ?></select></td>
<td width="10px"></td>
<td><select name="demp[]" id="demp<?php echo $index;?>"  style="width:150px;">
      <option value="">-Select-</option>
	  <?php if($row1['receiver']!=""){?> 
      <option value="<?php echo $row1['receiver']; ?>" selected="selected" ><?php echo $row1['receiver']; ?></option>
	  <?php } ?>
   </select></td>
<td width="10px"></td>

</tr>
<?php } ?>
</table>
<br />
<br />

<table align="center">
<td style="vertical-align:middle;"><strong>Remarks&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"><?php echo $remarks; ?></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br />
<br />
<center>
<input type="submit" value="Update" id="save" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_purchaseindent';">
</center>
<br />
<br />

</form>
</div>
</section>
</center>
</body>
<br />
<br />



<script type="text/javascript">

function checkform()
{
document.getElementById("save").disabled=true;

}

function num(b)
{
if((b<48 || b>57) &&(b!=46))
{
event.keyCode=false;
return false;
}

}



//Requesition Starts ///
function pi()
{
  var date1 = document.getElementById('ddate').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var piincr = new Array();
    var pr = "";
	var c=0;
  <?php 
  
   include "config.php"; 
   $query1 = "SELECT MAX(piincr) as piincr,m,y FROM pp_purchaseindent GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
   
   
?>

if(m==<?php echo $m;?> && y== <?php echo $y; ?>)
c=1;

     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     piincr[<?php echo $k; ?>] = <?php echo $row1['piincr']; ?>;

<?php $k++; } ?>
m1=Number(m);
y1=Number(y);


if(m1!="<?php echo $m;?>" || y1!="<?php echo $y;?>")
{


for(var l = 0; l <= <?php echo $k; ?>;l++)
{
 if((yea[l] == y) && (mon[l] == m))
  { 
   if(piincr[l] < 10)
     pr = 'PR'+'-'+m+y+'-000'+parseInt(piincr[l]+1);
   else if(piincr[1] < 100 && piincr[1] >= 10)
     pr = 'PR'+'-'+m+y+'-00'+parseInt(piincr[l]+1);
   else
     pr = 'PR'+'-'+m+y+'-0'+parseInt(piincr[l]+1);
  document.getElementById('piincr').value = parseInt(piincr[l] + 1);
  break;
  }
 else
  {
   pr = 'PR'+'-'+m+y+'-000'+parseInt(1);
     document.getElementById('piincr').value = 1;
  }
}
  document.getElementById('rno').value = pr;
document.getElementById('m').value = m;
document.getElementById('y').value =y;




}

else
{
document.getElementById('pr').value="<?php echo $pi;?>";

}


}
///Requisition Ends ///


function getemp(b)
{
var a=b.substr(7,b.length);

document.getElementById("demp" + a).options.length=1;
			 myselect1 = document.getElementById("demp" + a);
              
			   
			   
			    var p=sectors.length;
			  var x=document.getElementById('doffice'+a).value;
 			  for(n=0;n<p;n++)
			  {
				  if(sectors[n].sector==x)
				  {	var name1=sectors[n].name;
					 var name=name1.split(',');
					  for(k=0;k<name.length;k++)
					  {
					  
					  theOption1=new Option(name[k],name[k]);
   					  myselect1.options.add(theOption1);
			   	
             
					  }
				  }
			  }
			   
	

} 




</script>
<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_editpurreq.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
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