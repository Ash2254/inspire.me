<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/conn.php");

$errors = [];

echo "<pre>";
print_r($_SERVER);
print_r($_POST);

// if (isset($_POST["action"]) && $_POST["action"] == "login"):

if (isset($_POST["action"]) && $_POST["action"] == "register"):
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






endif;

if (!empty($errors)) {
    $query = http_build_query(array("errors" => $errors));
    header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?" . $query);

}

?>