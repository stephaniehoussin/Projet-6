function initMap(position)
{
    var map = L.map('map-oneSpot').setView([position.coords.latitude, position.coords.longitude],9);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Données de la carte &copy; <a href="http://www.openstreetmap.org/#map=5/51.500/-0.100">Open Street Map</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken:'pk.eyJ1Ijoic3RlcGhhbmllaG91c3NpbiIsImEiOiJjamg1ejFrNDYxZnNyMnFsbmsxOXFoNmwxIn0.Cfc6uy_CpLtKoUjAKMQelg'
    }).addTo(map);

    for(var $i= 0; $i < $element.length; $i++)
    {
        var marker = new L.marker([$element[$i][1], $element[$i][2]])
            .bindPopup($element[$i][0])
            .addTo(map)
    }
}
if (navigator.geolocation)
    navigator.geolocation.getCurrentPosition(initMap);