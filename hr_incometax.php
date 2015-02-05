<?php include "jquery.php" ?>
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
	<button type="button" onClick="document.location='dashboardsub.php?page=hr_addincometax'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
	</div>
	</div></div>
<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Income Tax Structure</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
	<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
	<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
	</span>From Date
</th>
<th style="text-align:left"><span class="column-sort">
	<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
	<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
	</span>To Date
</th>
<th style="text-align:left"><span class="column-sort">
	<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
	<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
	</span>From Salary
</th>
<th style="text-align:left"><span class="column-sort">
	<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
	<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
	</span>To Salary
</th>
<th style="text-align:left"><span class="column-sort">
	<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
	<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
	</span>Bal Amt Ded
</th>
<th style="text-align:left"><span class="column-sort">
	<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
	<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
	</span>Amount Exceeded
</th>
<th style="text-align:left"><span class="column-sort">
	<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
	<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
	</span>Deduction %
</th>
<th style="text-align:left">Actions</th>			 
</tr>
</thead>
<tbody>

	  <?php 
			include "config.php"; 
           $query = "SELECT * FROM hr_incometax ORDER BY  id ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           { ?>
              <tr>
            <td><?php echo date('d-m-Y',strtotime($row1['fromdate'])); ?></td>
			 <td><?php echo date('d-m-Y',strtotime($row1['todate'])); ?></td>
			 <td><?php echo $row1['fromsal']; ?></td>
             <td><?php echo $row1['tosal']; ?></td>
             <td><?php echo $row1['balamtded']; ?></td>
             <td><?php echo $row1['amtexceeded']; ?></td>
             <td><?php echo $row1['deductionper']; ?></td>
			 <?php
			 $f=explode("-",$row1['fromdate']);
			 $t=explode("-",$row1['todate']);
			$q="select date from hr_salary_payment where year1  in('$f[0]', '$t[0]') and month1 in( '$f[1]','$t[1]')";
			 $res=mysql_query($q,$conn);
			 $n=0;
			 $n=mysql_num_rows($res);
			 if($n>0)
			 {
			  ?>
			 <td>
			  
			<a href="dashboardsub.php?page=hr_editincometax&id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;
			<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Lock" />
</td>
<?php
}
else
{
?>
 <td>
<a href="dashboardsub.php?page=hr_editincometax&id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;
			<a href="hr_deleteincometax.php?id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;&nbsp;

			</td>
<?php
}
?>

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







