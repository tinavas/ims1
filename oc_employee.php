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
			<!--<button type="button" onClick="document.location='dashboardsub.php?page=tally_contacts'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Import</button> -->
			<button type="button" onClick="document.location='dashboardsub.php?page=oc_addemployee'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			
			


		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Marketing Employee</h1>
			
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
           include "config.php"; 
		    
		   
           $query = "SELECT * FROM oc_employee  ORDER BY name  ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {	
		   	 $name = $row1['name'];
			  $cnt = 0;
		   $query1 = "SELECT count(*) as c1 FROM oc_cobi where marketingemp = '$name' ";
           $result1 = mysql_query($query1,$conn); 
           while($row1a = mysql_fetch_assoc($result1))
           {	
		   $cnt = $cnt + $row1a['c1'];
		   }
			  
           ?>
            <tr>
             <td><?php echo $row1['name']; ?></td>
             <td><?php echo $row1['place']; ?></td>
             <td><?php echo $row1['phone']; ?></td>
             <td><?php echo $row1['mobile']; ?></td>
             <td><a href="dashboardsub.php?page=oc_editemployee&id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
			 &nbsp;
			 <?php if($cnt > 0) {?>
			 <img src="images/icons/fugue/lock.png" style="border:0px;" title="Cannot Delete" />
			 <?php } else {?>
			 <a href="oc_deleteemployee.php?id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px;" title="Delete" /></a>
			 <?php } ?>
			 </td> 
            </tr>
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

