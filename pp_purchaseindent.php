<?php include "jquery.php";
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
		</div>
		
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboardsub.php?page=pp_addpurchaseindent'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Purchase Request</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Purchase Request #</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Item Code</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Quantity</th>
<th>Actions</th>
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
		 $query = "SELECT distinct(pi),date,approve FROM pp_purchaseindent  ORDER BY date DESC ";
		 
		 else
		$query = "SELECT distinct(pi),date,approve FROM pp_purchaseindent where doffice in($sectorlist)  ORDER BY date DESC "; 
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
               $date = $row1['date'];
               $date = date("j.m.Y", strtotime($date));
               $approve = $row1['approve'];
               $name = "";
               $quantity = "";
			    
               $query2 = "SELECT * FROM pp_purchaseindent WHERE pi = '$row1[pi]' ORDER BY date DESC ";
               $result2 = mysql_query($query2,$conn); 
               $num2 = mysql_num_rows($result2);
               while($row2 = mysql_fetch_assoc($result2))
               {
			   
			   	$user=$row2['empname'];
                 $name = $name."/".$row2['icode'];
                 $quantity = $quantity."/".$row2['quantity'];
				
				 $approve = $row2['approve'];
               } 
              $name = substr($name,1,(strlen($name)-1));
              $quantity = substr($quantity,1,(strlen($quantity)-1));
           ?>
            <tr>
             <td><?php echo $date; ?></td>
             <td><?php echo $row1['pi']; ?></td>
			 <td><?php echo $name; ?></td>
			 <td><?php echo $quantity; ?></td>
 <td>

<?php

$tquery	= "SELECT * FROM pp_purchaseorder WHERE pr = '$row1[pi]'";
$tresult = mysql_query($tquery,$conn) or die(mysql_error());
 $trows = mysql_num_rows($tresult);
if($trows == 0)
{
?>		
<?php if($_SESSION['valid_user']==$user || ($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") ){?> 

<a href="dashboardsub.php?page=pp_editpurchaseindent&pi=<?php echo $row1['pi']; ?>" ><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" /></a>
<a href="pp_deletepurchaseindent.php?pi=<?php echo $row1['pi']; ?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>

<?php  } else { ?>

<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Locked" />
<?php  }?>

<?php } else { ?>
<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Purchase Order Completed" />
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







<script type="text/javascript">
function reloadpurord()
{ 
 var ioff = document.getElementById('ioff').value;
 window.location = "purchaseIndentnew.php?ioff=" + ioff;
}

function purord()
{
/* if(document.getElementById('ioff').selectedIndex == 0)
 {
   alert("please select an office");
   document.getElementById('ioff').focus();
 }
 else
 { */
  var date1 = document.getElementById('date1').value;
  //var ioff = document.getElementById('ioff').value;
  top.location = "purchaseIndentInsertnew.php?date1=" + date1;
 //}
}
</script>
</html>
