<?php 
		include "jquery.php";
		include "getemployee.php";
		include "config.php"; 
?>
<center>
<br />
<h1>TDS Limit</h1> 
<br /><br /><br />
<form action="tds_save_limit.php" method="post" onSubmit="return check_fields()">
<table align="center">
    <tr>
        <td align="left"><strong>From Date:&nbsp;</strong>
        	<input type="text" id="fromdate" name="fromdate" size="10" class="datepicker" placeholder="dd.mm.yyyy" onChange="check_date_exist(this);enable_disable();"  />
        </td>
        <td width="5px"></td>
        <td align="left"><strong>To Date:&nbsp;<strong>
        	<input type="text" id="todate" name="todate" size="10" class="datepicker" placeholder="dd.mm.yyyy" onChange="check_date_exist(this);enable_disable()" />
        </td>
        <td width="10px"></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="center" colspan="3"><strong>Cash Transaction Limit:&nbsp;<strong>
        	<input type="text" id="cash_limit" name="cash_limit" size="14" value="0" style="text-align:right" onKeyUp="enable_disable()" />
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
    	<td align="center" colspan="2"><input type="submit" value="Save" id="save" disabled="disabled"/></td>
        <td align="center"><input type="button" value="Cancel" onClick="javascript:window.location='dashboardsub.php?page=tds_limit'"/></td>
    </tr>
</table>

</form>
</center>

<script type="text/javascript">
function check_date_exist(date){
	var sp=date.value.split('.');
	var ttt=sp[2]+"-"+sp[1]+"-"+sp[0];
	var flag=0;
	
	<?php
			$query="SELECT fromdate, todate FROM tds_limit ORDER BY fromdate";
			$result=mysql_query($query);
			while($data=mysql_fetch_array($result))
			{
	?>	
				t1="<?php echo $data['fromdate'] ?>";
				t2="<?php echo $data['todate'] ?>";
				
				if(ttt>=t1 && ttt<=t2)
					flag=1;
				
	<?php
			}
	?>
	if(flag==1)
	{	
		alert(date.value+" falling under dates which already Exist");
		document.getElementById(date.id).value="";
		document.getElementById(date.id).focus();	
	}
}


function check_fields(){
		document.getElementById("save").disabled=true;
		var fdt=document.getElementById("fromdate").value;
		var tdt=document.getElementById("todate").value;
		fdt=fdt.split(".");
		fdt=fdt[2]+"-"+fdt[1]+"-"+fdt[0];
		tdt=tdt.split(".");
		tdt=tdt[2]+"-"+tdt[1]+"-"+tdt[0];
		if(tdt<fdt)
		{
				alert("Fromdate must be less than To Date");
				return false;
		}
	return true;
}

function enable_disable()
{
	if(document.getElementById("cash_limit").value>0 && document.getElementById("fromdate").value!="" && document.getElementById("todate").value!="")
		document.getElementById("save").disabled=false;
	else
		document.getElementById("save").disabled=true;
}
</script>
</body>
</html>