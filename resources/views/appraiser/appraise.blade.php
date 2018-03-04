@extends('layouts.appraiser')

@section('title', 'Appraise Property')

@section('style')
    <style>
        #property_1, #property_2, #property_3{
                display:none;
            }
    </style>
@stop

@section('content')
        <div class = "container" id="container">
            <form role="form" data-toggle="validator" id="appraisal_form">
                <div class="row">&nbsp</div>
				<div id="subject_property" class="row">
                    <div class="box">
                        <div class="box-body">
                            <legend>Subject Property Details</legend>
                            <div class = "row">
                                <input type="hidden" class="form-control" id="subj_id_appraisal" value="{{$appraisal->id_appraisal}}">
                                <div class="form-group col-md-4">
                                    <label for="subj_property_name" class="control-label">Property Name</label>
                                    <input type="text" class="form-control" id="subj_property_name" value="{{$appraisal->property->property_name}}" readonly/>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="subj_property_type">Property Type</label>
                                    <select class="form-control" id="subj_property_type" disabled>
                                        <option></option>
                                        <option value = "0" <?php if($appraisal->property->property_type == '0') echo ' selected="true"'; ?> >Lot</option>
                                        <option value = "1" <?php if($appraisal->property->property_type == '1') echo ' selected="true"'; ?>>House and Lot</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="subj_tct_number" class="control-label">TCT Number</label>
                                    <input type="text" class="form-control" id="subj_tct_number" value ="{{$appraisal->property->tct_number}}"  readonly />
                                </div>
                            </div>
                            <legend>Property Location</legend>
                            <div class="row">
                                <div class="form-group  col-sm-12">
                                    <label for="subj_property_location" class="control-label">House No. / Street / Subdivision / Barangay / City / Province / Region</label>
                                    <input class="form-control" id="subj_property_location" value="{{$appraisal->property->propertylocation->address}}" readonly>
                                </div>
                            </div>   
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-6">
                            <div class="box">
                                <div class="box-body">
                                    <legend>Appraisal Info</legend>
                                    <div class="form-group">
                                        <label for="subj_dtInspection" class="col-lg-4 control-label">Date of Inspection</label>
                                        <div class="col-lg-8">
                                            <input type="date" class="form-control" id="subj_dtInspection" placeholder="MM/DD/YYYY">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subj_dtAppraisal" class="col-lg-4 control-label">Date of Appraisal</label>
                                        <div class="col-lg-8">
                                            <input type="date" class="form-control" id="subj_dtAppraisal" placeholder="MM/DD/YYYY">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subj_reg_deeds" class="col-lg-4 control-label">Registry of Deeds</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="subj_reg_deeds" placeholder="Registry of Deeds">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subj_house_model"  class="col-lg-4 control-label">House Model</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="subj_house_model">
                                                <option></option>
                                                @foreach($house_models as $house_model)
                                                    <option value="{{$house_model->id_house_model}}">{{$house_model->house_model}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subj_num_storey" class="col-lg-4 control-label">Number of Storeys</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="subj_num_storey" placeholder="Number of Storeys">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subj_lot_area" class="col-lg-4 control-label">Lot Area (Sq m.)</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="subj_lot_area" placeholder="Lot Area" value="{{$appraisal->property->lot_area}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subj_remarks" class="col-lg-4 control-label">Remarks</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="subj_remarks" placeholder="Remarks">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class = "col-md-6">
                            <div class="box">
                                <div class="box-body">
                                    <legend>Appraisal Value</legend>
                                    <div class="form-group">
                                        <label for="subj_house_value" class="col-lg-4 control-label">House Value</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control number" id="subj_house_value" placeholder="House Value">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subj_effective_age" class="col-lg-4 control-label">Effective Age</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="subj_effective_age" placeholder="Effective Age">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subj_total_ecolife" class="col-lg-4 control-label">Total ECO Life</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" onblur="getSubjRemainingEcolife()" id="subj_total_ecolife" placeholder="Total ECO Life">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subj_remaining_ecolife" class="col-lg-4 control-label">Remaining ECO Life</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="subj_remaining_ecolife" readonly placeholder="Remaining ECO Life">
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <div class="box">
                                <div class="box-body">
                                    <legend>Actions</legend>
                                    <div class ="form-group">
                                        <a class="btn btn-success col-md-6 next pull-right">NEXT</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

				</div>

				<div id="property_1" class="row">
                    <div class="box">
                        <div class="box-body">
                            <legend>Comparable Property 1 Details</legend>
                            <div class = "row">
                                <div class="form-group col-md-6">
                                    <label for="prpty1_property_name" class="control-label">Property Name</label>
                                    <input type="text" class="form-control" id="prpty1_property_name"/>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="prpty1_property_type">Property Type</label>
                                    <select class="form-control" id="prpty1_property_type" disabled>
                                        <option></option>
                                        <option value = "0" <?php if($appraisal->property->property_type == '0') echo ' selected="true"'; ?> >Lot</option>
                                        <option value = "1" <?php if($appraisal->property->property_type == '1') echo ' selected="true"'; ?>>House and Lot</option>
                                    </select>
                                </div>
                            </div>
                            <legend>Property Location</legend>
                            <div class = "row">
                                <div class="form-group col-sm-3">
                                    <label for="prpty1_region" class="control-label">Region</label>
                                    <select class="form-control" id="prpty1_region">
                                        <option value=""></option>
                                        @foreach($regions as $region)
                                            <option value="{{$region->id_region}}">{{$region->region_description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-sm-3">
                                    <label for="prpty1_province" class="control-label">Province</label>
                                    <select class="form-control" id="prpty1_province">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group  col-sm-3">
                                    <label for="prpty1_city" class="control-label">City</label>
                                    <select class="form-control" id="prpty1_city">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group  col-sm-3">
                                    <label for="prpty1_barangay" class="control-label">Barangay</label>
                                    <select class="form-control" id="prpty1_barangay">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group  col-sm-12">
                                    <label for="prpty1_property_location" class="control-label">House No. / Street / Subdivision </label>
                                    <input class="form-control" id="prpty1_property_location">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">&nbsp</div>
                    <div class = "row">
                        <div class = "col-md-6">
                            <div class="box">
                                <div class="box-body">
                                    <legend>Appraisal Value</legend>
                                    <div class="form-group">
                                        <label for="prpty1_lot_value" class="col-lg-4 control-label">Lot Value (Sq m.)</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control number" id="prpty1_lot_value" placeholder="Lot Value">
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-6">
                            <div class="box">
                                <div class="box-body">
                                    <legend>Actions</legend>
                                    <div class ="form-group">
                                        <a class="btn btn-default col-md-6 previous" >PREVIOUS</a>
                                        <a class="btn btn-success col-md-6 next pull-right">NEXT</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
				</div>

                <div id="property_2" class="row">
					<div class="box">
                        <div class="box-body">
                            <legend>Comparable Property 2 Details</legend>
                            <div class = "row">
                                <div class="form-group col-md-6">
                                    <label for="prpty2_property_name" class="control-label">Property Name</label>
                                    <input type="text" class="form-control" id="prpty2_property_name" />
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="prpty2_property_type">Property Type</label>
                                    <select class="form-control" id="prpty2_property_type" disabled>
                                        <option></option>
                                        <option value = "0" <?php if($appraisal->property->property_type == '0') echo ' selected="true"'; ?> >Lot</option>
                                        <option value = "1" <?php if($appraisal->property->property_type == '1') echo ' selected="true"'; ?>>House and Lot</option>
                                    </select>
                                </div>
                            </div>
                            <legend>Property Location</legend>
                            <div class = "row">
                                <div class="form-group col-sm-3">
                                    <label for="prpty2_region" class="control-label">Region</label>
                                    <select class="form-control" id="prpty2_region">
                                        <option value=""></option>
                                        @foreach($regions as $region)
                                            <option value="{{$region->id_region}}">{{$region->region_description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-sm-3">
                                    <label for="prpty2_province" class="control-label">Province</label>
                                    <select class="form-control" id="prpty2_province">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group  col-sm-3">
                                    <label for="prpty2_city" class="control-label">City</label>
                                    <select class="form-control" id="prpty2_city">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group  col-sm-3">
                                    <label for="prpty2_barangay" class="control-label">Barangay</label>
                                    <select class="form-control" id="prpty2_barangay">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group  col-sm-12">
                                    <label for="prpty2_property_location" class="control-label">House No. / Street / Subdivision </label>
                                    <input class="form-control" id="prpty2_property_location">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">&nbsp</div>
                    <div class = "row">
                        <div class = "col-md-6">
                            <div class="box">
                                <div class="box-body">
                                    <legend>Appraisal Value</legend>
                                    <div class="form-group">
                                        <label for="prpty2_lot_value" class="col-lg-4 control-label">Lot Value (Sq m.)</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control number" id="prpty2_lot_value" placeholder="Lot Value">
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-6">
                            <div class="box">
                                <div class="box-body">
                                    <legend>Actions</legend>
                                    <div class ="form-group">
                                        <a class="btn btn-default col-md-6 previous" >PREVIOUS</a>
                                        <a class="btn btn-success col-md-6 next pull-right">NEXT</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
				</div>

                <div id="property_3" class="row">
					<div class="box">
                        <div class="box-body">
                            <legend>Comparable Property 3 Details</legend>
                            <div class = "row">
                                <div class="form-group col-md-6">
                                    <label for="prpty3_property_name" class="control-label">Property Name</label>
                                    <input type="text" class="form-control" id="prpty3_property_name"/>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="prpty3_property_type">Property Type</label>
                                    <select class="form-control" id="prpty3_property_type" disabled>
                                        <option></option>
                                        <option value = "0" <?php if($appraisal->property->property_type == '0') echo ' selected="true"'; ?> >Lot</option>
                                        <option value = "1" <?php if($appraisal->property->property_type == '1') echo ' selected="true"'; ?>>House and Lot</option>
                                    </select>
                                </div>
                            </div>
                            <legend>Property Location</legend>
                            <div class = "row">
                                <div class="form-group col-sm-3">
                                    <label for="prpty3_region" class="control-label">Region</label>
                                    <select class="form-control" id="prpty3_region">
                                        <option value=""></option>
                                        @foreach($regions as $region)
                                            <option value="{{$region->id_region}}">{{$region->region_description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-sm-3">
                                    <label for="prpty3_province" class="control-label">Province</label>
                                    <select class="form-control" id="prpty3_province">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group  col-sm-3">
                                    <label for="prpty3_city" class="control-label">City</label>
                                    <select class="form-control" id="prpty3_city">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group  col-sm-3">
                                    <label for="prpty3_barangay" class="control-label">Barangay</label>
                                    <select class="form-control" id="prpty3_barangay">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group  col-sm-12">
                                    <label for="prpty3_property_location" class="control-label">House No. / Street / Subdivision </label>
                                    <input class="form-control" id="prpty3_property_location" >
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">&nbsp</div>
                    <div class = "row">
                        <div class = "col-md-6">
                            <div class="box">
                                <div class="box-body">
                                    <legend>Appraisal Value</legend>
                                    <div class="form-group">
                                        <label for="prpty3_lot_value" class="col-lg-4 control-label">Lot Value (Sq m.)</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control number" id="prpty3_lot_value" placeholder="Lot Value">
                                        </div>
                                    </div>     
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-6">
                            <div class="box">
                                <div class="box-body">
                                    <legend>Actions</legend>
                                    <div class="form-group">
                                        <a class="btn btn-default previous col-md-6" >PREVIOUS</a>
                                        <button type="submit" id="btnAppraiseProperty" class="btn col-md-6 btn-success">APPRAISE</button>
                                    </div>     
                                </div>
                            </div>
                        </div>
                    </div>

				</div>
			
            </form>
        </div>
@stop

@section('script')
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.extensions.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.numeric.extensions.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{ URL::asset('assets/js/appraiserIndex.js') }}"></script>
    <script type="text/javascript">
		$(document).ready(function(){

			$(".next").click(function(){
				var form = $("#myform");
                if ($('#subject_property').is(":visible")){
                    current_fs = $('#subject_property');
                    next_fs = $('#property_1');
                }else if($('#property_1').is(":visible")){
                    current_fs = $('#property_1');
                    next_fs = $('#property_2');
                }else if($('#property_2').is(":visible")){
                    current_fs = $('#property_2');
                    next_fs = $('#property_3');
                }
                next_fs.show(); 
                current_fs.hide();
            
			});

			$('.previous').click(function(){
				if($('#property_1').is(":visible")){
					current_fs = $('#property_1');
					prev_fs = $('#subject_property');
				}else if ($('#property_2').is(":visible")){
					current_fs = $('#property_2');
					prev_fs = $('#property_1');
				}else if ($('#property_3').is(":visible")){
					current_fs = $('#property_3');
					prev_fs = $('#property_2');
				}
				current_fs.hide();
                prev_fs.show(); 
			});
			
		});

	</script>

@stop