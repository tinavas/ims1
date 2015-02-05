<?php
include "jquery.php";
?>
<br /><br />
<form action="hr_saveholidays.php" method="POST" id="form1" name="form1" onsubmit="return validate();">
<select id="dbdates" name="dbdates" style="visibility:hidden">
<?php   include "config.php";
		$q = "select * from holidays";
		$l = 0;
		$qr = mysql_query($q,$conn);
		while($r = mysql_fetch_assoc($qr))
		{
		$temp = explode("-",$r['date']);
		$olddbdates[$l] = $temp[2] . "." . $temp[1] . "." . $temp[0] ;
		$l++;
?>
<option value="<?php echo $r['date']; ?>"><?php echo $r['date']; ?></option>
<?php } ?>

</select>
<div id="paraID">
<input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>" />
<table align="center">

<tr>
<td align="center"> <strong>DATE</strong> </td>
<td width="10px">&nbsp;</td>
<td align="center"> <strong>REASON </strong></td>
<td width="10px">&nbsp;</td>
<td></td>

</tr>

<tr height="2"></tr><tr></tr>

<tr>
<td>
<input type="text" value="<?php echo date('d.m.Y') ?>" name="date1[]" id="date1" size="12" class="datepicker" onchange="datecomp()">
</td>

<td width="10px">&nbsp;</td>

<td>
<textarea id="reason" name="reason[]" value="" cols="25"></textarea>
</td>

<td width="10px">&nbsp;</td>

<td>
<input type="button" onClick="newform();" value="Click for another holiday" />
</td>
</tr>
</table>
</div>
<br />
<br />

<center>
<input type="submit" value="Submit" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_holidays';">
</center>
</form>

<script type="text/javascript">
var x = new Array();
var index = 0;
function datecomp()
{

dd = document.getElementsByName("date1[]");

//from1 = from1[1] + "/" + from1[0] + "/" + from1[2];
for (j = 0; j < dd.length; j++)
{
temp =  dd[j].value.split(".");
temp = temp[1] + "/" + temp[0] + "/" + temp[2];
temp1 = new Date(temp);

temp10 = new Date();
newday = temp10.getDate();
newmonth = temp10.getMonth() + 1;
newyear = temp10.getYear();
temp12 = newmonth + "/" + newday + "/" + newyear;
temp2 = new Date(temp12);

if(temp1 < temp2)
{
alert("You should not select past dates"); 
x[index] = 1;
index++;
}
else
{
x[index] = 0;
index++;
}
var dbdate;
t = dd[j].value;


var i = 0;
<?php
     include "config.php";
     $q2=mysql_query("select * from holidays ORDER BY date ASC ");
     while($nt2=mysql_fetch_array($q2)){
     echo "if(t == '$nt2[dumpdate]') {";
     echo "i = i + 1;"; 
      echo "}"; // end of JS if condition
     }
?>

if(i > 0)
{
alert("Holiday has already been taken for this date");
document.getElementsByName("date1[]")[j].value = "";
}
}

}

function validate()
{

var k = 0;var m = 0;
var dd = document.getElementsByName('date1[]');
if(dd.length > 0)
{
for (i = 0; i < dd.length; i++)
{
for (j = 0; j < dd.length; j++)
{
if(i != j)
{
if( dd[i].value == dd[j].value ) 
k = 1;
}
}
}
}

for(l=index;l>=(index-dd.length);l--)
if(x[l] == 1)
m = 1;

if( m == 1 )
{
alert('Make sure that you have entered correct date(s)');
return false;
}
if( k == 1)
{
alert('You have entered same date');
return false;
}
p = 0;
for (j = 0; j < dd.length; j++)
{
if(dd[j].value == '')
{
p = 1;
}
}
if(p == 1)
{
alert('Date(s) should not be empty');
return false;
}
if(m == 0 && k == 0 && p == 0)
{
return true;
}

}
var index = 0;
function newform()
{
index = index + 1;
mypara=document.getElementById('paraID');


//////////Break element/////////

mybreak = document.createElement('<br>');


mypara.appendChild(mybreak);
mypara.appendChild(mybreak);
mypara.appendChild(mybreak);

table = document.createElement('table');
table.setAttribute('align','center');

row = document.createElement('tr');

col1 = document.createElement('td');
input=document.createElement('input');
input.type = 'text';
input.size = "12";

var c = "datepicker" + index;
input.setAttribute("class",c);

input.setAttribute('readonly');
input.value = "<?php echo date('d.m.Y') ?>";

input.name='date1[]';
input.setAttribute('onChange','datecomp();');
input.id='date' + index;
col1.appendChild(input);
row.appendChild(col1);

col1 = document.createElement('td');
col1.width = "12px";

row.appendChild(col1);


col1 = document.createElement('td');
textarea = document.createElement('textarea');
textarea.name = 'reason[]';
textarea.cols='25';
col1.appendChild(textarea);
row.appendChild(col1);

col1 = document.createElement('td');
col1.width = "12px";

row.appendChild(col1);


col1 = document.createElement('td');
input = document.createElement('input');
input.type = 'button';
input.setAttribute('onClick','newform()');
input.value='Click for another holiday';
col1.appendChild(input);
row.appendChild(col1);


table.appendChild(row);
mypara.appendChild(table);

  $(function() {
	$( "." + c ).datepicker();
  });

}

</script>

<script type="text/javascript">
function script1() {
window.open('HRHELP/help_m_addholiday.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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