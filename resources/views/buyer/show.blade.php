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
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1" class=""></li>
                        <li data-target="#myCarousel" data-slide-to="2" class=""></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <center>
                            <img class="first-slide" src="{{ URL::asset('assets/temp/images/model/model.jpg') }}" alt="First slide">
                            </center>
                        </div>
                        <div class="item">
                            <center>
                            <img class="second-slide" src="{{ URL::asset('assets/temp/images/model/model.jpg') }}" alt="Second slide">
                            </center>
                        </div>
                        <div class="item">
                            <center>
                            <img class="third-slide" src="{{ URL::asset('assets/temp/images/model/model.jpg') }}" alt="Third slide">
                            </center>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    </a>
                </div>
                <br>
                INSERT PICS
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
                        <label for="">Seller: {{$property->seller->first_name}} {{$property->seller->last_name}}</label>
                        <label for="">Contact: {{$property->seller->contact_number}}</label>
                        <label for="">Area: {{$property->lot_area}} m<sup>2</sup></label>
                        <label for="">Effective Age: {{$property->effective_age}}</label>
                        <label for="">No. of Contacts:</label>
                    </div>
                </div>
                <hr>
                INSERT MAP
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
                <button id="contact" type="button" title="Contact Me">Contact Me</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
    <script src="{{ URL::asset('assets/plugins/chartjs/Chart.js')}}"></script>
    <script src="{{ URL::asset('assets/js/showProperty.js') }}"></script>
    <script>
        $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: "/get_statistics",
                data: {barangay: "{{$property->propertyLocation->barangay->id_barangay}}", property: "{{$property->id_property}}"},
                cache: false,
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                dataType: "JSON",
                success:function(data){
                    var ctx = document.getElementById('statistics').getContext('2d');
                    var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: 'line',
                        // The data for our dataset
                        data: {
                            labels: ["{{$property->propertyLocation->barangay->barangay_description}} ({{$property->propertyLocation->barangay->barangay_code}})"],
                            datasets: [
                                {
                                    label: "Minimum",
                                    backgroundColor: 'rgb(255, 99, 132)',
                                    borderColor: 'rgb(255, 99, 132)',
                                    data: [data.min[0].minimum]
                                },
                                {
                                    label: "Current",
                                    backgroundColor: 'rgb(255, 99, 132)',
                                    borderColor: 'rgb(255, 99, 132)',
                                    data: [data.current[0].current]
                                },
                                {
                                    label: "Maximum",
                                    backgroundColor: 'rgb(255, 99, 132)',
                                    borderColor: 'rgb(255, 99, 132)',
                                    data: [data.max[0].maximum]
                                }
                            ]
                        },
                        
                        // Configuration options go here
                        options: {}
                    });
                }
            })
        });
    </script>
@stop