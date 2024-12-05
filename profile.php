<?php
    require_once "includes/auth/header.php";
    require_once "includes/auth/menu.php";
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
                                        <div class="form-group"><label>Name</label>
                                            <input type="text"
                                                   placeholder="Enter name"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group"><label>Surname</label>
                                            <input type="text"
                                                   placeholder="Enter surname"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group"><label>Email</label>
                                            <input type="email"
                                                   placeholder="Enter email"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group"><label>Email</label>
                                            <input type="email"
                                                   placeholder="Enter email"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group"><label>Password</label>
                                            <input type="password"
                                                   placeholder="Password"
                                                   class="form-control">
                                        </div>
                                        <div>
                                            <button class="btn btn-xl btn-primary pull-left m-t-n-s" type="submit">
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