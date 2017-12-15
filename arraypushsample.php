
<?php
$a=array(0=>"red","green");
array_push($a,"blue",1=>"2");
print_r($a);
?>

<?php
$array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');

$key = array_search('green', $array); // $key = 2;
$key = array_search('red', $array);   // $key = 1;
?>