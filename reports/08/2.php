<?php
function revsort(&$array) {
	sort($array);
    $array = array_reverse($array);
}

$Array = [2,4,1,5,3];
echo implode(", ", $Array) . "<br>";
revsort($Array);
echo implode(", ", $Array);
?>
