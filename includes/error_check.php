<?php
if(isset($_GET["errors"])) {
    foreach($_GET["errors"] as $error) {
        ?>
        <script>
          $.notify({
            icon: "priority_high",
            message: "<?=$error?>"
          },{
            type: 'danger',
            delay: 20000
          });
        </script>
        <?php
    }
} elseif (isset($_GET["success"])) {
    ?>
    <script>
      $.notify({
        icon: "check",
        message: "<?=$_GET["success"]?>"
      },{
        type: 'success',
        delay: 20000
      });
    </script>
    <?php
}
?>