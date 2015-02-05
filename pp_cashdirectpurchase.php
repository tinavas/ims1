<?php include "jquery.php";
 include "getemployee.php"; 
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
		
		
			<!--<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button>--> 
			<button type="button" target="_new" onClick="window.open('production/purchasereportsmry.php');">Open report</button>
		<?php if(($_SESSION['db'] == 'souza') or ($_SESSION['db'] == "suriya")) {?>
		<button type="button" target="_new" onClick="window.open('production/purchasereportsmrynew.php');">Date Wise report</button>
		<?php } ?>
		</div>
		
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboardsub.php?page=pp_addcashdirectpurchase'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			 


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Cash Purchases</h1>
<?php 
if($_SESSION['db'] == 'mlcf' or $_SESSION['db'] == "mbcf" || $_SESSION['db']=='ncf')
{
$result = mysql_query("select code,capacity from ims_bagdetails",$conn) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$bagweight[$res['code']] = $res['capacity'];

}
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
<select name="month" id="month" onchange="reloadpage();" >
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
<select name="year" id="year" onchange="reloadpage();" >
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
<th style="text-align:center" title="Auto Generated Number(Supplier Order Based Invoice)"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>SOBI #</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Vendor</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Items</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Quantity</th>
<!--<th style="text-align:center;visibility:hidden;"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Price</th>-->
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
           $query1 = "SELECT distinct(so),date,vendor,grandtotal,flag FROM pp_sobi WHERE dflag = '0' and date >= '$fromdate' and date <= '$todate' and client = '$client' AND so IN (SELECT distinct(posobi) FROM pp_payment WHERE choice = 'SOBIs' AND date >= '$fromdate' and date <= '$todate' and client = '$client')  order by date DESC";
           $result1 = mysql_query($query1,$conn); 
           while($row1 = mysql_fetch_assoc($result1))
           { $count = 1; $items = ""; $description = ""; $qty = ""; $price = "";
		    $flag = $row1['flag'];
            $query2 = "SELECT * FROM pp_sobi WHERE so = '$row1[so]' order by date";
            $result2 = mysql_query($query2,$conn); 
            while($row2 = mysql_fetch_assoc($result2))
            {
              if ($count == 3)
			 {
			  $items = $items.$row2['code']."<br>"; 
              $description = $description.$row2['description']."<br>"; 
              if(($_SESSION['db'] == "mlcf" && strlen(strstr($row2['code'],'LFD'))>0) or ( $_SESSION['db'] == "mbcf" && strlen(strstr($row2['code'],'BFD'))>0 ) or ( $_SESSION['db'] == "ncf" && strlen(strstr($row2['code'],'NFD'))>0 ) or ( $_SESSION['db'] == "ncf" && strlen(strstr($row2['code'],'LFD'))>0 ) )
			    $qty = $qty.($row2['sentquantity']/$bagweight[$row2['bagtype']])."<br>"; 
			  else
			   $qty = $qty.$row2['sentquantity']."<br>";
              $price = $price.$row2['rateperunit']."<br>"; 
			 }
			 else
			 {
			  $items = $items.$row2['code']."/"; 
              $description = $description.$row2['description']."/"; 
             if(($_SESSION['db'] == "mlcf" && strlen(strstr($row2['code'],'LFD'))>0) or ( $_SESSION['db'] == "mbcf" && strlen(strstr($row2['code'],'BFD'))>0 ) or ( $_SESSION['db'] == "ncf" && strlen(strstr($row2['code'],'NFD'))>0 ) or ( $_SESSION['db'] == "ncf" && strlen(strstr($row2['code'],'LFD'))>0 ))
			  $qty = $qty.($row2['sentquantity']/$bagweight[$row2['bagtype']])."/";
			  else
			  $qty = $qty.$row2['sentquantity']."/"; 
              $price = $price.$row2['rateperunit']."/"; 
			 }
            
			 $count = $count + 1;
			
            }
      ?>
            <tr>
			
              <td><?php echo date("d.m.Y", strtotime($row1['date'])); ?></td>
              <td><?php echo $row1['so']; ?></td>
              <td><?php echo $row1['vendor']; ?></td>
			  
             <td title="<?php echo substr($description,0,-1); ?>"><?php echo substr($items,0,-1); ?></td>
             <td><?php echo substr($qty,0,-1); ?></td>
             <!--<td style="visibility:hidden;"><?php #echo substr($price,0,-1); ?></td>-->
		 <td style="text-align:right"><?php echo $row1['grandtotal']; ?></td>
             <td>
			 
<?php if($_SESSION['db'] == "central" or $_SESSION['db'] == "alwadi") { ?>

<?php if($flag == 0) { ?>	<!-- Before Authorization -->
<a href="dashboardsub.php?page=pp_editcashdirectpurchases&id=<?php echo $row1['so']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
&nbsp;&nbsp;&nbsp;<a onclick="if(confirm('Are you sure,want to delete')) document.location ='pp_deletecashdirectpurchase.php?id=<?php echo $row1['so']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;

<?php } else { ?>					<!-- After Authorization -->
<?php if ( strlen(strstr(','.$_SESSION['authorizesectors'],',SOBI,' ))>0 ) { ?>	<!-- If he has authority power -->
<a href="dashboardsub.php?page=pp_editcashdirectpurchases&id=<?php echo $row1['so']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
&nbsp;&nbsp;&nbsp;<a onclick="if(confirm('Are you sure,want to delete')) document.location ='pp_deletecashdirectpurchase.php?id=<?php echo $row1['so']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;

<?php if($flag == 1) { ?><img src="images/icons/fugue/tick-circle.png" title="Already Authorized" width="16" 

height="16"><?php } ?>
<?php } else { ?>
<img src="images/icons/fugue/lock.png" style="border:0px" title="<?php echo "Already Authorized"; ?>"/>
<?php } ?>
<?php } ?>



<?php } else { ?>
			 
<?php if($row1['flag'] == 0){ ?>
<a href="dashboardsub.php?page=pp_authorizedirectpurchase&id=<?php echo $row1['so']; ?>"><img src="images/icons/fugue/authorize.png" style="border:0px" title="Authorize"/></a>
 <?php } ?>
<a href="dashboardsub.php?page=pp_editcashdirectpurchases&id=<?php echo $row1['so']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
<?php 
$q = "select * from broiler_daily_entry where flock = '$row1[flock]' and client = '$client'";
$r = mysql_query($q,$conn) or die(mysql_error());
$num_rows = mysql_num_rows($r);
if($num_rows > 0)
{
?>
<img src="images/icons/fugue/lock.png" style="border:0px" title="Cannot be deleted"/>
<?php } else { ?>
&nbsp;&nbsp;&nbsp;<a onclick="if(confirm('Are you sure,want to delete')) document.location ='pp_deletecashdirectpurchase.php?id=<?php echo $row1['so']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
<?php } 
if($_SESSION['client'] == 'FEEDATIVES')
{
?>
<a href="purchaseinvoice.php?id=<?php echo $row1['so']; ?>" target="_new"><img src="images/icons/fugue/report.png" width="16px" style="border:0px" title="Invoice" /></a>
<?php } 
else if($_SESSION['db'] == "suriya") { ?>
<a href="invoice_purchase.php?id=<?php echo $row1['so']; ?>" target="_new"><img src="images/icons/fugue/report.png" width="16px" style="border:0px" title="Invoice" /></a>
<?php } ?>


<?php } ?>

</td>

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
document.location = "dashboardsub.php?page=pp_directpurchase&month=" + month + "&year=" + year;
}
</script>

