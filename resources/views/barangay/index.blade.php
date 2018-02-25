@extends('layouts.admin')

@section('title', 'Barangay')

@section('content')
    <section class="content-header">
        <h1>
            Barangay
            <small>Control panel</small>

        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filters</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <select class="form-control selFilter">
                                <option value="0">Active Barangays</option>
                                <option value="1">Deleted Barangays</option>
                            </select>
                        </div>
                        <button class="btn btn-success btn-block addBarangay" data-toggle="modal" data-toggle="modal" data-target="#modalAddBarangay" title="AddBarangay">Add Barangay </button>
                    </div>
                </div>
            </div>
            <div class="loading">Loading&#8230;</div>
            <div class="col-md-9" id="barangayTable">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Barangay</h3>
                    </div>
                    <div class="box-body">
                        <table id="dtblBarangay" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th>Barangay</th>
                                    <th>Description</th>
                                    <th>City</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($barangays as $barangay)
                                    <tr>
                                        <td class="hide classBarangayPrimaryKey">{{$barangay->id_barangay}}</td>
                                        <td class="hide classCity">{{$barangay->city->id_city}}</td>                        
                                        <td class="classCode clickable-row" style="cursor: pointer" data-href="barangays/show/{{$barangay->id_barangay}}">
                                            {{$barangay->barangay_code}}
                                        </td>
                                        <td class="classDescription clickable-row" style="cursor: pointer" data-href="barangays/show/{{$barangay->id_barangay}}">
                                            {{$barangay->barangay_description}}
                                        </td>
                                        <td class="classCityName clickable-row" style="cursor: pointer" data-href="barangays/show/{{$barangay->id_barangay}}">
                                            {{$barangay->city->city_description}}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-default btnUpdateBarangay" data-toggle="tooltip" title="Update">
                                                    <i class="fa fa-fw fa-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-default btnDeleteBarangay" data-toggle="tooltip" title="Deactivate">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Barangay</th>
                                    <th>Description</th>
                                    <th>City</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="loadingBarangay">
                        <i id="loadingBarangayDesign"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>  
    
    <!-- MODAL ADD Barangay -->
        <div class="modal fade" id="modalAddBarangay" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create new Barangay</h4>
                    </div>

                    <form role="form" data-toggle="validator" id="form">
                        <div class="modal-body">
                            <div class="box-body">
                                <p class="help-block col-sm-12" id="formErrorMessage" style="color:red;">
                                    Something went wrong, please check your inputs.
                                </p>
                                <div class="form-group  col-sm-12">
                                    <input type="text" class="form-control" id="inputBarangay" placeholder="Barangay" required>
                                </div>
                                <div class="form-group  col-sm-12">
                                    <input class="form-control" id="inputDescription" placeholder="Description" required>
                                </div>
                                <div class="form-group col-sm-12">
                                    <select class="form-control" id="inputCity" placeholder="City" required>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id_city}}">{{$city->city_description }} ({{$city->city_code}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <span class="form-group">
                                <button type="submit" id="btnCreateBarangay" class="btn btn-success">Create</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL ADD Barangay-->

        <!-- MODAL SUCCESSFUL CREATION -->
        <div class="modal fade" id="modalSuccessfulCreation" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create a new Barangay</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; A new Barangay <span id="successCode"></span> has been created.
                        </p>
                        <div class="successMessage">
                            <p>Barangay Description:</p>
                            <p id="successDescription" class="credentials"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="btnCreateAnotherBarangay">CREATE ANOTHER Barangay</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL CREATION -->

        <!-- MODAL UPDATE Barangay -->
        <div class="modal fade" id="modalUpdateBarangay" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update Barangay</h4>
                    </div>

                    <form role="form" data-toggle="validator" id="formUpdate">
                        <div class="modal-body">
                            <div class="box-body">
                                <p class="help-block col-sm-12" id="formErrorMessageUpdate" style="color:red;">
                                    Something went wrong, please check your inputs.
                                </p>
                                <input type="hidden" class="form-control" id="inputIdUpdate" required>
                                <div class="form-group  col-sm-12">
                                    <input type="text" class="form-control" id="inputBarangayUpdate" placeholder="Barangay" required>
                                </div>
                                <div class="form-group  col-sm-12">
                                    <input class="form-control" id="inputDescriptionUpdate" placeholder="Description" required>
                                </div>
                                <div class="form-group col-sm-12">
                                    <select class="form-control" id="inputCityUpdate" placeholder="City" required>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id_city}}">{{$city->city_description }} ({{$city->city_code}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="help-block"></p>
                                <div class="form-group  col-sm-6">
                                    <input type="hidden" class="form-control" id="inputBarangayPrimaryKey">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <span class="form-group">
                                <button type="submit" id="btnUpdateBarangaySubmit" class="btn btn-success">Update Barangay</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL UPDATE Barangay-->

        <!-- MODAL SUCCESSFUL UPDATE -->
        <div class="modal fade" id="modalSuccessfulUpdate" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update Barangay</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Update successful.
                        </p>
                        <div class="successMessage">
                            <p>The updated Barangay is: </p>
                            <p>Barangay: <span id="updatedBarangay" class="credentials"></span></p>
                            <p>Description: <span id="updatedDescription" class="credentials"></span></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL UPDATE -->


        <!-- MODAL SUCCESSFUL DELETE Barangay -->
        <div class="modal fade" id="modalDeleteBarangaySuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Delete Barangay</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Delete Barangay success.
                        </p>
                        <div class="successMessage">
                            <p>Barangay : <span id="deletedBarangay" class="credentials"></span></p>
                            <p>Description : <span id="deletedDescription" class="credentials"></span></p>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL DELETE Barangay -->

        <!-- MODAL SUCCESSFUL RESTORE Barangay -->
        <div class="modal fade" id="modalRestoredBarangaySuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Restore Barangay</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Restore Barangay success.
                        </p>
                        <div class="successMessage">
                            <p>Barangay : <span id="restoredBarangay" class="credentials"></span></p>
                            <p>Description : <span id="restoredDescription" class="credentials"></span></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL RESTORE Barangay -->
@stop

@section('script')
    <script src="{{ URL::asset('assets/js/barangayIndex.js') }}"></script>
@stop
