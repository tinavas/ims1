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
			<button type="button" onClick="document.location='dashboardsub.php?page=pp_addqcTop'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<!--<button type="button" class="grey">View</button> -->
			<!-- <button type="button" disabled="disabled">Disabled</button> -->
			<!--<button type="button" class="red">Authorize</button> -->


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Lab Values</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >
<th style="text-align:center"><span class="column-sort" title="Gate Entry">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>GE</th>
<th style="text-align:center"><span class="column-sort" title="Purchase Order">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>PO</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Vendor</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Name</th>
<th style="text-align:center">Actions</th>
</tr>
</thead>
<tbody>
	   <?php
           include "config.php"; 
           $query = "SELECT distinct(ge),po,name,vendor,date FROM tbl_labvalues ORDER BY date DESC";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
              $query2 = "SELECT qcaflag FROM pp_gateentry WHERE ge = '$row1[ge]' AND desc1 = '$row1[name]'";
              $result2 = mysql_query($query2,$conn); 
              while($row2 = mysql_fetch_assoc($result2))
              {
                 $qcaflag = $row2['qcaflag'];
              }
           ?>
            <tr>
		 <td><?php echo $row1['ge']; ?></td>
             <td><?php echo $row1['po'];  ?></td>
             <td><?php echo $row1['vendor']; ?></td>
		 <td><?php echo $row1['name']; ?></td>
             <td>
       <?php if($qcaflag == 0) { ?>
	 <a href="dashboardsub.php?page=pp_authorizeqc&ge=<?php echo $row1['ge']; ?>&name=<?php echo $row1['name']; ?>">
		 <img src="images/icons/fugue/arrow-090.png" style="border:0px" title="Authorize"/></a>
       <?php } else { ?>
		 <img src="images/icons/fugue/lock.png" style="border:0px" title="Authorized"/>
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



