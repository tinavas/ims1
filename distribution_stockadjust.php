<?php include "jquery.php"; ?>
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
			<button type="button" onClick="document.location='dashboardsub.php?page=distribution_addstockadjust';"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			

		</div>
			
	</div></div>
	


		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Stock Adjustment</h1>
			
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
				
					<thead>
						<tr>
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
								Item Description
							</th>
							<th scope="col" width="70px">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
							Item code
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Quantity
							</th>
							
							 <th>Actions</th>
						</tr>
					</thead>
					
					<tbody>
						

<?php 

include "distribution_getsuperstockist_singh.php";

	 
$query="select distinct(trnum) from distribution_stockadjustment where superstockist in ($authorizedsuperstockistlist) order by date desc";
	 
	 $result=mysql_query($query,$conn) or die(mysql_error());
	 while($trnum=mysql_fetch_assoc($result))
	 {
	  $description="";
	  $coacode="";
	  $quantity="";
	  $cnt=0;
     $query1 = "SELECT * from distribution_stockadjustment where trnum = '$trnum[trnum]' order by id"; 
     $result1 = mysql_query($query1,$conn); 
     while($row1 = mysql_fetch_assoc($result1)) 
     {
	 	$user=$row1['empname'];
	 $date=$row1['date'];
	 $trnum=$row1['trnum'];
	 $cnt++; 
	  $description.= $row1['description']." / ";
  	  $coacode .= $row1['code'] . " / ";
  	  $quantity.= $row1['quantity']." / ";
	 } 
	 $description=substr($description,0,-3);
	 $coacode=substr($coacode,0,-3);
	 $quantity=substr($quantity,0,-3);
?>
         <tr>
            <td><?php echo date("d.m.Y",strtotime($date)); ?></td>
            <td><?php echo $description; ?></td>
            <td><?php echo $coacode; ?></td>
            <td ><?php echo $quantity; ?></td>
			<td>
			
			
			
<a href="dashboardsub.php?page=distribution_editstockadjust&id=<?php echo $trnum; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" /></a>
<a href="dashboardsub.php?page=distribution_deletestockadjust&id=<?php echo $trnum; ?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>



			 </td>
         </tr>
<?php  } ?> 

						
					</tbody>
				
				</table>
					
			</form></div>
		</section>
		
		
		<div class="clear"></div>
		
	</article>

