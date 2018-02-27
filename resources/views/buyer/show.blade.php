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
                        <label for="">Price: {{number_format($property->appraisal->first()->SellProperty->price,2)}}</label>
                        <label for="">Seller: {{$property->seller->first_name}} {{$property->seller->last_name}}</label>
                        <label for="">Contact: {{$property->seller->contact_number}}</label>
                        <label for="">Area: {{$property->lot_area}} sq. m.</label>
                        <label for="">Effective Age: {{$property->effective_age}}</label>
                        <span id="counter"><label for="">No. of Contacts: {{$property->appraisal->first()->SellProperty->counter}}</label></span>
                    </div>
                </div>
                <hr>
                {{$property->appraisal->first()->SellProperty->remakrs}}
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
                INSERT MAP
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
    <script>
        $(document).ready(function(){
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
                            labels: ["{{$property->propertyLocation->barangay->barangay_description}} ({{$property->propertyLocation->barangay->barangay_code}})"],
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
                    var rank = 0;
                    $.each(data.rank, function(key,value){
                        rank = (value.property==property ? value.rank : rank);
                    });
                    $('#ranking').html('<label>Ranking: '+rank+' out of '+data.all[0].total+'</label>')
                }
            })
        });
    </script>
@stop