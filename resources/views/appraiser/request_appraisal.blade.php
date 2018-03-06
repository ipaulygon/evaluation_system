@extends('layouts.appraiser')

@section('title', 'My Properties')
@section('content')
    <div class="container" id="container">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h3 class="box-title">Appraisal Requests</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="loading">Loading&#8230;</div>
            <div class="col-md-12" id="appraisalTable">
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
                                                    <a class="btn btn-sm btn-default btnShowAppraiseProperty" data-toggle="tooltip" title="View">
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
            </div>
        </div>
    </div>
@stop


@section('script')
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.extensions.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.numeric.extensions.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script>
        $('#dtblAppraisal').dataTable();
            $('document').ready(function(){
                $('.loading').addClass('hide');
        });
        $(document).on('click','.btnShowAppraiseProperty', function(){
            var id = $(this).parent().parent().parent().find('.classAppraisalPrimaryKey').text(); 
            $.ajax({
                type: "POST",
                url: "/view_appraised_property",
                data: {id: id},
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                success:function(data){
                    $('#container').html(data);
                    $(".number").inputmask({ 
                        alias: "currency",
                        prefix: '',
                        allowMinus: false,
                        autoGroup: true,
                        min: 0
                    });
                    $('.loading').addClass('hide');                    
                },
                error:function(data){
                    alert('error');
                }
            });
        });
        $(document).on('click','.btnRejectProperty', function(){
            var id = $(this).parent().parent().parent().find('.classAppraisalPrimaryKey').text(); 
            bootbox.confirm({ 
                    size: "small",
                    title: "<b>Reject Appraisal</b>",
                    message:  "Reject this appraisal?",
                    callback: function(result){ 
                        if(result){
                            $('#loadingProperty').addClass('overlay');
                            $('#loadingPropertyDesign').addClass('fa fa-refresh fa-spin')
                            $.ajax({
                                type: "POST",
                                url: "/reject_property",
                                data: {id: id},
                                beforeSend: function (xhr) {
                                    var token = $('meta[name="csrf_token"]').attr('content');
                                    if (token) {
                                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                                    }
                                },
                                success:function(data){
                                    $('#appraisalTable').html(data);
                                    $('#dtblAppraisal').dataTable();
                                },
                                error:function(data){
                                    alert('error');
                                }
                            });
                        }
                    }
                });
        });
        
    </script>
@stop