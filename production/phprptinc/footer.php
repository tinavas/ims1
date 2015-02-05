<?php //if (@$sExport == "") 
{ ?>
			<!-- right column (end) -->
		</td></tr>
		<tr><td><div align="center" id="loadingpage"></div></td></tr>
	</table>
	<!-- content (end) -->
	<!-- footer (begin) --><!-- *** Note: Only licensed users are allowed to remove or change the following copyright statement. *** -->
		<div>
<br />
	<br />
	<div align="center" style=" color:#339933">&copy;Powered By Tulasi Technologies Pvt Ltd.</div>
	</div>
<script type="text/javascript">
<!--
//xGetElementsByClassName(EW_REPORT_TABLE_CLASS, null, "TABLE", ewrpt_SetupTable); // init the table

//-->
</script>
<?php } ?>
<?php
list($time_end_msec, $time_end_sec) = explode(" ", microtime());
$diff=$time_end_sec-$time_start_sec;
$diffm=$time_end_msec-$time_start_msec;
if($diffm<0) {$diff--;  echo "<script> var sec=$diff;var msec=".substr($diffm,1).' </script>' ;}
else echo "<script> var sec=$diff;var msec=$diffm;".' </script>' ;
?>
<!--<div align="center" id="loadingpage"></div>-->
</body>
</html>
