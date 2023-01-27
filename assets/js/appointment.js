$(document).ready(function () {

    $('#appointmentDescription').on('input', function () {
        checkDescription();
    });

    $('#editAppointmentDescription').on('input', function () {
        checkEditDescription();
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

    var appointment_id = null;

    $('.editAppointmentButton').click(function () {

        //Keeping only the numeric part of ID
        appointment_id = this.id.replace(/\D/g, '');

    });

    $('#editAppointmentSubmit').click(function () {

        if(!checkEditDescription()){
            $("#editMessage").html(`<div class="alert alert-warning">Please fill all the required fields</div>`);
            $("#editAppointmentDescription").attr("class", "form-control is-invalid");
        } else {
            console.log(appointment_id);

        document.getElementById('editAppointmentId').setAttribute('value', appointment_id);

        console.log("ok");
        $("#message").html("");
        var form = $('#editAppointmentForm')[0];
        console.log(form);
        var data = new FormData(form);
        $.ajax({
            url: "editAppointment.php",
            type: "POST",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            async: true,
            beforeSend: function () {
                $('#editAppointmentSubmit').html('<i class="fa-solid fa-spinner fa-spin"></i>');
                $('#editAppointmentSubmit').attr("disabled", true);
                $('#editAppointmentSubmit').css({ "border-radius": "50%" });
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
                    $('#editAppointmentForm').trigger("reset");
                    $('#editAppointmentSubmit').attr("disabled", false);
                    $('#editAppointmentSubmit').css({ "border-radius": "4px" });
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

function checkEditDescription(){

    var editDescription = $('#editAppointmentDescription').val();

    if(editDescription == ''){
        return false;
    } else {
        return true;
    }

}