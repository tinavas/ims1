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
	
		<div class="float-left">
			<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button> 
			<button type="button" onClick="openModal()">Open report</button>
		</div>
		
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboard.php?page=ac_addpvoucher'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<button type="button" class="grey">Reverted Vouchers</button> 
			<!-- <button type="button" disabled="disabled">Disabled</button> -->
			


		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Payment Voucher</h1>
			
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Tr No.</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Cash/Bank</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>COA Code</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Amount</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php"; 
           $query = "SELECT * FROM ac_gl where voucher = 'P' and vstatus <> 'R' group by transactioncode ORDER BY date DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
              
           ?>
            <tr>
             <td><?php echo date("d.m.Y",strtotime($row1['date'])); ?></td>
             <td><?php echo $row1['transactioncode']; ?></td>
             <td><?php echo $row1['bccodeno']; ?></td>
             <td><?php echo $row1['code']; ?></td>
             <td><?php echo $row1['crtotal']; ?></td>
          <?php if(($row1['status'] == 'U') AND ($row1['vstatus'] == 'U')) { ?>
            <td>
			<a href="dashboard.php?page=ac_editpvoucher&id=<?php echo $row1['transactioncode']; ?>">
			<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;
			
			<a href="dashboard.php?page=ac_deletepvoucher&id=<?php echo $row1['transactioncode']; ?>">
			<img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;&nbsp;
			
			<a href="dashboard.php?page=ac_authorizepvoucher&id=<?php echo $row1['transactioncode']; ?>&type=P">
			<img src="images/icons/fugue/arrow-090.png" style="border:0px;width:20px;height:20px" title="Authorise" /></a>&nbsp;
			</td> 
			
          <?php } else if ($row1['status'] == 'R')  { ?>
		  
           	<td>
			<img src="images/icons/fugue/lock.png" style="border:0px; width:20px; height:20px;" title="Reconsiled Cannot Reverse" /></a>&nbsp;
			</td>
          <?php } else { ?>
		  
		   <td>
		   <a href="dashboard.php?page=reversepvoucher&id=<?php echo $row1['transactioncode']; ?>&type=P">
		   <img src="images/icons/fugue/arrow-curve-000-left.png" style="border:0px; width:20px; height:20px;" title="Reverse" /></a>&nbsp;
		   </td>
		  <?php } ?>
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

