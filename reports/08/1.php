<?php
for ($i=0; $i<9; $i++) {
	for ($j=0; $j<=($i<5?$i:8-$i); $j++) echo chr(65+$j);
	echo "<br>";
}
?>
