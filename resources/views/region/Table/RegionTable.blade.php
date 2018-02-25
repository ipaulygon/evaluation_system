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
<script src="{{ URL::asset('assets/js/regionIndex.js') }}"></script>
