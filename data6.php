
<!--<div>
<frameset rows="70%,*" border="0"  >
<frameset cols="45%,45%,*">
    <frame src="production/flot/graphs/comparesales1.php?fdate=01.05.2013&tdate=07.11.2013" scrolling="no">
    <!--<frame src="flot/graphs/cashflow2.php" scrolling="no">-->
   <!-- <frame src="Flot Pie Chart/categorywisesalesgraph.php" scrolling="no" />
  
    <frame src="data3.php" scrolling="no">
</frameset>
    <frameset cols="*">
    <frame src="data3.php"  scrolling="no">
    </frameset>
</frameset>
</div>-->
<html>
	<head>
    <link type="text/css" href="css/common.css" />
    <style type="text/css">
    .button {
	
/*display: block;
width: 115px;
height: 25px;
background: #4E9CAF;
padding: 10px;
text-align: center;
border-radius: 5px;
color: white;
font-weight: bold;*/

	
    height: 25px;
  border-style: solid;
  border-width : 1px 1px 1px 1px;
  text-decoration : none;
  padding : 4px;
  border-color : #000000;
  font-weight: bold;
  color: black;
  
  

}
    </style>
    
    
    </head>
    <body>
    <div align="center">

	<a href="data6a.php"  target="frameforall" class="button">Profit And Loss</a>
   <a href="data6b.php"   target="frameforall" class="button">Assets And Liabilities</a> 

</div>
<iframe src="data6a.php"  height="700" width="1400"  frameborder="0"  name="frameforall" id="frameforall" ></iframe>
<!--<iframe src="Flot Pie Chart/expenseandrevenue.php" align="right" height="700" width="620"  frameborder="0"  ></iframe>
<iframe src="Flot Pie Chart/expenseandrevenue1.php" align="left" height="700" width="700" frameborder="0"  ></iframe>-->
</body>
</html>
