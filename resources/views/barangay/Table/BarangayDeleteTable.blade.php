<div class="box">
    <div class="box-header">
        <h3 class="box-title">Barangay</h3>
    </div>
    <div class="box-body">
        <table id="dtblBarangay" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="hide"></th>
                    <th class="hide"></th>
                    <th>Barangay</th>
                    <th>Description</th>
                    <th>City</th>
                    <th>Date Deleted</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangays as $barangay)
                    <tr>
                        <td class="hide classBarangayPrimaryKey">{{$barangay->id_barangay}}</td>
                        <td class="hide classCity">{{$barangay->city->id_city}}</td>                        
                        <td class="classCode clickable-row" style="cursor: pointer" data-href="barangays/show/{{$barangay->id_barangay}}">
                            {{$barangay->barangay_code}}
                        </td>
                        <td class="classDescription clickable-row" style="cursor: pointer" data-href="barangays/show/{{$barangay->id_barangay}}">
                            {{$barangay->barangay_description}}
                        </td>
                        <td class="classCityName clickable-row" style="cursor: pointer" data-href="barangays/show/{{$barangay->id_barangay}}">
                            {{$barangay->city->city_description}}
                        </td>
                        <td class="dateDeleted" style="cursor: pointer" data-href="cities/show/{{$city->id_city}}">
                            {{date('M j, Y',strtotime($barangay->delete_date))}}
                        </td>
                        <td width="100px">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default btnRestoreBarangay" data-toggle="tooltip" title="Reactivate">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Barangay</th>
                    <th>Description</th>
                    <th>City</th>
                    <th>Date Deleted</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div id="loadingBarangay">
        <i id="loadingBarangayDesign"></i>
    </div>
</div>
<script src="{{ URL::asset('assets/js/barangayIndex.js') }}"></script>
