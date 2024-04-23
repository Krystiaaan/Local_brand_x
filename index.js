// console.log("x"); To test if JS works

//map
document.addEventListener('DOMContentLoaded', function() {
    var platform = new H.service.Platform({
        'apikey': 'h1bCmu1tmdSnD-yPl_WvuFPWbEBQKKwfNSW36zSwUl8'
    });
    
    var defaultLayers = platform.createDefaultLayers();
    
    var map = new H.Map(
        document.getElementById('mapContainer'),
        defaultLayers.vector.normal.map,
        {
            zoom: 12,
            center: { lat: 50.004951, lng: 8.252870 }
        }
    );

    var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
    var ui = H.ui.UI.createDefault(map, defaultLayers, );
    

    function getMarkerIcon(id) {
        const svgCircle = `<svg width="30" height="30" version="1.1" xmlns="http://www.w3.org/2000/svg">
                              <g id="marker">
                                <circle cx="15" cy="15" r="10" fill="#0099D8" stroke="#0099D8" stroke-width="4" />
                                <text x="50%" y="50%" text-anchor="middle" fill="#FFFFFF" font-family="Arial, sans-serif" font-size="12px" dy=".3em">${id}</text>
                              </g></svg>`;
        return new H.map.Icon(svgCircle, {
            anchor: {
                x: 10,
                y: 10
            }
        });
    }

    function addMarker(position, id) {
        var marker = new H.map.Marker(position, {
            data: {
                id
            },
            icon: getMarkerIcon(id),
        });
    
        map.addObject(marker);
        return marker;
    }
    var latitude = document.getElementById('latitude').textContent;
    var longitude = document.getElementById('longitude').textContent;

    latitude = parseFloat(latitude);
    longitude = parseFloat(longitude);

    
    map.setCenter({ lat: latitude, lng: longitude });

    
    addMarker({ lat: latitude, lng: longitude }, 'New Marker');
});

//suggestions complete
window.addEventListener('DOMContentLoaded', (event) =>{
    var locationInput = document.getElementById('location');
    locationInput.addEventListener('input',fetchCitySuggestions);
});
function fetchCitySuggestions(){
    var dataList = document.getElementById('suggestions');
}