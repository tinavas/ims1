<?php 
   include "jquery.php";  
   
   	include "distribution_getsuperstockist_singh.php";
     
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
			<button type="button" onClick="document.location='dashboardsub.php?page=distribution_addarea'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16">Add</button> 
			
			
			


		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1>Area Details</h1>
                <div align="center">
               <strong>State</strong> <select name="state" id="state" onchange="reloadpage()">
               <option value="">-Select-</option>
                
                <?php
				
				if($_GET['state']<>"")
				{
				  $state=$_GET['state'];
				}
				else
				{
				   $q1="select state from contactdetails where name in ($authorizedsuperstockistlist) order by state limit 1";
				
				   $q1=mysql_query($q1) or die(mysql_error());
				
				   $r1=mysql_fetch_assoc($q1);
				   
				   $state=$r1['state'];
				 
				
				}
				
				
				$q1="select distinct(state) as state from contactdetails where name in ($authorizedsuperstockistlist) order by state";
				
				$q1=mysql_query($q1) or die(mysql_error());
				
				while($r1=mysql_fetch_assoc($q1))
				{
				?>
                
                <option value="<?php echo $r1['state'];?>" <?php if($r1['state']==$state){?> selected="selected" <?php }?>><?php echo $r1['state'];?></option>
                
                <?php }?>
                
                
                </select>
			</div>
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Area code</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Area Name</th> 
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>CNF/Stockist</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>State</th>
                                
                                <th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>District</th>
                                
<th>Actions</th>
</tr>
</thead>
<tbody>
	 
    <?php
	

	
	
	  
	  $q1=mysql_query("set group_concat_max_len=10000000000");
	  
	  $q1="select group_concat(areacode separator '$') as codes from distribution_distributor ";
	  
	  $q1=mysql_query($q1) or die(mysql_error());
	  
	  $r1=mysql_fetch_assoc($q1);
	  
	  $allcodes1=explode("$",$r1['codes']);
	  
	  $q1="select group_concat(distinct areacode separator '$') as codes from distribution_salesman ";
	  
	  $q1=mysql_query($q1) or die(mysql_error());
	  
	  $r1=mysql_fetch_assoc($q1);
	  
	  $allcodes2=explode("$",$r1['codes']);
	  
	  $allcodes=array_merge($allcodes1,$allcodes2);
	  
	  
	  $q1="select * from distribution_area where superstockist in ($authorizedsuperstockistlist) and state='$state' order by areacode";
	 
	 $q1=mysql_query($q1) or die(mysql_error());
	 
	 while($r1=mysql_fetch_assoc($q1))
	 {
	 ?>
     <tr>
     <td><?php echo $r1['areacode'];?></td>
     
      <td><?php echo $r1['areaname'];?></td>
      
       <td><?php echo $r1['superstockist'];?></td>
       
        <td><?php echo $r1['state'];?></td>
        
        
        <td><?php echo $r1['district'];?></td>
        
        <?php
		
		if(!in_array($r1['areacode'],$allcodes))
		{
		?>
        
         <td>
         <a href="dashboardsub.php?page=distribution_editarea&id=<?php echo $r1['id'];?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;&nbsp;
         <a onclick="if(confirm('Are you sure,want to delete'))document.location='dashboardsub.php?page=distribution_deletearea&id=<?php echo $r1['id'];?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px;" title="Delete" /></a></td>
         <?php } else {?>
         
         
         <td><img src="images/icons/fugue/lock.png"></td>
         
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
var state=document.getElementById("state").value;

document.location="dashboardsub.php?page=distribution_area&state="+state;

}
</script>
