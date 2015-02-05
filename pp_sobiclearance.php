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
	
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboardsub.php?page=pp_addsobiclearance'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			

		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>SOBI Adjustment</h1>
			
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th><th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Vendor</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Source</th>
<!--<th style="text-align:left">Control type</th>--><th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>SOBI</th><th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Total Amount</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
	  <?php
	  $totamount = 0;

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
$query = "SELECT * FROM pp_sobiclearance where client = '$client'  group by trid order by date ";

else
$query = "SELECT * FROM pp_sobiclearance where client = '$client' where unit in ($sectorlist)  group by trid order by date ";

           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
              
			  
			 $query1 = "SELECT * FROM pp_sobiclearance where trid = '$row1[trid]' and client = '$client'  ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
		 $s = $row11['sourcetype'];
		  
			 $totamount = $totamount + $row11['sourceamount'];
			 $user=$row11['empname'];
		   }
           ?>
            <tr>
             <td><?php echo date("d.m.Y",strtotime($row1['date'])); ?></td>
             <td><?php echo $row1['vendor']; ?></td>
             <td><?php echo $s; ?></td>
             <td><?php echo $row1['sobi']; ?></td>
             <td><?php echo $totamount; ?></td>
             <td>
			 
			 	<?php if($_SESSION['valid_user']==$user || ($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") ){?> 	
			
			 <a onclick="if(confirm('do you really want to delete this row?'))document.location='deletepvoucher.php?id=<?php echo $row1['trid']; ?>&type=PP'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a> 
	
<?php }  else
  { ?>
<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Locked" />
<?php  }?>		 
			    <a href="pp_sobiclearanceprint.php?id=<?php echo $row1['trid']; ?>" target="_new"><img src="images/icons/fugue/report.png" width="16px" style="border:0px" title="Print SOBI Clearance" />
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


