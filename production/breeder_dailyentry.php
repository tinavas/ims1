<?php include "jquery.php"; 
$uniti1 = $_GET['unit'];?>
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
							<?php if($_SESSION['client'] == "JOHNSON") { ?>
							{ },
<?php } ?>
 							{ },
 							{ },
 							{ },
 							/*{ },
 							{ },
*/ 							{ }
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
			<button type="button" target="_new" onClick="window.open('production/dailyreport.php');">Open report</button>
		</div>
		
		<div class="float-right"> 
			<button type="button" onclick="document.location='dashboardsub.php?page=breeder_adddailyentry';"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<!-- <button type="button" class="grey">View</button> -->
			<!-- <button type="button" disabled="disabled">Disabled</button> -->
			<!-- <button type="button" class="red">Authorize</button> -->


		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Daily Entry</h1>
				<table align="center">
 <tr>
 <td><strong>Unit<strong>&nbsp;&nbsp;</td>
  <td><select name="unit" id="unit" tabindex="1" onchange="reloadpage();">
      <option value="">-Select Unit-</option>
       <?php include "config.php";
	   $c=0;
	  $query1 = "SELECT distinct(unitcode)  FROM breeder_unit ORDER BY unitdescription ASC";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
		   if($c==0 && $uniti1 == "")
		   {
		   $uniti = $row1['unitcode'];
		   }
		   
?>
<option value="<?php echo $row1['unitcode']; ?>" <?php if(($c==0 && $uniti1 == "") || ($uniti1 == $row1['unitcode']) ){ ?> selected="selected" <?php } ?>><?php echo $row1['unitcode']; ?></option>
<?php $c++;} ?>
</select>&nbsp;&nbsp;&nbsp;</td>
  <td><strong>Flock<strong>&nbsp;&nbsp;</td>
  <td><select name="flock" id="flock" tabindex="2">
    <option value="">-Select Flock-</option>
    <?php
	$j =0;
	 include "config.php";
	 if($uniti1 == "")
{
$unit2 = $uniti;
} 
else
{
$unit2 = $uniti1;
}
if($unit2 == "")
{
        $query = "select distinct(flockcode) as flock from breeder_flock WHERE client = '$client' and cullflag='0' ORDER BY flock ASC";
		}
		else
		{
		$query = "select distinct(flockcode) as flock from breeder_flock WHERE client = '$client' and unitcode = '$unit2' and cullflag='0' and unitcode='$unit2' ORDER BY flock ASC";
		}
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
    <option value="<?php echo $row1['flock']; ?>" <?php if($j == 0){ ?> selected="selected" <?php } ?>><?php echo $row1['flock']; ?></option>
    <?php } ?>
  </select>    &nbsp;&nbsp;&nbsp;</td>
 
<td>
 <input type="button" value="Add Book Entry" onclick="bookentry();" />&nbsp;&nbsp;&nbsp;</td>
</tr>
</table>
				
			
				
				
			
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
				
					<thead>
						<tr>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>								</span>
								Date							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>								</span>
								Flock							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>								</span>
								Age							</th>
							<th scope="col" title="Consumed Items">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>								</span>
								Items							</th>
							<th scope="col" title="Consumed Quantity">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>								</span>
								Quantity							</th>
							<th scope="col" title="Hatch Eggs">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>								</span>
								Hatch Eggs							</th>
							<th scope="col" title="Hatch Eggs">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>								</span>
								Quantity							</th>
							
                                          <th>Actions</th>
						</tr>
					</thead>
					
					<tbody>
						

<?php

include "config.php"; 
if($unit2 == "")
{
$query2 = "SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = '0'  and client='$client' order by flockcode ASC";
}
else
{
$query2 = "SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = '0' and unitcode = '$unit2' and client='$client' order by flockcode ASC"; 
}
$result2 = mysql_query($query2,$conn);
while($row2 = mysql_fetch_assoc($result2))
{
	$query0 = "SELECT date2,flag,age FROM breeder_consumption WHERE flock = '$row2[flockcode]' AND client = '$client' ORDER BY date2 DESC LIMIT 1"; $result0 = mysql_query($query0,$conn);
	while($row0 = mysql_fetch_assoc($result0))
      { 
		$query1 = "SELECT distinct(flock),flag FROM breeder_consumption WHERE flock = '$row2[flockcode]' AND date2 = '$row0[date2]' AND client = '$client' ORDER BY flock ASC"; 
		$result1 = mysql_query($query1,$conn); 
		while($row1 = mysql_fetch_assoc($result1)) 
		{ 
			$i = 0; $citem="";$citemdesc=""; $cqty="";
			$query3 = "SELECT * FROM breeder_consumption WHERE flock = '$row2[flockcode]' AND date2 = '$row0[date2]' AND client = '$client' ORDER BY flock ASC"; $result3 = mysql_query($query3,$conn); 
			while($row3 = mysql_fetch_assoc($result3)) 
			{
				$i++;
				$citem .= $row3['itemcode']."/";
				$citemdesc .= $row3['itemdesc']."/";
				$tqty = round($row3['quantity'],2);
				$cqty .= $tqty."/";
				if($i%3 == 0)
				{
					$citem.= "<br/>";
					$cqty.= "<br/>";
				}

			}
		}
 $k = 0; $heitem="";$heitemdesc=""; $heqty="";
 $j = 0; $pitem="";$pitemdesc=""; $pqty="";
		$query5 = "SELECT itemcode FROM breeder_production WHERE flock = '$row2[flockcode]' AND date1 = '$row0[date2]' AND client = '$client' ORDER BY itemcode ASC"; $result5 = mysql_query($query5,$conn); 
		while($row5 = mysql_fetch_assoc($result5)) 
		{ 					
			$query6 = "SELECT * FROM ims_itemcodes WHERE code='$row5[itemcode]' AND cat LIKE '%Eggs%' ORDER BY code ASC"; $result6 = mysql_query($query6,$conn); 
			while($row6 = mysql_fetch_assoc($result6)) 
			{  
				/*if($row6['cat'] == "Hatch Eggs")
				{  
					$query4 = "SELECT * FROM breeder_production WHERE itemcode ='$row6[code]' AND flock = '$row2[flockcode]' AND date1 = '$row0[date2]' AND client = '$client' ORDER BY flock ASC"; $result4 = mysql_query($query4,$conn); 
					while($row4 = mysql_fetch_assoc($result4)) 
					{
						$k++;
						$heitem .= $row4['itemcode']."/";
						$heitemdesc .= $row4['itemdesc']."/";
						$heqty .= $row4['quantity']."/";
						if($k%3 == 0)
						{
							$heitem.= "<br/>";
							$heqty.= "<br/>";
						} 
					} 
				}
 				else
				{ 
					$query4 = "SELECT * FROM breeder_production WHERE itemcode ='$row6[code]' AND flock = '$row2[flockcode]' AND date1 = '$row0[date2]' AND client = '$client' ORDER BY flock ASC"; $result4 = mysql_query($query4,$conn); 
					while($row4 = mysql_fetch_assoc($result4)) 
					{
						$j++;
						$pitem .= $row4['itemcode']."/";
						$pitemdesc .= $row4['itemdesc']."/";
						$pqty .= $row4['quantity']."/";
						if($j%3 == 0)
						{
							$pitem.= "<br/>";
							$pqty.= "<br/>";
						}
					}
				}*/
				
				if($row6['cat'] == "Hatch Eggs")
				{  
					$query4 = "SELECT * FROM breeder_production WHERE itemcode ='$row6[code]' AND flock = '$row2[flockcode]' AND date1 = '$row0[date2]' AND client = '$client' ORDER BY flock ASC"; $result4 = mysql_query($query4,$conn); 
					while($row4 = mysql_fetch_assoc($result4)) 
					{
						$k++;
						$heitem .= $row4['itemcode']."/";
						$heitemdesc .= $row4['itemdesc']."/";
						$heqty .= $row4['quantity']."/";
						if($k%3 == 0)
						{
							$heitem.= "<br/>";
							$heqty.= "<br/>";
						} 
					} 
				}
 				else
				{ 
					$query4 = "SELECT * FROM breeder_production WHERE itemcode ='$row6[code]' AND flock = '$row2[flockcode]' AND date1 = '$row0[date2]' AND client = '$client' ORDER BY flock ASC"; $result4 = mysql_query($query4,$conn); 
					while($row4 = mysql_fetch_assoc($result4)) 
					{
						/*$j++;
						$pitem .= $row4['itemcode']."/";
						$pitemdesc .= $row4['itemdesc']."/";
						$pqty .= $row4['quantity']."/";
						if($j%3 == 0)
						{
							$pitem.= "<br/>";
							$pqty.= "<br/>";
						}*/
						
						$k++;
						$heitem .= $row4['itemcode']."/";
						$heitemdesc .= $row4['itemdesc']."/";
						$heqty .= $row4['quantity']."/";
						if($k%3 == 0)
						{
							$heitem.= "<br/>";
							$heqty.= "<br/>";
						} 
					}
				}
				
				
			}
		}
		
		
           $test = "<br/>"; 
           strlen($test);
           $m = substr_count($citem,$test);
           if($m == 1)
           {
                    $citem = substr($citem,0,-6);
			  $citemdesc = substr($citemdesc,0,-1);
			  $cqty = substr($cqty,0,-6);

 			  $heitem = substr($heitem,0,-1);
			  $heitemdesc = substr($heitemdesc,0,-1);
			  $heqty = substr($heqty,0,-1);

 			  $pitem = substr($pitem,0,-1);
			  $pitemdesc = substr($pitemdesc,0,-1);
			  $pqty = substr($pqty,0,-1);

           }
           else
           {
              $citem = substr($citem,0,-1);
			  $citemdesc = substr($citemdesc,0,-1);
			  $cqty = substr($cqty,0,-1);    

 			  $heitem = substr($heitem,0,-1);
			  $heitemdesc = substr($heitemdesc,0,-1);
			  $heqty = substr($heqty,0,-1); 

 			  $pitem = substr($pitem,0,-1);
			  $pitemdesc = substr($pitemdesc,0,-1);
			  $pqty = substr($pqty,0,-1);
           }


            if($pitem == "") { $pitem = "Not Started"; $pqty=0; }
            if($heitem == "") { $heitem = "Not Started"; $heqty=0; }
?>
         <tr>
            <td><?php echo date("d.m.Y",strtotime($row0['date2'])); ?></td>
			 <td><?php echo $row2['flockcode']; ?></td>
			 <?php  ?><?php ?>
            <td><?php echo round(($row0['age']/7)).".".round(($row0['age']%7));?></td>
			
            <td title="<?php echo $citemdesc; ?>"><?php echo $citem; ?></td>
            <td><?php echo $cqty; ?></td>
            <td title="<?php echo $heitemdesc; ?>"><?php echo $heitem; ?></td>
            <td><?php echo $heqty; ?></td>
           
            <td>

<a href="dashboardsub.php?page=breeder_editdailyentry&flock=<?php echo $row2['flockcode']; ?>&date=<?php echo $row0['date2']; ?>">
			<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
<a onclick="if(confirm('Are you sure,want to delete')) document.location ='breeder_deletedailyentry.php?flock=<?php echo $row2['flockcode']; ?>&date=<?php echo $row0['date2']; ?>'">
<img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>
<a target="new" href="dashboardsub.php?page=breeder_detaildailyentry&flock=<?php echo $row2['flockcode']; ?>">
<img src="images/icons/fugue/open.png" style="border:0px" title="View Entry Details" /></a></td>
         </tr>
<?php 
$citem=""; $citemdesc=""; $cqty="";
$heitem=""; $heitemdesc=""; $heqty="";
$pitem=""; $pitemdesc=""; $pqty="";
?>
<?php } ?> 
<?php } ?> 
</tbody>
</table>
</form></div>
</section>
<div class="clear"></div>
</article>
<script type="text/javascript">
function bookentry()
{
var flock = document.getElementById('flock').value;
document.location='dashboardsub.php?page=breeder_bookentry&flock=' + flock,"_Top"; 
}

function reloadpage()
{
var unit = document.getElementById('unit').value;
document.location = "dashboardsub.php?page=breeder_dailyentry&unit=" + unit ;
}
function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
}
</script>

