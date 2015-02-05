<?php 
$query12 = "SELECT min(fdate) as fdate,max(tdate) as tdate FROM ac_definefy";
$result12 = mysql_query($query12,$conn) or die(mysql_error());
while($rows12 = mysql_fetch_assoc($result12))
{
$fdate = $rows12['fdate'];
$fyear = date("Y", strtotime($fdate));
$tdate = $rows12['tdate'];
$tyear = date("Y", strtotime($tdate));
}
?>

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

			

			



	          <?php 
$query = "SELECT type,fromdate,todate,empname,days FROM dataentry_daterange  WHERE module <> 'Others'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{

  $days=$rows['days']-1;

  $qry12="select date_sub(curdate(),interval $days day)as fromdate,curdate()as todate ";
					   $res12=mysql_query($qry12,$conn) or die(mysql_error());
					  while( $row12=mysql_fetch_assoc($res12))
					    { 
						
						$fromdate = date("d.m.Y",strtotime($row12['fromdate']));
                        $todate = date("d.m.Y",strtotime($row12['todate']));

						
						?>
		  
		        $(function() {
		           $( ".datepicker<?php echo $rows[type]; ?>" ).datepicker(
					{
					
					 
					
					  minDate: '<?php echo $fromdate; ?>',
					  maxDate: '<?php echo $todate; ?>'
					}
			
				   );
		           $( ".datepicker<?php echo $rows[type]; ?>" ).attr("readonly",true);
	            });
<?php } } ?>
<?php 
$query = "SELECT type,fromdate,todate,empname FROM dataentry_daterange  WHERE module = 'Others'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$fromdate = date("d.m.Y",strtotime($rows['fromdate']));
$todate = date("d.m.Y",strtotime($rows['todate']));
?>
				
	            $(function() {
		           $( ".datepicker" ).datepicker(
					{ 
					}
			
				   );
		           $( ".datepicker" ).attr("readonly",true);
	            });

	            $(function() {
		           $( ".datepickerreport" ).datepicker();
	            });
				 $(function() {
		           $( ".datepickerdob" ).datepicker();
	            });




				});
		

		


		function openModal()

		{

			$.modal({

				content: '<p>Sample Report</p>',

				title: 'Purchases Report',

				maxWidth: 500,

				buttons: {

					'Print': function(win) { openModal(); },

					'Close': function(win) { win.closeModal(); }

				}

			});

		}

	

	</script>
    
<!--<script type="text/javascript" src="dataTables.dateFormat.js"></script>
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
			
			

	            $(function() {
		           $( ".datepicker" ).datepicker();
	            });
		});
		
		function openModal()
		{
			$.modal({
				content: '<p>Sample Report</p>',
				title: 'Purchases Report',
				maxWidth: 500,
				buttons: {
					'Print': function(win) { openModal(); },
					'Close': function(win) { win.closeModal(); }
				}
			});
		}
	
	</script>-->

