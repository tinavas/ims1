<?php 
include "config,php"; 
include "jquery.php";

$q1=mysql_query("select farmcode, group_concat(distinct house) as f from broiler_flock group by farmcode",$conn) or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{
$f[]=$r1[farmcode];
$fh[]=array("farm"=>$r1[farmcode],"house"=>$r1[f]);
}
$fh1=json_encode($fh);
$q1=mysql_query("select house, group_concat(distinct flock) as f from broiler_flock group by house",$conn) or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{
$ff[]=array("house"=>$r1[house],"flock"=>$r1[f]);
}
$ff1=json_encode($ff);

$q1=mysql_query("select date_add(max(date),interval 1 day) as date,max(age) as age,flock from broiler_consumption group by flock",$conn) or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{
$con[]=array("date"=>$r1[date],"flock"=>$r1[flock],"age"=>$r1[age]);
}
$con1=json_encode($con);

$q1=mysql_query("select min(date) as date,flock  from pp_sobi where code in (select code from ims_itemcodes where cat like 'Broiler Chicks') group by flock",$conn) or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{
$sobi[]=array("date"=>$r1[date],"flock"=>$r1[flock]);
}
$sobi1=json_encode($sobi);

$q1=mysql_query("select min(date) as date,flock  from hatchery_chickreceiving group by flock",$conn) or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{
$chick[]=array("date"=>$r1[date],"flock"=>$r1[flock]);
}
$chick1=json_encode($chick);
?>
<script type="text/javascript">
var fh=<?php echo $fh1;?>;
var ff=<?php echo $ff1;?>;
var sobi=<?php echo $sobi1;?>;
var con=<?php echo $con1;?>;
var chick=<?php echo $chick1;?>;
</script>
<br />
<center>
<h1>Broiler Daily Entry</h1>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
</center>

<form id="form1" name="form1" method="post" action="broiler_savedailyentry.php" onSubmit="return chk();">
<input type="hidden" name="saed" id="saed" value="save" />

<br /><br />

<table id="paraID" align="center">
<tr align="center">
<td><strong>Farm <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>House <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Flock<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>    </strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Age<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>    </strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Date</strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Mort</strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Cull</strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Feed Type<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>    </strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Feed<br><font size="1px">(In Kg's)<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>    </font></strong></td>
		


<td>&nbsp;&nbsp;</td>
<td><strong title="Average Weight">Avg.Wgt<br><font size="1px">(In Gms)</font></strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Water</strong></td>

</tr>
<tr height="10px"><td></td></tr>

<tr align="center">
<input type="hidden" id="dispflock" value=""/>
<input type="hidden" id="dispage" value=""/>
<input type="hidden" id="dispdate" value=""/>
<input type="hidden" id="dispflock1" value=""/>
<input type="hidden" id="dispage1" value=""/>
<input type="hidden" id="dispdate1" value=""/>
<input type="hidden" id="trc1" value=""/>
<input type="hidden" id="prc1" value=""/>

<td>
<select name="farm[]" id="farm@0" style="width:120px" onChange="getplace(this.id);">
<option value="">-Select-</option>

<?php
           for($i=0;$i<count($f);$i++)
		   {
		   $farm=explode("@",$f[$i]);
?>
<option value="<?php echo $farm[0]; ?>" title="<?php echo $farm[0]; ?>"><?php echo $farm[0]; ?></option>
<?php  } ?>
</select>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<select name="place[]" id="place@0" style="width:120px" onChange="getflock(this.id);">
<option value="">-Select-</option>
</select>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<select name="flock[]" id="flock@0" style="width:120px" onChange="getdate(this.id,this.value),chkflk(this.id)">
<option value="">-Select-</option>
</select></td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="age[]" id="age@0" size="2" readonly />
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="date1[]" id="date1@0" size="10" readonly />
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="mort[]" id="mort@0" size="2" value="0" />
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="cull[]" id="cull@0"size="2" value="0"/>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<select name="feedtype[]" id="feedtype@0" style="width:100px">
<option value="">-Select-</option>
	    <?php 
			     include "config.php";
	             $query = "SELECT distinct(code),description FROM ims_itemcodes WHERE cat = 'Broiler Feed' ORDER BY code ASC";
		         $result = mysql_query($query,$conn);
 		         while($row = mysql_fetch_assoc($result))
		         {
            ?>
	 <option value="<?php echo $row['code'];?>" title="<?php echo $row['description'];?>"><?php echo $row['code']; ?></option>
	        <?php } ?>
</select>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="consumed[]" id="consumed@0" size="4" value="0"/>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="weight[]" id="weight@0" size="4" value="0"/>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="water[]" id="water@0" value="0"  size="4" onFocus="makeForm()" />
</td>

</tr>
</table>


<center>
<br />
<br />
<input type="submit" value="Save" id="Save"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=broiler_dailyentry';">
</center>

</form>

<div class="clear"></div>
<br />

<script type="text/javascript">
function script1() {
window.open('BroilerHelp/Help_t_addbrdailyentry.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
<br />
<body> 
<script type="text/javascript">
 function getplace(id)
 {
 var ind=id.split('@');
 document.getElementById("place@"+ind[1]).options.length=1;
var val=document.getElementById(id).value;
 for(i=0;i<fh.length;i++)
 {
 if(fh[i].farm==val)
 {
 var hous=ff[i].house.split(',');
for(j=0;j<hous.length;j++)
{
var op=new Option(hous[j],hous[j]);
op.title=hous[j];
document.getElementById("place@"+ind[1]).options.add(op);
 }
 }
  }
 }
  function getflock(id)
 {
 var ind=id.split('@');
 document.getElementById("flock@"+ind[1]).options.length=1;
var val=document.getElementById(id).value;
 for(i=0;i<ff.length;i++)
 {
 if(ff[i].house==val)
 {
 var flk=ff[i].flock.split(',');
for(j=0;j<flk.length;j++)
{
var op=new Option(flk[j],flk[j]);
op.title=flk[j];
document.getElementById("flock@"+ind[1]).options.add(op);
}
 }
  }
 }
function getdate(a,b)
{

var ind=a.split('@');
document.getElementById("age@"+ind[1]).value="";
document.getElementById("date1@"+ind[1]).value="";
if(con!=null)
for(i=0;i<con.length;i++)
{
if(con[i].flock==b)
{
document.getElementById("age@"+ind[1]).value=con[i].age;
document.getElementById("date1@"+ind[1]).value=con[i].date;
}
}
else if(sobi!=null)
for(i=0;i<sobi.length;i++)
{
if(sobi[i].flock==b)
{
if(chick!=null )
{
for(j=0;j<chick.length;j++)
{
if(chick[j].flock==b)
{
document.getElementById("age@"+ind[1]).value=1;
document.getElementById("date1@"+ind[1]).value=chick[j].date;
var sd=sobi[i].date.split("-");
var cd=chick[i].date.split("-");
var sd1=sd[0]+"/"+sd[1]+"/"+sd[2];
var cd1=cd[0]+"/"+cd[1]+"/"+cd[2];
var sd11=new Date(sd1);
var cd11=new Date(cd1);
if(sd11.getTime()>cd11.gettime())
{
document.getElementById("date1@"+ind[1]).value=chick[j].date;
}
else
{
document.getElementById("date1@"+ind[1]).value=sobi[j].date;
}
}
}
}
else
{
document.getElementById("date1@"+ind[1]).value=sobi[j].date;

}
}
}
else if(chick!=null)
for(j=0;j<chick.length;j++)
{
if(chick[j].flock==b)
{
document.getElementById("age@"+ind[1]).value=1;
document.getElementById("date1@"+ind[1]).value=chick[j].date;
}
}

}

var index = 0;
function makeForm() {
if((document.getElementById('feedtype@' + index).value != "")&&(document.getElementById('feedtype@' + index).value != "-Select-")&& (document.getElementById('age@' + index).value != "0") && (document.getElementById('age@' + index).value != ""))
{
index = index + 1;
///////////para element//////////

table=document.getElementById("paraID");
tr = document.createElement('tr');
tr.align = "center";

td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "farm[]";
myselect1.id = "farm@" + index;
myselect1.style.width = "120px";
myselect1.onchange = function ()  {  getplace(this.id); };

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);

<?php
         for($k=0;$k<count($f);$k++)
		 {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $f[$k]; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $f[$k]; ?>";
myselect1.appendChild(theOption1);
<?php } ?>

td.appendChild(myselect1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "place[]";
myselect1.id = "place@" + index;
myselect1.style.width = "120px";
myselect1.onchange = function ()  {  getflock(this.id); };

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);

td.appendChild(myselect1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "flock[]";
myselect1.id = "flock@" + index;
myselect1.style.width = "120px";
myselect1.onchange = function ()  {  getdate(this.id,this.value); };

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);

td.appendChild(myselect1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);


td = document.createElement('td');
mybox1=document.createElement("input");

mybox1.size="2";

mybox1.type="text";

mybox1.name="age[]";

mybox1.setAttribute("readonly",true);


mybox1.id = "age@" + index;

td.appendChild(mybox1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);


td = document.createElement('td');
mybox1=document.createElement("input");

mybox1.size="10";

mybox1.type="text";

mybox1.name="date1[]";

mybox1.value = "";

mybox1.id = "date1@" + index;

mybox1.setAttribute("readonly",true);

td.appendChild(mybox1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox1=document.createElement("input");

mybox1.size="2";

mybox1.type="text";

mybox1.value = "0";

mybox1.name="mort[]";

mybox1.id = "mort@" + index;

td.appendChild(mybox1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox1=document.createElement("input");

mybox1.size="2";

mybox1.type="text";

mybox1.name="cull[]";

mybox1,id = "cull@" + index;

mybox1.value = "0";

td.appendChild(mybox1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
myselect1 = document.createElement("select");

theOption1=document.createElement("OPTION");

myselect1.name = "feedtype[]";

myselect1.id = "feedtype@" + index;

myselect1.style.width = "100px";

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);

<?php
           include "config.php"; 
           $query = "SELECT distinct(code),description FROM ims_itemcodes where cat = 'Broiler Feed' ORDER BY code ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['code']; ?>";
theOption1.title = "<?php echo $row1['description']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
 
td.appendChild(myselect1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox2=document.createElement("input");

mybox2.size="4";

mybox2.type="text";

mybox2.value = "0";

mybox2.name="consumed[]";

mybox2.id = "consumed@" + index;
td.appendChild(mybox2);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox3=document.createElement("input");

mybox3.size="4";

mybox3.type="text";

mybox3.value = "0";

mybox3.name="weight[]";

mybox3.id = "weight@" + index;

td.appendChild(mybox3);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox4=document.createElement("input");

mybox4.size="4";

mybox4.type="text";

mybox4.name="water[]";

mybox4.id = "water@" + index;

mybox4.value="0";

mybox4.onfocus = function () { makeForm(); }

td.appendChild(mybox4);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox1=document.createElement("input");

mybox1.type="hidden";

mybox1.name="birds[]";

mybox1.id = "birds@" + index;

mybox1.value="0";

td.appendChild(mybox1);
tr.appendChild(td);

table.appendChild(tr);
}
}
function chkflk(id)
{
var ind=id.split('@');
for(i=0;i<=index;i++)
{
if(i!=ind[1])
if(document.getElementById("flock@"+i).value==document.getElementById("flock@"+ind[1]).value)
{
alert("Same Flock Cannot be Selected");
document.getElementById("flock@"+i).focus();
}
else
{
}
}
}
function chk()
{
  

   if(document.getElementById("supervisor").value=="")
  {
  alert("Please select supervisor");
  document.getElementById("supervisor").focus();
  return false;
  
  }
  
  if(index==0)
  {
  loop=0;
  }
  else
  {
  loop=index-1;
  }
  
  
  for(j=0;j<=loop;j++)
  {
  //alert(document.getElementById("cramount"+j).value);
  
   if(document.getElementById("farm@"+j).value=="")
  {
  alert("Please select farm");
  document.getElementById("farm@"+j).focus();
  return false;
  
  }
  
  
  if(document.getElementById("feedtype@"+j).value=="")
  {
  alert("Please select feedtype");
  document.getElementById("feedtype@"+j).focus();
  return false;
  
  }
  
  if(document.getElementById("consumed@"+j).value=="" || document.getElementById("consumed@"+j).value=="0")
  {
  alert("Please Enter Feed quantity");
  document.getElementById("consumed@"+j).focus();
  return false;
  
  }
  
 
  }
  
  
  document.getElementById("Save").disabled="true";
  

}

</script>