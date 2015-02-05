<?php

set_time_limit(0);

ini_set("memory_limit","-1");

//C:\HostingSpaces\Admin
 $path=getcwd();

$path = realpath("$path");

//$path="C:\HostingSpaces\Admin";

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename)
{

      $flag=0;
	   
	   $info = new SplFileInfo("$filename");
       
	    
	   if(basename($filename)!="." && basename($filename)!=".." && basename($filename)!="script to get hackfiles.php" &&( $info->getExtension()=="php" || $info->getExtension()=="txt") )
	   {
	   
	   
	   //echo $info->getExtension(),"<br/>";
	   
	    // echo "$filename->";
		 
		 // search for the file whether config file is existed or not
		 
		//$searchfor1 = "mail(";
		//$searchfor2="send_smtp(";
		//$searchfor3="read_smtp_answer";
		$searchfor4="stripslashes("."$"."_POST"."[\"to_address\"])";
		//$searchfor5="Math.floor(Math.random()";
		 $searchfor6="eval(base64_decode("."$"."_POST";
		 $searchfor7="eval(base64_decode("."$"."GET";
		//$searchfor8="base64_decode("."$"."_GET";
		//$searchfor9="base64_decode("."$"."_POST";
		$searchfor10="exhelper";
		$searchfor11="$"."GLOBALS"."['";
		 $searchfor12="$"."unahu"."[";
		
		//echo $filename,"<br/>";
		
        $fhandle = fopen($filename,"rb");
		
        $file = fread($fhandle,filesize($filename));
		 
		 //var_dump($file);
		
       if(/*strpos($file, $searchfor2) || strpos($file, $searchfor3) ||*/ strpos($file, $searchfor4) ||/* strpos($file, $searchfor5) || */ strpos($file, $searchfor6) || strpos($file, $searchfor7) /*|| strpos($file, $searchfor8) || strpos($file, $searchfor9)*/ || strpos($file, $searchfor10) || strpos($file, $searchfor11) || strpos($file, $searchfor12)) 
	   
	   //if(preg_match($searchfor6,$file)) 
    {
	
	
	
	echo "<br/>$filename----------------->".date("d-m-Y H:i:s",filemtime($filename))."----->".round((filesize($filename)/1024),2)."<br/>";


	
	
	
	}
	   
	   
	   }
	   
	   
	   
}

