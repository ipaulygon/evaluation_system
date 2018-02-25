@extends('layouts.admin')

@section('title', 'City')

@section('content')
    <section class="content-header">
        <h1>
            City
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
                                <option value="0">Active Cities</option>
                                <option value="1">Deleted Cities</option>
                            </select>
                        </div>
                        <button class="btn btn-success btn-block addCity" data-toggle="modal" data-toggle="modal" data-target="#modalAddCity" title="AddCity">Add City </button>
                    </div>
                </div>
            </div>
            <div class="loading">Loading&#8230;</div>
            <div class="col-md-9" id="cityTable">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">City</h3>
                    </div>
                    <div class="box-body">
                        <table id="dtblCity" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th>City</th>
                                    <th>Description</th>
                                    <th>Province</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cities as $city)
                                    <tr>
                                        <td class="hide classCityPrimaryKey">{{$city->id_city}}</td>
                                        <td class="hide classProvince">{{$city->province->id_province}}</td>                        
                                        <td class="classCode clickable-row" style="cursor: pointer" data-href="cities/show/{{$city->id_city}}">
                                            {{$city->city_code}}
                                        </td>
                                        <td class="classDescription clickable-row" style="cursor: pointer" data-href="cities/show/{{$city->id_city}}">
                                            {{$city->city_description}}
                                        </td>
                                        <td class="classProvinceName clickable-row" style="cursor: pointer" data-href="cities/show/{{$city->id_city}}">
                                            {{$city->province->province_description}}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-default btnUpdateCity" data-toggle="tooltip" title="Update">
                                                    <i class="fa fa-fw fa-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-default btnDeleteCity" data-toggle="tooltip" title="Deactivate">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>City</th>
                                    <th>Description</th>
                                    <th>Province</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="loadingCity">
                        <i id="loadingCityDesign"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>  
    
    <!-- MODAL ADD City -->
        <div class="modal fade" id="modalAddCity" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create new City</h4>
                    </div>

                    <form role="form" data-toggle="validator" id="form">
                        <div class="modal-body">
                            <div class="box-body">
                                <p class="help-block col-sm-12" id="formErrorMessage" style="color:red;">
                                    Something went wrong, please check your inputs.
                                </p>
                                <div class="form-group  col-sm-12">
                                    <input type="text" class="form-control" id="inputCity" placeholder="City" required>
                                </div>
                                <div class="form-group  col-sm-12">
                                    <input class="form-control" id="inputDescription" placeholder="Description" required>
                                </div>
                                <div class="form-group col-sm-12">
                                    <select class="form-control" id="inputProvince" placeholder="Province" required>
                                        @foreach($provinces as $province)
                                            <option value="{{$province->id_province}}">{{$province->province_description }} ({{$province->province_code}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <span class="form-group">
                                <button type="submit" id="btnCreateCity" class="btn btn-success">Create</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL ADD City-->

        <!-- MODAL SUCCESSFUL CREATION -->
        <div class="modal fade" id="modalSuccessfulCreation" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create a new City</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; A new City <span id="successCode"></span> has been created.
                        </p>
                        <div class="successMessage">
                            <p>City Description:</p>
                            <p id="successDescription" class="credentials"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="btnCreateAnotherCity">CREATE ANOTHER City</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL CREATION -->

        <!-- MODAL UPDATE City -->
        <div class="modal fade" id="modalUpdateCity" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update City</h4>
                    </div>

                    <form role="form" data-toggle="validator" id="formUpdate">
                        <div class="modal-body">
                            <div class="box-body">
                                <p class="help-block col-sm-12" id="formErrorMessageUpdate" style="color:red;">
                                    Something went wrong, please check your inputs.
                                </p>
                                <input type="hidden" class="form-control" id="inputIdUpdate" required>
                                <div class="form-group  col-sm-12">
                                    <input type="text" class="form-control" id="inputCityUpdate" placeholder="City" required>
                                </div>
                                <div class="form-group  col-sm-12">
                                    <input class="form-control" id="inputDescriptionUpdate" placeholder="Description" required>
                                </div>
                                <div class="form-group col-sm-12">
                                    <select class="form-control" id="inputProvinceUpdate" placeholder="Province" required>
                                        @foreach($provinces as $province)
                                            <option value="{{$province->id_province}}">{{$province->province_description }} ({{$province->province_code}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="help-block"></p>
                                <div class="form-group  col-sm-6">
                                    <input type="hidden" class="form-control" id="inputCityPrimaryKey">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <span class="form-group">
                                <button type="submit" id="btnUpdateCitySubmit" class="btn btn-success">Update City</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL UPDATE City-->

        <!-- MODAL SUCCESSFUL UPDATE -->
        <div class="modal fade" id="modalSuccessfulUpdate" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update City</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Update successful.
                        </p>
                        <div class="successMessage">
                            <p>The updated City is: </p>
                            <p>City: <span id="updatedCity" class="credentials"></span></p>
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


        <!-- MODAL SUCCESSFUL DELETE City -->
        <div class="modal fade" id="modalDeleteCitySuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Delete City</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Delete City success.
                        </p>
                        <div class="successMessage">
                            <p>City : <span id="deletedCity" class="credentials"></span></p>
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
        <!-- MODAL SUCCESSFUL DELETE City -->

        <!-- MODAL SUCCESSFUL RESTORE City -->
        <div class="modal fade" id="modalRestoredCitySuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Restore City</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Restore City success.
                        </p>
                        <div class="successMessage">
                            <p>City : <span id="restoredCity" class="credentials"></span></p>
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
        <!-- MODAL SUCCESSFUL RESTORE City -->
@stop

@section('script')
    <script src="{{ URL::asset('assets/js/cityIndex.js') }}"></script>
@stop
