<?php
// Boxy pro případné zprávy - Success/Error
function successBox($param){
    echo ' <div class="container mt-5 mb-5" style="display:none;" id="successBox">';
    echo '<div class="alert alert-success" role="alert">' . $param . '</div>';
    echo '</div>';
    echo '<script>$("#successBox").fadeIn();</script>'; // Fadein efekt JS
}

function errorBox($param){
    echo ' <div class="container mt-5 mb-5" style="display:none;" id="errorBox">';
    echo '<div class="alert alert-danger" role="alert">' . $param . '</div>';
    echo '</div>';
    echo '<script>$("#errorBox").fadeIn();</script>';
}