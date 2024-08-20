<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "verve_task";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);

    // Execute statement
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        // Bind result
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($pass, $hashed_password)) {
            // Password is correct
            echo "Login successful!";
            // Optionally start a session and redirect
            $_SESSION['username'] = $user;
            header("Location: success.html");
            exit();
        } else {
            // Invalid password
            $error = "Invalid username or password.";
        }
    } else {
        // User does not exist
        $error = "Invalid username or password.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        *{
            margin:0;
            padding:0;
        }
    
        body{
            background-color: rgb(27, 27, 62);
            background-position:cover;
            background-size: cover;
            height: fit-content;
        }
        .wrapper{
            background-color: rgba(245, 244, 238, 0.927);
            box-shadow:100%;
            height:70vh;
            margin-left:450px;
            margin-right:450px;
            margin-top:70px;
            border-radius:25px;
            font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }
        h1{
            font-size:30px;
            font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            padding:40px;
            text-align: center;
            margin-top: 30px;
        }
        form{
            padding:3px;
            margin: top 6px;
            margin-left:50px;
            margin-bottom:20px;
            
        }
        form input{
            border:none;
            box-sizing: border-box;
            padding:7px;
            margin:12px;
            width:80%;
            background-color: rgb(176, 211, 227);
            border-radius: 6px;
        }
    
        form input:hover{
        background-color: rgb(231, 222, 160);
    }
    
        form input::placeholder{
            color:darkblue;
        }
        form label{
            font-size:15px;
            margin-left:20px;
        }
        form button{  
            margin-left:60px;
            border-radius:20px;
            width:40%;
            padding:10px;
            border:2px solid white;
            margin-top: 20px;
            background-color: rgb(75, 75, 143);
            font-weight:500;
            cursor: pointer;
    }
        form button:hover{
            background-color:black;
        }
        .main_head{
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            font-size: 40px;
            color:white;
            margin-left: 380px;
            margin-top: 10px;

        }
    </style>
    </head>
    <body>
        <div class="main_head">
            <p>Welcome to SmartLearning Hub</p>
        </div>
        <div class="wrapper">
            <h1>LOGIN</h1>
            <?php
        if (isset($error)) {
            echo '<div class="alert alert-danger">' . $error . '</div>';
        }
        ?>
        <form method="post" action="login.php">
            <div class="mb-3">
              <label for="email" class="form-label">Email Id :</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="email" placeholder="enter your email" name="username" required="required">
              </div>
            </div>
            <div class="mb-3">
              <label for="passwd" class="form-label">Password :</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="password" placeholder="enter your password" name="password" required="required">
              </div>
            </div>
            <button type="submit"><font color="white"><b>Login</b></font></button>
            </div>
        
     <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>   
    </body>
    </html>