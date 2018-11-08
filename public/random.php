<?php
echo $a = rand(1,19);
echo '<br>';
$b = rand(1,19);
while($a == $b){
    $b = rand(1,19);
}
echo $b;