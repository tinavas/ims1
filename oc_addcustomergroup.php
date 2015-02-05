<?php 
include "config.php"; 
$i= 0;
$query = "select vgroup,vca,vppac from ac_vgrmap";
$result = mysql_query($query,$conn) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
 $vgr[$i] = $res['vgroup']; 
 $vca[$i] = $res['vca'];
$vppac[$i]=$res['vppac'];
$i++;
}

?>

<center>

<br />

<h1>Customer Group Mapping</h1>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/>

<br/><br />

<form id="form1" name="form1" method="post" action="oc_savecustomergroup.php" onSubmit="return checkform(this);">

<div style="height:auto">



<table align="center">

<tr>

<td>

<strong>Customer Group Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td align="left">

<input type="text" id="grcode" name="tno" size="10" onblur="checkvgr(this.value,this.id);"   />

</td>

</tr>

<tr height="10px"></tr>

<tr>

<td><strong>Customer Group Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td><input type="text" id="desc" name="desc" size="20"  /></td>

</tr><br />

</table>

<br /><br/>

<table border="1" cellpadding="2" cellspacing="2" id="mytable" align="center">

<tr align="center">

<thead align="center">





<td>

<strong>Customer Controll A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>



<td>

<strong>Customer Advance A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>



</thead>

</tr>

<tr>



<td>

<select name="ca" id="ca"  style="width:160px;">

<option value = "" >SelectCode</option>

<?php

           include "config.php"; 

           $query = "SELECT * FROM ac_coa where controltype='Customer A/c' and code not in(select distinct(vca) from ac_vgrmap) ORDER BY code ASC ";

           $result = mysql_query($query,$conn); 

           while($row1 = mysql_fetch_assoc($result))

           {

           ?>

<option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']; ?>"><?php echo $row1['code']; ?></option>

<?php } ?>

</select>

</td>

<td>

<select name="ppac" id="ppac"  style="width:160px;">

<option value = "">SelectCode</option>

<?php

           include "config.php"; 

           $query = "SELECT * FROM ac_coa where controltype='Customer Advance A/c' and code not in(select distinct(vppac) from ac_vgrmap) ORDER BY code ASC ";

           $result = mysql_query($query,$conn); 

           while($row1 = mysql_fetch_assoc($result))

           {

           ?>

<option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']; ?>"><?php echo $row1['code']; ?></option>

<?php } ?>

</select>

</td>

</tr>

</table>

<br />

</div>

<br /><br/><br/>

<center>

<input type="submit" value="Save" id="Save" name="Save"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=oc_customergroup';">

</center>

<br />

<!-- </center> -->

</form>

<script language="JavaScript" type="text/javascript">
function checkvgr(vgrcode)
{
var newcode = "";
<?php 
for($j=0; $j < sizeof($vgr); $j++)
{?>
newcode = "<?php echo $vgr[$j]; ?>"; 

if(newcode.toUpperCase() == vgrcode.toUpperCase())
{
alert('Group Code Alaredy Exists! Please Enter Other');
document.getElementById('grcode').value = "";
}
<?php }
?>
}


function checkform( form )

{

var numericExpression = /^[0-9]+$/;



if (form.grcode.value == "") {

    alert( "Please enter Customer Group Code" );

    form.grcode.focus();

    return false ;

  }



    

  

   else if (form.desc.value == "") {

    alert( "Please enter Customer Group Description" );

    form.desc.focus();

    return false ;

  }


  else if ((form.ca.value == "") || (form.ca.value == "SelectCode")) {

     alert( "Please enter Customer Controll A/C" );

    form.ca.focus();

    return false ;

  }

   else if ((form.ppac.value == "") || (form.ppac.value == "SelectCode")) {

    

    alert( "Please enter Customer Prepayment A/C" );

    form.ppac.focus();

    return false ;

  }

 var coaone = document.getElementById('ca').value;
var coatwo = document.getElementById('ppac').value;
var newone = "";
var newtwo = "";
<?php 
for($j=0; $j< sizeof($vgr);$j++)
{
?>
 newone = "<?php echo $vca[$j]; ?>";
 newtwo = "<?php echo $vppac[$j]; ?>";

if(coaone.toUpperCase() == newone.toUpperCase() || coatwo.toUpperCase() == newtwo.toUpperCase() || coaone.toUpperCase() == newtwo.toUpperCase() || coatwo.toUpperCase() == newone.toUpperCase()) 
{
alert('Customer accounts are already entered for other group');

document.getElementById('ca').value = "";
document.getElementById('ppac').value = "";
return false;
}

<?php }
?>
       

  return true ;

}



</script>





<script type="text/javascript">

function script1() {

window.open('O2CHelp/help_m_addcustomergrmapping.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

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



