<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Flot Examples</title>
    <link href="layout.css" rel="stylesheet" type="text/css"></link>
    <!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="../jquery.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.js"></script>
 </head>
    <body>
    <h1>Flot Examples</h1>

    <div id="placeholder" style="width:600px;height:300px"></div>

    <p>Flot supports lines, points, filled areas, bars and any
    combinations of these, in the same plot and even on the same data
    series.</p>

<script id="source" language="javascript" type="text/javascript">
$(function () {
  
    var d5 = [];
    for (var i = 0; i < 14; i += 0.5)
        d5.push([i, Math.sqrt(i)]);
                        
    $.plot($("#placeholder"), [
        {
            data: d5,
            lines: { show: true },
            points: { show: true }
        }
    ]);
});
</script>

 </body>
</html>
