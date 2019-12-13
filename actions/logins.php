<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/conn.php");

$errors = [];

// echo "<pre>";
// print_r($_SERVER);
// print_r($_POST);

// SECTION login
if (isset($_POST["action"]) && $_POST["action"] == "login") {
    
    if (
        (isset($_POST["username"]) && $_POST["username"] != "") &&
        (isset($_POST["password"]) && $_POST["password"] != "")
    ) {
        $username = $_POST["username"];
        $hashed_password = md5($_POST["password"]);

        $login_query = "SELECT * FROM users 
                        WHERE username = '".$username."'
                        AND password = '".$hashed_password."'
                        LIMIT 1";

        $login_result = mysqli_query($conn, $login_query);

        if (mysqli_num_rows($login_result) > 0) {
            while ($user = mysqli_fetch_array($login_result)) {

                session_destroy();
                session_start();

                $_SESSION["username"] = $user["username"];
                $_SESSION["role"]     = $user["role"];
                $_SESSION["user_id"]  = $user["id"];

                print_r($_SESSION);

                header("Location: " . $_SERVER["HTTP_REFERER"]);
                
            }
        } else {
            $errors[] = "Username or Password are incorrect.";
        }
    } else {
        $errors[] = "Please fill out both fields.";
    }
// !SECTION login 


// SECTION register
} elseif (isset($_POST["action"]) && $_POST["action"] == "register") {
    $username  = $_POST["username"];
    $email     = $_POST["email"];
    $password  = $_POST["password"];
    $password2 = $_POST["password2"];

    if (strlen($username) < 3)         $errors[] = "Username must be 3 or more characters.";
    if ($email == "")                  $errors[] = "Please fill out your email.";
    if (strlen($password) < 8)         $errors[] = "Your password must be a minimum of 8 characters.";
    if ($password != $password2)       $errors[] = "Your passwords do not match.";
    if (!isset($_POST["agree_terms"])) $errors[] = "You must agree to the Terms and Conditions.";


    if(empty($errors)) {

        $hashed_password = md5($password);

        $date_created = date("Y-m-d H:i:s");
    
        $new_user_query = "INSERT INTO users (username, email, password, role, date_created) VALUES ('$username', '$email', '$hashed_password', 2, '$date_created')";
    
        if (!mysqli_query($conn, $new_user_query)) {
            echo mysqli_error($conn);
        } else {
            $user_id = mysqli_insert_id($conn);
    
            session_destroy();
            session_start();
    
            $_SESSION["user_id"] = $user_id;
            $_SESSION["role"]    = 2;
            $_SESSION["username"]= $username;
    
            header("Location: ".$_SERVER["HTTP_REFERER"]);
        }
        
    }
// !SECTION register

// SECTION logout
} elseif (isset($_POST["action"]) && $_POST["action"] == "logout") {
    session_destroy();

    header("Location: http://" . $_SERVER["SERVER_NAME"]);

}
// !SECTION logout

if (!empty($errors)) {
    $query = http_build_query(array("errors" => $errors));
    header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?" . $query);

}

?>