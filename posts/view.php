<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/header.php"); ?>

<body class="">
    <div class="wrapper">
        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/sidebar.php"); ?>
        <div class="main-panel">
            <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/navbar.php"); ?>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <?php 
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
                                while($post_row = mysqli_fetch_array($post_result)):
                                    $banner = $post_row["banner_url"];
                                    $avatar = $post_row["avatar_url"];
                                    $bio    = $post_row["bio"];
                                    $user_id= $post_row["user_id"];

                                    $tag_query  = "SELECT user_tags.*, tags.* FROM user_tags
                                            LEFT JOIN tags
                                            ON user_tags.tag_id = tags.id
                                            WHERE user_tags.user_id = $user_id";
                                    
                                    if ($tag_request = mysqli_query($conn, $tag_query)) {
                                        while ($tag_row = mysqli_fetch_array($tag_request)) {
                                            $tags[] = $tag_row["name"];
                                            $tag_ids[] = $tag_row["id"];
                                        }
                                    }
                        ?>
                            <div class="card">
                                <img src="<?=$post_row["image_url"]?>" alt="" class="card-img">
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <h2 class="text-center">Post Info</h2>
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="text-center card-title"><?=$post_row["title"]?></h3>
                                            <p class="category text-center">
                                                Posted on  
                                                <?=date("l, F jS, Y @ g:ia", strtotime($post_row["date_created"]))?>
                                                <?=($post_row["date_created"] != $post_row["date_modified"]) ? "<br>Last updated on ".date("l, F jS, Y @ g:ia", strtotime($post_row["date_modified"])) : "" ?>
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><?=$post_row["description"]?></p>
                                        </div>
                                        <?php if($post_row["author_id"] == $_SESSION["user_id"] || $_SESSION["role"] == 1) { ?>
                                        <div class="card-footer">
                                            <div class="ml-auto">
                                                <a href="/posts/edit.php?id=<?=$post_row["id"]?>" class="btn btn-warning btn-fab btn-round" data-toggle="tooltip" data-placement="top" title="Edit"><i class="material-icons">edit</i></a>
                                                <button id="delete" type="button" class="btn btn-danger btn-fab btn-round" data-toggle="tooltip" data-placement="top" title="Delete"><i class="material-icons">delete</i></button>
                                                <input type="hidden" name="user_id" value="<?=$post_row["author_id"]?>">
                                                <input type="hidden" name="post_id" value="<?=$post_row["id"]?>">
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h2 class="text-center">Author</h2>
                                    <div class="card card-profile">
                                        <?=($banner) ? "<img class=\"card-img-top\" src=\"$banner\">" : false ?>
                                        <div class="card-avatar">
                                        <a href="/profile/view.php?id=<?=$post_row["author_id"]?>">
                                            <img class="img" src="<?=($avatar) ? $avatar : "/assets/img/placeholder.jpg"?>" alt="<?=$post_row["username"]?>'s Avatar"/>
                                        </a>
                                        </div>

                                        <div class="card-body">
                                        <h4 class="card-title"><?=$post_row["username"]?></h4>
                                        <h6 class="card-category">
                                            <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/tags.php"); ?>
                                        </h6>
                                        <p class="card-description">
                                            <?=$bio?>
                                        </p>
                                        <a href="/profile/view.php?id=<?=$post_row["author_id"]?>" class="btn btn-rose btn-round">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>






                        <?php
                                endwhile;
                            }

                        } else {
                            $search_query = (isset($_GET["search"])) ? $_GET["search"] : false;

                            if ($search_query) {
                                echo "<h1 class='d-inline'>Search results for: $search_query <a href='/posts/view.php' class='d-inline-block btn btn-rose ml-2 mb-3'>Clear Search</a></h1>";
                            } else {
                                echo "<h1>Posts</h1>";
                            }

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
                                            ON posts.author_id = users.id";
                            $search ="";
                            if ($search_query) {
                                $search =" WHERE posts.title LIKE '%$search_query%'
                                        OR posts.description LIKE '%$search_query%'";
                                $post_query .= $search;
                            }

                            $current_page = (isset($_GET["page"])) ? $_GET["page"] : 1;
                            $limit = 6;
                            $offset = $limit * ($current_page - 1);

                            $post_query.= "  ORDER BY posts.date_created DESC
                                                LIMIT $limit OFFSET $offset"; 


                            if ($post_result = mysqli_query($conn, $post_query)) {

                                $pagi_query = "SELECT COUNT(*) AS total FROM posts";

                                if ($search_query) {
                                    $pagi_query .= $search;
                                }
                                $pagi_result = mysqli_query($conn, $pagi_query);
                                $pagi_row = mysqli_fetch_array($pagi_result);
                                $total_posts = $pagi_row["total"];

                                $page_count = ceil($total_posts / $limit);

                                echo "<nav><ul class='pagination'>";

                                $get_search = ($search_query) ? "&search=".$search_query : "";

                                if ($current_page > 1) {
                                    echo "<li class='page-item'><a class='page-link' href='/posts/view.php?page=".($current_page - 1)."$get_search'>Previous</a></li>";
                                } else {
                                    echo "<li class='page-item'><span class='page-link'>Previous</span></li>";
                                }

                                for ($i = 1; $i <= $page_count; $i++) {
                                    echo "<li class='page-item";
                                    if ($current_page == $i) echo " active"; 
                                    echo "'><a class='page-link' href='/posts/view.php?page=$i".$get_search."'>$i</a></li>";
                                }

                                if ($current_page < $page_count) {
                                    echo "<li class='page-item'><a class='page-link' href='/posts/view.php?page=".($current_page + 1)."$get_search'>Next</a></li>";
                                } else {
                                    echo "<li class='page-item'><span class='page-link'>Next</span></li>";
                                }

                                echo "</ul></nav>";

                                while ($post_row = mysqli_fetch_array($post_result)) {
                        
                        ?>
                    </div>

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
                                    <a href="?id=<?=$post_row["id"]?>" class="btn btn-default btn-link" rel="tooltip"
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
                                    <a href="?id=<?=$post_row["id"]?>"><?=$post_row["title"]?></a>
                                </h4>
                                <div class="card-description">
                                    <?=$post_row["description"]?>
                                </div>
                                <div class="text-center mt-3">
                                    <?php 
                                    if ($post_row["author_id"] == $_SESSION["user_id"]) {
                                        echo "<a href=\"?id=".$post_row["id"]."\" class=\"btn btn-rose btn-round\">View Your Post</a>";
                                    } else {
                                        echo "<a href=\"?id=".$post_row["id"]."\" class=\"btn btn-primary btn-round\">View Post</a>";
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
                        <?php 
                                    }
                                }
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>


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