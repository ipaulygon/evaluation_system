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
        <div class="row">
            @foreach($properties as $property)
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header">
                            <center>
                                <img class="card-img-top" src="{{ URL::asset('assets/temp/images/model/model.jpg') }}" height="250px" width="100%" alt="Card image">
                            </center>
                        </div>
                        <div class="box-body">
                            <label for="">{{$property->appraisal->Property->property_name}}</label>
                            <label>Area: {{number_format($property->appraisal->Property->lot_area)}} m<sup>2</sup></label>
                            <label>Price: PhP {{number_format($property->price,2)}}</label>
                            <a href="/show_property/{{$property->appraisal->Property->id_property}}" class="btn btn-success btn-block">See Property</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-3">
        <form>
            <div class="form-group">
                <label for="region">Region:</label>
                <select class="form-control" id="region">
                    @foreach($regions as $region)
                        <option value="{{$region->id_region}}">{{$region->region_description}} ({{$region->region_code}})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="province">Province:</label>
                <select class="form-control" id="province">
                    @foreach($provinces as $province)
                        <option value="{{$province->id_province}}">{{$province->province_description}} ({{$province->province_code}})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="city">City/Municipality:</label>
                <select class="form-control" id="city">
                    @foreach($cities as $city)
                        <option value="{{$city->id_city}}">{{$city->city_description}} ({{$city->city_code}})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="barangay">Barangay:</label>
                <select class="form-control" id="barangay">
                    @foreach($barangays as $barangay)
                        <option value="{{$barangay->id_barangay}}">{{$barangay->barangay_description}} ({{$barangay->barangay_code}})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="model">Property Type:</label>
                <select class="form-control" id="model">
                    @foreach($models as $model)
                        <option value="{{$model->id_house_model}}">{{$model->house_model}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="budget">Minimum Budget:</label>
                <input type="text" class="form-control" id="minbudget">
            </div>
            <div class="form-group">
                <label for="budget">Maximum Budget:</label>
                <input type="text" class="form-control" id="maxbudget">
            </div>
            <button type="submit" class="btn btn-success btn-block">Find Property </button>
        </form>
    </div>
</div>
@stop

@section('script')
   <script src="{{ URL::asset('assets/js/home.js') }}"></script>
@stop
