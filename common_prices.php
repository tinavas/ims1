<?php include "jquery.php"; ?>

	<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	
		<div class="float-left">
			<!--<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button> 
			<button type="button" onClick="openModal()">Open report</button>-->
		</div>
		
		<div class="float-right"> 
			<button type="button" onclick="document.location='dashboardsub.php?page=common_addprices';"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<button type="button" class="grey">View</button> 
			<!-- <button type="button" disabled="disabled">Disabled</button> -->
			<button type="button" class="red">Authorize</button> 


		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Hatch Egg / Bird Prices</h1>
			
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
				
					<thead>
						<tr>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Type
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Location
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Date
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Price
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Unit
							</th>
                                          <th>Actions</th>
						</tr>
					</thead>
					
					<tbody>
						

<?php 
     include "config.php"; 
     $date = date("Y-m-d");
     $query1 = "SELECT * FROM common_rates where date = '$date'"; 
     $result1 = mysql_query($query1,$conn); 
     while($row1 = mysql_fetch_assoc($result1)) 
     { 
 ?>
         <tr>
            <td><?php echo $row1['type']; ?></td>
            <td><?php echo $row1['location']; ?></td>
            <td><?php echo $row1['date']; ?></td>
            <td><?php echo $row1['rate']; ?></td>
            <td><?php echo $row1['unit']; ?></td>
            <td><a href="dashboardsub.php?page=breeder_deletemaster&id=<?php echo $row1['id']; ?>&col=<?php echo "id"; ?>&name=<?php echo "common_rates"; ?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a></td>
         </tr>
<?php }  ?> 

						
					</tbody>
				
				</table>
					
			</form></div>
		</section>
		
		
		<div class="clear"></div>
		
	</article>

