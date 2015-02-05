

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

 <head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>B.I.M.S Graphs</title>

    <link href="layout.css" rel="stylesheet" type="text/css"></link>

    <!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->

    <script language="javascript" type="text/javascript" src="../jquery.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.dashes.js"></script>
	 <link href="css/common.css" rel="stylesheet" type="text/css">
	<link href="css/standard.css" rel="stylesheet" type="text/css">

 </head>
    <body>
      <center>
	 

    <table border="0" style="margin-top:-30px;">

     <tr>

      <td colspan="3"<strong>Hatchability Comparison</strong></td>

     </tr> 

     <tr>

      <td width="1px">

       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Hatchability &amp; Saleable Chicks %</span></span>

      </td>

      <td width="5px"></td>

      <td>

        <div id="placeholder" style="width:270px;height:270px;"></div>

      </td>

     <td  ><?php $i=5; ?>

	 		<table align="left">
			<tr>
			 <th><font color="red" > Num </font></th>
			 <th style="width:100px"><font color="red" > Flock Name </font></th>
			</tr>
	  

			  

        <?php

           include "config.php";

           $query3 = "SELECT distinct(flock) FROM hatchery_hatchrecord ORDER BY flock ASC ";
           $result3 = mysql_query($query3,$conn1); 
			$n=mysql_num_rows($result3);
           while($row3 = mysql_fetch_assoc($result3))

           { ?>

		   <tr>

		    <td align="left"><?php echo $i; $i=$i+5; ?> </td>

		    <td align="left" ><?php echo $row3['flock']; ?></td>

			</tr>

			

			<?php } ?>

		   </table>



     <!-- <td colspan="3" style="text-align:left;padding-left:110px">-->

        <?php

           /*include "config.php";

           $query3 = "SELECT distinct(flock) FROM hatchery_hatchrecord ORDER BY flock ASC ";

           $result3 = mysql_query($query3,$conn1); 

           $i = 3;

           while($row3 = mysql_fetch_assoc($result3))

           {

		    

		   */

         ?>  

           <!--<font color="red" style="padding-right:65px">( <?php// echo $row3['flock']; ?> )</font>-->

  

       <?php

          //$i = $i + 3;}  

       ?>



     </td>

     </tr> 

   </table>

    </center>

<script id="source" language="javascript" type="text/javascript">

$(function () {





    var d2 = [

        <?php

           include "config.php";

           $query3 = "SELECT h1.flock, sum( h2.noofeggsset ) AS totaleggset, sum( h2.hatch ) AS hatch , h1.code FROM `hatchery_traysetting` h1, hatchery_hatchrecord h2 WHERE h1.flock = h2.flock AND h1.hatchdate = h2.hatchdate GROUP BY h1.flock,h1.code ASC ";

           $result3 = mysql_query($query3,$conn1); 

           $i = 2;

           while($row3 = mysql_fetch_assoc($result3))

           {
		   
		   if($row3[code]=="CLA")
		   {
		    $clahatchper = ( $row3['hatch'] / $row3['totaleggset'] ) * 100;
              //$hatchper = $row3['hatchper'];

       ?>

			 [<?php echo $i; ?>, <?php echo $clahatchper; ?>], 
         <?php $i = $i + 5; }} ?>
			
             [, ]];

 var d3 = [

        <?php

           include "config.php";

           $query3 = "SELECT h1.flock, sum( h2.noofeggsset ) AS totaleggset, sum( h2.hatch ) AS hatch , h1.code FROM `hatchery_traysetting` h1, hatchery_hatchrecord h2 WHERE h1.flock = h2.flock AND h1.hatchdate = h2.hatchdate GROUP BY h1.flock,h1.code ASC ";

           $result3 = mysql_query($query3,$conn1); 

           $k =3;

           while($row3 = mysql_fetch_assoc($result3))

           {
		   
		   if($row3[code]=="F15")
		   {
			$f15hatchper = ( $row3['hatch'] / $row3['totaleggset'] ) * 100;
              //$hatchper = $row3['hatchper'];

       ?>

			 [<?php echo $k; ?>, <?php echo $f15hatchper; ?>], 
         <?php $k = $k + 5; }} ?>
			
             [, ]];   



    var d1 = [

        <?php

           include "config.php";

           $query3 = "SELECT h1.flock, sum( h2.noofeggsset ) AS totaleggset, sum( h2.saleablechicks ) AS saleablechicks, h1.code FROM `hatchery_traysetting` h1, hatchery_hatchrecord h2 WHERE h1.flock = h2.flock AND h1.hatchdate = h2.hatchdate GROUP BY h1.flock, h1.code ASC ";

           $result3 = mysql_query($query3,$conn1); 

           $j = 4;

           while($row3 = mysql_fetch_assoc($result3))

           {
				if($row3['code']=="CLA")
				{
              $clasaleper = ( $row3['saleablechicks'] / $row3['totaleggset'] ) * 100;

       ?>

             [<?php echo $j; ?>, <?php echo $clasaleper; ?>], 

         <?php $j = $j + 5; }} ?>

             [, ]];

 var d4 = [

        <?php

           include "config.php";

           $query3 = "SELECT h1.flock, sum( h2.noofeggsset ) AS totaleggset, sum( h2.saleablechicks ) AS saleablechicks, h1.code FROM `hatchery_traysetting` h1, hatchery_hatchrecord h2 WHERE h1.flock = h2.flock AND h1.hatchdate = h2.hatchdate GROUP BY h1.flock, h1.code ASC ";

           $result3 = mysql_query($query3,$conn1); 

           $l = 5;

           while($row3 = mysql_fetch_assoc($result3))

           {
			  if($row3['code']=="F15"){
              $f15saleper = ( $row3['saleablechicks'] / $row3['totaleggset'] ) * 100;

       ?>

             [<?php echo $l; ?>, <?php echo $f15saleper; ?>], 

         <?php $l = $l + 5;} } ?>

             [, ]];








  var plot =   $.plot($("#placeholder"),

           [  { data: d2, label: "CLA Hatc % "},{ data: d3, label: "F15 Hatc % " },

             { data: d1, label: "CLA SalChick%"} ,{ data: d4, label: "F15 SalChick%"}],

           { 

             grid: { hoverable: true, clickable: true },

             bars: { show: true },

             xaxis: { min: 1, max: 26,

                      tickSize: 5,

					  label: "test"

                    },

             yaxis: { min: 0, max: 100, tickSize: 10 },

             y2axis: { min : 0, max: 100, tickSize: 10 },

             legend: { margin: [-120,-10] } 

    });



    function showTooltip(x, y, contents) {

        $('<div id="tooltip">' + contents + '</div>').css( {

            position: 'absolute',

            display: 'none',

            top: y + 5,

            left: x + 5,

            border: '1px solid #fdd',

            padding: '2px',

            'background-color': '#fee',

            opacity: 0.80

        }).appendTo("body").fadeIn(200);

    }



    var previousPoint = null;

    $("#placeholder").bind("plothover", function (event, pos, item) {

        $("#x").text(pos.x.toFixed(2));

        $("#y").text(pos.y.toFixed(2));



        if (1) {

            if (item) {

                if (previousPoint != item.datapoint) {

                    previousPoint = item.datapoint;

                    

                    $("#tooltip").remove();

                    var x = item.datapoint[0].toFixed(0),

                        y = item.datapoint[1].toFixed(2);

                    

                    showTooltip(item.pageX, item.pageY,

                                item.series.label + " is " + y);

                }

            }

            else {

                $("#tooltip").remove();

                previousPoint = null;            

            }

        }

    });



    $("#placeholder").bind("plotclick", function (event, pos, item) {

        if (item) {

            $("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");

            plot.highlight(item.series, item.datapoint);

        }

    });

});

</script>

 </body>

</html>













