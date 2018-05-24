<?php
    include_once('../config.php');
    if(isset($_POST['action']) && $_POST['action'] == 'availability'){
        echo mysqli_num_rows(mysqli_query($baglanti,"select * from admin where kuladi='".$_POST['username']."'");
    }
?>