<?php include "jquery.php"; ?>
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
<!--			<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button> 
			<button type="button" onClick="openModal()">Open report</button>-->
		</div>
		
		<div class="float-right"> 
			<button type="button" onclick="document.location='dashboardsub.php?page=common_addbagcapacity';"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<!--<button type="button" class="grey">View</button> -->
			<!-- <button type="button" disabled="disabled">Disabled</button> -->
			<!--<button type="button" class="red">Authorize</button> -->


		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Bag Capacity Standards</h1>
			
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
				
					<thead>
						<tr>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								From Date
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								To Date
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Bag Code
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Bag Weight
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Bag Capacity
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Units
							</th>
                                          <th>Actions</th>
						</tr>
					</thead>
					
					<tbody>
						

<?php 
     include "config.php"; 
     $query1 = "SELECT * FROM bagcapacity order by fromdate"; 
     $result1 = mysql_query($query1,$conn); 
     while($row1 = mysql_fetch_assoc($result1)) 
     { 
 ?>
         <tr>
            <td><?php echo date("d.m.Y",strtotime($row1['fromdate'])); ?></td>
            <td><?php echo date("d.m.Y",strtotime($row1['todate'])); ?></td>
            <td title="<?php echo $row1['bagdescription']; ?>"><?php echo $row1['bagcode']; ?></td>
            <td><?php echo $row1['weight']; ?></td>
            <td><?php echo $row1['capacity']; ?></td>
            <td><?php echo $row1['units']; ?></td>
            <td><a href="dashboardsub.php?page=common_deletebagcapacity&id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a></td>
         </tr>
<?php }  ?> 

						
					</tbody>
				
				</table>
					
			</form></div>
		</section>
		
		
		<div class="clear"></div>
		
	</article>

