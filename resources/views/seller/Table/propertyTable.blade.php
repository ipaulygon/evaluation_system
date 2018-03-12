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
                                @if($property->property_status != 5)
                                <button type="button" class="btn btn-sm btn-default btnUploadProperty" data-toggle="modal" data-target="#modalUploadProperty" title="Upload Property">
                                    UPLOAD
                                </button>
                                @endif
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
                                <button type="button" class="btn btn-sm btn-default btnUpdatePublishProperty" data-toggle="modal" data-target="#modalUpdateProperty" title="Update">
                                    UPDATE
                                </button>
                                <button type="button" class="btn btn-sm btn-default btnSoldProperty" title="Sold">
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
<script src="{{ URL::asset('assets/js/sellerIndex.js') }}"></script>