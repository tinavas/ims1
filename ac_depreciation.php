<?php include "jquery.php"; ?>
<script type="text/javascript">
		$(document).ready(function()
		{
			$('.sortable').each(function(i)
			{
				var table = $(this),
					oTable = table.dataTable({

						aoColumns: [
						    { sType: 'eu_date',asSorting: [ "desc" ]},
							{ sType: 'eu_date',asSorting: [ "desc" ]},
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
	
		<div class="float-left"></div>
		
		
			<!--<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button>--> 
			
	
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboardsub.php?page=ac_adddepreciation'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Depreciation</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>From Date</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>To Date</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Code</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Description</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Expense</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Type</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Amount</th>
<th style="text-align:center">Actions</th>
</tr>
</thead>
<tbody>
	  <?php
         include "config.php"; 
		$query = "SELECT * FROM ac_depreciation WHERE client = '$client' ORDER BY fromdate DESC";
		$result = mysql_query($query,$conn) or die(mysql_error());
		while($rows = mysql_fetch_assoc($result))
		{
      ?>
            <tr>
              <td><?php echo date("d.m.Y",strtotime($rows['fromdate'])); ?></td>
			  <td><?php echo date("d.m.Y",strtotime($rows['todate'])); ?></td>
              <td><?php echo $rows['code']; ?></td>
              <td><?php echo $rows['description']; ?></td>
			  <td><?php echo $rows['edescription']; ?></td>
			  <td><?php echo $rows['type']; ?></td>
              <td style="text-align:right"><?php echo $rows['amount']; ?></td>
             <td>
<?php if($rows['flag'] == 0) { ?>			 
<a href="dashboardsub.php?page=ac_editdepreciation&id=<?php echo $rows['id']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
&nbsp;&nbsp;&nbsp;<a onclick="if(confirm('Are you sure,want to delete')) document.location ='ac_deletedepreciation.php?id=<?php echo $rows['id']; ?>&delete=1'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
<?php } else { ?>
<img src="images/icons/fugue/lock.png" style="border:0px;" title="The Depreciation Amount has been used" />
<?php } ?>
 </td>
           </tr>
<?php } ?>
</tbody>
</table>
</form>
</div>
</section>


<br />
