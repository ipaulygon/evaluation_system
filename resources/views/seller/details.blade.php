<form role="form" data-toggle="validator" id="formView">
    <div class="modal-body">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <fieldset>
                        <div class="form-group  col-sm-12">
                            <label for="inputPropertyName">Property Name</label>
                            <input type="text" class="form-control" id="inputPropertyName" value="{{$property->property_name}}" readonly>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="inputPropertyType">Property Type</label>
                            <input type="text" class="form-control" id="inputPropertyType" value="{{($property->property_type ? 'House and Lot' : 'Lot')}}" readonly>                            
                        </div>
                        <div class="form-group  col-sm-12">
                            <label for="inputTCTNumber">TCT Number</label>
                            <input type="text" class="form-control" id="inputTCTNumber" value="{{$property->tct_number}}" readonly>
                        </div>
                        <div class="form-group  col-sm-12">
                            <label for="inputLotArea">Lot Area (sq. m.)</label>
                            <input class="form-control" id="inputLotArea" value="{{$property->lot_area}}" readonly>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="">Location</label>
                            <textarea class="form-control" readonly>{{$property->propertyLocation->address}}</textarea>
                        </div>
                        @if(count($appraisals) > 0)
                            <div class="form-group">
                                <label for="">Appraisal Details:</label>
                                <ul>
                                @foreach($appraisals as $appraisal)
								@if($appraisal->appraiseProperty)
									<li>PhP {{number_format($appraisal->appraiseProperty->total_property_value,2)}} - {{date('F j, Y',strtotime($appraisal->appraiseProperty->create_date))}} <label>by: {{$appraisal->appraiser->first_name}} {{$appraisal->appraiser->last_name}}</label></li>
								@endif
                                @endforeach
                                </ul>
                            </div>
                        @endif
                    </fieldset>
                </div>                                   
            </div>
            <h4>Images</h4>
            <hr>
            <div class="row">
                @foreach($property->pictures as $image)
                    <div class="col-md-4" id="picture{{$image->id_property_picture}}">
                        <img class="img-responsive" src="{{URL::asset($image->picture_path)}}" alt="property images" style="max-width:150px; background-size: contain"><br>
                        <button class="btn btn-danger btn-block btn-flat" id="removePic" data-id="{{$image->id_property_picture}}">Remove</button>                     
                    </div>
                @endforeach     
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
    </div>
</form>