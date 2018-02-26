@extends('index')

@section('title', 'Home')

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
    <div class="col-md-9">
        <div class="row" id="searchResults">
            @foreach($properties as $property)
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header">
                            <center>
                                <img class="card-img-top" src="{{ URL::asset('assets/temp/images/model/model.jpg') }}" height="250px" width="100%" alt="Card image">
                            </center>
                        </div>
                        <div class="box-body">
                            <label>{{$property->property_name}}</label>
                            <label>Property Type: {{($property->property_type) ? "House and Lot" : "Lot"}}</label>
                            <label>Area: {{number_format($property->lot_area)}} sq. m.</sup></label>
                            <label>Price: PhP {{number_format($property->price,2)}}</label>
                            <a href="/show_property/{{$property->id_property}}" class="btn btn-success btn-block">See Property</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-3">
        <form id="formSearch">
            <div class="form-group">
                <label for="region">Region:</label>
                <select class="form-control" name="region" id="region">
                    @foreach($regions as $region)
                        <option value="{{$region->id_region}}">{{$region->region_description}} ({{$region->region_code}})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="province">Province:</label>
                <select class="form-control" name="province" id="province">
                    @foreach($provinces as $province)
                        <option value="{{$province->id_province}}">{{$province->province_description}} ({{$province->province_code}})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="city">City/Municipality:</label>
                <select class="form-control" name="city" id="city">
                    @foreach($cities as $city)
                        <option value="{{$city->id_city}}">{{$city->city_description}} ({{$city->city_code}})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="barangay">Barangay:</label>
                <select class="form-control" name="barangay" id="barangay">
                    @foreach($barangays as $barangay)
                        <option value="{{$barangay->id_barangay}}">{{$barangay->barangay_description}} ({{$barangay->barangay_code}})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="model">Property Type:</label>
                <select class="form-control" name="model" id="model">
                    <option value = "0">Lot</option>
                    <option value = "1">House and Lot</option>
                </select>
            </div>
            <div class="form-group">
                <label for="budget">Minimum Budget:</label>
                <input type="text" class="form-control" name="minbudget" id="minbudget">
            </div>
            <div class="form-group">
                <label for="budget">Maximum Budget:</label>
                <input type="text" class="form-control" name="maxbudget" id="maxbudget">
            </div>
            <button type="submit" id="search" class="btn btn-success btn-block">Find Property </button>
        </form>
    </div>
    <div id="loading" class="overlay hidden">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>
@stop

@section('script')
   <script src="{{ URL::asset('assets/js/home.js') }}"></script>
@stop
