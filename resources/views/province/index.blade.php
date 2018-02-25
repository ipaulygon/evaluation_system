@extends('layouts.admin')

@section('title', 'Province')

@section('content')
    <section class="content-header">
        <h1>
            Province
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
                                <option value="0">Active Provinces</option>
                                <option value="1">Deleted Provinces</option>
                            </select>
                        </div>
                        <button class="btn btn-success btn-block addProvince" data-toggle="modal" data-toggle="modal" data-target="#modalAddProvince" title="AddProvince">Add Province </button>
                    </div>
                </div>
            </div>
            <div class="loading">Loading&#8230;</div>
            <div class="col-md-9" id="provinceTable">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Province</h3>
                    </div>
                    <div class="box-body">
                        <table id="dtblProvince" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th>Province</th>
                                    <th>Description</th>
                                    <th>Region</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($provinces as $province)
                                    <tr>
                                        <td class="hide classProvincePrimaryKey">{{$province->id_province}}</td>
                                        <td class="hide classRegion">{{$province->region->id_region}}</td>                        
                                        <td class="classCode clickable-row" style="cursor: pointer" data-href="provinces/show/{{$province->id_province}}">
                                            {{$province->province_code}}
                                        </td>
                                        <td class="classDescription clickable-row" style="cursor: pointer" data-href="provinces/show/{{$province->id_province}}">
                                            {{$province->province_description}}
                                        </td>
                                        <td class="classRegionName clickable-row" style="cursor: pointer" data-href="provinces/show/{{$province->id_province}}">
                                            {{$province->region->region_description}}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-default btnUpdateProvince" data-toggle="tooltip" title="Update">
                                                    <i class="fa fa-fw fa-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-default btnDeleteProvince" data-toggle="tooltip" title="Deactivate">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Province</th>
                                    <th>Description</th>
                                    <th>Region</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="loadingProvince">
                        <i id="loadingProvinceDesign"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>  
    
    <!-- MODAL ADD Province -->
        <div class="modal fade" id="modalAddProvince" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create new Province</h4>
                    </div>

                    <form role="form" data-toggle="validator" id="form">
                        <div class="modal-body">
                            <div class="box-body">
                                <p class="help-block col-sm-12" id="formErrorMessage" style="color:red;">
                                    Something went wrong, please check your inputs.
                                </p>
                                <div class="form-group  col-sm-12">
                                    <input type="text" class="form-control" id="inputProvince" placeholder="Province" required>
                                </div>
                                <div class="form-group  col-sm-12">
                                    <input class="form-control" id="inputDescription" placeholder="Description" required>
                                </div>
                                <div class="form-group col-sm-12">
                                    <select class="form-control" id="inputRegion" placeholder="Region" required>
                                        @foreach($regions as $region)
                                            <option value="{{$region->id_region}}">{{$region->region_description }} ({{$region->region_code}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <span class="form-group">
                                <button type="submit" id="btnCreateProvince" class="btn btn-success">Create</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL ADD Province-->

        <!-- MODAL SUCCESSFUL CREATION -->
        <div class="modal fade" id="modalSuccessfulCreation" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create a new Province</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; A new Province <span id="successCode"></span> has been created.
                        </p>
                        <div class="successMessage">
                            <p>Province Description:</p>
                            <p id="successDescription" class="credentials"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="btnCreateAnotherProvince">CREATE ANOTHER Province</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL CREATION -->

        <!-- MODAL UPDATE Province -->
        <div class="modal fade" id="modalUpdateProvince" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update Province</h4>
                    </div>

                    <form role="form" data-toggle="validator" id="formUpdate">
                        <div class="modal-body">
                            <div class="box-body">
                                <p class="help-block col-sm-12" id="formErrorMessageUpdate" style="color:red;">
                                    Something went wrong, please check your inputs.
                                </p>
                                <input type="hidden" class="form-control" id="inputIdUpdate" required>
                                <div class="form-group  col-sm-12">
                                    <input type="text" class="form-control" id="inputProvinceUpdate" placeholder="Province" required>
                                </div>
                                <div class="form-group  col-sm-12">
                                    <input class="form-control" id="inputDescriptionUpdate" placeholder="Description" required>
                                </div>
                                <div class="form-group col-sm-12">
                                    <select class="form-control" id="inputRegionUpdate" placeholder="Region" required>
                                        @foreach($regions as $region)
                                            <option value="{{$region->id_region}}">{{$region->region_description }} ({{$region->region_code}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="help-block"></p>
                                <div class="form-group  col-sm-6">
                                    <input type="hidden" class="form-control" id="inputProvincePrimaryKey">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <span class="form-group">
                                <button type="submit" id="btnUpdateProvinceSubmit" class="btn btn-success">Update Province</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL UPDATE Province-->

        <!-- MODAL SUCCESSFUL UPDATE -->
        <div class="modal fade" id="modalSuccessfulUpdate" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update Province</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Update successful.
                        </p>
                        <div class="successMessage">
                            <p>The updated Province is: </p>
                            <p>Province: <span id="updatedProvince" class="credentials"></span></p>
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


        <!-- MODAL SUCCESSFUL DELETE Province -->
        <div class="modal fade" id="modalDeleteProvinceSuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Delete Province</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Delete Province success.
                        </p>
                        <div class="successMessage">
                            <p>Province : <span id="deletedProvince" class="credentials"></span></p>
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
        <!-- MODAL SUCCESSFUL DELETE Province -->

        <!-- MODAL SUCCESSFUL RESTORE Province -->
        <div class="modal fade" id="modalRestoredProvinceSuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Restore Province</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Restore Province success.
                        </p>
                        <div class="successMessage">
                            <p>Province : <span id="restoredProvince" class="credentials"></span></p>
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
        <!-- MODAL SUCCESSFUL RESTORE Province -->
@stop

@section('script')
    <script src="{{ URL::asset('assets/js/provinceIndex.js') }}"></script>
@stop
