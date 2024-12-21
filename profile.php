<?php
error_reporting(0);
session_start();
require_once "connect.php";
require_once "functions.php";

require_once "includes/auth/header.php";
require_once "includes/auth/menu.php";

$query_user_data = "SELECT id,
                           name,
                           surname,
                           email
                    FROM users
                    WHERE id = '".mysqli_real_escape_string($conn, $_SESSION['id'])."'";


$result_user_data = mysqli_query($conn, $query_user_data);
if (!$result_user_data){
    //TODO: Show an error, do not break the page
    echo "Error";
    exit;
}

$data = array();
while ($row = mysqli_fetch_assoc($result_user_data)){
    $data['id'] = $row['id'];
    $data['name'] = $row['name'];
    $data['surname'] = $row['surname'];
    $data['email'] = $row['email'];
}
?>
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                    </a>
                </div>
            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Profile</h2>
                <ol class="breadcrumb">
                    <li class="active">
                        <strong>Profile</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="wrapper wrapper-content">
            <div class="row animated fadeInRight">
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Your photo</h5>
                        </div>
                        <div>
                            <div class="ibox-content no-padding border-left-right">
                                <img alt="image" class="img-responsive" src="img/profile_big.jpg">
                                <input type="file">
                            </div>
                            <div class="ibox-content profile-content">
                                <h4><strong>Emri Mbiemri</strong></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Profile Data</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">Update your profile data here</h3>
                                    <form role="form">
                                        <input type="hidden" id = "id" name="id" value="<?=$data['id']?>">
                                        <div class="form-group"><label>Name</label>
                                            <input type="text"
                                                   id = "name"
                                                   name = "name"
                                                   placeholder="Enter name"
                                                   class="form-control"
                                            value="<?=$data['name'] ?>">
                                            <span class="error-message" id="nameError"></span>
                                        </div>
                                        <div class="form-group"><label>Surname</label>
                                            <input type="text"
                                                   id = "surname"
                                                   name = "surname"
                                                   placeholder="Enter surname"
                                                   class="form-control"
                                                   value="<?=$data['surname'] ?>" >
                                            <span class="error-message" id="surnameError"></span>
                                        </div>
                                        <div class="form-group"><label>Email</label>
                                            <input type="email"
                                                   id = "email"
                                                   name = "email"
                                                   placeholder="Enter email"
                                                   class="form-control"
                                                   value="<?=$data['email'] ?>">
                                            <span class="error-message" id="emailError"></span>
                                        </div>
<!--                                        <div class="form-group"><label>Password</label>-->
<!--                                            <input type="password"-->
<!--                                                   placeholder="Password"-->
<!--                                                   class="form-control">-->
<!--                                        </div>-->
                                        <div>
                                            <button class="btn btn-xl btn-primary pull-left m-t-n-s" type="button" onclick="updateUser();">
                                                <strong>Save</strong></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


<?php
require_once "includes/auth/footer.php";
?>

<script>

    function updateUser() {
        // var name = document.getElementById("name").value;
        var name = $("#name").val();
        var surname = $("#surname").val();
        var email = $("#email").val();
        var id = $("#id").val();

        var textRegex = /^[a-zA-Z ]{3,20}$/;

        var error = 0;
        // validimi i emrit
        if (!textRegex.test(name)) {
            $("#name").addClass('error');
            $("#nameError").text("Emri vetem karaktere, minimumi 3");
            error++;
        } else {
            $("#name").removeClass('error');
            $("#nameError").text("")
        }

        // validimi i mbiemrit
        if (!textRegex.test(surname)) {
            $("#surname").addClass('error');
            $("#surnameError").text("Mbiemri vetem karaktere, minimumi 3");
            error++;
        } else {
            $("#surname").removeClass('error');
            $("#surnameError").text("")
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

        // Data that will be sent in backend
        var data = new FormData();
        data.append("action", "updateUser");
        data.append("name", name);
        data.append("surname", surname);
        data.append("email", email);
        data.append("id", id);

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
                        toastr.success(response.message)
                        // setTimeout(function (){
                        //     window.location.href = response.location;
                        // }, 2500);

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

