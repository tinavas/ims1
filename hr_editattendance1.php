<?php 
include "jquery.php";
include "config.php";	
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
			<button type="button" onClick="document.location='dashboardsub.php?page=hr_addattendance'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			

		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Attendance</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Employee Name</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Sector</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Reporting To</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php
$date=$_GET['id'];


 $query="select * from hr_attendance where date='$date'";
$result=mysql_query($query,$conn);
while($row=mysql_fetch_array($result))
{
$eid=$row['eid'];
$sector=$row['place'];
$reportingto=$row['reportingto'];

 $query1="select name from hr_employee where sector='$sector' and employeeid='$eid'";
$result1=mysql_query($query1,$conn);
$row1=mysql_fetch_array($result1);
$ename=$row1['name'];
?>
<tr>
<td><?php echo $ename;?></td>
<td><?php echo $sector;?></td>
<td><?php echo $reportingto;?></td>
<td><a href="dashboardsub.php?page=hr_editattendance&sector=<?php echo $sector; ?>&reportingto=<?php echo $reportingto;?>&name=<?php echo $ename;?>&id=<?php echo $date;?>">
			<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
			&nbsp;
			<a href="hr_deleteattendance.php?&sector=<?php echo $sector; ?>&reportingto=<?php echo $reportingto;?>&name=<?php echo $ename;?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;</td>
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



