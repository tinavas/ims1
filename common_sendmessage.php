<?php include "jquery.php"; ?>


<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:500px" id="complex_form" method="post" action="common_savemessage.php" >


	  <h1 id="title1">New Message</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>






<fieldset style="width:380px;text-align:left">
<legend>Message</legend>
<table border="0px" id="inputs">
     <tr height="20px"><td></td></tr>

   <tr>
       <td width="100px"><strong>To</strong></td> 
 
       <td style="text-align:left;">
         <select style="width:140px" name="toname" id="toname">
          <option>-Select-</option>
          <?php  
            include "config.php"; session_start(); $user = $_SESSION['valid_user'];
            $query1 = "SELECT * FROM common_useraccess where username <> '$user' ORDER BY username ASC ";
            $result1 = mysql_query($query1,$conn); 
            while($row11 = mysql_fetch_assoc($result1))
            {
          ?>
           <option value="<?php echo $row11['username']; ?>"><?php echo $row11['username']; ?></option>
          <?php } ?>
         </select>
       </td>

    </tr>

    <tr height="10px"><td></td></tr>
  
    <tr>
       <td><strong>Title</strong></td> 

       <td><input type="text" size="45" name="title" /></td>
    </tr>

    <tr height="10px"><td></td></tr>
  
    <tr>
       <td><strong>Message</strong></td> 

       <td><textarea rows="6" cols="45" name="message"></textarea></td>
    </tr>

 
</table>

<center>
<table>
<tr height="30px"><td></td></tr>
<tr><td>
 <center><input type="submit" value="Send" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=common_messages';"></center>
</td></tr>
</table>
</center>

</fieldset>
              </center>
     </form>
  </div>
</section>
		


<div class="clear"></div>
<br />


