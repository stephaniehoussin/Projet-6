function initMap(position)
{
    var map = L.map('map').setView([position.coords.latitude, position.coords.longitude],12);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Données de la carte &copy; <a href="http://www.openstreetmap.org/#map=5/51.500/-0.100">Open Street Map</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken:'pk.eyJ1Ijoic3RlcGhhbmllaG91c3NpbiIsImEiOiJjamg1ejFrNDYxZnNyMnFsbmsxOXFoNmwxIn0.Cfc6uy_CpLtKoUjAKMQelg'
    }).addTo(map);


    var $elements =
        [
            {% for spot in spots %}
    {% if spots %}
    ["{{ spot.user }}", "{{ spot.id }}", "{{ spot.title }}", "{{ spot.category }}", "{{ spot.infosSupp }}", {{ spot.latitude }}, {{ spot.longitude }}],
    {% endif %}
    {% endfor %}
];


    for(var $i= 0; $i < $elements.length; $i++)
    {
        var url = window.location.host;
        var marker = new L.marker([$elements[$i][5], $elements[$i][6]])
            .bindPopup(
                '<div class="card-search">' +
                '<div class="card-body"> ' +
                '<p class="search-title"> Spot# '+$elements[$i][1] +'</p>' +
                '<p><span> Spoteur</span> : '+$elements[$i][0] +'</p>' +
                '<p><span> Catégorie</span> : '+$elements[$i][3] +'</p>' +
                '<p><span> Titre</span> : '+$elements[$i][2] +'</p>' +
                '<p><span> Adresse</span> : '+$elements[$i][4] +'</p>' +
                '</div>' +
                '<a href="http://'+ url +'/accueil/spot/'+$elements[$i][1]+'"  class="btn btn-primary">Voir le spot</a>' +
                '</div>')
            .addTo(map)
    }
}
if (navigator.geolocation)
    navigator.geolocation.getCurrentPosition(initMap);
