<?php include "jquery.php";
 //include "getemployee.php";
  ?>
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
			<button type="button" onClick="document.location='dashboardsub.php?page=ims_addstockreceiving'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			 


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Stock Receive</h1>
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
$monthcnt = "01";
}
else if ($month == "February")
{
$monthcnt = "02";
}
else if($month == "March")
{
$monthcnt = "03";
}
else if($month == "April")
{
$monthcnt = "04";
}
else if($month == "May")
{
$monthcnt = "05";
}
else if($month == "June")
{
$monthcnt = "06";
}
else if($month == "July")
{
$monthcnt = "07";
}
else if($month == "August")
{
 $monthcnt = "08";
}
else if($month == "September")
{
$monthcnt = "09";
}
else if($month == "October")
{
$monthcnt = "10";
}
else if($month == "November")
{
$monthcnt = "11";
}
else if($month == "December")
{
$monthcnt = "12";
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
<th style="text-align:center" title="Auto Generated Number(Supplier Order Based Invoice)"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Cat</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>From Warehouse</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>To Warehouse</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Code</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Received Quantity</th>
<th style="text-align:center">Actions</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php";
 session_start();

		       if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
		if($sectorlist=="")   
    
     $query = "SELECT * FROM ims_stockreceive where  date >= '$fromdate' and date <= '$todate' group by tid order by date desc"; 
	 
	 else
	  $query = "SELECT * FROM ims_stockreceive where  date <= '$todate' and fromwarehouse in ($sectorlist) group by tid order by date desc"; 
	 

           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {  
$str=$row1[transferid];
		   	  
			  $i = 0;
		      $code = "";$towarehouse="";$quantity="";
              $q = "select * from ims_stockreceive where tid = '$row1[tid]' order by code";
			  $qrs = mysql_query($q,$conn) or die(mysql_error());
			  while($qr = mysql_fetch_assoc($qrs))
			  {
			  	$i++;
					$user=$qr['empname'];
				$towarehouse.= $qr['towarehouse'] . "/";
				$code.= $qr['code'] . "/";
				$quantity.= $qr['receivedquantity'] . "/";
				if($i%3 == 0)
				{
					$towarehouse.= "<br/>";
					$code.= "<br/>";
					$quantity.= "<br/>";
				}
			  }
			  $towarehouse = substr($towarehouse,0,-1);
			  $code = substr($code,0,-1);
			  $quantity = substr($quantity,0,-1);
			  
           ?>

            <tr>
			 <td><?php echo date("d.m.Y",strtotime($row1['date'])); ?></td>
			 <td><?php echo $row1['cat']; ?></td>
			 <td><?php echo $row1['fromwarehouse']; ?></td>
			 <td><?php echo $towarehouse; ?></td>
			 <td><?php echo $code; ?></td>
			<td><?php echo $quantity; ?></td>
             
			 <td>
			 
			 <?php if(($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") ){?> 
<!--<a href="dashboardsub.php?page=ims_editstockreceive&id=<?php echo $row1['id']; ?>&col=<?php echo "id"; ?>&tid=<?php echo $row1['tid']; ?>&date=<?php echo $row1['date']; ?>&flock=<?php echo $row1['aflock']; ?>&type=<?php echo "SR"; ?>&name=<?php echo "ims_stockreceive"; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" /></a>-->
              &nbsp; <a onclick="if(confirm('Are you sure,want to delete')) document.location ='ims_deletestockreceive.php?id=<?php echo $row1['id']; ?>&tid=<?php echo $row1['tid'];?>&date=<?php echo $row1['date']; ?>&str=<?php echo $row1['transferid']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
		
		
		<?php  } else { ?>

<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Locked" />
<?php  }?>	  
			  <!--<a href="stktrinvoice.php?tid=<?php echo $row1['tid']; ?>&towar=<?php echo $row1['towarehouse'];?>" target="_new"><img src="images/icons/fugue/report.png" style="border:0px" title="Print" /></a>-->

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
document.location = "dashboardsub.php?page=ims_stockreceive&month=" + month + "&year=" + year;
}
</script>



