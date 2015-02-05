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
			<button type="button" onClick="document.location='dashboardsub.php?page=vehicle_addtype'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			 


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Vehicle Types</h1>

<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >

<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Vehicle Type</th>
<th style="text-align:center">Actions</th>
</tr>
</thead>
<tbody>
	 <?php
           include "config.php";
		   
           $query = "SELECT * FROM vehicle_type ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {  
           ?>
            <tr>
			
			 <td><?php echo $row1['vtype']; ?></td>
			 

			 
              <td>

<a href="dashboardsub.php?page=vehicle_edittype&id=<?php echo $row1['id']; ?>">
<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" />
</a>&nbsp;
<?php

$query1 = "SELECT * FROM vehicle_master where vtype = '$row1[vtype]' ";
 $result1 = mysql_query($query1,$conn); 
$flag = mysql_num_rows($result1);
 if($flag == 0)
 {
 $query1 = "SELECT * FROM vehicle_spareparts where vehicletype LIKE '%$row1[vtype]%' ";
 $result1 = mysql_query($query1,$conn); 
 $flag = mysql_num_rows($result1);
 }

 if($flag == 0)
 {
 $query1 = "SELECT * FROM vehicle_servicemaster where vehicletype LIKE '%$row1[vtype]%' ";
 $result1 = mysql_query($query1,$conn); 
 $flag = mysql_num_rows($result1);
 }
  if($flag == 0)
 {
 $query1 = "SELECT * FROM vehicle_chargemaster where vehicletype LIKE '%$row1[vtype]%' ";
 $result1 = mysql_query($query1,$conn); 
 $flag = mysql_num_rows($result1);
 }
if($flag == 0)
{
?>

			<a href="<?php echo 'vehicle_deletetype.php?id='.$row1['id']; ?>">
			 			 
			 <img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" />
			 </a>&nbsp;
			 
			 <?php } else { ?>
<img src="images/icons/fugue/lock.png" style="border:0px" title="Cannot be deleted"/>
<?php } ?>


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
document.location = "dashboardsub.php?page=om_categorymasters&month=" + month + "&year=" + year;
}
</script>





