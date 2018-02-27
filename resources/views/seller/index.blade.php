@extends('layouts.admin')

@section('title', 'Sellers')
@section('content')
    <section class="content-header">
        <h1>
            Seller
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
                                <option value="0">Active Sellers</option>
                                <option value="1">Suspended Sellers</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="loading">Loading&#8230;</div>
            <div class="col-md-9" id="sellerTable">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Seller</h3>
                    </div>
                    <div class="box-body">
                        <table id="dtblSeller" class="table table-bordered table-hover">
                            <thead>
                                <tr>  
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sellers as $seller)
                                    <tr>
                                        <td class="hide classSellerPrimaryKey">{{$seller->id_seller}}</td>
                                        <td class="hide classFirstname">{{$seller->first_name}}</td>
                                        <td class="hide classMiddlename">{{$seller->middle_name}}</td>
                                        <td class="hide classLastname">{{$seller->last_name}}</td>
                                        <td class="hide classUserID">{{$seller->id_user}}</td>
                                        <td style="cursor: pointer" class="clickable-row name" data-href="seller/show/{{$seller->id_seller}}">
                                            {{$seller->first_name}} {{$seller->last_name}}
                                        </td>
                                        <td class="status">
                                            {{$seller->isActive==1 ? "Active":"Pending"}}
                                        </td>
                                        <td width="150px">
                                            <div class="btn-group">
                                                @if($seller->isActive==1)
                                                <button class="btn btn-sm btn-default btnSuspendSeller" data-toggle="tooltip" title="Deactivate">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                @else
                                                <button class="btn btn-sm btn-default btnAcceptSeller" data-toggle="tooltip" title="Accept Seller">
                                                    <i class="fa fa-check"></i>
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
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="loadingSeller">
                        <i id="loadingSellerDesign"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL SUSPEND APPRAISER -->
        <div class="modal fade" id="modalSuspendSellerSuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Suspend Seller</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Suspend seller success.
                        </p>
                        <div class="successMessage">
                            <p>Seller <span id="suspendedSeller" class="credentials"></span> is now suspended</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL SUSPEND APPRAISER -->

        <!-- MODAL SUCCESSFUL RESTORE APPRAISER -->
        <div class="modal fade" id="modalRestoredSellerSuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Restore Seller</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Restore seller success.
                        </p>
                        <div class="successMessage">
                            <p>Seller <span id="restoredSeller" class="credentials"></span> is now restored</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAcceptedSellerSuccess" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Accept Seller</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <img class="img-responsive" src="assets/image/icons/successIcon.png" alt="Success Icon" width="20px" align="left">
                            &nbsp; Accept seller success.
                        </p>
                        <div class="successMessage">
                            <p>Seller <span id="restoredSeller" class="credentials"></span> is now accepted.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" id="btnPrint" class="btn btn-success">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL SUCCESSFUL RESTORE APPRAISER -->
    </section>
@stop


@section('script')
    <script src="{{ URL::asset('assets/js/seller.js') }}"></script>
@stop