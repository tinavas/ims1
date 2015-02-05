<?php include "jquery.php" ?>
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
			<button type="button" onClick="document.location='dashboardsub.php?page=ac_addbankcashmastersTop'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			

		</div>
			
	</div></div>

<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Bank/Cash Masters</h1>
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
<th style="text-align:left">Coacode</th>
<th style="text-align:left">A/c.No</th>
<th style="text-align:left">Sector</th>
<th style="text-align:left">Address</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php"; 
	 
	   $query = "SELECT * FROM ac_bankcashcodes ORDER BY code ASC ";
	  
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
             $code=$row1['code'];
			 $flag=0;
			
			  $q="select * from `ac_bankmasters`  where code='$code'";
				$r=mysql_query($q,$conn);
				while($row=mysql_fetch_array($r))
				{
				$coa=$row['coacode'];
				$acno=$row['acno'];
				}

			 $q="select distinct(coacode) as coacode from `ac_financialpostings`  ";
				$r=mysql_query($q,$conn);
				while($row=mysql_fetch_array($r))
				{
				if($coa==$row['coacode'])
				$flag=1;
				}


			  
           ?>
            <tr>
             <td><?php echo $row1['code']; ?></td>
             <td><?php echo $row1['name']; ?></td>
             <td><?php echo $coa; ?></td>
			 <td><?php echo $acno; ?></td>
			 <td><?php echo $row1['sector']; ?></td>
             <td><?php echo $row1['address']; ?></td>
             <td>
               <a href="dashboardsub.php?page=ac_editbankcashmasters&id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;
<?php if($flag == "1") { ?>
            <img src="images/icons/fugue/lock.png" style="border:0px" title="Cannot Delete" /></a>&nbsp; 
<?php } else { ?>
          	<a onclick="if(confirm('Are you sure,want to delete')) document.location ='ac_deletebankcashmasters.php?id=<?php echo $row1['id']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
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