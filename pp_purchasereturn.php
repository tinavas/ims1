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
							{ },
							{ },
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
			<button type="button" onClick="document.location='dashboardsub.php?page=pp_addpurchasereturn'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Purchase Return</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Return Date</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>PRE#</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>SOBI#</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Item Code</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Description</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Purchased Quantity</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Returnned Quantity</th>

<th style="text-align:center">Actions</th>
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
		 $query = "SELECT distinct(date),trid,sobi,flag FROM pp_purchasereturn order by date desc";
		   
		else   
           $query = "SELECT distinct(date),trid,sobi,flag FROM pp_purchasereturn where  warehouse in ($sectorlist) order by date desc";
         
		
		   $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		   	  $i = 0;
              $date = date("d-m-Y", strtotime($row1['date']));
			  
			  $code = $description = $pq = $rq = $status = "";
			  $q = "select * from pp_purchasereturn where trid = '$row1[trid]' order by sobi";
			  $qrs = mysql_query($q,$conn) or die(mysql_error());
			  while($qr = mysql_fetch_assoc($qrs))
			  {
			  	$i++;
			  	$code.= $qr['code'] . "/";
				$description.= $qr['description'] . "/";
				$pq.= $qr['purchasedquantity'] . "/";
				$rq.= $qr['returnquantity'] . "/";
				$status.= $qr['status'] . "/";
				$user=$qr['empname'];
				
				if($i%3 == 0)
				{
			  		$code.= "<br/>";
					$description.= "<br/>";
					$pq.= "<br/>";
					$rq.= "<br/>";
					$status.= "<br/>";
				}
			  }
	
			  if($i%3 == 0)
			  {
				  $code = substr($code,0,-6);
				  $description = substr($description,0,-6);
				  $pq = substr($pq,0,-6);
				  $rq = substr($rq,0,-6);
				  $status = substr($status,0,-6);
			  }
			  else
			  {
				  $code = substr($code,0,-1);
				  $description = substr($description,0,-1);
				  $pq = substr($pq,0,-1);
				  $rq = substr($rq,0,-1);
				 
			  }

			  
			  
           ?>
            <tr>
			 <td><?php echo $date; ?></td>
             <td><?php echo $row1['trid']; ?></td>
			 <td><?php echo $row1['sobi']; ?></td>
			 <td><?php echo $code; ?></td>
			 <td><?php echo $description; ?></td>
			 <td><?php echo $pq; ?></td>
			 <td><?php echo $rq; ?></td>
		
             <td>
			 
			
		
	<?php if($_SESSION['valid_user']==$user || ($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") ){?> 	
			
 <a href="pp_deletepurchasereturn.php?&id=<?php echo $row1['trid']; ?>&q=<?php echo $rq ?>&code=<?php echo $code; ?>&warehouse=<?php echo $row1['warehouse']; ?>">
			<img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
			<?php } else {?>
<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Locked" />
<?php  }?>

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



