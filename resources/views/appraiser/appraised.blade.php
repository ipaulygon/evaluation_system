@extends('layouts.appraiser')

@section('title', 'Appraise Property')

@section('style')
    
@stop

@section('content')
    <div class = "container">
        <form role="form" data-toggle="validator" id="appraised_form">
            <div class="row">
                <div class="loading">Loading&#8230;</div>
                <div class="box">
                    <div class="box-body">
                        <legend>Appraised Property Details</legend>
                        <div class = "row">
                            <input type="hidden" class="form-control" id="appraised_id_appraisal" value="">
                            <div class="form-group col-md-4">
                                <label for="appraised_property_name" class="control-label">Property Name</label>
                                <input type="text" class="form-control" id="appraised_property_name" value="" readonly/>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="appraised_property_type">Property Type</label>
                                <select class="form-control" id="appraised_property_type" readonly>
                                    <option></option>
                                    
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="appraised_tct_number" class="control-label">TCT Number</label>
                                <input type="text" class="form-control" id="appraised_tct_number" value =""  readonly />
                            </div>
                        </div>
                        <legend>Property Location</legend>
                        <div class="row">
                            <div class="form-group  col-sm-12">
                                <label for="appraised_property_location" class="control-label">House No. / Street / Subdivision / Barangay / City / Province / Region</label>
                                <input class="form-control" id="appraised_property_location" value="" readonly>
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
                                    <label for="appraised_dtInspection" class="col-lg-4 control-label">Date of Inspection</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control" id="appraised_dtInspection" placeholder="MM/DD/YYYY" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_dtAppraisal" class="col-lg-4 control-label">Date of Appraisal</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control" id="appraised_dtAppraisal" placeholder="MM/DD/YYYY" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_reg_deeds" class="col-lg-4 control-label">Registry of Deeds</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="appraised_reg_deeds" placeholder="Registry of Deeds" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_house_model"  class="col-lg-4 control-label">House Model</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="appraised_house_model" readonly>
                                            <option></option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_num_storey" class="col-lg-4 control-label">Number of Storeys</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="appraised_num_storey" placeholder="Number of Storeys" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_rental_rate" class="col-lg-4 control-label">Rental Rate</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="appraised_rental_rate" placeholder="Rental Rate" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_lot_area" class="col-lg-4 control-label">Lot Area (Sq m.)</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="appraised_lot_area" placeholder="Lot Area" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_floor_area" class="col-lg-4 control-label">Floor Area</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="appraised_floor_area" placeholder="Floor Area" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_effective_age" class="col-lg-4 control-label">Effective Age</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="appraised_effective_age" placeholder="Effective Age" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_total_ecolife" class="col-lg-4 control-label">Total ECO Life</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" onblur="getSubjRemainingEcolife()" id="appraised_total_ecolife" placeholder="Total ECO Life" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_remaining_ecolife" class="col-lg-4 control-label">Remaining ECO Life</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="appraised_remaining_ecolife" readonly placeholder="Remaining ECO Life" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_remarks" class="col-lg-4 control-label">Remarks</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="appraised_remarks" placeholder="Remarks" readonly>
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
                                    <label for="appraised_lot_value" class="col-lg-4 control-label">Lot Value (Sq m.)</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" onblur="getSubjTotalValue()" readonly id="appraised_lot_value" placeholder="Lot Value">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_completion" class="col-lg-4 control-label">% of Completion</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="appraised_completion" readonly placeholder="% of Completion">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_house_value" class="col-lg-4 control-label">House Value</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" onblur="getSubjTotalValue()" readonly id="appraised_house_value" placeholder="House Value">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_depreciated_value" class="col-lg-4 control-label">Depreciated Value</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" onblur="getSubjTotalValue()" readonly id="appraised_depreciated_value" placeholder="Depreciated Value">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_cost_improvement" class="col-lg-4 control-label">Cost of Improvement</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" onblur="getSubjTotalValue()" readonly id="appraised_cost_improvement" placeholder="Cost of Improvement">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appraised_total_value" class="col-lg-4 control-label">Total Value</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="appraised_total_value" readonly placeholder="Total Value">
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <div class ="row">
                            <button type="button" class="btn btn-default  col-md-6" data-toggle="modal" data-target="#modalAddAppraisedPropertyImage" title="AddAppraiser">Add Appraised Image</button>
                            <button type="button" class="btn btn-success  col-md-6" data-toggle="modal" title="Save">Save</button>
                        </div>
                    </div>
                </div>
                <div id="loadingProperty">
                    <i id="loadingPropertyDesign"></i>
                </div>
            </div>
        </form>
    </div>

    <!-- MODAL ADD APPRAISED IMAGE -->
    <div class="modal fade" id="modalAddAppraisedPropertyImage" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Appraised Property Images</h4>
                </div>

                <form role="form" data-toggle="validator" id="formAddImage" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="box-body">
                            <p class="help-block col-sm-12" id="formErrorMessage" style="color:red;">
                                Something went wrong, please check your inputs.
                            </p>
                            <div class="row">
                                <center>
                                    <input type="file" class="btn btn-primary btn-sm" name="appraisePicture" id="appraisePicture" multiple>
                                </center>
                            </div>
                            <br>
                            <div class="form-group  col-sm-12">
                                <input type="hidden" class="form-control" id="inputAppraisePropertyPrimaryKey">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <span class="form-group">
                            <button type="submit" id="btnAddAppraisedPropertyImage" class="btn btn-success">Add</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL ADD APPRAISED IMAGE-->
@stop

@section('script')
    <script src="{{ URL::asset('assets/js/appraiserIndex.js') }}"></script>
@stop