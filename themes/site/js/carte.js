var $ = jQuery;

if ($("#mapConsult").length > 0 ){
    var map = L.map('mapConsult').setView([49.3990733, 1.0984624], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var hIcon = L.icon({
        iconUrl: '/themes/site/img/marker.png',
        iconSize:     [52, 51],
        iconAnchor:   [25, 47],
    });

    var markerArray = [];
    var markers = L.markerClusterGroup();

    $(".markerConsult").each(function () {
        if  ($(this).data("lat") !== "" && $(this).data("lng") !== "") {
            var marker = L.marker([$(this).data("lat"), $(this).data("lng")], {icon: hIcon})
                .bindPopup($(this).data("titre")
                    + "<br>" + $(this).data("adress")
                    + "<br>" + $(this).data("ville")
                    + "<br>" + $(this).data("tel")
                    + "<br>" + $(this).data("horaire")
                    + "<br><a href=\"" + $(this).data("url") + "\">Voir le détail</a>"
                );
            markers.addLayer(marker);
            markerArray.push(marker);
        }
    });

    map.addLayer(markers);
    var group = L.featureGroup(markerArray);
    map.fitBounds(group.getBounds(), {padding: [25, 25]});

}


