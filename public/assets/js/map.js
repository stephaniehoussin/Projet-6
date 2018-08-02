$(function() {

    var mymap = L.map('map', {
        center: ['48.8534', '2.3488'],
        zoom: 9,
    });

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: 'Données de la carte &copy; <a href="http://www.openstreetmap.org/#map=5/51.500/-0.100">Open Street Map</a>',
        maxZoom: 18
    }).addTo(map);

/*
    //INIT_GEOLOCATION
    let latitude = $('input#spot_latitude');
    let longitude = $('input#spot_longitude');

    function success(pos) {
        let cLong = pos.coords.longitude;
        let cLat = pos.coords.latitude;

        if(longitude.val() === "" && latitude.val() === "") {
            latitude.val(cLat);
            longitude.val(cLong);
        }
        mymap.flyTo([cLat,cLong], 10);
    }

    function error(err) {
        switch (err.code) {
            case err.TIMEOUT:
                cLat.val('temps de chargement dépassé');
                cLong.val('temps de chargement dépassé');
                break;

            case err.PERMISSION_DENIED:
                cLat.val('permission désaprouvée');
                cLong.val('permission désaprouvée');
                break;

            case err.POSITION_UNAVAILABLE:
                cLat.val('position indéterminée');
                cLong.val('position indéterminée');
                break;

            case err.UNKNOWN_ERRROR:
                cLat.val('erreur inconnue');
                cLong.val('erreur inconnue');
                break;
        }
    }

    let geo = navigator.geolocation;
    geo.getCurrentPosition(success,error,{maximumAge:10000,enableHighAccuracy:true});

    //END_GEOLOCATION*/

  /*  $().ready(function () {
        $.getJSON('http://127.0.0.1:8000/recherche-les-dernieres-observations',
            function(data) {

                let i = 0;
                data.forEach(function (datas) {

                    i++;
                    let layer = L.marker([datas.latitude,datas.longitude]);
                    let tab = [];
                    tab.push(layer);
                    console.log(datas);
                    L.featureGroup(tab).bindPopup(datas.ref.nomComplet).addTo(mymap);


                });
            }
        );
    });*/

});