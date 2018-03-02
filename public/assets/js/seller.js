$('#dtblSeller').dataTable();
$('document').ready(function(){
    $('.loading').addClass('hide');
});

$( ".selFilter" ).change(function() {
    var selFilterValue = $( ".selFilter" ).val();
    $('#loadingSeller').addClass('overlay');
    $('#loadingSellerDesign').addClass('fa fa-refresh fa-spin')
    $.ajax({
        url: "seller/filter",
        type:"POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {selFilterValue : selFilterValue},
        success:function(data){
            $('#sellerTable').html(data);
            $('#dtblSeller').dataTable();
        },error:function(data){ 
            alert("Error!");
        }
    });
});

$(document).on('click', '.btnSuspendSeller', function () {
    var strFirstname = $(this).parent().parent().parent().find('.classFirstname').text();
    var strLastname = $(this).parent().parent().parent().find('.classLastname').text();
    var strPrimaryKey = $(this).parent().parent().parent().find('.classSellerPrimaryKey').text(); 
    bootbox.confirm({ 
        size: "small",
        title: "<b>Suspend " + strFirstname + " " + strLastname + "</b>",
        message:  "This seller will not be able to:<ul><li>Login to evaluation system.</li><li>Access any data to evaluation system.</li></ul>",
        callback: function(result){ 
            if(result){
                $('#loadingSeller').addClass('overlay');
                $('#loadingSellerDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "seller/suspend",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {strPrimaryKey : strPrimaryKey},
                    success:function(data){
                        $('#sellerTable').html(data);  
                        $('#dtblSeller').dataTable();
                        $('#suspendedSeller').text(strFirstname + " " + strLastname);
                        $('#modalSuspendSellerSuccess').modal('show');
                    },error:function(data){ 
                        alert("Error!");
                    }
                });
            }
        }
    })
} );


$(document).on('click', '.btnRestoreSeller', function () {
    var strFirstname = $(this).parent().parent().parent().find('.classFirstname').text();
    var strLastname = $(this).parent().parent().parent().find('.classLastname').text();
    var strPrimaryKey = $(this).parent().parent().parent().find('.classSellerPrimaryKey').text(); 
    bootbox.confirm({ 
        size: "small",
        title: "<b>Restore " + strFirstname + " " + strLastname + "</b>",
        message:  "This seller will be able to access evaluation system",
        callback: function(result){ 
            if(result){
                $('#loadingSeller').addClass('overlay');
                $('#loadingSellerDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "seller/restore",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {strPrimaryKey : strPrimaryKey},
                    success:function(data){
                        $('#sellerTable').html(data);
                        $('#dtblSeller').dataTable();                        
                        $('#restoredSeller').text(strFirstname + " " + strLastname);
                        $('#modalRestoredSellerSuccess').modal('show');
                        $(".selFilter").val(0); 
                    },error:function(data){ 
                        alert("Error!");
                    }
                });
            }
        }
    })
} );

$(document).on('click', '.btnAcceptSeller', function () {
    var strFirstname = $(this).parent().parent().parent().find('.classFirstname').text();
    var strLastname = $(this).parent().parent().parent().find('.classLastname').text();
    var strPrimaryKey = $(this).parent().parent().parent().find('.classSellerPrimaryKey').text(); 
    bootbox.confirm({ 
        size: "small",
        title: "<b>Accept " + strFirstname + " " + strLastname + "</b>",
        message:  "This seller will be able to sell the evaluation system",
        callback: function(result){ 
            if(result){
                $('#loadingSeller').addClass('overlay');
                $('#loadingSellerDesign').addClass('fa fa-refresh fa-spin')
                $.ajax({
                    url: "/seller/accept",
                    type:"POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {strPrimaryKey : strPrimaryKey},
                    success:function(data){
                        $('#sellerTable').html(data);
                        $('#dtblSeller').dataTable();                        
                        $('#acceptedSeller').text(strFirstname + " " + strLastname);
                        $('#modalAcceptedSellerSuccess').modal('show');
                        $(".selFilter").val(0); 
                    },error:function(data){ 
                        alert("Error!");
                    }
                });
            }
        }
    })
} );