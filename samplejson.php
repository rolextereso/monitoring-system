<?php


$json_data = array(
				array(
							
							"showInLegend"	   => true,
							"name"			   => "Total Visit",
							"data"             => array(array("2015-07-11",15),array("2015-06-11",11),array("2015-05-11",5),array("2015-05-08",16)) 
					 ),
			    array(
							"showInLegend"	   => true,
							"name"			   => "Unique Visit",
							"data"            => array(array("2015-05-11",15),array("2015-06-12",11),array("2015-06-11",5))   // total data array
					 )
			);

echo json_encode($json_data);  // send data as json format

?>