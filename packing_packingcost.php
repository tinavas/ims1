<?php 
    
     include "jquery.php";
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
			<button type="button" onClick="document.location='dashboardsub.php?page=packing_addpackingcost'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16">Add</button> 
			
			
			


		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Packing Cost Details</h1>
			
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>From Date</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>To Date</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Warehouse</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Code(Description)</th>
                                <th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Cost</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
	 
	<?php
	
	if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
	 
	 if($sectorlist=="")   
				
				$q1="SELECT * FROM `packing_packingcost` order by code";
				
				else
				
				$q1="SELECT * FROM `packing_packingcost` where location in ($sectorlist) order by code";
           

$q1=mysql_query($query) or die(mysql_error());
	
	
	$q1="SELECT * FROM `packing_packingcost` order by code";
	
	$q1=mysql_query($q1) or die(mysql_error());
	
	while($r1=mysql_fetch_assoc($q1))
	
	{
	?>
    <tr>
    
	<td><?php echo date("d.m.Y",strtotime($r1['fromdate']));?></td>
	
	<td><?php echo date("d.m.Y",strtotime($r1['todate']));?></td>
    
    <td><?php echo $r1['location'];?></td>
    
    <td><?php echo $r1['code']."(".$r1['description'].")";?></td>
    
    <td><?php echo $r1['cost'];?></td>
    
    <?php
	 $q5="select count(*) as count from packing_dailypacking where location='$r1[location]' and code='$r1[code]' and date between '$r1[fromdate]' and '$r1[todate]'";
	
	$q5=mysql_query($q5) or die(mysql_error());
	
	$r5=mysql_fetch_assoc($q5);
	
	if($r5['count']==0)
	{
	?>
    
<td><a href="dashboardsub.php?page=packing_editpackingcost&id=<?php echo $r1['id'];?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;&nbsp;
         <a onclick="if(confirm('Are you sure,want to delete'))document.location='dashboardsub.php?page=packing_deletepackingcost&id=<?php echo $r1['id'];?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px;" title="Delete" /></a></td>
<?php }else
{
?>
<td><img src="images/icons/fugue/lock.png" /></td>

<?php }?>	
    </tr>
	
	  
    <?php }?>  
      
      
                                   
</tbody>

</table>
</form>
</div></section><br />
<center>


&nbsp;&nbsp; 
      </center>

