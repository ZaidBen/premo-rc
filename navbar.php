<div class="navbar navbar-expand-xl bg-white" style="border-bottom: 4px solid #dc3545;">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <img src="../template/assets/images/premologo.png" style="width: 180px; height: auto;">
        </div>
        <li class="nav-item ms-lg-2">
            <span class="live-time"></span>
            <span class="current-date"></span>

        </li>
        <ul class="nav flex-row justify-content-end order-2 order-lg-2">
            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a style="color:black" href="#" class="navbar-nav-link align-items-center rounded-pill p-1"
                    data-bs-toggle="dropdown">
                    <span>
                        <i class="fas fa-user-circle profile-icon"></i>
                        <span></span>
                        <b>Bienvenue <u>
                                <?php echo $_SESSION['username'] ?>
                            </u></b>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="../login/logout.php" class="dropdown-item">
                        <i class="ph-sign-out me-2"></i>
                        <b>Se Déconnecter</b>
                    </a>
                </div>
            </li>

        </ul>
    </div>
</div>
<script>
    // Function to update the live time and current date
    function updateTimeAndDate() {
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var timeString = hours + ":" + minutes + ":" + seconds;
        document.querySelector(".live-time").textContent = timeString;

        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        var dateString = currentTime.toLocaleDateString(undefined, options);
        document.querySelector(".current-date").textContent = dateString;
    }

    // Update the time and date every second
    setInterval(updateTimeAndDate, 1000);
</script>
<style>
    .live-time,
    .current-date {
        display: inline-block;
        font-size: 20px;
        margin-left: 10px;
        color: #777;
        animation: fade-in 1s ease-in-out infinite alternate;
    }

    @keyframes fade-in {
        from {
            opacity: 0.2;
        }

        to {
            opacity: 1;
        }
    }
</style>

<style>
    .profile-icon {
        font-size: 32px;
    }

    .navbar {
        border-radius: 0;

    }

    .navbar-brand h4 {
        font-size: 1.2rem;
        margin-bottom: 0;
    }

    .navbar-toggler {
        background-color: rgba(255, 255, 255, 0.1);
        border: none;
    }

    .navbar-nav-link {
        color: white;
        font-weight: bold;
        font-size: 1rem;
    }

    .navbar-nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .dropdown-item {
        font-weight: bold;
    }

    .dropdown-item:hover {
        background-color: rgba(0, 0, 0, 0.1);
    }
</style>