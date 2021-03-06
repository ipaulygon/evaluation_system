<div class="box">
    <div class="box-header">
        <h3 class="box-title">House Model</h3>
    </div>
    <div class="box-body">
        <table id="dtblHouseModel" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="hide"></th>
                    <th>House Model</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($models as $houseModel)
                    <tr>
                        <td class="hide classHouseModelPrimaryKey">{{$houseModel->id_house_model}}</td>
                        <td class="classCode clickable-row" style="cursor: pointer" data-href="houseModels/show/{{$houseModel->id_house_model}}">
                            {{$houseModel->house_model}}
                        </td>
                        <td class="classDescription clickable-row" style="cursor: pointer" data-href="houseModels/show/{{$houseModel->id_house_model}}">
                            {{$houseModel->description}}
                        </td>
                        <td width="100px">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default btnRestoreHouseModel" data-toggle="tooltip" title="Reactivate">
                                        <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>House Model</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div id="loadingHouseModel">
        <i id="loadingHouseModelDesign"></i>
    </div>
</div>
<script src="{{ URL::asset('assets/js/houseModelIndex.js') }}"></script>
