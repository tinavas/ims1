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
			<button type="button" onClick="document.location='dashboardsub.php?page=chicken_addlivebirdstransfer'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			 


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Chicken Live Birds Transfer</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >

<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>From Warehouse</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>To Warehouse</th>	
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Code</th>	


<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Quantity</th>	
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Mortality</th>									
<th style="text-align:center">Actions</th>
</tr>
</thead>
<tbody>
	  <?php 
     include "config.php";
		   
          $query = "SELECT * FROM ims_stocktransfer where cat LIKE '%Birds%' and (fromwarehouse in (select sector from tbl_sector where type1='Chicken Center' or type1='Processing Center') or towarehouse in (select sector from tbl_sector where type1='Chicken Center' or type1='Processing Center')) and client = '$client' order by id ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {  
		  
           ?>
            <tr>
			<td><?php echo date("d.m.Y",strtotime($row1['date'])); ?></td>
			<td><?php echo $row1['fromwarehouse'];?> </td>
			<td><?php echo $row1['towarehouse'];?> </td>
			 <td><?php echo $row1['code']; ?></td>
			
			 
			 <td><?php echo $row1['quantity']; ?></td>
			 <td><?php echo $row1['tmort']; ?></td>

			 
              <td>

<a href="dashboardsub.php?page=chicken_editlivebirdstransfer&id=<?php echo $row1['id']; ?>&tid=<?php echo $row1['tid'];?>&date=<?php echo $row1['date']; ?>&flock=<?php echo $row1['aflock']; ?>&type=<?php echo "TR"; ?>">
<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" />
</a>&nbsp;

			<a href="<?php echo 'chicken_deletelivebirdstransfer.php?id='.$row1['id']; ?>">
			 			 
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
document.location = "dashboardsub.php?page=chicken_dailyrates&month=" + month + "&year=" + year;
}
</script>





