<?php


		     if($_SESSION["superstockistlist"]!="")
		       {
                 if($_SESSION["superstockistlist"]=="all")
			       {
			   
			         $q3="select group_concat(name separator '*') as names from contactdetails where superstockist='YES' and type like '%party%'";
			   
			         $q3=mysql_query($q3) or die(mysql_error());
			   
			         $r3=mysql_fetch_assoc($q3);
			   
			         $authorizedsuperstockist=explode("*",$r3["names"]);
			   
			      }
				  
			    else
			     {
			   $authorizedsuperstockist=explode(",",$_SESSION["superstockistlist"]);
			     }
			 }
       
	   $authorizedsuperstockistlist="'".str_replace("*","','",implode("*",$authorizedsuperstockist))."'";
	   
	   $q1=mysql_query("set group_concat_max_len=1000000000");
	


?>