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
			<button type="button" onClick="document.location='dashboardsub.php?page=common_addprofitcenter'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			 


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Profit Center- Cost Center Mapping</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >

<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Profit Center</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Cost Center</th>
								<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Input Category</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Output Category</th>
<th style="text-align:center">Actions</th>
</tr>
</thead>
<tbody>
	 <?php
           include "config.php";
		    $query = "SELECT distinct(tid),profitcenter FROM tbl_profitcenter group by tid";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {  
		  
              $icat = "";$ocat=""; $costcenter = "";
              $query2 = "SELECT distinct(inputcat),outputcat FROM tbl_profitcenter where tid = '$row1[tid]'";
              $result2 = mysql_query($query2,$conn); 
              while($row2 = mysql_fetch_assoc($result2))
              {  
                 $icat = $icat . "/" . $row2['inputcat'];
				 $ocat = $ocat . "/" . $row2['outputcat'];
              }
			  $icat = substr($icat,1);
			  $ocat = substr($ocat,1);
              $query2 = "SELECT distinct(costcenter) FROM tbl_profitcenter where tid = '$row1[tid]'";
              $result2 = mysql_query($query2,$conn); 
              while($row2 = mysql_fetch_assoc($result2))
                 $costcenter .= $row2['costcenter']."/";
			  $costcenter = substr($costcenter,0,-1);
           
           ?>
            <tr>		
			 <td><?php echo $row1['profitcenter']; ?></td>
			 <td><?php echo $costcenter; ?></td>	
			 <td><?php echo $icat; ?></td>
			 <td><?php echo $ocat; ?></td>		 
              <td>

<a href="dashboardsub.php?page=common_editprofitcenter&id=<?php echo $row1['id']; ?>&tid=<?php echo $row1['tid'];?>">
<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" />
</a>&nbsp;

			<a href="<?php echo 'common_deleteprofitcenter.php?id='.$row1['id']; ?>">
			 			 
			 <img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" />
			 </a>&nbsp;


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
document.location = "dashboardsub.php?page=chicken_dailyrates&month=" + month + "&year=" + year;
}
</script>





