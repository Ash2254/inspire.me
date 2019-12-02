<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/conn.php");

session_start();

$errors = [];


if (isset($_POST["action"]) && $_POST["action"] == "update"):

    if(isset($_SESSION["user_id"]) && ($_SESSION["user_id"] == $_POST["user_id"]) || $_SESSION["role"] == 1) {

        $user_id        = $_POST["user_id"];
        $username       = $_POST["username"];
        $bio            = $_POST["bio"];
        $avatar_id      = NULL;
        $banner_pic_id  = NULL;

        if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] == 0) {
            if (
                ($_FILES["avatar"]["type"] == "image/jpeg" ||
                $_FILES["avatar"]["type"] == "image/jpg"   ||
                $_FILES["avatar"]["type"] == "image/png"   ||
                $_FILES["avatar"]["type"] == "image/gif")  &&
                $_FILES["avatar"]["type"] <= 3000000
            ) {

                $file_name = $_SERVER["DOCUMENT_ROOT"]."/uploads/".$_FILES["avatar"]["name"];

                if(!file_exists($file_name)) {
                    if(move_uploaded_file($_FILES["avatar"]["tmp_name"], ($file_name))) {
                        $insert_image_query = " INSERT INTO avatars 
                                                (url, owner_id, date_uploaded)
                                                VALUES
                                                ('".str_replace($_SERVER["DOCUMENT_ROOT"], "", $file_name)."', $user_id)";

                        if(mysqli_query($conn, $insert_image_query)) {

                            $avatar_id = mysqli_insert_id($conn);
                        } else {

                        }
                    }
                }
            }
        }
    }



endif;

?>