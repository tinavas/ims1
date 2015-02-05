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
			<button type="button" onClick="document.location='dashboardsub.php?page=hr_addemployee'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			
		</div>
	</div></div>

<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Employees List</h1>
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
								</span>Designation</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Salary</th> 								
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Personal Contact</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Company Contact</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Image</th> 
<th>Actions</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php"; 
           $query = "SELECT * FROM hr_employee ORDER BY name ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
              
           ?>
            <tr>
             <td><?php echo $row1['name']; ?></td>
             <td><?php echo $row1['designation']; ?></td>
			 <td><?php echo $row1['salary']; ?></td>
             <td><?php echo $row1['personalcontact']; ?></td>
             <td><?php echo $row1['companycontact']; ?></td>
               <?php if($row1['image'] == "") { ?> 
			<?php /*?> <td><a href="employeeimages/reduced/noimage.jpg">
			 <img src="employeeimages/thumbnails/noimage.jpg" width="50px" height="50px" border="0px" /></a>
			</td><?php */?>
			 <td><a href="employeeimages/reduced/noimage.jpg">
			 <img src="employeeimages/thumbnails/noimage.jpg" width="50px" height="50px" border="0px" /></a>
			</td>
               <?php } else { ?>
			 <?php /*?><td><a href="employeeimages/reduced/<?php echo $row1['image']; ?>">
			 <img src="employeeimages/thumbnails/<?php echo $row1['image']; ?>" width="50px" height="50px" border="0px" /></a>
			</td><?php */?>
			<td><a href="employeeimages/<?php echo $row1['image']; ?>">
			 <img src="employeeimages/<?php echo $row1['image']; ?>" width="50px" height="50px" border="0px" /></a>
			</td>
               <?php } ?>
           	<td>
			<a href="dashboardsub.php?page=hr_editemployee&id=<?php echo $row1['employeeid']; ?>">
			<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
			<a onclick="if(confirm('Are you sure?')) document.location='dashboardsub.php?page=hr_deleteemployee&id=<?php echo $row1['employeeid']; ?>';">
			<img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>
			<a href="hr_printemp.php?id=<?php echo $row1['employeeid']; ?>" target="_new">
			<img src="images/icons/fugue/report.png" style="border:0px" title="Print" /></a>
			<a href="dashboardsub.php?page=hr_leaves&id=<?php echo $row1['employeeid']; ?>">
			<img src="images/icons/fugue/home.png" style="border:0px" title="Leave" /></a>
			<a href="dashboardsub.php?page=hr_editemployeeimage&id=<?php echo $row1['employeeid']; ?>">
			<img src="images/icons/fugue/image.png" style="border:0px" title="Edit Image" />
			</a>
			
			<a href="dashboardsub.php?page=<?php if($row1['releaved'] == '0') echo "hr_relieving"; else echo "hr_rejoining";?>&id=<?php echo $row1['employeeid']; ?>">
			<img src="images/icons/fugue/<?php if($row1['releaved'] == '0') echo "control-power"; else echo "control";?>.png" style="border:0px" title="<?php if($row1['releaved'] == '0') echo "Relieve"; else echo "Rejoin";?>" />
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



