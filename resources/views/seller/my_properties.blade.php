@extends('layouts.seller')

@section('title', 'My Properties')
@section('content')
    <br>
    <div class="container">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Sell Property</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-success btn-block addProperty" data-toggle="modal" data-toggle="modal" data-target="#modalAddProperty" title="AddProperty">Add Property</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="loading">Loading&#8230;</div>
            <div class="col-md-12" id="propertyTable">
                <div class="box">
                    <div class="box-body">
                        <table id="dtblProperty" class="table table-bordered table-hover">
                            <thead>
                                <tr>  
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th>Property Name</th>
                                    <th>Property Location</th>
                                    <th>Property Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($properties as $property)
                                    <tr>
                                        <td class="hide classPropertyPrimaryKey">{{$property->id_property}}</td>
                                        <td class="hide classPropertyName">{{$property->property_name}}</td>
                                        <td class="hide classPropertyLocation">{{$property->id_property_location}}</td>
                                        <td class="hide classPropertyLocationAddress">{{$property->propertyLocation->address}}</td>
                                        <td class="hide classSellerID">{{$property->id_seller}}</td>
                                        <td style="cursor: pointer" class="clickable-row name" data-href="property/show/{{$property->id_property}}">
                                            {{$property->property_name}}
                                        </td>
                                        <td class="location">
                                            {{$property->propertyLocation->address}}
                                        </td>
                                        <td class="property_status">
                                            <?php
                                                $status = null;
                                                if($property->property_status == 0){$status = "Available for Appraisal";}
                                                if($property->property_status == 1){$status = "Requested for Appraisal";}
                                                if($property->property_status == 2){$status = "Appraisal Completed";}
                                                if($property->property_status == 3){$status = "Re-appraise";}
                                                if($property->property_status == 4){$status = "Publish";}
                                                if($property->property_status == 5){$status = "Sold";}
                                            ?>   
                                            {{$status}}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-default btnViewProperty" data-toggle="modal" data-target="#modalViewProperty" title="View Property">
                                                    VIEW
                                                </button>
                                                <button type="button" class="btn btn-sm btn-default btnUploadProperty" data-toggle="modal" data-target="#modalUploadProperty" title="Upload Property">
                                                    UPLOAD
                                                </button>
                                                @if($property->property_status == 0)
                                                <button type="button" class="btn btn-sm btn-default btnAppraiseProperty" data-toggle="tooltip" title="Appraise">
                                                    APPRAISE
                                                </button>
                                                <button type="button" class="btn btn-sm btn-default btnEditProperty" data-toggle="tooltip" title="Edit">
                                                    EDIT
                                                </button>
                                                <button type="button" class="btn btn-sm btn-default btnDeleteProperty" data-toggle="tooltip" title="Delete">
                                                    DELETE
                                                </button>
                                                @endif
                                                @if($property->property_status == 2)
                                                <button type="button" class="btn btn-sm btn-default btnPublishProperty" data-toggle="modal" data-target="#modalPublishProperty" title="Publish Property">
                                                    PUBLISH
                                                </button>
                                                <button type="button" class="btn btn-sm btn-default btnAppraiseProperty" data-toggle="tooltip" title="Re-appraise">
                                                    RE-APPRAISE
                                                </button>
                                                @endif
                                                @if($property->property_status == 4)
                                                <button type="button" class="btn btn-sm btn-default btnSoldProperty" data-toggle="tooltip" title="Sold">
                                                    SOLD
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th>Property Name</th>
                                    <th>Property Location</th>
                                    <th>Property Status</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="loadingProperty">
                        <i id="loadingPropertyDesign"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL ADD PROPERTY -->
        <div class="modal fade" id="modalAddProperty" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add new Property</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        
                    </div>

                    <form role="form" data-toggle="validator" id="form">
                        <div class="modal-body">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset>
                                            <legend>Property Details</legend>
                                    
                                            <div class="form-group  col-sm-12">
                                                <label for="inputPropertyName">Property Name</label>
                                                <input type="text" class="form-control" id="inputPropertyName" required>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label for="inputPropertyType">Property Type</label>
                                                <select class="form-control" id="inputPropertyType">
                                                    <option value = "0">Lot</option>
                                                    <option value = "1">House and Lot</option>
                                                </select>
                                            </div>
                                            <div class="form-group  col-sm-12">
                                                <label for="inputTCTNumber">TCT Number</label>
                                                <input type="text" class="form-control" id="inputTCTNumber" required>
                                            </div>
                                            <div class="form-group  col-sm-12">
                                                <label for="inputLotArea">Lot Area</label>
                                                <input class="form-control" id="inputLotArea" required>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset>
                                            <legend>Property Location</legend>
                                            <div class="form-group  col-sm-12">
                                                <label for="region">Region</label>
                                                <select class="form-control" id="region">
                                                    @foreach($regions as $region)
                                                        <option value="{{$region->id_region}}">{{$region->region_description}} ({{$region->region_code}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group  col-sm-12">
                                                <label for="province">Province</label>
                                                <select class="form-control" id="province">
                                                    @foreach($provinces as $province)
                                                        <option value="{{$province->id_province}}">{{$province->province_description}} ({{$province->province_code}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group  col-sm-12">
                                                <label for="city">City</label>
                                                <select class="form-control" id="city">
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id_city}}">{{$city->city_description}} ({{$city->city_code}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group  col-sm-12">
                                                <label for="barangay">Barangay</label>
                                                <select class="form-control" id="barangay">
                                                    @foreach($barangays as $barangay)
                                                        <option value="{{$barangay->id_barangay}}">{{$barangay->barangay_description}} ({{$barangay->barangay_code}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group  col-sm-12">
                                                <label for="barangay">House No. / Street / Subdivision </label>
                                                <input class="form-control" id="inputPropertyLocation" required>
                                            </div>
                                        </fieldset>
                                    </div>                                        
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="btnAddProperty" class="btn btn-success">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL ADD PROPERTY-->

        <!-- MODAL ADD PROPERTY -->
        <div class="modal fade" id="modalViewProperty" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Property</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>    
                    </div>
                    <div id="viewDetails">
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL ADD PROPERTY-->


        <!-- MODAL SUCCESSFUL CREATION -->
        <div class="modal fade" id="modalSuccessfulCreation" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Property</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; A new property named <span id="successPropertyName"></span> has been added to your property.
                        </p>
                        <div class="successMessage">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="btnCreateAnotherProperty">CREATE ANOTHER PROPERTY</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL CREATION -->

        <div class="modal fade" id="modalSuccessfulSold" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Property</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Property has been sold.
                        </p>
                        <div class="successMessage">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL CREATION -->

        <div class="modal fade" id="modalSuccessfulPublish" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Property</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Property has been published.
                        </p>
                        <div class="successMessage">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL CREATION -->
        
        <!-- MODAL SUCCESSFUL RENAME -->
        <div class="modal fade" id="modalSuccessfulRequestAppraisal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Request Appraisal Sent</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Request for appraisal successfully sent to appraiser.
                        </p>
                        <div class="successMessage">
                            <p>Property <span id="propertyNameAppraise" class="credentials"></span> is now pending for appraisal.</p>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL REQUEST APPRAISAL -->
        <div class="modal fade" id="modalRequestAppraisal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Request Appraisal</h4>
                    </div>

                    <form role="form" data-toggle="validator" id="formRequestAppraisal">
                        <div class="modal-body">
                            <div class="box-body">
                                <p class="help-block col-sm-12" id="formErrorMessageRequestAppraisal" style="color:red;">
                                    Something went wrong, please check your inputs.
                                </p>
                                <div class="form-group  col-sm-12">
                                    <label for="inputPropertyName">Property Name</label>
                                    <input type="text" class="form-control" id="inputPropertyNameAppraise" placeholder="Property Name"disabled="true" >
                                </div>
                                <div class="form-group  col-sm-12">
                                    <label for="inputPropertyName">Property Location</label>
                                    <textarea class="form-control" id="inputPropertyLocationAppraise" disabled="true"></textarea>
                                </div>
                                <div class="form-group  col-sm-12">
                                    <label for="inputAppraiserId">Select Appraiser</label>
                                    <select class="form-control" name="inputAppraiserId" id="inputAppraiserId">
                                            <option></option>
                                        @foreach($appraisers as $appraiser)
                                            <option value="{{$appraiser->id_appraiser}}">{{$appraiser->last_name}} , {{$appraiser->first_name}} {{$appraiser->middle_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-sm-12">
                                    <label for="inputRemarksAppraise">Remarks</label>
                                    <textarea class="form-control" id="inputRemarksAppraise"></textarea>
                                </div>

                                <p class="help-block"></p>
                                <div class="form-group  col-sm-6">
                                    <input type="hidden" class="form-control" id="inputPropertyPrimaryKeyAppraise">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <span class="form-group">
                                <button type="submit" id="btnRequestAppraisalSubmit" class="btn btn-success">Submit Request Appraisal</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL REQUEST APPRAISAL-->
        
        <div class="modal fade" id="modalPublishProperty" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="formPublish">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Publish Property</h4>
                            </div>
                            <div class="modal-body">
                                <center>Do you want to publish this property?</center>
                                <input type="hidden" name="propertyId" id="propertyId" value="">
                                <input type="hidden" name="appraisalId" id="appraisalId" value="">
                                <span id="appraisedValue" class="hidden">Appraised Value: </span>
                                <div class="form-group">
                                    <label for="">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" id="remarks" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" id="btnPublish" class="btn btn-success">Publish</button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
        <div class="modal fade" id="modalUploadProperty" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" data-toggle="validator" id="formUpload" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="box-body">
                                <p class="help-block col-sm-12" id="formErrorMessageUpload" style="color:red;">
                                    Something went wrong, please check your inputs.
                                </p>
                                <center><img class="img-responsive" id="inputDisplayPicture" src="{{ URL::asset('assets/image/avatar/AdminAvatar.jpg')}}" style="max-width:150px; background-size: contain" /></center>
                                <div class="row">
                                    <center>
                                        <input type="file" class="btn btn-primary btn-sm" name="inputPicture" id="inputPicture" onchange="readURL(this)" required>
                                    </center>
                                </div>
                                <input type="hidden" name="propertyId" id="uploadPropertyId">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <span class="form-group">
                                <button type="submit" id="btnUploadImage" class="btn btn-success">Create</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@stop


@section('script')
    <script src="{{ URL::asset('assets/js/sellerIndex.js') }}"></script>
@stop