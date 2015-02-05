<!DOCTYPE html>
<html lang="en">
<head>

	<title>Tulasi Technologies -  Stock Manager on Cloud - Login</title>
	<meta charset="utf-8">
	
      <link href="css/reset.css" rel="stylesheet" type="text/css">
      <link href="css/common.css" rel="stylesheet" type="text/css">
	<link href="css/form.css" rel="stylesheet" type="text/css">
	<link href="css/standard.css" rel="stylesheet" type="text/css">
	<link href="css/special-pages.css" rel="stylesheet" type="text/css">


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

	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<link rel="icon" type="image/png" href="favicon-large.png">
	
	<!--[if lte IE 8]><script type="text/javascript" src="js/standard.ie.js"></script><![endif]-->
	
	<script type="text/javascript">
	
		$(document).ready(function()
		{

                        var wrong = "<?php if(isset($_GET['wrong'])) { echo 'yes'; } ?>";

                        if(wrong == "yes")
                        {
					$('#login-block').removeBlockMessages().blockMessage('Invalid username or password', {type: 'error'});
                        }

                        var mail = "<?php if(isset($_GET['lost'])) { echo 'yes'; } ?>";

                        if(mail == "yes")
                        {
                             var message = "<?php if(isset($_GET['lost'])) { echo $_GET['lost']; } ?>";
                             if(message == "sent")
					$('#login-block').removeBlockMessages().blockMessage('E-mail has been sent', {type: 'warning'});
                             else
					$('#login-block').removeBlockMessages().blockMessage('Entered E-mail address does not match with our records', {type: 'error'});
                        }

			$('#login-form').submit(function(event)
			{
				event.preventDefault();
				
				var login = $('#username').val();
				var pass = $('#pass').val();
				
				if (!login || login.length == 0)
				{
					$('#login-block').removeBlockMessages().blockMessage('Please enter your user name', {type: 'warning'});
				}
				else if (!pass || pass.length == 0)
				{
					$('#login-block').removeBlockMessages().blockMessage('Please enter your password', {type: 'warning'});
				}
                        else
                        {
                           document.forms("login-form").submit();
                        }
			});

			$('#password-recovery').submit(function(event)
			{
				event.preventDefault();
				
				var email = $('#email').val();
				
				if (!email || email.length == 0)
				{
					$('#login-block').removeBlockMessages().blockMessage('Please enter your email', {type: 'warning'});
				}
                        else
                        {
                           document.forms("password-recovery").submit();
                        }
			});
		});
	
	</script>
	

	
</head>

<body class="special-page login-bg dark">
<!--[if lt IE 9]><div class="ie"><![endif]-->
<!--[if lt IE 8]><div class="ie7"><![endif]-->

	<!-- <section id="message">
		<div class="block-border"><div class="block-content no-title dark-bg">
			<p class="mini-infos">For demo website, use <b>admin</b> / <b>admin</b></p>
		</div></div>
	</section> -->
	
	<section id="login-block">
		<div class="block-border"><div class="block-content">
				
 		    <div class="block-header">You have successfully logged out</div>
                   <center> 
				<button type="button" class="float-middle" onClick="document.location='index.php'">Back To Home Page</button>
                   </center>
		</div></div>
	</section>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->

</body>
</html>








