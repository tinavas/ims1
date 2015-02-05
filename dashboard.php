<?php include "header.php"; 
if($_GET['salevar'])
{
 session_start();
 if($_SESSION['salevar'] != $_GET['salevar'])
 {
 unset($_SESSION['salevar']);
 $_SESSION['salevar'] = $_GET['salevar'];
 }
}

if($_GET['page'] == "") { 
 ?>
 <iframe id="new" allowtransparency="true" style="POSITION: absolute; overflow: auto;" name=new  src="dashboardsub.php?page=data1" width=100% height=100%
                   border-width:0px;? ;   
                  frameborder="0"> </iframe>
<?php 

}

 else { ?>
  <iframe id="new" allowtransparency="true" style="POSITION: absolute; overflow: auto;" name=new  src="dashboardsub.php?page=<?php echo $_GET['page']; ?>"  width=100% height=100%
                   border-width:0px;? ;   
                  frameborder="0"> </iframe>
<?php } ?>