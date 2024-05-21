<?php
function successBox($param){
    echo '<div class="alert alert-success" role="alert">' . $param . '</div>';
}

function errorBox($param){
    echo '<div class="alert alert-danger" role="alert">' . $param . '</div>';
}