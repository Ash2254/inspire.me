<?php 

require_once($_SERVER["DOCUMENT_ROOT"]."/conn.php");

session_start();

$errors = [];

// echo "<pre>";
// print_r($_SERVER);
// print_r($_POST);
// print_r($_FILES);
// exit;

if (isset($_POST["action"]) && $_POST["action"] == "edit_post") {
    if (isset($_SESSION["user_id"]) && ($_SESSION["user_id"] == $_POST["user_id"]) || $_SESSION["role"] == 1) {

        $user_id        = $_POST["user_id"];
        $post_id        = $_POST["post_id"];
        $title          = $_POST["post_title"];
        $category       = $_POST["post_category"];
        $description    = htmlspecialchars($_POST["post_description"], ENT_QUOTES);
        $date_modified  = date("Y-m-d H:i:s");
        
        
        if (isset($_FILES["post_image"]) && $_FILES["post_image"]["error"] == 0) {
            if (
                ($_FILES["post_image"]["type"] == "image/jpeg" || 
                $_FILES["post_image"]["type"] == "image/jpg"   ||
                $_FILES["post_image"]["type"] == "image/png"   ||
                $_FILES["post_image"]["type"] == "image/gif")  &&
                $_FILES["post_image"]["size"] <= 3000000
            ) {

                $file_name = $_SERVER["DOCUMENT_ROOT"]."/uploads/posts/".$_FILES["post_image"]["name"];

                $file_name = explode(".", $file_name);
                $file_ext  = strtolower(end($file_name));
                array_pop($file_name);
                $file_name[] = date("YmdHis");
                $file_name[] = $file_ext;
                $file_name = implode(".", $file_name);

                // Check if file exists
                if (!file_exists($file_name)
                ) {
                    // upload to uploads folder

                    if (move_uploaded_file($_FILES["post_image"]["tmp_name"], ($file_name))) {
                        $insert_image_query = "INSERT INTO post_images (url, owner_id, date_uploaded) VALUES ('".str_replace($_SERVER["DOCUMENT_ROOT"], "", $file_name)."', $user_id, '$date_modified')";

                        if(mysqli_query($conn, $insert_image_query)) {

                            $post_image_id = mysqli_insert_id($conn);

                        } else {
                            $errors[] = mysqli_error($conn);
                        }
                    }

                } else {
                    $errors[] = "File already exists";
                }

            } else {
                $errors[] = "Incorrect file type";
            }
            
        }


        if ($title != "" && $description != "") {
            $update_query = "   UPDATE posts
                                SET title       = '$title',
                                    category    = '$category',
                                    description = '$description',
                                    date_modified = '$date_modified'";
            $update_query .=    (isset($post_image_id)) ? ",image_id = $post_image_id" : "";
            $update_query .=    " WHERE id = $post_id";
            
            if (mysqli_query($conn, $update_query)) {
                header("Location: http://".$_SERVER["SERVER_NAME"]."/posts/view.php?id=".$post_id);
            }

        } else {
            $errors[] = "Your post must have a title and description";
        }




    } else {
        $errors[] = "You do not have permission to edit this post";
    }


} elseif (isset($_POST["action"]) && $_POST["action"] == "delete_post") {
    if (isset($_SESSION["user_id"]) && ($_SESSION["user_id"] == $_POST["user_id"]) || $_SESSION["role"] == 1) {
        $post_id = $_POST["post_id"];

        $delete_query = "DELETE FROM posts WHERE id = $post_id";
        $select_query = "SELECT * FROM posts WHERE id = $post_id";

        if ($post_result = mysqli_query($conn, $select_query)) {
            while ($post_row = mysqli_fetch_array($post_result)) {
                if(mysqli_query($conn, $delete_query)) {
                    header("Location: http://".$_SERVER["SERVER_NAME"]."/posts/view.php?success=Post+Deleted+Successfully");
                } else {
                    $errors[] = mysqli_error($conn);
                }
            }

        } else {
            $errors[] = "User does not exist: ". mysqli_error($conn);
        }
    } else {
        $errors[] = "You do not have permission to delete this post";
    }
}





if (!empty($errors)) {
    $query = http_build_query(array("errors" => $errors));
    header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?" . $query);

}

?>