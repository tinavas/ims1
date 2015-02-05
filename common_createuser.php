

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Tulasi Technologies - BIMS</title>
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



<form name="form1" action="common_saveuser.php" onSubmit="return validate()" method="post">
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
             			<li >

                                   <input type="checkbox" name="m[]" id="id<?php echo $a; $a = $a + 1; ?>" value="<?php echo $row1['refid']; ?>"   >
                                   <label id="lab<?php echo $b; $b = $b + 1; ?>"  <?php if($_SESSION['db']=="singhsatrang"){?> onClick="getsuperstockist(this.id)" <?php }?>><?php echo $row1['name']; ?></label>
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
                                   <input type="checkbox" name="m[]" id="id<?php echo $a; $a = $a + 1; ?>" value="<?php echo $row2['refid']; ?>">
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
                                   <input type="checkbox" name="m[]" id="id<?php echo $a; $a = $a + 1; ?>" value="<?php echo $row3['refid']; ?>">
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

                                   <input type="checkbox" name="m[]" id="id<?php echo $a; $a = $a + 1; ?>" value="<?php echo $row4['refid']; ?>" />
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

<fieldset style="margin-bottom:20px;width:350px">
<br />
<table>
 <tr>
  <td width="100">Employee</td><td width="100">


         <select name="employee" id="employee" style="width:125px;">
           <option>-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM hr_employee WHERE designation <> 'Cleaner' AND designation <> 'Driver' AND designation <> 'Labourer' AND designation <> 'Loading/Unloading Supervisor' AND designation <> 'Maintainance' AND designation <> 'Watchman' AND designation <> 'Weekly Labour' AND name NOT IN (SELECT employeename FROM common_useraccess) ORDER BY name ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['employeeid'].'@'.$row1['name'].'@'.$row1['sector']; ?>"><?php echo $row1['name']; ?></option>
           <?php } ?>
         </select>


</td>
 </tr>
<tr height="10px"><td></td></tr>
 <tr>
  <td width="100">Username</td><td width="100"><input type="text" id="uname" name="uname" value="" size="18" /></td><td id="usercheck"></td><td id="avilable" style="display:none"><img  title="This user name is available" src="images\icons\fugue\tick-circle.png" ></td><td style="display:none" id="loading" ><img  title="This user name is avilable" src="images\mask-loader.gif" ></td>
 </tr> 
<tr height="10px"><td></td></tr>
<tr>
  <td width="100">Password</td><td width="100"><input id="pass" type="password" name="pass" value="" size="18" /><span id="hint" ><a href="#">Hint</a></span></td>
 </tr> 
<tr height="10px"><td></td></tr>
<tr>
  <td width="100">Email</td><td width="100"><input id="email" type="text" name="email" value="" size="18" /></td> <td id="emailcheck"></td><td id="emailavailable" style="display:none"><img  title="This email id is available" src="images\icons\fugue\tick-circle.png" ></td><td style="display:none" id="emailloading" ><img  title="This user name is avilable" src="images\mask-loader.gif" ></td>
 </tr> 
 

 
<tr height="10px"><td></td></tr>
<tr >
  <td style="vertical-align:middle" width="100">Sector</td><td width="100">
  <select name="sector[]" multiple="multiple" id="sector" style="width:125px;">
             
		   <option value="all" title="All">All</option> 
	<?php
              include "config.php"; 
			  $sector='';
              $query = "SELECT sector FROM tbl_sector   ORDER BY sector ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
			  
           ?>
           <option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
           <?php } ?>
	
		   
         </select>
  </td>
 </tr> 
 <?php
 if($_SESSION['db']=="singhsatrang")
 {
  include "config.php";
 ?>

 <tr height="10px"><td></td></tr>
<tr  style="display:none" id="superstockisttid">
  <td style="vertical-align:middle" width="100">CNF/Superstockist</td><td width="100">
  <select name="superstockist[]" multiple="multiple" id="superstockist" style="width:125px;" onChange="getall(this.selectedIndex)" >
             
		   <option value="all" title="All">All</option> 
	<?php
              
			  $sector='';
              $query = "SELECT name FROM contactdetails where superstockist='YES'   ORDER BY name ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
			  
           ?>
           <option value="<?php echo $row1['name']; ?>"><?php echo $row1['name']; ?></option>
           <?php } ?>
	
		   
         </select>
  </td>
 </tr> 
 
 
 <?php }?>
 
  <?php 
 if($_SESSION[admin]==1) {  ?> 
 <tr height="40px"><td></td></tr>
 <tr>
  <td align="right"><input type="checkbox" value="1" id="admin" name="admin" /></td>
  <td width="100"> &nbsp;&nbsp;&nbsp;Authority Power</td>
 </tr>
<?php } ?> 


<tr>
  <td colspan="2"><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" id="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=common_users';" /></td>
 </tr> 
</table>
</fieldset>

<div id="data"  style="height:330px;overflow:auto"></div>

</div>
</fieldset>
</form>
<div class="clear"></div>
<br />

<script type="text/javascript">
function script1() {
window.open('Management Help/help_m_addalert.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
<script type="text/javascript">
function script1() {
window.open('AdminHelp/help_m_adduserrights1.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
<script type='text/javascript'>
 function updatediv()
 {
   var data = document.getElementById("data");
   data.innerHTML = "";
   var table = document.createElement('table');
  



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
      var text = document.createTextNode("Add");
	  td.style.display='none';
      td.appendChild(text);
      tr.appendChild(td);

    
	
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
     
	 
      var text = document.createElement('input');
      text.type = "checkbox";
      text.checked = "true";
      
	  text.name = "view[]";
      text.value = document.getElementById('id' + i).value;
      td.appendChild(text);
      tr.appendChild(td);

      var td = document.createElement('td');
      td.setAttribute('width','20px');
      td.appendChild(text);
      tr.appendChild(td);

     
  table.appendChild(tr);
  }  
}

 data.appendChild(table);


 }
 
 function validate()
 {
 
 
 
 var selectitems = document.getElementById("employee");
 var items = selectitems.getElementsByTagName("option");
  if(items.length==1)
  {
  if(confirm('All Employees is given User Name or No Employees to Create Users,So please create Employee'))
   {
    document.location='dashboardsub.php?page=hr_addemployee';
	return false;
   }
  else
   return false;
  }
  if(document.getElementById('employee').value=='')
  {
  alert('Select the Employee'); return false;
  }
  
  if(document.getElementById('uname').value=='')
  {
  alert('Enter user name'); return false;
  }
  if(document.getElementById('pass').value=='')
  {
  alert('Enter user password'); return false;
  }
  
  
   //validation for password starts here------
  
  var uname=document.getElementById('uname').value;

  var password=document.getElementById('pass').value;
  
  if(password.match(uname))
  {
    alert("Password Should Not Contain Username");
    document.getElementById('pass').focus();
    return false;
  }
   
   if(!validatepassword("pass",password))
  {
   document.getElementById('pass').focus();
   return false;
  }
  
  //validation of password end here-----------
  
  
  
  if(document.getElementById('sector').value=='')
  {
  alert('Select Atleast one sector'); return false;
  }
  
  
  
  
  if(document.getElementById('data').innerHTML=='')
  {
  alert('Select atleast one Module'); return false;
  }
  
 }
 
 $(document).ready(function()
{  	
	$("#uname").blur(function()
	{  
	   
	   if($("#uname").val()) {
	   document.getElementById("avilable").style.display='none';
	   document.getElementById("loading").style.display='';
		$.post("getusers_ajax.php",{ username:$("#uname").val() },function(data)
        {
		document.getElementById("loading").style.display='none';
		if(data>0)
		 { 
		  alert('This user name is not avilable');
		  document.getElementById("uname").value='';
		  document.getElementById("usercheck").innerHTML='*Not Avilable';
		  document.getElementById("usercheck").style.color='#FF0000';
		  document.getElementById("submit").disabled='disabled';
		 }
		 else if(data==0){
		  document.getElementById("usercheck").innerHTML='';
		  //document.getElementById("usercheck").style.color='#00FF00';
		  document.getElementById("avilable").style.display='';
		  document.getElementById("submit").disabled='';
		 }
		});
		
		} // end of if
    });
	
	
	$("#email").blur(function()
	{  
	   
	   if($("#email").val()) {
	   document.getElementById("emailavailable").style.display='none';
	   document.getElementById("emailloading").style.display='';
		$.post("ajax_emailcheck.php",{ email:$("#email").val() },function(data)
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
