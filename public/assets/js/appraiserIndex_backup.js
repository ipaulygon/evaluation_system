$('#dtblAppraiser').dataTable();
$('document').ready(function(){
    $('.loading').addClass('hide');
    $('#dtblAppraiser tbody').on('click', '.clickable-row', function () {
        window.location = $(this).data("href");
    } );

});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
            reader.onload = function (e) {
                $('#inputDisplayPicture')
                .attr('src', e.target.result)
                .width(180);
            };
        reader.readAsDataURL(input.files[0]);
    }
}

$(".addAppraiser").click(function(){
    var passwordGenerated = randomString(7);
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputPassword").val(passwordGenerated);
    $("#inputReEnterPassword").val(passwordGenerated);
    $("#inputFirstname").val("");
    $("#inputLastname").val("");
    $("#inputEnforcerID").val("");
    $(".passwordCredential").hide();
    $("#setPasswordBlock").show();
});


function randomString(length){
    var stringGenerated = '';
    var chars = '0123456789!@#$_&abcdefghijklmnopwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for(var i = length; i > 0; --i){
        stringGenerated += chars[Math.floor(Math.random() * chars.length)];
    }
    return stringGenerated;
}

$(".passwordCredential").hide();
$("#setPassword").click(function(){
    $(".passwordCredential").show();
    $("#setPasswordBlock").hide();
    $("#inputPassword").val("");
    $("#inputReEnterPassword").val("");
});
$("#autoGeneratePassword").click(function(){
    $(".passwordCredential").hide();
    $("#setPasswordBlock").show();
    var passwordGenerated = randomString(7);
    $("#inputPassword").val(passwordGenerated);
    $("#inputReEnterPassword").val(passwordGenerated);
});


$('#form').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        $('#loadingAppraiser').addClass('overlay');
        $('#loadingAppraiserDesign').addClass('fa fa-refresh fa-spin')
        /* 
            for create appraiser loading state
        */
        var $btnCreateAppraiser = $('#btnCreateAppraiser');
        $btnCreateAppraiser.button('loading');
        /*
            Submit data to the controller using ajax
            */
            var strFirstname = $("#inputFirstname").val();
            var strMiddlename = $("#inputMiddlename").val();
            var strLastname = $("#inputLastname").val();
            var strAppraiserEmail = $("#inputAppraiserEmail").val();
            var strPassword = $("#inputPassword").val();
            var strReEnterPassword = $("#inputReEnterPassword").val();
            var picture = $("#inputPicture").val();
        var data = new FormData();
        data.append('strFirstname',strFirstname);
        data.append('strMiddlename',strMiddlename);
        data.append('strLastname',strLastname);
        data.append('strAppraiserEmail',strAppraiserEmail);
        data.append('strPassword',strPassword);
        data.append('strReEnterPassword',strReEnterPassword);
        // $.each($('#inputPicture')[0].files, function(i, file){
        //     data.append('inputPicture', file);
        // });
        // $data.append('picture',picture);
        var formData = new FormData($('#form')[0]);
        
        $.ajax({
            url: "appraiser/create",
            type:"POST",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: formData,
            // data: { strFirstname : strFirstname, strMiddlename : strMiddlename, strLastname : strLastname, strAppraiserEmail : strAppraiserEmail, strPassword : strPassword, picture: picture },
            success:function(data){
                console.log(data);
                if(data == 'error'){
                    $("#formErrorMessage").show();
                    $btnCreateAppraiser.button('reset');  
                } else{
                    $('#appraiserTable').html(data);
                    $('#modalAddAppraiser').modal('hide');
                    $('#successUsername').text(strAppraiserEmail);
                    $('#successPassword').text(strPassword);
                    $('#successFirstname').text(strFirstname);
                    $('#successLastname').text(strLastname);
                    $('#modalSuccessfulCreation').modal('show');
                    $btnCreateAppraiser.button('reset');
                    $(".selFilter").val(0);  
                }
                
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})

$("#btnCreateAnotherAppraiser").click(function(){
    $('#modalSuccessfulCreation').modal('hide');
    var passwordGenerated = randomString(7);
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputPassword").val(passwordGenerated);
    $("#inputReEnterPassword").val(passwordGenerated);
    $("#inputFirstname").val("");
    $("#inputMiddlename").val("");
    $("#inputLastname").val("");
    $("#inputAppraiserEmail").val("");
    $(".passwordCredential").hide();
    $("#setPasswordBlock").show();
    $('#modalAddAppraiser').modal('show');
});

$('#dtblAppraiser tbody').on('click', '.btnRenameAppraiser', function () {
    if($('#formRename').data('bs.validator').validate().hasErrors()) {
        $('#formRename').data('bs.validator').reset();
    }
    var appraiserPrimaryKey = $(this).parent().parent().parent().find('.classAppraiserPrimaryKey').text(); 
    var appraiserFirstname = $(this).parent().parent().parent().find('.classFirstname').text(); 
    var appraiserMiddlename = $(this).parent().parent().parent().find('.classMiddlename').text();
    var appraiserLastname = $(this).parent().parent().parent().find('.classLastname').text(); 
    
    $("#inputFirstnameRename").val(appraiserFirstname);
    $("#inputMiddlenameRename").val(appraiserMiddlename);
    $("#inputLastnameRename").val(appraiserLastname);
    $("#inputAppraiserEmail").val(appraiserPrimaryKey);
    $("#formErrorMessageRename").hide();
    $('#modalRenameAppraiser').modal('show');

} );


$('#formRename').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        /* 
            for create appraiser loading state
        */
        var $btnRenameAppraiserSubmit = $('#btnRenameAppraiserSubmit');
        $btnRenameAppraiserSubmit.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var strFirstname = $("#inputFirstnameRename").val();
        var strMiddlename = $("#inputMiddlenameRename").val();
        var strLastname = $("#inputLastnameRename").val();
        var strPrimaryKey = $("#inputAppraiserPrimaryKey").val();
        $.ajax({
            url: "appraiser/update",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {strPrimaryKey : strPrimaryKey, strFirstname : strFirstname, strMiddlename : strMiddlename, strLastname : strLastname},
            success:function(data){
                if(data == 'error'){
                    $("#formErrorMessageRename").show();
                    $btnRenameAppraiserSubmit.button('reset');  
                } else{
                    $('#appraiserTable').empty();
                    $('#appraiserTable').append(data);
                    $('#modalRenameAppraiser').modal('hide');  
                    $('#updatedName').text(strFirstname +' '+ strLastname);
                    $('#modalSuccessfulRename').modal('show');
                    $btnRenameAppraiserSubmit.button('reset');
                    $(".selFilter").val(0); 
                }
                
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})

$("#autoGeneratePasswordReset").click(function(){
    var passwordGenerated = randomString(7);
    $("#inputPasswordReset").val(passwordGenerated);
    $("#inputReEnterPasswordReset").val(passwordGenerated);
});

$('#dtblAppraiser tbody').on('click', '.btnResetPassword', function () {
    if($('#formResetPassword').data('bs.validator').validate().hasErrors()) {
        $('#formResetPassword').data('bs.validator').reset();
    }
    var userID = $(this).parent().parent().parent().find('.classUserID').text();
    $("#inputUserID").val(userID); 
    $('#modalResetPassword').modal('show');
    $("#inputPasswordReset").val("");
    $("#inputReEnterPasswordReset").val("");
} );

$('#formResetPassword').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        /* 
            for create appraiser loading state
        */
        var $btnResetPasswordSubmit = $('#btnResetPasswordSubmit');
        $btnResetPasswordSubmit.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var intUserID = $("#inputUserID").val();
        var strPassword = $("#inputPasswordReset").val();
        $.ajax({
            url: "appraiser/resetpassword",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {intUserID : intUserID, strPassword : strPassword},
            success:function(data){
                if(data == 'error'){
                    $btnResetPasswordSubmit.button('reset');  
                } else{
                    $('#modalResetPassword').modal('hide');  
                    $('#updatedPassword').text(strPassword);
                    $('#modalResetPasswordSuccess').modal('show');
                    $btnResetPasswordSubmit.button('reset');
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
    $('#loadingAppraiser').addClass('overlay');
    $('#loadingAppraiserDesign').addClass('fa fa-refresh fa-spin')
    $.ajax({
        url: "appraiser/filter",
        type:"POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {selFilterValue : selFilterValue},
        success:function(data){
            $('#appraiserTable').empty();    
            $('#appraiserTable').append(data);
        },error:function(data){ 
            alert("Error!");
        }
    });
});

$('#dtblAppraiser tbody').on('click', '.btnSuspendAppraiser', function () {
    var strFirstname = $(this).parent().parent().parent().parent().parent().find('.classFirstname').text();
    var strLastname = $(this).parent().parent().parent().parent().parent().find('.classLastname').text();
    var strPrimaryKey = $(this).parent().parent().parent().parent().parent().find('.classAppraiserPrimaryKey').text(); 
    bootbox.confirm({ 
        size: "small",
        title: "<b>Suspend " + strFirstname + " " + strLastname + "</b>",
        message:  "This appraiser will not be able to:<ul><li>Login to evaluation system.</li><li>Access any data to evaluation system.</li></ul>",
        callback: function(result){ 
            if(result){
                $('#loadingAppraiser').addClass('overlay');
                $('#loadingAppraiserDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "appraiser/suspend",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {strPrimaryKey : strPrimaryKey},
                    success:function(data){
                        $('#appraiserTable').empty();
                        $('#appraiserTable').append(data);  
                        $('#suspendedAppraiser').text(strFirstname + " " + strLastname);
                        $('#modalSuspendAppraiserSuccess').modal('show');
                    },error:function(data){ 
                        alert("Error!");
                    }
                });
            }
        }
    })
} );


$('#dtblAppraiser tbody').on('click', '.btnRestoreAppraiser', function () {
    var strFirstname = $(this).parent().parent().parent().find('.classFirstname').text();
    var strLastname = $(this).parent().parent().parent().find('.classLastname').text();
    var strPrimaryKey = $(this).parent().parent().parent().find('.classAppraiserPrimaryKey').text(); 
    bootbox.confirm({ 
        size: "small",
        title: "<b>Restore " + strFirstname + " " + strLastname + "</b>",
        message:  "This appraiser will be able to access evaluation system",
        callback: function(result){ 
            if(result){
                $('#loadingAppraiser').addClass('overlay');
                $('#loadingAppraiserDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "appraiser/restore",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {strPrimaryKey : strPrimaryKey},
                    success:function(data){
                        $('#appraiserTable').empty();
                        $('#appraiserTable').append(data);
                        $('#restoredAppraiser').text(strFirstname + " " + strLastname);
                        $('#modalRestoredAppraiserSuccess').modal('show');
                        $(".selFilter").val(0); 
                    },error:function(data){ 
                        alert("Error!");
                    }
                });
            }
        }
    })
} );


$('#appraisal_form').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        /* 
            for appraise property loading state
        */
        var $btnAppraiseProperty = $('#btnAppraiseProperty');
        $btnAppraiseProperty.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var subj_id_appraisal = $("#subj_id_appraisal").val();
        var subj_property_name = $("#subj_property_name").val();
        
        var prpty1_property_name= $("#prpty1_property_name").val();
        var prpty1_region= $("#prpty1_region").val();
        var prpty1_province= $("#prpty1_province").val();
        var prpty1_city= $("#prpty1_city").val();
        var prpty1_barangay= $("#prpty1_barangay").val();
        var prpty1_property_location= $("#prpty1_property_location").val();
        var prpty1_dtInspection= $("#prpty1_dtInspection").val();
        var prpty1_dtAppraisal= $("#prpty1_dtAppraisal").val();
        var prpty1_reg_deeds= $("#prpty1_reg_deeds").val();
        var prpty1_house_model= $("#prpty1_house_model").val();
        var prpty1_num_storey= $("#prpty1_num_storey").val();
        var prpty1_rental_rate= $("#prpty1_rental_rate").val();
        var prpty1_lot_area= $("#prpty1_lot_area").val();
        var prpty1_floor_area= $("#prpty1_floor_area").val();
        var prpty1_effective_age= $("#prpty1_effective_age").val();
        var prpty1_total_ecolife= $("#prpty1_total_ecolife").val();
        var prpty1_remaining_ecolife= $("#prpty1_remaining_ecolife").val();
        var prpty1_remarks= $("#prpty1_remarks").val();
        var prpty1_lot_value= $("#prpty1_lot_value").val();
        var prpty1_completion= $("#prpty1_completion").val();
        var prpty1_house_value= $("#prpty1_house_value").val();
        var prpty1_depreciated_value= $("#prpty1_depreciated_value").val();
        var prpty1_cost_improvement= $("#prpty1_cost_improvement").val();
        var prpty1_total_value= $("#prpty1_total_value").val();

        var prpty2_property_name= $("#prpty2_property_name").val();
        var prpty2_region= $("#prpty2_region").val();
        var prpty2_province= $("#prpty2_province").val();
        var prpty2_city= $("#prpty2_city").val();
        var prpty2_barangay= $("#prpty2_barangay").val();
        var prpty2_property_location= $("#prpty2_property_location").val();
        var prpty2_dtInspection= $("#prpty2_dtInspection").val();
        var prpty2_dtAppraisal= $("#prpty2_dtAppraisal").val();
        var prpty2_reg_deeds= $("#prpty2_reg_deeds").val();
        var prpty2_house_model= $("#prpty2_house_model").val();
        var prpty2_num_storey= $("#prpty2_num_storey").val();
        var prpty2_rental_rate= $("#prpty2_rental_rate").val();
        var prpty2_lot_area= $("#prpty2_lot_area").val();
        var prpty2_floor_area= $("#prpty2_floor_area").val();
        var prpty2_effective_age= $("#prpty2_effective_age").val();
        var prpty2_total_ecolife= $("#prpty2_total_ecolife").val();
        var prpty2_remaining_ecolife= $("#prpty2_remaining_ecolife").val();
        var prpty2_remarks= $("#prpty2_remarks").val();
        var prpty2_lot_value= $("#prpty2_lot_value").val();
        var prpty2_completion= $("#prpty2_completion").val();
        var prpty2_house_value= $("#prpty2_house_value").val();
        var prpty2_depreciated_value= $("#prpty2_depreciated_value").val();
        var prpty2_cost_improvement= $("#prpty2_cost_improvement").val();
        var prpty2_total_value= $("#prpty2_total_value").val();

        var prpty3_property_name= $("#prpty3_property_name").val();
        var prpty3_region= $("#prpty3_region").val();
        var prpty3_province= $("#prpty3_province").val();
        var prpty3_city= $("#prpty3_city").val();
        var prpty3_barangay= $("#prpty3_barangay").val();
        var prpty3_property_location= $("#prpty3_property_location").val();
        var prpty3_dtInspection= $("#prpty3_dtInspection").val();
        var prpty3_dtAppraisal= $("#prpty3_dtAppraisal").val();
        var prpty3_reg_deeds= $("#prpty3_reg_deeds").val();
        var prpty3_house_model= $("#prpty3_house_model").val();
        var prpty3_num_storey= $("#prpty3_num_storey").val();
        var prpty3_rental_rate= $("#prpty3_rental_rate").val();
        var prpty3_lot_area= $("#prpty3_lot_area").val();
        var prpty3_floor_area= $("#prpty3_floor_area").val();
        var prpty3_effective_age= $("#prpty3_effective_age").val();
        var prpty3_total_ecolife= $("#prpty3_total_ecolife").val();
        var prpty3_remaining_ecolife= $("#prpty3_remaining_ecolife").val();
        var prpty3_remarks= $("#prpty3_remarks").val();
        var prpty3_lot_value= $("#prpty3_lot_value").val();
        var prpty3_completion= $("#prpty3_completion").val();
        var prpty3_house_value= $("#prpty3_house_value").val();
        var prpty3_depreciated_value= $("#prpty3_depreciated_value").val();
        var prpty3_cost_improvement= $("#prpty3_cost_improvement").val();
        var prpty3_total_value= $("#prpty3_total_value").val();

        var subj_dtInspection= $("#subj_dtInspection").val();
        var subj_dtAppraisal= $("#subj_dtAppraisal").val();
        var subj_reg_deeds= $("#subj_reg_deeds").val();
        var subj_house_model= $("#subj_house_model").val();
        var subj_num_storey= $("#subj_num_storey").val();
        var subj_rental_rate= $("#subj_rental_rate").val();
        var subj_lot_area= $("#subj_lot_area").val();
        var subj_floor_area= $("#subj_floor_area").val();
        var subj_effective_age= $("#subj_effective_age").val();
        var subj_total_ecolife= $("#subj_total_ecolife").val();
        var subj_remaining_ecolife= $("#subj_remaining_ecolife").val();
        var subj_remarks= $("#subj_remarks").val();
        var subj_completion= $("#subj_completion").val();
        
        
        var appraisal_total_value = (prpty1_total_value + prpty2_total_value + prpty3_total_value) / 3;
        var appraisal_lot_value = (prpty1_lot_value + prpty2_lot_value + prpty3_lot_value) / 3;
        var appraisal_house_value = (prpty1_house_value + prpty2_house_value + prpty3_house_value) / 3;
        var appraisal_cost_of_improvement = (prpty1_cost_improvement + prpty2_cost_improvement + prpty3_cost_improvement) / 3;
        var appraisal_depreciated_value = (prpty1_depreciated_value + prpty2_depreciated_value + prpty3_depreciated_value) / 3;

        $.ajax({
            url: "appraiser/appraised",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {
                prpty1_property_name : prpty1_property_name, prpty1_region : prpty1_region, prpty1_province : prpty1_province, prpty1_city : prpty1_city, prpty1_barangay : prpty1_barangay, prpty1_dtInspection : prpty1_dtInspection, prpty1_dtAppraisal : prpty1_dtAppraisal, prpty1_reg_deeds : prpty1_reg_deeds, prpty1_num_storey : prpty1_num_storey, prpty1_rental_rate : prpty1_rental_rate, prpty1_lot_area : prpty1_lot_area, prpty1_floor_area : prpty1_floor_area, prpty1_effective_age : prpty1_effective_age, prpty1_total_ecolife : prpty1_total_ecolife, prpty1_remaining_ecolife : prpty1_remaining_ecolife, prpty1_remarks : prpty1_remarks, prpty1_lot_value : prpty1_lot_value, prpty1_completion : prpty1_completion, prpty1_house_value : prpty1_house_value, prpty1_depreciated_value : prpty1_depreciated_value, prpty1_cost_improvement : prpty1_cost_improvement, prpty1_total_value : prpty1_total_value, prpty1_property_location : prpty1_property_location, prpty1_house_model :  prpty1_house_model,
                prpty2_property_name : prpty2_property_name, prpty2_region : prpty2_region, prpty2_province : prpty2_province, prpty2_city : prpty2_city, prpty2_barangay : prpty2_barangay, prpty2_dtInspection : prpty2_dtInspection, prpty2_dtAppraisal : prpty2_dtAppraisal, prpty2_reg_deeds : prpty2_reg_deeds, prpty2_num_storey : prpty2_num_storey, prpty2_rental_rate : prpty2_rental_rate, prpty2_lot_area : prpty2_lot_area, prpty2_floor_area : prpty2_floor_area, prpty2_effective_age : prpty2_effective_age, prpty2_total_ecolife : prpty2_total_ecolife, prpty2_remaining_ecolife : prpty2_remaining_ecolife, prpty2_remarks : prpty2_remarks, prpty2_lot_value : prpty2_lot_value, prpty2_completion : prpty2_completion, prpty2_house_value : prpty2_house_value, prpty2_depreciated_value : prpty2_depreciated_value, prpty2_cost_improvement : prpty2_cost_improvement, prpty2_total_value : prpty2_total_value, prpty2_property_location : prpty2_property_location, prpty2_house_model :  prpty2_house_model,
                prpty3_property_name : prpty3_property_name, prpty3_region : prpty3_region, prpty3_province : prpty3_province, prpty3_city : prpty3_city, prpty3_barangay : prpty3_barangay, prpty3_dtInspection : prpty3_dtInspection, prpty3_dtAppraisal : prpty3_dtAppraisal, prpty3_reg_deeds : prpty3_reg_deeds, prpty3_num_storey : prpty3_num_storey, prpty3_rental_rate : prpty3_rental_rate, prpty3_lot_area : prpty3_lot_area, prpty3_floor_area : prpty3_floor_area, prpty3_effective_age : prpty3_effective_age, prpty3_total_ecolife : prpty3_total_ecolife, prpty3_remaining_ecolife : prpty3_remaining_ecolife, prpty3_remarks : prpty3_remarks, prpty3_lot_value : prpty3_lot_value, prpty3_completion : prpty3_completion, prpty3_house_value : prpty3_house_value, prpty3_depreciated_value : prpty3_depreciated_value, prpty3_cost_improvement : prpty3_cost_improvement, prpty3_total_value : prpty3_total_value, prpty3_property_location : prpty3_property_location, prpty3_house_model :  prpty3_house_model,
                subj_id_appraisal : subj_id_appraisal, appraisal_total_value : appraisal_total_value, appraisal_lot_value : appraisal_lot_value, 
                appraisal_house_value : appraisal_house_value, appraisal_cost_of_improvement : appraisal_cost_of_improvement, appraisal_depreciated_value : appraisal_depreciated_value, 
                subj_dtInspection : subj_dtInspection, subj_dtAppraisal : subj_dtAppraisal, subj_reg_deeds : subj_reg_deeds, subj_house_model : subj_house_model,
                subj_num_storey : subj_num_storey, subj_rental_rate : subj_rental_rate, subj_lot_area : subj_lot_area, subj_floor_area : subj_floor_area, subj_effective_age : subj_effective_age,
                subj_total_ecolife : subj_total_ecolife, subj_remaining_ecolife : subj_remaining_ecolife, subj_remarks : subj_remarks, subj_completion : subj_completion
            },
            success:function(data){
                if(data == 'error'){
                    $("#formErrorMessage").show();
                    $btnAppraiseProperty.button('reset');  
                } else{
                    $('#successAppraisePropertyName').text(subj_property_name);
                    $('#successAppraiseValue').text(appraisal_total_value);
                    $('#modalSuccessfulCreation').modal('show');
                    $btnAppraiseProperty.button('reset');
                }
                
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})










