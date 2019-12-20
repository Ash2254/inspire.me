<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/header.php") ?>

<body class="">
  <div class="wrapper">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/sidebar.php"); ?>
    <div class="main-panel">
      <?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/navbar.php"); ?>

        <div id="carousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carousel" data-slide-to="0" class="active"></li>
            <li data-target="#carousel" data-slide-to="1"></li>
            <li data-target="#carousel" data-slide-to="2"></li>
            <li data-target="#carousel" data-slide-to="3"></li>
            <li data-target="#carousel" data-slide-to="4"></li>
          </ol>
          <div class="carousel-inner">
            <?php
            
            $carousel_query = "SELECT posts.title, posts.id, post_images.url AS image_url FROM posts
                               LEFT JOIN post_images
                               ON post_images.id = posts.image_id
                               ORDER BY id DESC
                               LIMIT 5";

            $carousel_result = mysqli_query($conn, $carousel_query);

            $times_run = 0;
            while ($carousel_row = mysqli_fetch_array($carousel_result)) {
              $times_run++;
            ?>
            <div class="carousel-item <?=($times_run == 1) ? "active" : "" ?>">
              <a href="/posts/view.php?id=<?=$carousel_row["id"]?>">
                <img class="d-block w-100" src="<?=$carousel_row["image_url"]?>" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                  <h5><?=$carousel_row["title"]?></h5>
                </div>
              </a>
            </div>
            <?php 
            }
            ?>
          </div>
          <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
      </div>
    </div>
  </div>



<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php") ?>