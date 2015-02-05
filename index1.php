<!DOCTYPE html>
<html lang="en">
<head>


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
<script type="text/javascript">
var mail = "<?php if(isset($_GET['lost'])) { echo 'yes'; } ?>";

                        if(mail == "yes")
                        {
                             var message = "<?php if(isset($_GET['lost'])) { echo $_GET['lost']; } ?>";
                             if(message == "sent")
					$('#login-block').removeBlockMessages().blockMessage('E-mail has been sent', {type: 'warning'});
                             else
					$('#login-block').removeBlockMessages().blockMessage('Entered E-mail address does not match with our records', {type: 'error'});
                        }
						</script>
</head></html>