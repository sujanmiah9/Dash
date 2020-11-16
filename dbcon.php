<?php
define('DNS', 'localhost;');
define('DB_NAME', 'kodeeo');
define('DB_USER', 'root');
define('DB_PASS', '');

try{
    $db = new PDO("mysql:host=".DNS."dbname=".DB_NAME, DB_USER,DB_PASS);
}catch(PDOException $e){
    echo "Erorr". $e->getMessage();
}
?>