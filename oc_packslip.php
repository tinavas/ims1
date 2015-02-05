<?php include "jquery.php";
      include "getemployee.php";
	  $date = $_GET['date'];
	  if($date == '')  
{
$date = date("d.m.Y");
}
$cdate = date('Y-m-d',strtotime($date));
?>
<script type="text/javascript">
		$(document).ready(function()
		{
			$('.sortable').each(function(i)
			{
				var table = $(this),
					oTable = table.dataTable({

						aoColumns: [

							{ },
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
		
function reload_page()
{
var cdate = document.getElementById("mdate").value;
document.location = 'dashboardsub.php?page=oc_packslip&date=' + cdate;
}	
	</script>

	<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	
		<div class="float-left">
			<!--<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button> 
			<button type="button" onClick="openModal()">Open report</button>-->
		</div>
		
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboardsub.php?page=oc_addpackslip'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<!-- <button type="button" class="grey">View</button> 
			<button type="button" disabled="disabled">Disabled</button>
			<button type="button" class="red">Authorize</button>  -->


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Pack Slip</h1>
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
<option value="2011"<?php if($year == "2011"){ ?> selected="selected"<?php } ?>>2011</option>
<option value="2012"<?php if($year == "2012"){ ?> selected="selected"<?php } ?>>2012</option>
<option value="2013"<?php if($year == "2013"){ ?> selected="selected"<?php } ?>>2013</option>
<option value="2014"<?php if($year == "2014"){ ?> selected="selected"<?php } ?>>2014</option>
</select>

<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >
<th><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Pack Slip#</th>
<th><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th>
<th><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Party</th>


<th><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Name</th>
<th><span class="column-sort">
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
	
		   {
		   		$query = "SELECT distinct(ps),date,driver,party,flag FROM oc_packslip where date >= '$fromdate' and date <= '$todate'  order by date DESC";

		   }
		   else
		   {
		   		$query = "SELECT distinct(ps),date,driver,party,flag FROM oc_packslip where date >= '$fromdate' and date <= '$todate' and warehouse in ($sectorlist)  order by date DESC";

		   }
          
		  
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
               $date = $row1['date'];
               $date = date("j.m.Y", strtotime($date));
               $itemcode = ""; $description = ""; $quantity = "";$k = 0;
               $query2 = "SELECT * FROM oc_packslip WHERE ps = '$row1[ps]' ORDER BY date DESC ";
               $result2 = mysql_query($query2,$conn); 
               $num2 = mysql_num_rows($result2);
               while($row2 = mysql_fetch_assoc($result2))
               {
			   $k++;
			   	$user=$row2['empname'];
			     $description = $description."/".$row2['description'];
                 $itemcode = $itemcode."/".$row2['itemcode'];
                 $quantity = $quantity."/".changeprice1($row2['quantity']);
				  if($k%5 == 0)
						{
							$description.= "<br/>";
							$itemcode.= "<br/>";
							$quantity.= "<br/>"; 
						} 
               
               } 
			   $description = substr($description,1,(strlen($description)-1));
              $itemcode = substr($itemcode,1,(strlen($itemcode)-1));
              $quantity = substr($quantity,1,(strlen($quantity)-1)); 
           ?>
            <tr>
             <td><?php echo $row1['ps']; ?></td>
			 <td><?php echo $date; ?></td>
             <td><?php echo $row1['party']; ?></td>
             
             <td ><?php echo $itemcode; ?></td>
			 <td style="text-align:right"><?php echo $quantity; ?></td>
			 <td>
			 
<?php
$flag = $row1['flag'];			 
$tquery	= "SELECT id FROM oc_cobi WHERE ps = '$row1[ps]'";
$tresult = mysql_query($tquery,$conn) or die(mysql_error());
$trows = mysql_num_rows($tresult);
if($trows !="")
{

?>

<?php $flag = $row1['flag']; ?>


<img src="images/icons/fugue/lock.png" style="border:0px" title="<?php echo "COBI Completed"; ?>"/>
<a href="oc_packslipprint.php?id=<?php echo $row1['ps']; ?>" target="_new"><img src="images/icons/fugue/report.png" width="16px" style="border:0px" title="Print Pack Slip" /></a>
	 
<?php
}
else
{?>

<?php if($_SESSION['valid_user']==$user || ($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") ){?> 
 <a href="dashboardsub.php?page=oc_editpackslip&ps=<?php echo $row1['ps']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" /></a>&nbsp;
<a href="dashboardsub.php?page=oc_deletepackslip&ps=<?php echo $row1['ps']; ?>"><img src="images/icons/fugue/cross-circle.png" title="Delete"/></a>
<a href="oc_packslipprint.php?id=<?php echo $row1['ps']; ?>" target="_new"><img src="images/icons/fugue/report.png" width="16px" style="border:0px" title="Print Pack Slip" /></a>


<?php  } else { ?>

<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Locked" />
<?php  }?>
 <?php
 
}
?>			 
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
document.location = "dashboardsub.php?page=oc_packslip&month=" + month + "&year=" + year;
}
</script>

