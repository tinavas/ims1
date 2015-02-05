
<?php 
include "jquery.php"; 
include "config.php";
$tid = $_GET['tid'];

$query="select * from tbl_profitcenter ";
$result=mysql_query($query);
$num_rows=mysql_num_rows($result);
while($row=mysql_fetch_assoc($result))
  $cc.=$row['costcenter'].','; 
$cc=explode(',',$cc);
$i=0;
while($cc[$i]) $cc1.="'".$cc[$i++]."',";
$cc_exist=substr($cc1,0,-1);


$query="select * from tbl_profitcenter where id=".$_GET[id];
$result=mysql_query($query);
if($row=mysql_fetch_assoc($result))
{
$pc=$row['profitcenter'];
$cc=explode(',',$row['costcenter']);
$icat=explode(',',$row['inputcat']);
$ocat=explode(',',$row['outputcat']);
}
?>
<script>
function validate()
{
if(document.getElementById('pc').value==''){ alert('select Profit Center');
 return false; }
if(document.getElementById('costcenter').value==''){ alert('select atleast one Cost Center');
 return false; }
if(document.getElementById('inputcat').value==''){ alert('select input Category');
 return false; }
if(document.getElementById('outputcat').value==''){ alert('select Output Category');
 return false; }
 
 return true;
}
var index = -1;
function makeform(a)
{

index = index + 1;
table=document.getElementById("tab23");
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
myselect1.name = "inputcat[]";
myselect1.id = "inputcat@" + index;
myselect1.style.width = "180px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
<?php
         $q = "select distinct(cat) as sector from ims_itemcodes order by cat"; 
         $qrs = mysql_query($q,$conn) or die(mysql_error());
        while($qr = mysql_fetch_assoc($qrs)) {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['sector']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $qr['sector']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
td.appendChild(myselect1);
//////////category td/////////

tr.appendChild(td);


var b5 = document.createElement('td');
myspace5= document.createTextNode('\u00a0');
b5.appendChild(myspace5);
////////space td//////////////

////////towarehouse td//////////////
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "outputcat[]";
myselect1.id = "output@" + index;
myselect1.style.width = "180px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.onfocus = function () { makeform(this.id); };
<?php
      $q1 = "select distinct(cat) as sector from ims_itemcodes order by cat";
      $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1)) { 
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['sector']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['sector']; ?>";
theOption1.title = "<?php echo $row1['sector']; ?>";
myselect1.appendChild(theOption1);

<?php } ?>
td.appendChild(myselect1);
//////////towarehouse td/////////

tr.appendChild(b5);
tr.appendChild(td);

table.appendChild(tr);
}
</script>
<center>
<br />
<h1><strong>Edit Profit Center-Cost Center Mapping</strong></h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br /><br />
<form id="form1" name="form1" method="post" onSubmit="return validate()" action="common_saveprofitcenter.php?edit=true&id=<?php echo $_GET[tid];  ?>" >
     
 <table border="0" id="tab">
     <tr style="height:20px"></tr>
<tr>
<td style="vertical-align:middle">
<strong>Profit Center</strong> <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="5px"></td>
<td style="vertical-align:middle">
<select id="pc" name="pc">
<option value="">-Select-</option>
<option selected="selected" value="<?php echo $pc ?>" title="<?php echo $pc ?>"><?php echo $pc ?></option>
<?php  
$query = "select distinct(sector) from tbl_sector where profitcentre=1 and sector not in(select profitcenter from tbl_profitcenter) order by sector";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 ?>
 <option  value="<?php echo $rows['sector']; ?>" title="<?php echo $rows['sector']; ?>"><?php echo $rows['sector']; ?></option>
 <?php } ?>
</select>
</td>
<td width="5px"></td>
<td style="vertical-align:middle">
<strong>Cost Center</strong> <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="5px"></td>
<td style="vertical-align:middle">
<select multiple="multiple" style="Width:180px" name="costcenter[]" id="costcenter" onChange="">
     		
			<?php  $i=0; while($cc[$i])  {  ?>
	<option selected="selected"; value="<?php echo $cc[$i]; ?>" title="<?php echo $cc[$i]; ?>"><?php echo $cc[$i++]; ?></option>	
			<?php } ?>
<?php
if($num_rows)
$query = "select distinct(sector) from tbl_sector where costeffect=1 and sector not in ($cc_exist) order by sector";
else
$query = "select distinct(sector) from tbl_sector where costeffect=1 order by sector";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 ?>
 <option value="<?php echo $rows['sector']; ?>" title="<?php echo $rows['sector']; ?>"><?php echo $rows['sector']; ?></option>
 <?php } ?>
</select>
</td>
 </tr>
 </table>
 <br/>
 <br/>
  <table border="0" id="tab23">
 <tr align="center">
 
  <th><strong>Input Category</strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Output Category</strong></th>
  <th width="10px">&nbsp;</th>
  </tr>
  
 <tr style="height:20px"></tr>
 <?php 
$i = -1;
	$q = "select * from tbl_profitcenter where tid= '$tid' order by id";
	
$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
$inputcat = $qr['inputcat'];
$outputcat = $qr['outputcat'];

?>
<script type="text/javascript">
var index = index + 1;
</script>
<tr >

<td>
<select style="Width:180px" name="inputcat[]" id="inputcat@<?php echo $i;?>" onChange="">
 <option value="">-Select-</option>    		
<?php
$query = "select distinct(cat) as sector from ims_itemcodes order by cat";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
if($inputcat == $rows['sector'] ) { 
?>
<option value="<?php echo $rows['sector'];?>" selected="selected"><?php echo $rows['sector'];?><?php } else { ?><option value="<?php echo $rows['sector'];?>" ><?php echo $rows['sector']; ?></option><?php } } ?>
</select>
</td>

<td width="10px"></td>
<td>
<select style="Width:180px" name="outputcat[]" id="outputcat@<?php echo $i;?>" onChange="makeform(this.id);">
     	<option value="">-Select-</option>	
<?php
$query = "select distinct(cat) as sector from ims_itemcodes order by cat";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
if($outputcat == $rows['sector'] ) { 
?>
<option value="<?php echo $rows['sector'];?>" selected="selected"><?php echo $rows['sector'];?><?php } else { ?><option value="<?php echo $rows['sector'];?>" ><?php echo $rows['sector']; ?></option><?php } } ?>
</select>
</td>
 </tr>
 <?php } ?>
 
 <tr >
<td>
<select style="Width:180px" name="inputcat[]" id="inputcat@-1" > 
<option value="">-Select-</option> 		
<?php
$query = "select distinct(cat) as sector from ims_itemcodes order by cat";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 ?>
 <option value="<?php echo $rows['sector']; ?>" title="<?php echo $rows['sector']; ?>"><?php echo $rows['sector']; ?></option>
 <?php } ?>
</select>
</td>
<td width="5px"></td>
<td>
<select style="Width:180px" name="outputcat[]" id="outputcat@-1" onchange="makeform(this.id);">
     <option value="">-Select-</option>		
<?php
$query = "select distinct(cat) as sector from ims_itemcodes order by cat";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 ?>
 <option value="<?php echo $rows['sector']; ?>" title="<?php echo $rows['sector']; ?>"><?php echo $rows['sector']; ?></option>
 <?php } ?>
</select>
</td>
 </tr>
   </table>
   <br /> 
 </center>

<br />			

<center>	


   <br />
   <input type="submit" value="Update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=common_profitcenter';">
</center>


						
</form>


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
</html>

