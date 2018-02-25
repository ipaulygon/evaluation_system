$('#dtblProperty').dataTable();
$('document').ready(function(){
    $('.loading').addClass('hide');
    $('#dtblProperty tbody').on('click', '.clickable-row', function () {
        window.location = $(this).data("href");
    } );

});

$(".addProperty").click(function(){
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputPropertyName").val("");
    $("#inputLotArea").val("");
    $("#inputEffectiveAge").val("");
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
        var intEffectiveAge = $("#inputEffectiveAge").val();
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
            data: { strPropertyName : strPropertyName, intPropertyType : intPropertyType, strTCTNumber : strTCTNumber, dblLotArea : dblLotArea, intEffectiveAge : intEffectiveAge, 
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

$("#btnCreateAnotherProperty").click(function(){
    $('#modalSuccessfulCreation').modal('hide');
    var passwordGenerated = randomString(7);
    if($('#form').data('bs.validator').validate().hasErrors()) {
        $('#form').data('bs.validator').reset();
    }
    $("#formErrorMessage").hide();
    $("#inputPropertyName").val("");
    $("#inputLotArea").val("");
    $("#inputEffectiveAge").val("");
    $("#inputPropertyLocation").val("");
    $('#modalAddProperty').modal('show');
});

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
    $('#publishId').val(id);    
});

$(document).on('click','#btnPublish',function(){
    var id = $(this).parent().parent().parent().find('.classPropertyPrimaryKey').text(); 
    $.ajax({
        url: "/publish_property",
        type:"POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: $('#formPublish').serialize() ,
        success:function(data){
            $('#propertyTable').html(data);
        },error:function(data){ 
            alert("Error!");
        }
    });
});

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









