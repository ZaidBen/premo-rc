<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
    <div class="container-fluid">
        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="../index.php" class="d-inline-flex align-items-center">
                <h3 class="sidebar-resize-hide flex-grow-1 my-auto">CHECK-LIST</h3>
            </a>
            <div class="navbar-brand flex-1 flex-lg-0">
            </div>
            <ul class="nav flex-row justify-content-end order-2 order-lg-2">
                <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                    <a style="color: white" href="#" class="navbar-nav-link align-items-center rounded-pill p-1"
                        data-bs-toggle="dropdown">
                        <span>
                            <i class="fas fa-user-circle profile-icon"></i>
                            <span></span>
                            <b class="text-light">Bienvenue <u>
                                    <?php echo $_SESSION['username'] ?>
                                </u></b>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="../responsable/logout.php" class="dropdown-item">
                            <i class="ph-sign-out me-2"></i>
                            <b>Se Déconnecter</b>
                        </a>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</div>