<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <?php if (auth()->access_level == 1 || auth()->access_level == 2) { ?>
                    <div class="sb-sidenav-menu-heading">Menu</div>
                    <a href="/dashboard/" class="nav-link" href="index.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                <?php } ?>

                <a class="nav-link" href="/dashboard/stocks">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Manage Stocks
                </a>
                <nav class="sb-sidenav-menu-nested nav">
                    <a href="/dashboard/stocks" class="nav-link" href="layout-static.html">View Stock Data</a>
                    <a href="/dashboard/stocks/updatestock.php" class="nav-link" href="layout-sidenav-light.html">Update Stocks</a>
                    <a href="/dashboard/stocks/product_logs.php" class="nav-link" href="layout-sidenav-light.html">Product Logs</a>
                </nav>

                <?php if (auth()->access_level == 1) { ?>
                    <a class="nav-link" href="/dashboard/users">
                        <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                        Users Management
                    </a>
                    <nav class="sb-sidenav-menu-nested nav">
                        <a href="/dashboard/users" class="nav-link" href="layout-static.html">Users</a>
                        <a href="/dashboard/users/create.php" class="nav-link" href="layout-sidenav-light.html">Create User</a>
                    </nav>

                    <a class="nav-link" href="/dashboard/history">
                        <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                        Inventory History
                    </a>
                    <nav class="sb-sidenav-menu-nested nav">
                        <a href="/dashboard/history" class="nav-link" href="layout-static.html">Tabular History Data</a>
                        <a href="/dashboard/history/graphical.php" class="nav-link" href="layout-static.html">Graphical History Data</a>
                    </nav>

                    <a class="nav-link" href="/dashboard/reports">
                        <div class="sb-nav-link-icon"><i class="fas fa-report"></i></div>
                        Reports
                    </a>
                    <nav class="sb-sidenav-menu-nested nav">
                        <a href="/dashboard/reports" class="nav-link" href="layout-static.html">Stock Report</a>
                    </nav>
                <?php } ?>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as: <strong><?php echo auth()->name ?></strong></div>
        </div>
    </nav>
</div>