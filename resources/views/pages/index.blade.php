@extends('main')
@section('title' , '| Καλώς Ήρθατε')
@section('content')


    <h3 style="text-align:center;">Trash Disposal System</h3>

    <div id="googleMap" style="width:100%;height:100%;"></div>

    <input type="file" id="fileSelect" value="import" name="import">

    {{--Pop Up1 Menus--}}
    <div class="col-sm-6">
        <div class="container">
            <div class="button">
                <div>
                    <input type="button" value="Check Routes" onclick="myFunction2()"/>
                </div>
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
                        </div>{{---------End form-------------}}
                    </div>{{---------End Conatiner-------------}}
                </div>{{---------End Content-------------}}
            </div> {{---------End PopUp1-------------}}
        </div>{{-- conatiner--}}
    </div> {{--End Col--}}
    {{--End Popup Menus--}}




    {{---------PopUp2-------------}}
    <div class="pop-up2" hidden>
        {{--<div class="col-sm-6" id="ion">--}}
        <div class="w3-container w3-center w3-animate-top">
            <div class="dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
            {{----------------------}}

            {{--------FORM2--------------}}
            <div class="formbox">
                <div class="w3-theme-l3">
                    {{--<div style="min-width:400px">--}}
                    <div class="w3-panel w3-white w3-card w3-display-container">

                                </div>

                                <div class="row">
                                    </br>
                                    <div class="ButStyle">
                                        <div class="b1class">
                                            <input type="button" value="B1" class="b1"
                                                   onclick="b1Callback()" style="width: 100%"/>
                                        </div>
                                        <div class="b2class">
                                            <input type="button" value="B2" class="b2"
                                                   onclick="b2Callback()" style="width: 100%"/>
                                        </div>
                                        <div class="b3class">
                                            <input type="button" value="B3" class="b3"
                                                   onclick="b3Callback()" style="width: 100%"/>
                                        </div>
                                        <div class="b4class">
                                            <input type="button" value="B4" class="b4"
                                                   onclick="b4Callback()" style="width: 100%"/>
                                        </div>
                                        <input type="button" value="B5" style="width: 100%"/>
                                        <input type="button" value="B6" style="width: 100%"/>
                                        <input type="button" value="Check Routes" id="demodemo" style="width: 100%"/>
                                    </div>
                                </div>
                            </div>{{-- End Form2--}}
                        </div>
                    </div>
                </div>

    <div class="div1">

    </div>

    <script>
        var locations = [
                @foreach($village as $vi)
            ['{{$vi->name}}', {{$vi->latitude}}, {{$vi->longitude}}, {{$vi->id}} ],
            @endforeach
        ];
        var aa = '';

        function myMap(jsonData = null) {
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

                arrowDrawer(jsonData);
            }

            function arrowDrawer(jsonData) {
                var destination = [];
                var coordinates = new Array();
                if (jsonData === null) {
                    @foreach($villageConn as $con)
                    destination.push([
                        new google.maps.LatLng({{$con->route_coord[0]->latitude}}, {{$con->route_coord[0]->longitude}}),
                        new google.maps.LatLng({{$con->dest_coord[0]->latitude}}, {{$con->dest_coord[0]->longitude}})
                    ]);

                    @endforeach
                } else {
                    var myData = jsonData;
                    var explodeData = myData.split(":");
                    for (var ar = 1, maxAr = explodeData.length; ar < maxAr; ar++) {
                        var line = explodeData[ar].trim().substr(1, explodeData[ar].length - 2);
                        var previousLine = explodeData[ar - 1].trim().substr(1, explodeData[ar - 1].length - 2);

                        var lastExpl = line.split(',');
                        var previousLastExpl = previousLine.split(',');
                        destination.push([
                            new google.maps.LatLng(previousLastExpl[1], previousLastExpl[2]),
                            new google.maps.LatLng(lastExpl[1], lastExpl[2])
                        ]);
                    }
                }

                for (var a = 0, max = destination.length; a < max; a++) {
                    var coordinates = [];
                    coordinates[0] = destination[a][0];
                    coordinates[1] = destination[a][1];

                    if (jsonData === null) {
                        var lineSymbol = [{
                            icon: {path: google.maps.SymbolPath.LINE},
                            offset: '100%',
                        }];
                    } else {
                        var lineSymbol = [{
                            icon: {path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW},
                            offset: '100%',
                        }];
                    }

                    var polylineOptions = {path: coordinates, icons: lineSymbol};
                    var polyline = new google.maps.Polyline(polylineOptions);

                    polyline.setMap(map);
                }
            }
        }

        function b1Callback() {
            $.ajax({
                url: "http://localhost:8000/demo",
                type: "POST",
                success: function (data) {
                    myMap(data.path)
                },
                error: function (req, status, err) {
                    console.log('something went wrong', status, err);
                }
            });
        }

        function b2Callback() {
            $.ajax({
                url: "http://localhost:8000/b2",
                type: "POST",
                success: function (data) {
                    myMap(data.path)
                },
                error: function (req, status, err) {
                    console.log('something went wrong', status, err);
                }
            });
        }

        function b3Callback() {
            $.ajax({
                url: "http://localhost:8000/b3",
                type: "POST",
                success: function (data) {
                    myMap(data.path)
                },
                error: function (req, status, err) {
                    console.log('something went wrong', status, err);
                }
            });
        }

        function b4Callback() {
            $.ajax({
                url: "http://localhost:8000/b4",
                type: "POST",
                success: function (data) {
                    myMap(data.path)
                },
                error: function (req, status, err) {
                    console.log('something went wrong', status, err);
                }
            });
        }

        var files;
        $('input[type=file]').on('change', importFile);

        function importFile() {
            files = event.target.files;
            console.log(files);

            $.ajax({
                url: "http://localhost:8000/calculate",
                type: "POST",
                data: files,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function () {
                    console.log('hi');
                },
                error: function (req, status, err) {
                    console.log('something went wrong', status, err);
                }
            });
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
        };


        $("button").click(function () {
            $(".pop-up").addClass("open");
        });

        $(".pop-up .close").click(function () {
            $(".pop-up").removeClass("open");
        });

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0ytnOS1jsLVniRSMiCZN3QyfOqBBcHJs&callback=myMap"></script>
@endsection

<link href="{{ asset('css/popup.css') }}" rel="stylesheet">
<link href="{{ asset('css/popup2.css') }}" rel="stylesheet">
<link href="{{ asset('css/click-me.css') }}" rel="stylesheet">