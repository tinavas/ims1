<?php include "config.php"; ?>

<?php include "jquery.php" ?>

<?php $category = $_GET['cat']; ?>

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
<button type="button" onClick="document.location='dashboardsub.php?page=tally_itemmasters'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Import</button> 
<button type="button" onClick="document.location='dashboardsub.php?page=ims_additemcodes'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>

		</div>

			

	</div></div>



<section class="grid_12">

<div class="block-border">

<form class="block-content form" id="table_form" method="post" action="">

<h1>Item Codes</h1>



<table align="center">

 <tr>

  <td><strong>Category</strong>&nbsp;&nbsp;</td>

  <td><select name="cat" id="cat" tabindex="2" onchange="reloadpage();" >

      

	   <?php 

	   $q = "select distinct(cat) from ims_itemcodes where client = '$client' order by cat ";

	   $r = mysql_query($q,$conn) or die(mysql_error());

	   while($qr = mysql_fetch_assoc($r))

	   {

	  

	

?>

<option value="<?php echo $qr['cat']; ?>" <?php if($category == $qr['cat']){  ?> selected="selected" <?php }?> ><?php echo $qr['cat']; ?></option>

<?php } ?>

</select>

&nbsp;&nbsp;&nbsp;

</td>

  

</tr>

</table>

<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">

<thead>

<tr>

<th style="text-align:left"><span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span>Category</th>

<th style="text-align:left"><span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span>Code</th>

<th style="text-align:left"><span class="column-sort">

									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>

									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>

								</span>Description</th> 

<th style="text-align:left"> Units Of Measure</th>


<th style="text-align:left">Actions</th>

<!--<th style="text-align:left">Vendor</th>-->

</tr>

</thead>

<tbody>

	  <?php

           include "config.php"; 

		   

		   if($category == "")

		   {

		   $q1 = "select distinct(cat) from ims_itemcodes where client = '$client' order by cat LIMIT 1 ";

			$result = mysql_query($q1,$conn); 

           while($row1 = mysql_fetch_assoc($result))

           {

		  $category = $row1['cat'];

		   }

		   }

	  

	       $query = "SELECT * FROM ims_itemcodes where cat = '$category' ORDER BY id ASC";

           $result = mysql_query($query,$conn); 

           while($row1 = mysql_fetch_assoc($result))

           {

           ?>

            <tr>

			 <td><?php echo $row1['cat']; ?></td>

             <td><?php echo $row1['code']; ?></td>

             <td><?php echo $row1['description']; ?></td>

             <td><?php echo $row1['sunits']; ?></td>

	
			<td>
            <?php $qr="select distinct(itemcode) from ac_financialpostings where itemcode='$row1[code]'";
			$r=mysql_query($qr);
			$n=mysql_num_rows($r);
			
			if($n==0)
			{?>

			<a href="dashboardsub.php?page=ims_edititemcodes&id=<?php echo $row1['id']; ?>"><img src="images/icons/fugue/pencil.png" height="16px" width="16px"  style="border:0px" title="Edit"/></a>&nbsp;&nbsp;

			<a href="dashboardsub.php?page=ims_viewitemcodes&id=<?php echo $row1['id']; ?>"  class="nyroModal"><img src="images/icons/fugue/open.png" height="16px" width="16px" title="view"  border="0px" /></a>&nbsp;&nbsp;

			<a onclick="if(confirm('Are you sure,want to delete')) document.location ='ims_deleteitemcodes.php?id=<?php echo $row1['id']; ?>&code=<?php echo $row1['code']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" height="16px" width="16px" title="Delete" /></a>

			</td>


           </tr>

           <?php }
		   else
		   {?>
		   <img src="images/icons/fugue/lock.png" height="16px" width="16px" title="view"  border="0px" />
		   <?php }

           }

           ?>   

                                   

</tbody>

</table>

</form>

</div>

</section>



<script type="text/javascript">

function reloadpage()

{

var cat = document.getElementById('cat').value;



document.location = "dashboardsub.php?page=ims_itemcodes&cat="+cat ;

}

</script>

