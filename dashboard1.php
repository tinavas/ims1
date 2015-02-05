

<?php include "header.php"; 
if($_GET['page'] == "") { ?>
  <iframe id="new" allowtransparency="true" style="POSITION: absolute; overflow: auto;" name=new  src="dashboardsub.php?page=data1" width=100% height=1200px
                   border-width:0px;? ;   
                  frameborder="0"> </iframe>
<?php } else { ?>
  <iframe id="new" allowtransparency="true" style="POSITION: absolute; overflow: auto;" name=new  src="dashboardsub.php?page=<?php echo $_GET['page']; ?>" width=100% height=1200px
                   border-width:0px;? ;   
                  frameborder="0"> </iframe>
<?php } ?>