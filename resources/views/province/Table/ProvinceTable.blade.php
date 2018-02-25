<div class="box">
    <div class="box-header">
        <h3 class="box-title">Province</h3>
    </div>
    <div class="box-body">
        <table id="dtblProvince" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="hide"></th>
                    <th class="hide"></th>                    
                    <th>Province</th>
                    <th>Description</th>
                    <th>Region</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($provinces as $province)
                    <tr>
                        <td class="hide classProvincePrimaryKey">{{$province->id_province}}</td>
                        <td class="hide classRegion">{{$province->region->id_region}}</td>                        
                        <td class="classCode clickable-row" style="cursor: pointer" data-href="provinces/show/{{$province->id_province}}">
                            {{$province->province_code}}
                        </td>
                        <td class="classDescription clickable-row" style="cursor: pointer" data-href="provinces/show/{{$province->id_province}}">
                            {{$province->province_description}}
                        </td>
                        <td class="classRegionName clickable-row" style="cursor: pointer" data-href="provinces/show/{{$province->id_province}}">
                            {{$province->region->region_description}}
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default btnUpdateProvince" data-toggle="tooltip" title="Update">
                                    <i class="fa fa-fw fa-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-default btnDeleteProvince" data-toggle="tooltip" title="Deactivate">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Province</th>
                    <th>Description</th>
                    <th>Region</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div id="loadingProvince">
        <i id="loadingProvinceDesign"></i>
    </div>
</div>
<script src="{{ URL::asset('assets/js/provinceIndex.js') }}"></script>
