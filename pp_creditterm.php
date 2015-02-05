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
	
		<div class="float-left"></div>
		
		
			<!--<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button>--> 
			
	
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboardsub.php?page=pp_addcreditterm'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Credit Term</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Code</th>
<th style="text-align:center" title="Auto Generated Number(Supplier Order Based Invoice)"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Description</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Value</th>
<th style="text-align:center">Actions</th>
</tr>
</thead>
<tbody>
	  <?php
         include "config.php"; 
		$query = "SELECT * FROM ims_creditterm WHERE client = '$client' ORDER BY code";
		$result = mysql_query($query,$conn) or die(mysql_error());
		while($rows = mysql_fetch_assoc($result))
		{
      ?>
            <tr>
			
              <td><?php echo $rows['code']; ?></td>
              <td><?php echo $rows['description']; ?></td>
              <td><?php echo $rows['value']; ?></td>
             <td>			 
<a href="dashboardsub.php?page=pp_addcreditterm&id=<?php echo $rows['id']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
&nbsp;&nbsp;&nbsp;<a onclick="if(confirm('Are you sure,want to delete')) document.location ='pp_savecreditterm.php?id=<?php echo $rows['id']; ?>&delete=1'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
 </td>
           </tr>
<?php } ?>
</tbody>
</table>
</form>
</div>
</section>


<br />
