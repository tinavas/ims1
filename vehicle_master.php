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

							{ sType: 'eu_date',asSorting: [ "desc" ] },
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
			<button type="button" onClick="document.location='dashboardsub.php?page=vehicle_addmasters'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			 


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Vehicle Masters</h1>

<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >

<th style="text-align:center" title="Auto Generated Number(Supplier Order Based Invoice)"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>VehicleType</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Vehicle Number</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>RCNumber</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Insurance Number</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Insurance Expiry Date</th>
								
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>image</th>
																

<th style="text-align:center">Actions</th>
</tr>
</thead>
<tbody>
	 <?php
           include "config.php";
		   
           $query = "SELECT * FROM vehicle_master ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {  
           ?>
            <tr>
			
			 
			 <td><?php echo $row1['vtype']; ?></td>
			 <td><?php echo $row1['vnumber']; ?></td>
			 <td><?php echo $row1['rcnumber']; ?></td>
			 <td><?php echo $row1['insurancenumber']; ?></td>
			 <td><?php echo date("d.m.Y",strtotime($row1['iexpirydate'])); ?></td>
			  <?php if($row1['image'] == "") { ?> 
			 <td><a href="employeeimages/reduced/noimage.jpg">
			 <img src="employeeimages/thumbnails/noimage.jpg" width="50px" height="50px" border="0px" /></a>
			</td>
               <?php } else { ?>
			 <td><a href="vehicleimages/<?php echo $row1['image']; ?>">
			 <img src="vehicleimages/<?php echo $row1['image']; ?>" width="50px" height="50px" border="0px" /></a>
			</td>
               <?php } ?>
			 
			 

			 
              <td>

<a href="dashboardsub.php?page=vehicle_editmaster&id=<?php echo $row1['id']; ?>">
<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" />
</a>&nbsp;

			<a href="<?php echo 'vehicle_deletemaster.php?id='.$row1['id']; ?>">
			 			 
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
document.location = "dashboardsub.php?page=om_taxationmasters&month=" + month + "&year=" + year;
}
</script>




