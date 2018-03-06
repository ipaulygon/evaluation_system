<form role="form" data-toggle="validator" id="appraised_form">
    <div class="row">
        <div class="loading">Loading&#8230;</div>
        <div class="row">&nbsp</div>
        <div id="subject_property" class="row">
            <div class="box">
                <div class="box-body">
                    <legend>Subject Property Details</legend>
                    <div class = "row">
                        <input type="hidden" class="form-control" id="subj_id_appraisal" value="{{$appraiseproperty->id_appraisal}}">
                        <div class="form-group col-md-4">
                            <label for="subj_property_name" class="control-label">Property Name</label>
                            <input type="text" class="form-control" id="subj_property_name" value="{{$appraiseproperty->appraisal->property->property_name}}" readonly/>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="subj_property_type">Property Type</label>
                            <select class="form-control" id="subj_property_type" disabled>
                                <option></option>
                                <option value = "0" <?php if($appraiseproperty->appraisal->property->property_type == '0') echo ' selected="true"'; ?> >Lot</option>
                                <option value = "1" <?php if($appraiseproperty->appraisal->property->property_type == '1') echo ' selected="true"'; ?>>House and Lot</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="subj_tct_number" class="control-label">TCT Number</label>
                            <input type="text" class="form-control" id="subj_tct_number" value ="{{$appraiseproperty->appraisal->property->tct_number}}"  readonly />
                        </div>
                    </div>
                    <legend>Property Location</legend>
                    <div class="row">
                        <div class="form-group  col-sm-12">
                            <label for="subj_property_location" class="control-label">House No. / Street / Subdivision / Barangay / City / Province / Region</label>
                            <input class="form-control" id="subj_property_location" value="{{$appraiseproperty->appraisal->property->propertylocation->address}}" readonly>
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
                                    <input type="date" class="form-control" id="subj_dtInspection" placeholder="MM/DD/YYYY" value="{{$appraiseproperty->inspection_date}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subj_dtAppraisal" class="col-lg-4 control-label">Date of Appraisal</label>
                                <div class="col-lg-8">
                                    <input type="date" class="form-control" id="subj_dtAppraisal" placeholder="MM/DD/YYYY" value="{{$appraiseproperty->appraisal_date}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subj_reg_deeds" class="col-lg-4 control-label">Registry of Deeds</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="subj_reg_deeds" placeholder="Registry of Deeds" value="{{$appraiseproperty->registry_of_deeds}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subj_house_model"  class="col-lg-4 control-label">House Model</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="subj_house_model" placeholder="House Model" value="{{$appraiseproperty->houseModel->house_model}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subj_num_storey" class="col-lg-4 control-label">Number of Storeys</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="subj_num_storey" placeholder="Number of Storeys" value="{{$appraiseproperty->number_of_storeys}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subj_lot_area" class="col-lg-4 control-label">Lot Area (Sq m.)</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="subj_lot_area" placeholder="Lot Area" value="{{$appraiseproperty->appraisal->property->lot_area}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subj_remarks" class="col-lg-4 control-label">Remarks</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="subj_remarks" placeholder="Remarks" value="{{$appraiseproperty->remarks}}" readonly>
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
                                    <input type="text" class="form-control number" id="subj_house_value" placeholder="House Value" value="{{$appraiseproperty->house_value}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subj_effective_age" class="col-lg-4 control-label">Effective Age</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="subj_effective_age" placeholder="Effective Age" value="{{$appraiseproperty->effective_age}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subj_total_ecolife" class="col-lg-4 control-label">Total ECO Life</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" onblur="getSubjRemainingEcolife()" id="subj_total_ecolife" placeholder="Total ECO Life" value="{{$appraiseproperty->total_ecolife}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subj_remaining_ecolife" class="col-lg-4 control-label">Remaining ECO Life</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="subj_remaining_ecolife" readonly placeholder="Remaining ECO Life" value="{{$appraiseproperty->remaining_ecolife}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subj_ave_lot_value" class="col-lg-4 control-label">Average Lot Value</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control number" id="subj_ave_lot_value" placeholder="Average Lot Value" value="{{$appraiseproperty->ave_lot_value}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subj_total_lot_value" class="col-lg-4 control-label">Total Lot Value</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control number" id="subj_total_lot_value" placeholder="Total Lot Value" value="{{$appraiseproperty->total_lot_value}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subj_total_house_value" class="col-lg-4 control-label">Total House Value</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control number" id="subj_total_house_value" placeholder="Total House Value" value="{{$appraiseproperty->total_house_value}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subj_total_property_value" class="col-lg-4 control-label">Total Property Value</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control number" id="subj_total_property_value" placeholder="Total Property Value" value="{{$appraiseproperty->total_property_value}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-md-6">
                            <a href="javascript: window.print()" target="_blank" type="button" class="btn btn-block btn-flat btn-primary">
                                <i class="fa fa-file"></i> Print PDF
                            </a>
                            </div>
                            <div class="col-md-6">
                            <a href="/request_appraisals" type="button" class="btn btn-block btn-flat btn-success">
                                Back to Request Appraisals
                            </a>
                            <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="loadingProperty">
            <i id="loadingPropertyDesign"></i>
        </div>
    </div>
</form>
