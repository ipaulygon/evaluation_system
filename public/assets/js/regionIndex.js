$('#dtblRegion').dataTable();
$('document').ready(function(){
    $('.loading').addClass('hide');
    // $('#dtblRegion tbody').on('click', '.clickable-row', function () {
    //     window.location = $(this).data("href");
    // } );

});

$(".addRegion").click(function(){
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputRegion").val("");
    $("#inputDescription").val("");
});

$('#form').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        $('#loadingRegion').addClass('overlay');
        $('#loadingRegionDesign').addClass('fa fa-refresh fa-spin')
        /* 
            for create appraiser loading state
        */
        var $btnCreateRegion = $('#btnCreateRegion');
        $btnCreateRegion.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var code = $("#inputRegion").val();
        var description = $("#inputDescription").val();
        $.ajax({
            url: "regions/create",
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
                    $btnCreateRegion.button('reset');  
                } else{
                    $('#regionTable').html(data);
                    $('#modalAddRegion').modal('hide');
                    $('#successCode').text(code);
                    $('#successDescription').text(description);
                    $('#modalSuccessfulCreation').modal('show');
                    $btnCreateRegion.button('reset');
                    $(".selFilter").val(0);  
                }
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})

$("#btnCreateAnotherRegion").click(function(){
    $('#modalSuccessfulCreation').modal('hide');
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputRegion").val("");
    $("#inputDescription").val("");
    $('#modalAddRegion').modal('show');
});

$('#dtblRegion tbody').on('click', '.btnUpdateRegion', function () {
    if($('#formUpdate').data('bs.validator').validate().hasErrors()) {
        $('#formUpdate').data('bs.validator').reset();
    }
    
    var region_id = $(this).parent().parent().parent().find('.classRegionPrimaryKey').text().trim(); 
    var region_code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var region_description = $(this).parent().parent().parent().find('.classDescription').text().trim();
    
    $("#inputIdUpdate").val(region_id);
    $("#inputRegionUpdate").val(region_code);
    $("#inputDescriptionUpdate").val(region_description);
    $("#formErrorMessageUpdate").hide();
    $('#modalUpdateRegion').modal('show');

} );


$('#formUpdate').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        /* 
            for create appraiser loading state
        */
        var $btnUpdateRegionSubmit = $('#btnUpdateRegionSubmit');
        $btnUpdateRegionSubmit.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var id = $("#inputIdUpdate").val();
        var code = $("#inputRegionUpdate").val();
        var description = $("#inputDescriptionUpdate").val();
        $.ajax({
            url: "regions/update",
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
                    $btnUpdateRegionSubmit.button('reset');  
                } else{
                    $('#regionTable').html(data);
                    $('#modalUpdateRegion').modal('hide');  
                    $('#updatedRegion').text(code);
                    $('#updatedDescription').text(description);
                    $('#modalSuccessfulUpdate').modal('show');
                    $btnUpdateRegionSubmit.button('reset');
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
    $('#loadingRegion').addClass('overlay');
    $('#loadingRegionDesign').addClass('fa fa-refresh fa-spin')
    $.ajax({
        url: "regions/filter",
        type:"POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {selFilterValue : selFilterValue},
        success:function(data){
            $('#regionTable').html(data);
        },error:function(data){ 
            alert("Error!");
        }
    });
});

$('#dtblRegion tbody').on('click', '.btnDeleteRegion', function () {
    var id = $(this).parent().parent().parent().find('.classRegionPrimaryKey').text().trim(); 
    var code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var description = $(this).parent().parent().parent().find('.classDescription').text().trim();
    bootbox.confirm({ 
        size: "small",
        title: "<b>Deactivate " + description + " ("+code+")</b>",
        message:  "This record will be deactivated immediately",        
        callback: function(result){ 
            if(result){
                $('#loadingRegion').addClass('overlay');
                $('#loadingRegionDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "regions/delete",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {id: id},
                    success:function(data){
                        $('#regionTable').html(data);  
                        $('#deletedRegion').text(code);
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


$('#dtblRegion tbody').on('click', '.btnRestoreRegion', function () {
    var id = $(this).parent().parent().parent().find('.classRegionPrimaryKey').text().trim(); 
    var code = $(this).parent().parent().parent().find('.classCode').text().trim(); 
    var description = $(this).parent().parent().parent().find('.classDescription').text().trim(); 
    bootbox.confirm({ 
        size: "small",
        title: "<b>Reactivate " + description + " ("+code+")</b>",
        message:  "This record can be used again.",
        callback: function(result){ 
            if(result){
                $('#loadingRegion').addClass('overlay');
                $('#loadingRegionDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "regions/reactivate",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {id: id},
                    success:function(data){
                        $('#regionTable').html(data);
                        $('#restoredRegion').text(code);
                        $('#restoredDescription').text(description);
                        $('#modalRestoredRegionSuccess').modal('show');
                        $(".selFilter").val(0); 
                    },error:function(data){ 
                        alert("Error!");
                    }
                });
            }
        }
    })
} );










