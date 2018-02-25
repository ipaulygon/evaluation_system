<div class="col-md-12" id="regionTable">
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
                        <th>Date Deleted</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($regions as $region)
                        <tr>
                            <td class="hide classRegionPrimaryKey">{{$region->id_region}}</td>
                            <td class="classCode clickable-row" style="cursor: pointer" data-href="region/show/{{$region->id_region}}">
                                {{$region->region_code}}
                            </td>
                            <td class="classDescription clickable-row" style="cursor: pointer" data-href="region/show/{{$region->id_region}}">
                                {{$region->region_description}}
                            </td>
                            <td class="dateDeleted">
                                {{date('M j, Y',strtotime($region->delete_date))}}
                            </td>
                            <td width="100px">
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-default btnRestoreRegion" data-toggle="tooltip" title="Reactivate">
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
                        <th>Region</th>
                        <th>Description</th>
                        <th>Date Deleted</th>
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
<script src="{{ URL::asset('assets/js/regionIndex.js') }}"></script>