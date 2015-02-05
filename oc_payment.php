<?php include "jquery.php" ?>
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
			<button type="button" onClick="document.location='dashboardsub.php?page=oc_addpayment'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			

		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>O2C Payment</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Party</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Amount</th>
								<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Actions</th>
				

</tr>
</thead>
<tbody>
	  <?php
           include "config.php";
		    
		       if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
		if($sectorlist=="")    
           $query = "SELECT distinct(tid),date,party,flag,totalamount,empname FROM oc_payment order by tid";
		   
		   else
		   $query = "SELECT distinct(tid),date,party,flag,totalamount,empname FROM oc_payment where unit in ($sectorlist) order by tid";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
              $user=$row1['empname'];
           ?>
            <tr>
			 <td><?php echo date("d.m.Y",strtotime($row1['date'])); ?></td>
			 
			 <td><?php echo $row1['party']; ?></td>
			 
			 <td align="right"><?php echo $row1['totalamount']; ?></td>
			 
			 <td>
			 
			 
			 <?php if($_SESSION['valid_user']==$user || ($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") ){?> 
			 <a 
			  href="<?php echo 'dashboardsub.php?page=oc_editpayment&id='.$row1['tid']; ?>" >
			 
			 
			 <img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;
			 
			 <a onclick="if(confirm('Are you sure,want to delete')) document.location ='<?php echo 'oc_deletepayment.php?id='.$row1['tid']; ?>'" >
			 
			 
			 <img src="images/icons/fugue/<?php echo "cross-circle.png";?>" style="border:0px" title="<?php echo "Delete";?>" />
			 </a>&nbsp;
			 
			 
			 
<?php  } else { ?>

<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Locked" />
<?php  }?>

			 

			 <?php if($row1['paymentmode'] == "Cheque") { ?>
             <a href="<?php echo 'oc_chequ1.php?date='.$date.'&vendor='.$row1['vendor'].'&amt='.$row1['amountpaid']; ?>" target="_new" >
			 
			 
			 <img src="images/icons/fugue/report.png" style="border:0px" title="<?php echo "Cheque Print";?>" />
			 </a>&nbsp;<?php } ?>


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