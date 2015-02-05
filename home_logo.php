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
			<!--<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button> 
			<button type="button" onClick="openModal()">Open report</button>-->
		</div>
		
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboardsub.php?page=home_addlogo'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Logo</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Address</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Logo</th> 
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php $query = "SELECT * FROM home_logo "; $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result)) { ?>
            <tr>
             <td><?php echo html_entity_decode($row1['address']); ?></td>
            
			  <?php if($row1['image'] == "") { ?> 
			 <td><a href="employeeimages/reduced/noimage.jpg">
			 <img src="employeeimages/thumbnails/noimage.jpg" width="50px" height="50px" border="0px" /></a>
			</td>
               <?php } else { ?>
			 <td><a href="logo/thumbnails/<?php echo $row1['image']; ?>">
			 <img src="logo/thumbnails/<?php echo $row1['image']; ?>" width="50px" height="50px" border="0px" /></a>
			</td>
               <?php } ?>
			 
		
             <td>
					
<a href="dashboardsub.php?page=home_editlogo&id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;&nbsp;&nbsp;
<a onclick="if(confirm('do you really want to delete this row')) document.location ='home_deletelogo.php?id=<?php echo $row1['id']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;</td>
			 
			 </td>
        </tr>
<?php } ?>   
                                   
</tbody>
</table>
</form>
</div>
</section>



