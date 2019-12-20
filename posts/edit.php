<?php 

require_once($_SERVER["DOCUMENT_ROOT"]."/conn.php");

$errors = [];

if (!isset($_SESSION["user_id"])) header("Location: http://".$_SERVER["SERVER_NAME"]);


if (isset($_GET["id"])) {
    $post_query = " SELECT posts.*, 
                    post_images.url AS image_url,

                    users.id AS user_id,
                    users.username,
                    banners.url AS banner_url,
                    avatars.url AS avatar_url,
                    users.bio

                    FROM posts 
                    LEFT JOIN users
                    ON posts.author_id = users.id
                    LEFT JOIN banners
                    ON users.banner_id = banners.id
                    LEFT JOIN avatars
                    ON users.avatar_id = avatars.id

                    LEFT JOIN post_images
                    ON posts.image_id = post_images.id
                    WHERE posts.id = ".$_GET["id"];

    if ($post_result = mysqli_query($conn, $post_query)) {
        while ($post_row = mysqli_fetch_array($post_result)) {
            
            if ($post_row["user_id"] == $_SESSION["user_id"] || $_SESSION["role"] == 1) {



?>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/header.php") ?>

<body class="">
    <div class="wrapper">
        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/sidebar.php"); ?>
        <div class="main-panel">
            <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/navbar.php"); ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="header text-center">
                        <h3 class="title">Edit your Post</h3>
                    </div>
                    <form action="/actions/edit_post.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="post_id" value="<?=$post_row["id"]?>">
                        <input type="hidden" name="user_id" value="<?=$post_row["author_id"];?>">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header card-header-primary">
                                        <h4 class="card-title">Post Details</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="post_title" class="bmd-label-floating">Post
                                                        Title</label>
                                                    <input type="text" name="post_title" id="post_title"
                                                    class="form-control" value="<?=$post_row["title"]?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="selectpicker" data-style="btn btn-primary btn-round btn-sm" id="category" name="post_category">
                                                        <option disabled>Category</option>
                                                        <option <?=($post_row["category"] == "Web Development") ? "selected" : "" ?> value="Web Development">Web Development</option>
                                                        <option <?=($post_row["category"] == "Graphic Design") ? "selected" : "" ?> value="Graphic Design">Graphic Design</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="post_description"
                                                        class="bmd-label-floating">Description</label>
                                                    <textarea name="post_description" id="post_description" cols="30"
                                                        rows="15" class="form-control"><?=$post_row["description"]?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header card-header-rose">
                                        <h4 class="card-title">Post Image</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12 text-center mt-3">
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?=$post_row["image_url"]?>">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail">
                                                </div>
                                                <div>
                                                    <span class="btn btn-round btn-primary btn-file">
                                                        <span class="fileinput-new">Change Image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="post_image">
                                                    </span>
                                                    <br>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists"
                                                        data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="button" id="delete" class="btn btn-danger btn-fab"><i class="material-icons">delete</i></button>
                            <button type="submit" class="btn btn-rose" name="action" value="edit_post">Edit Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php 
    
            } else {
                $errors[] = "You do not have permission to edit this post.";
                $query = http_build_query(array("errors" => $errors));
                header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?" . $query);
            }

        }
    }
}
?>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/error_check.php"); ?>
<script>
$("button#delete").click(function (e) { 
  e.preventDefault();
  
  const deletePostSwal = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-danger',
      cancelButton: 'btn btn-secondary'
    },
    buttonsStyling: false
  })

  deletePostSwal.fire({
    title: 'Are you sure you would like to delete this post?',
    text: "This action is irreversible.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true
  }).then((result) => {
    if (result.value) {
        var post_id = $("input:hidden[name=post_id]").val();
        var user_id = $("input:hidden[name=user_id]").val();
            $.ajax({
              type: "POST",
              url: "/actions/edit_post.php",
              data: {action: "delete_post", post_id: post_id, user_id: user_id}

            }).done(function() {
              window.location.href = "/posts/view.php?success=Post+Successfully+Deleted";
            })
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      deletePostSwal.fire(
        'Cancelled',
        'Post has not been deleted.',
        'error'
      )
    }
  })

});
</script>
