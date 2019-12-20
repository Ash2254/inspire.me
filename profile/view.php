<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/header.php"); ?>

<?php
// SECTION user query
$user_id = (isset($_GET["id"])) ? $_GET["id"] : $_SESSION["user_id"];

$user_query = " SELECT users.*, avatars.url AS avatar, banners.url AS banner
                FROM users 
                LEFT JOIN avatars
                ON users.avatar_id = avatars.id
                LEFT JOIN banners
                ON users.banner_id = banners.id
                WHERE users.id = " . $user_id;

$tag_query  = " SELECT user_tags.*, tags.* FROM user_tags
                LEFT JOIN tags
                ON user_tags.tag_id = tags.id
                WHERE user_tags.user_id = $user_id";

if ($user_request = mysqli_query($conn, $user_query)):
  while ($user_row = mysqli_fetch_array($user_request)):

    $tags = [];
    $tag_ids = [];
    
    if ($tag_request = mysqli_query($conn, $tag_query)) {
      while ($tag_row = mysqli_fetch_array($tag_request)) {
        $tags[] = $tag_row["name"];
        $tag_ids[] = $tag_row["id"];
      }
    }

        $username = $user_row["username"];
        $bio      = $user_row["bio"];
        $avatar   = $user_row["avatar"];
// !SECTION user query
?>

<body class="">
    <div class="wrapper">
        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/sidebar.php"); ?>
        <div class="main-panel">
            <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/navbar.php"); ?>

            <div class="content">


                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <!-- SECTION profile card -->
                            <div class="card card-profile">

                                <div class="card-header card-header-primary text-center">
                                    <div class="card-avatar mb-3">
                                        <a href="#pablo">
                                            <img class="img"
                                                src="<?=($user_row["avatar"]) ? $user_row["avatar"] : "/assets/img/placeholder.jpg"?>"
                                                alt="<?=$user_row["username"]?>'s Avatar" />
                                        </a>
                                    </div>

                                    <h1 class="card-title"><?=$user_row["username"]?></h1>
                                    <p class="category">
                                        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/tags.php"); ?>
                                    </p>

                                </div>
                                <div class="card-body container">
                                    <h4><?=$user_row["bio"]?></h4>
                                </div>

                            </div>
                            <!-- !SECTION profile card -->

                        </div>
                    </div>
                    <div class="row">
                        <?php 
                        $post_query = " SELECT 
                                        posts.id,
                                        posts.title,
                                        post_images.url AS image_url,
                                        posts.description,
                                        posts.author_id,
                                        users.username,
                                        posts.date_created,
                                        posts.date_modified
                                        FROM posts
                                        LEFT JOIN post_images
                                        ON posts.image_id = post_images.id
                                        LEFT JOIN users
                                        ON posts.author_id = users.id
                                        WHERE posts.author_id = $user_id";

                        $current_page = (isset($_GET["page"])) ? $_GET["page"] : 1;
                        $limit = 3;
                        $offset = $limit * ($current_page - 1);

                        $post_query.= "  ORDER BY posts.date_created DESC
                                            LIMIT $limit OFFSET $offset"; 


                        if ($post_result = mysqli_query($conn, $post_query)) {

                            while ($post_row = mysqli_fetch_array($post_result)) {
                        ?>
                        <div class="col-4">
                            <!-- SECTION post cards -->
                            <div class="card card-product">
                                <div class="card-header card-header-image" <?= ($post_row["author_id"] == $_SESSION["user_id"] || $_SESSION["role"] == 1) ? "data-header-animation=\"true\"" : "" ?>>
                                    <a href="#pablo">
                                        <img class="img" src="<?=$post_row["image_url"]?>">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <?php if ($post_row["author_id"] == $_SESSION["user_id"] || $_SESSION["role"] == 1) { ?>
                                    <div class="card-actions text-center">
                                        <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                            <i class="material-icons">build</i> Fix Header!
                                        </button>
                                        <a href="/posts/view.php?id=<?=$post_row["id"]?>" class="btn btn-default btn-link" rel="tooltip"
                                            data-placement="bottom" title="" data-original-title="View">
                                            <i class="material-icons">art_track</i>
                                        </a>
                                        <a href="/posts/edit.php?id=<?=$post_row["id"]?>" class="btn btn-success btn-link" rel="tooltip"
                                            data-placement="bottom" title="" data-original-title="Edit">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <button id="delete" type="button" class="btn btn-danger btn-link" rel="tooltip"
                                            data-placement="bottom" title="" data-original-title="Remove">
                                            <i class="material-icons">close</i>
                                        </button>
                                        <input type="hidden" name="user_id" value="<?=$post_row["author_id"]?>">
                                        <input type="hidden" name="post_id" value="<?=$post_row["id"]?>">
                                    </div>
                                    <?php } ?>
                                    <h4 class="card-title">
                                        <a href="/posts/view.php?id=<?=$post_row["id"]?>"><?=$post_row["title"]?></a>
                                    </h4>
                                    <div class="card-description">
                                        <?=$post_row["description"]?>
                                    </div>
                                    <div class="text-center mt-3">
                                        <?php 
                                        if ($post_row["author_id"] == $_SESSION["user_id"]) {
                                            echo "<a href=\"/posts/view.php?id=".$post_row["id"]."\" class=\"btn btn-rose btn-round\">View Your Post</a>";
                                        } else {
                                            echo "<a href=\"/posts/view.php?id=".$post_row["id"]."\" class=\"btn btn-primary btn-round\">View Post</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">access_time</i> posted on
                                        &nbsp;<span class="text-primary" data-toggle="tooltip" data-placement="top" title="<?=date("l, F jS, Y @ g:ia", strtotime($post_row["date_created"]))?>"><?=date("F jS, Y", strtotime($post_row["date_created"]))?></span>

                                    </div>
                                    <div class="stats pull-right">
                                        <?=($post_row["date_created"] != $post_row["date_modified"]) ? "<i class=\"material-icons\">update</i> last updated on &nbsp;<span class='text-primary' data-toggle='tooltip' data-placement='top' title='".date("l, F jS, Y @ g:ia", strtotime($post_row["date_modified"]))."'>".date("F jS, Y", strtotime($post_row["date_modified"])) : "";?>
                                    </div>
                                </div>
                            </div>
                            <!-- !SECTION post cards -->
                        </div>
                        <?php 
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>

        </div>
    </div>


    <?php 
    endwhile;
endif;
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
        var post_id = $(this).nextAll("input:hidden[name=post_id]").val();
        var user_id = $(this).nextAll("input:hidden[name=user_id]").val();
            $.ajax({
              type: "POST",
              url: "/actions/edit_post.php",
              data: {action: "delete_post", post_id: post_id, user_id: user_id}

            }).done(function() {
              window.location.href = "/profile/view.php?success=Post+Successfully+Deleted";
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