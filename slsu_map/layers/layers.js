ol.proj.get("EPSG:4326").setExtent([125.179411, 10.395176, 125.196237, 10.408346]);
var wms_layers = [];
var format_Tree_Park_Slsu_0 = new ol.format.GeoJSON();
var features_Tree_Park_Slsu_0 = format_Tree_Park_Slsu_0.readFeatures(json_Tree_Park_Slsu_0, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Tree_Park_Slsu_0 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_Tree_Park_Slsu_0.addFeatures(features_Tree_Park_Slsu_0);var lyr_Tree_Park_Slsu_0 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Tree_Park_Slsu_0, 
                style: style_Tree_Park_Slsu_0,
                title: '<img src="styles/legend/Tree_Park_Slsu_0.png" /> Tree_Park_Slsu'
            });var format_Duck_Production_Area_1 = new ol.format.GeoJSON();
var features_Duck_Production_Area_1 = format_Duck_Production_Area_1.readFeatures(json_Duck_Production_Area_1, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Duck_Production_Area_1 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_Duck_Production_Area_1.addFeatures(features_Duck_Production_Area_1);var lyr_Duck_Production_Area_1 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Duck_Production_Area_1, 
                style: style_Duck_Production_Area_1,
                title: '<img src="styles/legend/Duck_Production_Area_1.png" /> Duck_Production_Area'
            });var format_Building_Zone_Buffer_2 = new ol.format.GeoJSON();
var features_Building_Zone_Buffer_2 = format_Building_Zone_Buffer_2.readFeatures(json_Building_Zone_Buffer_2, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Building_Zone_Buffer_2 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_Building_Zone_Buffer_2.addFeatures(features_Building_Zone_Buffer_2);var lyr_Building_Zone_Buffer_2 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Building_Zone_Buffer_2, 
                style: style_Building_Zone_Buffer_2,
                title: '<img src="styles/legend/Building_Zone_Buffer_2.png" /> Building_Zone_Buffer'
            });var format_Rice_Land_Project_3 = new ol.format.GeoJSON();
var features_Rice_Land_Project_3 = format_Rice_Land_Project_3.readFeatures(json_Rice_Land_Project_3, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Rice_Land_Project_3 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_Rice_Land_Project_3.addFeatures(features_Rice_Land_Project_3);var lyr_Rice_Land_Project_3 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Rice_Land_Project_3, 
                style: style_Rice_Land_Project_3,
                title: '<img src="styles/legend/Rice_Land_Project_3.png" /> Rice_Land_Project'
            });var format_Slsu_PLAZA_HC_4 = new ol.format.GeoJSON();
var features_Slsu_PLAZA_HC_4 = format_Slsu_PLAZA_HC_4.readFeatures(json_Slsu_PLAZA_HC_4, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Slsu_PLAZA_HC_4 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_Slsu_PLAZA_HC_4.addFeatures(features_Slsu_PLAZA_HC_4);var lyr_Slsu_PLAZA_HC_4 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Slsu_PLAZA_HC_4, 
                style: style_Slsu_PLAZA_HC_4,
                title: '<img src="styles/legend/Slsu_PLAZA_HC_4.png" /> Slsu_PLAZA_HC'
            });var format_Cocoland_5 = new ol.format.GeoJSON();
var features_Cocoland_5 = format_Cocoland_5.readFeatures(json_Cocoland_5, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Cocoland_5 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_Cocoland_5.addFeatures(features_Cocoland_5);var lyr_Cocoland_5 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Cocoland_5, 
                style: style_Cocoland_5,
                title: '<img src="styles/legend/Cocoland_5.png" /> Cocoland'
            });var format_PAGSOW_6 = new ol.format.GeoJSON();
var features_PAGSOW_6 = format_PAGSOW_6.readFeatures(json_PAGSOW_6, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_PAGSOW_6 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_PAGSOW_6.addFeatures(features_PAGSOW_6);var lyr_PAGSOW_6 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_PAGSOW_6, 
                style: style_PAGSOW_6,
                title: '<img src="styles/legend/PAGSOW_6.png" /> PAGSOW'
            });var format_Project_Area_7 = new ol.format.GeoJSON();
var features_Project_Area_7 = format_Project_Area_7.readFeatures(json_Project_Area_7, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Project_Area_7 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_Project_Area_7.addFeatures(features_Project_Area_7);var lyr_Project_Area_7 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Project_Area_7, 
                style: style_Project_Area_7,
                title: '<img src="styles/legend/Project_Area_7.png" /> Project_Area'
            });var format_Canal_Main_Exit_8 = new ol.format.GeoJSON();
var features_Canal_Main_Exit_8 = format_Canal_Main_Exit_8.readFeatures(json_Canal_Main_Exit_8, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Canal_Main_Exit_8 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_Canal_Main_Exit_8.addFeatures(features_Canal_Main_Exit_8);var lyr_Canal_Main_Exit_8 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Canal_Main_Exit_8, 
                style: style_Canal_Main_Exit_8,
                title: '<img src="styles/legend/Canal_Main_Exit_8.png" /> Canal_Main_Exit'
            });var format_Rice_uncol_3_9 = new ol.format.GeoJSON();
var features_Rice_uncol_3_9 = format_Rice_uncol_3_9.readFeatures(json_Rice_uncol_3_9, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Rice_uncol_3_9 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_Rice_uncol_3_9.addFeatures(features_Rice_uncol_3_9);var lyr_Rice_uncol_3_9 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Rice_uncol_3_9, 
                style: style_Rice_uncol_3_9,
                title: '<img src="styles/legend/Rice_uncol_3_9.png" /> Rice_uncol_3'
            });var format_Inter_Cropping_Area_10 = new ol.format.GeoJSON();
var features_Inter_Cropping_Area_10 = format_Inter_Cropping_Area_10.readFeatures(json_Inter_Cropping_Area_10, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Inter_Cropping_Area_10 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_Inter_Cropping_Area_10.addFeatures(features_Inter_Cropping_Area_10);var lyr_Inter_Cropping_Area_10 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Inter_Cropping_Area_10, 
                style: style_Inter_Cropping_Area_10,
                title: '<img src="styles/legend/Inter_Cropping_Area_10.png" /> Inter_Cropping_Area'
            });var format_Slsu_Mapping_2015_11 = new ol.format.GeoJSON();
var features_Slsu_Mapping_2015_11 = format_Slsu_Mapping_2015_11.readFeatures(json_Slsu_Mapping_2015_11, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Slsu_Mapping_2015_11 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_Slsu_Mapping_2015_11.addFeatures(features_Slsu_Mapping_2015_11);var lyr_Slsu_Mapping_2015_11 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Slsu_Mapping_2015_11, 
                style: style_Slsu_Mapping_2015_11,
                title: '<img src="styles/legend/Slsu_Mapping_2015_11.png" /> Slsu_Mapping_2015'
            });var format_Irrigation_12 = new ol.format.GeoJSON();
var features_Irrigation_12 = format_Irrigation_12.readFeatures(json_Irrigation_12, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_Irrigation_12 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_Irrigation_12.addFeatures(features_Irrigation_12);var lyr_Irrigation_12 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_Irrigation_12, 
                style: style_Irrigation_12,
                title: '<img src="styles/legend/Irrigation_12.png" /> Irrigation'
            });var format_FutureInfra_13 = new ol.format.GeoJSON();
var features_FutureInfra_13 = format_FutureInfra_13.readFeatures(json_FutureInfra_13, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_FutureInfra_13 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_FutureInfra_13.addFeatures(features_FutureInfra_13);var lyr_FutureInfra_13 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_FutureInfra_13, 
                style: style_FutureInfra_13,
                title: '<img src="styles/legend/FutureInfra_13.png" /> Future Infra'
            });var format_ExistingIinfra_14 = new ol.format.GeoJSON();
var features_ExistingIinfra_14 = format_ExistingIinfra_14.readFeatures(json_ExistingIinfra_14, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_ExistingIinfra_14 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_ExistingIinfra_14.addFeatures(features_ExistingIinfra_14);var lyr_ExistingIinfra_14 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_ExistingIinfra_14, 
                style: style_ExistingIinfra_14,
                title: '<img src="styles/legend/ExistingIinfra_14.png" /> Existing Iinfra'
            });var format_FutureRoad_15 = new ol.format.GeoJSON();
var features_FutureRoad_15 = format_FutureRoad_15.readFeatures(json_FutureRoad_15, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_FutureRoad_15 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_FutureRoad_15.addFeatures(features_FutureRoad_15);var lyr_FutureRoad_15 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_FutureRoad_15, 
                style: style_FutureRoad_15,
                title: '<img src="styles/legend/FutureRoad_15.png" /> Future Road'
            });var format_canal_16 = new ol.format.GeoJSON();
var features_canal_16 = format_canal_16.readFeatures(json_canal_16, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_canal_16 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_canal_16.addFeatures(features_canal_16);var lyr_canal_16 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_canal_16, 
                style: style_canal_16,
                title: '<img src="styles/legend/canal_16.png" /> canal'
            });var format_road_existing_17 = new ol.format.GeoJSON();
var features_road_existing_17 = format_road_existing_17.readFeatures(json_road_existing_17, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:4326'});
var jsonSource_road_existing_17 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_road_existing_17.addFeatures(features_road_existing_17);var lyr_road_existing_17 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_road_existing_17, 
                style: style_road_existing_17,
                title: '<img src="styles/legend/road_existing_17.png" /> road_existing'
            });

lyr_Tree_Park_Slsu_0.setVisible(true);lyr_Duck_Production_Area_1.setVisible(true);lyr_Building_Zone_Buffer_2.setVisible(true);lyr_Rice_Land_Project_3.setVisible(true);lyr_Slsu_PLAZA_HC_4.setVisible(true);lyr_Cocoland_5.setVisible(true);lyr_PAGSOW_6.setVisible(true);lyr_Project_Area_7.setVisible(true);lyr_Canal_Main_Exit_8.setVisible(true);lyr_Rice_uncol_3_9.setVisible(true);lyr_Inter_Cropping_Area_10.setVisible(true);lyr_Slsu_Mapping_2015_11.setVisible(true);lyr_Irrigation_12.setVisible(true);lyr_FutureInfra_13.setVisible(true);lyr_ExistingIinfra_14.setVisible(true);lyr_FutureRoad_15.setVisible(true);lyr_canal_16.setVisible(true);lyr_road_existing_17.setVisible(true);
var layersList = [lyr_Tree_Park_Slsu_0,lyr_Duck_Production_Area_1,lyr_Building_Zone_Buffer_2,lyr_Rice_Land_Project_3,lyr_Slsu_PLAZA_HC_4,lyr_Cocoland_5,lyr_PAGSOW_6,lyr_Project_Area_7,lyr_Canal_Main_Exit_8,lyr_Rice_uncol_3_9,lyr_Inter_Cropping_Area_10,lyr_Slsu_Mapping_2015_11,lyr_Irrigation_12,lyr_FutureInfra_13,lyr_ExistingIinfra_14,lyr_FutureRoad_15,lyr_canal_16,lyr_road_existing_17];
lyr_Tree_Park_Slsu_0.set('fieldAliases', {'id': 'id', 'tree_park': 'tree_park', 'area': 'area', 'YU': 'YU', });
lyr_Duck_Production_Area_1.set('fieldAliases', {'id': 'id', });
lyr_Building_Zone_Buffer_2.set('fieldAliases', {'id': 'id', 'plaza': 'plaza', 'PLAZA_AREA': 'PLAZA_AREA', });
lyr_Rice_Land_Project_3.set('fieldAliases', {'Rice_land': 'Rice_land', 'area': 'area', });
lyr_Slsu_PLAZA_HC_4.set('fieldAliases', {'id': 'id', 'plaza': 'plaza', 'PLAZA_AREA': 'PLAZA_AREA', });
lyr_Cocoland_5.set('fieldAliases', {'id': 'id', 'coconut': 'coconut', 'area_ha': 'area_ha', });
lyr_PAGSOW_6.set('fieldAliases', {'id': 'id', 'PAGSOW': 'PAGSOW', });
lyr_Project_Area_7.set('fieldAliases', {'id': 'id', 'prjectarea': 'prjectarea', 'kadak_on': 'kadak_on', });
lyr_Canal_Main_Exit_8.set('fieldAliases', {'id': 'id', 'canal_main': 'canal_main', 'katas-on': 'katas-on', });
lyr_Rice_uncol_3_9.set('fieldAliases', {'id': 'id', 'rice_uncol': 'rice_uncol', 'AREA': 'AREA', });
lyr_Inter_Cropping_Area_10.set('fieldAliases', {'id': 'id', 'inter_crop': 'inter_crop', 'AREA': 'AREA', 'KADAKO': 'KADAKO', });
lyr_Slsu_Mapping_2015_11.set('fieldAliases', {'id': 'id', });
lyr_Irrigation_12.set('fieldAliases', {'id': 'id', 'irragation': 'irragation', 'lent': 'lent', 'LLL': 'LLL', });
lyr_FutureInfra_13.set('fieldAliases', {'id': 'id', 'futurinfra': 'futurinfra', });
lyr_ExistingIinfra_14.set('fieldAliases', {'id': 'id', 'BUILDING': 'BUILDING', });
lyr_FutureRoad_15.set('fieldAliases', {'id': 'id', 'futureraod': 'futureraod', });
lyr_canal_16.set('fieldAliases', {'id': 'id', 'drainage': 'drainage', 'katas-on': 'katas-on', });
lyr_road_existing_17.set('fieldAliases', {'id': 'id', 'road': 'road', 'katas_on': 'katas_on', });
lyr_Tree_Park_Slsu_0.set('fieldImages', {'id': 'TextEdit', 'tree_park': 'TextEdit', 'area': 'TextEdit', 'YU': 'TextEdit', });
lyr_Duck_Production_Area_1.set('fieldImages', {'id': 'TextEdit', });
lyr_Building_Zone_Buffer_2.set('fieldImages', {'id': 'TextEdit', 'plaza': 'TextEdit', 'PLAZA_AREA': 'TextEdit', });
lyr_Rice_Land_Project_3.set('fieldImages', {'Rice_land': 'TextEdit', 'area': 'TextEdit', });
lyr_Slsu_PLAZA_HC_4.set('fieldImages', {'id': 'TextEdit', 'plaza': 'TextEdit', 'PLAZA_AREA': 'TextEdit', });
lyr_Cocoland_5.set('fieldImages', {'id': 'TextEdit', 'coconut': 'TextEdit', 'area_ha': 'TextEdit', });
lyr_PAGSOW_6.set('fieldImages', {'id': 'TextEdit', 'PAGSOW': 'TextEdit', });
lyr_Project_Area_7.set('fieldImages', {'id': 'TextEdit', 'prjectarea': 'TextEdit', 'kadak_on': 'TextEdit', });
lyr_Canal_Main_Exit_8.set('fieldImages', {'id': 'TextEdit', 'canal_main': 'TextEdit', 'katas-on': 'TextEdit', });
lyr_Rice_uncol_3_9.set('fieldImages', {'id': 'TextEdit', 'rice_uncol': 'TextEdit', 'AREA': 'TextEdit', });
lyr_Inter_Cropping_Area_10.set('fieldImages', {'id': 'TextEdit', 'inter_crop': 'TextEdit', 'AREA': 'TextEdit', 'KADAKO': 'TextEdit', });
lyr_Slsu_Mapping_2015_11.set('fieldImages', {'id': 'TextEdit', });
lyr_Irrigation_12.set('fieldImages', {'id': 'TextEdit', 'irragation': 'TextEdit', 'lent': 'TextEdit', 'LLL': 'TextEdit', });
lyr_FutureInfra_13.set('fieldImages', {'id': 'TextEdit', 'futurinfra': 'TextEdit', });
lyr_ExistingIinfra_14.set('fieldImages', {'id': 'TextEdit', 'BUILDING': 'TextEdit', });
lyr_FutureRoad_15.set('fieldImages', {'id': 'TextEdit', 'futureraod': 'TextEdit', });
lyr_canal_16.set('fieldImages', {'id': 'TextEdit', 'drainage': 'TextEdit', 'katas-on': 'TextEdit', });
lyr_road_existing_17.set('fieldImages', {'id': 'TextEdit', 'road': 'TextEdit', 'katas_on': 'TextEdit', });
lyr_Tree_Park_Slsu_0.set('fieldLabels', {'id': 'no label', 'tree_park': 'no label', 'area': 'no label', 'YU': 'no label', });
lyr_Duck_Production_Area_1.set('fieldLabels', {'id': 'no label', });
lyr_Building_Zone_Buffer_2.set('fieldLabels', {'id': 'no label', 'plaza': 'no label', 'PLAZA_AREA': 'no label', });
lyr_Rice_Land_Project_3.set('fieldLabels', {'Rice_land': 'no label', 'area': 'no label', });
lyr_Slsu_PLAZA_HC_4.set('fieldLabels', {'id': 'no label', 'plaza': 'no label', 'PLAZA_AREA': 'no label', });
lyr_Cocoland_5.set('fieldLabels', {'id': 'no label', 'coconut': 'no label', 'area_ha': 'no label', });
lyr_PAGSOW_6.set('fieldLabels', {'id': 'no label', 'PAGSOW': 'no label', });
lyr_Project_Area_7.set('fieldLabels', {'id': 'no label', 'prjectarea': 'no label', 'kadak_on': 'no label', });
lyr_Canal_Main_Exit_8.set('fieldLabels', {'id': 'no label', 'canal_main': 'no label', 'katas-on': 'no label', });
lyr_Rice_uncol_3_9.set('fieldLabels', {'id': 'no label', 'rice_uncol': 'no label', 'AREA': 'no label', });
lyr_Inter_Cropping_Area_10.set('fieldLabels', {'id': 'no label', 'inter_crop': 'no label', 'AREA': 'no label', 'KADAKO': 'no label', });
lyr_Slsu_Mapping_2015_11.set('fieldLabels', {'id': 'no label', });
lyr_Irrigation_12.set('fieldLabels', {'id': 'no label', 'irragation': 'no label', 'lent': 'no label', 'LLL': 'no label', });
lyr_FutureInfra_13.set('fieldLabels', {'id': 'no label', 'futurinfra': 'no label', });
lyr_ExistingIinfra_14.set('fieldLabels', {'id': 'no label', 'BUILDING': 'no label', });
lyr_FutureRoad_15.set('fieldLabels', {'id': 'no label', 'futureraod': 'no label', });
lyr_canal_16.set('fieldLabels', {'id': 'no label', 'drainage': 'no label', 'katas-on': 'no label', });
lyr_road_existing_17.set('fieldLabels', {'id': 'no label', 'road': 'no label', 'katas_on': 'no label', });
lyr_road_existing_17.on('precompose', function(evt) {
    evt.context.globalCompositeOperation = 'normal';
});