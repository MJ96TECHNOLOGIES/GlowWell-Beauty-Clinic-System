<?php

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

?>