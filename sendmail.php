
<?php
 include "class.smtp.php";
	include "class.phpmailer.php";
	
	
    $Host = "mail.tulassi.com";						// SMTP servers
	$Username = "info@tulassi.com";	     // SMTP password
	$Password = "icareu";					// SMTP username
	
	$From = "info@tulassi.com";
	$FromName = "Tulasi Technologies";
	$email = "trimurthy@tulassi.com";
	$Tos = array(
		$name =>  $email
	);	
	
	
	
$hotelname = $_POST['Hotel Name'];
$contactperson = $_POST['Contact Person'];
$address = $_POST['Address'];
$fromemail = $_POST['Email ID'];
$mobile = $_POST['Mobile'];
$telephone = $_POST['Telephone'];
$notray = $_POST['No of Trays'];

 $body = "<html><body><center><table border=1>";
  $body .= "<tr><td>&nbsp;&nbsp; Hotel Name &nbsp;&nbsp; </td><td>&nbsp;&nbsp; ".$hotelname."&nbsp;&nbsp;</td></tr>";
  $body .= "<tr><td>&nbsp;&nbsp; Contact Person &nbsp;&nbsp; </td><td>&nbsp;&nbsp; ".$contactperson."&nbsp;&nbsp;</td></tr>";
  $body .= "<tr><td>&nbsp;&nbsp; Address &nbsp;&nbsp; </td><td>&nbsp;&nbsp; ".$address."&nbsp;&nbsp;</td></tr>";
  $body .= "<tr><td>&nbsp;&nbsp; E-Mail &nbsp;&nbsp; </td><td>&nbsp;&nbsp; ".$fromemail."&nbsp;&nbsp;</td></tr>";
  $body .= "<tr><td>&nbsp;&nbsp; Mobile &nbsp;&nbsp; </td><td>&nbsp;&nbsp; ".$mobile."&nbsp;&nbsp;</td></tr>";
  $body .= "<tr><td>&nbsp;&nbsp; Telephone &nbsp;&nbsp; </td><td>&nbsp;&nbsp; ".$telephone."&nbsp;&nbsp;</td></tr>";
  $body .= "<tr><td>&nbsp;&nbsp; No of Trays &nbsp;&nbsp; </td><td>&nbsp;&nbsp; ".$notray."&nbsp;&nbsp;</td></tr>";
$body  .= "</table></body></html>"; 

$headers =  'MIME-Version: 1.0' . "\r\n";
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 $headers .= 'From: info@spetacularsys.com' . "\r\n";


$subject = "Quote Request From ".$hotelname; 

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
	
	

    $mail->WordWrap = 50;				// set word wrap
	$mail->Priority = 1; 
    $mail->IsHTML(true);  
    $mail->Subject  =  $Subject;
    $mail->Body     =  $Body;

if ($mail->Send()) {
  echo "Order Send Successfully";
} else { 
     echo "Order Sending Failed";
}
?>