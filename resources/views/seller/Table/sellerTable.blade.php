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
                            {{$seller->ind_active==1 ? "Active":"Pending"}}
                        </td>
                        <td width="150px">
                            <div class="btn-group">
                                @if($seller->ind_active==1)
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
<script src="{{ URL::asset('assets/js/seller.js') }}"></script>