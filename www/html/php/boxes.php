<?php
function successBox($param){
    echo ' <div class="container mb-5">';
    echo '<div class="alert alert-success" role="alert">' . $param . '</div>';
    echo '</div>';
}

function errorBox($param){
    echo ' <div class="container mb-5">';
    echo '<div class="alert alert-danger" role="alert">' . $param . '</div>';
    echo '</div>';
}