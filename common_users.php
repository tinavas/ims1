<?php include "jquery.php"; ?>
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
	
		<div class="float-left">
			<!--<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button> -->
			<?php if($userlogged=="test" or $userlogged =="test"){?>
			<form method="post" action="dashboardsub.php?page=mailusers">
			<button type="submit">Passwords</button>
			</form>
			<?php } ?>
		</div>
		<div class="float-left">
			<button type="button" target="_new" 
			onClick="window.open('production/usernamereport.php');">Open report</button>
		</div>
		<div class="float-right"> 
			<button type="button" 
			onclick="document.location='dashboardsub.php?page=common_createuser';">
			<img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add
			</button>	
		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Users</h1>
			
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
				
					<thead>
						<tr>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Employee
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								User
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Email
							</th>
		
                                          <th>Actions</th>
						</tr>
					</thead>
					
					<tbody>
						

<?php 
     include "config.php"; 
     $query1 = "SELECT * FROM common_useraccess"; 
     $result1 = mysql_query($query1,$conn); 
     while($row1 = mysql_fetch_assoc($result1)) 
     { 
?>
         <tr>
            <td><?php echo $row1['employeename']; ?></td>
            <td><?php echo $row1['username']; ?></td>
            <td><?php echo $row1['email']; ?></td>
          
            
            <?php if($_SESSION[admin]==1)
			{?>
			<td>
              <a href="dashboardsub.php?page=common_edituser&id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
			
              &nbsp;&nbsp;
			  
              <!--<a onclick="if(confirm('Are you sure,want to delete')) document.location ='common_deleteusers.php?id=<?php echo $row1['username']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>-->
             <img src="images/icons/fugue/lock.png" /> 
              </td>
			 <?php }  else
			  {?>
               <td><img src="images/icons/fugue/lock.png" /></td>
              <?php 
			  }?> 
            
         </tr>
<?php }  ?> 

						
					</tbody>
				
				</table>
					
			</form></div>
		</section>
		
		
		<div class="clear"></div>
		
	</article>

