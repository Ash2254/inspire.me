<?php 

require_once($_SERVER["DOCUMENT_ROOT"]."/conn.php");

session_start();

$errors = [];

// echo "<pre>";
// print_r($_SERVER);
// print_r($_POST);
// print_r($_FILES);
// exit;

if (isset($_SESSION["user_id"])):

    $user_id        = $_SESSION["user_id"];
    $title          = htmlspecialchars($_POST["post_title"], ENT_QUOTES);
    $description    = htmlspecialchars($_POST["post_description"], ENT_QUOTES);
    $tags           = htmlspecialchars(explode(",", $_POST["post_tags"]), ENT_QUOTES);
    $date_created   = date("Y-m-d H:i:s");

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
                    $insert_image_query = "INSERT INTO post_images (url, owner_id) VALUES ('".str_replace($_SERVER["DOCUMENT_ROOT"], "", $file_name)."', $user_id)";

                    if(mysqli_query($conn, $insert_image_query)) {

                        $post_image_id = mysqli_insert_id($conn);

                        if ($title != "" && $description != "") {
                            $query = "  INSERT INTO posts 
                                        (
                                            title, 
                                            description, 
                                            image_id, 
                                            author_id, 
                                            date_created, 
                                            date_modified
                                        ) VALUES (
                                            '$title',
                                            '$description',
                                            $post_image_id,
                                            $user_id,
                                            '$date_created',
                                            '$date_created'
                                        )";
                            
                            if (mysqli_query($conn, $query)) {
                                $post_id = mysqli_insert_id($conn);
                                header("Location: http://".$_SERVER["SERVER_NAME"]."/posts/view.php?id=".$post_id);
                            }
                        }

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
        
    } else {
        $errors[] = "Please upload an image";
    }




    
    
endif;






if (!empty($errors)) {
    $query = http_build_query(array("errors" => $errors));
    header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?" . $query);

}

?>