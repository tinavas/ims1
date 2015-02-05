<?php 
include "jquery.php";
include "config.php"; 
$client = $_SESSION['client'];

$q1=mysql_query("select group_concat(name,'/',employeeid) as name,sector as warehouse from hr_employee where (sector!=' ' or sector is not null) group by sector order by name",$conn) or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{
$sec[]=$r1['warehouse']."@".$r1['name'];
}
$sec1=json_encode($sec);
?>
<script type="text/javascript">
var sec=<?php if(empty($sec1)){echo "0";} else{ echo $sec1; }?>;
</script>
<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="min-height:600px" id="complex_form" name="form" method="post" onSubmit="return checkform(this)" action="hr_saveemptransfer.php" >
	  <h1 id="title1">Employee Transfer</h1>
		
  
<br />
<b>Employee Transfer</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />

<br /><br />

<input type="hidden" name="saed" id="saed" value="save" />
<table align="center">
<tr>
 
 <td align="right"><strong>From Sector</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><select id="fromwarehouse" name="fromwarehouse" style="width:180px;" onChange="getemp()">
         <option value="">-Select-</option>
 <?php
for($i=0;$i<count($sec);$i++)
		   {		
		   $sector=explode('@',$sec[$i]);
		   $sector=$sector[0];
		   if($sector!='')
		   {
           ?>
<option value="<?php echo $sector;?>" title="<?php echo $sector; ?>"><?php echo $sector; ?></option>
<?php }} ?>
       </select>
 </td>
  <td align="right"><strong>Employee</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><select id="emp" name="emp" style="width:180px;">
         <option value="">-Select-</option>
       </select>
 </td>
 <td align="right"><strong>To Sector</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><select id="towarehouse" name="towarehouse" style="width:180px;">
         <option value="">-Select-</option>
 <?php
for($i=0;$i<count($sec);$i++)
		   {		
		   $sector=explode('@',$sec[$i]);
		   $sector=$sector[0];
		   if($sector!='')
		   {
           ?>
<option value="<?php echo $sector;?>" title="<?php echo $sector; ?>"><?php echo $sector; ?></option>
<?php }} ?>
<td align="right"><strong>Leaving Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><input type="text" size="15" id="ldate" name="ldate" class="datepicker" value="<?php echo date("d.m.Y"); ?>" />&nbsp;&nbsp;&nbsp;</td>
 <td align="right"><strong>Joining Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><input type="text" size="15" id="jdate" name="jdate" class="datepicker" value="<?php echo date("d.m.Y"); ?>" />&nbsp;&nbsp;&nbsp;</td>

       </select>
 </td>
 
</tr>
<tr style="height:20px"></tr>
</table>
<br />
<table>
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br />
<br/>

<table align="center">
<tr>
<td colspan="5" align="center">
<center>
<input type="submit" id="Save" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" id="Cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=hr_emptransfer';"/>
</center>
</td>
</tr>
</table>
</form>
</div>
</section>
</center>
	<script type="text/javascript">
function getemp()
{
document.getElementById("emp").options.length=1;
var fromsec=document.getElementById("fromwarehouse").value;
var myselect1=document.getElementById("emp");
for(i=0;i<sec.length;i++)
{
var sec1=sec[i].split('@');
var sec2=sec1[1].split(',');

if(sec1[0]==fromsec)
{
//alert(sec1[0]);
for(j=0;j<sec2.length;j++)
{
var name=sec2[j].split('/');
var theOption=new Option(name[0],sec2[j]);
myselect1.options.add(theOption);
}
}
}
}
	function checkform()
	{
	var warehouse=document.getElementById("fromwarehouse").value;
	if(warehouse=="")
	  {
	  	alert("Select Fromwarehouse");
		return false;
	  }
	  	var twarehouse=document.getElementById("towarehouse").value;
	if(twarehouse=="")
	  {
	  	alert("Select Towarehouse");
		return false;
	  }
	if(warehouse==twarehouse)
	{
		alert("From warehosue and towarehouse should be differeent for 1st row");
		return false;
	}
/*	for(j=-1;j<index;j++)
	{
	var cat =document.getElementById("cat@"+j).value;
	var code= document.getElementById("code@"+j).value;
	var desc =document.getElementById("desc@"+j).value;
	var towarehouse= document.getElementById("towarehouse@"+j).value;
	var qty=document.getElementById("squantity@"+j).value;
	if(warehouse==towarehouse)
	{
		alert("From warehosue and towarehouse should be differeent for"+j+"row");
		return false;
	
	}
	
}*/
	document.getElementById('Save').disabled=true;
	}
function script1() {
window.open('IMSHelp/help_t_addstocktransfer.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
</body>
<script type="text/javascript">
///////////////makeform//////////////
var index = -1;
function makeForm(a) {/*
var temp=a.split('@');
 var id=temp[1];

if(id!=index)
return false;
index = index + 1 ;

var i,b;
table=document.getElementById("paraID");
tr = document.createElement('tr');
tr.align = "center";

////////space td//////////////
var b1 = document.createElement('td');
myspace1= document.createTextNode('\u00a0');
b1.appendChild(myspace1);
////////space td//////////////

////////category td//////////////
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "cat[]";
myselect1.id = "cat@" + index;
myselect1.style.width = "120px";
var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { getcode(this.id); };
  for(i=0;i<items.length;i++)
{
 var theOption=new Option(items[i].cat,items[i].cat);
myselect1.options.add(theOption);
} 
td.appendChild(myselect1);
//////////category td/////////

tr.appendChild(b1);
tr.appendChild(td);

////////space td//////////////
var b2 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
b2.appendChild(myspace2);
////////space td//////////////

////////item code td//////////////
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "code[]";
myselect1.id = "code@" + index;
myselect1.style.width = "75px";

var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { selectdesc(this.id,this.value); };

td.appendChild(myselect1);

// for description start

myselect1 = document.createElement("select");
myselect1.name = "desc[]";
myselect1.id = "desc@" + index;
myselect1.style.width = "130px";
var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { selectcode(this.id,this.value); };

// for description end
//////////item code td/////////

tr.appendChild(b2);
tr.appendChild(td);

////////space td///////////
var b3 = document.createElement('td');
myspace3= document.createTextNode('\u00a0');
b3.appendChild(myspace3);
/////////////space td//////

/////////////description////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="15";
mybox1.type="hidden";
mybox1.name="description[]";
mybox1.id = "description@" + index;

td.appendChild(mybox1);
td.appendChild(myselect1); // for description
//////////fdescription td//////

tr.appendChild(b3);
tr.appendChild(td);
////////space td//////////////
var b5 = document.createElement('td');
myspace5= document.createTextNode('\u00a0');
b5.appendChild(myspace5);
////////space td//////////////

////////towarehouse td//////////////
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "towarehouse[]";
myselect1.id = "towarehouse@" + index;
myselect1.style.width = "140px";

var op1=new Option("-Select-","");
myselect1.options.add(op1);
          
            for(j=0;j<sectors1.length;j++)
		   {
		   	var theOption=new Option(sectors1[j],sectors1[j]);
			myselect1.options.add(theOption);
		   } 
td.appendChild(myselect1);
//////////towarehouse td/////////

tr.appendChild(b5);
tr.appendChild(td);

table.appendChild(tr);
*/}
///////////////end of make form////////////////
</script>
<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>