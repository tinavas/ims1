<?php 
session_start();
if($_SESSION['db'] == "") { 
header('Location:index.php');
}
?>

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
	<title>Tulasi Technologies - BIMS</title>
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
	
	<!--<script type="text/javascript" src="http://www.google.com/jsapi"></script>
	<script type="text/javascript">
	
		google.load('visualization', '1', {'packages':['corechart']});
		
	</script>-->
	

</head>

<body>
<!--[if lt IE 9]><div class="ie"><![endif]-->
<!--[if lt IE 8]><div class="ie7"><![endif]-->
	
	<header><div class="container_12">
		
		<p id="skin-name"><small>Tulasi Technologies<br> B.I.M.S</small> <strong>2.0</strong></p>
		<!-- <div class="server-info">Server: <strong>Apache (unknown)</strong></div>
		<div class="server-info">Php: <strong>5.2.14</strong></div> -->
		
	</div></header>
	
	<nav id="main-nav">
		
		<ul class="container_12">
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
  
                         $query = "SELECT * FROM common_links where active = 1 and step = 1 ORDER BY sortorder ASC ";
                         $result = mysql_query($query,$conn); 
                         while($row1 = mysql_fetch_assoc($result))
                         { 
                 ?>


                           <?php if ( strlen(strstr($rights ,$row1['refid'] ))>0 ) {  ?>
             			<li class="<?php echo $row1['icon']; if($main == $row1['refid']) { echo " current"; }?>"><a href="<?php echo $row1['link']; ?>" title="<?php echo $row1['title']; ?>" target="<?php echo $row1['target']; ?>" onclick="<?php echo $row1['javascript']; ?>"><?php echo $row1['name']; ?></a>
                              
                                  <?php
                                     include "config.php"; 
                                     $query1 = "SELECT * FROM common_links where active = 1 and step = 2 and parentid = '$row1[refid]' ORDER BY sortorder ASC ";
                                     $result1 = mysql_query($query1,$conn); 
                                     if(mysql_num_rows($result1))
                                     {
                                  ?>
                                     <ul>
                                  <?php   
                                       while($row2 = mysql_fetch_assoc($result1))
                                       { 
                                  ?>
                           <?php if ( strlen(strstr($rights ,$row2['refid'] ))>0 ) {  ?>
                					<li class="<?php echo $row2['icon']; ?>"><a href="<?php echo $row2['link']; ?>" title="<?php echo $row2['title']; ?>" target="<?php echo $row2['target']; ?>"><?php echo $row2['name']; ?></a>



                                              <?php
                                                 include "config.php";  
                                                 $query2 = "SELECT * FROM common_links where active = 1 and step = 3 and parentid = '$row2[refid]' ORDER BY sortorder ASC ";
                                                 $result2 = mysql_query($query2,$conn); 
                                                 if(mysql_num_rows($result2))
                                                 {
                                              ?>
						<div class="menu">
						  <img src="images/menu-open-arrow.png" width="16" height="16">
                                              <ul>
                                                 <?php   
                                                    while($row3 = mysql_fetch_assoc($result2))
                                                    { 
                                                 ?>
                           <?php if ( strlen(strstr($rights ,$row3['refid'] ))>0 ) {  ?>
                          					<li class="<?php echo $row3['icon']; ?>"><a href="<?php echo $row3['link']; ?>" title="<?php echo $row3['title']; ?>" target="<?php echo $row3['target']; ?>"><?php echo $row3['name']; ?></a>








                                              <?php
                                                 include "config.php";  
                                                 $query3 = "SELECT * FROM common_links where active = 1 and step = 4 and parentid = '$row3[refid]' ORDER BY sortorder ASC ";
                                                 $result3 = mysql_query($query3,$conn); 
                                                 if(mysql_num_rows($result3))
                                                 {
                                              ?>
                                              <ul>
                                                 <?php   
                                                    while($row4 = mysql_fetch_assoc($result3))
                                                    { 
                                                 ?>
                           <?php if ( strlen(strstr($rights ,$row4['refid'] ))>0 ) {  ?>
                          					<li class="<?php echo $row4['icon']; ?>"><a href="<?php echo $row4['link']; ?>" title="<?php echo $row4['title']; ?>" target="<?php echo $row4['target']; ?>"><?php echo $row4['name']; ?></a></li>
                           <?php } ?>  
                                                <?php } ?></ul><?php } ?>














                                                       </li>
                            <?php } ?> 
                                                <?php } ?></ul></div><?php } ?>


                                          </li>
                            <?php } ?>
                                  <?php } ?></ul><?php } ?>
                              </li>
                           <?php } ?>
                   <?php } ?>
		</ul>
	</nav>
	<div id="sub-nav"><div class="container_12">
		
		<a href="javascript:void(0)" title="Help" class="nav-button"><b>Help</b></a>
	
		<form id="search-form" name="search-form" method="post" action="search.php">
			<input type="text" name="s" id="s" value="" title="Search admin..." autocomplete="off">
		</form>
	
	</div></div>
	<!-- <div id="status-bar"><div class="container_12">
	
		<ul id="status-infos">
			<li class="spaced">Logged as: <strong><?php echo ucfirst($user); ?></strong></li> -->
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
			<!-- <li>
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

			<li>
                       <?php
                         include "config.php"; session_start(); $user = $_SESSION['valid_user']; $count1 = 0; $count2 = 0;
                         $query1 = "SELECT * FROM common_alerts"; 
                         $result1 = mysql_query($query1,$conn); 
                         while($row1 = mysql_fetch_assoc($result1)) 
                         {
                            $query11 = "SELECT sum(quantity) as 'quantity' FROM ims_stock where itemcode = '$row1[item]' and quantity < '$row1[minqty]'"; 
                            $result11 = mysql_query($query11,$conn); 
                            while($row11 = mysql_fetch_assoc($result11)) 
                            {
                              if(!is_null($row11['quantity'])) { $count1 = $count1 + 1; }
                            }

                            $query11 = "SELECT sum(quantity) as 'quantity' FROM ims_stock where itemcode = '$row1[item]' and quantity > '$row1[maxqty]'"; 
                            $result11 = mysql_query($query11,$conn); 
                            while($row11 = mysql_fetch_assoc($result11)) 
                            {
                              if(!is_null($row11['quantity'])) { $count2 = $count2 + 1; }
                            }

  
                            $count = $count1 + $count2;
                         }
                       ?> 

                      
				<a href="javascript:void(0)" class="button" title="<?php echo $count; ?> Alerts"><img src="images/icons/fugue/alert.png" width="16" height="16"> <strong><?php echo $count; ?></strong></a>
				<div id="comments-list" class="result-block">
					<span class="arrow"><span></span></span>
					
					<ul class="small-files-list icon-comment">
                       <?php
                         include "config.php"; session_start(); $user = $_SESSION['valid_user'];
                         $query1 = "SELECT * FROM common_alerts"; 
                         $result1 = mysql_query($query1,$conn); 
                         while($row1 = mysql_fetch_assoc($result1)) 
                         {
                            $query11 = "SELECT sum(quantity) as 'quantity' FROM ims_stock where itemcode = '$row1[item]' and quantity < '$row1[minqty]'"; 
                            $result11 = mysql_query($query11,$conn); 
                            while($row11 = mysql_fetch_assoc($result11)) 
                            {
                              if(!is_null($row11['quantity'])) {
                       ?> 
						<li>
							<a href="javascript:void(0)"><strong><?php echo $row1['item']; ?> is less than <?php echo $row1['minqty']; ?></strong><br>
							<small>Available Qty: <?php echo $row11['quantity']; ?></small></a>
						</li>
                       <?php } } 

                            $query11 = "SELECT sum(quantity) as 'quantity' FROM ims_stock where itemcode = '$row1[item]' and quantity > '$row1[maxqty]'"; 
                            $result11 = mysql_query($query11,$conn); 
                            while($row11 = mysql_fetch_assoc($result11)) 
                            {
                              if(!is_null($row11['quantity'])) {
                       ?>
						<li>
							<a href="javascript:void(0)"><strong><?php echo $row1['item']; ?> is more than <?php echo $row1['maxqty']; ?></strong><br>
							<small>Available Qty: <?php echo $row11['quantity']; ?></small></a>
						</li>
                       <?php } } ?>
                       <?php } ?> 
					</ul>
					
					<p id="comments-info" class="result-info"><a href="dashboardsub.php?page=common_alert">Manage Alerts &raquo;</a></p>
				</div>
			</li>

			<li><a href="logout.php" class="button red" title="Logout"><span class="smaller">LOGOUT</span></a></li>
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
	
	</div></div> -->
	
	<div id="header-shadow"></div>

