$('#dtblHouseModel').dataTable();
$('document').ready(function(){
    $('.loading').addClass('hide');
    // $('#dtblHouseModel tbody').on('click', '.clickable-row', function () {
    //     window.location = $(this).data("href");
    // } );

});

$(".addHouseModel").click(function(){
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputHouseModel").val("");
    $("#inputDescription").val("");
});

$('#form').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        $('#loadingHouseModel').addClass('overlay');
        $('#loadingHouseModelDesign').addClass('fa fa-refresh fa-spin')
        /* 
            for create appraiser loading state
        */
        var $btnCreateHouseModel = $('#btnCreateHouseModel');
        $btnCreateHouseModel.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var code = $("#inputHouseModel").val();
        var description = $("#inputDescription").val();
        $.ajax({
            url: "housemodels/create",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {code: code, description: description},
            success:function(data){
                if(data == 'error'){
                    $("#formErrorMessage").show();
                    $btnCreateHouseModel.button('reset');  
                } else{
                    $('#houseModelTable').html(data);
                    $('#modalAddHouseModel').modal('hide');
                    $('#successCode').text(code);
                    $('#successDescription').text(description);
                    $('#modalSuccessfulCreation').modal('show');
                    $btnCreateHouseModel.button('reset');
                    $(".selFilter").val(0);  
                }
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})

$("#btnCreateAnotherHouseModel").click(function(){
    $('#modalSuccessfulCreation').modal('hide');
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputHouseModel").val("");
    $("#inputDescription").val("");
    $('#modalAddHouseModel').modal('show');
});

$('#dtblHouseModel tbody').on('click', '.btnUpdateHouseModel', function () {
    if($('#formUpdate').data('bs.validator').validate().hasErrors()) {
        $('#formUpdate').data('bs.validator').reset();
    }
    
    var houseModel_id = $(this).parent().parent().parent().find('.classHouseModelPrimaryKey').text().trim(); 
    var houseModel_code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var houseModel_description = $(this).parent().parent().parent().find('.classDescription').text().trim();
    
    $("#inputIdUpdate").val(houseModel_id);
    $("#inputHouseModelUpdate").val(houseModel_code);
    $("#inputDescriptionUpdate").val(houseModel_description);
    $("#formErrorMessageUpdate").hide();
    $('#modalUpdateHouseModel').modal('show');

} );


$('#formUpdate').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        /* 
            for create appraiser loading state
        */
        var $btnUpdateHouseModelSubmit = $('#btnUpdateHouseModelSubmit');
        $btnUpdateHouseModelSubmit.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var id = $("#inputIdUpdate").val();
        var code = $("#inputHouseModelUpdate").val();
        var description = $("#inputDescriptionUpdate").val();
        $.ajax({
            url: "housemodels/update",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {id: id, code: code, description: description},
            success:function(data){
                if(data == 'error'){
                    $("#formErrorMessageUpdate").show();
                    $btnUpdateHouseModelSubmit.button('reset');  
                } else{
                    $('#houseModelTable').html(data);
                    $('#modalUpdateHouseModel').modal('hide');  
                    $('#updatedHouseModel').text(code);
                    $('#updatedDescription').text(description);
                    $('#modalSuccessfulUpdate').modal('show');
                    $btnUpdateHouseModelSubmit.button('reset');
                    $(".selFilter").val(0); 
                }
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
});

$( ".selFilter" ).change(function() {
    var selFilterValue = $( ".selFilter" ).val();
    $('#loadingHouseModel').addClass('overlay');
    $('#loadingHouseModelDesign').addClass('fa fa-refresh fa-spin')
    $.ajax({
        url: "housemodels/filter",
        type:"POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {selFilterValue : selFilterValue},
        success:function(data){
            $('#houseModelTable').html(data);
        },error:function(data){ 
            alert("Error!");
        }
    });
});

$('#dtblHouseModel tbody').on('click', '.btnDeleteHouseModel', function () {
    var id = $(this).parent().parent().parent().find('.classHouseModelPrimaryKey').text().trim(); 
    var code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var description = $(this).parent().parent().parent().find('.classDescription').text().trim();
    bootbox.confirm({ 
        size: "small",
        title: "<b>Deactivate " + description + " ("+code+")</b>",
        message:  "This record will be deactivated immediately",        
        callback: function(result){ 
            if(result){
                $('#loadingHouseModel').addClass('overlay');
                $('#loadingHouseModelDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "housemodels/delete",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {id: id},
                    success:function(data){
                        $('#houseModelTable').html(data);  
                        $('#deletedHouseModel').text(code);
                        $('#deletedDescription').text(description);                        
                        $('#modalDeleteProvinceSuccess').modal('show');
                    },error:function(data){ 
                        alert("Error!");
                    }
                });
            }
        }
    })
} );


$('#dtblHouseModel tbody').on('click', '.btnRestoreHouseModel', function () {
    var id = $(this).parent().parent().parent().find('.classHouseModelPrimaryKey').text().trim(); 
    var code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var description = $(this).parent().parent().parent().find('.classDescription').text().trim(); 
    bootbox.confirm({ 
        size: "small",
        title: "<b>Reactivate " + description + " ("+code+")</b>",
        message:  "This record can be used again.",
        callback: function(result){ 
            if(result){
                $('#loadingHouseModel').addClass('overlay');
                $('#loadingHouseModelDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "housemodels/reactivate",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {id: id},
                    success:function(data){
                        $('#houseModelTable').html(data);
                        $('#restoredHouseModel').text(code);
                        $('#restoredDescription').text(description);
                        $('#modalRestoredHouseModelSuccess').modal('show');
                        $(".selFilter").val(0); 
                    },error:function(data){ 
                        alert("Error!");
                    }
                });
            }
        }
    })
} );










