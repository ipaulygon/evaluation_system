$('#dtblBarangay').dataTable();
$('document').ready(function(){
    $('.loading').addClass('hide');
    // $('#dtblBarangay tbody').on('click', '.clickable-row', function () {
    //     window.location = $(this).data("href");
    // } );

});

$(".addBarangay").click(function(){
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputBarangay").val("");
    $("#inputDescription").val("");
    $("#inputCity").val("");
});

$('#form').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        $('#loadingBarangay').addClass('overlay');
        $('#loadingBarangayDesign').addClass('fa fa-refresh fa-spin')
        /* 
            for create appraiser loading state
        */
        var $btnCreateBarangay = $('#btnCreateBarangay');
        $btnCreateBarangay.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var code = $("#inputBarangay").val();
        var description = $("#inputDescription").val();
        var city = $("#inputCity").val();
        $.ajax({
            url: "barangays/create",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {code: code, description: description, city: city},
            success:function(data){
                if(data == 'error'){
                    $("#formErrorMessage").show();
                    $btnCreateBarangay.button('reset');  
                } else{
                    $('#barangayTable').html(data);
                    $('#modalAddBarangay').modal('hide');
                    $('#successCode').text(code);
                    $('#successDescription').text(description);
                    $('#modalSuccessfulCreation').modal('show');
                    $btnCreateBarangay.button('reset');
                    $(".selFilter").val(0);  
                }
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})

$("#btnCreateAnotherBarangay").click(function(){
    $('#modalSuccessfulCreation').modal('hide');
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputBarangay").val("");
    $("#inputDescription").val("");
    $("#inputCity").val("");
    $('#modalAddBarangay').modal('show');
});

$('#dtblBarangay tbody').on('click', '.btnUpdateBarangay', function () {
    if($('#formUpdate').data('bs.validator').validate().hasErrors()) {
        $('#formUpdate').data('bs.validator').reset();
    }
    
    var id = $(this).parent().parent().parent().find('.classBarangayPrimaryKey').text().trim(); 
    var code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var description = $(this).parent().parent().parent().find('.classDescription').text().trim();
    var city = $(this).parent().parent().parent().find('.classCity').text().trim();

    $("#inputIdUpdate").val(id);
    $("#inputBarangayUpdate").val(code);
    $("#inputDescriptionUpdate").val(description);
    $("#inputCityUpdate").val(city);
    $("#formErrorMessageUpdate").hide();
    $('#modalUpdateBarangay').modal('show');
} );


$('#formUpdate').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        /* 
            for create appraiser loading state
        */
        var $btnUpdateBarangaySubmit = $('#btnUpdateBarangaySubmit');
        $btnUpdateBarangaySubmit.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var id = $("#inputIdUpdate").val();
        var code = $("#inputBarangayUpdate").val();
        var description = $("#inputDescriptionUpdate").val();
        var city = $("#inputCityUpdate").val();
        $.ajax({
            url: "barangays/update",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {id: id, code: code, description: description, city: city},
            success:function(data){
                if(data == 'error'){
                    $("#formErrorMessageUpdate").show();
                    $btnUpdateBarangaySubmit.button('reset');  
                } else{
                    $('#barangayTable').html(data);
                    $('#modalUpdateBarangay').modal('hide');  
                    $('#updatedBarangay').text(code);
                    $('#updatedDescription').text(description);
                    $('#modalSuccessfulUpdate').modal('show');
                    $btnUpdateBarangaySubmit.button('reset');
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
    $('#loadingBarangay').addClass('overlay');
    $('#loadingBarangayDesign').addClass('fa fa-refresh fa-spin')
    $.ajax({
        url: "barangays/filter",
        type:"POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {selFilterValue : selFilterValue},
        success:function(data){
            $('#barangayTable').html(data);
        },error:function(data){
            alert("Error!");
        }
    });
});

$('#dtblBarangay tbody').on('click', '.btnDeleteBarangay', function(){
    var id = $(this).parent().parent().parent().find('.classBarangayPrimaryKey').text().trim(); 
    var code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var description = $(this).parent().parent().parent().find('.classDescription').text().trim();
    var city = $(this).parent().parent().parent().find('.classCityName').text().trim();
    console.log(id);
    bootbox.confirm({ 
        size: "small",
        title: "<b>Deactivate " + description + " ("+code+")</b>",
        message:  "This record will be deactivated immediately",
        callback: function(result){ 
            if(result){
                $('#loadingBarangay').addClass('overlay');
                $('#loadingBarangayDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "barangays/delete",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {id : id},
                    success:function(data){
                        $('#barangayTable').html(data);
                        $('#deletedBarangay').text(code);
                        $('#deletedDescription').text(description);                        
                        $('#modalDeleteBarangaySuccess').modal('show');
                    },error:function(data){                       
                        alert("Error!");
                    }
                });
            }
        }
    })

});

$('#dtblBarangay tbody').on('click', '.btnRestoreBarangay', function () {
    var id = $(this).parent().parent().parent().find('.classBarangayPrimaryKey').text().trim(); 
    var code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var description = $(this).parent().parent().parent().find('.classDescription').text().trim();
    var city = $(this).parent().parent().parent().find('.classCityName').text().trim();
    bootbox.confirm({ 
        size: "small",
        title: "<b>Reactivate " + description + " ("+code+")</b>",
        message:  "This record can be used again.",
        callback: function(result){ 
            if(result){
                $('#loadingBarangay').addClass('overlay');
                $('#loadingBarangayDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "barangays/reactivate",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {id : id},
                    success:function(data){
                        $('#barangayTable').html(data);
                        $('#restoredBarangay').text(code);
                        $('#restoredDescription').text(description);
                        $('#modalRestoredBarangaySuccess').modal('show');
                        $(".selFilter").val(0); 
                    },error:function(data){ 
                        alert("Error!");
                    }
                });
            }
        }
    })
} );










