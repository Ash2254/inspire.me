<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/conn.php");

session_start();

$errors = [];

// echo "<pre>";
// print_r($_POST);
// print_r($_SESSION);
// print_r($_FILES);
// exit;


if (isset($_POST["action"]) && $_POST["action"] == "update") {

    if(isset($_SESSION["user_id"]) && ($_SESSION["user_id"] == $_POST["user_id"]) || $_SESSION["role"] == 1) {

        $user_id        = $_POST["user_id"];
        $username       = $_POST["username"];
        $email          = $_POST["email"];
        $bio            = $_POST["bio"];
        $avatar_id      = NULL;
        $banner_pic_id  = NULL;

        if (strlen($username) < 3) $errors[] = "Username must be 3 or more characters.";
        if ($email == "")          $errors[] = "Please fill out your email.";

        if ((empty($errors)) && isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] == 0) {
            if (
                ($_FILES["avatar"]["type"] == "image/jpeg" ||
                $_FILES["avatar"]["type"] == "image/jpg"   ||
                $_FILES["avatar"]["type"] == "image/png"   ||
                $_FILES["avatar"]["type"] == "image/gif")  &&
                $_FILES["avatar"]["type"] <= 3000000
            ) {

                $date_uploaded = date("Y-m-d H:i:s");

                $file_name = $_SERVER["DOCUMENT_ROOT"]."/uploads/avatars/".$_FILES["avatar"]["name"];

                if(!file_exists($file_name)) {
                    if(move_uploaded_file($_FILES["avatar"]["tmp_name"], ($file_name))) {
                        $insert_image_query = " INSERT INTO avatars 
                                                (url, owner_id, date_uploaded)
                                                VALUES
                                                ('".str_replace($_SERVER["DOCUMENT_ROOT"], "", $file_name)."', $user_id, '$date_uploaded')";

                        if(mysqli_query($conn, $insert_image_query)) {

                            $avatar_id = mysqli_insert_id($conn);
                        } else {

                        }
                    }
                } else {
                    $errors[] = "File already exists.";
                    // TODO: Better handle duplicate files
                }
            } else {
                $errors[] = "Invalid File.";
            }
        }

        if (empty($errors)) {
            $update_query = "   UPDATE users SET
                                email       = '$email',
                                username    = '$username',
                                bio         = '$bio'";
            $update_query .=    ($avatar_id != NULL) ? ", avatar_id = $avatar_id" : "";
            $update_query .=    " WHERE id = $user_id";

            if (mysqli_query($conn, $update_query)) {
                header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?")."?user_id=".$user_id."&success=Profile+Updated+Successfully");
            } else {
                $errors[] = mysqli_error($conn);
            }
        }
        
    } else {
        $errors[] = "You do not have permission to edit this user.";
    }



}

if (!empty($errors)) {
    $query = http_build_query(array("errors" => $errors));
    header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?user_id=" . $user_id . "&" . $query);

}

?>