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
			<button type="button" onClick="document.location='dashboardsub.php?page=ims_addstandardcosts'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Standard Costs</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>From Date</th>
<th style="text-align:center" title="Auto Generated Number(Supplier Order Based Invoice)"><span class="column-sort">
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
								</span>Standard Cost</th>
<th style="text-align:center">Actions</th>
</tr>
</thead>
<tbody>
	  <?php
         include "config.php"; 
		$query = "SELECT * FROM ims_standardcosts WHERE client = '$client' ORDER BY code";
		$result = mysql_query($query,$conn) or die(mysql_error());
		while($rows = mysql_fetch_assoc($result))
		{
      ?>
            <tr>
			
              <td><?php echo date("d.m.Y",strtotime($rows['fromdate'])); ?></td>
			  <td><?php echo date("d.m.Y",strtotime($rows['todate'])); ?></td>
              <td><?php echo $rows['code']; ?></td>
			  <td><?php echo $rows['description']; ?></td>
              <td style="text-align:right"><?php echo $rows['stdcost']; ?></td>
             <td>			 
<a href="dashboardsub.php?page=ims_editstandardcosts&id=<?php echo $rows['id']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>


<?php

  $q="select iac from ims_itemcodes where code='$rows[code]'";
   $r=mysql_query($q,$conn);
   $r1=mysql_fetch_array($r);
   $coacode=$r1['iac'];

$maxdate="";
   $q1="select max(date) as maxdate from ac_financialpostings where itemcode='$rows[code]' and coacode='$coacode'";
   $r1=mysql_query($q1,$conn);
   $r2=mysql_fetch_array($r1);
 $maxdate=$r2['maxdate'];
   
   if(($maxdate<=$rows['todate'] && $maxdate>=$rows['fromdate'])&&($maxdate!=""))
   {?>
   <img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Pack Slip Completed" />
   <?php
   }
   else
   {
   ?>

&nbsp;&nbsp;&nbsp;<a onclick="if(confirm('Are you sure,want to delete')) document.location ='ims_deletestandardcosts.php?id=<?php echo $rows['id']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /> </a>&nbsp;
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
