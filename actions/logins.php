<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/conn.php");

$errors = [];

// echo "<pre>";
// print_r($_SERVER);
// print_r($_POST);

if (isset($_POST["action"]) && $_POST["action"] == "login"):
    
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

                header("Location: http://" . $_SERVER["SERVER_NAME"]);
                
            }
        } else {
            $errors[] = "Username or Password are incorrect.";
        }
    } else {
        $errors[] = "Please fill out both fields.";
    }

elseif (isset($_POST["action"]) && $_POST["action"] == "register"):
    $username  = $_POST["username"];
    $email     = $_POST["email"];
    $password  = $_POST["password"];
    $password2 = $_POST["password2"];

    if (strlen($password) > 7) {
        if ($password == $password2) {
            if (isset($_POST["agree_terms"])) {
                if($username != "" && $email != "") {
                    $hashed_password = md5($password);

                    $new_user_query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', 2)";

                    if (!mysqli_query($conn, $new_user_query)) {
                        echo mysqli_error($conn);
                    } else {
                        $user_id = mysqli_insert_id($conn);

                        session_destroy();
                        session_start();

                        $_SESSION["user_id"] = $user_id;
                        $_SESSION["role"]    = 2;
                        $_SESSION["username"]= $username;

                        header("Location: http://".$_SERVER["SERVER_NAME"]);
                    }

                } else {
                    $errors[] = "Please fill out all fields.";
                }

            } else {
                $errors[] = "You must agree to the Terms and Conditions";
            }

        } else {
            $errors[] = "Your passwords do not match";
        }

    } else {
        $errors[] = "Your password must be a minimum of 8 characters.";
    }




elseif (isset($_POST["action"]) && $_POST["action"] == "logout"):
    session_destroy();

    header("Location: http://" . $_SERVER["SERVER_NAME"]);


endif;

if (!empty($errors)) {
    $query = http_build_query(array("errors" => $errors));
    header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?" . $query);

}

?>