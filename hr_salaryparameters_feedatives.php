<?php include "jquery.php" ?>
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
							{ sType: 'eu_date',asSorting: [ "desc" ] },
							{ sType: 'eu_date',asSorting: [ "desc" ] }
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
			<?php
		if($_SESSION['db'] == "feedatives")
		{?>
			<button type="button" onClick="document.location='dashboardsub.php?page=hr_addsalaryparameters_feedatives'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
	<?php } else {?>
			<button type="button" onClick="document.location='dashboardsub.php?page=hr_addsalaryparameters'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<?php } ?>
			


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Salary Parameters</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Name</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Sector</th>								
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>From Date</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>To Date</th>	
<th>Actions</th>							
</tr>
</thead>
<tbody>
	  <?php
           include "config.php"; 
           $query = "SELECT * FROM hr_salaryparameters ORDER BY name ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
              
           ?>
            <tr>
             <td><?php echo $row1['name']; ?></td>
			 <td><?php echo $row1['sector']; ?></td>
             <td><?php echo date("d.m.Y",strtotime($row1['fromdate'])); ?></td>
             <td><?php echo date("d.m.Y",strtotime($row1['todate'])); ?></td>
			  <td>
			  
			<a href="dashboardsub.php?page=hr_editsalaryparameters_feedatives&eid=<?php echo $row1['eid']; ?>&id=<?php echo $row1['id']; ?>&name=<?php echo $row1['name'];?>&sector=<?php echo $row1['sector'];?>">
			
			<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;
			
			<a href="hr_deletesalaryparameters_feedatives.php?id=<?php echo $row1['id']; ?>&mon=<?php echo $mnt;?>&year=<?php echo $row1['year'];?>">
			<img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;&nbsp;
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



