<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ecommerce | Register</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .error-message{
            float: left;
            color: #d71b1b
        }

    </style>
</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen   animated fadeInDown">
    <div>
        <!-- Logo -->
        <div>
            <img src="img/user-photo.png" alt="user photo" style="width: 100%">
        </div>
        <h3>Register to our ecommerce</h3>
        <p>Create account to see it in action.</p>
        <form class="m-t" role="form" action="index.php">
            <div class="form-group">
                <input type="text" name = "name" id = "name" class="form-control" placeholder="Name" required>
                <span class = "error-message" id ="nameError"></span>
            </div>
            <div class="form-group">
                <input type="email" name = "email" id = "email"  class="form-control" placeholder="Email" required>
                <span class = "error-message" id ="emailError"></span>
            </div>
            <div class="form-group">
                <input type="password" name = "password" id = "password" class="form-control" placeholder="Password" required>
                <span class = "error-message" id ="passwordError"></span>
            </div>
            <div class="form-group">
                <input type="password" name = "confirm-password" id = "confirm-password" class="form-control" placeholder="Confirm Password" required>
                <span class = "error-message" id ="confirmPasswordError"></span>
            </div>
            <div class="form-group">
                <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Agree the terms and policy </label></div>
            </div>
            <button type="button" id = 'register' class="btn btn-primary block full-width m-b" onclick="validate()">Register</button>
            <p class="text-muted text-center"><small>Already have an account?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="index.php">Login</a>
        </form>
        <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
    </div>
</div>

<!-- Mainly scripts -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
    // Display an info toast with no title


    function isEmpty(val) {
        return (val == "" || val === undefined || val == null || val === false || val.length <= 0) ? true : false;
    }

    function validate(){
        // var name = document.getElementById("name").value;
        var name = $("#name").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var confirmPassword = $("#confirm-password").val();

        var nameRegex = /^[a-zA-Z ]{3,20}$/;

        // validimi i emrit
        if (!nameRegex.test(name)){
            $("#name").addClass('error');
            $("#nameError").text("Emri vetem karaktere, minimumi 3");
            toastr.error('Emri vetem karaktere, minimumi 3')
        } else {
            $("#name").removeClass('error');
            $("#nameError").text("")
        }

        // validimi i emailit
        if (isEmpty(email)){
            $("#email").addClass('error');
            $("#emailError").text("Email nuk mund te jete bosh");
            toastr.error('Email nuk mund te jete bosh')
        } else {
            $("#email").removeClass('error');
            $("#emailError").text("")
        }

        // validimi i passowrdit
        if (password != confirmPassword){
            $("#password").addClass('error');
            $("#confirm-password").addClass('error');
            $("#passwordError").text("Passwordet nuk jane te barabarta");
            $("#confirmPasswordError").text("Passwordet nuk jane te barabarta");
            toastr.error('Passwordet nuk jane te barabarta')
        } else {
            $("#password").removeClass('error');
            $("#confirm-password").removeClass('error');
            $("#passwordError").text("");
            $("#confirmPasswordError").text("");
        }

        // Thirrje ne backend dhe dergimi i te dhenave.

        $.ajax({
            type: "POST",
            url: "ajax.php",
            // dataType: 'json',
            async: false,
            cache: false,
            processData: false,
            data: {
                "name": name
            },
            contentType: false,
            success: function (response, status, call) {
                console.log(response)
                // response = JSON.parse(response);
                //
                // if (call.status == 200) {
                //     window.location.href = "profile.php";
                // } else {
                //     $("#" + response.tag).text(response.message);
                //     Swal.fire('Error', response.message, 'error')
                // }
            }
        })

    }


    console.log(name);
</script>
</body>

</html>
