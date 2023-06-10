<?php
session_start();


session_destroy();

header('Location: connexion.html');
http_response_code(302);
echo("hello");
?>