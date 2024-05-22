<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                        class="ti-menu ti-close"></i></a>
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <!-- <a class="navbar-brand" href="index.html">
                    Logo icon
                    <b class="logo-icon">
                        You can put here icon as well // <i class="wi wi-sunset"></i> //
                        Dark Logo icon
                        <img src="public/assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                        Light Logo icon
                        <img src="public/assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                    </b>
                    End Logo icon
                    Logo text
                    <span class="logo-text">
                        dark Logo text
                        <img src="public/assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                        Light Logo text
                        <img src="public/assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
                    </span>
                </a> -->
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <!-- ============================================================== -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                    data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav mr-auto float-left">
                    <!-- This is  -->
                    <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-md-block waves-effect waves-dark"
                            href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                </ul>
                <!-- ============================================================== -->
                <!-- Right side toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-right">
                    <!-- Profile -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="<?= ASSET_URL ?>public/assets/images/users/1.png" alt="user" width="30"
                                class="profile-pic rounded-circle" />
                        </a>
                        <div class="dropdown-menu mailbox dropdown-menu-right scale-up">
                            <ul class="dropdown-user list-style-none">
                                <li>
                                    <div class="dw-user-box p-3 d-flex">
                                        <div class="u-img"><img src="<?= ASSET_URL ?>public/assets/images/users/1.png"
                                                alt="user" class="rounded" width="80"></div>
                                        <div class="u-text ml-2">
                                            <h4 class="mb-0">
                                                <?php if (session()->loggedin == 'adminloggedin'): ?>
                                                    <?= ucfirst(session()->username); ?>
                                                <?php endif ?>
                                            </h4>
                                        </div>
                                    </div>
                                </li>
                                <li class="user-list">
                                    <a class="px-3 py-2" href="<?= base_url('superadmin/logout') ?>">
                                        <i class="fa fa-power-off"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="<?= base_url() ?>"
                            aria-expanded="false">
                            <i class="fas fa-th-list"></i>
                            <span class="hide-menu">Dashboard </span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="mdi mdi-gauge"></i>
                            <span class="hide-menu">Master</span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a href="<?= base_url('superadmin/addDepartment') ?>" class="sidebar-link">
                                    <i class="mdi mdi-adjust"></i>
                                    <span class="hide-menu"> Add Department </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">
                                    <i class="mdi mdi-adjust"></i>
                                    <span class="hide-menu"> Add Services </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false"><i class="mdi mdi-content-copy"></i><span class="hide-menu">Raised
                                Tickets </span></a>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
        <!-- Bottom points-->
        <div class="sidebar-footer">
            <div class="container" style="text-align: center; margin: 10px auto;">
                <a href="<?= base_url('superadmin/logout') ?>" class="link" data-toggle="tooltip" title="Logout">
                    <i class="mdi mdi-power" style="font-size: 20px;"></i>
                </a>
            </div>
        </div>
        <!-- End Bottom points-->
    </aside>