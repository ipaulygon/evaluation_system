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

$('#formSearch').on('submit',function(e){
    e.preventDefault();
    $('#loading').removeClass('hidden');
    $.ajax({
        url: "/get_search",
        type:"POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: $('#formSearch').serialize(),
        success:function(data){
            console.log(data);
            $('#searchResults').html(data);  
            $('#loading').addClass('hidden');                              
        },error:function(data){ 
            alert("Error!");
        }
    });
});