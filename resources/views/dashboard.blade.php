<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{ $title }} | Getlead Partner Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Partner Portal for Getlead" name="description" />
    <meta content="Getlead" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    @if (isset($additional_css)){{$additional_css}}@endif
</head>
<body data-layout="vertical" data-sidebar="dark">
    <div id="layout-wrapper">
	
<header id="page-topbar" class="isvertical-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="home.php" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.svg" alt="Getlead Partner Portal Logo" height="45">
                    </span>
                </a>
                <a href="home.php" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.svg" alt="Getlead Partner Portal Logo" height="45">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- Search -->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="bx bx-search"></span>
                </div>
            </form>
        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block d-lg-none">
                <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-sm" data-feather="search"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
                    <form class="p-2">
                        <div class="search-box">
                            <div class="position-relative">
                                <input type="text" class="form-control rounded bg-light border-0" placeholder="Search...">
                                <i class="mdi mdi-magnify search-icon"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-sm" data-feather="bell"></i>
                <span class="noti-dot bg-danger rounded-pill">3</span>
            </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 font-size-15"> Notifications </h5>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small"> Mark all as read</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 250px;">
                        <h6 class="dropdown-header bg-light">New</h6>
                        <!-- Notification items -->
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                            <i class="uil-arrow-circle-right me-1"></i> <span>View More..</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg" alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <a class="dropdown-item" href="#"><i class='bx bx-user-circle text-muted font-size-18 align-middle me-1'></i> <span class="align-middle">My Account</span></a>
                    <a class="dropdown-item" href="help.php"><i class='bx bx-buoy text-muted font-size-18 align-middle me-1'></i> <span class="align-middle">Support</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="auth-login.php"><i class='bx bx-log-out text-muted font-size-18 align-middle me-1'></i> <span class="align-middle">Logout</span></a>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="home.php" class="logo logo-dark">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.svg" alt="Getlead Partner Portal Logo" height="45">
            </span>
        </a>

        <a href="home.php" class="logo logo-light">
            <span class="logo-lg">
                <img src="assets/images/logo-sm.svg" alt="Getlead Partner Portal Logo" height="45">
            </span>
            <span class="logo-sm">
                <img src="assets/images/logo-sm.svg" alt="Getlead Partner Portal Logo" height="45">
            </span>
        </a>
    </div>

    <div data-simplebar class="sidebar-menu-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="index.php">
                        <i class="bx bx-tachometer icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="partners.php">
                        <i class="bx bx-user-circle icon nav-icon"></i>
                        <span class="menu-item" data-key="t-partners">Partners</span>
                    </a>
                </li>

                <li>
                    <a href="leads.php">
                        <i class="bx bx-user-pin icon nav-icon"></i>
                        <span class="menu-item" data-key="t-leads">Leads</span>
                    </a>
                </li>

                <li>
                    <a href="payouts.php">
                        <i class="bx bx-wallet icon nav-icon"></i>
                        <span class="menu-item" data-key="t-payouts">Payouts</span>
                    </a>
                </li>

                <li>
                    <a href="notifications.php">
                        <i class="bx bx-bell icon nav-icon"></i>
                        <span class="menu-item" data-key="t-notifications">Notifications</span>
                    </a>
                </li>

                <li>
                    <a href="marketing.php">
                        <i class="bx bx-bullhorn icon nav-icon"></i>
                        <span class="menu-item" data-key="t-marketing">Marketing</span>
                    </a>
                </li>

                <li>
                    <a href="integrations.php">
                        <i class="bx bx-heart-circle icon nav-icon"></i>
                        <span class="menu-item" data-key="t-integrations">Integrations</span>
                    </a>
                </li>

                <li>
                    <a href="developer-api.php">
                        <i class="bx bx-code-curly icon nav-icon"></i>
                        <span class="menu-item" data-key="t-api">API's</span>
                    </a>
                </li>

                <li>
                    <a href="settings.php">
                        <i class="bx bx-cog icon nav-icon"></i>
                        <span class="menu-item" data-key="t-settings">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Dashboard</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->

            <!-- Welcome Message -->
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success text-center" role="alert">
                        <h4 class="alert-heading">Welcome Back, <?php echo $username; ?>!</h4>
                        <p>Manage your partners and leads effectively with our comprehensive dashboard.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Partners Statistics -->
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Partners</h5>
                            <h4>1,245</h4>
                            <p class="text-muted">Partners added this week: 45</p>
                            <p class="text-muted">Partners added this month: 150</p>
                        </div>
                    </div>
                </div>

                <!-- Leads Statistics -->
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Leads</h5>
                            <h4>3,564</h4>
                            <p class="text-muted">Leads added this week: 120</p>
                            <p class="text-muted">Leads added this month: 450</p>
                        </div>
                    </div>
                </div>

                <!-- Payout Statistics -->
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Payouts</h5>
                            <h4>$25,890</h4>
                            <p class="text-muted">Payouts this week: $1,200</p>
                            <p class="text-muted">Payouts this month: $4,800</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest Leads -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Latest Leads</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Partner</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>John Doe</td>
                                            <td>john.doe@example.com</td>
                                            <td>+1234567890</td>
                                            <td>Partner A</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                        </tr>
                                        <tr>
                                            <td>Jane Smith</td>
                                            <td>jane.smith@example.com</td>
                                            <td>+0987654321</td>
                                            <td>Partner B</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td>Michael Johnson</td>
                                            <td>michael.johnson@example.com</td>
                                            <td>+1122334455</td>
                                            <td>Partner C</td>
                                            <td><span class="badge bg-danger">Inactive</span></td>
                                        </tr>
                                        <tr>
                                            <td>Emily Davis</td>
                                            <td>emily.davis@example.com</td>
                                            <td>+6677889900</td>
                                            <td>Partner D</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                        </tr>
                                        <tr>
                                            <td>William Brown</td>
                                            <td>william.brown@example.com</td>
                                            <td>+5566778899</td>
                                            <td>Partner E</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Marketing Campaigns and Notifications -->
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Recent Notifications</h5>
                            <ul class="list-group">
                                <li class="list-group-item">New lead added by Partner A</li>
                                <li class="list-group-item">Payout processed for Partner B</li>
                                <li class="list-group-item">Integration with Service X successful</li>
                                <li class="list-group-item">New partner registered</li>
                                <li class="list-group-item">Lead status updated by Partner C</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Marketing Campaigns</h5>
                            <ul class="list-group">
                                <li class="list-group-item">Campaign 1: 500 leads generated</li>
                                <li class="list-group-item">Campaign 2: 300 leads generated</li>
                                <li class="list-group-item">Campaign 3: 200 leads generated</li>
                                <li class="list-group-item">Campaign 4: 150 leads generated</li>
                                <li class="list-group-item">Campaign 5: 100 leads generated</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> &copy; Getlead Partner Portal.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://getleadcrm.com/" target="_blank" class="text-reset">GetLead CRM</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/metismenujs/metismenujs.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="assets/libs/feather-icons/feather.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
@if (isset($additional_js)) {{ $additional_js }} @endif
</body>
</html>