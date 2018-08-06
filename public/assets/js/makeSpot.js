function initMap(position)
{
    var map = L.map('map-makeSpot').setView([position.coords.latitude, position.coords.longitude],12);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Données de la carte &copy; <a href="http://www.openstreetmap.org/#map=5/51.500/-0.100">Open Street Map</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken:'pk.eyJ1Ijoic3RlcGhhbmllaG91c3NpbiIsImEiOiJjamg1ejFrNDYxZnNyMnFsbmsxOXFoNmwxIn0.Cfc6uy_CpLtKoUjAKMQelg'
    }).addTo(map);

    var marker = L.marker([position.coords.latitude, position.coords.longitude],{
        draggable: 'true',
    }).addTo(map);
    $("#spot_latitude").val(position.coords.latitude);
    $("#spot_longitude").val(position.coords.longitude);

    marker.on('dragend', function(event){
        position = marker.getLatLng();
        marker.setLatLng(position,
            {
                draggable: 'true'
            }).bindPopup(position).update();
        $("#spot_latitude").val(position.lat);
        $("#spot_longitude").val(position.lng).keyup();
    });

    $("#spot_latitude, #spot_longitude").change(function(){
        position = [parseInt($("#spot_latitude").val()), parseInt($("#spot_longitude").val())];
        marker.setLatLng(position, {
            draggable: 'true'
        }).bindPopup(position).update();
        map.panTo(position);
    })
}
if (navigator.geolocation)
    navigator.geolocation.getCurrentPosition(initMap);
