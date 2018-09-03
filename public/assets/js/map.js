$(function() {

    var mymap = L.map('map', {
        center: ['48.8534', '2.3488'],
        zoom: 9,
    });

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: 'Données de la carte &copy; <a href="http://www.openstreetmap.org/#map=5/51.500/-0.100">Open Street Map</a>',
        maxZoom: 18
    }).addTo(map);

});