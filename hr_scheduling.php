<?php include "jquery.php";
      include "getemployee.php";
      include "config.php";
?>
<script type="text/javascript">
		$(document).ready(function()
		{
			$('.sortable').each(function(i)
			{
				var table = $(this),
					oTable = table.dataTable({


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
			<!--<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button> 
			<button type="button" onClick="openModal()">Open report</button>-->
		</div>
		
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboardsub.php?page=hr_addscheduling'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Task Assigning</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Scheduled Date</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Employee</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Task</th> 								
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php 
$query = "SELECT * FROM hr_scheduling "; 
$result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result)) { 
	  $flag = $row1['flag'];
	  ?>
            <tr>
             <td><?php echo date("d.m.Y",strtotime($row1['scheduleddate'])); ?></td>
            <td><?php echo $row1['employee']; ?></td>
			<td><?php echo $row1['subject']; ?></td>
			  
			</td>
            
			 
		
             <td>
					

<?php if($flag == 1)
{?>
<img src="images/icons/fugue/tick-circle.png" style="border:0px" title="Task Completed"/> <?php } else {  ?>
<a href="dashboardsub.php?page=hr_editscheduling&id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;&nbsp;&nbsp;
<a onClick="if(confirm('do you really want to delete this row')) document.location ='hr_deletescheduling.php?id=<?php echo $row1['id']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp; <?php } ?>
</td>
			 
			 </td>
        </tr>
<?php } ?>   
                                   
</tbody>
</table>
</form>
</div>
</section>



