

<?php
$start_process = (float) array_sum(explode(' ',microtime()));

session_start();
$userlogged = $_SESSION['valid_user'];
           include "config.php"; 
           $query1 = "SELECT * FROM common_useraccess where username= '$userlogged' ORDER BY username ASC ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
                $rights = $row11['view'];
           }
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Tulasi Technologies -S.M.O.C.trial</title>
	<meta charset="utf-8">
		<SCRIPT LANGUAGE="JavaScript">
NavName = navigator.appName.substring(0,3);
NavVersion = navigator.appVersion.substring(0,1);
if (NavName != "Mic" || NavVersion>=4)
	{
	entree = new Date;
	entree = entree.getTime();
	}

function calculateloadgingtime()
	{
	if (NavName != "Mic" || NavVersion>=4)
		{
		fin = new Date;
		fin = fin.getTime();
		secondes = (fin-entree)/1000;
		var exetime11 = document.getElementById("exetime1").value;
		secondes = parseFloat(secondes) + parseFloat(exetime11);
	    secondes =  secondes.toFixed(3);
		window.status='Page loaded in ' + secondes + ' seconde(s).';
		document.getElementById("loadgingpage").innerHTML = "(Page loaded in " + secondes + " second(s).)";
		}
	}
window.onload = calculateloadgingtime;

</SCRIPT>
	
	<link href="css/reset.css" rel="stylesheet" type="text/css">
      <link href="css/common.css" rel="stylesheet" type="text/css">
	<link href="css/form.css" rel="stylesheet" type="text/css">
	<link href="css/standard.css" rel="stylesheet" type="text/css">
	<link href="css/960.gs.fluid.css" rel="stylesheet" type="text/css">
	<link href="css/simple-lists.css" rel="stylesheet" type="text/css">
	<link href="css/block-lists.css" rel="stylesheet" type="text/css">
	<link href="css/planning.css" rel="stylesheet" type="text/css">
	<link href="css/table.css" rel="stylesheet" type="text/css">
	<link href="css/calendars.css" rel="stylesheet" type="text/css">
	<link href="css/wizard.css" rel="stylesheet" type="text/css">
	<link href="css/gallery.css" rel="stylesheet" type="text/css">


	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<link rel="icon" type="image/png" href="favicon-large.png">

	
	<script type="text/javascript" src="js/html5.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    
   
    
	<script type="text/javascript" src="js/old-browsers.js"></script>
	<script type="text/javascript" src="js/jquery.accessibleList.js"></script>
	<script type="text/javascript" src="js/searchField.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/standard.js"></script>
	<script type="text/javascript" src="js/jquery.tip.js"></script>
	<script type="text/javascript" src="js/jquery.hashchange.js"></script>
	<script type="text/javascript" src="js/jquery.contextMenu.js"></script>
	<script type="text/javascript" src="js/jquery.modal.js"></script>
	<script type="text/javascript" src="js/list.js"></script>

	<link rel="stylesheet" href="js/base/jquery-ui-1.8.6.custom.css">

	<script src="js/jquery.ui.core.js"></script>
	<script src="js/jquery.ui.datepicker.js"></script>


	<!--[if lte IE 8]><script type="text/javascript" src="js/standard.ie.js"></script><![endif]-->
	
	<script  type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script  type="text/javascript" src="js/jquery.datepick/jquery.datepick.min.js"></script>
	

</head>

<body>
                 <?php


                         $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') 
                                 === FALSE ? 'http' : 'https';
                         $host     = $_SERVER['HTTP_HOST'];
                         $script   = $_SERVER['SCRIPT_NAME'];
                         $params   = $_SERVER['QUERY_STRING'];
                         //$currentUrl = $protocol . '://' . $host . $script . '?' . $params;
                         $currentUrl = substr($script . '?' . $params,1);

                        include "config.php"; 

                        $query = "SELECT * FROM common_links where link = '$currentUrl' ORDER BY sortorder ASC ";
                        $result = mysql_query($query,$conn); 
						$r4 = mysql_num_rows($result);
                        while($row1 = mysql_fetch_assoc($result))
                        { 
                           $parentid = $row1['parentid'];
                           $main = substr($parentid,0,1);
						   $name = $row1['name'];
						   $title = $row1['title'];
						}
						$q = "SELECT parentid,link,title,name from common_links where refid = '$parentid' and client = '$client'";
						$r = mysql_query($q,$conn) or die(mysql_error());
						$r3 = mysql_num_rows($r);
						$rr = mysql_fetch_assoc($r);
						$pid3 = $rr['parentid'];
						$l3 = $rr['link'];
						$t3 = $rr['title'];
						$n3 = $rr['name'];

						$q = "SELECT parentid,link,title,name from common_links where refid = '$pid3' and client = '$client'";
						$r = mysql_query($q,$conn) or die(mysql_error());
						$r2 = mysql_num_rows($r);
						$rr = mysql_fetch_assoc($r);
						$pid2 = $rr['parentid'];
						$l2 = $rr['link'];
						$t2 = $rr['title'];
						$n2 = $rr['name'];

						$q = "SELECT parentid,link,title,name from common_links where refid = '$pid2' and client = '$client'";
						$r = mysql_query($q,$conn) or die(mysql_error());
						$r1 = mysql_num_rows($r);
						$rr = mysql_fetch_assoc($r);
						$pid1 = $rr['parentid'];
						$l1 = $rr['link'];
						$t1 = $rr['title'];
						$n1 = $rr['name'];

                        
?>
<!--[if lt IE 9]><div class="ie"><![endif]-->
<!--[if lt IE 8]><div class="ie7"><![endif]-->
	<div id="status-bar"><div class="container_12">
	
		<ul id="status-infos">
			
			<li></li>
		</ul>
		
		<ul id="breadcrumb">
<?php if($r1) { ?>	<li><a href="<?php echo $l1; ?>" title="<?php echo $t1; ?>"><?php echo $n1; ?></a></li> <?php } ?>
<?php if($r2) { ?>	<li><a href="<?php echo $l2; ?>" title="<?php echo $t2; ?>"><?php echo $n2; ?></a></li> <?php } ?>
<?php if($r3) { ?>	<li><a href="<?php echo $l3; ?>" title="<?php echo $t3; ?>"><?php echo $n3; ?></a></li> <?php } ?>
<?php if($r4) { ?> 	<li><a href="<?php echo $currentUrl; ?>" title="<?php echo $title; ?>"><?php echo $name; ?></a></li> <?php } ?>
		</ul>
	
	</div></div>
	
	<div id="header-shadow"></div>

<?php 
if($_GET['page'] == "")
{
  include "data1.php"; 
}
else
{
   include "$_GET[page].php";
}

    $end_process = (float) array_sum(explode(' ',microtime())); 
	$exetime = $end_process-$start_process;
?>
<input id="exetime1" value="<?php echo $exetime; ?>" type="hidden"/>

<center>
<br/><br/>
<p><div id="loadgingpage"></div></p>
</center>