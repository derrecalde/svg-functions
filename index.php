<?php include('function.php'); ?>

<div style="width:100%;overflow-y: hidden;overflow-x: inherit;" >
  <?php //Array with values by day for graphic line
  $graphic_line_points = array('2017-02-01'=>1,'2017-02-02'=>2,'2017-02-03'=>3,'2017-02-04'=>4,'2017-02-05'=>5, '2017-02-06'=>6, '2017-02-07'=>7, '2017-02-08'=>8,'2017-02-09'=>9,'2017-02-10'=>10,'2017-02-11'=>11,'2017-02-12'=>12,'2017-02-13'=>13,'2017-02-14'=>14,'2017-02-15'=>15);
  echo graphicCurvesPoints($graphic_line_points); ?>
</div>

<div class="mdl-cell mdl-cell--3-col" >
  <?php //return the graphic circle
  echo graphicRroundStats(10,100, 450, 15); ?>
</div>
