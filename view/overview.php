<?php
?>


<div id="globe">
    <a href="">
        <img src="view/Images/globe.png" alt="globe">
    </a>
</div>
<div id="chartdiv"></div>
<div id="info"></div>
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/maps.js"></script>
<script src="https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/dark.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://www.amcharts.com/lib/4/geodata/lang/FR.js"></script>
<script>
    am4core.useTheme(am4themes_dark);
    am4core.useTheme(am4themes_animated);

    let map = am4core.create("chartdiv", am4maps.MapChart);
    let cd =  document.getElementById('chartdiv');
    // Set map definition
    map.geodata = am4geodata_worldLow;
    map.geodataNames = am4geodata_lang_FR;

    document.getElementById("globe").addEventListener("onclick",toggle3D);
    function toggle3D() {
        <?php
        if(isset($_SESSION['2D']) && $_SESSION['2D'])
            $_SESSION['2D'] = false;
        else
            $_SESSION['2D'] = true;
        ?>
        }

    // Set projection
    map.projection = <?php echo $_SESSION['proj'];?>;
    map.panBehavior = <?php echo $_SESSION['panB'];?>;

    // Create map polygon series
    let polygonSeries = map.series.push(new am4maps.MapPolygonSeries());

    // Add some custom data

    polygonSeries.data = <?php
    $string = '[{';

    foreach ($tab as $key => $id) {
        if(strtoupper($id["Departement"])=="INFO"){
            $color = "#bb1e27";
        }
        else if(strtoupper($id["Departement"])=="GEA"){
            $color = "#f0702f";
        }
        else if(strtoupper($id["Departement"])=="TC"){
            $color = "#e94663";
        }
        else if(strtoupper($id["Departement"])=="CHIMIE"){
            $color = "#87ba44";
        }
        else if(strtoupper($id["Departement"])=="MP"){
            $color = "#6f448d";
        }
        else if(strtoupper($id["Departement"])=="GB"){
            $color = "#00a7b8";
        }
        else if(strtoupper($id["Departement"])=="GEII"){
            $color = "#8a005d";
        }
        if (isset($_GET["Dep"])) {
            if ($id["Departement"] = strtoupper($id["Departement"]) == $_GET["Dep"]) {
                $string = $string . '"id": "' . $id['id'] . '",
                "description":"';
                foreach ($tab as $key2 => $idP) {
                    if($idP["id"]==$id["id"] and $key["idPartenariat"]==$key2["idPartenariat"]) {
                        if ($idP["Departement"] == $_GET["Dep"]) {
                            $string = $string . 'Il y a un partenariat '.strtoupper($idP["Departement"]).' à <a href=?action=read&idPartenariat=' . $idP['idPartenariat'] . '>' . $idP['Ville'] . '.</a><Br>';

                        }
                    }

                }
                $string=$string. '","color":"'.$color.'"},{';
            }

        }


        else{
            $string = $string . '"id": "' . $id['id'] . '",
                "description":"';
                foreach ($tab as $key2 => $idP) {
                    if($idP["id"]==$id["id"] and $key["idPartenariat"]==$key2["idPartenariat"]){
                        $string = $string . 'Il y a un partenariat '.strtoupper($idP["Departement"]).' à <a href=?action=read&idPartenariat=' . $idP['idPartenariat'] . '>' . $idP['Ville'] . '.</a><Br>';

                    }

                }
                $string=$string. '","color":"#0086c5"},{';
            }

    }
    echo substr($string,0,-2).']'?>;


    // Make map load polygon (like country names) data from GeoJSON
    polygonSeries.useGeodata = true;

    // Configure series
    let polygonTemplate = polygonSeries.mapPolygons.template;

    polygonTemplate.tooltipText = "{name}";
    polygonTemplate.fill = am4core.color("#DADBDD"); //Pays ne contenant pas de partenariat
    polygonTemplate.propertyFields.fill = "color";

    polygonTemplate.events.on("hit", function(ev){
        let data = ev.target.dataItem.dataContext;
        map.zoomToMapObject(ev.target);
        let info = document.getElementById("info");
        info.innerHTML = "<h3>" + data.name + " (" + data.id  + ")</h3>";
        if (data.description)
            info.innerHTML += data.description;
        else
            info.innerHTML += "<i>Aucun partenariat.</i>"
            info.innerHTML += "</Br><a href = ?action=create&id=" + data.id+ "> Ajouter un partenariat</a> ";

    });
    let imageSeries = map.series.push(new am4maps.MapImageSeries());
    imageSeries.mapImages.template.propertyFields.longitude = "longitude";
    imageSeries.mapImages.template.propertyFields.latitude = "latitude";
    imageSeries.mapImages.template.tooltipText = "{title}";
    imageSeries.mapImages.template.propertyFields.url = "url";

    let circle = imageSeries.mapImages.template.createChild(am4core.Circle);
    circle.radius = 3;
    circle.propertyFields.fill = "color";

    let circle2 = imageSeries.mapImages.template.createChild(am4core.Circle);
    circle2.radius = 1.9;
    circle2.propertyFields.fill = "color";


    circle2.events.on("inited", function(event){
        animateBullet(event.target);
    });


    function animateBullet(circle) {
        let animation = circle.animate([{ property: "scale", from: 1, to: 5 }, { property: "opacity", from: 1, to: 0 }], 1000, am4core.ease.circleOut);
        animation.events.on("animationended", function(event){
            animateBullet(event.target.object);
        });
    }

    let colorSet = new am4core.ColorSet();

    imageSeries.data = <?php
    $string = '[{';

    foreach ($tab as $key => $id) {
        if(strtoupper($id["Departement"])=="INFO"){
            $color = "#bb1e27";
        }
        else if(strtoupper($id["Departement"])=="GEA"){
            $color = "#f0702f";
        }
        else if(strtoupper($id["Departement"])=="TC"){
            $color = "#e94663";
        }
        else if(strtoupper($id["Departement"])=="CHIMIE"){
            $color = "#87ba44";
        }
        else if(strtoupper($id["Departement"])=="MP"){
            $color = "#6f448d";
        }
        else if(strtoupper($id["Departement"])=="GB"){
            $color = "#00a7b8";
        }
        else if(strtoupper($id["Departement"])=="GEII"){
            $color = "#8a005d";
        }
        if (isset($_GET["Dep"])) {
            if ($id["Departement"] == $_GET["Dep"]) {

                $string = $string . '"title": "' . $id['Ville'] . '",
 "latitude" : ' . $id['latitude'] . ',
"longitude" : ' . $id['longitude'] . ',
"color":"#F4D03F"},{';

            }
        }
        else{
            $string = $string . '"title": "' . $id['Ville'] . '",
 "latitude" : ' . $id['latitude'] . ',
"longitude" : ' . $id['longitude'] . ',
"color":"'.$color.'"},{';

        }
    }
    echo substr($string,0,-2).']'?>;


    // Create hover state and set alternative fill color
    let hs = polygonTemplate.states.create("hover");
    hs.properties.fill = am4core.color("#9e1e25");

    // Remove Antarctica
    polygonSeries.exclude = ["AQ"];

    // Add zoom control
   map.zoomControl = new am4maps.ZoomControl();
</script>