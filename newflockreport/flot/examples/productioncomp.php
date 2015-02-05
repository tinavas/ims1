<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Performance Graphs</title>
    <link href="layout.css" rel="stylesheet" type="text/css"></link>
    <!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="../jquery.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.dashes.js"></script>
	
      <link href="css/common.css" rel="stylesheet" type="text/css">
	<link href="css/standard.css" rel="stylesheet" type="text/css">


 </head>
    <body>
   <?php include "reportheader.php"; ?><br /><br />

<iframe id="new" allowtransparency="true" style="overflow: auto;" name=new  src="production1.php?flock=<?php echo $_GET['flock1']; ?>&unit=<?php echo $_GET['unit1']; ?>" width=100% height=600px
                   border-width:0px;? ;   
                  frameborder="0"> </iframe>



  <iframe id="new" allowtransparency="true" style="overflow: auto;" name=new  src="production1.php?flock=<?php echo $_GET['flock2']; ?>&unit=<?php echo $_GET['unit2']; ?>" width=100% height=800px
                   border-width:0px;? ;   
                  frameborder="0"> </iframe>
</body>
</html>