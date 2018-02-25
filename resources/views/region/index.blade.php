@extends('layouts.admin')

@section('title', 'Region')

@section('content')
    <section class="content-header">
        <h1>
            Region
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
                                <option value="0">Active Regions</option>
                                <option value="1">Deleted Regions</option>
                            </select>
                        </div>
                        <button class="btn btn-success btn-block addRegion" data-toggle="modal" data-toggle="modal" data-target="#modalAddRegion" title="AddRegion">Add Region </button>
                    </div>
                </div>
            </div>
            <div class="loading">Loading&#8230;</div>
            <div class="col-md-9" id="regionTable">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Region</h3>
                    </div>
                    <div class="box-body">
                        <table id="dtblRegion" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="hide"></th>
                                    <th>Region</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($regions as $region)
                                    <tr>
                                        <td class="hide classRegionPrimaryKey">{{$region->id_region}}</td>
                                        <td class="classCode clickable-row" style="cursor: pointer" data-href="regions/show/{{$region->id_region}}">
                                            {{$region->region_code}}
                                        </td>
                                        <td class="classDescription clickable-row" style="cursor: pointer" data-href="regions/show/{{$region->id_region}}">
                                            {{$region->region_description}}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-default btnUpdateRegion" data-toggle="tooltip" title="Update">
                                                        <i class="fa fa-fw fa-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-default btnDeleteRegion" data-toggle="tooltip" title="Deactivate">
                                                        <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Region</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="loadingRegion">
                        <i id="loadingRegionDesign"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>  
    
    <!-- MODAL ADD Region -->
        <div class="modal fade" id="modalAddRegion" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create new Region</h4>
                    </div>

                    <form role="form" data-toggle="validator" id="form">
                        <div class="modal-body">
                            <div class="box-body">
                                <p class="help-block col-sm-12" id="formErrorMessage" style="color:red;">
                                    Something went wrong, please check your inputs.
                                </p>
                                <div class="form-group  col-sm-12">
                                    <input type="text" class="form-control" id="inputRegion" placeholder="Region" required>
                                </div>
                                <div class="form-group  col-sm-12">
                                    <input class="form-control" id="inputDescription" placeholder="Description" required>
                                </div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <span class="form-group">
                                <button type="submit" id="btnCreateRegion" class="btn btn-success">Create</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL ADD Region-->

        <!-- MODAL SUCCESSFUL CREATION -->
        <div class="modal fade" id="modalSuccessfulCreation" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create a new Region</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; A new Region <span id="successCode"></span> has been created.
                        </p>
                        <div class="successMessage">
                            <p>Region Description:</p>
                            <p id="successDescription" class="credentials"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="btnCreateAnotherRegion">CREATE ANOTHER Region</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL CREATION -->

        <!-- MODAL UPDATE Region -->
        <div class="modal fade" id="modalUpdateRegion" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update Region</h4>
                    </div>

                    <form role="form" data-toggle="validator" id="formUpdate">
                        <div class="modal-body">
                            <div class="box-body">
                                <p class="help-block col-sm-12" id="formErrorMessageUpdate" style="color:red;">
                                    Something went wrong, please check your inputs.
                                </p>
                                <input type="hidden" class="form-control" id="inputIdUpdate" required>
                                <div class="form-group  col-sm-12">
                                    <input type="text" class="form-control" id="inputRegionUpdate" placeholder="Region" required>
                                </div>
                                <div class="form-group  col-sm-12">
                                    <input class="form-control" id="inputDescriptionUpdate" placeholder="Description" required>
                                </div>
                                <p class="help-block"></p>
                                <div class="form-group  col-sm-6">
                                    <input type="hidden" class="form-control" id="inputRegionPrimaryKey">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <span class="form-group">
                                <button type="submit" id="btnUpdateRegionSubmit" class="btn btn-success">Update Region</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL UPDATE Region-->

        <!-- MODAL SUCCESSFUL UPDATE -->
        <div class="modal fade" id="modalSuccessfulUpdate" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update Region</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Update successful.
                        </p>
                        <div class="successMessage">
                            <p>The updated Region is: </p>
                            <p>Region: <span id="updatedRegion" class="credentials"></span></p>
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


        <!-- MODAL SUCCESSFUL DELETE Region -->
        <div class="modal fade" id="modalDeleteRegionSuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Delete Region</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Delete Region success.
                        </p>
                        <div class="successMessage">
                            <p>Region : <span id="deletedRegion" class="credentials"></span></p>
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
        <!-- MODAL SUCCESSFUL DELETE Region -->

        <!-- MODAL SUCCESSFUL RESTORE Region -->
        <div class="modal fade" id="modalRestoredRegionSuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Restore Region</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Restore Region success.
                        </p>
                        <div class="successMessage">
                            <p>Region : <span id="restoredRegion" class="credentials"></span></p>
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
        <!-- MODAL SUCCESSFUL RESTORE Region -->
@stop

@section('script')
    <script src="{{ URL::asset('assets/js/regionIndex.js') }}"></script>
@stop
