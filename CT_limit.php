<?php include "jquery.php";
      //include "getemployee.php";
      include "config.php";
	  
?> 
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
			

			$('.datepicker').datepick({
				alignment: 'bottom',
				showOtherMonths: true,
				selectOtherMonths: true,
				renderer: {
					picker: '<div class="datepick block-border clearfix form"><div class="mini-calendar clearfix">' +
							'{months}</div></div>',
					monthRow: '{months}', 
					month: '<div class="calendar-controls">' +
								'{monthHeader:M yyyy}' +
							'</div>' +
							'<table cellspacing="0">' +
								'<thead>{weekHeader}</thead>' +
								'<tbody>{weeks}</tbody></table>', 
					weekHeader: '<tr>{days}</tr>', 
					dayHeader: '<th>{day}</th>', 
					week: '<tr>{days}</tr>', 
					day: '<td>{day}</td>', 
					monthSelector: '.month', 
					daySelector: 'td', 
					rtlClass: 'rtl', 
					multiClass: 'multi', 
					defaultClass: 'default', 
					selectedClass: 'selected', 
					highlightedClass: 'highlight', 
					todayClass: 'today', 
					otherMonthClass: 'other-month', 
					weekendClass: 'week-end', 
					commandClass: 'calendar', 
					commandLinkClass: 'button',
					disabledClass: 'unavailable'
				}
			});
		});
		
	</script>

<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	<div class="float-right">
	<button type="button" onClick="document.location='dashboardsub.php?page=CT_add_limit'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>		
	</div>		
</div></div>
<article class="container_12">
	<div class="clear"></div>
		<div class="clear"></div>
<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Cash Transaction Limit</h1>
<table align="center">
<tr>

</tr>
</table>
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
		</span>Limit
	</th>
	
	<th>Actions</th>
</tr>
</thead>
<tbody>
	  <?php
	   // $date2=date("Y-m-d",strtotime($date1));
		
			$query="SELECT * FROM ct_limit";
		
		$result=mysql_query($query,$conn) or die(mysql_error());
		while($row1=mysql_fetch_assoc($result))
		{
			//$date=date('d.m.Y',strtotime($row1['date']));
      ?>
            <tr>
             
			
			 <td><?php echo date('d.m.Y',strtotime($row1['fromDate'])); ?></td>
			 <td><?php echo date('d.m.Y',strtotime($row1['toDate'])); ?></td>
			 <td><?php echo $row1['limit']; ?></td>
			 <td>
            
				<?php
					$q=mysql_query("SELECT * FROM ac_gl WHERE (voucher='P' OR voucher='R') AND date BETWEEN '".$row1['fromDate']."' AND '".$row1['toDate']."' AND controltype='Cash'");
					$re=mysql_num_rows($q);
					$q1=mysql_query("SELECT * FROM hr_payment WHERE date BETWEEN '".$row1['fromDate']."' AND '".$row1['toDate']."' AND paymode='Cash'");
					$re1=mysql_num_rows($q1);
					$q2=mysql_query("SELECT * FROM pp_payment WHERE date BETWEEN '".$row1['fromDate']."' AND '".$row1['toDate']."' AND paymentmode='Cash'");
					$re2=mysql_num_rows($q2);
					$q3=mysql_query("SELECT * FROM pp_payment WHERE date BETWEEN '".$row1['fromDate']."' AND '".$row1['toDate']."' AND paymentmode='Cash'");
					$re3=mysql_num_rows($q3);
					$q4=mysql_query("SELECT * FROM pp_receipt WHERE date BETWEEN '".$row1['fromDate']."' AND '".$row1['toDate']."' AND paymentmode='Cash'");
					$re4=mysql_num_rows($q4);
					$q5=mysql_query("SELECT * FROM oc_payment WHERE date BETWEEN '".$row1['fromDate']."' AND '".$row1['toDate']."' AND paymentmode='Cash'");
					$re5=mysql_num_rows($q5);
					$q6=mysql_query("SELECT * FROM oc_receipt WHERE date BETWEEN '".$row1['fromDate']."' AND '".$row1['toDate']."' AND paymentmode='Cash'");
					$re6=mysql_num_rows($q6);
					
					if($re!=0 || $re1!=0 || $re2!=0 || $re3!=0 || $re4!=0 || $re5!=0 || $re6!=0)
					{
				?>
                	<img src="images/icons/fugue/Lock.png" style="border:0px" title="Delete" />
              <?php
					}
					else
					{
				?>
                	<a onclick="if(confirm('Are you sure,want to delete')) document.location ='CT_delete_limit.php?id=<?php echo $row1['id']; ?>'">
                    	<img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" />
                     </a>
                <?php
					}
				?>
             
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

<script type="text/javascript">
function reloadpage()
{
var date1 = document.getElementById('date').value;

document.location = "dashboardsub.php?page=breeder_mortality&date1="+date1 ;
}
</script>

