<div class="col-md-12" id="appraiserTable">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Appraiser</h3>
        </div>
        <div class="box-body">
            <table id="dtblAppraiser" class="table table-bordered table-hover">
                <thead>
                    <tr>  
                        <th class="hide"></th>
                        <th class="hide"></th>
                        <th class="hide"></th>
                        <th class="hide"></th>
                        <th class="hide"></th>
                        <th>Name</th>
                        <th>Date Added</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appraisers as $appraiser)
                        <tr>
                            <td class="hide classAppraiserPrimaryKey">{{$appraiser->id_appraiser}}</td>
                            <td class="hide classFirstname">{{$appraiser->first_name}}</td>
                            <td class="hide classFirstname">{{$appraiser->middle_name}}</td>
                            <td class="hide classLastname">{{$appraiser->last_name}}</td>
                            <td class="hide classUserID">{{$appraiser->id_user}}</td>
                            <td style="cursor: pointer" class="clickable-row name" data-href="appraiser/show/{{$appraiser->id_appraiser}}">
                                {{$appraiser->first_name}} {{$appraiser->last_name}}
                            </td>
                            <td class="lastSignedIn">
                                {{date('M j, Y',strtotime($appraiser->create_date))}}
                            </td>
                            <td width="150px">
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-default btnResetPassword" data-toggle="tooltip" title="Reset Password">
                                            <i class="fa fa-fw fa-unlock"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-default btnRenameAppraiser" data-toggle="tooltip" title="Rename">
                                        <i class="fa fa-fw fa-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" class="btnSuspendAppraiser">Suspend Enforcer</a></li>
                                    </ul>
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
                        <th>Last signed-in</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div id="loadingAppraiser">
            <i id="loadingAppraiserDesign"></i>
        </div>
    </div>
</div>
<script src="{{ URL::asset('assets/js/appraiserIndex.js') }}"></script>