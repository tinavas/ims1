<?php
include "jquery.php"; 
include "config.php";

$id= $_GET['id'];
$tid=$_GET['tid'];


$query1 = "SELECT * FROM ims_budget where tid = '$tid'";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
  $id =  $row1['id'];
 $tid = $row1['tid'];
$cc = $row1['costcentre'];
$month = $row1['month'];
 $year = $row1['year'];
 $narration = $row1['narration'];


}
?>

	<center>
<br/>
<h1>Budget Allocation</h1>
</center>
<br /><br /><br />
<form method="post" action="ims_updatebudgets.php" >
<table align="center">
<tr align="center">
 <input type = "hidden" id= "id" name = "id" value = "<?php echo $id;?>"/>

<input type = "hidden" id= "tid" name = "tid" value = "<?php echo $tid;?>"/>

<td><strong>Cost Centre:</strong></td>

<td width="10px">&nbsp;</td>
<td>

<select id="sector" name="sector" style="width:130px">
<option vakue="">-Select-</option>
<?php $query = "SELECT distinct(sector) FROM tbl_sector where costeffect = '1' ORDER BY sector ASC ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))  
	  { 
	  if($cc = '$row1[sector]')
	  {
	  ?>
<option value="<?php echo $row1['sector']; ?>" selected="selected"><?php echo $row1['sector']; ?></option>
<?php } else { ?>
<option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
<?php } }?>
</select></td>
</tr>
</table>
<br/>
<br/>
<table align="center">
<tr>
<td align="right"><strong>Month : </strong></td>
<td width="10px">&nbsp;</td>
<td align="left"><select id="month" onChange="" name="month" >
<option value="Select"> Select </option>
<option value= "01"<?php if($month == '01') {?> selected="selected" <?php }?>>JAN</option>
<option value= "02"<?php if($month == '02') {?> selected="selected" <?php }?>>FEB</option>
<option value= "03"<?php if($month == '03') {?> selected="selected" <?php }?>>MAR</option>
<option value= "04"<?php if($month == '04') {?> selected="selected" <?php }?>>APR</option>
<option value= "05"<?php if($month == '05') {?> selected="selected" <?php }?>>MAY</option>
<option value= "06"<?php if($month == '06') {?> selected="selected" <?php }?>>JUN</option>
<option value= "07"<?php if($month == '07') {?> selected="selected" <?php }?>>JUL</option>
<option value= "08"<?php if($month == '08') {?> selected="selected" <?php }?>>AUG</option>
<option value= "09"<?php if($month == '09') {?> selected="selected" <?php }?>>SEP</option>
<option value= "10"<?php if($month == '10') {?> selected="selected" <?php }?>>OCT</option>
<option value= "11"<?php if($month == '11') {?> selected="selected" <?php }?>>NOV</option>
<option value= "12"<?php if($month == '12') {?> selected="selected" <?php }?>>DEC</option>
</select></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Year : </strong></td>
<td width="10px">&nbsp;</td>
<td align="left"><select id="year" onChange="" name="year">
<option value="Select"> Select </option>
<option value= "2011"<?php if($year == '2011') {?> selected="selected" <?php }?>>2011</option>
<option value= "2012"<?php if($year == '2012') {?> selected="selected" <?php }?>>2012</option>
<option value= "2013"<?php if($year == '2013') {?> selected="selected" <?php }?>>2013</option>
<option value= "2014"<?php if($year == '2014') {?> selected="selected" <?php }?>>2014</option>
<option value= "2015"<?php if($year == '2015') {?> selected="selected" <?php }?>>2015</option>
<option value= "2016"<?php if($year == '2016') {?> selected="selected" <?php }?>>2016</option>
<option value= "2017"<?php if($year == '2017') {?> selected="selected" <?php }?>>2017</option>
<option value= "2018"<?php if($year == '2018') {?> selected="selected" <?php }?>>2018</option>
<option value= "2019"<?php if($year == '2019') {?> selected="selected" <?php }?>>2019</option>
<option value= "2020"<?php if($year == '2020') {?> selected="selected" <?php }?>>2020</option>
</select></td>
</tr>

<tr height="20"></tr>

</table>

<table id="paraID" align="center">
<tr align="center">
  <th width="10px">&nbsp;</th>
  <th><strong>Coa Code</strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Description<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Cr/Dr<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Amount</strong></th>
  <th width="10px">&nbsp;</th>
 

</tr>

<tr style="height:10px"></tr>
<?php 
$i = -1;
 $q = "select * from ims_budget where tid= '$tid' order by id";
	
$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
 $code = $qr['coacode'];
 $desc = $qr['description'];
	$crdr = $qr['crdr'];
	$amount = $qr['amount'];

?>
<script type="text/javascript">
var index = index + 1;
</script>

<tr align="center">
<td width="10px">&nbsp;</td>
 <td><select id="code@<?php echo $i;?>" name="code[]" onChange="selectdesc(this.id);" style="width:120px">
 <option value="">-Select-</option>
        <?php 
	     $query = "select distinct(code),description from ac_coa WHERE client = '$client' order by code";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           {
            if ( $code == $row['code'] ) { 
			 ?>
		<option value="<?php echo $row['code'];?>" title="<?php echo $row['description'];?>" selected="selected"><?php echo $row['code'];?><?php } else { ?><option value="<?php echo $row['code'];?>" title="<?php echo $row['description'];?>"><?php echo $row['code']; ?></option><?php } } ?>
</select>
       </td>

 <td width="10px"></td>

<td><select style="Width:180px" name="desc[]" id="desc@<?php echo $i?>" onChange="selectcode(this.id);">
	<option>-Select-</option>
	<?php 
	     $query = "select distinct(code),description from ac_coa WHERE client = '$client' order by code";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           {
		if ( $desc == $row['description'] ) { 
			 ?>
		<option value="<?php echo $row['description'];?>" title="<?php echo $row['code'];?>" selected="selected"><?php echo $row['description'];?><?php } else { ?><option value="<?php echo $row['description'];?>" title="<?php echo $row['code'];?>"><?php echo $row['description']; ?></option><?php } } ?>
</select>
	   
</td>

 <td width="10px">&nbsp;</td>

<td>
<select style="Width:100px" name="crdr[]" id="crdr@<?php echo $i;?>">
     		<option>-Select-</option>
			<option value= "Cr"<?php if($crdr == 'Cr') {?> selected="selected" <?php }?>>Cr</option>
<option value= "Dr"<?php if($crdr == 'Dr') {?> selected="selected" <?php }?>>Dr</option>
</select>

</td>

<td width="10px">&nbsp;</td>

<td><input type="text" size="15" id="amt@<?php echo $i;?>" name="amt[]" value="<?php echo $amount;?>" onFocus="makeForm();"/></td>
</tr>
 <?php $i++; } ?>

</table>
<br/>
<br/>
<table border="0"  align="center">
 <tr style="height:10px"></tr> 
<tr>
<td style="vertical-align:middle;"><strong>Narration</strong>&nbsp;&nbsp;&nbsp;</td>
<td><textarea rows="3" cols="50" id="remarks" name="remarks"><?php echo $narration;?></textarea></td>
</tr>
</table>
<center>	


   <br />
   <input type="submit" value="Update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ims_budgets';">
</center>

</form>




<script type="text/javascript">
var index = "<?php echo $i;?>";

function selectcode(codeid)
{
var temp = codeid.split("@");
var tempindex = temp[1];


var item1 = document.getElementById(codeid).value;

    removeAllOptions(document.getElementById("code@" + tempindex));
myselect1 = document.getElementById("code@" + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "code[]";
myselect1.style.width = "120px";
<?php 
	    $q = "select distinct(code),description from ac_coa WHERE client = '$client' order by code";
    $qrs = mysql_query($q) or die(mysql_error());
    while($q1r = mysql_fetch_assoc($qrs))
    {

			?>
	
		   theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $q1r['code']; ?>");
theOption1.value = "<?php echo $q1r['code']; ?>";
theOption1.title = "<?php echo $q1r['description']; ?>";

   <?php 	echo "if(item1 == '$q1r[description]') {"; ?>
     
theOption1.selected = true;
<?php echo "}"; ?>
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);



<?php }  ?>

}

function selectdesc(codeid)
{
var temp = codeid.split("@");
var tempindex = temp[1];


var item1 = document.getElementById(codeid).value;

    removeAllOptions(document.getElementById("desc@" + tempindex));
myselect1 = document.getElementById("desc@" + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "desc[]";
myselect1.style.width = "180px";
<?php 
	    $q = "select distinct(code),description from ac_coa WHERE client = '$client' order by code";
    $qrs = mysql_query($q) or die(mysql_error());
    while($q1r = mysql_fetch_assoc($qrs))
    {

			?>

	
		   theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $q1r['description']; ?>");
theOption1.value = "<?php echo $q1r['description']; ?>";
theOption1.title = "<?php echo $q1r['code']; ?>";

   <?php echo "if(item1 == '$q1r[code]') {"; ?>
    
theOption1.selected = true;
<?php echo "}"; ?>
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);



<?php }  ?>

}

function makeForm()
 {
index = index + 1;
var i,b;


table=document.getElementById("paraID");
tr = document.createElement('tr');
tr.align = "center";

////////space td//////////////
var b1 = document.createElement('td');
myspace1= document.createTextNode('\u00a0');
b1.appendChild(myspace1);
////////space td//////////////

////////item code td//////////////

myselect1 = document.createElement("select");
myselect1.name = "code[]";
myselect1.id = "code@" + index;
myselect1.style.width = "120px";

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.onchange = function () { selectdesc(this.id); };

<?php 
                       $query = "select distinct(code),description from ac_coa WHERE client = '$client' order by code";
                       $result = mysql_query($query); 
                       while($row1 = mysql_fetch_assoc($result))
                       {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['code']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
var code = document.createElement('td');
code.appendChild(myselect1);

tr.appendChild(b1);
tr.appendChild(code);
// for description start

////////space td//////////////
var b2 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
b2.appendChild(myspace2);
////////space td//////////////

myselect1 = document.createElement("select");
myselect1.name = "desc[]";
myselect1.id = "desc@" + index;
myselect1.style.width = "180px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.onchange = function () { selectcode(this.id); };
<?php 
                       $query = "select distinct(description),code from ac_coa WHERE client = '$client' order by description";
                       $result = mysql_query($query); 
                       while($row1 = mysql_fetch_assoc($result))
                       {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['description']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['description']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
var desc = document.createElement('td');
desc.appendChild(myselect1);
// for description end


//////////item code td/////////

tr.appendChild(desc);

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


tr.appendChild(td);
////////space td///////////
var b5 = document.createElement('td');
myspace5= document.createTextNode('\u00a0');
b5.appendChild(myspace5);
/////////////space td//////

/////////////units////////
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "crdr[]";
myselect1.id = "crdr@" + index;
myselect1.style.width = "100px";

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Cr");
theOption1.appendChild(theText1);
theOption1.value = "Cr";
myselect1.appendChild(theOption1);
td.appendChild(myselect1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Dr");
theOption1.appendChild(theText1);
theOption1.value = "Dr";
myselect1.appendChild(theOption1);

tr.appendChild(b5);
tr.appendChild(td);


////////space td///////////
var b4 = document.createElement('td');
myspace4= document.createTextNode('\u00a0');
b4.appendChild(myspace4);
/////////////space td//////

/////////////units////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="15";
mybox1.type="text";
mybox1.value = "";
mybox1.name="amt[]";
mybox1.id = "amt@" + index;
mybox1.onfocus = function () { makeForm(this.id); };
td.appendChild(mybox1);
//////////units td//////

tr.appendChild(b4);
tr.appendChild(td);





table.appendChild(tr);

}
function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}


</script>

<script type="text/javascript">
function script1() {
window.open('Management Help/help_t_addbudgets.php','BIMS',
'width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

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
</html>
