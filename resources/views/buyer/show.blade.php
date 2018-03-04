@extends('index')

@section('title', 'Lot')

@section('style')
    <style>
        body{
            background-color: #eee;
        }
        hr{
            border:1px solid grey!important;
        }
        label{
            display:block!important;
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$property->property_name}}</h3>
            </div>
            <div class="box-body">
                <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="3000" style="width:100%!important">
                    <ol class="carousel-indicators">
                        @foreach($property->pictures as $key => $image)
                            @if($key==0)
                            <li data-target="#myCarousel" data-slide-to="{{$key}}" class="active"></li>                            
                            @else
                            <li data-target="#myCarousel" data-slide-to="{{$key}}"></li>                                                        
                            @endif
                        @endforeach
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        @foreach($property->pictures as $key => $image)
                            @if($key==0)
                            <div class="item active">
                                <center>
                                <img src="{{ URL::asset($image->picture_path) }}" >
                                </center>
                            </div>
                            @else
                            <div class="item">
                                <center>
                                <img src="{{ URL::asset($image->picture_path) }}" >
                                </center>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    </a>
                </div>
                <br>
                <hr>
                <h4>Details</h4>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Region: {{$property->propertyLocation->barangay->city->province->region->region_description}} ({{$property->propertyLocation->barangay->city->province->region->region_code}})</label>
                        <label for="">Province: {{$property->propertyLocation->barangay->city->province->province_description}} ({{$property->propertyLocation->barangay->city->province->province_code}})</label>
                        <label for="">City/Municipality: {{$property->propertyLocation->barangay->city->city_description}} ({{$property->propertyLocation->barangay->city->city_code}})</label>
                        <label for="">Barangay: {{$property->propertyLocation->barangay->barangay_description}} ({{$property->propertyLocation->barangay->barangay_code}})</label>
                        <label for="">Address: {{$property->propertyLocation->address}}</label>
                    </div>
                    <div class="col-md-6">
                        <label for="">Price: PhP {{number_format($property->appraisal->SellProperty->price,2)}}</label>
                        <label for="">Seller: {{$property->seller->first_name}} {{$property->seller->last_name}}</label>
                        <label for="">Contact: {{$property->seller->contact_number}}</label>
                        <label for="">Area: {{$property->lot_area}} sq. m.</label>
                        <span id="counter"><label for="">No. of Contacts: {{number_format($property->appraisal->SellProperty->counter)}}</label></span>
                    </div>
                </div>
                <hr>
                {{$property->appraisal->SellProperty->remarks}}
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Statistics</h3>
            </div>
            <div class="box-body">
                <input type="hidden" id="property" value="{{$property->id_property}}">
                <canvas id="statistics"></canvas>
                <div id="ranking"></div>
                <hr>
                <div id="googleMap" style="height:300px;width:100%;"></div>
                <button class="btn btn-block btn-flat btn-success" id="contact" type="button" title="Contact Me">Contact Me</button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalContact" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Contact Me</h4>
                </div>
                <div class="modal-body">
                    <div class="contactMessage">
                        <ul>
                            <li>Contact Person: {{$property->seller->first_name}} {{$property->seller->last_name}}</li>
                            <li>Contact No.: {{$property->seller->contact_number}}</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
    <script src="{{ URL::asset('assets/plugins/chartjs/Chart.js')}}"></script>
    <script src="{{ URL::asset('assets/js/showProperty.js') }}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDI-sORFyqmgMCfNE_qu0u9ehexRBcVCH8"></script>
    <script>
        function myMap() {
            var address = "{{$property->propertyLocation->address}}";
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'address': address
                }, 
                function(results, status) {
                    if(status == google.maps.GeocoderStatus.OK) {
                        new google.maps.Marker({
                            position: results[0].geometry.location,
                            map: map
                    });
                    map.setCenter(results[0].geometry.location);
                }
            });
            var mapProp = {
                zoom: 17,
                scrollwheel: true,
                draggable: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
        }

        $(document).ready(function(){
            myMap();
            var barangay = "{{$property->propertyLocation->barangay->id_barangay}}";
            var property = "{{$property->id_property}}";
            $.ajax({
                type: "POST",
                url: "/get_statistics",
                data: {barangay: barangay, property: property},
                cache: false,
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                dataType: "JSON",
                success:function(data){
                    console.log(data);
                    var ctx = document.getElementById('statistics').getContext('2d');
                    var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: 'line',
                        // The data for our dataset
                        data: {
                            labels: ["Minimum","Current","Maximum"],
                            datasets: [
                                {
                                    label: "Ranking",
                                    backgroundColor: null,
                                    borderColor: 'black',
                                    data: [data.min[0].minimum,data.current[0].current,data.max[0].maximum]
                                }
                            ]
                        },
                        
                        // Configuration options go here
                        options: {}
                    });
                    $('#ranking').html('<label>Ranking: '+data.rank[0].rank+' out of '+data.all[0].total+'</label>')
                }
            })
        });
    </script>
@stop