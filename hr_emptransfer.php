<?php include "jquery.php";
 //include "getemployee.php";
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
			<button type="button" onClick="document.location='dashboardsub.php?page=hr_addemptransfer'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			 


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Employee Transfer</h1>
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
$monthcnt = "01";
}
else if ($month == "February")
{
$monthcnt = "02";
}
else if($month == "March")
{
$monthcnt = "03";
}
else if($month == "April")
{
$monthcnt = "04";
}
else if($month == "May")
{
$monthcnt = "05";
}
else if($month == "June")
{
$monthcnt = "06";
}
else if($month == "July")
{
$monthcnt = "07";
}
else if($month == "August")
{
 $monthcnt = "08";
}
else if($month == "September")
{
$monthcnt = "09";
}
else if($month == "October")
{
$monthcnt = "10";
}
else if($month == "November")
{
$monthcnt = "11";
}
else if($month == "December")
{
$monthcnt = "12";
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
<th style="text-align:center" title="Auto Generated Number(Supplier Order Based Invoice)"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>From Sector</th>
                                <th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Employee</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>ToSector</th>

<th style="text-align:center">Actions</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php";
 session_start();

		       if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
		if($sectorlist=="")   
    
     $query = "SELECT * FROM hr_emptransfer where  leavingdate >= '$fromdate' and leavingdate <= '$todate' order by leavingdate desc"; 
	 
	 else
	  $query = "SELECT * FROM hr_emptransfer where leavingdate >= '$fromdate' and  leavingdate <= '$todate' and (fromsector in ($sectorlist) or tosector in ($sectorlist)) order by leavingdate desc"; 
	 

           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {  
$eid=$row1['employeeid'];
$tsector=$row1['tosector'];
           ?>

            <tr>
			 <td><?php echo date("d.m.Y",strtotime($row1['leavingdate'])); ?></td>
             <td><?php echo $row1['fromsector']; ?></td>
             <td><?php echo $row1['employeename']; ?></td>
             <td><?php echo $row1['tosector']; ?></td>

             
             <?php 
echo $q="select count(*) as c from hr_attendance where eid='$eid' and farm='$tsector'";
$q=mysql_query($q,$conn) or die(mysql_error());
$r=mysql_fetch_array($q);
$c=$r[c];
if($c=="")
$c=0;
$q0=mysql_query("select count(*) as c from hr_salary_generation where eid='$eid' and sector='$tsector'",$conn) or die(mysql_error());
$r0=mysql_fetch_array($q0);
$d=$r0[c];
if($d=="")
$d=0;
?>

<td>
<?php 
if($c==0 && d==0)
{			 ?>
             
		
			 
<?php /*?>			 <?php if(($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") ){?> 
             <?php if($row1[flag]==0)
			 {?>
<a href="dashboardsub.php?page=ims_editstocktransfer&id=<?php echo $row1['id']; ?>&col=<?php echo "id"; ?>&tid=<?php echo $row1['tid']; ?>&date=<?php echo $row1['date']; ?>&flock=<?php echo $row1['aflock']; ?>&type=<?php echo "STR"; ?>&name=<?php echo "ims_stockreceive"; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" /></a>
              &nbsp; <a onclick="if(confirm('Are you sure,want to delete')) document.location ='ims_deletestocktransfer.php?id=<?php echo $row1['id']; ?>&tid=<?php echo $row1['tid']; ?>&date=<?php echo $row1['date']; ?>&flock=<?php echo $row1['aflock']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;<?php */?>
		
		<a onclick="if(confirm('Are you sure,want to delete')) document.location ='hr_deleteemptransfer.php?eid=<?php echo $row1['employeeid']; ?>&emp=<?php echo $row1['employeename']; ?>&tsector=<?php echo $row1['tosector']; ?>&fsector=<?php echo $row1['fromsector']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
		<?php }
		else
		{?>
		<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Locked" />
        <?php } ?>
		<?php /*?><?php }
		 } else { ?>

<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Locked" />
<?php  }?>	  
			  <a href="stktrinvoice.php?tid=<?php echo $row1['tid']; ?>&towar=<?php echo $row1['towarehouse'];?>" target="_new"><img src="images/icons/fugue/report.png" style="border:0px" title="Print" /></a>
<?php */?>
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
document.location = "dashboardsub.php?page=hr_emptransfer&month=" + month + "&year=" + year;
}
</script>



