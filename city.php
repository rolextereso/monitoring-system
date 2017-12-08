<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "us_cities");
$request = mysqli_real_escape_string($connect, $_GET["query"]);
$query = "
 SELECT zip, city FROM zips WHERE city LIKE '%{$request}%' OR zip LIKE '%{$request}%'
";

$result = mysqli_query($connect, $query);

$data = array();

if(mysqli_num_rows($result) > 0)
{
 while($row = mysqli_fetch_assoc($result))
 {
  $data[] = array(
                    'label'=>$row["city"],
                    'value'=>$row["city"].' ,'.$row['zip']
                );
 }
 echo json_encode($data);
}

?>