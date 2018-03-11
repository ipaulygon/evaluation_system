$(document).ready(function(){
    $(".number").inputmask({ 
        alias: "currency",
        prefix: '',
        allowMinus: false,
        autoGroup: true,
        min: 0
    });
});

$('#dtblProperty').dataTable();
$('document').ready(function(){
    $('.loading').addClass('hide');
    // $('#dtblProperty tbody').on('click', '.clickable-row', function () {
    //     window.location = $(this).data("href");
    // } );

});

$(".addProperty").click(function(){
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputPropertyName").val("");
    $("#inputLotArea").val("");
    // $("#inputEffectiveAge").val("");
    $("#inputPropertyLocation").val("");

});



$('#form').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        $('#loadingProperty').addClass('overlay');
        $('#loadingPropertyDesign').addClass('fa fa-refresh fa-spin')
        /* 
            for create appraiser loading state
        */
        var $btnCreateProperty = $('#btnCreateProperty');
        $btnCreateProperty.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var strPropertyName = $("#inputPropertyName").val();
        var intPropertyType = $("#inputPropertyType").val();
        var strTCTNumber = $("#inputTCTNumber").val();
        var dblLotArea = $("#inputLotArea").val();
        // var intEffectiveAge = $("#inputEffectiveAge").val();
        var intRegion = $("#region").val();
        var intProvince = $("#province").val();
        var intCity = $("#city").val();
        var intBarangay = $("#barangay").val();
        var strPropertyLocation = $("#inputPropertyLocation").val();
        $.ajax({
            url: "my_properties/create",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { strPropertyName : strPropertyName, intPropertyType : intPropertyType, strTCTNumber : strTCTNumber, dblLotArea : dblLotArea, 
               intRegion : intRegion, intProvince : intProvince, intCity : intCity, intBarangay : intBarangay, strPropertyLocation : strPropertyLocation},
            success:function(data){
                if(data == 'error'){
                    $("#formErrorMessage").show();
                    $btnCreateProperty.button('reset');  
                } else{
                    $('#propertyTable').html(data);
                    $('#modalAddProperty').modal('hide');
                    $('#successPropertyName').text(strPropertyName);
                    $('#modalSuccessfulCreation').modal('show');
                    $btnCreateProperty.button('reset');
                }
                
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})

$('#btnCreateAnotherProperty').click(function(){
    $('#modalSuccessfulCreation').modal('hide');
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $('#formErrorMessage').hide();
    $('#inputPropertyName').val("");
    $('#inputPropertyType').val("");
    $('#inputTCTNumber').val("");
    $('#inputLotArea').val("");
    $('#inputPropertyLocation').val("");
    $('#modalAddProperty').modal('show');
});

$('#dtblProperty tbody').on('click', '.btnEditProperty', function () {
    if($('#formUpdate').data('bs.validator').validate().hasErrors()) {
        $('#formUpdate').data('bs.validator').reset();
    }
    var propertyPrimaryKey = $(this).parent().parent().parent().find('.classPropertyPrimaryKey').text(); 
    var propertyLocation = $(this).parent().parent().parent().find('.classPropertyLocation').text();
    var propertySellerID = $(this).parent().parent().parent().find('.classSellerID').text();
        
    $.ajax({
        type: "POST",
        url: "/get_property_details",
        data: {propertyPrimaryKey : propertyPrimaryKey, propertyLocation : propertyLocation, propertySellerID : propertySellerID},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            var property = data.property;
            var propertyLocation = data.propertyLocation;
            var province = data.province;
            var city = data.city;
            var barangay = data.barangay;
            $('#inputUpdatePropertyPrimaryKey').val(property.id_property);
            $('#inputUpdatePropertyName').val(property.property_name);
            $('#inputUpdatePropertyType').val(property.property_type).attr("selected" , "selected");
            $("#inputUpdateTCTNumber").val(property.tct_number);
            $("#inputUpdateLotArea").val(property.lot_area);
            $("#inputUpdateRegion").val(province.id_region).attr("selected" , "selected");
            $("#inputUpdateProvince").val(province.id_province).attr("selected" , "selected");
            $("#inputUpdateCity").val(city.id_city).attr("selected" , "selected");
            $("#inputUpdateBarangay").val(propertyLocation.id_barangay).attr("selected" , "selected");
            $("#inputUpdatePropertyLocation").val(propertyLocation.address);
            $("#inputUpdatePropertyLocationID").val(propertyLocation.id_property_location);
            $("#formErrorMessageRename").hide();
            $('#modalEditProperty').modal('show');
        
        },
        error: function(data){
            alert('error');
        }
    });
    
} );


$('#formUpdate').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        $('#loadingProperty').addClass('overlay');
        $('#loadingPropertyDesign').addClass('fa fa-refresh fa-spin')
        
        var $btnUpdateProperty = $('#btnUpdateProperty');
        $btnUpdateProperty.button('loading');
        var propertyId = $('#inputUpdatePropertyPrimaryKey').val();
        var propertyLocationId = $('#inputUpdatePropertyPrimaryKey').val();


        var strPropertyName = $("#inputUpdatePropertyName").val();
        var intPropertyType = $("#inputUpdatePropertyType").val();
        var strTCTNumber = $("#inputUpdateTCTNumber").val();
        var dblLotArea = $("#inputUpdateLotArea").val();
        var intRegion = $("#inputUpdateRegion").val();
        var intProvince = $("#inputUpdateProvince").val();
        var intCity = $("#inputUpdateCity").val();
        var intBarangay = $("#inputUpdateBarangay").val();
        var strPropertyLocation = $("#inputUpdatePropertyLocation").val();
        $.ajax({
            url: "my_properties/update",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { propertyId : propertyId, propertyLocationId : propertyLocationId, strPropertyName : strPropertyName, intPropertyType : intPropertyType, strTCTNumber : strTCTNumber, dblLotArea : dblLotArea, 
               intRegion : intRegion, intProvince : intProvince, intCity : intCity, intBarangay : intBarangay, strPropertyLocation : strPropertyLocation},
            success:function(data){
                if(data == 'error'){
                    $("#formErrorMessage").show();
                    $btnUpdateProperty.button('reset');  
                } else{
                    $('#propertyTable').html(data);
                    $('#successUpdatePropertyName').text(strPropertyName);
                    $("#inputUpdatePropertyName").val("");
                    $("#inputUpdatePropertyType").val("");
                    $("#inputUpdateTCTNumber").val("");
                    $("#inputUpdateLotArea").val("");
                    $("#inputUpdatePropertyLocation").val("");
                    $('#modalEditProperty').modal('hide'); 
                    $('#modalSuccessfulUpdate').modal('show');
                    $btnUpdateProperty.button('reset');
                }
                
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})


$('#dtblProperty tbody').on('click', '.btnAppraiseProperty', function () {
    if($('#formRequestAppraisal').data('bs.validator').validate().hasErrors()) {
        $('#formRequestAppraisal').data('bs.validator').reset();
    }
    var propertyPrimaryKey = $(this).parent().parent().parent().find('.classPropertyPrimaryKey').text(); 
    var propertyName = $(this).parent().parent().parent().find('.classPropertyName').text();
    var propertyLocation = $(this).parent().parent().parent().find('.classPropertyLocationAddress').text(); 
    $('#modalRequestAppraisal').modal('show');
    $("#inputPropertyNameAppraise").val(propertyName);
    $("#inputPropertyLocationAppraise").val(propertyLocation);
    $("#inputPropertyPrimaryKeyAppraise").val(propertyPrimaryKey);
    $("#formErrorMessageRequestAppraisal").hide();
    

} );

$('#dtblProperty tbody').on('click', '.btnDeleteProperty', function () {
    var propertyPrimaryKey = $(this).parent().parent().parent().find('.classPropertyPrimaryKey').text(); 
    var propertyName = $(this).parent().parent().parent().find('.classPropertyName').text();
    bootbox.confirm({ 
        size: "small",
        title: "<b>Delete " + propertyName + "</b>",
        message:  "This property will be remove to your property list",
        callback: function(result){ 
            if(result){
                $('#loadingProperty').addClass('overlay');
                $('#loadingPropertyDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "/remove_property",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {propertyPrimaryKey : propertyPrimaryKey},
                    success:function(data){
                        $('#propertyTable').html(data);  
                        $('#modalSuccessfulDelete').modal('show');     
                    },error:function(data){ 
                        alert("Error!");
                    }
                });
            }
        }
    })
} );


$('#formRequestAppraisal').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        /* 
            for create appraiser loading state
        */
        var $btnRequestAppraisalSubmit = $('#btnRequestAppraisalSubmit');
        $btnRequestAppraisalSubmit.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var intPropertyId = $("#inputPropertyPrimaryKeyAppraise").val();
        var strPropertyName = $("#inputPropertyNameAppraise").val();
        var intAppraiserId = $("#inputAppraiserId").val();
        var strRemarks = $("#inputRemarksAppraise").val();
        $.ajax({
            url: "my_properties/request_appraisal",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {intPropertyId : intPropertyId, intAppraiserId : intAppraiserId, strRemarks : strRemarks},
            success:function(data){
                if(data == 'error'){
                    $("#formErrorMessageRequestAppraisal").show();
                    $btnRequestAppraisalSubmit.button('reset');  
                } else{
                    $('#propertyTable').html(data);
                    $('#modalRequestAppraisal').modal('hide');  
                    $('#propertyNameAppraise').text(strPropertyName);
                    $('#modalSuccessfulRequestAppraisal').modal('show');
                    $btnRequestAppraisalSubmit.button('reset');
                }
                
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})

$(document).on('click','.btnPublishProperty',function(){
    var id = $(this).parent().parent().parent().find('.classPropertyPrimaryKey').text();
    $.ajax({
        type: "POST",
        url: "/get_appraised_value",
        data: {id: id},
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            $('#appraisedValue').html(data[0]);
            $('#appraisalId').val(data[1]);
            $('#propertyId').val(id);    
        },
        error: function(data){
            alert("error!");
        }
    });
});

$(document).on('click','.btnUpdatePublishProperty',function(){
    var id = $(this).parent().parent().parent().find('.classPropertyPrimaryKey').text();
    $.ajax({
        type: "POST",
        url: "/get_update_value",
        data: {id: id},
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            $('#appraisedValueUpdate').html(data[0]);
            $('#appraisalIdUpdate').val(data[1]);
            $('#propertyIdUpdate').val(id);
            $('#sellPropertyIdUpdate').val(data[2].id_sell_property);
            $('#priceUpdate').val(data[2].price);
            $('#remarksUpdate').val(data[2].remarks);
            $('#modalUpdatePublishProperty').modal('show');  
        },
        error: function(data){
            alert("error!");
        }
    });
});

$('#formPublish').validator().on('submit',function(e){
    e.preventDefault();
    var id = $(this).parent().parent().parent().find('.classPropertyPrimaryKey').text(); 
    var $btnPublish= $('#btnPublish');
    $btnPublish.button('loading');
    $.ajax({
        url: "/publish_property",
        type:"POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: $('#formPublish').serialize(),
        success:function(data){
            $('#propertyTable').html(data);  
            $('#modalPublishProperty').modal('hide');  
            $btnPublish.button('reset');            
            $('#modalSuccessfulPublish').modal('show');                    
        },error:function(data){ 
            alert("Error!");
        }
    });
});

$('#formUpdatePublish').validator().on('submit',function(e){
    e.preventDefault();
    var id = $(this).parent().parent().parent().find('.classPropertyPrimaryKey').text(); 
    var $btnPublish= $('#btnUpdate');
    $btnPublish.button('loading');
    $.ajax({
        url: "/update_property",
        type:"POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: $('#formUpdatePublish').serialize(),
        success:function(data){
            $('#propertyTable').html(data);  
            $('#modalUpdatePublishProperty').modal('hide');  
            $btnPublish.button('reset');            
            $('#modalSuccessfulPublish').modal('show');                    
        },error:function(data){ 
            alert("Error!");
        }
    });
});

$(document).on('click','.btnSoldProperty',function(e){
    e.preventDefault();
    var id = $(this).parent().parent().parent().find('.classPropertyPrimaryKey').text(); 
    bootbox.confirm({ 
        size: "small",
        title: "<b>Mark property as sold?</b>",
        message:  "This property will no longer be viewed",
        callback: function(result){ 
            if(result){
                $('#loadingSeller').addClass('overlay');
                $('#loadingSellerDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "/sold_property",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {id : id},
                    success:function(data){
                        $('#propertyTable').html(data);
                        $('#modalSuccessfulSold').modal('show');
                    },error:function(data){ 
                        alert("Error!");
                    }
                });
            }
        }
    })
});

$(document).on('click','.btnChangePassword',function(){
    $('#modalChangePassword').modal('show');
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
        var $btnResetPasswordSubmit = $('#btnChangePasswordSubmit');
        $btnResetPasswordSubmit.button('loading');
        /*
            Submit data to the controller using ajax
        */
        var strPassword = $("#inputPasswordReset").val();
        $.ajax({
            url: "/change_password",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {strPassword : strPassword},
            success:function(data){
                if(data == 'error'){
                    $btnResetPasswordSubmit.button('reset');  
                } else{
                    $('#modalChangePassword').modal('hide');  
                    $('#modalChangePasswordSuccess').modal('show');
                    $btnResetPasswordSubmit.button('reset');
                }
                
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})

$(document).on('change','#region',function(){
    $.ajax({
        type: "POST",
        url: "/change_region",
        data: {region: $('#region').val()},
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
            $("#province").empty();
            $("#city").empty();
            $("#barangay").empty();
            $.each(provinces,function(key,value){
                $("#province").append($("<option></option>").attr("value",value.id_province).text(value.province_description+" ("+value.province_code+")"));
            });
            $.each(cities,function(key,value){
                $("#city").append($("<option></option>").attr("value",value.id_city).text(value.city_description+" ("+value.city_code+")"));
            });
            $.each(barangays,function(key,value){
                $("#barangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});

$(document).on('change','#province',function(){
    $.ajax({
        type: "POST",
        url: "/change_province",
        data: {province: $('#province').val()},
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
            $("#city").empty();
            $("#barangay").empty();
            $.each(cities,function(key,value){
                $("#city").append($("<option></option>").attr("value",value.id_city).text(value.city_description+" ("+value.city_code+")"));
            });
            $.each(barangays,function(key,value){
                $("#barangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});

$(document).on('change','#city',function(){
    $.ajax({
        type: "POST",
        url: "/change_city",
        data: {city: $('#city').val()},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            var barangays = data.barangays;
            $("#barangay").empty();
            $.each(barangays,function(key,value){
                $("#barangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});


$(document).on('change','#inputUpdateRegion',function(){
    $.ajax({
        type: "POST",
        url: "/change_region",
        data: {region: $('#inputUpdateRegion').val()},
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
            $("#inputUpdateProvince").empty();
            $("#inputUpdateCity").empty();
            $("#inputUpdateBarangay").empty();
            $("#inputUpdatePropertyLocation").val("");
            $.each(provinces,function(key,value){
                $("#inputUpdateProvince").append($("<option></option>").attr("value",value.id_province).text(value.province_description+" ("+value.province_code+")"));
            });
            $.each(cities,function(key,value){
                $("#inputUpdateCity").append($("<option></option>").attr("value",value.id_city).text(value.city_description+" ("+value.city_code+")"));
            });
            $.each(barangays,function(key,value){
                $("#inputUpdateBarangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});

$(document).on('change','#inputUpdateProvince',function(){
    $.ajax({
        type: "POST",
        url: "/change_province",
        data: {province: $('#inputUpdateProvince').val()},
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
            $("#inputUpdateCity").empty();
            $("#inputUpdateBarangay").empty();
            $("#inputUpdatePropertyLocation").val("");
            $.each(cities,function(key,value){
                $("#inputUpdateCity").append($("<option></option>").attr("value",value.id_city).text(value.city_description+" ("+value.city_code+")"));
            });
            $.each(barangays,function(key,value){
                $("#inputUpdateBarangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
});

$(document).on('change','#inputUpdateCity',function(){
    $.ajax({
        type: "POST",
        url: "/change_city",
        data: {city: $('#inputUpdateCity').val()},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            var barangays = data.barangays;
            $("#inputUpdateBarangay").empty();
            $("#inputUpdatePropertyLocation").val("");
            $.each(barangays,function(key,value){
                $("#inputUpdateBarangay").append($("<option></option>").attr("value",value.id_barangay).text(value.barangay_description+" ("+value.barangay_code+")"));
            });
        },
        error: function(data){
            alert('error');
        }
    });
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

$(document).on('click', '.btnViewProperty', function(e){
    e.preventDefault();
    var id = $(this).parent().parent().parent().find('.classPropertyPrimaryKey').text(); 
    $.ajax({
        type: "POST",
        url: "/view_property",
        data: {id: id},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success:function(data){
            $('#viewDetails').html(data);
            $('#modalViewProperty').modal('show');
        },
        error:function(data){
            alert('error!');
        }
    });  
});

$(document).on('click','#removePic',function(e){
    e.preventDefault();
    var confirm = window.confirm("Do you really want to remove this image?");
    var id = $(this).attr('data-id');
    if(confirm){
        $.ajax({
            type: "POST",
            url: "/remove_picture",
            data: {id : id},
            cache: false,
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            success:function(data){
                $('#picture'+id).addClass('hidden');
                alert('Image removed');
            },
            error:function(data){

            }
        })
    }
});

$(document).on('click', '.btnUploadProperty', function(){
    $('#formErrorMessageUpload').hide();
    var id = $(this).parent().parent().parent().find('.classPropertyPrimaryKey').text(); 
    $('#uploadPropertyId').val(id);    
});

$('#formUpload').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
        // handle the invalid form...
    } else {
        var $btnUpload = $('#btnUploadImage');
        $btnUpload.button('loading');
        var formData = new FormData($('#formUpload')[0]);
        $.ajax({
            url: "/add_property_images",
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
                if(data == 'error'){
                    $("#formErrorMessageUpload").show();
                    $btnUpload.button('reset');  
                } else{
                    $btnUpload.button('reset');
                    $('#modalUploadProperty').modal('hide');
                    $('#inputPicture').val('');
                    alert('Success!');
                }
            },error:function(data){ 
                alert("Error!");
            }
        });
    }
    return false;
})







