<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/profile_small.jpg"/>
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong
                                        class="font-bold"><?=$_SESSION['name']?></strong>
                             </span> <span class="text-muted text-xs block"><?=$_SESSION['email']?><b
                                        class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.php">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="index.php">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>

            <li>
                <a href="profile.php"><i class="fa fa-users"></i> <span class="nav-label">Profile</span></a>
            </li>
            <li>
                <a href="products.php"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Products</span></a>
            </li>
        </ul>

    </div>
</nav>