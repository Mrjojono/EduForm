<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="inex.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>

<body class="container-fluid body" >

<!-- Navbar -->
<div class="container-fluid">
    <nav class="navbar fixed-top navbar-expand-lg ">
        <div class="container-fluid">
            <a class="navbar-brand" style="color: black; font-size:25px;" href="index.html">EduForm</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                    aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link active " style="color: white; font-size:12px;"   aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: white; font-size:12px;" href="info_etudiant.php">Form</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: white; font-size:12px;" href="index2.html">Blog-campus</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        style="color: white; font-size:12px;"
                           aria-expanded="false">
                            Link
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../php/Login.php">Logout</a></li>
                        </ul>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Link</a>
                    </li>
                    -->
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</div>

<!-- Main Content -->
<div class="container-fluid mt-5 pt-5">
    <div class="container-fluid">

        <!-- Professor Control Section -->
        <div class=" container-fluid professor">

            <div class="online">

                <div class="chat-container mt-4">
                    <div class="message-display">
                        <!-- Messages go here -->
                    </div>
                    <div class="input-area">
                        <input type="text" class="form-control" placeholder=" Ecrire un message...">
                        <button class="btn-envoyer">Envoyer</button>
                    </div>
                </div>

                <!--personne en ligne -->
                <div class="online-perso">
                    <div class="message">

                    </div>
                </div>

            </div>


        </div>

        <!-- Student Section -->
        <div class=" container-fluid  ">
            <div class="_add" >
                                                <?php

                                    require_once '../php/database.php';

                                    $users_email = $_SESSION["email"];

                                    // Fetch the user ID based on the email
                                    $id2_sql = $conn->prepare("SELECT id FROM users WHERE email = ?");
                                    $id2_sql->bind_param("s", $users_email);
                                    $id2_sql->execute();
                                    $result_3 = $id2_sql->get_result();
                                    $user = $result_3->fetch_assoc();
                                    $user_id_2 = $user["id"];

                                    // Fetch all student data for the connected user
                                    $stmt = $conn->prepare("SELECT * FROM users_data WHERE users_id = ?;");
                                    $stmt->bind_param("i", $user_id_2);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    // Fetch the number of students for the connected user
                                    /*
                                    
                                     $stmt_2 = $conn->prepare("SELECT count(*) as student_numb FROM users_data WHERE users_id = ?;");
                                    $stmt_2->bind_param("i", $user_id_2);
                                    $stmt_2->execute();
                                    $result_2 = $stmt_2->get_result();
                                    $user_data_2 = $result_2->fetch_assoc();
                                    $student_numb = $user_data_2["student_numb"];

                                    */
                                   
                                    // Loop through each student and display their data
                                    while ($user_data = $result->fetch_assoc()) {
                                        $prenom = $user_data["prénoms"];
                                        $name = $user_data["names"];
                                        $email = $user_data["email"];

                                        echo "
                                    
                                            <div class='container-fluid liste bg-dark '>
                                                <div class='info'>
                                                    <li>Nom: $name</li>
                                                    <li>Prénom : $prenom</li>
                                                    <li>Email: $email</li>
                                                </div>

                                                <div class='btn'>
                                                    <button class='icone'>
                                                        <ion-icon name='pencil-outline'></ion-icon>
                                                    </button>

                                                    <button class='icone'>
                                                        <ion-icon name='trash-outline'></ion-icon>
                                                    </button>
                                                </div>
                                            </div>
                                       ";

                                    }

                                    $stmt->close();
                                    $id2_sql->close();
                                    $conn->close();

                                    ?>

            </div>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="index.js"></script>

</body>
</html>
