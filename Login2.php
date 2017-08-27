<?php
    require("password.php");

    $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    
    $statement = mysqli_prepare($con, "SELECT * FROM admin WHERE username = ?");
    mysqli_stmt_bind_param($statement, "s", $first_name);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $colfirst_name, $collast_name, $colemail, $colphone, $colpass);
    
    $response = array();
    $response["success"] = false;  
    
    while(mysqli_stmt_fetch($statement)){
        if (password_verify($pass, $colpass)) {
            $response["success"] = true;  
            $response["first_name"] = $colfirst_name;
            $response["last_name"] = $collast_name;
        }
    }

    echo json_encode($response);
?>
