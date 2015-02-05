<?php include "jquery.php"; ?>
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
			<button type="button" onclick="document.location='dashboardsub.php?page=common_sendmessage';"><img src="images/icons/fugue/tick-circle.png" width="16" height="16">New Message</button>
		</div>
			
	</div></div>
	
	<article class="container_12">
		

		
		
		<div class="clear"></div>
		

		<div class="clear"></div>
		

		
		<section class="grid_12">
			<div class="block-border"><form class="block-content form" id="table_form" method="post" action="">
				<h1><?php if($_GET['id'] == "toname") { ?>Received Messages<?php } else { ?>Sent Messages<?php } ?></h1>
			
				<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
				
					<thead>
						<tr>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Date
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								<?php if($_GET['id']== "toname") { ?> From <?php } else { ?> To <?php } ?>
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Title
							</th>
							<th scope="col">
								<span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>
								Message
							</th>
		
                                          <th>Actions</th>
						</tr>
					</thead>
					
					<tbody>
						

<?php 
     include "config.php"; session_start(); $user = $_SESSION['valid_user'];
	
	 $query = "update common_messages set starus = 1 where toname = '$user'";
	 $result1 = mysql_query($query,$conn); 
	
     if($_GET['id'] == "toname")
       $query1 = "SELECT * FROM common_messages where $_GET[id] = '$user' and receivedflag = 1"; 
     else
       $query1 = "SELECT * FROM common_messages where $_GET[id] = '$user' and sentflag = 1"; 
     $result1 = mysql_query($query1,$conn); 
     while($row1 = mysql_fetch_assoc($result1)) 
     { 
?>
         <tr>
            <td><?php echo date("d.m.Y",strtotime($row1['date'])); ?></td>
            <td><?php if($_GET['id'] == "toname") {  echo $row1['fromname']; } else { echo $row1['toname']; } ?> </td>
            <td><?php echo $row1['title']; ?></td>
            <td><?php echo $row1['message']; ?></td>
            <td>
              <a href="common_deletemessage.php?id=<?php echo $row1['id']; ?>&col=<?php echo $_GET['id']; ?>&name=<?php echo "common_messages"; ?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>
            </td>
         </tr>
<?php }  ?> 

						
					</tbody>
				
				</table>
					
			</form></div>
		</section>
		
		
		<div class="clear"></div>
		
	</article>

