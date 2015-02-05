<center>
<br />
<h1>Chart Of Accounts(Edit)</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/><br/><br />
<form id="form1" name="form1" method="post" action="ac_updatecoa.php"  onLoad="getschedule();" onsubmit="return checkform(this);">
<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>" />
<table align="center">
 <?php
       include "config.php";
       $query1 = "SELECT * FROM ac_coa where id = $_GET[id] ORDER BY id ASC ";
       $result1 = mysql_query($query1,$conn);
       while($row1 = mysql_fetch_assoc($result1))
       { $ctype=$row1['controltype'];
         $schedule=$row1['schedule'];
 ?>   
<tr>
<td width="150" align="right"><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="300" align="left"><input type="text" name="code" size="7" id="code" disabled="true" value="<?php echo $row1['code']; ?>" /></td>
</tr>
<tr height="10px"><td></td></tr>
<tr>
<td width="150" align="right"><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left"><input type="text" name="description" size="32" id="description" value="<?php echo $row1['description']; ?>" />
&nbsp;<span id="description1" style="color:red;"></span></td>
</tr>
<tr height="10px"><td></td></tr>
<tr>
<td width="150" align="right"><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left"><select style="Width:120px" name="type" id="type" disabled="true">
                      <option value="SELECT">-Select-</option>
        <option value="Asset" <?php if ( $row1['type'] == 'Asset' ) { ?> selected="selected" <?php } ?>>Asset</option>
        <option value="Capital" <?php if ( $row1['type'] == 'Capital' ) { ?> selected="selected" <?php } ?>>Capital</option>
   	  <option value="Expense" <?php if ( $row1['type'] == 'Expense' ) { ?> selected="selected" <?php } ?>>Expense</option>
	  <option value="Liability" <?php if ( $row1['type'] == 'Liability' ) { ?> selected="selected" <?php } ?>>Liability</option>
	  <option value="Revenue" <?php if ( $row1['type'] == 'Revenue' ) { ?> selected="selected" <?php } ?>>Revenue</option>
			</select>
</td>
</tr>
<tr height="10px"><td></td></tr>
<tr>
<td width="150" align="right"><strong>Control Type</strong>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left">
<select style="Width:180px" name="ctype" id="ctype" disabled="true" >
                      <option value="<?php echo $row1['controltype']?>" selected="selected"><?php  echo $row1['controltype'] ?></option>
			</select>
</td>
</tr>
<tr height="10px"><td></td></tr>
<tr>
<td width="150" align="right"><strong>Schedule</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left">
<select style="Width:220px" name="schedule" id="schedule" disabled="true" >
                     <option value="<?php echo $row1['schedule']?>" selected="selected"><?php echo $row1['schedule'] ?></option>
			</select>
</td>
</tr>
<tr height="10px"><td></td></tr>
<?php if($_SESSION['db'] == 'central') { $centre = $row1['costcentre']; ?>
<tr>
<td width="150" align="right"><strong>Cost Centre</strong>&nbsp;&nbsp;&nbsp;</td>
<td width="300" align="left">
<select style="Width:120px" name="costcentre" id="costcentre" >
                      <option value="">-Select-</option>
<?php $query = "select sector from tbl_sector where costeffect = 1 and client = '$client'";
	   $result = mysql_query($query,$conn) or die(mysql_error());
	   while($rows = mysql_fetch_assoc($reult))
	   {
	   ?>
	   <option value="<?php echo $rows['sector']; ?>" <?php if($centre == $rows['sector']) { ?> selected="selected" <?php } ?>><?php echo $rows['sector']; ?></option>
	   <?php
	   }
	   ?>					  
	   </select>
</td>
</tr>

<tr height="10px"><td></td></tr>
<?php } ?>
<?php } ?>
<tr>
<td colspan="5" align="center">
<br />
<center>
<input type="submit" value="Update" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ac_coa';">
</center>
</td>
</tr>
</table>
</center>
<br /><br /><br />
</form>
<script language="JavaScript" type="text/javascript">
function getschedule()
{
 removeAllOptions(document.getElementById("schedule"));
 removeAllOptions(document.getElementById("ctype"));

 myselect1 = document.getElementById("ctype");
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("");
              theOption1.appendChild(theText1);
              myselect1.appendChild(theOption1);

<?php
     include "config.php";
     $q2=mysql_query("select distinct(type) from ac_controltype order by type ASC");
	 
     while($nt2=mysql_fetch_array($q2)){
     echo "if(document.getElementById('type').value == '$nt2[type]'){";
     $q3=mysql_query("select * from ac_controltype where type='$nt2[type]' order by controltype ASC");
	  
     while($nt3=mysql_fetch_array($q3))
	 { ?>
			 

              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $nt3['controltype']; ?>");
			  theOption1.value = "<?php echo $nt3['controltype']; ?>";
               <?php  if($nt3['controltype'] == $ctype){ ?>  theOption1.selected = "selected"; <?php } ?>
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			 
    <?php   } 
      echo "}"; 
     }
  ?>
 		 myselect1 = document.getElementById("schedule");
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
              theOption1.appendChild(theText1);
              myselect1.appendChild(theOption1);
 <?php
     include "config.php";
     $q2=mysql_query("select distinct(type) from ac_schedule order by type ASC");
	 
     while($nt2=mysql_fetch_array($q2)){
     echo "if(document.getElementById('type').value == '$nt2[type]'){";
     $q3=mysql_query("select * from ac_schedule where type='$nt2[type]' order by schedule ASC");
	  
     while($nt3=mysql_fetch_array($q3))
	 { ?>
			 

              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $nt3['schedule']; ?>");
			  theOption1.value = "<?php echo $nt3['schedule']; ?>";
			  <?php  if($nt3['schedule'] == $schedule){ ?>  theOption1.selected = "selected"; <?php } ?>
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			 
    <?php   } 
      echo "}"; 
     }
  ?>
}



function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.remove(i);
	}
}


function checkform ( form )
{
var noalpha = /^[a-zA-Z.0-9]*$/;
 var noalpha1 = /^[a-zA-Z.0-9.\s]*$/;
 var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";
 var nonums = /^[0-9]*$/;
 var numericExpression = /^[0-9].+$/;
 if (form.description.value == "") 
{
  document.getElementById("description1").innerHTML = "Please enter description";
  document.getElementById("description").setAttribute("class","error relative");
  form.description.focus();
  return false ;
}
else if ((!(form.description.value.match(noalpha1)))) 
{
  document.getElementById("description1").innerHTML = "Description cannot have special characters";
  document.getElementById("description").setAttribute("class","error relative");
  form.description.focus();
  return false ;
 }
 else if (form.description.value.length > 45 ) 
 {
  document.getElementById("description1").innerHTML = "Description Should not be morethan 45 characters";
  document.getElementById("description").setAttribute("class","error relative");
  form.description.focus();
  return false ;
  }
   
  return true ;
}
</script>
<script type="text/javascript">
function script1() {
window.open('GLHelp/help_editcoa.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
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

