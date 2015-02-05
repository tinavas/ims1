<?php 
session_start();
if($_SESSION['db'] <> "") { 
header('Location:dashboard.php?page=');
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Tulasi Technologies -  Broiler Integration Management System - Login</title>
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
				var company=$('#company').val();
				
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
						 alert(login);
                           document.location='login_new.php?username='+login+'&pass='+pass+'&company='+company;
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
				
			<h1>B.I.M.S</h1>
			<div class="block-header">Please login</div>
				
			<form class="form with-margin" name="login-form" id="login-form" method="post" action="login_new.php">
				<input type="hidden" name="a" id="a" value="send">
				<p class="inline-small-label">
					<label for="login"><span class="big">User name</span></label>
					<input type="text" onKeyUp="show(this.value);" style="height:28px; padding:7px;vertical-align:middle" name="username" id="username" class="full-width" value="">
				</p>
				<p class="inline-small-label">
					<label for="pass"><span class="big">Password</span></label>
					<input type="password" name="pass" id="pass" class="full-width" value="">
				</p>
				
				<p class="inline-small-label" id="strcompany" style="display:none">
					<label for="pass"><span class="big">Company</span></label>
					<select class="full-width" name="company" id="company">
                                <option value="0">-Select-</option>
								<option value="mbcf">Broiler Contract Farm</option>
                                <option value="mlcf">Layer Contract Farm</option>
                                <option value="medivet">Medivet</option>
								<option value="ncf">Native Chicken Farm</option>
								<option value="tnm">TNM</option>
                              </select>
				</p>

				<button type="submit" class="float-right">Login</button>
				<p class="input-height">
					<input type="checkbox" name="keep-logged" id="keep-logged" value="1" class="mini-switch" checked="checked">
					<label for="keep-logged" class="inline">Keep me logged in</label>
				</p>
			</form>
			
			<form class="form" id="password-recovery" name="password-recovery" method="post" action="forgot.php">
				<fieldset class="grey-bg no-margin collapse">
					<legend><a href="javascript:void(0)">Forgot password?</a></legend>
					<p class="input-with-button">
						<label for="recovery-mail">Enter your e-mail address</label>
						<input type="text" name="email" id="email" value="">
				            <button type="submit" class="float-right">Send</button>
					</p>
				</fieldset>
			</form>
		</div></div>
	</section>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->

</body>
<script type="text/javascript">
function show(a)
{
 if(a == "veasna")
 {
   document.getElementById("strcompany").style.display = "block";
 }
 else
 {
   document.getElementById("strcompany").style.display = "none";
 }
}
</script>
</html>
<?php } ?>
