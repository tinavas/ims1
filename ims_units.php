<?php include "config.php"; ?>

<?php include "jquery.php" ?>

<?php $category = $_GET['cat']; ?>

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

	

		

		

		<div class="float-right">
 
<button type="button" onClick="document.location='dashboardsub.php?page=ims_addunits'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>

		</div>

			

	</div></div>



<section class="grid_12">

<div class="block-border">

<form class="block-content form" id="table_form" method="post" action="">

<h1>Conversion Units</h1>



<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">

<thead>

<tr>

<th style="text-align:left"><span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span>From Units</th>

<th style="text-align:left"><span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span>To Units</th>

<th style="text-align:left"><span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span>Conversion Units</th>


									

<th style="text-align:left">Actions</th>

<!--<th style="text-align:left">Vendor</th>-->

</tr>

</thead>

<tbody>
<?php
include "config.php"; 
$query = "SELECT * FROM ims_convunits ";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
  {
?>
 <tr>
	<td><?php echo $row1['fromunits']; ?></td>
	<td><?php echo $row1['tounits']; ?></td>
    <td><?php echo $row1['conunits']; ?> </td>
    <td>
	<a href="dashboardsub.php?page=ims_editunits&id=<?php echo $row1['id']; ?>&fromunits=<?php echo $row1['fromunits'];?>&tounits=<?php echo $row1["tounits"]; ?>&conunits=<?php echo $row1['conunits'];?>"><img src="images/icons/fugue/pencil.png" height="16px" width="16px"  style="border:0px" title="Edit"/></a>&nbsp;&nbsp;
	<a onclick="if(confirm('Are you sure,want to delete')) document.location ='ims_deleteunits.php?id=<?php echo $row1['id']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" height="16px" width="16px" title="Delete" /></a>
	</td>
 </tr>
<?php } ?>  
</tbody>
</table>
</form>
</div>
</section>


