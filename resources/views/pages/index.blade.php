@extends('main')
@section('title' , '| Καλώς Ήρθατε')
@section('content')
    <div>
        <h3>My Google Maps Demo</h3>
        <div id="googleMap" style="width:100%;height:400px;"></div>

        {{--<script async defer--}}
                {{--src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAY7MUrUKE60VHv-MolOuwADCelvq8Wk4E&callback=initMap">--}}
        {{--</script>--}}

        <script>
            var locations = [
                ['Athens', 37.9833333, 23.7333333 , 1],
                ['Serres', 41.0855556, 23.5497222, 2],
                ['Thessaloniki',40.6402778, 22.9438889, 3]
            ];
            function myMap() {
                var Thessaloniki = new google.maps.LatLng(40.6402778,22.9438889);
                var mapCanvas = document.getElementById("googleMap");
                var mapOptions = {center: Thessaloniki,zoom: 5};
                var map = new google.maps.Map(mapCanvas, mapOptions);
                var marker = new google.maps.Marker({position:Thessaloniki,animation: google.maps.Animation.BOUNCE});
                marker.setMap(map);
                var infowindow = new google.maps.InfoWindow({});
                var marker2, i;
                for (i = 0; i < locations.length; i++) {
                    marker2 = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map,
                        animation: google.maps.Animation.BOUNCE
                    });
                    google.maps.event.addListener(marker2, 'click', (function(marker2, i) {
                        return function() {
                            infowindow.setContent(locations[i][0]);
                            infowindow.open(map, marker2);
                        }
                    })(marker2, i));
                }
            }
        </script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0ytnOS1jsLVniRSMiCZN3QyfOqBBcHJs&callback=myMap"></script>


    </div>

    {{--<form action="" method="POST" id="form1">--}}
        {{--<label>Locations:</label>--}}
        {{--<input type="text" name="locations">--}}
        {{--<br>--}}
        {{--<label>Buckets:</label>--}}
        {{--<input type="text" name="buckets">--}}
        {{--<br>--}}
        {{--<label>Limitsof the road:</label>--}}
        {{--<input type="text" name="limits">--}}
    {{--</form>--}}

    {{--<form action="" method="POST" id="form2">--}}
        {{--<label>Capacity:</label>--}}
        {{--<input type="text" name="capacity">--}}
        {{--<br>--}}
    {{--</form>--}}

    {{--<form action="" method="POST" id="form3">--}}
        {{--<label>Input:</label>--}}
        {{--<input type="text" name="input">--}}
        {{--<br>--}}
    {{--</form>--}}

    {{--<form action="" method="POST" id="form4">--}}
        {{--<label>Changecable:</label>--}}
        {{--<input type="text" name="changecable">--}}
        {{--<br>--}}
    {{--</form>--}}
@endsection