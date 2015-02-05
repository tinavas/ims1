<?php include "jquery.php";
 include "getemployee.php"; ?>
<script type="text/javascript">
		$(document).ready(function()
		{
			$('.sortable').each(function(i)
			{
				var table = $(this),
					oTable = table.dataTable({

						aoColumns: [

							
							{ },
							{ },
							{ },
							{ }
						],

						sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
						

						fnDrawCallback: function()
						{
							this.parent().applyTemplateSetup();
						},
						fnInitComplete: function()
						{
							this.parent().applyTemplateSetup();
						}
					});
				
				table.find('thead .sort-up').click(function(event)
				{
					event.preventDefault();
					
					var column = $(this).closest('th'),
						columnIndex = column.parent().children().index(column.get(0));
					
					oTable.fnSort([[columnIndex, 'asc']]);
					
					return false;
				});
				table.find('thead .sort-down').click(function(event)
				{
					event.preventDefault();
					
					var column = $(this).closest('th'),
						columnIndex = column.parent().children().index(column.get(0));
					
					oTable.fnSort([[columnIndex, 'desc']]);
					
					return false;
				});
			});
			
		});
		
	</script>
	<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	
		
		
		<div class="float-right"> 
	
			<button type="button" onClick="document.location='dashboardsub.php?page=pp_addsobi'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
		
			<!--<button type="button" class="grey">View</button> -->
			<!-- <button type="button" disabled="disabled">Disabled</button> -->
			<!--<button type="button" class="red">Authorize</button> -->


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Supplier Order Invoice</h1>
<?php
$month = $_GET['month'];
 $datep = date("d-m-Y");
$monthcnt = "";
$yearcnt = "";
$year = $_GET['year'];
if($year == "")
{

$arr = explode('-',$datep);
 $year = $arr[2];
}
if($month == "")
{
  $arr = explode('-',$datep);
 $monthcnt = $arr[1];
}
else if($month == "January")
{
$monthcnt = 1;
}
else if ($month == "February")
{
$monthcnt = 2;
}
else if($month == "March")
{
$monthcnt = 3;
}
else if($month == "April")
{
$monthcnt = 4;
}
else if($month == "May")
{
$monthcnt = 5;
}
else if($month == "June")
{
$monthcnt = 6;
}
else if($month == "July")
{
$monthcnt = 7;
}
else if($month == "August")
{
$monthcnt = 8;
}
else if($month == "September")
{
$monthcnt = 9;
}
else if($month == "October")
{
$monthcnt = 10;
}
else if($month == "November")
{
$monthcnt = 11;
}
else if($month == "December")
{
$monthcnt = 12;
}
$fromdate = $year."-".$monthcnt."-01";
$todate = $year."-".$monthcnt."-31";
?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Month:
<select name="month" id="month" onchange="reloadpage();" >
<option value="">--Select--</option>
<option  value="January"<?php if($monthcnt == 1){ ?> selected="selected"<?php } ?>>January</option>
<option  value="February"<?php if($monthcnt == 2){ ?> selected="selected"<?php } ?>>February</option>
<option  value="March"<?php if($monthcnt == 3){ ?> selected="selected"<?php } ?>>March</option>
<option  value="April"<?php if($monthcnt == 4){ ?> selected="selected"<?php } ?>>April</option>
<option  value="May"<?php if($monthcnt == 5){ ?> selected="selected"<?php } ?>>May</option>
<option  value="June"<?php if($monthcnt == 6){ ?> selected="selected"<?php } ?>>June</option>
<option  value="July"<?php if($monthcnt == 7){ ?> selected="selected"<?php } ?>>July</option>
<option  value="August"<?php if($monthcnt == 8){ ?> selected="selected"<?php } ?>>August</option>
<option  value="September"<?php if($monthcnt == 9){ ?> selected="selected"<?php } ?>>September</option>
<option  value="October"<?php if($monthcnt == 10){ ?> selected="selected"<?php } ?>>October</option>
<option  value="November"<?php if($monthcnt == 11){ ?> selected="selected"<?php } ?>>November</option>
<option  value="December"<?php if($monthcnt == 12){ ?> selected="selected"<?php } ?>>December</option>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year:
<select name="year" id="year" onchange="reloadpage();" >
<option value="">--Select--</option>
<?php 
for($i=$fyear;$i<=$tyear;$i++)
{
echo $i;
?>
<option value="<?php echo $i; ?>" <?php if($i == $year) { ?> selected="selected" <?php } ?>><?php echo $i; ?></option>
<?php } ?>
</select>

<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>

<tr >
<th style="text-align:center"><span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span>Date</th>
<th style="text-align:center"><span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span>SoBI #</th>

<th style="text-align:center"><span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span>Supplier</th>

<th style="text-align:center"><span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span>Goods Receipt #</th>

<th style="text-align:center"><span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span>Amount</th>

<th style="text-align:center">Actions</th>

</tr>

</thead>
<tbody>
	  <?php
           include "config.php"; 
		   
		              include "config.php"; 
		   
		       if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
		if($sectorlist=="")
        
           $query = "SELECT distinct(so),gr,grandtotal,flag,vendor,empname FROM pp_sobi where dflag = '1' and date >= '$fromdate' and date <= '$todate'  group by so order by so";
		   
		   else
		     $query = "SELECT distinct(so),gr,grandtotal,flag,vendor,empname FROM pp_sobi where dflag = '1' and date >= '$fromdate' and date <= '$todate' and warehouse in ($sectorlist)  group by so order by so";
		   
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		   
		   	$flag = $row1['flag']; 
			?>
			
			
			<tr>         
			<?php 
			$gr="";
			$query1 = "SELECT gr,date,empname FROM pp_sobi where so='$row1[so]' and dflag = '1' and date >= '$fromdate' and date <= '$todate' group by gr  ";
			
           $result1 = mysql_query($query1,$conn); 

           while($row2 = mysql_fetch_assoc($result1))
		   { 
		   		
				$user=$row2['empname'];
				$a="";
					$n=$n+1;
				 if($n%5==0)
				 {
				 	$a="<br/>";
				 }
		   		$gr=$gr."/".$row2['gr'].$a;
				$date=$row2['date'];
		   }
		   $gr= substr($gr,1,(strlen($gr)-1));

      ?>
            
            		<td style="text-align:center; width:100px"><?php echo date("d.m.Y",strtotime($date)); ?></td>
		<td style="text-align:center; width:100px"><?php echo $row1['so']; ?></td>
		<td style="text-align:center; width:100px"><?php echo $row1['vendor']; ?></td>	
		<td style="text-align:center; width:350px"><?php echo $gr; ?></td>
		<td style="text-align:right; width:100px"><?php echo $row1['grandtotal']; ?></td>
        <td>
   <?php if($_SESSION['valid_user']==$user || ($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") ){?>       

&nbsp;&nbsp;&nbsp;<a onclick="if(confirm('Do you really want to delete this row?')) document.location='pp_deletesobi.php?id=<?php echo $row1['so']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;


<?php }  else
  { ?>
<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Locked" />
<?php  }?>

&nbsp;&nbsp;<a href="invoice_purchase1.php?id=<?php echo $row1['so']; ?>" target="_new"><img src="images/icons/fugue/report.png" width="16px" style="border:0px" title="Print Invoice" />

 </td>
           </tr>
           <?php 
           }
           ?>   
                                   
</tbody>
</table>
</form>
</div>
</section>


<br />



<script type="text/javascript">
function reloadpage()
{
var month = document.getElementById('month').value;
var year = document.getElementById('year').value;
document.location = "dashboardsub.php?page=pp_sobi&month=" + month + "&year=" + year;
}
</script>

