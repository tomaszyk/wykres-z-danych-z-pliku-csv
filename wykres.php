<?php

require 'polaczenie.php';

/**
 * Pobranie z bazy wszystkich rekordów
 */
$countries = $polaczenie -> query("SELECT country FROM people order by country");

$countriesDB[] = 0;

/**
 * Pętla sprawdza czy w tablicy $countriesDB istnieje taki klucz jak nazwa kraju, 
 * jeżeli tak to wartośść tego klucza jest zwiększana o jeden
 * jeżeli nie to tworzony jest nowy klucz o nazwie kraju
 */
while($country = mysqli_fetch_array($countries))
{
    $country_key = $country['country'];

    if(array_key_exists($country_key, $countriesDB))
    {
        $countriesDB[$country_key]++;
    }
    else
    {
        $countriesDB[$country_key] = 1;
    }
}

/**
 * Tworzenie tablicy do wykonania wykresy ($key to nazwa kraju a $value to ilość wystąpień tego kraju)
 */
$i = 0;
foreach($countriesDB as $key => $value)
{
    $dataPoints[$i] = array("label" => $key, "y" => $value);
    $i++;
}
	
?>


<!DOCTYPE HTML>
<head>
	<title>Wykres</title>
</head>
<html>
<head>  
	<!-- Skrypt tworzy wykres -->
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Simple Column Chart with Index Labels"
	},
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",   
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>                              