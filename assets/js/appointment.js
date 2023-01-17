$(document).ready(function () {

    $('#appointmentDescription').on('input', function () {
        checkDescription();
    });

    var doctor_id = null;

    $('.makeAppointmentButton').click(function () {

        //Keeping only the numeric part of ID
        doctor_id = this.id.replace(/\D/g, '');

    });

    $('#makeAppointmentSubmit').click(function () {

        if(!checkDescription()){
            $("#message").html(`<div class="alert alert-warning">Please fill all the required fields</div>`);
            $("#appointmentDescription").attr("class", "form-control is-invalid");
        } else {
            console.log(doctor_id);

        document.getElementById('appointmentDoctorId').setAttribute('value', doctor_id);

        console.log("ok");
        $("#message").html("");
        var form = $('#makeAppointmentForm')[0];
        console.log(form);
        var data = new FormData(form);
        $.ajax({
            url: "appointment.php",
            type: "POST",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            async: true,
            beforeSend: function () {
                $('#makeAppointmentSubmit').html('<i class="fa-solid fa-spinner fa-spin"></i>');
                $('#makeAppointmentSubmit').attr("disabled", true);
                $('#makeAppointmentSubmit').css({ "border-radius": "50%" });
            },
            success: function (data) {
                console.log(data);
                var json = $.parseJSON(data);
                $('#message').html(json.message);
                if(json.success){
                    // Redirect to index page
                    window.location.href = "./user.php"; 
                }
            },
            complete: function () {
                setTimeout(function () {
                    $('#makeAppointmentForm').trigger("reset");
                    $('#makeAppointmentSubmit').attr("disabled", false);
                    $('#makeAppointmentSubmit').css({ "border-radius": "4px" });
                }, 5000);
            }
        });
        }
    });
});

function checkDescription() {
    var description = $('#appointmentDescription').val();

    if(description == ''){
        return false;
    } else {
        return true;
    }
}