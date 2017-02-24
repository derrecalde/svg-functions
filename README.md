# svg-functions
Graphique SVG functions

##This functions return SVG graphics of data for statistiques views
###How to use ?
- include('function.php');    
```echo graphicRroundStats(10,100);```

###Options   
####graphicRroundStats()   
- Required : $main_value   
- Required : $reference_value
- Options : $size_of_circle_value    
- Options: $size_of_border_value   

####graphicCurvesPoints()   
- Required : $array_of_data ('Y-m-d':value,...)   
- Options : $height_of_graphic    
- Options: $number_of_y_lines   
