(function ($) {
  "use strict";
  function mainMap() {
    var ib = new InfoBox();
    function locationData(
      locationImg,
      locationPrice,
      locationURL,
      locationTitle,
      locationHotel,
      locationBath,
      locationMinus
    ) {
      return (
        "" +
        '<div class="map-listing-item">' +
        '<div class="inner-box">' +
        '<div class="infoBox-close"><i class="icon-close"></i></div>' +
        '<div class="image-box">' +
        '<figure class="image"><img src="' + locationImg + '" alt=""></figure>' +
        "</div>" +
        '<div class="content">' +
        '<div class="price">' + locationPrice + '</div>' +
        '<h4><a href=' + locationURL + '>' + locationTitle + "</a></h4>" +
        '<div class="icon-box">' +
        '<div class="item">' +
        '<i class="flaticon-hotel"></i>' +
        '<p>' + locationHotel + '</p>' +
        '</div>' +
        '<div class="item">' +
        '<i class="flaticon-bath-tub"></i>' +
        '<p>' + locationBath + '</p>' +
        '</div>' +
        '<div class="item">' +
        '<i class="flaticon-minus-front"></i>' +
        '<p>' + locationMinus + '</p>' +
        '</div>' +
        '</div>' +
        "</div>" +
        "</div>"
      );
    }

    var locations = [
      [
        locationData(
          './../images/image-box/map-location-1.jpg',
          'AED 250,000',
          'property-single-v1.html',
          'City Walk Crestlane, Dubai',
          '5',
          '4',
          '3200'
        ),
        25.206669643718868,
        55.25704552524123,
        1,
        '<div></div>'
      ],
      // Other property locations remain unchanged
    ];

    var map = new google.maps.Map(document.getElementById("map"), {
      zoom: 12,
      scrollwheel: false,
      center: new google.maps.LatLng(25.206669643718868, 55.25704552524123),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      zoomControl: true,
      streetViewControl: false,
      gestureHandling: "cooperative"
    });

    var boxText = document.createElement("div");
    boxText.className = "map-box";
    var boxOptions = {
      content: boxText,
      disableAutoPan: false,
      alignBottom: true,
      maxWidth: 0,
      pixelOffset: new google.maps.Size(-134, -55),
      boxStyle: { width: "360px" },
      closeBoxMargin: "0",
      closeBoxURL: "",
      infoBoxClearance: new google.maps.Size(25, 25),
      isHidden: false,
      pane: "floatPane",
      enableEventPropagation: false
    };

    var allMarkers = [];
    for (var i = 0; i < locations.length; i++) {
      var overlaypositions = new google.maps.LatLng(locations[i][1], locations[i][2]),
        overlay = new CustomMarker(overlaypositions, map, { marker_id: i }, locations[i][4]);
      allMarkers.push(overlay);
      google.maps.event.addDomListener(
        overlay,
        "click",
        (function (overlay, i) {
          return function () {
            ib.setOptions(boxOptions);
            boxText.innerHTML = locations[i][0];
            ib.open(map, overlay);
          };
        })(overlay, i)
      );
    }
  }

  if (document.getElementById("map")) {
    google.maps.event.addDomListener(window, "load", mainMap);
  }
})(this.jQuery);