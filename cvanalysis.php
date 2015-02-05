
<?php 
include "jquery.php"; 
include "config.php";
include "getemployee.php";

?>


<center>
<br />
<body bgcolor="#ECF1F5">
<?php include "commonheader.php"; ?>
<center><h3><b>C.V.Analysis</b></h3>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
</center>

<br /><br />
<form name="cv" id="cv" method="post" action="cvsave.php" target="_parent">
<table width="492" border="0">
        <tr>
		<td width="41"><div align="right"><b><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></b></div></td>
		<td width="118"><input type="text" size="15" id="cvdate" name="cvdate" class="datepicker" onchange = "getage();" value="<?php echo date("d.m.o"); ?>"></td>
        <td width="62"><div align="right"><b><strong>Flock</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></b></div></td>
        <td width="111"><div align="left"><select style="width: 100px" name="flockdate" id="flockdate" onchange = "getage();" >
		                                         <option value="">-SELECT-</option>
												 <?php include "config.php"; 
                                  $query = "SELECT distinct(flockcode) as flock,startdate,age FROM breeder_flock ORDER BY flockcode ASC ";
                                  $result = mysql_query($query,$conn); 
                                  while($row1 = mysql_fetch_assoc($result))
                                  {
                                                  ?>
                                    <option value="<?php echo $row1['flock'].'@'.$row1['startdate'].'@'.$row1['age']; ?>"><?php echo $row1['flock']; ?></option>
								<?php } ?>
		                      </select>
							  <input type="hidden" name="flock" id="flock" value="" />
							  </div></td>
	    <td ><div align="left"><b><strong>Age(in weeks)</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></b></div></td>
        <td width="46"><div align="left"><input type="text" size="4" name="age" id="age" onChange="cal(this.value);"></div></td>  
      </tr>
  </table>
  <br />
 <table width="241">
<tr>
<td width="125"><div align="right"><b><strong>Weight<font size="1px;">(in grams)</font></strong></b></div></td>
<td width="0"></td>
<td width="100"><b><strong>No. Of Birds<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></b></td>
</tr>

<tr>
<td width="125"><div align="right"><input type="text" id="weight1" name="weight1" readonly style="background:none;border:0px; text-align:right" size="4"  /></div></td>
<td></td>
<td width="100"><input type="text" name="num1" id="num1" size="6"/></td>
</tr>

<tr>
<td width="125"><div align="right"><input type="text" id="weight2" name="weight2" readonly style="background:none;border:0px; text-align:right" size="4"  /></div></td>
<td></td>
<td width="100"><input type="text" name="num2" id="num2" size="6"/></td>
</tr>

<tr>
<td width="125"><div align="right">  <input type="text" id="weight3" name="weight3" readonly style="background:none;border:0px; text-align:right" size="4"  /></div></td>
<td></td>
<td width="100"><input type="text" name="num3" id="num3" size="6"/></td>
</tr>

<tr>
<td width="125"><div align="right"><input type="text" id="weight4" name="weight4" readonly style="background:none;border:0px; text-align:right" size="4"  /></div></td>
<td></td>
<td width="100"><input type="text" name="num4" id="num4" size="6"/></td>

</tr>

<tr>
<td width="125"><div align="right"><input type="text" id="weight5" name="weight5" readonly style="background:none;border:0px; text-align:right" size="4"  /></div></td>
<td></td>
<td width="100"><input type="text" name="num5" id="num5" size="6"/></td>
</tr>

<tr>
<td width="125"><div align="right"><input type="text" id="weight6" name="weight6" readonly style="background:none;border:0px;text-align:right" size="4"  /></div></td>
<td></td>
<td width="100"><input type="text" name="num6" id="num6" size="6"/></td>
</tr>

<tr>
<td width="125"><div align="right"><input type="text" id="weight7" name="weight7" readonly style="background:none;border:0px; text-align:right" size="4"  /></div></td>
<td></td>
<td width="100"><input type="text" name="num7" id="num7" size="6"/></td>
</tr>

<tr>
<td width="125"><div align="right"><input type="text" id="weight8" name="weight8" readonly style="background:none;border:0px; text-align:right" size="4"  /></div></td>
<td></td>
<td width="100"><input type="text" name="num8" id="num8" size="6"/></td>
</tr>

<tr>
<td width="125"><div align="right"><input type="text" id="weight9" name="weight9" readonly style="background:none;border:0px; text-align:right" size="4"  /></div></td>
<td></td>
<td width="100"><input type="text" name="num9" id="num9" size="6"/></td>
</tr>

<tr>
<td width="125"><div align="right"><input type="text" id="weight10" name="weight10" readonly style="background:none;border:0px; text-align:right" size="4"  /></div></td>
<td></td>
<td width="100"><input type="text" name="num10" id="num10" size="6"/></td>
</tr>

<tr>
<td width="125"><div align="right"><input type="text" id="weight11" name="weight11" readonly style="background:none;border:0px; text-align:right" size="4"  /></div></td>
<td></td>
<td width="100"><input type="text" name="num11" id="num11" size="6"/></td>
</tr>

</table>
</div>



<br />
<center>
<input type="submit" name="save" id="save" value="Save" onClick="return divert();" />
<input type="button" name="cancel" id="cancel" value="Cancel" onClick="document.location = 'dashboardsub.php?page=cv';" />
</form>
</body>
<script type="text/javascript">
function getage()
{
  var a = document.getElementById('flockdate').value;
  if(a != "")
  {
    var date1 = document.getElementById('cvdate').value;
    var flockdetails = a.split("@");
    document.getElementById('flock').value = flockdetails[0];
    var days = days_between(date1,flockdetails[1]) + parseInt(flockdetails[2]) + 1;
    var weeks = parseInt(days/7);
    //var days = parseInt(days%7);
    document.getElementById('age').value = weeks;
	cal(weeks);
  }
}
function days_between(date1, date2) {
date1 = date1.split(".");
date2 = date2.split("-");
var oneDay = 24*60*60*1000; 
var firstDate = new Date(date1[2],date1[1],date1[0]);
var secondDate = new Date(date2[0],date2[1],date2[2]);
 
var diffDays = Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay));
return diffDays;
}
function cal(a) {
 var avgw = 0;
 
 <?php
     $q2=mysql_query("select * from breeder_standards");
     while($nt2=mysql_fetch_array($q2))
	 {
       echo "if(document.getElementById('age').value == '$nt2[age]'){";
          $q3=mysql_query("select fweight from breeder_standards WHERE age ='$nt2[age]' ");
             while($nt3=mysql_fetch_array($q3))
			 {
              echo "document.getElementById('weight6').value = '$nt3[fweight]';";
	          echo "var avgw = '$nt3[fweight]';";
             } // end of while loop
 
	  echo "}";// end of JS if condition

     }
  ?>
  if(avgw != 0 )
  {
  document.getElementById('weight1').value = parseInt(avgw) - 100;
  document.getElementById('weight2').value = parseInt(avgw) - 80;
  document.getElementById('weight3').value = parseInt(avgw) - 60;
  document.getElementById('weight4').value = parseInt(avgw) - 40;
  document.getElementById('weight5').value = parseInt(avgw) - 20;
  document.getElementById('weight7').value = parseInt(avgw) + 20 ;
  document.getElementById('weight8').value = parseInt(avgw) + 40 ;
  document.getElementById('weight9').value = parseInt(avgw) + 60 ;
  document.getElementById('weight10').value = parseInt(avgw) + 80 ;
  document.getElementById('weight11').value = parseInt(avgw) + 100 ;
  }
  else
  {
  document.getElementById('weight1').value = 0;
  document.getElementById('weight2').value = 0;
  document.getElementById('weight3').value = 0;
  document.getElementById('weight4').value = 0;
  document.getElementById('weight5').value = 0;
  document.getElementById('weight7').value = 0 ;
  document.getElementById('weight8').value = 0 ;
  document.getElementById('weight9').value = 0 ;
  document.getElementById('weight10').value = 0 ;
  document.getElementById('weight11').value = 0 ;
  }
}

function divert()
{
 if(document.getElementById('flock').selectedIndex == 0)
 {
   alert("Please select a flock");
   document.getElementById('flock').focus();
   document.getElementById('age').value = "";
   return false;
 }
 
 else if(document.getElementById('num1').value == "")
 {
   alert("Please enter a number");
   document.getElementById('num1').focus();
   return false;
 }
 else if(document.getElementById('num2').value == "")
 {
   alert("Please enter a number");
   document.getElementById('num2').focus();
   return false;
 }
 else if(document.getElementById('num3').value == "")
 {
   alert("Please enter a number");
   document.getElementById('num3').focus();
   return false;
 }else if(document.getElementById('num4').value == "")
 {
   alert("Please enter a number");
   document.getElementById('num4').focus();
   return false;
 }
 else if(document.getElementById('num5').value == "")
 {
   alert("Please enter a number");
   document.getElementById('num5').focus();
   return false;
 }
 else if(document.getElementById('num6').value == "")
 {
   alert("Please enter a number");
   document.getElementById('num6').focus();
   return false;
 }
 else if(document.getElementById('num7').value == "")
 {
   alert("Please enter a number");
   document.getElementById('num7').focus();
   return false;
 }
 else if(document.getElementById('num8').value == "")
 {
   alert("Please enter a number");
   document.getElementById('num8').focus();
   return false;
 }
 else if(document.getElementById('num9').value == "")
 {
   alert("Please enter a number");
   document.getElementById('num9').focus();
   return false;
 }
 else if(document.getElementById('num10').value == "")
 {
   alert("Please enter a number");
   document.getElementById('num10').focus();
   return false;
 }
 else if(document.getElementById('num11').value == "")
 {
   alert("Please enter a number");
   document.getElementById('num11').focus();
   return false;
 }
}


function script1() {
window.open('BREEDERHELP/help_cvanalysis.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

</html>



