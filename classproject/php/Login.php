<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="tuto.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="bg-black">
<div class="container-fluid  ">
    <nav class="navbar fixed-top ">
        <div class="container-fluid ">
            <a class="navbar-brand" style="color: antiquewhite; font-weight: bold; font-size: 40px">EduForm</a>
            <form class="d-flex">
                <button class="btn" type="submit">Social</button>
                <button class="btn btn-outline-success" type="submit"><a href="Login.php" style="text-decoration: none; color:green; " >Sign</a></button>
            </form>
        </div>
    </nav>
    <div class="container">

    <?php
    session_start();
    if (isset($_POST["Login"])) {
        require_once "database.php";

        $email = $_POST["email"];
        $pass = $_POST["password"];
        $errors = array();


        if (empty($email) || empty($pass)) {
            array_push($errors, "Email and password are required.");
        } else {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc(); 

            
            if ($user) {
                if (password_verify($pass, $user["passwords"])) {
                    header("Location: ../index/index.php");
                    $_SESSION["email"] = $email;

                    $_SESSION["id"] = $user["id"];
                    exit();
                } else {
                    array_push($errors, "Password doesn't match.");
                }
            } else {
                array_push($errors, "Email not found.");
            }

            $stmt->close();
        }

        if (count($errors) > 0) {
            echo "<div class='alert alert-danger'>";
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
            echo "</div>";
        }
    }
    ?>

        <form class="form-group form-horizontal" action="Login.php" method="post">
            <h1 class="h1 mt-5 font-weight-bold">Login</h1>
            <label class="pass">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
            </label>
            <label class="pass">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            </label>
            <label class="pass">
            <input type="checkbox" value="remember-me"> Remember me
            </label> 
    
            <button class="btn btn-primary btn-block mb-2 mt-3" type="submit" name="Login">Login</button>

            <p class="p mt-2">No account? <a href="Register.php">Create one!</a></p>
        
        </form>
    </div>
    <footer class="text-center text-white mt-5 py-3 bg-transparent">
        <div class="container">
            <p class="mb-0">&copy; 2024 Mrjojono. All rights reserved.</p>
        </div>
    </footer>
</div>
<script src="./Login.js"></script>
</body>
</html>
