<?php include "jquery.php";
 include "getemployee.php"; ?>
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
			 
		
			<button type="button" onClick="document.location='dashboardsub.php?page=oc_addcashsales_ims'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Cash Sales</h1>
<?php 
$month = $_GET['month'];
 $datep = date("d-m-Y");
$monthcnt = "";
$yearcnt = "";
$year = $_GET['year'];
if($year == "")
{

$arr = explode('-',$datep);
 $year = $arr[2];
}
if($month == "")
{
  $arr = explode('-',$datep);
 $monthcnt = $arr[1];
}
else if($month == "January")
{
$monthcnt = 1;
}
else if ($month == "February")
{
$monthcnt = 2;
}
else if($month == "March")
{
$monthcnt = 3;
}
else if($month == "April")
{
$monthcnt = 4;
}
else if($month == "May")
{
$monthcnt = 5;
}
else if($month == "June")
{
$monthcnt = 6;
}
else if($month == "July")
{
$monthcnt = 7;
}
else if($month == "August")
{
$monthcnt = 8;
}
else if($month == "September")
{
$monthcnt = 9;
}
else if($month == "October")
{
$monthcnt = 10;
}
else if($month == "November")
{
$monthcnt = 11;
}
else if($month == "December")
{
$monthcnt = 12;
}
$fromdate = $year."-".$monthcnt."-01";
$todate = $year."-".$monthcnt."-31";
?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Month:
<select name="month" id="month" onChange="reloadpage();" >
<option value="">--Select--</option>
<option  value="January"<?php if($monthcnt == 1){ ?> selected="selected"<?php } ?>>January</option>
<option  value="February"<?php if($monthcnt == 2){ ?> selected="selected"<?php } ?>>February</option>
<option  value="March"<?php if($monthcnt == 3){ ?> selected="selected"<?php } ?>>March</option>
<option  value="April"<?php if($monthcnt == 4){ ?> selected="selected"<?php } ?>>April</option>
<option  value="May"<?php if($monthcnt == 5){ ?> selected="selected"<?php } ?>>May</option>
<option  value="June"<?php if($monthcnt == 6){ ?> selected="selected"<?php } ?>>June</option>
<option  value="July"<?php if($monthcnt == 7){ ?> selected="selected"<?php } ?>>July</option>
<option  value="August"<?php if($monthcnt == 8){ ?> selected="selected"<?php } ?>>August</option>
<option  value="September"<?php if($monthcnt == 9){ ?> selected="selected"<?php } ?>>September</option>
<option  value="October"<?php if($monthcnt == 10){ ?> selected="selected"<?php } ?>>October</option>
<option  value="November"<?php if($monthcnt == 11){ ?> selected="selected"<?php } ?>>November</option>
<option  value="December"<?php if($monthcnt == 12){ ?> selected="selected"<?php } ?>>December</option>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year:
<select name="year" id="year" onChange="reloadpage();" >
<option value="">--Select--</option>
<?php 
for($i=$fyear;$i<=$tyear;$i++)
{
echo $i;
?>
<option value="<?php echo $i; ?>" <?php if($i == $year) { ?> selected="selected" <?php } ?>><?php echo $i; ?></option>
<?php } ?>
</select>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th>
<th style="text-align:center" title="Auto Generated Number(Customner Order Based Invoice)"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>COBI #</th>
 
								 
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Items</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Quantity</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Price</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Amount</th>

														
<th style="text-align:center">Actions</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php"; 
		  //  $query = "select distinct(socobi) from oc_receipt where choice = 'COBIs' and date > '$fromdate'";
//	   $result = mysql_query($query,$conn) or die(mysql_error());
//	   while($res = mysql_fetch_assoc($result))
//	   $paid[$res['socobi']] = 1;
		  
			$sectortype1=$_SESSION['sectorlist'];
			if($sectortype1=="all")
		   {
		 $query1 = "SELECT distinct(invoice),party,date,finaltotal,flag,empname FROM oc_cobi WHERE dflag = '2' and date >= '$fromdate' and date <= '$todate' and  invoice in (SELECT distinct(socobi) FROM oc_receipt WHERE choice = 'COBIs' AND date >= '$fromdate' and date <= '$todate' and client = '$client') order by date DESC ";
		 }
			else
			{
			$query1 = "SELECT distinct(invoice),party,date,finaltotal,flag,empname FROM oc_cobi WHERE dflag = '2' and date >= '$fromdate' and date <= '$todate' and  invoice in (SELECT distinct(socobi) FROM oc_receipt WHERE choice = 'COBIs' AND date >= '$fromdate' and date <= '$todate' and client = '$client') and warehouse in ($sectortype1) order by date DESC ";
		 }
	       $result1 = mysql_query($query1,$conn); 
           while($row1 = mysql_fetch_assoc($result1))
           {
		   $count = 1;
            $items = "";$description = ""; $qty = ""; $price = "";
			$flag = $row1['flag'];
           $query2 = "SELECT * FROM oc_cobi WHERE invoice = '$row1[invoice]' order by date LIMIT 5";
           $result2 = mysql_query($query2,$conn); 
           while($row2 = mysql_fetch_assoc($result2))
           {
		    $a="";
				 $n=$n+1;
				 if($n%5==0)
				 {
				 	$a="<br/>";
				 }
		  
			  $items = $items.$row2['code']." / ".$a;
                    $description = $description.$row2['description']." / ";
                    $qty = $qty.$row2['quantity']." / ".$a;
                    $price = $price.$row2['price']." / ".$a;
             $flock = $row2['flock'];
			 $count = $count + 1;
           }
      ?>
            <tr>
              <td> <?php echo date("d.m.Y", strtotime($row1['date'])); ?></td>
			  
              <td><?php echo $row1['invoice']; ?></td>
			  
             
			  <td title="<?php echo substr($description,0,-3); ?>"><?php echo substr($items,0,-3); ?></td>
			  
              <td><?php echo substr($qty,0,-3); ?></td>
			  
              <td><?php echo substr($price,0,-3); ?></td>
			  
		 <td style="text-align:right"><?php echo $row1['finaltotal']; ?></td>
		 
		 <td style="width:auto;">
<?php if($_SESSION['superadmin']=="1" || $row1['empname']==$_SESSION['valid_user']){?>



<a href="dashboardsub.php?page=oc_editcashsales_ims&id=<?php echo $row1['invoice']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>


<a onClick="if(confirm('Are you sure,want to delete')) document.location ='oc_deletecashsales_ims.php?id=<?php echo $row1['invoice']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a> 

<?php  }// else {?>
<!-- <img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Locked" /> -->
<?php //}?>

<?php /*?><?php else if($paid[$row1['invoice']])
{
?>
<a onClick="if(confirm('Are you sure,want to delete')) document.location ='oc_deletecashsales_ims.php?id=<?php echo $row1['invoice']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a> 

<img src="images/icons/fugue/lock.png" style="border:0px" title="<?php echo "Payment done for this entry."; ?>"/>
<?php } ?>
<?php */?> <a href="invoice.php?id=<?php echo $row1['invoice']; ?>" target="_new"><img src="images/icons/fugue/report.png" width="16px" style="border:0px" title="Invoice" /></a>
 
		

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
function reloadpage()
{
var month = document.getElementById('month').value;
var year = document.getElementById('year').value;
document.location = "dashboardsub.php?page=oc_cashsales_ims&month=" + month + "&year=" + year;
}
</script>




