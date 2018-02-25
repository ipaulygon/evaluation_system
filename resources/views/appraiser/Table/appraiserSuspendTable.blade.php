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
                        <th>Last signed-in</th>
                        <th>Date suspended</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appraisers as $appraiser)
                        <tr>
                            <td class="hide classAppraiserPrimaryKey">{{$appraiser->id_appraiser}}</td>
                            <td class="hide classFirstname">{{$appraiser->first_name}}</td>
                            <td class="hide classMiddlename">{{$appraiser->middle_name}}</td>
                            <td class="hide classLastname">{{$appraiser->last_name}}</td>
                            <td class="hide classUserID">{{$appraiser->id_user}}</td>
                            <td style="cursor: pointer" class="clickable-row name" data-href="appraiser/show/{{$appraiser->id_appraiser}}">
                                {{$appraiser->first_name}} {{$appraiser->last_name}}
                            </td>
                            <td class="lastSignedIn">
                                <?php
                                $dateLastSignedin = ($appraiser->last_signedin == "0000-00-00 00:00:00") ? "Never logged in" :
                                    date('M j, Y',strtotime($appraiser->last_signedin));
                                ?>   
                                {{$dateLastSignedin}}
                            </td>
                            <td class="dateDeleted">
                                {{date('M j, Y',strtotime($appraiser->update_date))}}
                            </td>
                            <td width="100px">
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-default btnRestoreAppraiser" data-toggle="tooltip" title="Restore Appraiser">
                                            <i class="fa fa-fw fa-refresh"></i>
                                    </button>
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
                        <th>Date suspended</th>
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