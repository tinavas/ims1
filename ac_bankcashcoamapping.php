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
	
		
		
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboardsub.php?page=ac_addbankcashcoamappingTop'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			

		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Bank/Cash to CoA Mapping</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Bank/Cash Code</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Bank/CashBook Name</th> 
<th style="text-align:left" title="Chart Of Account Code"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>CoA Code</th>
<th style="text-align:left">A/c #</th><th>Actions</th>
</tr>
</thead>
<tbody>
<?php
           include "config.php"; 
	   if($_SESSION['db'] == "feedatives")
		{
		   if($_SESSION['sectorr'] == "all")
		   {
		   	$query = "SELECT * FROM ac_bankmasters ORDER BY code ASC ";
		   }
		   else
		   {
		   $sectorr = $_SESSION['sectorr'];
		 $query = "SELECT * FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector = '$sectorr' ORDER BY code ASC)";
		   }
		 }
	   else
	   {
	   $query = "SELECT * FROM ac_bankmasters ORDER BY code ASC ";
	   }
 $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result)) { ?>
            <tr>
             <td><?php echo $row1['code']; ?></td>
             <td><?php echo $row1['name']; ?></td>
             <td><?php echo $row1['coacode']; ?></td>
             <td><?php echo $row1['acno']; ?></td>
             <td><!--<a href="editbankmasters.php?id=<?php echo $row1['id']; ?>"><img src="sticky.png" style="border:0px" title="Edit"/></a>&nbsp;-->
<?php if(($row1['flag'] == '1') OR ($row1['tflag'] == '1')) { ?>
        <img src="images/icons/fugue/lock.png" style="border:0px" title="Cannot Delete" /></a>&nbsp;
<?php } else { ?>
         <a onclick="if(confirm('Are you sure,want to delete')) document.location ='ac_deletebankcashcoamapping.php?id=<?php echo $row1['id']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
<?php } ?>
             </td>
         </tr>
<?php } ?>   
                                   
</tbody>
</table>
</form>
</div>
</section>