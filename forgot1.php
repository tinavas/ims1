<?php
    include "class.smtp.php";
	include "class.phpmailer.php";
	
           include "mainconfig.php"; 
           
              $email = $_POST['to'];
              $message=$_POST['message'];


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
  $body .= "&nbsp;&nbsp;&nbsp;&nbsp;Message :</td><td>&nbsp;&nbsp;&nbsp;";
  $body .= $message;
  
  $body    .= "</td></tr></table></body></html>"; 
  
 $headers =  'MIME-Version: 1.0' . "\r\n";
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 $headers .= 'From: info@spetacularsys.com' . "\r\n";
 $subject = "A message from Broiler Integration Management System"; 

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

if ($mail->Send()) {
  header('Location:index1.php?lost=sent');
} else { 
   header('Location:index1.php?lost=failed');
}
?>
