<?php include "jquery.php" ?>

	<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	
		
		
		<div class="float-right"> 
		<?php if($_SESSION['client'] == 'SKPFNEW')
		{ ?>
			<button type="button" onClick="document.location='dashboardsub.php?page=hr_addsalpaymentnew'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<?php } 
			else if($_SESSION['client'] == 'FEEDATIVES'){?>
			<button type="button" onClick="document.location='dashboardsub.php?page=hr_addsalpayment_feedatives'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<?php } 
			
			else if($_SESSION['client'] == 'GOLDEN'){?>
			<button type="button" onClick="document.location='dashboardsub.php?page=hr_addsalpayment_golden'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<?php } else {?>
			
			<button type="button" onClick="document.location='dashboardsub.php?page=hr_addsalpayment'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<?php } ?>			
			


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
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Tr.Id</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Emp.Id</th> 
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
								</span>Actual Salary Paid</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Deduction</th> 
<th>Actions</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php"; 
		   
           $query = "SELECT * FROM hr_payment ORDER BY date";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		   $k =0;
		   		$eid = $name = $totalsal = $paid = $deduction = "";
		        $q = "select * from hr_payment where id = '$row1[id]' order by id";
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
             <td><?php echo $row1['tid']; ?></td>
             <td><?php echo $eid; ?></td>
             <td><?php echo $name; ?></td>
             <td><?php echo $totalsal; ?></td>
             <td><?php echo $paid; ?></td>
             <td><?php echo $deduction; ?></td>
			 <td>
			 <a 
			 <?php /* if($row1['flag'] != 1) { ?> href="<?php echo 'dashboardsub.php?page=hr_authorizesalpayment&id='.$row1['tid']; ?>>" <?php } ?>
			
			 <img src="images/icons/fugue/arrow-090.png" style="border:0px" title="<?php if($row1['flag'] != 1) echo "Authorize"; else echo "Already Authorized";?>"/></a>&nbsp;<?php */?>
			<?php  if($row1['flag'] != 1) {?>
			<?php if($_SESSION['client'] == "GOLDEN") {?>
			<a href="dashboardsub.php?page=hr_editsalarypayment_golden&id=<?php echo $row1['id']; ?>&mon=<?php echo $row1['month1'];?>&year=<?php echo $row1['year1'];?>">
			<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;
			<?php }else {?>
			<a href="dashboardsub.php?page=hr_editsalarypayment&id=<?php echo $row1['id']; ?>&mon=<?php echo $row1['month1'];?>&year=<?php echo $row1['year1'];?>">
			<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;
			<?php }?>
			<a href="dashboardsub.php?page=hr_authorizesalpayment&id=<?php echo $row1['tid']; ?>" ><img src="images/icons/fugue/arrow-090.png" style="border:0px" title="<?php if($row1['flag'] != 1) echo "Authorize"; else echo "Already Authorized";?>"/></a>&nbsp;
			 <a href="hr_deletesalarypaymento.php?id=<?php echo $row1['id']; ?>&name=<?php echo $name;?>&daten=<?php echo $row1['date'];?>">
			<img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;&nbsp;	
			<?php  } else {?>
			
			<?php if($_SESSION['client'] == "GOLDEN") {?>
			<a href="dashboardsub.php?page=hr_editsalarypayment_golden&id=<?php echo $row1['id']; ?>&mon=<?php echo $row1['month1'];?>&year=<?php echo $row1['year1'];?>">
			<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;
			<?php }else {?>
			<a href="dashboardsub.php?page=hr_editsalarypayment&id=<?php echo $row1['id']; ?>&mon=<?php echo $row1['month1'];?>&year=<?php echo $row1['year1'];?>">
			<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;
			<?php }?>
			
			<a href="hr_deletesalarypayment.php?id=<?php echo $row1['id']; ?>&name=<?php echo $name;?>&daten=<?php echo $row1['date'];?>">
			<img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;&nbsp; <?php }?>	
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



