<?php
require_once "includes/header.php";
?>

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <!-- Logo -->
        <div>
            <img src="img/user-photo.png" alt="user photo" style="width: 100%">
        </div>
        <h3>Register to our ecommerce</h3>
        <p>Create account to see it in action.</p>
        <form class="m-t" role="form" action="index.php">
            <div class="form-group">
                <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                <span class="error-message" id="nameError"></span>
            </div>
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                <span class="error-message" id="emailError"></span>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                       required>
                <span class="error-message" id="passwordError"></span>
            </div>
            <div class="form-group">
                <input type="password" name="confirm-password" id="confirm-password" class="form-control"
                       placeholder="Confirm Password" required>
                <span class="error-message" id="confirmPasswordError"></span>
            </div>
            <div class="form-group">
                <div class="checkbox i-checks">
                    <label style="padding-left: 0px
">
                        <input type="checkbox">
                        <i></i>
                        Pranoj termat dhe kushtet e perdorimit
                    </label>
                </div>
            </div>
            <button type="button" id='register' class="btn btn-primary block full-width m-b" onclick="register_user();">
                Register
            </button>
            <p class="text-muted text-center"><small>Already have an account?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="index.php">Login</a>
        </form>
        <p class="m-t"><small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small></p>
    </div>
</div>


<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-envelope modal-icon"></i>
                <h4 class="modal-title">Verfikimi i E-Mailit</h4>
            </div>
            <div class="modal-body">
                <p><strong>Ne emailin tuaj kemi derguar nje kod.</strong> Vendosni kodin per te verikuar emailin.</p>
                <div class="form-group"><label>Kodi Juaj</label>
                    <input type="number" placeholder="Vendosni kodin" class="form-control"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="verify_email();">Verifiko</button>
            </div>
        </div>
    </div>
</div>

<?php
    require_once "includes/footer.php";
?>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    function register_user() {
        // var name = document.getElementById("name").value;
        var name = $("#name").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var confirmPassword = $("#confirm-password").val();

        var nameRegex = /^[a-zA-Z ]{3,20}$/;
        var passwordRegex = /^[a-zA-Z0-9-_ ]{4,}$/;

        var error = 0;
        // validimi i emrit
        if (!nameRegex.test(name)) {
            $("#name").addClass('error');
            $("#nameError").text("Emri vetem karaktere, minimumi 3");
            error++;
        } else {
            $("#name").removeClass('error');
            $("#nameError").text("")
        }

        // validimi i emailit
        if (isEmpty(email)) {
            $("#email").addClass('error');
            $("#emailError").text("Email nuk mund te jete bosh");
            error++;
        } else {
            $("#email").removeClass('error');
            $("#emailError").text("")
        }

        // validimi i passowrdit
        if (!passwordRegex.test(password)) {
            $("#password").addClass('error');
            $("#passwordError").text("Password ka minimumi 4 karaktere");
            error++;
        } else if (password != confirmPassword) {
            $("#password").addClass('error');
            $("#confirm-password").addClass('error');
            $("#passwordError").text("Passwordet nuk jane te barabarta");
            $("#confirmPasswordError").text("Passwordet nuk jane te barabarta");
            error++;
        } else {
            $("#password").removeClass('error');
            $("#confirm-password").removeClass('error');
            $("#passwordError").text("");
            $("#confirmPasswordError").text("");
        }

        // Data that will be sent in backend
        var data = new FormData();
        data.append("action", "register");
        data.append("name", name);
        data.append("email", email);
        data.append("password", password);
        data.append("confirmPassword", confirmPassword);

        // Thirrje ne backend dhe dergimi i te dhenave.
        if (error == 0) {
            $.ajax({
                type: "POST",
                url: "ajax.php",
                async: false,
                cache: false,
                processData: false,
                data: data,
                contentType: false,
                // dataType: 'json',
                success: function (response, status, call) {
                    response = JSON.parse(response);
                    console.log(response);

                    if (call.status == 200) {
                        // TODO SET TE CODE SENT IN EMAIL. iF THE CODE IS OK, GO TO THE NEXT STEP
                        // $('#myModal').modal('toggle');

                        toastr.success(response.message)
                        setTimeout(function (){
                            window.location.href = response.location;
                        }, 2500);

                    } else {
                        $("#" + response.tagError).text(response.message);
                        $("#" + response.tagElement).addClass('error');
                        // Swal.fire('Error', response.message, 'error')
                    }
                }
            })
        }
    }
</script>
