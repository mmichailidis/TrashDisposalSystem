@extends('main')
@section('title' , '| Καλώς Ήρθατε')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3>My Google Maps Demo</h3>
                <div id="googleMap" style="width:100%;height:400px;"></div>

                <script>
                    var locations = [
                            @foreach($village as $vi)
                        ['{{$vi->name}}', {{$vi->latitude}}, {{$vi->longitude}}, {{$vi->id}} ],
                        @endforeach
                    ];

                    function myMap() {
                        var Serres = new google.maps.LatLng(41.092083, 23.541016);
                        var mapCanvas = document.getElementById("googleMap");
                        var mapOptions = {center: Serres, zoom: 11};
                        var map = new google.maps.Map(mapCanvas, mapOptions);
                        var marker = new google.maps.Marker({
                            position: Serres,
                            animation: google.maps.Animation.BOUNCE
                        });
                        marker.setMap(map);
                        var infowindow = new google.maps.InfoWindow({});
                        var marker2, i;
                        for (i = 0; i < locations.length; i++) {
                            marker2 = new google.maps.Marker({
                                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                                map: map,
                                animation: google.maps.Animation.BOUNCE
                            });
                            google.maps.event.addListener(marker2, 'click', (function (marker2, i) {
                                return function () {
                                    infowindow.setContent(locations[i][0]);
                                    infowindow.open(map, marker2);
                                    document.getElementById("demo").innerHTML = (locations[i][0]);

                                }
                            })(marker2, i));
                        }

                        var destination = [];
                        @foreach($village as $v)
                         destination.push(new google.maps.LatLng({{$v->latitude}}, {{$v->longitude}}));
                        @endforeach

                        for(var a=0, n = destination.length; a<n; a++) {
                            var coordinates = new Array();
                            for (var j = a; j < a+2 && j < n; j++) {
                                coordinates[j-a] = destination[j];
                            }

                            var lineSymbol = [{
                                icon: {path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW},
                                offset: '100%',
                            }];
                            var polylineOptions = {path: coordinates, icons: lineSymbol};
                            var polyline = new google.maps.Polyline( polylineOptions);



                            polyline.setMap(map);
//                            polylines.push(polyline);
                        }

                    }
                </script>

                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0ytnOS1jsLVniRSMiCZN3QyfOqBBcHJs&callback=myMap"></script>


            </div>
            <div class="col-sm-6">
                <div container>
                    <div class="button">
                        <button><span>Click Me</span></button>
                    </div>

                    <div class="pop-up">
                        <div class="content">
                            <div class="container">
                                <div class="dots">
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                </div>

                                <span class="close">close</span>

                                <div class="title">
                                    <h1>subscribe</h1>
                                </div>
                                <div class="form">
                                    <form onclick="myFunction()" action="" method="GET" id="form2">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label>Locations:</label>
                                            </div>
                                            <div class="col-md-5">
                                                <label id="demo">--</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label>Buckets:</label>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" name="buckets" id="buckets">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label>Limitsof the road:</label>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" name="limits" id="limits">
                                            </div>
                                        </div>
                                        <div class="row">
                                            </br>
                                            <input type="submit" value="Subscribe" onclick="myFunction2()"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{--Popup No2--}}

                </div>
            </div>
            <label id="field2">Buckets:</label>
            <script>
                $("button").click(function () {
                    $(".pop-up").addClass("open");
                });

                $(".pop-up .close").click(function () {
                    $(".pop-up").removeClass("open");
                });
            </script>
            <script>
                function myFunction2() {
                    document.getElementById("field2").value = document.getElementById("buckets").value;
                }
            </script>

            {{--<script>--}}
                {{--function myFunction2() {--}}
                    {{--document.getElementById("hi").innerHTML = "YOU CLICKED ME!";--}}
                    {{--// var x = document.getElementById("buckets").value;--}}
                    {{--var y = document.getElementById("limits").value;--}}
                {{--}--}}

                {{--$("io").click(function () {--}}
                    {{--$(".pop-up2").addClass("open");--}}
                {{--});--}}

                {{--$(".pop-up2 .close").click(function () {--}}
                    {{--$(".pop-up2").removeClass("open");--}}
                {{--});--}}
            {{--</script>--}}
        </div>
    </div>

@endsection

<link href="{{ asset('css/popup.css') }}" rel="stylesheet">