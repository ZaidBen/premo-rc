<div class="sidebar sidebar-main sidebar-expand-lg">
    <div class="sidebar-content">
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h4 class="sidebar-resize-hide flex-grow-1 my-auto">Menu</h4>
                <div>
                   

                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="sidebar-section" >
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item">
                    <a href="../login/admin.php" class="nav-link active">
                        <i class="fas fa-tachometer-alt"></i>
                        <span >Dashboard</span>
                    </a>
                    <hr class="sidebar-divider">

                </li>
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-80 sidebar-resize-hide text-light "><b>Production</b></div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                    <hr class="text-light" style="width:100%;text-align:left;margin-left:0;border-color:white;border:solid">

                </li>
                <li class="nav-item" style="margin-left: 15px;">

                    <a href="../codes/ligne.php" class="nav-link">
                        <i class="fas fa-heading"></i>
                        <span>Codes des projets</span>
                    </a>
                </li>
                <li class="nav-item" style="margin-left: 15px;">
                    <a href="../lignes/list_ligne.php" class="nav-link">
                        <i class="fas fa-industry"></i>
                        <span>Lignes de production</span>
                    </a>
                </li>
                <li class="nav-item" style="margin-left: 15px;">
                    <a href="../projets/projet.php" class="nav-link">
                        <i class="fas fa-project-diagram"></i>
                        <span>Projets des clients</span>
                    </a>
                </li>
                <li class="nav-item" style="margin-left: 15px;">
                    <a href="../postes/postes.php" class="nav-link">
                        <i class="fas fa-cogs"></i>
                        <span>Postes</span>
                    </a>
                </li>
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-80 sidebar-resize-hide text-light "><b>Gestion des personnes</b></div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                    <hr class="text-light" style="width:100%;text-align:left;margin-left:0;border-color:white;border:solid">

                </li>
                <li class="nav-item" style="margin-left: 15px;">
                    <a href="../operateur/operateur.php" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Liste des <b>opérateurs</b></span>
                    </a>
                </li>
                <li class="nav-item" style="margin-left: 15px;">
                    <a href="../responsable/responsable.php" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span>Liste des <b>responsables</b></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
    .sidebar-divider {
        border: none;
        border-top: 5px solid black;
        opacity: 0.5;
        margin: 10px 0;
    }



    .sidebar {
        background-color: #dc3545;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .sidebar-section-body {
        background-color: #dc3545;
        padding: 10px 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-section-body h4 {
        font-weight: bold;
        font-size: 1.3rem;
        margin-bottom: 0;
        color: #fff;
    }

    .sidebar-control,
    .sidebar-mobile-main-toggle {
        background-color: #fff;
        border-color: transparent;
        color: #dc3545;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .sidebar-control:hover,
    .sidebar-mobile-main-toggle:hover {
        background-color: #f8f9fa;
        color: #dc3545;
    }

    .nav-sidebar .nav-link {
        color: #fff;
        font-weight: ;
        transition: background-color 0.3s;
        /* Add left padding here */

    }

    .nav-sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .nav-sidebar .nav-link i {
        font-size: 25px;
        margin-right: 15px;
    }

    .nav-sidebar .nav-link span {
        font-size: 14px;
    }
</style>