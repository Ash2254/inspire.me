<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/conn.php");

session_start();

$errors = [];

// echo "<pre>";
// print_r($_POST);
// print_r($_SESSION);
// print_r($_FILES);
// exit;

// SECTION update
if (isset($_POST["action"]) && $_POST["action"] == "update") {

    if(isset($_SESSION["user_id"]) && ($_SESSION["user_id"] == $_POST["user_id"]) || $_SESSION["role"] == 1) {

        $user_id        = $_POST["user_id"];
        $username       = $_POST["username"];
        $email          = $_POST["email"];
        $bio            = htmlspecialchars($_POST["bio"], ENT_QUOTES);
        $avatar_id      = NULL;
        $banner_pic_id  = NULL;

        if (strlen($username) < 3) $errors[] = "Username must be 3 or more characters.";
        if ($email == "")          $errors[] = "Please fill out your email.";

        
        // SECTION tags
        $delete_tags_query = "DELETE FROM user_tags WHERE user_id = $user_id";
        mysqli_query($conn, $delete_tags_query);
        if((empty($errors)) && isset($_POST["tags"])) {
            
            foreach ($_POST["tags"] as $tag_id) {

                $tag_check_query = "SELECT 1 FROM user_tags 
                                    WHERE user_id   = $user_id
                                    AND tag_id      = $tag_id
                                    LIMIT 1";

                $tag_check_result = mysqli_query($conn, $tag_check_query);

                if (mysqli_num_rows($tag_check_result) <= 0) {

                    $tag_query = "INSERT INTO user_tags (user_id, tag_id) VALUES ($user_id, $tag_id)";
    
                    if (mysqli_query($conn, $tag_query)) {
                        
                    } else {
                        $errors[] = "Error setting your tags: " . mysqli_error($conn);
                    }
                } 
                

            }

        }
        // !SECTION tags


        // SECTION banners
        if ((empty($errors)) && isset($_FILES["banner"]) && $_FILES["banner"]["error"] == 0) {
            if (
                ($_FILES["banner"]["type"] == "image/jpeg" ||
                $_FILES["banner"]["type"] == "image/jpg"   ||
                $_FILES["banner"]["type"] == "image/png"   ||
                $_FILES["banner"]["type"] == "image/gif")  &&
                $_FILES["banner"]["type"] <= 3000000
            ) {

                $date_uploaded = date("Y-m-d H:i:s");

                $file_name = $_SERVER["DOCUMENT_ROOT"]."/uploads/banners/".$_FILES["banner"]["name"];
                $file_name = explode(".", $file_name);
                $file_ext  = strtolower(end($file_name));
                array_pop($file_name);
                $file_name[] = date("YmdHis");
                $file_name[] = $file_ext;
                $file_name = implode(".", $file_name);

                if(!file_exists($file_name)) {
                    if(move_uploaded_file($_FILES["banner"]["tmp_name"], ($file_name))) {
                        $insert_image_query = " INSERT INTO banners 
                                                (url, owner_id, date_uploaded)
                                                VALUES
                                                ('".str_replace($_SERVER["DOCUMENT_ROOT"], "", $file_name)."', $user_id, '$date_uploaded')";

                        if(mysqli_query($conn, $insert_image_query)) {

                            $banner_id = mysqli_insert_id($conn);
                        } else {

                        }
                    }
                } else {
                    $errors[] = "File already exists.";
                }
            } else {
                $errors[] = "Invalid File.";
            }
        }
        // !SECTION banners

        // SECTION avatars
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
                $file_name = explode(".", $file_name);
                $file_ext  = strtolower(end($file_name));
                array_pop($file_name);
                $file_name[] = date("YmdHis");
                $file_name[] = $file_ext;
                $file_name = implode(".", $file_name);

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
                }
            } else {
                $errors[] = "Invalid File.";
            }
        }
        // !SECTION avatars

        // SECTION update user
        if (empty($errors)) {
            $update_query = "   UPDATE users SET
                                email       = '$email',
                                username    = '$username',
                                bio         = '$bio'";
            $update_query .=    ($avatar_id != NULL) ? ", avatar_id = $avatar_id" : "";
            $update_query .=    ($banner_id != NULL) ? ", banner_id = $banner_id" : "";
            $update_query .=    " WHERE id = $user_id";

            if (mysqli_query($conn, $update_query)) {
                header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?")."?user_id=".$user_id."&success=Profile+Updated+Successfully");
            } else {
                $errors[] = mysqli_error($conn);
            }
        }
        // !SECTION update user
        
    } else {
        $errors[] = "You do not have permission to edit this user.";
    }
}
// !SECTION update

// SECTION delete
elseif (isset($_POST["action"]) && $_POST["action"] == "delete") {
    $user_id = $_POST["user_id"];

    $delete_query = "DELETE FROM users WHERE id = $user_id";
    $select_query = "SELECT * FROM users WHERE id = $user_id";

    if ($user_result = mysqli_query($conn, $select_query)) {
        while ($user_row = mysqli_fetch_array($user_result)) {
            if ($user_row["role"] != 1) {
                if(mysqli_query($conn, $delete_query)) {
                    if ($user_row["id"] == $_SESSION["user_id"]) {
                        session_destroy();
                        header("Location: http://".$_SERVER["SERVER_NAME"]);
                    } else {
                        header("Location: http://".$_SERVER["SERVER_NAME"]."/members.php");
                    }
                } else {
                    $errors[] = mysqli_error($conn);
                }
            } else {
                $errors[] = "This user cannot be deleted.";
            }
        }

    } else {
        $errors[] = "User does not exist: ". mysqli_error($conn);
    }
}
// !SECTION delete

// SECTION change password
elseif (isset($_POST["action"]) && $_POST["action"] == "change_password") {
    // * select current user and check if current password matches
        // * check if new passwords match
            // * update user
    echo '<pre>';
    print_r($_POST);
    exit;
    // FIXME update to work with modal
    $user_id            = $_POST["user_id"];
    $current_password   = md5($_POST["password"]);
    $new_password       = md5($_POST["new_password"]);
    $new_password2      = md5($_POST["new_password2"]); 

    $select_query = "   SELECT * FROM users 
                        WHERE id = $user_id
                        AND password = '$current_password'";

    $select_result = mysqli_query($conn, $select_query);
    if (mysqli_num_rows($select_result) > 0) {
        if ($new_password == $new_password2) {
            $update_query = "   UPDATE users 
                                SET password = '$new_password' 
                                WHERE id = $user_id";

            if (mysqli_query($conn, $update_query)) {
                header("Location: http://".$_SERVER["SERVER_NAME"]."/profile.php?success=Password+Updated");
            } else {
                $errors[] = "Something went wrong: " . mysqli_error($conn);
            }
        } else {
            $errors[] = "New passwords do not match.";
        }
    } else {
        $errors[] = "Current password is incorrect " . mysqli_error($conn);
    }
}
// !SECTION change password

if (!empty($errors)) {
    $query = http_build_query(array("errors" => $errors));
    header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?user_id=" . $user_id . "&" . $query);

}

?>