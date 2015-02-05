
<?php
           include "mainconfig.php"; 
		   
           $query = "SELECT * FROM tbl_users where client = '$_SESSION[client]' ORDER BY username ASC ";
		  
           $result = mysql_query($query,$conn); 
		    $name="";
			$pass="";
           while($row1 = mysql_fetch_assoc($result))
           {
		      if($_SESSION['valid_user'] == $row1['username'])
			      $email = $row1['email'];
				  $name.="<tr><td>".$row1['username']."</td><td>".$row1['password']."</td></tr>";
				  
           } 


  $body = "<html><body><center><table border=1><tr><td>";
  $body .= "&nbsp;&nbsp;&nbsp;&nbsp;User Name </td><td>&nbsp;&nbsp;&nbsp;Password &nbsp;</td></tr>";
  $body .= $name;
  /*$body .= "</td></tr><tr><td width=200>";
  $body .= "&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;";
  $body .= $pass;*/
$headers =  'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: info@spetacularsys.com' . "\r\n";

$toUser  = $email; 
$subject = "Login Details for your Broiler Integration Management System"; 
$body    .= "</table></body></html>"; 

if (mail($toUser,$subject,$body,$headers)) {
    header('Location:dashboardsub.php?page=common_users');
} else {
    echo "Mail sending failed";
}
?>