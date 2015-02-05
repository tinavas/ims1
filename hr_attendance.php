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
								</span>Date</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>No. of Presents</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>No. of Absents</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
		
	  <?php
           $query1 = "SELECT count(*) as `tcount` FROM hr_employee ";
           $result1 = mysql_query($query1,$conn); 
           while($row2 = mysql_fetch_assoc($result1))
           {
              $tcount = $row2['tcount'];
           }
 
           $query = "SELECT count(date) as `count`,date FROM hr_attendance where daytype!='Leav' GROUP BY date ORDER BY date DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
                         $query1 = "SELECT count(*) as `tcount` FROM hr_employee where rdate <= '$row1[date]' ";
                         $result1 = mysql_query($query1,$conn); 
                         while($row2 = mysql_fetch_assoc($result1))
                         {
                            $rcount = $row2['tcount'];
                         }
           ?>
            <tr>
             <td>
			 <?php 
			 $nd =  explode("-",$row1['date']); 
			 echo $nd[2] . "." . $nd[1] . "." . $nd[0];
			 ?>
			 </td>
			 
             <td><?php echo $row1['count']; ?></td>
             <td><?php echo $tcount - ($row1['count'] + $rcount); ?></td>
           	<td><a href="dashboardsub.php?page=hr_editattendance1&id=<?php echo $row1['date']; ?>">
			<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
			&nbsp;
			<a href="hr_deleteattendance.php?id=<?php echo $row1['date']; ?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;</td>
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



