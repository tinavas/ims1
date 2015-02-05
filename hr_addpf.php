<center>

<h1>Professional Tax</h1>

</center>

<br />

<br/>



<form id="form1" name="form1" method="post"  action="hr_savepf.php"  enctype="multipart/form-data">

<table align="center"  id="inputs1">

<tr>

<th><strong>Salary From</strong>&nbsp;&nbsp;&nbsp;</th>

<td width="10">&nbsp;</td>

<th><strong>Salary To</strong>&nbsp;&nbsp;&nbsp;</th>

<td width="10">&nbsp;</td>

<th><strong>Tax</strong>&nbsp;&nbsp;&nbsp;</th>

<td width="10">&nbsp;</td>

<th><strong>Coa Code</strong>&nbsp;&nbsp;&nbsp;</th>

</tr>



<tr>

<td align="left"><input type="text" id="salfrom0" name="salfrom[]" size="17" /></td> 

<td width="10">&nbsp;</td>

<td  align="left"><input type="text" id="salto0" name="salto[]" size="17"/></td> 

<td width="10">&nbsp;</td>

<td  align="left"><input type="text" id="tax0" name="tax[]" size="15" /></td> 
<td width="10">&nbsp;</td>

<td  align="left">
<select style="Width:80px" name="coa[]" id="coa0" onfocus="makeform();">
  <option value="">-Select-</option>
  <?php 
  $query="select code,description from ac_coa where type='Liability' or type='Expense'";
  $result=mysql_query($query,$conn);
  while($rows=mysql_fetch_assoc($result))
  {
  ?>
  <option value="<?php echo $rows['code'];?>" title="<?php echo $rows['description'];?>" ><?php echo $rows['code'];?></option>
  <?php
  } 
  ?>
</select>
</td> 
</tr>

</table>

 <br />

<center>

<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_pf';">

</center>





</form>

<script language="JavaScript" type="text/javascript">

function removeAllOptions(selectbox)

{

	var i;

	for(i=selectbox.options.length-1;i>=0;i--)

	{

		selectbox.remove(i);

	}

}



var indexz = 0;

function makeform()

{

  

  if((indexz>0) &&((document.getElementById('salto'+indexz).value =="") || (document.getElementById('coa'+(indexz-1) ).value =="")) )

  {

  }

  else

  {

  indexz = indexz + 1;

  var t1  = document.getElementById('inputs1');

  var r1 = document.createElement('tr'); 



  mybox1=document.createElement("input");

  mybox1.size="17";

  mybox1.type="text";

  mybox1.name="salfrom[]" ;

  mybox1.id="salfrom" + indexz;

  var ba1 = document.createElement('td');

  ba1.appendChild(mybox1);



  var b1 = document.createElement('td');

  myspace2= document.createTextNode('\u00a0');

  b1.appendChild(myspace2);

  

  mybox1=document.createElement("input");

  mybox1.size="17";

  mybox1.type="text";

  mybox1.name="salto[]";

  mybox1.id="salto" + indexz;

  var ba2 = document.createElement('td');

  ba2.appendChild(mybox1);



  var b2 = document.createElement('td');

  myspace2= document.createTextNode('\u00a0');

  b2.appendChild(myspace2);

  

  mybox1=document.createElement("input");

  mybox1.size="15";

  mybox1.type="text";

  mybox1.name="tax[]";

  mybox1.id="tax" + indexz;

  var ba3 = document.createElement('td');

  ba3.appendChild(mybox1);



  var b3 = document.createElement('td');

  myspace2= document.createTextNode('\u00a0');

  b3.appendChild(myspace2);

 myselect1 = document.createElement("select");
  myselect1.style.width = "80px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.value = "";
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
<?php 
  $query="select code,description from ac_coa where type='Liability' or type='Expense'";
  $result=mysql_query($query,$conn);
  while($rows=mysql_fetch_assoc($result))
  {
	  ?>  
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('<?php echo $rows['code'];?>');
  theOption1.value = "<?php echo $rows['code'];?>";
  theOption1.title="<?php echo $rows['description'];?>";
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
 <?php } ?> 
  
  myselect1.name = "coa[]";
  myselect1.id = "coa" + indexz;
   myselect1.onfocus = function ()  {  makeform(); };
var ba4 = document.createElement('td');

  ba4.appendChild(myselect1);



  var b4 = document.createElement('td');

  myspace2= document.createTextNode('\u00a0');

  b4.appendChild(myspace2);


      r1.appendChild(ba1);

      r1.appendChild(b1);



      r1.appendChild(ba2);

      r1.appendChild(b2);

	  

	  r1.appendChild(ba3);

      r1.appendChild(b3);
	   r1.appendChild(ba4);

      r1.appendChild(b4);

      t1.appendChild(r1);

	  }



}





</script>

<script type="text/javascript">

function script1() {

window.open('HRHELP/hr_m_addprofessionaltax.php','BIMS',

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

