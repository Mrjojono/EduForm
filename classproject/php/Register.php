<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="tuto.css" rel="stylesheet">
    <title>Document</title>
</head>
<body class="bg-black">
<div class="container-fluid">
    <nav class="navbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" style="color: antiquewhite; font-weight: bold; font-size: 40px">EduForm</a>
            <form class="d-flex">
                <button class="btn" type="submit">Social</button>
                <button class="btn btn-outline-success" type="submit"><a href="Login.php"
                                                                         style="text-decoration: none; color:green; ">Sign</a>
                </button>
            </form>
        </div>
    </nav>
    <div class="container">
        <?php
        require_once 'database.php';
        if (isset($_POST["submit"])) {
            $email = $_POST["email"];
            $name = $_POST["name"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["passwordRepeat"];
            $error = array();

            // Perform validation
            if (empty($password) || empty($email) || empty($name)) {
                $error[] = "All fields are required.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error[] = "Email is not valid.";
            }
            if (strlen($password) < 8) {
                $error[] = "Password must be at least 8 characters long.";
            }
            if ($password !== $passwordRepeat) {
                $error[] = "Passwords do not match.";
            }

            if (count($error) > 0) {
                echo "<div class='alert alert-danger'>";
                foreach ($error as $err) {
                    echo $err . "<br>";
                }
                echo "</div>";
            } else {
                require_once "database.php";
                // Check if email already exists
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $rowCount = mysqli_num_rows($result);

                if ($rowCount > 0) {
                    $error[] = "Email already exists!";
                } else {
                    // Hash the password
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Insert new user
                    $sql = "INSERT INTO users (name, email, passwords) VALUES (?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);

                    if (mysqli_stmt_prepare($stmt, $sql)) {
                        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'>Form submitted successfully!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>There was an error with the database.</div>";
                    }

                    mysqli_stmt_close($stmt);
                }

                mysqli_close($conn);
            }
        }
        ?>

        <form class="form-horizontal" action="Register.php" method="post">
            <h1 class="h1 mt-5 font-weight-bold">Register</h1>
            <label for="name" class="sr-only">
                <input type="text" id="name" name="name" class="form-control" placeholder="full name"
                >
            </label>
            <label for="email" class="sr-only">
                <input type="email" id="email" name="email" class="form-control" placeholder="email">
            </label>
            <label for="pass" class="sr-only">
                <input type="password" id="pass" name="password" class="form-control" placeholder="password">
            </label>
            <label for="pass" class="sr-only">
                <input type="password" id="pass" name="passwordRepeat" class="form-control"
                       placeholder=" Repeat password">
            </label>
            <button class="btn  btn-primary btn-block mb-2 mt-3" type="submit" name="submit" onclick="login();">
                Register
            </button>
            <p class="p mt-2">Already have an account? <a href="Login.php">Login!</a></p>
        </form>
    </div>
    <footer class="text-center text-white mt-5 py-3 bg-transparent ">
        <div class="container">
            <p class="mb-0">&copy; 2024 Mrjojono. All rights reserved.</p>
        </div>
    </footer>
</div>
<script src="/Login.js"></script>
</body>
</html>
