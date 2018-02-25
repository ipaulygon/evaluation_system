$(document).on('click','#contact',function(){
    var id = $('#property').val();
    $.ajax({
        type: "POST",
        url: "/property_count",
        data: {id: id},
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){

        },
        error: function(data){
            alert('error');
        }
    });
});