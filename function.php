<?php

/**
 * Display graphic line with his values points.
 * @param array $params required array('Y-m-d' => value,...)
 * @param array $params options @h_size -> height & @$nbr_y : Number of Y lines
 * @return Html / svg
 */
function graphicCurvesPoints($res_date, $h_size = 350, $nbr_y = 5){

  //Affichage graphique line
  $array_date = array();
  foreach ($res_date as $key => $dates):
    $date = new DateTime($key);
    array_push($array_date, $date->format('Y-m-d'));
  endforeach;
  // echo 'compte : '.count($array_date);
  $date_min = new DateTime(min($array_date));
  $date_max = new DateTime(max($array_date));
  $current_date = new DateTime(min($array_date));
  // echo 'date '.$date_min->format('Y-m-d').' au '.$date_max->format('Y-m-d');
  $interval = $date_min->diff($date_max);
  $interval->format('%a');
  $count_values = $res_date;//array_count_values($array_date);

  /*Reglages sizes*/
  $view_x = 1;
  $size_graph = 500;
  $h_size=$h_size;//height table
  $nbr_y = $nbr_y;//nbr gird lines Y
  $ajuste_size_x = 1.5;
  /**/

  $val_max = max($count_values);
  $size = (round($h_size/10,2))*2;//45;
  $ajuste_size_y = round($h_size/100,2);//2.17
  $val_index = $val_max/$nbr_y;

  /*GENERATION HTML*/
  $grafic = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 '.$size_graph.' '.$h_size.'" style="position: fixed; left: -1000px; height: -1000px;">';
  $grafic .= '<defs>';
  $grafic .= '<g id="chart">';

    $grafic .= '<g id="Numbers">';

      //genere mes dates
      $points_users = '';

      for ($i=0; $i <= $interval->format('%a'); $i++):
        $prct_current_val = 0;
        $prct_current_val =  $count_values[$current_date->format('Y-m-d')]* 100 / $val_max;
        $prct_current_val = 100-$prct_current_val;
        $prct_val_y = round($prct_current_val,2)*$ajuste_size_y;
        $points_users .= $i * $size/$ajuste_size_x .','. $prct_val_y.' ';

        $grafic .= '<circle r="3" fill="#00888a" cy="'.$prct_val_y.'" cx="'.($i*$size/$ajuste_size_x).'" />';
        $grafic .= '<text x="'.(($i*$size/$ajuste_size_x)+5).'" y="'.$prct_val_y.'" fill="#00888a" font-family="Roboto" font-size="11" >'.($count_values[$current_date->format('Y-m-d')]).'</text>';
        $grafic .= '<text transform="matrix(1 0 0 1 '.(($i*$size/$ajuste_size_x)-15).' '.$h_size*0.95.')" fill="#888888" font-family="Roboto" font-size="11">'.$current_date->format('d-m').'</text>';

        $current_date->add(new DateInterval('P1D'));
      endfor;

      for ($a=0; $a <= $nbr_y ; $a++):
        $grafic .= '<text transform="matrix(1 0 0 1 5 '.($a* $size -5).')" fill="#888888" font-family="Roboto" font-size="11">'.round($val_max-$val_index*$a,0).'</text>';
      endfor;

    $grafic .= '</g>';
    $grafic .= '<g id="Gridlines">';

      for ($e=0; $e <= $interval->format('%a'); $e++):
        $grafic .= '<line fill="#888888" stroke="#e9e9e9" stroke-miterlimit="10" x1="'.($e*$size/$ajuste_size_x).'" y1="0" x2="'.($e*$size/$ajuste_size_x).'" y2="'.$h_size.'"/>';
       endfor;

      for ($u=0; $u <= $nbr_y ; $u++):
        $grafic .= '<line fill="#888888" stroke="#c7c7c7" stroke-miterlimit="10" x1="0" y1="'.($u*$size).'" x2="'.($i * $size/$ajuste_size_x).'" y2="'.($u*$size).'"/>';
      endfor;

    $grafic .= '</g>';
    $grafic .= '<g id="Layer_5">';

    //genere mes dates
    $points_users = '0,'.$h_size.' '.substr($points_users, 0).' '. $i * $size/$ajuste_size_x .','.$h_size;
    $grafic .= '<polygon opacity="0.36" stroke-miterlimit="10" points="'.$points_users.'" />';
  $grafic .= '</g>';

$grafic .= '</g>';
$grafic .= '</defs></svg>';

$grafic .= '<svg fill="currentColor" style="overflow: inherit;width:100%;min-width:'. ($i * $size/$ajuste_size_x).'px;height: '.$h_size.'px;" viewBox="0 -15 '. ($i * $size/$ajuste_size_x).' '.$h_size.'" class="demo-graph">';
$grafic .= '<use xlink:href="#chart"/>';
$grafic .= '</svg>';

return $grafic;

}

/**
 * Display graphic line with his values points.
 * @param array $params requierd  @valref -> value, @valmax -> value
 * @param array $params options @size , @border
 * @return Html / svg
 */
function graphicRroundStats($valmain,$valmax,$size_graph = 500,$border = 20){
  $valref = $size_graph;
  $size = $valref/2.75; //200;
  $r_b_size = (round($size/2,2));
  $stroke = 6;

  $count_session = $valmain;//array_count_values($session_array);
  $tot_sessions = $valmax;//calculTotValue($count_session);
  $prct_session =  $count_session * 100 / $tot_sessions;

  $grafic = '<svg fill="currentColor" width="'.$size.'px" height="'.$size.'px" class="svg_circle" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--3-col-desktop">';
  $grafic .= '<circle r="'.($valref/$stroke).'" cx="'.$r_b_size.'" cy="'.$r_b_size.'" class="new_circle" stroke="#4db6ac" fill="rgba(199, 199, 199, 0.1)" style="stroke-dasharray: '. converToPrct($prct_session, $valref).' '.$valref.';stroke-width: '.($border).';" />';
    $grafic .= '<text x="'.$r_b_size.'" y="'.($r_b_size+($size_graph/100)*5).'" font-family="Roboto" font-size="'.($size_graph/7).'" fill="#888" text-anchor="middle" dy="0.1">'.round($prct_session,0).'<tspan dy="-'.(($size_graph/100)*5).'" font-size="'.($size_graph/15).'">%</tspan></text>';
  $grafic .= '</svg>';

  return $grafic;
}

/*Functions*/
function converToPrct($val, $valref){
  $val_prct= round($val,5);
  $prct_val =  $val_prct/100 * $valref;
  return $prct_val;
}
?>
