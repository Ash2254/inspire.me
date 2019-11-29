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
}
?>