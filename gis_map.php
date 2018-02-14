<?php 
    require_once('layout/header.php');
    require_once('layout/nav.php');
    require_once('classes/function.php');
?>  
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="stylesheet" href="slsu_map/resources/ol.css">
        <link rel="stylesheet" href="slsu_map/resources/ol3-layerswitcher.css">
        <link rel="stylesheet" href="slsu_map/resources/qgis2web.css">
        <style>
        .ol-geocoder.gcd-gl-container {
            top: 65px!important;
        }
        .ol-geocoder .gcd-gl-btn {
            width: 21px!important;
            height: 21px!important;
        }
        </style>
        <style>
        html, body {
            background-color: #ffffff;
        }
        </style>
        <link href="slsu_map/resources/ol3-geocoder.min.css" rel="stylesheet">
        <style>
         #map {
            width: 100%;
            height: 100%;
            padding-top: 54px;
         }
          #location-map{
            position: absolute;
            top: 26px;
          }

          .ol-geocoder .gcd-gl-control {
           
            height: 34.1875em!important;
          }
        </style>



  <main role="main" class="col-sm-9 ml-sm-auto col-md-10" style="padding-left:0px;" > 
        
   <?php if(access_role("Location Map","view_page",$_SESSION['user_type'])){?>  
      

    <div id="map">
            <div id="popup" class="ol-popup">
                <a href="#" id="popup-closer" class="ol-popup-closer"></a>
                <div id="popup-content"></div>
            </div>
        </div>
        <script src="slsu_map/resources/qgis2web_expressions.js"></script>
        <script src="slsu_map/resources/proj4.js"></script>
        <script>proj4.defs('EPSG:4326','+proj=longlat +datum=WGS84 +no_defs');</script>
        <script src="slsu_map/resources/polyfills.js"></script>
        <script src="slsu_map/resources/functions.js"></script>
        <script src="slsu_map/resources/ol-debug.js"></script>
        <script src="slsu_map/resources/ol3-layerswitcher.js"></script>
        <script src="slsu_map/resources/ol3-geocoder.js"></script>
        <script src="slsu_map/layers/Tree_Park_Slsu_0.js"></script>
        <script src="slsu_map/layers/Duck_Production_Area_1.js"></script>
        <script src="slsu_map/layers/Building_Zone_Buffer_2.js"></script>
        <script src="slsu_map/layers/Rice_Land_Project_3.js"></script>
        <script src="slsu_map/layers/Slsu_PLAZA_HC_4.js"></script>
        <script src="slsu_map/layers/Cocoland_5.js"></script>
        <script src="slsu_map/layers/PAGSOW_6.js"></script>
        <script src="slsu_map/layers/Project_Area_7.js"></script><script src="slsu_map/layers/Canal_Main_Exit_8.js"></script>
        <script src="slsu_map/layers/Rice_uncol_3_9.js"></script>
        <script src="slsu_map/layers/Inter_Cropping_Area_10.js"></script>
        <script src="slsu_map/layers/Slsu_Mapping_2015_11.js"></script>
        <script src="slsu_map/layers/Irrigation_12.js"></script>
        <script src="slsu_map/layers/FutureInfra_13.js"></script>
        <script src="slsu_map/layers/ExistingIinfra_14.js"></script>
        <script src="slsu_map/layers/FutureRoad_15.js"></script>
        <script src="slsu_map/layers/canal_16.js"></script>
        <script src="slsu_map/layers/road_existing_17.js"></script>
        <script src="slsu_map/styles/Tree_Park_Slsu_0_style.js"></script>
        <script src="slsu_map/styles/Duck_Production_Area_1_style.js"></script>
        <script src="slsu_map/styles/Building_Zone_Buffer_2_style.js"></script>
        <script src="slsu_map/styles/Rice_Land_Project_3_style.js"></script>
        <script src="slsu_map/styles/Slsu_PLAZA_HC_4_style.js"></script>
        <script src="slsu_map/styles/Cocoland_5_style.js"></script>
        <script src="slsu_map/styles/PAGSOW_6_style.js"></script>
        <script src="slsu_map/styles/Project_Area_7_style.js"></script>
        <script src="slsu_map/styles/Canal_Main_Exit_8_style.js"></script>
        <script src="slsu_map/styles/Rice_uncol_3_9_style.js"></script>
        <script src="slsu_map/styles/Inter_Cropping_Area_10_style.js"></script>
        <script src="slsu_map/styles/Slsu_Mapping_2015_11_style.js"></script>
        <script src="slsu_map/styles/Irrigation_12_style.js"></script>
        <script src="slsu_map/styles/FutureInfra_13_style.js"></script>
        <script src="slsu_map/styles/ExistingIinfra_14_style.js"></script>
        <script src="slsu_map/styles/FutureRoad_15_style.js"></script>
        <script src="slsu_map/styles/canal_16_style.js"></script><script src="slsu_map/styles/road_existing_17_style.js"></script>
        <script src="slsu_map/layers/layers.js" type="text/javascript"></script> 
        <script src="slsu_map/resources/qgis2web.js"></script>
        <script src="slsu_map/resources/Autolinker.min.js"></script>

        <script>
            $(document).ready(function(){
                var button="<a href='location-map.php' title='Go to Satellite Map' id='location-map'><button> <i class='fa fa-map-marker'></i></button></a>";
                $('.gcd-gl-control').append(button);
            })
        </script>
    <?php }else{ echo UnauthorizedOpenTemp(); } ?>

</main>
  
  

<?php require_once('layout/footer.php');?>    