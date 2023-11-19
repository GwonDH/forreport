<?php
$filename = "client.txt";
$file = fopen($filename, 'r');
while ($line = fgets($file)) {
    $content = explode(' ', $line);
    if (intval($content[1]) >= 30) echo "Name : ",$content[0],", Age : ",$content[1],", Gender : ",$content[2],", Email : ",$content[3],"<br>";
}
?>
