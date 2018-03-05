$(document).ready(function(){
    $(".number").inputmask({ 
        alias: "currency",
        prefix: '',
        allowMinus: false,
        autoGroup: true,
        min: 0
    });
});


$('#dtblAppraiser').dataTable();
$('document').ready(function(){
    $('.loading').addClass('hide');
    // $('#dtblAppraiser tbody').on('click', '.clickable-row', function () {
    //     window.location = $(this).data("href");
    // } );

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


function getSubjRemainingEcolife(){
    var subj_effective_age= $("#subj_effective_age").val();
    var subj_total_ecolife= $("#subj_total_ecolife").val();
    var subj_remaining_ecolife= $("#subj_remaining_ecolife").val();

    var remaining = parseFloat(((parseFloat(subj_total_ecolife) || 0) - (parseFloat(subj_effective_age) || 0)) || 0);
    $("#subj_remaining_ecolife").val(remaining);
}


$('#appraisal_form').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        /* 
            for appraise property loading state
        */
        var $btnAppraiseProperty = $('#btnAppraiseProperty');
        //$btnAppraiseProperty.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var subj_id_appraisal = $("#subj_id_appraisal").val();
        var subj_property_name = $("#subj_property_name").val();
        var subj_property_type = $("#subj_property_type").val();

        var prpty1_property_name= $("#prpty1_property_name").val();
        var prpty1_region= $("#prpty1_region").val();
        var prpty1_province= $("#prpty1_province").val();
        var prpty1_city= $("#prpty1_city").val();
        var prpty1_barangay= $("#prpty1_barangay").val();
        var prpty1_property_location= $("#prpty1_property_location").val();
        var prpty1_lot_value= $("#prpty1_lot_value").val().replace(/,/g,'');
        
        var prpty2_property_name= $("#prpty2_property_name").val();
        var prpty2_region= $("#prpty2_region").val();
        var prpty2_province= $("#prpty2_province").val();
        var prpty2_city= $("#prpty2_city").val();
        var prpty2_barangay= $("#prpty2_barangay").val();
        var prpty2_property_location= $("#prpty2_property_location").val();
        var prpty2_lot_value= $("#prpty2_lot_value").val().replace(/,/g,'');
        
        var prpty3_property_name= $("#prpty3_property_name").val();
        var prpty3_region= $("#prpty3_region").val();
        var prpty3_province= $("#prpty3_province").val();
        var prpty3_city= $("#prpty3_city").val();
        var prpty3_barangay= $("#prpty3_barangay").val();
        var prpty3_property_location= $("#prpty3_property_location").val();
        var prpty3_lot_value= $("#prpty3_lot_value").val().replace(/,/g,'');
        
        var subj_dtInspection= $("#subj_dtInspection").val();
        var subj_dtAppraisal= $("#subj_dtAppraisal").val();
        var subj_reg_deeds= $("#subj_reg_deeds").val();
        var subj_house_model= $("#subj_house_model").val();
        var subj_num_storey= $("#subj_num_storey").val();
        var subj_lot_area= $("#subj_lot_area").val();
        var subj_effective_age= $("#subj_effective_age").val();
        var subj_total_ecolife= $("#subj_total_ecolife").val();
        var subj_remaining_ecolife= $("#subj_remaining_ecolife").val();
        var subj_remarks= $("#subj_remarks").val();
        var subj_house_value= $("#subj_house_value").val().replace(/,/g,'');
        
        var average_lot_value = parseFloat(((parseInt(prpty1_lot_value) || 0 ) + (parseInt(prpty2_lot_value) || 0) + (parseInt(prpty3_lot_value) || 0)) / 3).toFixed(2);
        // alert("Apppraisal Average Lot Value : " + average_lot_value);


        var appraisal_total_lot_value = parseFloat(average_lot_value * (parseInt(subj_lot_area) || 0)).toFixed(2);
        // alert("Apppraisal Total Lot Value : " + appraisal_total_lot_value);

        var appraisal_total_house_value = parseFloat(((parseInt(subj_house_value) || 0 ) / (parseInt(subj_total_ecolife) || 0)) * (parseInt(subj_remaining_ecolife) || 0) || 0).toFixed(2);
        // alert("Apppraisal Total House Value : " + appraisal_total_house_value);

        var appraisal_total_property_value = parseFloat((parseFloat(appraisal_total_lot_value) || 0 ) + (parseFloat(appraisal_total_house_value) || 0)).toFixed(2);
        // alert("Apppraisal Total Property Value :" + appraisal_total_property_value);

        $.ajax({
            url: "/appraised",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {
                prpty1_property_name : prpty1_property_name, prpty1_region : prpty1_region, prpty1_province : prpty1_province, prpty1_city : prpty1_city, prpty1_barangay : prpty1_barangay, prpty1_lot_value : prpty1_lot_value, prpty1_property_location : prpty1_property_location,
                prpty2_property_name : prpty2_property_name, prpty2_region : prpty2_region, prpty2_province : prpty2_province, prpty2_city : prpty2_city, prpty2_barangay : prpty2_barangay, prpty2_lot_value : prpty2_lot_value, prpty2_property_location : prpty2_property_location,
                prpty3_property_name : prpty3_property_name, prpty3_region : prpty3_region, prpty3_province : prpty3_province, prpty3_city : prpty3_city, prpty3_barangay : prpty3_barangay, prpty3_lot_value : prpty3_lot_value, prpty3_property_location : prpty3_property_location,
                subj_property_name : subj_property_name, subj_dtInspection : subj_dtInspection, subj_dtAppraisal : subj_dtAppraisal, subj_reg_deeds : subj_reg_deeds, subj_num_storey : subj_num_storey, subj_lot_area : subj_lot_area, subj_effective_age : subj_effective_age, 
                subj_total_ecolife : subj_total_ecolife, subj_remaining_ecolife : subj_remaining_ecolife, subj_remarks : subj_remarks, subj_house_value : subj_house_value, subj_house_model :  subj_house_model,
                subj_id_appraisal : subj_id_appraisal, subj_property_type : subj_property_type,
                average_lot_value : average_lot_value, appraisal_total_lot_value : appraisal_total_lot_value, appraisal_total_house_value : appraisal_total_house_value, appraisal_total_property_value : appraisal_total_property_value

        },
            success:function(data){
                if(data == 'error'){
                    $("#formErrorMessage").show();
                    $btnAppraiseProperty.button('reset');  
                } else{
                    $('#container').html(data);
                    $(".number").inputmask({ 
                        alias: "currency",
                        prefix: '',
                        allowMinus: false,
                        autoGroup: true,
                        min: 0
                    });
                    $('.loading').addClass('hide');
                }
                
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
});

$(document).on('change','#prpty1_region',function(){
    $.ajax({
        type: "POST",
        url: "/change_region",
        data: {region: $('#prpty1_region').val()},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            var provinces = data.provinces;
            var cities = data.cities;
            var barangays = data.barangays;
            $("#prpty1_province").empty();
            $("#prpty1_city").empty();
            $("#prpty1_barangay").empty();
            $.each(provinces,function(key,value){
                $("#prpty1_province").append($("<option></option>").attr("value",value.id_province).text(value.province_description+" ("+value.province_code+")"));
            });
            $.each(cities,function(key,value){
                $("#prpty1_city").append($("<option></option>").attr("value",value.id_city).text(value.city_description+" ("+value.city_code+")"));
            });
            $.each(barangays,function(key,value){
                $("#prpty1_barangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});

$(document).on('change','#prpty1_province',function(){
    $.ajax({
        type: "POST",
        url: "/change_province",
        data: {province: $('#prpty1_province').val()},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            var cities = data.cities;
            var barangays = data.barangays;
            $("#prpty1_city").empty();
            $("#prpty1_barangay").empty();
            $.each(cities,function(key,value){
                $("#prpty1_city").append($("<option></option>").attr("value",value.id_city).text(value.city_description+" ("+value.city_code+")"));
            });
            $.each(barangays,function(key,value){
                $("#prpty1_barangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});

$(document).on('change','#prpty1_city',function(){
    $.ajax({
        type: "POST",
        url: "/change_city",
        data: {city: $('#prpty1_city').val()},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            var barangays = data.barangays;
            $("#prpty1_barangay").empty();
            $.each(barangays,function(key,value){
                $("#prpty1_barangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});

$(document).on('change','#prpty2_region',function(){
    $.ajax({
        type: "POST",
        url: "/change_region",
        data: {region: $('#prpty2_region').val()},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            var provinces = data.provinces;
            var cities = data.cities;
            var barangays = data.barangays;
            $("#prpty2_province").empty();
            $("#prpty2_city").empty();
            $("#prpty2_barangay").empty();
            $.each(provinces,function(key,value){
                $("#prpty2_province").append($("<option></option>").attr("value",value.id_province).text(value.province_description+" ("+value.province_code+")"));
            });
            $.each(cities,function(key,value){
                $("#prpty2_city").append($("<option></option>").attr("value",value.id_city).text(value.city_description+" ("+value.city_code+")"));
            });
            $.each(barangays,function(key,value){
                $("#prpty2_barangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});

$(document).on('change','#prpty2_province',function(){
    $.ajax({
        type: "POST",
        url: "/change_province",
        data: {province: $('#prpty2_province').val()},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            var cities = data.cities;
            var barangays = data.barangays;
            $("#prpty2_city").empty();
            $("#prpty2_barangay").empty();
            $.each(cities,function(key,value){
                $("#prpty2_city").append($("<option></option>").attr("value",value.id_city).text(value.city_description+" ("+value.city_code+")"));
            });
            $.each(barangays,function(key,value){
                $("#prpty2_barangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});

$(document).on('change','#prpty2_city',function(){
    $.ajax({
        type: "POST",
        url: "/change_city",
        data: {city: $('#prpty2_city').val()},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            var barangays = data.barangays;
            $("#prpty2_barangay").empty();
            $.each(barangays,function(key,value){
                $("#prpty2_barangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});

$(document).on('change','#prpty3_region',function(){
    $.ajax({
        type: "POST",
        url: "/change_region",
        data: {region: $('#prpty3_region').val()},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            var provinces = data.provinces;
            var cities = data.cities;
            var barangays = data.barangays;
            $("#prpty3_province").empty();
            $("#prpty3_city").empty();
            $("#prpty3_barangay").empty();
            $.each(provinces,function(key,value){
                $("#prpty3_province").append($("<option></option>").attr("value",value.id_province).text(value.province_description+" ("+value.province_code+")"));
            });
            $.each(cities,function(key,value){
                $("#prpty3_city").append($("<option></option>").attr("value",value.id_city).text(value.city_description+" ("+value.city_code+")"));
            });
            $.each(barangays,function(key,value){
                $("#prpty3_barangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});

$(document).on('change','#prpty3_province',function(){
    $.ajax({
        type: "POST",
        url: "/change_province",
        data: {province: $('#prpty3_province').val()},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            var cities = data.cities;
            var barangays = data.barangays;
            $("#prpty3_city").empty();
            $("#prpty3_barangay").empty();
            $.each(cities,function(key,value){
                $("#prpty3_city").append($("<option></option>").attr("value",value.id_city).text(value.city_description+" ("+value.city_code+")"));
            });
            $.each(barangays,function(key,value){
                $("#prpty3_barangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});

$(document).on('change','#prpty3_city',function(){
    $.ajax({
        type: "POST",
        url: "/change_city",
        data: {city: $('#prpty3_city').val()},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            var barangays = data.barangays;
            $("#prpty3_barangay").empty();
            $.each(barangays,function(key,value){
                $("#prpty3_barangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});
