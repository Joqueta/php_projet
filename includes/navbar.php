<?php 
  function createHeader() {
    return '
      <header>
            <nav>
                <ul>
                    <li><a href="index.php">Acceuil</a></li>
                    <li><a href="dashboard.php">Tableau de bord</a></li>
                    <li><a href="user.php">Profil</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>
            </nav>
        </header>
    ';
  }
  
?>
<style>
    header {
        background-color: #6191e4;
        color: white;
        padding: 10px;
        text-align: center;
    }

    nav ul {
        list-style-type: none;
        padding: 0;
    }

    nav ul li {
        display: inline;
        margin-right: 10px;
    }

    nav ul li a {
        color: white;
        text-decoration: none;
    }
    </style>