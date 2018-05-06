@extends('main')
@section('title' , '| Καλώς Ήρθατε')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3>Trash Disposal System</h3>
                <div id="googleMap" style="width:100%;height:85%;"></div>

                <script>
                    var locations = [
                            @foreach($village as $vi)
                        ['{{$vi->name}}', {{$vi->latitude}}, {{$vi->longitude}}, {{$vi->id}} ],
                        @endforeach
                    ];
                    var aa = '';

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
                                    aa = document.getElementById("demo").innerHTML = (locations[i][0]);

                                }
                            })(marker2, i));
                        }

                        var destination = [];
                        @foreach($villageConn as $con)
                        {{--@foreach($village as $v)--}}
                        {{--@if(($con->route_village)==($v->id))--}}
                        {{--destination.push(new google.maps.LatLng({{$v->latitude}}, {{$v->longitude}}));--}}
                        {{--@endif--}}
                        {{--@if(($con->connected_village)==($v->id))--}}
                        {{--destination.push(new google.maps.LatLng({{$v->latitude}}, {{$v->longitude}}));--}}
                        {{--@endif--}}
                        {{--@endforeach--}}
                        destination.push(new google.maps.LatLng({{$con->route_coord[0]->latitude}}, {{$con->route_coord[0]->longitude}}));
                        destination.push(new google.maps.LatLng({{$con->dest_coord[0]->latitude}}, {{$con->dest_coord[0]->longitude}}));
                                @endforeach

                        for (var a = 0, n = destination.length; a < n; a++) {
                            var coordinates = new Array();
                            for (var j = a; j < a + 2 && j < n; j++) {
                                coordinates[j - a] = destination[j];
                            }

                            var lineSymbol = [{
                                icon: {path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW},
                                offset: '100%',
                            }];
                            var polylineOptions = {path: coordinates, icons: lineSymbol};
                            var polyline = new google.maps.Polyline(polylineOptions);


                            polyline.setMap(map);
//                            polylines.push(polyline);
                        }

                    }


                    function myFunction2() {
                        $(".button").addClass('hidden');
                        $(".pop-up").addClass("hidden");
                        $(".pop-up2").removeAttr('hidden');

                        // var a = document.getElementById("buckets").value;
                        var x = document.getElementById("buckets").value;
                        var y = document.getElementById("limits").value;
                        var onoma = [];

                        $("#Loc").data("test", {first: onoma}).push(new townObj(aa, x, y));

                        console.log($("#Loc").data("test").first);

                        $("#demodemo").click(function () {
                            document.getElementById("Loc").innerHTML = $("#Loc").data("test").first.location;
                        });

                        document.getElementById("Loc").innerHTML = aa;
                        document.getElementById("Buck").innerHTML = x;
                        document.getElementById("Limits").innerHTML = y;
                    }

                    var townObj = class {
                        constructor(location, buck, limit) {
                            this._location = location;
                            this._buck = buck;
                            this._limit = limit;
                        }

                        get location() {
                            return this._location;
                        }

                        get buck() {
                            return this._buck;
                        }

                        get limit() {
                            return this._limit;
                        }


                        toString() {
                            return this._location + this._buck + this._limit;
                        }
                    }
                </script>

                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0ytnOS1jsLVniRSMiCZN3QyfOqBBcHJs&callback=myMap"></script>


            </div>
            {{--Pop Up Menus--}}
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
                                    <div id="form">
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
                                                <label>Limits of the road:</label>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" name="limits" id="limits">
                                            </div>
                                        </div>
                                        <div class="row">
                                            </br>
                                            <input type="button" value="Subscribe" onclick="myFunction2()"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pop-up2" hidden>
                        <div class="content">
                            <div class="container">
                                <div class="dots">
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                </div>
                                {{----------------------}}
                                <div class="title">
                                    <h1>subscribe</h1>
                                </div>
                                {{----------------------}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <label id="Locations">Locations</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label id="Loc">--</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label id="buck">Buckets</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label id="Buck">--</label>
                                        {{--<p id="demo666"></p>--}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label id="demo3">Limits of the road:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label id="Limits">--</label>
                                    </div>
                                </div>
                                {{--------FORM2--------------}}
                                <div class="form2">
                                    <div id="form2">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Vehicle:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="Vehicle" id="Vehicle">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Capacity:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="capacity" id="capacity">
                                            </div>
                                        </div>

                                        <div class="row">
                                            </br>
                                            <input type="button" value="Subscribe" id="demodemo"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>{{-- Content--}}
                    </div>{{-- pop-up2--}}
                </div>{{-- conatiner--}}
            </div>{{--End Popup Menus--}}
        </div>
    </div>

    <script>
        $("button").click(function () {
            $(".pop-up").addClass("open");
        });

        $(".pop-up .close").click(function () {
            $(".pop-up").removeClass("open");
        });
    </script>
@endsection

<link href="{{ asset('css/popup.css') }}" rel="stylesheet">