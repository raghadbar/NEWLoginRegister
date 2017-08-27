<?php
    require("password.php");

    $connect = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $phone =$_POST["phone"];

     function registerUser() {
        global $connect, $first_name, $last_name, $email, $pass,$phone;
        $passHash = password_hash($pass, PASSWORD_DEFAULT);
        $statement = mysqli_prepare($connect, "INSERT INTO admin (first_name,last_name, email, phone, pass) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($statement, "siss", $first_name, $last_name, $email, $passwordHash, $phone);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);     
    }

    function usernameAvailable() {
        global $connect, $email;
        $statement = mysqli_prepare($connect, "SELECT * FROM admin WHERE username = ?"); 
        mysqli_stmt_bind_param($statement, "s", $email);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_stmt_num_rows($statement);
        mysqli_stmt_close($statement); 
        if ($count < 1){
            return true; 
        }else {
            return false; 
        }
    }

    $response = array();
    $response["success"] = false;  

    if (usernameAvailable()){
        registerUser();
        $response["success"] = true;  
    }
    
    echo json_encode($response);
?>
