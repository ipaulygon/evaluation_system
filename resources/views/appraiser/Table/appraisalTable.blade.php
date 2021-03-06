<div class="box">
    <div class="box-body">
        <table id="dtblAppraisal" class="table table-bordered table-hover">
            <thead>
                <tr>  
                    <th class="hide"></th>
                    <th class="hide"></th>
                    <th class="hide"></th>
                    <th class="hide"></th>
                    <th class="hide"></th>
                    <th class="hide"></th>
                    <th>Property Name</th>
                    <th>Property Location</th>
                    <th>Appraisal Status</th>
                    <th>Remarks</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($appraisals as $appraisal)
                    <tr>
                        <td class="hide classAppraisalPrimaryKey">{{$appraisal->id_appraisal}}</td>
                        <td class="hide classPropertyPrimaryKey">{{$appraisal->id_property}}</td>
                        <td class="hide classAppraiserPrimaryKey">{{$appraisal->id_appraiser}}</td>
                        <td class="hide classPropertyName">{{$appraisal->property->property_name}}</td>
                        <td class="hide classPropertyLocation">{{$appraisal->property->id_property_location}}</td>
                        <td class="hide classPropertyLocationAddress">{{$appraisal->property->propertyLocation->address}}</td>
                        <td style="cursor: pointer" class="clickable-row name" data-href="appraisal/show/{{$appraisal->id_appraisal}}">
                            {{$appraisal->property->property_name}}
                        </td>
                        <td class="location">
                            {{$appraisal->property->propertyLocation->address}}
                        </td>
                        <td class="appraisal_status">
                            <?php
                                $status = null;
                                if($appraisal->appraisal_status == 0){$status = "Available for Appraisal";}
                                if($appraisal->appraisal_status == 1){$status = "Requested for Appraisal";}
                                if($appraisal->appraisal_status == 2){$status = "Appraisal Completed";}
                                if($appraisal->appraisal_status == 3){$status = "Re-appraise";}
                                if($appraisal->appraisal_status == 4){$status = "Publish";}
                                if($appraisal->appraisal_status == 5){$status = "Sold";}
                            ?>   
                            {{$status}}
                        </td>
                            <td class="remarks">
                            {{$appraisal->remarks}}
                        </td>
                            <td>
                            <div class="btn-group">
                                @if($appraisal->appraisal_status==1)
                                    <a class="btn btn-sm btn-default btnAppraiseProperty" data-toggle="tooltip" href="/appraise_property/{{$appraisal->id_appraisal}}" title="Appraise">
                                        APPRAISE
                                    </a>
                                    <button type="button" class="btn btn-sm btn-default btnRejectProperty" data-toggle="tooltip" title="Reject">
                                        REJECT
                                    </button>
                                @elseif($appraisal->appraisal_status==2)
                                    <a class="btn btn-sm btn-default btnShowAppraiseProperty" title="View">
                                        VIEW
                                    </a>
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
                    <th class="hide"></th>
                    <th>Property Name</th>
                    <th>Property Location</th>
                    <th>Appraisal Status</th>
                    <th>Remarks</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div id="loadingProperty">
        <i id="loadingPropertyDesign"></i>
    </div>
</div>