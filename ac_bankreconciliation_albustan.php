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
							{ },
							{ sType: 'eu_date',asSorting: [ "desc" ] },
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
			<button type="button" onClick="document.location='dashboardsub.php?page=ac_addbankreconciliation_albustan'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			


		</div>
			
	</div></div>
	
	<article class="container_12">
<?php
$date = $_GET['date'];
if($date == "")
 $date = date("d.m.Y");
$ddate = date("Y-m-d",strtotime($date));
?>		
		<div class="clear"></div>
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Bank Reconciliation</h1>
				<center><strong>Transaction Date</strong>&nbsp;&nbsp;<input type="text" class="datepicker" id="trdate" name="trdate" value="<?php echo $date; ?>" onchange="reloadpage()" size="10" /></center>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Tr. Date</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Bank</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Transaction No.</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Cheque</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Reconsiled Date</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Reconsiled By</th>
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
           $query = "SELECT * FROM ac_recons WHERE date = '$ddate' order by date desc ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		   $date = date("d.m.Y",strtotime($row1['date']));
		   $rdate = date("d.m.Y",strtotime($row1['rdate']));
		        if($row1['dr'] > 0) 
			   {
			     $amount = $row1['dr'];
			   }
			   else
			   {
			    $amount = $row1['cr'];
			   }
           ?>
            <tr>
             <td><?php echo $date; ?></td>
             <td><?php echo $row1['bank']; ?></td>
			 <td><?php echo $row1['trnum']; ?></td>
             <td><?php echo $row1['cheque']; ?></td>
             <td><?php echo $rdate; ?></td>
			 <td><?php echo $row1['empname']; ?></td>
             <td style="text-align:right"><?php echo $amount; ?></td>
			 <td><!--<a onclick="if(confirm('Are you sure,want to delete')) document.location ='ac_deletebankreconciliation.php?id=<?php echo $row1['id']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>-->
			 <a href="ac_deletebankreconciliation.php?id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>
			 </td>             
            </tr>
           <?php 
           }
           ?>   
                                   
</tbody>

</table>
</form>
</div></section><br />
<script type="text/javascript">
function reloadpage()
{ 
 var tdate = document.getElementById("trdate").value;
 document.location = "dashboardsub.php?page=ac_bankreconciliation_albustan&date=" + tdate;
}
</script>