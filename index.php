<?php
require_once "includes/header.php";
?>

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>
            <img src="img/user-photo.png" alt="user photo" style="width: 100%">
        </div>
        <h3>Welcome to our ecommerce</h3>
        <p>Login in. To see it in action.</p>
        <form class="m-t" role="form" action="#">
            <div class="form-group">
                <input type="text" name = "email_nr"  id = "email_nr" class="form-control" placeholder="E-Mail ose numri" required="">
                <span class="error-message" id="emailNrError"></span>
            </div>
            <div class="form-group">
                <input type="password" name = "password"  id = "password" class="form-control" placeholder="Password" required="">
                <span class="error-message" id="passwordError"></span>
            </div>
            <button type="button" class="btn btn-primary block full-width m-b" onclick="login();">Login</button>

            <a href="#"><small>Forgot password?</small></a>
            <p class="text-muted text-center"><small>Do not have an account?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="register.php">Create an account</a>
        </form>
    </div>
</div>

<?php
    require_once "includes/footer.php";
?>



<script>
    function login() {
        // var name = document.getElementById("name").value;
        var email_number = $("#email_nr").val();
        var password = $("#password").val();

        var passwordRegex = /^[a-zA-Z0-9-_ ]{4,}$/;

        var error = 0;

        // validimi i emailit
        if (isEmpty(email_number)) {
            $("#email_nr").addClass('error');
            $("#emailNrError").text("Email nuk mund te jete bosh");
            error++;
        } else {
            $("#email_nr").removeClass('error');
            $("#emailNrError").text("")
        }

        // validimi i pass
        if (!passwordRegex.test(password)) {
            $("#password").addClass('error');
            $("#passwordError").text("Password ka minimumi 4 karaktere");
            error++;
        } else {
            $("#password").removeClass('error');
            $("#passwordError").text("");
        }

        // Data that will be sent in backend
        var data = new FormData();
        data.append("action", "login");
        data.append("email_number", email_number);
        data.append("password", password);

        // Thirrje ne backend dhe dergimi i te dhenave.
        if (error == 0) {
            $.ajax({
                type: "POST",
                url: "ajax.php",
                // dataType: 'json',
                async: false,
                cache: false,
                processData: false,
                data: data,
                contentType: false,
                success: function (response, status, call) {
                    response = JSON.parse(response);

                    if (call.status == 200) {
                        window.location.href = response.location;
                    } else {
                        $("#" + response.tagError).text(response.message);
                        $("#" + response.tagElement).addClass('error');
                        // Swal.fire('Error', response.message, 'error')
                    }
                },
            })
        }
    }
</script>

