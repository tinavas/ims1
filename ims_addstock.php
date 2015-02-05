<?php include "config.php"; ?>
<script type="text/javascript">
function getstock(a)
{
 var temp = a.split('@');
 document.getElementById("pstock").value = temp[1];
 document.getElementById("warehouse").value = temp[2];
 var qty = document.getElementById("addstock").value;
 document.getElementById("fstock").value = Number(temp[1]) + Number(qty);
}

function changestock(a)
{
 document.getElementById("fstock").value = Number(document.getElementById("pstock").value) + Number(a);
}
function checkform()
{
 var fstock = Number(document.getElementById("fstock").value);
 var qty = Number(document.getElementById("addstock").value);
 if(qty != 0)
  return true;
 else
  return false;
}
  
</script>
<body>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:600px" id="complex_form" method="post" onSubmit="return checkform()" action="ims_savestock.php" >
	  <h1 id="title1">Add Stock</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>
<br />
<table>
 <tr>
  <td><strong>Code</strong></td>
  <td width="10px"></td>
  <td align="left">
  <select id="code" name="code" onChange="getstock(this.value);">
  <option value="select">-Select-</option>
  <?php
 echo  $query1 = "SELECT * FROM ims_stock WHERE itemcode IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat IN ('Ingredients','Medicines','Vaccines') AND client = '$client') AND warehouse = 'Godown' AND client = '$client' ORDER BY itemcode ASC";
   $result1 = mysql_query($query1,$conn) or die(mysql_error());
   while($rows = mysql_fetch_assoc($result1))
   {
    ?>
	<option value="<?php echo $rows['itemcode']."@".$rows['quantity']."@".$rows['warehouse']; ?>" title="<?php echo $rows['warehouse']; ?>"><?php echo $rows['itemcode']; ?></option>
	<?php
   }
  ?>
  </select>
  </td>
 </tr>
 <tr height="5px"></tr>
 <tr>
  <td><strong>Warehouse</strong></td>
  <td width="10px"></td>
  <td><input type="text" id="warehouse" value="0" style="background:none; border:none;" readonly ></td>
 </tr>
 <tr height="5px"></tr>
 <tr>
  <td><strong>Present Stock</strong></td>
  <td width="10px"></td>
  <td><input type="text" id="pstock" value="0" style="background:none; border:none;" readonly ></td>
 </tr>
 <tr height="5px"></tr>
 <tr>
  <td><strong>Adding Quantity</strong></td>
  <td width="10px"></td>
  <td><input type="text" id="addstock" value="10" onKeyUp="changestock(this.value);"  ></td>
 </tr>
 <tr height="5px"></tr>
 <tr>
  <td><strong>Final Stock</strong></td>
  <td width="10px"></td>
  <td><input type="text" id="fstock" name="fstock" value="0" ></td>
 </tr>
 <tr height="10px"></tr>
</table>		  
<input type="submit" value="Save" id="Save" />
</center>

</form>
</div>
</section>
