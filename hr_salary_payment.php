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
					<button type="button" onClick="document.location='dashboardsub.php?page=hr_addsalary_payment'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Salary Payment</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left">Paid Date</th>
<!--<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Tr.Id</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Emp.Id</th> -->
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Emp.Name</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Salary</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Deduction</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Bonus</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>OT</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Actual Salary Paid</th> 								
<th>Actions</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php"; 
		   
           $query = "SELECT * FROM hr_salary_payment ORDER BY date";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		   $k =0;
		   		$eid = $name = $totalsal = $paid = $deduction =  "";
		        $q = "select * from hr_salary_payment where id = '$row1[id]' order by id";
		   		$qrs = mysql_query($q,$conn) or die(mysql_error());
		   		while($qr = mysql_fetch_assoc($qrs))
		   		{
				$k++;
		   			/*$eid.= $qr['eid'] . "/";
		   			$name.= $qr['name'] . "/";
		   			$totalsal.= $qr['totalsal'] . "/";
		   			$paid.= $qr['paid'] . "/";
		   			$deduction.= $qr['deduction'] . "/";*/
					$eid.= $qr['eid'] ;
		   			$name.= $qr['name'] ;
		   			$totalsal.= $qr['totalsal'] ;
		   			$paid.= $qr['paid'];
		   			$deduction.= $qr['deduction'] ;
					$bonus = $qr['bonus'];
					$ot = $qr['ot'];
					if($k%2 == 0)
					{
					$name.= "<br/>";
					}
					if($k%3 == 0)
						{
							$eid.= "<br/>";
							$totalsal.= "<br/>";
							$paid.= "<br/>";
							$deduction.= "<br/>";
							
						} 
	            }
		       /*$eid = substr($eid,0,-1);
		       $name = substr($name,0,-1);
		       $totalsal = substr($totalsal,0,-1);
		       $paid = substr($paid,0,-1);
		       $deduction = substr($deduction,0,-1);*/
		   
           ?>
            <tr>
			 <td><?php echo date("d.m.Y",strtotime($row1['date'])); ?></td>
            <?php /*?> <td><?php echo $row1['tid']; ?></td>
             <td><?php echo $eid; ?></td><?php */?>
             <td><?php echo $name; ?></td>
             <td><?php echo $totalsal; ?></td>
             <td><?php echo $deduction; ?></td>
			 <td><?php echo $bonus;?></td>
			 <td><?php echo $ot;?></td>
             <td><?php echo $paid; ?></td>
			 <td>
			 <?php /*?><a 
			 <?php if($row1['flag'] != 1) { ?> href="<?php echo 'dashboardsub.php?page=hr_authorizesalpayment&id='.$row1['tid']; ?>" <?php } ?>
			 >
			 <img src="images/icons/fugue/arrow-090.png" style="border:0px" title="<?php if($row1['flag'] != 1) echo "Authorize"; else echo "Already Authorized";?>"/></a>&nbsp;&nbsp;<?php */?>
			 <a href="dashboardsub.php?page=hr_editsalary_payment&id=<?php echo $row1['id']; ?>">
			<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;&nbsp;
			 <a href="hr_deletesalary_payment.php?id=<?php echo $row1['id']; ?>&name=<?php echo $name;?>&daten=<?php echo $row1['date'];?>salid=<?php echo $row1['salparamid']; ?>">
			<img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;&nbsp;			 </td>
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



