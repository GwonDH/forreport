<?php
$arr = array(
    "Kim" => "Seoul",
    "Lee" => "Pusan, Daegu",
    "Choi" => "Inchon",
    "Park" => "Suwon, Daejon",
    "Jung" => "Kwangju, Chunchon, Wonju"
);
unset($arr["Choi"]);
foreach ($arr as $person => $cities) echo $person." : ".$cities."<br>";
?>
