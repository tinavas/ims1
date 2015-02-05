  <?php
	 include "config.php";
	 $q=mysql_query("select distinct cat, from ims_itemcodes",$conn) or die(mysql_error());
	 $n=mysql_num_rows($q);
	 $i=0;
	 while($r=mysql_fetch_array($q))
	 {
	 if($i<=$n-1)
	 {
	 ?>
	 "<?php echo $r['cat'];?>",
	 <?php } else {?>
	 "<?php echo $r['cat'];?>"
	 <?php }
	 $i++;
	 }
	 ?>
	 
     
     <!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Autocomplete - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <?php 
   include "config.php";
	 $q=mysql_query("select group_concat(code,'@',description) as code,cat from ims_itemcodes group by cat",$conn) or die(mysql_error());
	 $n=mysql_num_rows($q);
	 $i=0;
	 while($r=mysql_fetch_array($q))
	 {
	 $codes[]=array("cat"=>$r[cat],"code"=>$r[code]);
	 }
	 $cod=json_encode($codes);
  ?>
  <script>
  var codes=<?php if(!empty($cod)){ echo $cod; }else { } ?>;
  $(function() {	
    var availableTags = [
/*	for(k=0;k<codes.length;k++)
{
	if(k<codes.length-1)
	 {
		"'"+codes[k].cat+"'",
		}
		else
		{
		"'"+codes[k].cat+"'"
		}
}*/
<?php 
for($i=0;$i<count($codes);$i++)
{

 if($i<=$n-1)
	 {
	 ?>
	 "<?php echo $codes[$i].cat;?>",
	 <?php } else {?>
	 "<?php echo $r['cat'];?>"
	 <?php }
	 $i++;

    ];
	
	 
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  });
  </script>
</head>
<body>
 
<div class="ui-widget">
  <label for="tags">Category: </label>
  <input id="tags" onBlur="chk()">
    <label for="code">Code: </label>
  <input id="code" >
</div>
 
 
</body>
<script type="text/javascript">
function chk()
{
alert("hii");
document.getElementById("tags").value;
}
</script>
</html>