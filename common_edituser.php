<?php
session_start();
$userlogged = $_SESSION['valid_user'];
           include "config.php"; 
           $query1 = "SELECT * FROM common_useraccess where username= '$userlogged' ORDER BY username ASC ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
                $rights = $row11['view'];
           }
           $query1 = "SELECT * FROM common_useraccess where id= '$_GET[id]' ORDER BY username ASC ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
                $checkedrights = $row11['view'];
                $addrights = $row11['addv'];
                $editrights = $row11['editv'];
                $deleterights = $row11['deletev'];
                $authorizerights = $row11['authorize'];
                $username = $row11['username'];
                $employee = $row11['employeename'];
				$empid=$row11['employeeid'];
				$empsector=$row11['sector'];
				
				 if($_SESSION['db']=="singhsatrang")
             {
			 
			 $superstockistflag=0;
			 
			 $superstockist=explode(",",$row11['superstockist']);
			 
			 $superstockistvalue=$row11['superstockist'];
			 
			 $checkedrightsforcheck=explode(",",$checkedrights);
			 
			 if(in_array(15,$checkedrightsforcheck))
			 {
			 
			 $superstockistflag=1;
			 
			 }
			 
			 }
				
				
				
				
           }
           
           include "mainconfig.php";
           $query1 = "SELECT * FROM tbl_users where username= '$username' ORDER BY username ASC ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
                $username = $row11['username'];
                $passwordd = $row11['password'];
                $emaild = $row11['email'];
				$sector = $row11['sectortype']; 
				$authorizesectors = $row11['authorizesectors'];
				$authorizesectors=substr($authorizesectors,0,-1);
				$admin=$row11['admin'];
           }
           include "config.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Tulasi Technologies - PMS</title>
	<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="checkboxtree/css/checkboxtree.css" charset="utf-8">

	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script src="checkboxtree/js/jquery.checkboxtree.js" type="text/javascript" language="JavaScript"></script>
<script>
jQuery(document).ready(function(){
	jQuery("#checkchildren").checkboxTree({
			collapsedarrow: "checkboxtree/images/checkboxtree/img-arrow-collapsed.gif",
			expandedarrow: "checkboxtree/images/checkboxtree/img-arrow-expanded.gif",
			blankarrow: "checkboxtree/images/checkboxtree/img-arrow-blank.gif",
			checkchildren: true
	});
	jQuery("#dontcheckchildren").checkboxTree({
			collapsedarrow: "checkboxtree/images/checkboxtree/img-arrow-collapsed.gif",
			expandedarrow: "checkboxtree/images/checkboxtree/img-arrow-expanded.gif",
			blankarrow: "checkboxtree/images/checkboxtree/img-arrow-blank.gif",
			checkchildren: false
	});
	jQuery("#docheckchildren").checkboxTree({
			collapsedarrow: "checkboxtree/images/checkboxtree/img-arrow-collapsed.gif",
			expandedarrow: "checkboxtree/images/checkboxtree/img-arrow-expanded.gif",
			blankarrow: "checkboxtree/images/checkboxtree/img-arrow-blank.gif",
			checkchildren: true,
			checkparents: false
	});
	jQuery("#dontcheckchildrenparents").checkboxTree({
			collapsedarrow: "checkboxtree/images/checkboxtree/img-arrow-collapsed.gif",
			expandedarrow: "checkboxtree/images/checkboxtree/img-arrow-expanded.gif",
			blankarrow: "checkboxtree/images/checkboxtree/img-arrow-blank.gif",
			checkchildren: false,
			checkparents: false
	});
});

$(document).ready(function() {
 
	var changeTooltipPosition = function(event) {
	  var tooltipX = event.pageX - 8;
	  var tooltipY = event.pageY + 8;
	  $('div.tooltip').css({top: tooltipY, left: tooltipX});
	};
 
	var showTooltip = function(event) {
	  $('div.tooltip').remove();
	  $('<div class="tooltip"><font color="red">1.Password Should Not Contain Username.<br/>2.Password Should Contain Atleast 8 Characters.<br/>3.Password Should Contain One Uppercase Letter and One Lowercase Letter and One Digit between 0 to 9.<br/>4.Password Should Contain One Special Character like !@#$&*</font></div>')
            .appendTo('body');
	  changeTooltipPosition(event);
	};
 
	var hideTooltip = function() {
	   $('div.tooltip').remove();
	};
 
	$("span#hint,label#username'").bind({
	   mousemove : changeTooltipPosition,
	   mouseenter : showTooltip,
	   mouseleave: hideTooltip
	});
});

</script>




	<link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/common.css" rel="stylesheet" type="text/css">
	<link href="css/form.css" rel="stylesheet" type="text/css">
	<link href="css/standard.css" rel="stylesheet" type="text/css">
	<link href="css/960.gs.fluid.css" rel="stylesheet" type="text/css">
	<link href="css/simple-lists.css" rel="stylesheet" type="text/css">
	<link href="css/block-lists.css" rel="stylesheet" type="text/css">
	<link href="css/planning.css" rel="stylesheet" type="text/css">
	<link href="css/table.css" rel="stylesheet" type="text/css">
	<link href="css/calendars.css" rel="stylesheet" type="text/css">
	<link href="css/wizard.css" rel="stylesheet" type="text/css">
	<link href="css/gallery.css" rel="stylesheet" type="text/css">


	<script type="text/javascript" src="js/html5.js"></script>
	<script type="text/javascript" src="js/old-browsers.js"></script>
	<script type="text/javascript" src="js/jquery.accessibleList.js"></script>
	<script type="text/javascript" src="js/searchField.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/standard.js"></script>
	<script type="text/javascript" src="js/jquery.tip.js"></script>
	<script type="text/javascript" src="js/jquery.hashchange.js"></script>
	<script type="text/javascript" src="js/jquery.contextMenu.js"></script>
	<script type="text/javascript" src="js/jquery.modal.js"></script>
	<script type="text/javascript" src="js/list.js"></script>
<script type="text/javascript">
function showpass()
{
document.getElementById("pass").style.display="";
}
function checkpassword()
{
if(document.getElementById("password11").value == "" && document.getElementById("password12").value== "")
return true;
else if(document.getElementById("password11").value == document.getElementById("password12").value)
       return true;
else
{
alert('Please enter same password in both fields.');
return false;
}
}
</script>

	
<style>
th {
	color: #3399cc;
}
form input[type=password]
{
   padding:0.2em;
}
#hint{
		cursor:pointer;
	}
	.tooltip{
		margin:8px;
		padding:8px;
		border:1px solid black;
		background-color:white;
		position: absolute;
		z-index: 2;
	}
</style>
</head>
<body>
<!--[if lt IE 9]><div class="ie"><![endif]-->
<!--[if lt IE 8]><div class="ie7"><![endif]-->
	
	

<form name="form1" action="common_updateuser.php" onSubmit="return validate()" method="post">

<input type="hidden" id="checkedrights" value="<?php echo $checkedrights; ?>" />
<input type="hidden" id="addrights" value="<?php echo $addrights; ?>" />
<input type="hidden" id="editrights" value="<?php echo $editrights; ?>" />
<input type="hidden" id="deleterights" value="<?php echo $deleterights; ?>" />
<input type="hidden" id="authorizerights" value="<?php echo $authorizerights; ?>" />


<fieldset style="width:900px">

<div style="height:450px;width:300px;float:left;margin-top:10px;overflow:auto">
<h2>Select Module(s)</h2>

<ul class="unorderedlisttree" id="checkchildren">

                <?php
                         $a = 1; $b = 1;
                         include "config.php"; 
                         $query = "SELECT * FROM common_links where active = 1 and step = 1 ORDER BY sortorder ASC ";
                         $result = mysql_query($query,$conn); 
                         while($row1 = mysql_fetch_assoc($result))
                         { 
                 ?>
                           <?php if ( strlen(strstr($rights ,$row1['refid'] ))>0 ) {  ?>
             			<li>

                                   <input type="checkbox" name="m[]" id="id<?php echo $a; $a = $a + 1; ?>" value="<?php echo $row1['refid']; ?>"  <?php if ( strlen(strstr(','.$checkedrights ,','.$row1['refid'].',' ))>0 ) {  ?>checked="checked"<?php } ?> >
                                   <label id="lab<?php echo $b; $b = $b + 1; ?>" <?php if($_SESSION['db']=="singhsatrang"){?> onClick="getsuperstockist(this.id)" <?php }?> ><?php echo $row1['name']; ?></label>
                                  <?php
                                     include "config.php"; 
                                     $query1 = "SELECT * FROM common_links where active = 1 and step = 2 and parentid = '$row1[refid]' ORDER BY sortorder ASC ";
                                     $result1 = mysql_query($query1,$conn); 
                                     if(mysql_num_rows($result1))
                                     {
									 ?>
                                     <ul>
                                  <?php   
                                       while($row2 = mysql_fetch_assoc($result1))
                                       { 
                                  ?>
                           <?php if ( strlen(strstr($rights ,$row2['refid'] ))>0 ) {  ?>
                					<li>
                                   <input type="checkbox" name="m[]" id="id<?php echo $a; $a = $a + 1; ?>" value="<?php echo $row2['refid']; ?>" <?php if ( strlen(strstr(','.$checkedrights ,','.$row2['refid'].',' ))>0 ) {  ?>checked="checked"<?php } ?> >
                                   <label id="lab<?php echo $b; $b = $b + 1; ?>" ><?php echo $row2['name']; ?></label>

                                             <?php
                                                 include "config.php";  
                                                 $query2 = "SELECT * FROM common_links where active = 1 and step = 3 and parentid = '$row2[refid]' ORDER BY sortorder ASC ";
                                                 $result2 = mysql_query($query2,$conn); 
                                                 if(mysql_num_rows($result2))
                                                 {
                                              ?>
                                              <ul>
                                                 <?php   
                                                    while($row3 = mysql_fetch_assoc($result2))
                                                    { 
                                                 ?>
                           <?php if ( strlen(strstr($rights ,$row3['refid'] ))>0 ) {  ?>
                          					<li>
                                   <input type="checkbox" name="m[]" id="id<?php echo $a; $a = $a + 1; ?>" value="<?php echo $row3['refid']; ?>" <?php if ( strlen(strstr(','.$checkedrights ,','.$row3['refid'].',' ))>0 ) {  ?>checked="checked"<?php } ?> >
                                   <label id="lab<?php echo $b; $b = $b + 1; ?>" ><?php echo $row3['name']; ?></label>

                                              <?php
                                                 include "config.php";  
                                                 $query3 = "SELECT * FROM common_links where active = 1 and step = 4 and parentid = '$row3[refid]' ORDER BY sortorder ASC ";
                                                 $result3 = mysql_query($query3,$conn); 
                                                 if(mysql_num_rows($result3))
                                                 {
                                              ?>
                                              <ul>
                                                 <?php   
                                                    while($row4 = mysql_fetch_assoc($result3))
                                                    { 
                                                 ?>
                           <?php if ( strlen(strstr($rights ,$row4['refid'] ))>0 ) {  ?>
                          					<li>

                                   <input type="checkbox" name="m[]" id="id<?php echo $a; $a = $a + 1; ?>" value="<?php echo $row4['refid']; ?>" <?php if ( strlen(strstr(','.$checkedrights ,','.$row4['refid'].',' ))>0 ) {  ?>checked="checked"<?php } ?> >
                                   <label id="lab<?php echo $b; $b = $b + 1; ?>" ><?php echo $row4['name']; ?></label>
           

                                                     </li>
                            <?php } ?> 
                                                <?php } ?></ul><?php } ?>

                                                       </li>
                            <?php } ?> 
                             
                                                <?php } ?></ul><?php } ?>

                                         </li>
                            <?php } ?> 

                                  <?php } ?></ul><?php } ?>
                              </li>
                            <?php } ?> 

                   <?php } ?>



</ul>
<br />  
</div>
<div >

<fieldset style="margin-bottom:20px;width:400px">
<br />
<table>
 <tr>
  <td width="100">Employee</td><td width="100">
  <input name="empid" value="<?php echo $empid; ?>" type="hidden">
  <input name="empsector" value="<?php echo $empsector; ?>" type="hidden">
          <input name="employee" id="employee" type="text"    value="<?php  echo $employee; ?>" size="18" readonly style="border:0px;background:none;">
<td >&nbsp;&nbsp;<input type="button" value="Show Password"  onClick="showpass();"></td>

</td>
 </tr>
<tr height="10px"><td></td></tr>
 <tr>
  <td width="100">Username</td><td width="100"><input type="text" id="uname" name="uname" value="<?php echo $username; ?>" size="18" readonly style="border:0px;background:none;" /></td><td id="pass" style="display:none" width="100">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $passwordd;?></td>
 </tr> 
<tr height="10px"><td></td><td></td></tr>
<tr>
  <td width="100">Password</td>
  <td width="100"><input  type="password" name="pass" value=""  size="18" id="pass1" /><span id="hint" ><a href="#">Hint</a></span>
  <input type="hidden" id="hiddenpass" name="password" value="<?php echo $passwordd;?>"></td>
  <td>&nbsp;</td>
 </tr> 
<tr height="10px"><td></td><td></td></tr>
<tr>
  <td width="100" >Conform Password</td><td width="100" >
  <input type="password" name="pass2" value=""  size="18" id="repass" />
  </td>
  <td>&nbsp;</td>
 </tr> 
<tr height="10px"><td></td><td></td></tr>
<tr>
  <td width="100">Email</td><td width="100"><input type="hidden" id="oldemail" name="oldemail" value="<?php echo $emaild; ?>" /><input type="text" id="email" name="email" value="<?php echo $emaild; ?>" size="18" /></td><td align="left" id="emailcheck"></td><td id="emailavailable" style="display:none"><img  title="This email id is available" src="images\icons\fugue\tick-circle.png" ></td><td style="display:none" id="emailloading" ><img  title="This user name is avilable" src="images\mask-loader.gif" ></td>
 </tr> 
<tr> 
<tr height="10px"><td></td></tr>
<tr>
  <td width="100">Sector</td><td width="100">
  <select name="sector[]" multiple="multiple" id="sector" style="width:125px;">
           <option value="">-Select-</option>
		  
	<?php 
              include "config.php"; 
			 $sectorarray= explode(',',$sector);
                            $query = "SELECT sector FROM tbl_sector  ORDER BY sector ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
			    if(in_array($row1['sector'], $sectorarray))
			     $selected = "selected = 'selected'";
				else
				 $selected = "";
           ?>
           <option value="<?php echo $row1['sector']; ?>"  <?php echo $selected; ?>><?php echo $row1['sector']; ?></option>
           <?php } ?>
	   <?php
              $query = "SELECT distinct(place) FROM broiler_farm ORDER BY place ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
			   if(in_array($row1['place'], $sectorarray))
			    $selected = "selected = 'selected'";
			   else
				$selected = "";
         ?>
           <option value="<?php echo $row1['place']; ?>" title="<?php echo $row1['place']; ?>" <?php echo $selected; ?>><?php echo $row1['place']; ?></option>
           <?php }  ?>
		    <option value="all" title="All" <?php if($sector == "all") echo "selected='selected'";  ?>>All</option>
         </select>
  </td>
 </tr> 
 
 
  </tr> 
  
  <tr height="10px"><td></td></tr>
 <?php
 if($_SESSION['db']=="singhsatrang")
 {
 ?>
 
 <tr height="10px"><td></td></tr>
<tr <?php if($superstockistflag==0){?>style="display:none" <?php }?> id="superstockisttid">
  <td style="vertical-align:middle" width="100">CNF/Superstockist</td><td width="100">
  <select name="superstockist[]" multiple="multiple" id="superstockist" style="width:125px;" onChange="getall(this.selectedIndex)">
             
		   <option value="all" title="All" <?php if(in_array("all",$superstockist)){?> selected="selected" <?php }?>>All</option> 
	<?php
              
			  $sector='';
              $query = "SELECT name FROM contactdetails where superstockist='YES'   ORDER BY name ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
			  
           ?>
           <option value="<?php echo $row1['name']; ?>" <?php if(in_array($row1['name'],$superstockist)){?> selected="selected" <?php }?>><?php echo $row1['name']; ?></option>
           <?php } ?>
	
		   
         </select>
  </td>
 </tr> 
 
 
 <?php }?>

 
 
 
 
 <?php 
  {  ?> 
 <tr height="40px"><td></td></tr>
 <tr>
  <td align="right"><input <?php if($admin) echo 'checked="checked"'; ?> type="checkbox" value="1" id="admin" name="admin" /></td>
  <td width="100"> &nbsp;&nbsp;&nbsp;Authority Power</td>
 </tr>
 <?php if($_SESSION[db]=='skdnew' or $_SESSION[db] == 'alwadi'){
 $authorizesectors= explode(',',$authorizesectors);?>
 <tr height="10px"><td></td></tr>
  <tr>
  <td style="vertical-align:middle" width="100">Authority Sections</td><td width="100">
  <select name="authorizesectors[]" multiple="multiple" id="authorizesectors" style="width:125px;">     
    <?php
   $query = "SELECT code,name FROM authorize_sections ORDER BY name";
   $result = mysql_query($query,$conn) or die(mysql_error());
   while($rows = mysql_fetch_assoc($result))
   {
	?>
	<option <?php if(in_array($rows[code], $authorizesectors)){ ?> selected="selected" <?php } ?> value="<?php echo $rows['code']; ?>"><?php echo $rows['name']; ?></option> 
	<?php
   }
		   
	?>	
		   </select>
		   
		   
		    <option <?php if(in_array('PSOBI', $authorizesectors)) echo "selected = 'selected'"; ?> value="PSOBI">SOBI</option> 
		   </td>
   </tr>
 <?php }} ?> 

  <td colspan="3"><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input id="submit" type="submit" value="Update" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=common_users';" /></td>

 </tr> 
</table>
</fieldset>

<div id="data"  style="height:330px;overflow:auto;"></div>

</div>
</fieldset>
</form>

<script type='text/javascript'>
updatediv();
 function updatediv()
 {
 //alert('hi');
   var checkedrights = document.getElementById("checkedrights").value;
   var addrights = document.getElementById("addrights").value;
   var editrights = document.getElementById("editrights").value;
   var deleterights = document.getElementById("deleterights").value;
   var authorizerights = document.getElementById("authorizerights").value;

   var data = document.getElementById("data");
   data.innerHTML = "";
   var table = document.createElement('table');
   //table.setAttribute('border','1px');

   var tr = document.createElement('tr');
 
      var td = document.createElement('th');
      var text = document.createTextNode("Section");
      td.appendChild(text);
      tr.appendChild(td);

      var td = document.createElement('th');
      td.setAttribute('width','180px');
      td.style.textAlign="left";
      td.appendChild(text);
      tr.appendChild(td);

      var td = document.createElement('th');
      var text = document.createTextNode("");
      td.appendChild(text);
      tr.appendChild(td);

      var td = document.createElement('th');
      td.setAttribute('width','40px');
      td.appendChild(text);
      tr.appendChild(td);

      var td = document.createElement('th');
      var text = document.createTextNode("Add");
      td.appendChild(text);
    //  tr.appendChild(td);

      var td = document.createElement('th');
      td.setAttribute('width','40px');
      td.appendChild(text);
     // tr.appendChild(td);

      var td = document.createElement('th');
      var text = document.createTextNode("Edit");
      td.appendChild(text);
    //  tr.appendChild(td);

      var td = document.createElement('th');
      td.setAttribute('width','40px');
      td.appendChild(text);
    //  tr.appendChild(td);

      var td = document.createElement('th');
      var text = document.createTextNode("Delete");
      td.appendChild(text);
    //  tr.appendChild(td);

      var td = document.createElement('th');
      td.setAttribute('width','40px');
      td.appendChild(text);
     // tr.appendChild(td);

      var td = document.createElement('th');
      var text = document.createTextNode("Authorize");
      td.appendChild(text);
   //   tr.appendChild(td);
   table.appendChild(tr);


for(var i = 1;i<<?php echo $a; ?>;i++)
{
  if(document.getElementById('id' + i).checked)
  { 
   var tr = document.createElement('tr');
 
      var td = document.createElement('td');
      var text = document.createTextNode(document.getElementById("lab" + i).innerHTML);
      td.appendChild(text);
      tr.appendChild(td);

      var td = document.createElement('td');
      td.setAttribute('width','20px');
      td.appendChild(text);
      tr.appendChild(td);

      var td = document.createElement('td');
      //var text = document.createTextNode("View");
      var text = document.createElement('input');
      text.type = "checkbox";
      //text.disabled = "true";
      text.name = "view[]";
      text.value = document.getElementById('id' + i).value;
      if(checkedrights.indexOf(document.getElementById('id' + i).value)) { text.checked = "true"; } else { text.checked = "false"; }
      td.appendChild(text);
      tr.appendChild(td);

      var td = document.createElement('td');
      td.setAttribute('width','20px');
      td.appendChild(text);
      tr.appendChild(td);

      var td = document.createElement('td');
      var text = document.createElement('input');
      text.type = "checkbox";
      if(addrights.indexOf(document.getElementById('id' + i).value) >= 0) { text.checked = "true"; } else { text.checked = "false"; }
      text.name = "add[]";
      text.value = document.getElementById('id' + i).value;
      td.appendChild(text);
    //  tr.appendChild(td);

      var td = document.createElement('td');
      td.setAttribute('width','20px');
      td.appendChild(text);
    //  tr.appendChild(td);

      var td = document.createElement('td');
      var text = document.createElement('input');
      text.type = "checkbox";
      if(editrights.indexOf(document.getElementById('id' + i).value) >= 0) { text.checked = "true"; } else { text.checked = "false"; }
      text.name = "edit[]";
      text.value = document.getElementById('id' + i).value;
      td.appendChild(text);
    //  tr.appendChild(td);

      var td = document.createElement('td');
      td.setAttribute('width','20px');
      td.appendChild(text);
    //  tr.appendChild(td);

      var td = document.createElement('td');
      var text = document.createElement('input');
      text.type = "checkbox";
      if(deleterights.indexOf(document.getElementById('id' + i).value) >= 0) { text.checked = "true"; } else { text.checked = "false"; }
      text.name = "delete[]";
      text.value = document.getElementById('id' + i).value;
      td.appendChild(text);
   //   tr.appendChild(td);

      var td = document.createElement('td');
      td.setAttribute('width','20px');
      td.appendChild(text);
    //  tr.appendChild(td);

      var td = document.createElement('td');
      var text = document.createElement('input');
      text.type = "checkbox";
      if(authorizerights.indexOf(document.getElementById('id' + i).value) >= 0) { text.checked = "true"; } else { text.checked = "false"; }
      text.name = "authorize[]";
      text.value = document.getElementById('id' + i).value;
      td.appendChild(text);
    //  tr.appendChild(td);
   table.appendChild(tr);
  }  
}

 data.appendChild(table);


 }
 
function validate()
 {
  if(document.getElementById('uname').value=='')
  {
  alert('Enter user name'); return false;
  }
  
  
  
   //validation of password starts here.............
  
   var uname=document.getElementById('uname').value;
  
/*  if(document.getElementById('pass1').value=='')
  {
  alert('Enter New Password');document.getElementById('pass1').focus(); return false;
  }*/
  
  
  var password=document.getElementById('pass1').value;
  
  
  if(password.match(uname))
  {
    alert("Password Should Not Contain Username");
    document.getElementById('pass1').focus();
    return false;
  }
  
  
   if(!validatepassword("pass1",password))
  {
  document.getElementById('pass1').focus();
  return false;
  }
  
   if(document.getElementById('repass').value=='')
  {
  alert('Enter Confirm Password'); document.getElementById('repass').focus(); return false;
  }
  
  
  
 var password=document.getElementById('repass').value;
 
  if(password.match(uname))
  {
    alert("Password Should Not Contain Username");
    document.getElementById('repass').focus();
    return false;
  }
 
 
  
  if(!validatepassword("repass",password))
  {
  document.getElementById('repass').focus();
  return false;
  }
  
  
  
  //----------------------------------validation ends here-----------------
  
  
  if(document.getElementById('sector').value=='')
  {
  alert('Select atleast one sector'); return false;
  }
  if(document.getElementById("pass1").value != document.getElementById("repass").value)
  {
  alert('Password and Conform Password must be same'); return false;
  }
  
  <?php if($_SESSION[db]=='central' or $_SESSION[db] == 'alwadi') { ?> 
  if(document.form1.admin.checked)
  if(document.getElementById('authorizesectors').value=='' )
  {
  alert('Select Atleast one Authority Sections'); return false;
  }
  <?php } ?>
  
 }
 
 
$(document).ready(function()
{  		
	$("#email").blur(function()
	{  
	   
	   if($("#email").val() && $("#email").val() != $("#oldemail").val()) {
	   document.getElementById("emailavailable").style.display='none';
	   document.getElementById("emailloading").style.display='';
		$.post("ajax_emailcheck_edit.php",{ email:$("#email").val()+'##'+$("#oldemail").val() },function(data)
        {
		document.getElementById("emailloading").style.display='none';
		if(data>0)
		 { 
		  alert('This email id is already exist');
		  document.getElementById("email").value='';
		  document.getElementById("emailcheck").innerHTML='*already exist';
		  document.getElementById("emailcheck").style.color='#FF0000';
		  document.getElementById("submit").disabled='disabled';
		 }
		 else if(data==0){
		  document.getElementById("emailcheck").innerHTML='';
		  //document.getElementById("usercheck").style.color='#00FF00';
		  document.getElementById("emailavailable").style.display='';
		  document.getElementById("submit").disabled='';
		 }
		});
		
		} // end of if
    });
	
	
	
});
 

 function getall(index)
 {

 if(document.form1.elements["superstockist[]"][0].selected)
 {
 //alert(document.form1.elements["superstockist[]"][0].selected);
 document.form1.elements["superstockist[]"].options[0].selected=true;
 
 for(i=1;i<document.form1.elements["superstockist[]"].options.length;i++)
{

 document.form1.elements["superstockist[]"].options[i].selected=false;
 
} 
 }
 
 }
 
function getsuperstockist(id)
 {

 
 var id1=id.replace("lab","id");
 //alert(document.getElementById(id1).checked);
 
 if(!document.getElementById(id1).checked)
 {
var value=document.getElementById(id).innerText;
 if(value=="Distribution")
 {

 document.getElementById("superstockisttid").style.display="";
 }
 
 }
 else
 {
 var value=document.getElementById(id).innerText;
 if(value=="Distribution")
 {
 document.getElementById("superstockisttid").style.display="none";
 for(i=0;i<document.form1.elements["superstockist[]"].options.length;i++)
{

 document.form1.elements["superstockist[]"].options[i].selected=false;
 
} 

 }
 
 
 }
 
 }
  function validatepassword(id,value)
 {
 
 
 //if you set it more strong
 /*
 ^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$


Explanation:

^                         Start anchor
(?=.*[A-Z].*[A-Z])        Ensure string has two uppercase letters.
(?=.*[!@#$&*])            Ensure string has one special case letter.
(?=.*[0-9].*[0-9])        Ensure string has two digits.
(?=.*[a-z].*[a-z].*[a-z]) Ensure string has three lowercase letters.
.{8}                      Ensure string is of length 8.
$                          End anchor.
 
 */
 
 
 if(value!="")
 {
 

 var username=document.getElementById("uname").value;
 
 var strongRegex = new RegExp("^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$", "g");
 
 if(!strongRegex.test(value))
 {
 
 alert("Please Set Strong Password");
  document.getElementById(id).focus();
  
  return 0;
 
 }
 
 }
 
 return 1;
 
 
 }
</script>
</body>
</html>
