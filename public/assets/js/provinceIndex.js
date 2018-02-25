$('#dtblProvince').dataTable();
$('document').ready(function(){
    $('.loading').addClass('hide');
    $('#dtblProvince tbody').on('click', '.clickable-row', function () {
        window.location = $(this).data("href");
    } );

});

$(".addProvince").click(function(){
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputProvince").val("");
    $("#inputDescription").val("");
    $("#inputRegion").val("");
});

$('#form').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        $('#loadingProvince').addClass('overlay');
        $('#loadingProvinceDesign').addClass('fa fa-refresh fa-spin')
        /* 
            for create appraiser loading state
        */
        var $btnCreateProvince = $('#btnCreateProvince');
        $btnCreateProvince.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var code = $("#inputProvince").val();
        var description = $("#inputDescription").val();
        var region = $("#inputRegion").val();
        $.ajax({
            url: "provinces/create",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {code: code, description: description, region: region},
            success:function(data){
                console.log(data);
                if(data == 'error'){
                    $("#formErrorMessage").show();
                    $btnCreateProvince.button('reset');  
                } else{
                    $('#provinceTable').html(data);
                    $('#modalAddProvince').modal('hide');
                    $('#successCode').text(code);
                    $('#successDescription').text(description);
                    $('#modalSuccessfulCreation').modal('show');
                    $btnCreateProvince.button('reset');
                    $(".selFilter").val(0);  
                }
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})

$("#btnCreateAnotherProvince").click(function(){
    $('#modalSuccessfulCreation').modal('hide');
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputProvince").val("");
    $("#inputDescription").val("");
    $("#inputRegion").val("");
    $('#modalAddProvince').modal('show');
});

$('#dtblProvince tbody').on('click', '.btnUpdateProvince', function () {
    if($('#formUpdate').data('bs.validator').validate().hasErrors()) {
        $('#formUpdate').data('bs.validator').reset();
    }
    
    var id = $(this).parent().parent().parent().find('.classProvincePrimaryKey').text().trim(); 
    var code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var description = $(this).parent().parent().parent().find('.classDescription').text().trim();
    var region = $(this).parent().parent().parent().find('.classRegion').text().trim();

    $("#inputIdUpdate").val(id);
    $("#inputProvinceUpdate").val(code);
    $("#inputDescriptionUpdate").val(description);
    $("#inputRegionUpdate").val(region);
    $("#formErrorMessageUpdate").hide();
    $('#modalUpdateProvince').modal('show');
} );


$('#formUpdate').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        /* 
            for create appraiser loading state
        */
        var $btnUpdateProvinceSubmit = $('#btnUpdateProvinceSubmit');
        $btnUpdateProvinceSubmit.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var id = $("#inputIdUpdate").val();
        var code = $("#inputProvinceUpdate").val();
        var description = $("#inputDescriptionUpdate").val();
        var region = $("#inputRegionUpdate").val();
        $.ajax({
            url: "provinces/update",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {id: id, code: code, description: description, region: region},
            success:function(data){
                if(data == 'error'){
                    $("#formErrorMessageUpdate").show();
                    $btnUpdateProvinceSubmit.button('reset');  
                } else{
                    $('#provinceTable').html(data);
                    $('#modalUpdateProvince').modal('hide');  
                    $('#updatedProvince').text(code);
                    $('#updatedDescription').text(description);
                    $('#modalSuccessfulUpdate').modal('show');
                    $btnUpdateProvinceSubmit.button('reset');
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
    $('#loadingProvince').addClass('overlay');
    $('#loadingProvinceDesign').addClass('fa fa-refresh fa-spin')
    $.ajax({
        url: "provinces/filter",
        type:"POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {selFilterValue : selFilterValue},
        success:function(data){
            $('#provinceTable').html(data);
        },error:function(data){
            alert("Error!");
        }
    });
});

$('#dtblProvince tbody').on('click', '.btnDeleteProvince', function(){
    var id = $(this).parent().parent().parent().find('.classProvincePrimaryKey').text().trim(); 
    var code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var description = $(this).parent().parent().parent().find('.classDescription').text().trim();
    var region = $(this).parent().parent().parent().find('.classRegionName').text().trim();
    console.log(id);
    bootbox.confirm({ 
        size: "small",
        title: "<b>Deactivate " + description + " ("+code+")</b>",
        message:  "This record will be deactivated immediately",
        callback: function(result){ 
            if(result){
                $('#loadingProvince').addClass('overlay');
                $('#loadingProvinceDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "provinces/delete",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {id : id},
                    success:function(data){
                        $('#provinceTable').html(data);
                        $('#deletedProvince').text(code);
                        $('#deletedDescription').text(description);                        
                        $('#modalDeleteProvinceSuccess').modal('show');
                    },error:function(data){                       
                        alert("Error!");
                    }
                });
            }
        }
    })

});

$('#dtblProvince tbody').on('click', '.btnRestoreProvince', function () {
    var id = $(this).parent().parent().parent().find('.classProvincePrimaryKey').text().trim(); 
    var code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var description = $(this).parent().parent().parent().find('.classDescription').text().trim();
    var region = $(this).parent().parent().parent().find('.classRegionName').text().trim();
    bootbox.confirm({ 
        size: "small",
        title: "<b>Reactivate " + description + " ("+code+")</b>",
        message:  "This record can be used again.",
        callback: function(result){ 
            if(result){
                $('#loadingProvince').addClass('overlay');
                $('#loadingProvinceDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "provinces/reactivate",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {id : id},
                    success:function(data){
                        $('#provinceTable').html(data);
                        $('#restoredProvince').text(code);
                        $('#restoredDescription').text(description);
                        $('#modalRestoredProvinceSuccess').modal('show');
                        $(".selFilter").val(0); 
                    },error:function(data){ 
                        alert("Error!");
                    }
                });
            }
        }
    })
} );










