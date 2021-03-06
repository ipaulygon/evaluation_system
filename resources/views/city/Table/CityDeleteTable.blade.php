<div class="box">
    <div class="box-header">
        <h3 class="box-title">City</h3>
    </div>
    <div class="box-body">
        <table id="dtblCity" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="hide"></th>
                    <th class="hide"></th>
                    <th>City</th>
                    <th>Description</th>
                    <th>Province</th>
                    <th>Date Deleted</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cities as $city)
                    <tr>
                        <td class="hide classCityPrimaryKey">{{$city->id_city}}</td>
                        <td class="hide classProvince">{{$city->province->id_province}}</td>                        
                        <td class="classCode clickable-row" style="cursor: pointer" data-href="cities/show/{{$city->id_city}}">
                            {{$city->city_code}}
                        </td>
                        <td class="classDescription clickable-row" style="cursor: pointer" data-href="cities/show/{{$city->id_city}}">
                            {{$city->city_description}}
                        </td>
                        <td class="classProvinceName clickable-row" style="cursor: pointer" data-href="cities/show/{{$city->id_city}}">
                            {{$city->province->province_description}}
                        </td>
                        <td class="dateDeleted" style="cursor: pointer" data-href="cities/show/{{$city->id_city}}">
                            {{date('M j, Y',strtotime($city->delete_date))}}
                        </td>
                        <td width="100px">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default btnRestoreCity" data-toggle="tooltip" title="Reactivate">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>City</th>
                    <th>Description</th>
                    <th>Province</th>
                    <th>Date Deleted</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div id="loadingCity">
        <i id="loadingCityDesign"></i>
    </div>
</div>
<script src="{{ URL::asset('assets/js/cityIndex.js') }}"></script>
