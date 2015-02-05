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
			<button type="button" onClick="document.location='dashboardsub.php?page=distribution_adddistributor'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16">Add</button> 
			
			
			


		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Distributor Details</h1>
			
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Name.</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Place</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Phone</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Mobile</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
	  <?php
	  
	 $q1=mysql_query("set group_concat_max_len=10000000000");
	  
	  $q1="select group_concat(distinct distributor separator '*') as codes from distribution_distributorstock";
	  
	  $q1=mysql_query($q1) or die(mysql_error());
	  
	  $r1=mysql_fetch_assoc($q1);
	  
	  $names1=explode("*",$r1['codes']);
	  
	  
	   $q1=mysql_query("set group_concat_max_len=10000000000");
	  
	  $q1="select group_concat(distinct distributor separator '*') as codes from distribution_stockissuetodistributor";
	  
	  $q1=mysql_query($q1) or die(mysql_error());
	  
	  $r1=mysql_fetch_assoc($q1);
	  
	  $names2=explode("*",$r1['codes']);
	  
	  
	     $q1=mysql_query("set group_concat_max_len=10000000000");
	  
	  $q1="select group_concat(distinct distributor separator '*') as codes from distribution_shop";
	  
	  $q1=mysql_query($q1) or die(mysql_error());
	  
	  $r1=mysql_fetch_assoc($q1);
	  
	  $names3=explode("*",$r1['codes']);
	  
	  $nn=array_merge($names1,$names2);
	  
	  $names=array_merge($nn,$names3);
	  
	  $q1="select * from distribution_distributor";
	  
	  $q1=mysql_query($q1) or die(mysql_error());
	  
	  while($r1=mysql_fetch_assoc($q1))
	  
	  {
	  ?>
      <tr>
      <td><?php echo $r1['name'];?></td>
      <td><?php echo $r1['place'];?></td>
      <td><?php echo $r1['phone'];?></td>
      <td><?php echo $r1['mobile'];?></td>
      
      <?php
	  if(!in_array($r1['name'],$names))
	  {
	  ?>
      
      <td>
      <a href="dashboardsub.php?page=distribution_editdistributor&id=<?php echo $r1['id'];?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;&nbsp;
         <a onclick="if(confirm('Are you sure,want to delete'))document.location='dashboardsub.php?page=distribution_deletedistributor&id=<?php echo $r1['id'];?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px;" title="Delete" /></a>
      
      
      </td>
      <?php }else{?>
      
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

