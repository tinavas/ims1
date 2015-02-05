<?php

include "config.php";

include "jquery.php";


@$sector=$_GET['sector'];
@$desg=$_GET['desg'];
@$date=$_GET['date'];

    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
		 $q1=mysql_query("select distinct(designation) as desg,sector,group_concat(name) as emp from hr_employee group by sector",$conn) or die(mysql_eroor());

	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 $q1=mysql_query("select distinct(designation) as desg,sector,group_concat(name) as emp from hr_employee where sector in ($sectorlist) group by sector",$conn) or die(mysql_eroor());

	 }

while($r1=mysql_fetch_array($q1))
{
$arr[]=array("sector"=>$r1[sector],"desg"=>$r1[desg],"name"=>$r1[emp]);
}
$k=0;
$qq=mysql_query("select concat(fromdate,'@',sector,'@',designation,'@',employee,'@',flag,'@',todate) as data from hr_newattendance order by date,employee",$conn) or die(mysql_error());
while($rr=mysql_fetch_array($qq))
{
$data[$k]=$rr['data'];
$k++;
}
$data1=json_encode($data);
?>
<script type="text/javascript">
var data=<?php if(empty($data1)){echo "0";} else{ echo $data1; }?>;
</script>

<br>

<br>

<center>

<h1>Attendance</h1>

<br>

<br>



<form method="post" name="myform" action="hr_savenewattendance.php" onSubmit="return valid(this);">


<strong>Date</strong> &nbsp;

<input type="text" value="<?php echo $date ?>" readonly name="date" id="date"  class="datepicker" size="12" onchange="chk();" />&nbsp;&nbsp;

<strong>Sector</strong> &nbsp;

<select id="sector" name="sector" onchange="reloadpage()">

  <option>-Select-</option>

  <?php for($i=0;$i<count($arr);$i++)

           { 

            ?>

  <option value="<?php echo $arr[$i][sector];?>"<?php if($sector==$arr[$i][sector]){?> selected="selected" <?php }?>> <?php echo $arr[$i][sector];?> </option>

  <?php } ?>

</select>

<strong>Designation</strong>&nbsp;

<select id="desg" name="desg" onchange="reloadpage()">

<option>-Select-</option>

  <?php for($j=0;$j<count($arr);$j++)
           { 
if($arr[$j][sector]==$sector)
{
            ?>

  <option value="<?php echo $arr[$j][desg];?>"<?php if($desg==$arr[$j][desg]){?> selected="selected" <?php }?>> <?php echo $arr[$j][desg];?> </option>

  <?php }} ?>

</select>
&nbsp;
<strong>Employee</strong>&nbsp;

<select id="emp" name="emp" onchange="chk();">

<option value=" ">-Select-</option>

  <?php for($k=0;$k<count($arr);$k++)
           { 
if($arr[$k][sector]==$sector && $arr[$k][desg]==$desg)
{
$n=explode(',',$arr[$k][name]);
 for($l=0;$l<count($n);$l++)
           { 
		   
            ?>

  <option value="<?php echo $n[$l];?>"> <?php echo $n[$l];?> </option>

  <?php }}} ?>

</select>

<strong>Status</strong>&nbsp;

<select id="status" name="status" onchange="chk();nr()">

<option value=" ">-Select-</option>

 <option value="On Leave">On Leave</option>
 
 <option value="On Work">On Work</option>
 
</select>
&nbsp;
<br /><br />
<br />
<table id="tab">
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br />

<br />

<br />



<input type="submit" value="Save" id="Save"/> 

&nbsp;&nbsp;&nbsp; 

<input type="button" value="Cancel" onClick="document.location = 'dashboardsub.php?page=hr_newattendance';">



</form>

</center>



<script type="text/javascript">


function reloadpage()
{
var date=document.getElementById("date").value;
var sector=document.getElementById("sector").value;
var desg=document.getElementById("desg").value;
document.location="dashboardsub.php?page=hr_newaddattendance&date="+date+"&sector="+sector+"&desg="+desg;
}


function chk()
{
var date1=document.getElementById("date").value;
var sector1=document.getElementById("sector").value;
var desg1=document.getElementById("desg").value;
var emp=document.getElementById("emp").value;
var status=document.getElementById("status").value;

 var fdate=date1.split(".");
 var formfdate=fdate[2]+"/"+fdate[1]+"/"+fdate[0];
 var ff=new Date(formfdate);

//alert(emp);
//alert(status);
if((status!=' ' && status!='-Select-') && (emp!='' && emp!='-Select-'))
{
//alert(2);
for(i=0;i<data.length;i++)
{
var j=data[i].split('@');
var tdate=j[0].split("-");
var formtdate=tdate[0]+"/"+tdate[1]+"/"+tdate[2];
 var tt=new Date(formtdate);
 var t1=j[5].split("-");
var tdate1=t1[0]+"/"+t1[1]+"/"+t1[2];
 var tt1=new Date(tdate1);
//alert(j[1]+"=="+sector1 +"&&"+ j[3]+"=="+emp +"&&"+ j[0]+"=="+date1+"&&"+j[2]+"=="+desg1);
if(j[1]==sector1 && j[3]==emp && j[2]==desg1)
{
//alert(4);


if(j[4]=='0' && status=="On Leave")
{
alert("already in Leave");
document.getElementById("emp").selectedIndex=0;
document.getElementById("emp").focus();
}
else if((tt.getTime()<=ff.getTime() && tt1.getTime()>=ff.getTime()) && tt.getTime()!=tt1.getTime() )
{
alert("already Leave Recorded For this Employee in Given Date Range");
document.getElementById("emp").selectedIndex=0;
document.getElementById("emp").focus();
}
else if(status=="On Work" && j[4]=='1' && tt.getTime()<=ff.getTime() && tt1.getTime()>=ff.getTime())
{
alert("already Recorded As On Work");
document.getElementById("emp").selectedIndex=0;
document.getElementById("emp").focus();
}
else
{

}
}

}
}
}

function nr()
{
var status=document.getElementById("status").value;
if(status=="On Leave")
document.getElementById("tab").style.visibility="visible";
else if(status=="On Work")
document.getElementById("tab").style.visibility="hidden";
}

</script>

<script type="text/javascript">

function script1() {

window.open('HRHELP/help_t_addattendance.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

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