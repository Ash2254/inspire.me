<?php
if(isset($_GET["errors"])) {
    foreach($_GET["errors"] as $error) {
        echo "<div class='alert alert-danger'>".$error."</div>";
    }
}

?>