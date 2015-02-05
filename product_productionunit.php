<?php include "jquery.php"; ?>
<script type="text/javascript">
		$(document).ready(function()
		{
			$('.sortable').each(function(i)
			{
				var table = $(this),
					oTable = table.dataTable({

						aoColumns: [

							{ sType: 'eu_date',asSorting: [ "desc" ] },
 							{ },
 							{ },
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
	
		<div class="float-left">
			<!--<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button> -->
			
		</div>
		
		<div class="float-right"> 
		
	
			<!--<button type="button" class="grey">View</button> -->
			<!-- <button type="button" disabled="disabled">Disabled</button> -->
			<!--<button type="button" class="red">Authorize</button> -->

<button type="button" onclick="document.location='dashboardsub.php?page=product_addproduction';"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
		
		</div>
			
	</div></div>
<!--										-->	
<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
				<h1>Production Unit</h1>
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
						<tr>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Date
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								warehouse
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Product Type
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Formula
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Mat. Consumed
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Produced Product
							</th> 
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Cost / Kg
							</th> 
                                          <th>Actions</th>
						</tr>
					</thead>
					
					<tbody>
						

<?php 
     include "config.php"; 
   
   if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
      $query1 = "SELECT * FROM product_productionunit where date >= '$fromdate' and date <= '$todate' order by date DESC"; 
  }
		   else
		   {
		 $sectorlist = $_SESSION['sectorlist'];
		  $query1 = "SELECT * FROM product_productionunit where date >= '$fromdate' and date <= '$todate' and warehouse in ($sectorlist) order by date DESC"; 
		 }
     $result1 = mysql_query($query1,$conn); 
     while($row1 = mysql_fetch_assoc($result1)) 
     { 
 ?>
         <tr>
            <td><?php echo date("d.m.Y",strtotime($row1['date'])); ?></td>
            <td><?php echo $row1['warehouse']; ?></td>
            <td><?php echo $row1['producttype']; ?></td>
            <td><?php echo $row1['formula']; ?></td>
            <td><?php echo $row1['matconsumed']; ?></td>
            <td><?php echo $row1['production']; ?></td>
            <td><?php echo $row1['costperunit']; ?></td>
            <td>

&nbsp;
 <?php if( ($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") )
 {?>  
<a onclick="if(confirm('Are you sure,want to delete')) document.location ='product_deleteproductionunit.php?id=<?php echo $row1['id']; ?>&col=<?php echo 'id'; ?>&date=<?php echo $row1['date']; ?>&warehouse=<?php echo $row1['warehouse']; ?>&feedtype=<?php echo $row1['mash']; ?>&formula=<?php echo $row1['formula']; ?>&name=<?php echo 'product_productionunit'; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Lock" />&nbsp;</td>
</a>
<?php }
 else
 {
 ?>
<img src="images/icons/fugue/lock.png" style="border:0px" title="Lock" />&nbsp;</td>
<?php }?>

</td>
         </tr>
<?php } ?> 				
					</tbody>
				
				</table>
					
			</form></div>
		</section>
		
		
		<div class="clear"></div>
		
	</article>

<script type="text/javascript">
function reloadpage()
{
var month = document.getElementById('month').value;
var year = document.getElementById('year').value;
document.location = "dashboardsub.php?page=product_productionunit&month=" + month + "&year=" + year;
}
</script>
