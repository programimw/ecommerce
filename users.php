<?php
error_reporting(0);
session_start();
require_once "connect.php";
require_once "functions.php";

require_once "includes/auth/header.php";
require_once "includes/auth/menu.php";

//Get all users
$query_users = "select users.id,
                       users.name,
                       surname,
                       email,
                       roles.name as roleName
                from users
                         left join roles on users.role_id = roles.id;";

$result_users = mysqli_query($conn, $query_users);

if (!$result_users) {
    echo "Error " . mysqli_error($conn);
    exit;
}

$users = array();
while ($row = mysqli_fetch_assoc($result_users)) {
    $users[$row['id']]['id'] = $row['id'];
    $users[$row['id']]['name'] = $row['name'];
    $users[$row['id']]['surname'] = $row['surname'];
    $users[$row['id']]['email'] = $row['email'];
    $users[$row['id']]['roleName'] = $row['roleName'];
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
        <div class="col-sm-4">
            <h2>Lista e Perdoruesve</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li class="active">
                    <strong>Lista e Perdoruesve</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="modal inmodal" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="toogleModal();"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-user modal-icon"></i>
                    <h4 class="modal-title">Perditesimi i userit</h4>
                </div>
                <div class="modal-body">
                    <p><strong>Te dhenat e userit </strong></p>
                    <form class="m-t" role="form" action="index.php">
                        <input type="hidden" name="edit_user_id" id="edit_user_id" value="0">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                            <span class="error-message" id="nameError"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" name="surname" id="surname" class="form-control" placeholder="Name"
                                   required>
                            <span class="error-message" id="surnameError"></span>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email"
                                   required>
                            <span class="error-message" id="emailError"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal" onclick="toogleModal()">Close
                    </button>
                    <button type="button" class="btn btn-primary" onclick="edit_user();">Modifiko</button>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>
                                    <th>Veprime</th>
                                    <th>Emri</th>
                                    <th>Mbiemri</th>
                                    <th>E-Mail</th>
                                    <th>Roli</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($users as $user_id => $user_data) {
                                    ?>
                                    <tr id="row_<?= $user_id ?>">
                                        <td class="text-center">
                                            <button class="btn btn-danger delete"
                                                    onclick="delete_user('<?= $user_id ?>')"><i class="fa fa-trash"></i>
                                            </button>
                                            &nbsp;&nbsp;&nbsp;
                                            <button class="btn btn-primary"
                                                    onclick="open_user_modal('<?= $user_id ?>')">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                        </td>
                                        <td><span id = "name_<?=$user_id?>"><?= $user_data['name'] ?></span></td>
                                        <td><span id = "surname_<?=$user_id?>"><?= $user_data['surname'] ?></span></td>
                                        <td><span id = "email_<?=$user_id?>"><?= $user_data['email'] ?></span></td>
                                        <td><?= $user_data['roleName'] ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
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
    $(document).ready(function () {
        $('.dataTables-example').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                {extend: 'copy'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},
            ]
        });

    });

    function open_user_modal(id) {
        var data = new FormData();
        data.append("action", "get_user_data");
        data.append("id", id);
        // Thirrje ne backend dhe dergimi i te dhenave.
        $.ajax({
            type: "POST",
            url: "users_api.php",
            async: false,
            cache: false,
            processData: false,
            data: data,
            contentType: false,
            // dataType: 'json',
            success: function (response, status, call) {
                response = JSON.parse(response);

                if (call.status == 200) {

                    $("#name").val(response.data.name);
                    $("#surname").val(response.data.surname);
                    $("#email").val(response.data.email);
                    $("#edit_user_id").val(response.data.id);

                    $("#editModal").toggle();
                    // $("#row_"+id).addClass("animated  fadeOutLeftBig");
                    // setTimeout(function (){
                    //     $("#row_"+id).remove();
                    // }, 1000);
                    // swal("Fshirja u realizua!", response.message, "success");
                } else {
                    // swal("Fshirja nuk u realizua!", response.message, "warning");
                }
            }
        })
    }


    function delete_user(id) {
        swal({
                title: "Jeni i sigurte?",
                text: "Ju po fshini nje user nga sistemi. Te dhenat nuk mund te rekuperohen!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Po, Fshije!",
                cancelButtonText: "Jo, Anullo veprimin!",
                closeOnConfirm: true,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    // Data that will be sent in backend
                    var data = new FormData();
                    data.append("action", "delete_user");
                    data.append("id", id);
                    // Thirrje ne backend dhe dergimi i te dhenave.
                    $.ajax({
                        type: "POST",
                        url: "users_api.php",
                        async: false,
                        cache: false,
                        processData: false,
                        data: data,
                        contentType: false,
                        // dataType: 'json',
                        success: function (response, status, call) {
                            response = JSON.parse(response);
                            if (call.status == 200) {
                                $("#row_" + id).addClass("animated  fadeOutLeftBig");
                                setTimeout(function () {
                                    $("#row_" + id).remove();
                                }, 1000);
                                // swal("Fshirja u realizua!", response.message, "success");
                            } else {
                                swal("Fshirja nuk u realizua!", response.message, "warning");
                            }
                        }
                    })
                } else {
                    swal("Veprimi u anullua", "Veprimi juaj u anullua!", "error");
                }
            });
    }

    function toogleModal() {
        $("#editModal").toggle();
    }


    function edit_user() {
        // var name = document.getElementById("name").value;
        var name = $("#name").val();
        var surname = $("#surname").val();
        var email = $("#email").val();
        var id = $("#edit_user_id").val();
        var error = 0;

        // todo validate users data
        // var nameRegex = /^[a-zA-Z ]{3,20}$/;
        // var passwordRegex = /^[a-zA-Z0-9-_ ]{4,}$/;
        //
        // // validimi i emrit
        // if (!nameRegex.test(name)) {
        //     $("#name").addClass('error');
        //     $("#nameError").text("Emri vetem karaktere, minimumi 3");
        //     error++;
        // } else {
        //     $("#name").removeClass('error');
        //     $("#nameError").text("")
        // }
        //
        // // validimi i emailit
        // if (isEmpty(email)) {
        //     $("#email").addClass('error');
        //     $("#emailError").text("Email nuk mund te jete bosh");
        //     error++;
        // } else {
        //     $("#email").removeClass('error');
        //     $("#emailError").text("")
        // }
        //
        // // validimi i passowrdit
        // if (!passwordRegex.test(password)) {
        //     $("#password").addClass('error');
        //     $("#passwordError").text("Password ka minimumi 4 karaktere");
        //     error++;
        // } else if (password != confirmPassword) {
        //     $("#password").addClass('error');
        //     $("#confirm-password").addClass('error');
        //     $("#passwordError").text("Passwordet nuk jane te barabarta");
        //     $("#confirmPasswordError").text("Passwordet nuk jane te barabarta");
        //     error++;
        // } else {
        //     $("#password").removeClass('error');
        //     $("#confirm-password").removeClass('error');
        //     $("#passwordError").text("");
        //     $("#confirmPasswordError").text("");
        // }

        // Data that will be sent in backend
        var data = new FormData();
        data.append("action", "edit_user");
        data.append("name", name);
        data.append("surname", surname);
        data.append("email", email);
        data.append("id", id);

        // Thirrje ne backend dhe dergimi i te dhenave.
        if (error == 0) {
            $.ajax({
                type: "POST",
                url: "users_api.php",
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
                        swal("Useri u perditesua!", response.message, "success");
                        setTimeout(function () {
                            $('#editModal').modal('toggle');
                        }, 1000);

                        $("#name_"+id).text(response.name);
                        $("#surname_"+id).text(response.surname);
                        $("#email_"+id).text(response.email);

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
