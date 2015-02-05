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
<body class="no-js">
  <div id="main-slider" class="liquid-slider">
  
    <div style="background:white;">
      <h2 class="title" style="visibility:hidden; color:#000000" >Assets And Liabilities</h2>
      <p ><iframe src="../ac_assets.php" align="right" height="700" width="600"  frameborder="0"  ></iframe>
      <iframe src="../capital and liability.php" align="right" height="700" width="600"  frameborder="0"  ></iframe></p>
    </div>
    
     <div style="background:white;">
      <h2 class="title" style="visibility:hidden" >Expenses and Revenue</h2>
      <p ><iframe src="../expenseandrevenue1.php" align="right" height="700" width="600"  frameborder="0"  ></iframe>
      <iframe src="../expenseandrevenue.php" align="right" height="700" width="600"  frameborder="0"  ></iframe></p>
    </div>
    
    
    
      <div style="background:white;">
      <h2 class="title" style="visibility:hidden" >Cash Flow</h2>
      <p >
     <iframe src="../cashflowgraph1.php" align="right" height="700" width="1250"  frameborder="0"  ></iframe>
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
