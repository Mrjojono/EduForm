<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="inex.css" rel="stylesheet">
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>

<body class="container-fluid body">

<!-- Navbar -->
<div class="container-fluid">
    <nav class="navbar fixed-top navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">EduForm</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                    aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="info_etudiant.html">Form</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index2.html">Blog-campus</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Link
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../php/Login.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<!-- Main Content -->
<div class="container-fluid mt-5 pt-5">
    <div class="container-fluid">

        <!-- Professor Control Section -->
        <div class="container-fluid professor">
            <form action="info_etudiant.php" method="post" enctype="multipart/form-data">

                <div class="input-group-text bg-transparent mb-5">
                    <?php
                    session_start(); 

                    if (isset($_POST["submit"])) {
                        $name = $_POST["name"];
                        $prenom = $_POST["prenom"];
                        $age = $_POST["age"];
                        $date_N = $_POST["date_N"];
                        $identifiant = $_POST["identifiant"];
                        $Adresse = $_POST["Adresse"];
                        $tel = $_POST["tel"];
                        $email = $_POST["email"];
                        $leve_l = $_POST["Niveau"];
                        $description = $_POST["description"];
                        $errors = [];
                        $photoPath = "";

                        // Check if user is logged in
                        if (isset($_SESSION['email'])) {
                            $user_email = $_SESSION['email'];
                        } else {
                            $errors[] = "Error: Please log in.";
                        }

                        // Validate required fields
                        if (empty($name) || empty($prenom) || empty($age) || empty($date_N)) {
                            $errors[] = "You must fill in all required fields.";
                        }

                        // Handle photo upload
                        if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
                            $photo = $_FILES["photo"];
                            $photoName = basename($photo["name"]);
                            $uploadDir = "uploads/";
                            $photoPath = $uploadDir . $photoName;
                        
                            // create directory if the directory doesn't exists
                            if (!is_dir($uploadDir)) {
                                mkdir($uploadDir, 0755, true); 
                            }
                        
                            // Move the uploaded file
                            if (move_uploaded_file($photo["tmp_name"], $photoPath)) {
                                echo "File successfully uploaded.";
                            } else {
                                echo "Failed to move uploaded file.";
                            }
                        } else {
                            echo "No file uploaded or upload error occurred.";
                        }
                        

                        // Insert into database if no errors

                        if (count($errors) === 0) {
                            require_once "../php/database.php";

                            //fill out the users id 
                            $id_sql = $conn->prepare("SELECT id FROM users WHERE email = ?");
                            $id_sql->bind_param("s", $user_email);
                            $id_sql->execute();
                            $result_2 = $id_sql->get_result();
                            $user = $result_2->fetch_assoc();
                            $user_id = $user["id"];

                
                            
                
                            //insert the data into the user_databse 
                            $stmt = $conn->prepare("INSERT INTO users_data (users_id, names, prénoms, age, date_naissance, identification_number, leve_l, Adresse, Tel, email, Photo, Descriptions) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("issisissssss", $user_id, $name, $prenom, $age, $date_N, $identifiant, $leve_l, $Adresse, $tel, $email, $photoPath, $description);
                            $stmt->execute();

                            $stmt->close();
                            $id_sql->close();
                            $conn->close();
                        }

                        // Display errors if any
                        if (count($errors) > 0) {
                            echo "<div class='alert alert-danger'>";
                            foreach ($errors as $e) {
                                echo $e . "<br>";
                            }
                            echo "</div>";
                        }
                    }
                    ?>

                    <input id="name" name="name" class="text form-control" type="text" placeholder="Name" >
                    <input id="prenom" name="prenom" class="text form-control" type="text" placeholder="Prénoms" >
                    <input id="age" name="age" class="text age" type="number" placeholder="Age" required >
                    <input id="date_N" name="date_N" class="text date" type="date" required>
                    <input id="identifiant" name="identifiant" class="text identifiant" type="number" placeholder="Numéro d'identification">
                    <input id="Niveau" name="Niveau" class="text Niveau" type="text" placeholder="Niveau">
                    <input id="Adresse" name="Adresse" class="text" type="text" placeholder="Adresse">
                    <input id="tel" name="tel" class="text" type="tel" placeholder="Numéro de téléphone">
                    <input id="email" name="email" class="text" type="email" placeholder="Entrer votre email">
                    <input id="photo" name="photo" class="text date" type="file">
                    <input class="text description form-control mt-3" type="text" id="description" name="description" placeholder="Notes/Commentaires">

                </div>

                <div class="btn-group">
                    <button class="btnl" id="supprimer" onclick="supp_student();">Delete student</button>
                    <button type="submit" class="btnl" name="submit">Add student</button>
                </div>

            </form>
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
