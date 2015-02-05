<?php include "jquery.php" ?>
	<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	
		<div class="float-left">
			<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button> 
			<button type="button" onClick="openModal()">Open report</button>
		</div>
		
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboard.php?page=hr_addemployee'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<button type="button" class="grey">View</button> 
			<!-- <button type="button" disabled="disabled">Disabled</button> -->
			<button type="button" class="red">Authorize</button> 
		</div>
	</div></div>

<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Employees List</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Name</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Designation</th> 
<th style="text-align:left">Personal Contact</th>
<th style="text-align:left">Company Contact</th>
<th style="text-align:left">Image</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php"; 
           $query = "SELECT * FROM hr_employee ORDER BY name ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
              
           ?>
            <tr>
             <td><?php echo $row1['name']; ?></td>
             <td><?php echo $row1['designation']; ?></td>
             <td><?php echo $row1['personalcontact']; ?></td>
             <td><?php echo $row1['companycontact']; ?></td>
			 <td><a href="employeeimages/reduced/<?php echo $row1['image']; ?>">
			 <img src="employeeimages/thumbnails/<?php echo $row1['image']; ?>" width="50px" height="50px" border="0px" /></a>
			</td>
           	<td>
			<a href="dashboard.php?page=hr_editemployee&id=<?php echo $row1['employeeid']; ?>">
			<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
			<a href="hr_deleteemployee.php?id=<?php echo $row1['employeeid']; ?>">
			<img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>
			<a href="hr_printemp.php?id=<?php echo $row1['employeeid']; ?>" target="_new">
			<img src="images/icons/fugue/report.png" style="border:0px" title="Print" /></a>
			<a href="dashboard.php?page=hr_leaves&id=<?php echo $row1['employeeid']; ?>">
			<img src="images/icons/fugue/home.png" style="border:0px" title="Leave" /></a>
			<a href="dashboard.php?page=hr_editemployeeimage&id=<?php echo $row1['employeeid']; ?>">
			<img src="images/icons/fugue/image.png" style="border:0px" title="Edit Image" />
			</a>
			
			<a href="dashboard.php?page=<?php if($row1['releaved'] == '0') echo "hr_relieving"; else echo "hr_rejoining";?>&id=<?php echo $row1['employeeid']; ?>">
			<img src="images/icons/fugue/<?php if($row1['releaved'] == '0') echo "control-power"; else echo "control";?>.png" style="border:0px" title="<?php if($row1['releaved'] == '0') echo "Relieve"; else echo "Rejoin";?>" />
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



