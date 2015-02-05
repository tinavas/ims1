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
			<button type="button" onClick="document.location='dashboardsub.php?page=ims_addbudgets'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			 


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Budget Allocation</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >

<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Month</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Year</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Cost Center</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Code</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Cr/Dr</th>								
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
		    $query = "SELECT * FROM ims_budget order by id";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {  
		   $m = $row1['month'];
		   if($m == '01') { $month = 'January'; }
		   else if($m == '02') { $month = 'February'; }
		   else if($m == '03') { $month = 'March'; }
		    else if($m == '04') { $month = 'April'; }
			 else if($m == '05') { $month = 'May'; }
			else if($m == '06') { $month = 'June'; }
			else if($m == '07') { $month = 'July'; }
			else if($m == '08') { $month = 'August'; }
			else if($m == '09') { $month = 'September'; }
			else if($m == '10') { $month = 'October'; }
			else if($m == '11') { $month = 'November'; }
			else if($m == '12') { $month = 'December'; }
			
              
           
           ?>
            <tr>		
			 <td><?php echo $month; ?></td>
			 <td><?php echo $row1['year']; ?></td>
			 <td><?php echo $row1['costcentre']; ?></td>	
			<td><?php echo $row1['coacode']; ?></td>
			 
			 <td><?php echo $row1['crdr']; ?></td>		
			 <td><?php echo $row1['amount']; ?></td>
			
              <td>

<a href="dashboardsub.php?page=ims_editbudgets&id=<?php echo $row1['id']; ?>&tid=<?php echo $row1['tid'];?>">
<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" />
</a>&nbsp;

			<a href="<?php echo 'ims_deletebudget.php?id='.$row1['id']; ?>">
			 			 
			 <img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" />
			 </a>&nbsp;


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
document.location = "dashboardsub.php?page=chicken_dailyrates&month=" + month + "&year=" + year;
}
</script>





