<?php 
    
     include "jquery.php";
?>
<script type="text/javascript">
		$(document).ready(function()
		{
			$('.sortable').each(function(i)
			{
				var table = $(this),
					oTable = table.dataTable({

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
			<button type="button" onClick="document.location='dashboardsub.php?page=packing_adddailypacking'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16">Add</button> 
			<button type="button" onClick="document.location='dashboardsub.php?page=packing_adddailypacking1'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16">New Add</button> 
		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border">
            
            
            <form class="block-content form" id="table_form" method="post" action="">
				<h1>Daily Packing Details</h1>
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
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Location</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Contractor/Labour</th>
                                <th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Description</th>
                                <th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Packets</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Amounts</th>
                              
<th>Actions</th>
</tr>
</thead>
<tbody>
	
   <?php
   
   $q1=mysql_query("set group_concat_max_len=10000000");
   
   $cont=$desc=$pack="";
   $q1="select date,location,trnum,totalamount,concat(\"'\",group_concat(code separator \"','\"),\"'\") as codes from packing_dailypacking where date between '$fromdate' and '$todate' group by trnum order by date desc";
   
   $q1=mysql_query($q1) or die(mysql_error());
   
   while($r1=mysql_fetch_assoc($q1))
   
    {
	$i=$n=$n1=0;
	$cont=$des=$packets=$amounts='';
	 $qq1="select * from packing_dailypacking where date='$r1[date]' and location='$r1[location]'  and trnum='$r1[trnum]' order by date desc";
	 $qq=mysql_query($qq1);
	 $n1=mysql_num_rows($qq);
	 while($rr=mysql_fetch_assoc($qq))
   
    {
	$i++;

	$cont=$cont.$rr['contractor']."/";
	$des=$des.$rr[description]."/";
	$packets=$packets.$rr[packets]."/";
	$amounts=$amounts.$rr[amount]."/";

	if($i%2==0)
	$des=$des."<br>";
	if($i%4==0)
	{
	$cont=$cont."<br>";
	$packets=$packets."<br>";
	$amounts=$amounts."<br>";
	}
	$n--;
	 }
	
	?>
    <tr>
    <td><?php echo date("d.m.Y",strtotime($r1['date']));?></td>
    
    <td><?php echo $r1['location'];?></td>
    
    <td><?php echo rtrim($cont,"/");?></td>
     <td><?php echo rtrim($des,"/");?></td>
      
        <td><?php echo rtrim($packets,"/");?></td>
    
    <td><?php echo rtrim($amounts,"/");?></td>
    
     
    
    <?php
	
	 $q3="select count(*) as count from product_productionunit where date='$r1[date]' and warehouse='$r1[location]' and producttype in ($r1[codes]) ";
	 
	 $q3=mysql_query($q3) or die(mysql_error());
	 
	 $r3=mysql_fetch_assoc($q3);
	 
	 if($r3['count']==0)
	{
	
	 if(($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") ){
	?>
	
    
    
    <td>
    
    <a href="dashboardsub.php?page=packing_editdailypacking&trnum=<?php echo $r1['trnum'];?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;&nbsp;
    <a href="dashboardsub.php?page=packing_editdailypacking1&trnum=<?php echo $r1['trnum'];?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="New Edit"/></a>&nbsp;&nbsp;
         <a onclick="if(confirm('Are you sure,want to delete'))document.location='dashboardsub.php?page=packing_deletedailypacking&trnum=<?php echo $r1['trnum'];?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px;" title="Delete" /></a>
    </td>
    <?php }else
	{
	?>
    <td><img src="images/icons/fugue/lock.png" /></td>
    <?php }}else
	{
	?>
    <td><img src="images/icons/fugue/lock.png" /></td>
    <?php }?>
    </tr>
    
    
    <?php }?>
    
    
    
                                   
</tbody>

</table>
</form>
</div></section><br />
<center>


&nbsp;&nbsp; 
      </center>
      <script type="text/javascript">
function reloadpage()
{
var month = document.getElementById('month').value;
var year = document.getElementById('year').value;
document.location = "dashboardsub.php?page=packing_dailypacking&month=" + month + "&year=" + year;
}
</script>

