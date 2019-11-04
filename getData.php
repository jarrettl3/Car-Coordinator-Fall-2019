<?php
session_start();
if(isset($_SESSION['fname'])){
    echo json_encode($_SESSION['fname']);
}else{
    echo 'UNKNOWN';
}
?>