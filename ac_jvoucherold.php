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
			<button type="button" onClick="document.location='dashboard.php?page=ac_addjvoucher'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<button type="button" class="grey">View</button> 
			<!-- <button type="button" disabled="disabled">Disabled</button> -->
			


		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Journal Voucher</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Tr No.</th><th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Code Debited</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Code Credited</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Amount</th>
<th style="text-align:left">Action</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php"; 
           $query = "SELECT * FROM ac_gl where voucher = 'J' and vstatus <> 'R' group by transactioncode ORDER BY date DESC";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		    $query = "SELECT * FROM ac_gl where voucher = 'J' and transactioncode = '$row1[transactioncode]' order by id; ";
           $result1 = mysql_query($query,$conn); 
           while($row2 = mysql_fetch_assoc($result1))
           {
		       if($row2['crdr'] == "Cr") 
			   {
			     $codeto = $row2['code'];
			   }
			   else
			   {
			    $codefrom = $row2['code'];
			   }
		      
		   }
              
           ?>
            <tr>
             <td><?php echo $row1['date']; ?></td>
             <td><?php echo $row1['transactioncode']; ?></td>
             <td><?php echo $codefrom; ?></td>
             <td><?php echo $codeto; ?></td>
             <td><?php echo $row1['crtotal']; ?></td>
             <?php if($row1['vstatus'] == 'U') { ?>
            <td><a href="dashboard.php?page=editjvoucher&id=<?php echo $row1['transactioncode']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;<a href="dashboard.php?page=deletejvoucher&id=<?php echo $row1['transactioncode']; ?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;&nbsp;<a href="dashboard.php?page=ac_authorizejvoucher&id=<?php echo $row1['transactioncode']; ?>&type=P"><img src="authorise1.jpg" style="border:0px;width:20px;height:20px"   title="Authorise" /></a>&nbsp;</td> 
          <?php } else { ?>
		   <td><a href="dashboard.php?page=reversejvoucher&id=<?php echo $row1['transactioncode']; ?>"><img src="reverse1.jpg" style="border:0px; width:20px; height:20px;" title="Reverse" /></a>&nbsp;</td>
		  <?php } ?>
		   </tr>
           <?php 
           }
           ?>   
                                   
</tbody>

</table>
</div><br />

