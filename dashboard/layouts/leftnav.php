    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <?php if (auth()->access_level == 1) { ?>
                    <div class="sb-sidenav-menu-heading">Menu</div>
                    <a href="/dashboard/" class="nav-link" href="index.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <?php } ?>

                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsStocks" aria-expanded="true" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Manage Stocks
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayoutsStocks" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a href="/dashboard/stocks" class="nav-link" href="layout-static.html">Listing</a>
                            <a href="/dashboard/stocks/create.php" class="nav-link" href="layout-sidenav-light.html">Form</a>
                        </nav>
                    </div>

                    <?php if (auth()->access_level == 1) { ?>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsUsers" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                        Users Management
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayoutsUsers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a href="/dashboard/users" class="nav-link" href="layout-static.html">Listing</a>
                            <a href="/dashboard/users/create.php" class="nav-link" href="layout-sidenav-light.html">Form</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsInventory" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                        Inventory History
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayoutsInventory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a href="/dashboard/history" class="nav-link" href="layout-static.html">Listing</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsInventory" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                        Reports
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayoutsInventory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a href="/dashboard/reports" class="nav-link" href="layout-static.html">Listing</a>
                        </nav>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as: <strong><?php echo auth()->name ?></strong></div>
            </div>
        </nav>
    </div>