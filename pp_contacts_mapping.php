<?php include "jquery.php";
      include "getemployee.php";
      include "config.php";
?>
<style>
div.pagination {
	padding: 3px;
	margin: 3px;
}

div.pagination a {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #AAAADD;
	text-decoration: none; 
	color: #0784DC;
	font-weight: bold;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #0784DC;
	color: #000;
}
div.pagination span.current {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #0784DC;
	font-weight: bold;
	background-color: #0784DC;
	color: #FFF;
	}
	div.pagination span.disabled {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #EEE;
		color: #DDD;
	}
	
</style>
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
			<button type="button" onClick="document.location='dashboardsub.php?page=pp_addcontacts_mapping'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<!--<button type="button" class="grey">View</button> -->
			 <!--<button type="button" disabled="disabled">Disabled</button> -->
			


		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Software - Tally Contacts Mapping</h1>
<?php 
$startletter = $_GET['startletter'];
if($startletter == "")
 $startletter = 'A';

$letters = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");  
?>
<center>
<div class="pagination">
<?php
for ($counter = 0; $counter < count($letters); $counter++)
			{
				if ($letters[$counter] == $startletter)
					$pagination.= "<span class=\"current\">$letters[$counter]</span>";
				else
					$pagination.= "<a href=\"dashboardsub.php?page=pp_contacts_mapping&startletter=$letters[$counter]\">$letters[$counter]</a>";					
			}
			echo $pagination;
if($startletter == "ALL")
{ $cond = ""
?>
<span class="current">ALL</span>
<?php } else { 
$cond = "AND name LIKE '$startletter%'";
?>
<a href="dashboardsub.php?page=pp_supplier&startletter=ALL">ALL</a>
<?php } ?>
</div>
</center>			
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Software Name</th><th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Tally Name</th> 

<th>Actions</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php"; 
           $query = "SELECT id,name,tally_name FROM contactdetails WHERE tally_name <> '' $cond ORDER BY name  ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {

           ?>
            <tr>
             <td><?php echo $row1['name']; ?></td>
             <td><?php echo $row1['tally_name']; ?></td>
             <td><a href="dashboardsub.php?page=pp_addcontacts_mapping&id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
			 &nbsp;
			 <?php if($cnt > 0) {?>
			 <img src="images/icons/fugue/lock.png" style="border:0px;" title="Cannot Delete" />
			 <?php } else {?>
			 <a href="pp_savecontacts_mapping.php?id=<?php echo $row1['id']; ?>&delete=1"><img src="images/icons/fugue/cross-circle.png" style="border:0px;" title="Delete" /></a>
			 <?php }?>
			 </td> 
            </tr>
           <?php 
           }
           ?>   
                                   
</tbody>

</table>
</form>
</div></section><br />
<center>


&nbsp;&nbsp; 
      </center>


