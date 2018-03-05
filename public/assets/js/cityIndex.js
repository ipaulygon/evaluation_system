$('#dtblCity').dataTable();
$('document').ready(function(){
    $('.loading').addClass('hide');
    // $('#dtblCity tbody').on('click', '.clickable-row', function () {
    //     window.location = $(this).data("href");
    // } );

});

$(".addCity").click(function(){
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputCity").val("");
    $("#inputDescription").val("");
    $("#inputProvince").val("");
});

$('#form').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        $('#loadingCity').addClass('overlay');
        $('#loadingCityDesign').addClass('fa fa-refresh fa-spin')
        /* 
            for create appraiser loading state
        */
        var $btnCreateCity = $('#btnCreateCity');
        $btnCreateCity.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var code = $("#inputCity").val();
        var description = $("#inputDescription").val();
        var province = $("#inputProvince").val();
        $.ajax({
            url: "cities/create",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {code: code, description: description, province: province},
            success:function(data){
                console.log(data);
                if(data == 'error'){
                    $("#formErrorMessage").show();
                    $btnCreateCity.button('reset');  
                } else{
                    $('#cityTable').html(data);
                    $('#modalAddCity').modal('hide');
                    $('#successCode').text(code);
                    $('#successDescription').text(description);
                    $('#modalSuccessfulCreation').modal('show');
                    $btnCreateCity.button('reset');
                    $(".selFilter").val(0);  
                }
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})

$("#btnCreateAnotherCity").click(function(){
    $('#modalSuccessfulCreation').modal('hide');
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputCity").val("");
    $("#inputDescription").val("");
    $("#inputProvince").val("");
    $('#modalAddCity').modal('show');
});

$('#dtblCity tbody').on('click', '.btnUpdateCity', function () {
    if($('#formUpdate').data('bs.validator').validate().hasErrors()) {
        $('#formUpdate').data('bs.validator').reset();
    }
    
    var id = $(this).parent().parent().parent().find('.classCityPrimaryKey').text().trim(); 
    var code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var description = $(this).parent().parent().parent().find('.classDescription').text().trim();
    var province = $(this).parent().parent().parent().find('.classProvince').text().trim();

    $("#inputIdUpdate").val(id);
    $("#inputCityUpdate").val(code);
    $("#inputDescriptionUpdate").val(description);
    $("#inputProvinceUpdate").val(province);
    $("#formErrorMessageUpdate").hide();
    $('#modalUpdateCity').modal('show');
} );


$('#formUpdate').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        /* 
            for create appraiser loading state
        */
        var $btnUpdateCitySubmit = $('#btnUpdateCitySubmit');
        $btnUpdateCitySubmit.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var id = $("#inputIdUpdate").val();
        var code = $("#inputCityUpdate").val();
        var description = $("#inputDescriptionUpdate").val();
        var province = $("#inputProvinceUpdate").val();
        $.ajax({
            url: "cities/update",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {id: id, code: code, description: description, province: province},
            success:function(data){
                if(data == 'error'){
                    $("#formErrorMessageUpdate").show();
                    $btnUpdateCitySubmit.button('reset');  
                } else{
                    $('#cityTable').html(data);
                    $('#modalUpdateCity').modal('hide');  
                    $('#updatedCity').text(code);
                    $('#updatedDescription').text(description);
                    $('#modalSuccessfulUpdate').modal('show');
                    $btnUpdateCitySubmit.button('reset');
                    $(".selFilter").val(0); 
                }
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})

$( ".selFilter" ).change(function() {
    var selFilterValue = $( ".selFilter" ).val();
    $('#loadingCity').addClass('overlay');
    $('#loadingCityDesign').addClass('fa fa-refresh fa-spin')
    $.ajax({
        url: "cities/filter",
        type:"POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {selFilterValue : selFilterValue},
        success:function(data){
            $('#cityTable').html(data);
        },error:function(data){
            alert("Error!");
        }
    });
});

$('#dtblCity tbody').on('click', '.btnDeleteCity', function(){
    var id = $(this).parent().parent().parent().find('.classCityPrimaryKey').text().trim(); 
    var code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var description = $(this).parent().parent().parent().find('.classDescription').text().trim();
    var province = $(this).parent().parent().parent().find('.classProvinceName').text().trim();
    console.log(id);
    bootbox.confirm({ 
        size: "small",
        title: "<b>Deactivate " + description + " ("+code+")</b>",
        message:  "This record will be deactivated immediately",
        callback: function(result){ 
            if(result){
                $('#loadingCity').addClass('overlay');
                $('#loadingCityDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "cities/delete",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {id : id},
                    success:function(data){
                        $('#cityTable').html(data);
                        $('#deletedCity').text(code);
                        $('#deletedDescription').text(description);                        
                        $('#modalDeleteCitySuccess').modal('show');
                    },error:function(data){                       
                        alert("Error!");
                    }
                });
            }
        }
    })

});

$('#dtblCity tbody').on('click', '.btnRestoreCity', function () {
    var id = $(this).parent().parent().parent().find('.classCityPrimaryKey').text().trim(); 
    var code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var description = $(this).parent().parent().parent().find('.classDescription').text().trim();
    var province = $(this).parent().parent().parent().find('.classProvinceName').text().trim();
    bootbox.confirm({ 
        size: "small",
        title: "<b>Reactivate " + description + " ("+code+")</b>",
        message:  "This record can be used again.",
        callback: function(result){ 
            if(result){
                $('#loadingCity').addClass('overlay');
                $('#loadingCityDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "cities/reactivate",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {id : id},
                    success:function(data){
                        $('#cityTable').html(data);
                        $('#restoredCity').text(code);
                        $('#restoredDescription').text(description);
                        $('#modalRestoredCitySuccess').modal('show');
                        $(".selFilter").val(0); 
                    },error:function(data){ 
                        alert("Error!");
                    }
                });
            }
        }
    })
} );










