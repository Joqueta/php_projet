<?php 
require_once 'db.php';   
require_once 'admin_functions.php';
require_once 'user_functions.php';

function createHeader() {
    $adminLinks = isAdmin() ? '<li><a href="admin.php">Admin</a></li>' : '';

    return '
    <header>
        <nav>
            <div class="logo">
                <a href="index.php">
                    <img src="../images/logo_sans_fond.png" alt="logo" width="50" height="50">
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="dashboard.php"></i>Tableau de bord</a></li>
                '.$adminLinks.'
                <li><a href="user.php">Profil</a></li>
                <li><a href="logout.php" class="logout">Déconnexion</a></li>
            </ul>
        </nav>
    </header>';
}
?>
<style>
header {
    background-color: rgb(39, 90, 186);
    color: white;
    padding: 10px 20px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}


nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
}


.logo img {
    width: 50px;
    height: 50px;
}


.nav-links {
    list-style: none;
    display: flex;
    align-items: center;
    gap: 15px;
}

.nav-links li {
    display: inline-block;
}

.nav-links a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 8px 12px;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: color 0.3s ease;
}

.nav-links a:hover {
    color: rgb(157, 190, 244);
}


.logout {
    background-color: #dc3545;
    padding: 8px 12px;
    border-radius: 5px;
}

.logout:hover {
    background-color: #c82333;
}


@media (max-width: 768px) {
    nav {
        flex-direction: column;
        text-align: center;
    }
    
    .nav-links {
        flex-direction: column;
        gap: 10px;
    }
}
</style>