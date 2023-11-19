<?php
$filename='exam.txt';
$line=count(file($filename));
$content=file_get_contents($filename);
$blank=substr_count($content, " ");
$words=$blank+$line;
$chars=mb_strlen($content);

echo $line, "<br>", $words, "<br>", $chars;
?>
