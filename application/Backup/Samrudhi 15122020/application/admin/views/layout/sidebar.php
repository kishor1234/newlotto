<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link" style="text-align:center;">
        <!--<img src="assets/static/logo/logo_pool.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">-->
        <span class="brand-text font-weight-light center" style="text-align:center;">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!--<div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="assets/static/logo/logo_pool.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Administrator</a>
            </div>
        </div>-->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Retailer
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!--<li class="nav-item">
                            <a href="javascript:void(0)" onclick="clickOnLink('/?r=dashboard&v=series', '#app-container', false)" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Series</p>
                            </a>
                        </li>-->
                        <li class="nav-item">
                            <a href="javascript:void(0)" onclick="clickOnLink('/?r=dashboard&v=user', '#app-container', false)" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Retailer Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0)" onclick="clickOnLink('/?r=dashboard&v=message', '#app-container', false)" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Publish Message</p>
                            </a>
                        </li>
                        

                    </ul>
                </li>
               
                
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-pencil-square-o"></i>
                        <p>
                            Report
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!--<li class="nav-item">
                            <a href="javascript:void(0)" onclick="clickOnLink('/?r=dashboard&v=grandSale', '#app-container', false)" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>My Grand Sell</p>
                            </a>
                        </li>-->
                        <li class="nav-item">
                            <a href="javascript:void(0)" onclick="clickOnLink('/?r=dashboard&v=getcashsummary', '#app-container', false)" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>My Retailers Cash Summery</p>
                            </a>
                        </li>
                        <!--<li class="nav-item">
                            <a href="javascript:void(0)" onclick="clickOnLink('/?r=dashboard&v=ticketPlayedreport', '#app-container', false)" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ticket Played Report</p>
                            </a>
                        </li>-->
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a href="javascript:void(0)" onclick="clickOnLink('/?r=dashboard&v=host', '#app-container', false)" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Deploy Game
<!--                            <span class="right badge badge-danger">New</span>-->
                        </p>
                    </a>
                </li>
                
<!--                <li class="nav-item">
                    <a href="javascript:void(0)" onclick="clickOnLink('/?r=dashboard&v=manualresult', '#app-container', false)" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Manual Result
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" onclick="clickOnLink('/?r=dashboard&v=blocknumber', '#app-container', false)" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Block Number Result
                        </p>
                    </a>
                </li>-->
                <li class="nav-item">
                    <a href="javascript:void(0)" onclick="clickOnLink('/?r=dashboard&v=changepassword', '#app-container', false)" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Change Password
<!--                            <span class="right badge badge-danger">New</span>-->
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/?r=logout" class="nav-link">
                        <i class=" nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout

                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside> 