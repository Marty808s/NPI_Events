<?php

define('INC', __DIR__ . '/includes');
define('XML', __DIR__ . '/xml_files');
define('PHP', __DIR__ . '/html/php');

session_start();

// Práce s logováním - kontrola s db na /php/db.php  T/F jestli je v databázi user
function setJmeno($jmeno = '')
{
    if ($jmeno)
        $_SESSION['jmeno'] = $jmeno;
    else
        unset($_SESSION['jmeno']);
}

function isUser(): bool
{
    return isset($_SESSION['jmeno']);
}