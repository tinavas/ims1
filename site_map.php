<?php
session_start();
$userlogged = $_SESSION['valid_user'];
           include "config.php"; 
           $query1 = "SELECT * FROM common_useraccess where username= '$userlogged' and client='$client' ORDER BY username ASC ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
                $rights = $row11['view'];
           }
           $query1 = "SELECT * FROM common_useraccess where id= '$_GET[id]' and client='$client' ORDER BY username ASC ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
                $checkedrights = $row11['view'];
                $addrights = $row11['addv'];
                $editrights = $row11['editv'];
                $deleterights = $row11['deletev'];
                $authorizerights = $row11['authorize'];
                $username = $row11['username'];
                $empdata = $row11['employeeid'];
           }
        
           include "mainconfig.php";
           $query1 = "SELECT * FROM tbl_users where username= '$username' and client='$client' ORDER BY username ASC ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
                $username = $row11['username'];
                $passwordd = $row11['password'];
                $emaild = $row11['email'];
				$sector = $row11['sectortype'];
           }
           include "config.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Tulasi Technologies - PMS</title>
	<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="checkboxtree/css/checkboxtree1.css" charset="utf-8">

	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script src="checkboxtree/js/jquery.checkboxtree.js" type="text/javascript" language="JavaScript"></script>
<script>
jQuery(document).ready(function(){
	jQuery("#checkchildren").checkboxTree({
			collapsedarrow: "checkboxtree/images/checkboxtree/img-arrow-collapsed.gif",
			expandedarrow: "checkboxtree/images/checkboxtree/img-arrow-expanded.gif",
			blankarrow: "checkboxtree/images/checkboxtree/img-arrow-blank.gif",
			checkchildren: true
	});
	jQuery("#dontcheckchildren").checkboxTree({
			collapsedarrow: "checkboxtree/images/checkboxtree/img-arrow-collapsed.gif",
			expandedarrow: "checkboxtree/images/checkboxtree/img-arrow-expanded.gif",
			blankarrow: "checkboxtree/images/checkboxtree/img-arrow-blank.gif",
			checkchildren: false
	});
	jQuery("#docheckchildren").checkboxTree({
			collapsedarrow: "checkboxtree/images/checkboxtree/img-arrow-collapsed.gif",
			expandedarrow: "checkboxtree/images/checkboxtree/img-arrow-expanded.gif",
			blankarrow: "checkboxtree/images/checkboxtree/img-arrow-blank.gif",
			checkchildren: true,
			checkparents: false
	});
	jQuery("#dontcheckchildrenparents").checkboxTree({
			collapsedarrow: "checkboxtree/images/checkboxtree/img-arrow-collapsed.gif",
			expandedarrow: "checkboxtree/images/checkboxtree/img-arrow-expanded.gif",
			blankarrow: "checkboxtree/images/checkboxtree/img-arrow-blank.gif",
			checkchildren: false,
			checkparents: false
	});
});
</script>




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


	<script type="text/javascript" src="js/html5.js"></script>
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


	
<style>
th {
	color: #3399cc;
}
form input[type=password]
{
   padding:0.2em;
}
</style>
</head>
<body onLoad="updatediv();">
<!--[if lt IE 9]><div class="ie"><![endif]-->
<!--[if lt IE 8]><div class="ie7"><![endif]-->
	
	

<form name="" action="common_updateuser.php" method="post">

<input type="hidden" id="checkedrights" value="<?php echo $checkedrights; ?>" />
<input type="hidden" id="addrights" value="<?php echo $addrights; ?>" />
<input type="hidden" id="editrights" value="<?php echo $editrights; ?>" />
<input type="hidden" id="deleterights" value="<?php echo $deleterights; ?>" />
<input type="hidden" id="authorizerights" value="<?php echo $authorizerights; ?>" />


<fieldset style="width:900px">

<div style="height:450px;width:300px;float:left; padding-left:400px;margin-top:10px;overflow:auto">
<h2>Site Map</h2>

<ul class="unorderedlisttree" id="checkchildren">

                <?php
                         $a = 1; $b = 1;
                         include "config.php"; 
                         $query = "SELECT * FROM common_links where active = 1 and step = 1 and client='$client' ORDER BY sortorder ASC ";
                         $result = mysql_query($query,$conn); 
                         while($row1 = mysql_fetch_assoc($result))
                         { 
                 ?>
                           <?php if ( strlen(strstr($rights ,$row1['refid']."," ))>0 ) {  ?>
             			<li>

                                   <input type="checkbox"  >
                                   <label style=" color:#000000;cursor:text" id="lab<?php echo $b; $b = $b + 1; ?>" ><?php echo $row1['name']; ?></label>
                                  <?php
                                     include "config.php"; 
                                     $query1 = "SELECT * FROM common_links where active = 1 and step = 2 and client='$client' and parentid = '$row1[refid]' ORDER BY sortorder ASC ";
                                     $result1 = mysql_query($query1,$conn); 
                                     if(mysql_num_rows($result1))
                                     {
                                  ?>
                                     <ul>
                                  <?php   
                                       while($row2 = mysql_fetch_assoc($result1))
                                       { 
                                  ?>
                           <?php if ( strlen(strstr($rights ,",".$row2['refid']."," ))>0 ) {  ?>
                					<li>
                                   <input type="checkbox"  >
                                   <label id="lab<?php echo $b; $b = $b + 1; ?>" > <a <?php if($row2['target']!="_NEW"&&$row2['target']!="new") echo 'style=" color:#000000;cursor:text"'; ?> target="<?php echo $row2['target'] ?>"  href="<?php echo $row2['link'] ?>"><?php echo $row2['name']; ?></a></label>

                                             <?php
                                                 include "config.php";  
                                                 $query2 = "SELECT * FROM common_links where active = 1 and client='$client' and step = 3 and parentid = '$row2[refid]' ORDER BY sortorder ASC ";
                                                 $result2 = mysql_query($query2,$conn); 
                                                 if(mysql_num_rows($result2))
                                                 {
                                              ?>
                                              <ul>
                                                 <?php   
                                                    while($row3 = mysql_fetch_assoc($result2))
                                                    { 
                                                 ?>
                           <?php if ( strlen(strstr($rights ,",".$row3['refid']."," ))>0 ) {  ?>
                          					<li>
                                   <input  type="checkbox"  >
                                   <label id="lab<?php echo $b; $b = $b + 1; ?>" ><a <?php if($row3['target']!="_NEW"&&$row3['target']!="new") echo 'style=" color:#000000;cursor:text"'; ?> target="<?php echo $row3['target'] ?>"  href="<?php echo $row3['link'] ?>"><?php echo $row3['name']; ?></a></label>

                                              <?php
                                                 include "config.php";  
                                                 $query3 = "SELECT * FROM common_links where active = 1 and  step = 4 and client='$client' and parentid = '$row3[refid]' ORDER BY sortorder ASC ";
                                                 $result3 = mysql_query($query3,$conn); 
                                                 if(mysql_num_rows($result3))
                                                 {
                                              ?>
                                              <ul>
                                                 <?php   
                                                    while($row4 = mysql_fetch_assoc($result3))
                                                    { 
                                                 ?>
                           <?php if ( strlen(strstr($rights ,",".$row4['refid']."," ))>0 ) {  ?>
                          					<li>

                                   <input type="checkbox">
                                   <label id="lab<?php echo $b; $b = $b + 1; ?>" >  <a target="<?php echo $row4['target'] ?>"  href="<?php echo $row4['link'] ?>"><?php echo $row4['name']; ?></a></label>
           

                                                     </li>
                            <?php } ?> 
                                                <?php } ?></ul><?php } ?>

                                                       </li>
                            <?php } ?> 
                             
                                                <?php } ?></ul><?php } ?>

                                         </li>
                            <?php } ?> 

                                  <?php } ?></ul><?php } ?>
                              </li>
                            <?php } ?> 

                   <?php }?>



</ul>
<br />  
</div>

</form>
<script type='text/javascript'>
 function updatediv()
 {
   
     
 }
</script>
</body>
</html>
