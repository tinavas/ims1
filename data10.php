<?php
	$fdate=date('Y-m-d',strtottime($_GET['fdate']));
	$tdate=date('Y-m-d',strtottime($_GET['tdate']));
?>
<link href="layout.css" rel="stylesheet" type="text/css"></link>
      <link href="css/common.css" rel="stylesheet" type="text/css">
	  <link href="css/standard.css" rel="stylesheet" type="text/css">
<iframe src="Flot Pie Chart/salesbargraph.php?fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>" align="right" height="700" width="610"  frameborder="0"  ></iframe>

