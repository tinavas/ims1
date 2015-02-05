<?php
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
	<title>Tulasi Technologies - PMS</title>
	<meta charset="utf-8">
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
                        while($row1 = mysql_fetch_assoc($result))
                        { 
                           $parentid = $row1['parentid'];
                           $main = substr($parentid,0,1);                           
                           if($row1['step'] == 2) { $sub1 = $row1['refid']; }
                           if($row1['step'] == 3) { $sub1 = substr($parentid,0,2); $sub2 = $row1['refid']; }
                           if($row1['step'] == 4) { $sub1 = substr($parentid,0,2); $sub2 = substr($parentid,0,4); $sub3 = $row1['refid'];}
                        }
?>
<!--[if lt IE 9]><div class="ie"><![endif]-->
<!--[if lt IE 8]><div class="ie7"><![endif]-->
	<div id="status-bar"><div class="container_12">
	
		<ul id="status-infos">
			<li class="spaced">Logged as: <strong>Admin</strong></li>
			<!-- <li>
				<a href="javascript:void(0)" class="button" title="5 messages"><img src="images/icons/fugue/mail.png" width="16" height="16"> <strong>5</strong></a>
				<div id="messages-list" class="result-block">
					<span class="arrow"><span></span></span>
					
					<ul class="small-files-list icon-mail">
						<li>
							<a href="javascript:void(0)"><strong>Today</strong> Test<br>
							<small>From: Tulasi</small></a>
						</li>
					</ul>
					
					<p id="messages-info" class="result-info"><a href="javascript:void(0)">Go to inbox &raquo;</a></p>
				</div>
			</li> -->
			<li>
                       <?php
                         include "config.php"; session_start(); $user = $_SESSION['valid_user'];
                         $query1 = "SELECT * FROM common_messages where toname = '$user'"; 
                         $result1 = mysql_query($query1,$conn); 
                         $count = mysql_num_rows($result1);
                       ?> 
				<a href="javascript:void(0)" class="button" title="<?php echo $count; ?> comments"><img src="images/icons/fugue/balloon.png" width="16" height="16"> <strong><?php echo $count; ?></strong></a>
				<div id="comments-list" class="result-block">
					<span class="arrow"><span></span></span>
					
					<ul class="small-files-list icon-comment">
                       <?php
                         include "config.php"; session_start(); $user = $_SESSION['valid_user'];
                         $query1 = "SELECT * FROM common_messages where toname = '$user'"; 
                         $result1 = mysql_query($query1,$conn); 
                         while($row1 = mysql_fetch_assoc($result1)) 
                         {
                       ?> 
						<li>
							<a href="javascript:void(0)"><strong><?php echo $row1['title']; ?></strong><br>
							<small>From: <?php echo $row1['fromname']; ?></small></a>
						</li>
                       <?php } ?> 
					</ul>
					
					<p id="comments-info" class="result-info"><a href="dashboardsub.php?page=common_messages&id=toname">Manage Messages &raquo;</a></p>
				</div>
			</li>
			<li><a href="logout.php" class="button red" title="Logout" target="_parent"><span class="smaller">LOGOUT</span></a></li>
		</ul>
		
		<ul id="breadcrumb">
                 <?php if($main) {
    
                        $query = "SELECT * FROM common_links where refid = '$main' ORDER BY sortorder ASC ";
                        $result = mysql_query($query,$conn); 
                        while($row1 = mysql_fetch_assoc($result))
                        { 
                 ?>
 			<li><a href="<?php echo $row1['link']; ?>" title="<?php echo $row1['title']; ?>"><?php echo $row1['name']; ?></a></li>
                <?php } } ?>

                 <?php if($sub1) {
    
                        $query = "SELECT * FROM common_links where refid = '$sub1' ORDER BY sortorder ASC ";
                        $result = mysql_query($query,$conn); 
                        while($row1 = mysql_fetch_assoc($result))
                        { 
                 ?>
 			<li><a href="<?php echo $row1['link']; ?>" title="<?php echo $row1['title']; ?>"><?php echo $row1['name']; ?></a></li>
                <?php } } ?>


                 <?php if($sub2) {
    
                        $query = "SELECT * FROM common_links where refid = '$sub2' ORDER BY sortorder ASC ";
                        $result = mysql_query($query,$conn); 
                        while($row1 = mysql_fetch_assoc($result))
                        { 
                 ?>
 			<li><a href="<?php echo $row1['link']; ?>" title="<?php echo $row1['title']; ?>"><?php echo $row1['name']; ?></a></li>
                <?php } } ?>


                 <?php if($sub3) {
    
                        $query = "SELECT * FROM common_links where refid = '$sub3' ORDER BY sortorder ASC ";
                        $result = mysql_query($query,$conn); 
                        while($row1 = mysql_fetch_assoc($result))
                        { 
                 ?>
 			<li><a href="<?php echo $row1['link']; ?>" title="<?php echo $row1['title']; ?>"><?php echo $row1['name']; ?></a></li>
                <?php } } ?>

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



?>