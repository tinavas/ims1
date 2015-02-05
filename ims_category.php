<?php include "getemployee.php"; ?>
<script type="text/javascript" src="dataTables.dateFormat.js"></script>
<script type="text/javascript">
		$(document).ready(function()
		{
		
			$('.favorites li').bind('contextMenu', function(event, list)
			{
				var li = $(this);
				
				if (li.prev().length > 0)
				{
					list.push({ text: 'Move up', link:'#', icon:'up' });
				}
				if (li.next().length > 0)
				{
					list.push({ text: 'Move down', link:'#', icon:'down' });
				}
				list.push(false);	// Separator
				list.push({ text: 'Delete', link:'#', icon:'delete' });
				list.push({ text: 'Edit', link:'#', icon:'edit' });
			});
			
			$('.favorites li:first').bind('contextMenu', function(event, list)
			{
				list.push(false);	// Separator
				list.push({ text: 'Settings', icon:'terminal', link:'#', subs:[
					{ text: 'General settings', link: '#', icon: 'blog' },
					{ text: 'System settings', link: '#', icon: 'server' },
					{ text: 'Website settings', link: '#', icon: 'network' }
				] });
			});
			
		
			$.fn.dataTableExt.oStdClasses.sWrapper = 'no-margin last-child';
			$.fn.dataTableExt.oStdClasses.sInfo = 'message no-margin';
			$.fn.dataTableExt.oStdClasses.sLength = 'float-left';
			$.fn.dataTableExt.oStdClasses.sFilter = 'float-right';
			$.fn.dataTableExt.oStdClasses.sPaging = 'sub-hover paging_';
			$.fn.dataTableExt.oStdClasses.sPagePrevEnabled = 'control-prev';
			$.fn.dataTableExt.oStdClasses.sPagePrevDisabled = 'control-prev disabled';
			$.fn.dataTableExt.oStdClasses.sPageNextEnabled = 'control-next';
			$.fn.dataTableExt.oStdClasses.sPageNextDisabled = 'control-next disabled';
			$.fn.dataTableExt.oStdClasses.sPageFirst = 'control-first';
			$.fn.dataTableExt.oStdClasses.sPagePrevious = 'control-prev';
			$.fn.dataTableExt.oStdClasses.sPageNext = 'control-next';
			$.fn.dataTableExt.oStdClasses.sPageLast = 'control-last';
			
					
			$('.sortable').each(function(i)
			{
				var table = $(this),
					oTable = table.dataTable({

						aoColumns: [

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
			<button type="button" onClick="document.location='dashboardsub.php?page=ims_addcategory'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<!--<button type="button" class="grey">View</button> -->
			<!-- <button type="button" disabled="disabled">Disabled</button> -->
			<!--<button type="button" class="red">Authorize</button> -->


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Item Category</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Category</th>
								<th>Actions</th>
</tr>
</thead>
<tbody>

<?php
           include "config.php";
   	       $query = "SELECT id,type FROM ims_itemtypes where client = '$client' ORDER BY type";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
           ?>
     		<tr>
             <td><?php echo $row1['type']; ?></td>
			 <?php
			 $q2 = "SELECT code FROM ims_itemcodes WHERE cat = '$row1[type]' AND client = '$client'";
			 $r2 = mysql_query($q2,$conn) or die(mysql_error());
			 $rows = mysql_num_rows($r2);
			 if($rows == 0) { ?>
			 <td><a href="dashboardsub.php?page=ims_editcategory&id=<?php echo $row1['id']; ?>&category=<?php echo $row1['type']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
			 <a onclick="if(confirm('Do you really want to delete this row?')) document.location='ims_deletecategory.php?id=<?php echo $row1['id']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>
			 </td>
			 <?php } else { ?>
			 <td><img src="images/icons/fugue/lock.png" style="border:0px" title="Item Codes Generated"/></td>
			 <?php } ?>
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



