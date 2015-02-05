
<?php
    include "class.smtp.php";
	include "class.phpmailer.php";
	
           include "mainconfig.php"; 
           $query = "SELECT * FROM tbl_users where email = '$_POST[email]' ORDER BY id ASC ";
           $result = mysql_query($query,$conn);
		   $count = mysql_num_rows($result);
           if($row1 = mysql_fetch_assoc($result))
           {
              $email = $_POST['email'];
              $name = $row1['username'];
              $pass = $row1['password'];
           } 


    $Host = "mail.tulassi.com";						// SMTP servers
	$Username = "info@tulassi.com";	     // SMTP password
	$Password = "icareu";					// SMTP username
	
	$From = "info@tulassi.com";
	$FromName = "Tulasi Technologies";
	
	$Tos = array(
		$name =>  $email
	);	
	$Ccs = array(
		"Support" => "support@tulassi.com"
	);


  $body = "<html><body><table border=1><tr><td width=200>";
  $body .= "&nbsp;&nbsp;&nbsp;&nbsp;User Name :</td><td>&nbsp;&nbsp;&nbsp;";
  $body .= $name;
  $body .= "</td></tr><tr><td width=200>";
  $body .= "&nbsp;&nbsp;&nbsp;&nbsp;Password :</td><td>&nbsp;&nbsp;&nbsp;";
  $body .= $pass;
  $body    .= "</td></tr></table></body></html>"; 
  
 $headers =  'MIME-Version: 1.0' . "\r\n";
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 $headers .= 'From: info@spetacularsys.com' . "\r\n";
 $subject = "Login Details for your Broiler Integration Management System"; 

 $Subject = $subject;
 $Body = $body;

	$mail = new PHPMailer();

    $mail->IsSMTP();                 	// send via SMTP
    $mail->Host     = $Host; 
    $mail->SMTPAuth = true;     		// turn on SMTP authentication
    $mail->Username = $Username;  
    $mail->Password = $Password; 
    
    $mail->From     = $From;
    $mail->FromName = $FromName;
	foreach($Tos as $key => $val){
		$mail->AddAddress($val , $key); 
	}
	
	foreach($Ccs as $key => $val){
		$mail->AddCC($val , $key); 
	}

    $mail->WordWrap = 50;				// set word wrap
	$mail->Priority = 1; 
    $mail->IsHTML(true);  
    $mail->Subject  =  $Subject;
    $mail->Body     =  $Body;

if ($count == 0) { 
   header('Location:index.php?lost=failed');
} else if ($mail->Send()) {
  header('Location:index.php?lost=sent');
} else { 
   header('Location:index.php?lost=failed');
}
?>