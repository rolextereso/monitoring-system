<?php
	
// 	$movies = array(
//     array('Office Space' , 'Comedy' , 'Mike Judge' ),
//     array('Matrix' , 'Action' , 'Andy / Larry Wachowski' ),
//     array('Lost In Translation' , 'Comedy / Drama' , 'Sofia Coppola' ),
//     array('A Beautiful Mind' , 'Drama' , 'Ron Howard' ),
//     array('Napoleon Dynamite' , 'Comedy' , 'Jared Hess' )
// );

// echo '<table border="1">';
// echo '<tr><th>Movies</th><th>Genre</th><th>Director</th></tr>';
// foreach( $movies as $movie )
// {
//     echo '<tr>';
//     foreach( $movie as $key )
//     {
//         echo '<td>'.$key.'</td>';
//     }
//     echo '</tr>';
// }
// echo '</table>';

	// $array=array(
	// 			array("sample0","date0","300"),
	// 			array("sample1","date1","300"),
	// 			array("sample0","date0","300"),
	// 			array("sample1","date1","300"),
	// 			array("sample0","date0","300"),
	// 			array("sample1","date1","300")

	// 		);

	

	// for($i=0;$i<count($array);$i++){
		
	// 	for($y=0; $y<count($array[$i]);$y++){

	// 		echo $array[$i][$y];
	// 	}
		
	// }

	$array=array(
				array("product"=>"sample1","date"=>"date1","amount"=>"400"),
				array("product"=>"sample1","date"=>"date2","amount"=>"500"),
				array("product"=>"sample1","date"=>"date3","amount"=>"600"),
				array("product"=>"sample2","date"=>"date1","amount"=>"700"),
				array("product"=>"sample2","date"=>"date2","amount"=>"800"),
				array("product"=>"sample2","date"=>"date3","amount"=>"900")

			);


	function a($array){
		print_r($array);
    
	}

	a($array);

	 $record=array();

	$found=array();
	foreach($array as $row){
		$row_data=array();

	     	if(!in_array($row["product"],$found)){
	     		    array_push($found,$row["product"]);
			    	$row_data['name']=$row["product"];
					$row_data['data'][]=$row["amount"];
		       		$record[] = $row_data;
		    }elseif(in_array($row["product"],$found)){		
			    	$index =array_keys($found, $row["product"]);

				$record[$index[0]]["data"][]=$row["amount"];			
			}  
		    
	}

	//echo json_encode($record);
	// $storage_value=array();

	echo "<table border='1'>";
	echo " 	<tr>";
	echo "<th>Project</th><th>Date1</th><th>Date2</th><th>Date3</th>";
	// $i=0;
	// while(count($array)>$i){
	// 	if(in_array($array[$i][0],$array))
	// 	echo "<th>".$array[$i][0]."</th>";
	// 	$i++;
	// }
	echo "  </tr>";
	echo " <tbody>";

	for($i=0;$i<count($record);$i++){
		echo "<tr>";
		echo "<td>".$record[$i]['name']."</td>";
		for($y=0; $y<count($record[$i]['data']);$y++){

			echo "<td>".$record[$i]['data'][$y]."</td>";
		}
		echo "</tr>";
	}

	echo "</tbody>";
	echo "</table>";

	// $product=array();




?>