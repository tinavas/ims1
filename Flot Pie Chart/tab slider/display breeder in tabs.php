<!DOCTYPE html>
<html lang="en-us">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1" />
  <meta name="description" content="Liquid Slider : The Last Responsive Content Slider You'll Ever Need" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <!-- Optionally use Animate.css -->
  <link rel="stylesheet" href="animate.min.css">
  <link rel="stylesheet" href="./css/liquid-slider.css">

  <title></title>
</head>
<body class="no-js" style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', Arial, Helvetica, sans-serif; " >
  <div id="main-slider" class="liquid-slider">
    <div>
      <h2 class="title" style="visibility:hidden" >Hatch Egg / Bird and Feed per Egg</h2>
      <p ><iframe src="../../flot/graphs/heggperbirdgraph1.php?unit=all&type=all" align="middle" height="700" width="600"  frameborder="0"  ></iframe>
      <iframe src="../../flot/graphs/feedperegg4.php" align="middle" height="700" width="600"  frameborder="0"  ></iframe>
      </p>
    </div>
    
     <!--<div>
      <h2 class="title" style="visibility:hidden" >Feed Per Egg</h2>
      <p ><iframe src="../../flot/graphs/feedperegg4.php" align="middle" height="600" width="1200"  frameborder="0"  ></iframe>
      </p>
    </div>-->
    
     <div>
      <h2 class="title" style="visibility:hidden" >Production Composition</h2>
      <p ><iframe src="../pgraphmonthwise.php" align="middle" height="700" width="600"  frameborder="0"  ></iframe>
      </p>
    </div>
    
   
  </div>
<footer>
  <script src="jquery.min.js"></script>
  <script src="jquery.easing.min.js"></script>
  <script src="jquery.touchSwipe.min.js"></script>
  <script src="./js/jquery.liquid-slider.min.js"></script>  
  <script>
    /**
     * If you need to access the internal property or methods, use this:
     * var api = $.data( $('#main-slider')[0], 'liquidSlider');
     * console.log(api);
     */
    $('#main-slider').liquidSlider();
  </script>
</footer>
</body>
</html>
