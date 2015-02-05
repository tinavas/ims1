<?php include "jquery.php"; ?>
<script type="text/javascript">
		$(document).ready(function()
		{
			$('.sortable').each(function(i)
			{
				var table = $(this),
					oTable = table.dataTable({

						aoColumns: [

							{  }
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
			<button type="button" onClick="document.location='dashboardsub.php?page=pp_addvendorgroup'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			


		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Vendor Group Mapping</h1>
			
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Code</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Group</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Controll A/C</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Prepayment A/C</th>
<th style="text-align:left"><span class="column-sort">
									
</span>Actions</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php"; 
           $query = "SELECT * FROM ac_vgrmap where flag = 'V' ORDER BY vgroup  ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
              
           ?>
            <tr>
             <td><?php echo $row1['vgroup']; ?></td>
             <td><?php echo $row1['vdesc']; ?></td>
             <td><?php echo $row1['vca']; ?></td>
             <td><?php echo $row1['vppac']; ?></td>                                                                                                                                                                             
             <td>
			 
			  <?php 
			 $vgroup = $row1['vgroup'];
			 $query1 = "select vgroup from contactdetails where vgroup = '$vgroup'";
			 $result1 = mysql_query($query1,$conn) or die(mysql_error());
			 if(mysql_num_rows($result1)>0)
			 {
			 ?>
			 <img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Locked" />
			 <?php } else { ?>
			 
			 &nbsp;&nbsp;&nbsp;<a onclick="if(confirm('Are you sure,want to delete')) document.location ='pp_deletevendorgroup.php?id=<?php echo $row1['vgroup']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>
			 <?php } ?>
			 
			 </td> 
             <?php 
           }
           ?>   
                                   
</tbody>

</table>
</form>
</div></section><br />
<center>


&nbsp;&nbsp; 
      </center>




