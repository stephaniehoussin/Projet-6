function initMap(position)
{
    var map = L.map('map-searchSpot').setView([position.coords.latitude, position.coords.longitude],12);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Données de la carte &copy; <a href="http://www.openstreetmap.org/#map=5/51.500/-0.100">Open Street Map</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken:'pk.eyJ1Ijoic3RlcGhhbmllaG91c3NpbiIsImEiOiJjamg1ejFrNDYxZnNyMnFsbmsxOXFoNmwxIn0.Cfc6uy_CpLtKoUjAKMQelg'
    }).addTo(map);

    for(var $i= 0; $i < $elements.length; $i++)
    {
        var url = window.location.host;
        var marker = new L.marker([$elements[$i][6], $elements[$i][7]])
            .bindPopup(
                '<div class="card-search">' +
                '<div class="card-body"> ' +
                '<p class="card-date"><i class="fa fa-calendar"> '+$elements[$i][5]+'</i></span> <i class="fa fa-user"> <span> '+$elements[$i][0] +'</span></i></p>' +
                '<p class="card-title"> Spot#'+$elements[$i][1] +' <span> - </span> : '+$elements[$i][2] +'</p>' +
                '<p class="card-infos"><i class="fa fa-map-marker">  '+$elements[$i][4] +'</i></p>' +
                '</div>' +
                '<a href="http://'+ url +'/accueil/spot/'+$elements[$i][1]+'"  class="btn btn-searchSpot">Voir le spot</a>' +
                '</div>')
            .addTo(map)
    }
}
if (navigator.geolocation)
    navigator.geolocation.getCurrentPosition(initMap);
