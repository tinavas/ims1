<?php include "jquery.php";
	$sectortype = $_SESSION['sectorr'];?>
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
	
		<div class="float-left">
			<!--<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button> 
			<button type="button" onClick="openModal()">Open report</button>-->
		</div>
		
		<div class="float-right"> 
			
			<button type="button" onClick="document.location='dashboardsub.php?page=pp_addpurchaseorder'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
 

		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Purchase Order</h1>
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
<tr>
<th style="text-align:center" ><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Purchase Order #</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Vendor</th>
<th style="text-align:center" ><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Items</th>
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
		   include "getemployee.php";


		       if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
	 
	 if($sectorlist=="")
	  $query = "SELECT distinct(po),date,vendor,flag FROM pp_purchaseorder where date >= '$fromdate' and date <= '$todate'   ORDER BY date DESC ";
	else  
	   $query = "SELECT distinct(po),date,vendor,flag FROM pp_purchaseorder where deliverylocation in ($sectorlist)  and date >= '$fromdate' and date <= '$todate'  ORDER BY date DESC ";

		 
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
               $date = $row1['date'];
               $date = date("j.m.Y", strtotime($date));
               $name = "";
			   $description="";
               $quantity = "";
               $query2 = "SELECT code,empname,quantity,pr,description FROM pp_purchaseorder WHERE po = '$row1[po]' and date >= '$fromdate' and date <= '$todate'  ORDER BY date DESC LIMIT 5 ";
               $result2 = mysql_query($query2,$conn); 
               $num2 = mysql_num_rows($result2);
               while($row2 = mysql_fetch_assoc($result2))
               {
                 $name = $name." / ".$row2['code'];
                 $quantity = $quantity." / ".$row2['quantity'];
                 $pr = $row2['pr'];
				 $user = $row2['empname'];
				  $description=$description."/".$row2['description'];
               } 
              $name = substr($name,3);
              $quantity = substr($quantity,3);
			  $description=substr($description,1);
           ?>
            <tr>
             <td><?php echo $date; ?></td>
             <td><?php echo $row1['po']; ?></td>
			 <td><?php echo $row1['vendor']; ?></td>
			 <td title="<?php echo $description;?>"><?php echo $name; ?></td>
			 <td ><?php echo $quantity; ?></td>
			
			 <td>
<?php

$tquery	= "SELECT * FROM pp_goodsreceipt WHERE po = '$row1[po]'";
$tresult = mysql_query($tquery,$conn) or die(mysql_error());
 $trows = mysql_num_rows($tresult);
if($trows == 0)
{
?>

<?php if($_SESSION['valid_user']==$user || ($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") ){?> 


	<?php if($pr == "") { ?>
	<a href="dashboardsub.php?page=pp_editpurchaseorder&po=<?php echo $row1['po']; ?>">
	<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" /></a>&nbsp;
	<?php } else { ?>
	<a href="dashboardsub.php?page=pp_editpurchaseorderrequest&po=<?php echo $row1['po']; ?>">
	<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" /></a>&nbsp;
	<?php } ?>


<a href="dashboardsub.php?page=pp_deletepurchaseorder&po=<?php echo $row1['po']; ?>"><img src="images/icons/fugue/cross-circle.png" title="delete"/></a>

<?php  }  else {?>
<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Can't be edited" />


<?php }?>




<?php } else {?>
<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Gate Entry Completed" />

<?php } ?>
<!--<a  <?php if($row1['flag'] != 1) { ?> href="<?php echo 'dashboardsub.php?page=pp_authorizepurchaseorder&id='.$row1['po']; ?>" <?php } ?> >
 <img src="images/icons/fugue/arrow-090.png" style="border:0px" title="<?php if($row1['flag'] != 1) echo "Authorize"; else echo "Already Authorized";?>"/></a>-->




<a href="pp_poprint.php?id=<?php echo $row1['po']; ?>" target="_new"><img src="images/icons/fugue/report.png" width="16px" style="border:0px" title="Print Purchase Order" /></a>




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

function reloadpage()
{
var month = document.getElementById('month').value;
var year = document.getElementById('year').value;
document.location = "dashboardsub.php?page=pp_purchaseorder&month=" + month + "&year=" + year;
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

