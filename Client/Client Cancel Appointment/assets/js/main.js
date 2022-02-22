$(document).ready(function () {
    errorReasonInput = true;
    $("#openCancelMSG").attr("disabled", true);
    $("#openCancelMSG").removeClass('bttn');
    $("#openCancelMSG").addClass('disable');

    $('#openCancelMSG').on('click', function(){
        $('#modal_cancelMSG').css('display', 'flex');
    });

    $('#close_modal').on('click', function(){
        $('#modal_cancelMSG').css('display', 'none');
        
    });

    $('#close_modal2').on('click', function(){
        $('#modal_cancelMSG').css('display', 'none');
        
    });

    
    $('#reason').keyup(function(){
        if($('#reason').val().length > 0){
            errorReasonInput = false;
            $("#i_reason").removeClass('fa-circle-exclamation');
        } else {
            errorReasonInput = true;
            $("#i_reason").addClass('fa-circle-exclamation');
        }
        $("#openCancelMSG").attr("disabled", false);
        $("#openCancelMSG").removeClass('disable');
        $("#openCancelMSG").addClass('bttn');
    })

    $("#cancelAppoint").submit(function (e) { 
        e.preventDefault();

        if(errorReasonInput == true){
            $("#i_reason").removeClass('fa-circle-exclamation');
        }

        if(errorReasonInput == false  ){
            $.ajax({
                url: "assets/cancel_sched_work.php",
                 type: 'POST',
                data: $('#cancelAppoint').serialize(),
                datatype: "text",
                cache:false,
                success:function(result){
                    if($.trim(result) == "success"){
                        $("#cancelAppoint")[0].reset();
                        errorReasonInput = true;
                        window.location.href = '../Client Manage Appointment/';
                    }
                        
                }
            });
        }
        
    });


});