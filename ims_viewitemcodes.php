<?php 
include "config.php"; 
$query = "select * from ims_itemcodes where id = '$_GET[id]'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_array($result))
{
  $itemcode = $row['code'];
  $category = $row['cat'];
  $description = $row['description'];
  $warehouse = $row['warehouse'];
  $vmethod = $row['cm'];
  $sunits = $row['sunits'];
  $cunits = $row['cunits'];
  $usage = $row['iusage'];
  $source = $row['source'];
  $type = $row['type'];
  $lscontrol = $row['lscontrol'];
  $iac  = $row['iac'];
  $pvac = $row['pvac'];
  $stdcost = $row['stdcost'];
}


?>

<center>
<br />
<h1>Item Masters</h1>
<br/><br/><br />
<form id="form1" name="form1" method="post" action="#"  onsubmit="">
<table align="center" >
<tr> 
<td width="200" align="right"><strong>Item Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $itemcode; ?></td>
<td width="200" align="right"><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left"><?php echo $description; ?></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right"><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $category; ?></td> 

<td width="200" align="right"><strong>Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $warehouse; ?></td> 

</tr>
<tr height="10px"><td></td></tr>
<tr>
<td width="200" align="right"><strong>Valuation Method</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $vmethod; ?></td> 
<td width="200" align="right" id="stdcostrow" ><strong>Standard Cost/Unit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left" id="stdcostrow1" ><?php echo $stdcost; ?>
</td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right"><strong>Storage Units Of Measure</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $sunits; ?></td>
<td width="240" align="right"><strong>Consumption Units Of Measure</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left"><?php echo $cunits; ?></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right"><strong>Usage</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $usage; ?></td>

<td width="200" align="right"><strong>Source</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $source; ?></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right"><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $type; ?></td>

<td width="200" align="right"><strong>Item A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left"><?php echo $iac; ?></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right"><strong>Lot/Serial Control</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $lscontrol; ?></td>

<td width="200" align="right"><strong>Price Variance A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left"><?php echo $pvac; ?></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right" id="am1td" style="visibility:hidden"><strong>Select</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left" ></td>

<td width="200" align="right" id="wpactd" style="visibility:hidden"><strong>W/P A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"></td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right" id="digits1td" style="visibility:hidden"><strong>Lot No. Limit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"></td>

<td width="200" align="right" id="cogsactd" style="visibility:hidden"><strong>COGS A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"></td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right" id="startvalue1td" style="visibility:hidden"><strong>Lot No. Starting Value</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"></td>

<td width="200" align="right" id="sactd" style="visibility:hidden"><strong>Sales A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"></td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right" id="digits2td" style="visibility:hidden"><strong>Serial No. Limit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left" ></td>

<td width="200" align="right" id="sractd" style="visibility:hidden"><strong>Sales Return</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"></td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right" id="startvalue2td" style="visibility:hidden"><strong>Serial No. Starting Value</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left" id="amtd2" ></td>

<td width="200" align="right" >&nbsp;</td>
<td width="200" align="left">&nbsp;

</td>

</tr>


<tr>
<td colspan="5" align="center">
<br />
<center>
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ims_itemcodes'">
</center>
</td>
</tr>
</table>
</center>
<br /><br /><br />
</form>
<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_m_additemmaster.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=YES,resizable=yes');
}
</script>


	<footer>
		<div class="float-left">
			<!-- <a href="#" class="button" onClick="script1()">Help</a> -->
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