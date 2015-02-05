<div id="time" align="center">
&nbsp;Please wait,while page is loading . . . . 
<?php 
$script   = $_SERVER['SCRIPT_NAME'] .'?'.$_SERVER['QUERY_STRING'];
$url=explode('?',$script); 
$url= explode('&',$url[1]); 
$filename= substr($url[0],5);
$args='?';
for($i=1;$i<count($url);$i++)
 $args.=$url[$i].'&';
 $filename=$filename.$args;
?>
</div>
<iframe align="middle" id="new" allowtransparency="true" name="new" scrolling="no" style="position:absolute" src="<?php  echo $filename ?>" width="100%"  frameborder="0" onload='javascript:resize(this)' > </iframe>


<script type="text/javascript" >
function resize(obj){
obj.style.height=(parseInt(obj.contentWindow.document.body.scrollHeight)+50)+'px';
if(obj.style.width<obj.contentWindow.document.body.scrollWidth+'px')
 obj.style.width=obj.contentWindow.document.body.scrollWidth+'px'
}
</script>
<!--/page=itemledger.php?fromdate=01.04.2011&todate=01.12.2011&code=FD106-->