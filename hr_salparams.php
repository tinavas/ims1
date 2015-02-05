<?php include "jquery.php" ?>

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

			<button type="button" onClick="document.location='dashboardsub.php?page=hr_addsalparams'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>

			



		</div>

			

	</div></div>





<section class="grid_12">

<div class="block-border">

<form class="block-content form" id="table_form" method="post" action="">

<h1>Define Salary Parameters</h1>

<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">

<thead>

<tr>

<th style="text-align:center">Code<span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span></th>

<th style="text-align:center">Description<span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span></th>

<th style="text-align:center">Unit<span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span></th> 

<th style="text-align:center">Basis<span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span></th>


<th style="text-align:center">Default<span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span></th>

<th style="text-align:center">Type<span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span></th>

<th>Actions</th>

</tr>

</thead>

<tbody>

	  <?php

           include "config.php"; 

           $query = "SELECT * FROM hr_params ORDER BY description ";

           $result = mysql_query($query,$conn); 

           while($row1 = mysql_fetch_assoc($result))

           {

              

           ?>

            <tr>

             <td><?php echo $row1['code']; ?></td>

             <td><?php echo $row1['description']; ?></td>

             <td><?php echo $row1['unit']; ?></td>

             <td><?php echo $row1['basis']; ?></td>

             

             <td><?php echo $row1['defaultval']; ?></td>

			 <td><?php echo $row1['type']; ?></td>

           	<td>
 
			<?php $c1=0;
			$query1 = "SELECT count(*) as c1 FROM hr_salary_parameters where `$row1[code]` !='0'";

           $result1 = mysql_query($query1,$conn); 

           while($row = mysql_fetch_assoc($result1))

           {

		    $c1 = $row['c1'];

		   }

		   

		   if($c1 == 0 )

		   {

			?>

			<a href="dashboardsub.php?page=hr_editsalparams&id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;&nbsp;&nbsp;

			<?php if($row1['description'] != 'ProfessionalTax')

			{?>

			<a href="hr_deletesalparams.php?id=<?php echo $row1['id']; ?>&par=<?php echo $row1['description'];?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;

			

			<?php }}

			else if($c1 >0)

			{

			?>

          <img src="images/icons/fugue/lock.png" style="border:0px; width:20px; height:20px;" title="Cannot be edited/deleted" />&nbsp;

			<?php }

			?></td>

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







