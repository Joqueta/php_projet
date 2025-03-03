<?php 
require_once 'db.php';   
require_once 'admin_functions.php';
require_once 'user_functions.php';
  function createHeader() {
    if (!isAdmin()){
        return '
      <header>
            <nav>
                <ul>
                <img src="../images/logo_sans_fond.png" alt="logo" width="50" height="50">
                    <li><a href="index.php">Acceuil</a></li>
                    <li><a href="dashboard.php">Tableau de bord</a></li>
                    <li><a href="pages_admin/admin.php">Tableau admin</a></li>
                    <li><a href="user.php">Profil</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>
            </nav>
        </header>
    ';
    } else {
    return '
      <header>
            <nav>
                <ul>
                <img src="../images/logo_sans_fond.png" alt="logo" width="50" height="50">
                    <li><a href="index.php">Acceuil</a></li>
                    <li><a href="dashboard.php">Tableau de bord</a></li>
                    <li><a href="user.php">Profil</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>
            </nav>
        </header>
    ';
  }
}
  
?>
<style>
    header {
        background-color:rgb(39, 90, 186);
        color: white;
        padding: 5  px;    
    }

    nav ul {
        list-style-type: none;
        padding: 0;             
        display: flex;
        flex-direction: row; 
        justify-content: right;
        align-items: center;
        justify-content: space-between;
    }

    nav ul li {
        display: inline;
        margin-right: 10px;
    }

    nav ul li a {
        color: white;
        text-decoration: none;
    }
    a:hover{
        color:rgb(157, 190, 244);
    }
    img{
        margin-right: 70rem;
    }

</style>