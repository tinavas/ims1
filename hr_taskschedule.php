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
			<!--<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button>--> 
			<button type="button" target="_new" onClick="window.open('production/taskassignedsmry.php');">Open report</button>
		</div>
		
		<div class="float-right"> 
			

		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>My Tasks</h1>
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
$query = "SELECT distinct(employeename) FROM common_useraccess where username = '$_SESSION[valid_user]' and client = '$client'"; 
$result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result)) 
	  {
	  $emp = $row1['employeename'];
	  $query2 = "select * from hr_scheduling where employee = '$emp' "; 
	  $result2 = mysql_query($query2,$conn) or die(mysql_error());
	  while($row2 = mysql_fetch_assoc($result2))
	  {
	  $sdate = date("d.m.Y",strtotime($row2['scheduleddate']));
	  $flag = $row2['flag'];
	  ?>
            <tr>
             <td><?php echo date("d.m.Y",strtotime($row2['scheduleddate'])); ?></td>
            <td><?php echo $row2['employee']; ?></td>
			<td><?php echo $row2['subject']; ?></td>
			  
			</td>
            
			 
		
             <td>
			<?php if($flag == 0)
			{		?>
<a href="dashboardsub.php?page=hr_addtaskschedule&sdate=<?php echo $sdate; ?>&task=<?php echo $row2['task']; ?>&id=<?php echo $row2['id']; ?>&title=<?php echo $row2['subject']; ?>&emp=<?php echo $row2['user']; ?>"><img src="images/icons/fugue/arrow-090.png" style="border:0px" title="Complete Task"/></a> <?php } else { ?>
<img src="images/icons/fugue/tick-circle.png" style="border:0px" title="Task Completed"/> <?php } ?>
			 </td>
        </tr>
<?php } }?>   
                                   
</tbody>
</table>
</form>
</div>
</section>



