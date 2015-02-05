<?php include "jquery.php";
      include "config.php"; 
?>
<script type="text/javascript">
		$(document).ready(function()
		{
			$('.sortable').each(function(i)
			{
				var table = $(this),
					oTable = table.dataTable({

						aoColumns: [

							{ sType: 'eu_date',asSorting: [ "desc" ] },
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
<center>
<br />
<h1>Current Currency</h1> 
<br /><br /><br />
<form method="post" action="hr_savecurrentcurrency.php">
<table align="center">
<?php
$query = "SELECT * FROM bccurrency";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$bcountry = $rows['bcountry'];
$bcurrency = $rows['bcurrency'];
$ccountry = $rows['ccountry'];
$ccurrency = $rows['ccurrency'];
?>
<tr>
<td align="right"><strong>Current Currency&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select id="ccurrency" name="ccurrency">
<?php
$q = "SELECT country,currency FROM currency ORDER BY country";
$r = mysql_query($q,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($r))
{
 ?>
 <option value="<?php echo $rows['country'].'@'.$rows['currency']; ?>" title="<?php echo $rows['country']; ?>" <?php if($ccurrency == $rows['currency']) { ?> selected="selected" <?php } ?>><?php echo $rows['currency']; ?></option>
 <?php
}
?>
</select>
<input type="hidden" id="bcountry" name="bcountry" value="<?php echo $bcountry; ?>" />
<input type="hidden" id="bcurrency" name="bcurrency" value="<?php echo $bcurrency; ?>" />
</td>
</tr>
</table>
<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" id="report" value="Save"/>
</form>
</center>



<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Current Currency</h1>
<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr>
<th  style="text-align:center">Current Country</th>
<th  style="text-align:center">Current Currency</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
         <tr>
		    <td><?php echo $ccountry; ?></td>
            <td><?php echo $ccurrency; ?></td>
            <td></td>
         </tr>
</tbody>
</table>
</form>
</div>
</section>

<script type="text/javascript">

</script>
</style>
<script type="text/javascript">
function script1() {
window.open('GLHelp/help_m_basecurrency.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
}
</script>


	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>