@if(count($properties)!=0)
@foreach($properties as $property)
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <center>
                    <img class="card-img-top" src="{{ URL::asset($property->picture) }}" height="250px" width="100%" alt="Card image">
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
@else
<center>No results found.</center>
@endif