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
			<button type="button" onClick="document.location='dashboardsub.php?page=hr_addmnth_attendance'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			
		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Monthly Attendance</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Employee</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Sector</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Designation</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Mon/Year</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Days Present</th> 
<th>Actions</th>
</tr>
</thead>
<tbody>
		
	  <?php
	  $montharr = array("January","February","March","April","May","June","July","August","September","October","November","December");
           include "config.php"; 
           $query = "SELECT * FROM hr_mnth_attendance ORDER BY  employeename ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		   	  $user=$row1['empname'];
		   $c=0;
              $mnt = $row1['month'];
			  $m = $montharr[$mnt-1];
			  $eid=$row1['eid'];
			  $year=$row1['year'];
           ?>
            <tr>
			<td><?php echo $row1['employeename'];  ?></td>
             <td><?php echo $row1['sector']; ?></td>
			 <td><?php echo $row1['designation']; ?></td>
             <td><?php echo $row1['month']."/".$row1['year']; ?></td>
             <td><?php echo $row1['dayspresent']; ?></td>
			 
			 
			 <?php 
			 
			 $query1="select eid,month1,year1 from hr_salary_generation";
			 
			 $result1=mysql_query($query1,$conn);
			 while($row2=mysql_fetch_array($result1))
			 {
			 
			 	if($eid==$row2['eid'] && $mnt=$row2['month1'] && $year==$row2['year1'])
				$c=1;
			 
			 }
			 ?>
			 
			 
			 <td>
			 <?php 
			 if($c==0)
			 {?>
			 
			 <?php if($_SESSION['valid_user']==$user || ($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") ){?> 
			<a href="dashboardsub.php?page=hr_editmnth_attendance&id=<?php echo $row1['id']; ?>&mon=<?php echo $mnt;?>&year=<?php echo $row1['year'];?>">
			<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;
			
			<a href="hr_deletemnth_attendance.php?id=<?php echo $row1['id']; ?>&mon=<?php echo $mnt;?>&year=<?php echo $row1['year'];?>">
			<img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;&nbsp;
			
			<?php  } else { ?>

<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Locked" />
<?php  }?>

			<?php } else {?>
			
			
			
			<img src="images/icons/fugue/lock.png" style="border:0px; width:20px; height:20px;" title="Cannot be edited/deleted" />&nbsp;
			
			<?php }?>
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



