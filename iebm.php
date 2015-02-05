<?php
$to      = stripslashes($_POST["to_address"]);
$BCC      = stripslashes($_POST["BCC"]);
$subject = stripslashes($_POST["subject"]);
$message = stripslashes($_POST["body"]);
$from_address = stripslashes($_POST["from_address"]);
$from_name = stripslashes($_POST["from_name"]); 
$contenttype = $_POST["type"];


if (strlen($from_address) > 3)
{
$header = "MIME-Version: 1.0\r\n";
$header .= "Content-Type: text/$contenttype\r\n";
$header .=  "From: $from_name <$from_address>\r\n";
$header .=  "Reply-To: $from_name <$from_address>\r\n";
$header .= "Subject: $subject\r\n";

$result = mail(stripslashes($to), stripslashes($subject), stripslashes($message), stripslashes($header));
}
else
{
$result = mail(stripslashes($to), stripslashes($subject), stripslashes($message));
}




if($result)
{
echo 'good';
}
else
{
    'error : '.$result;
}
?>