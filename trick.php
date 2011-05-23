<?php
foreach ($_SESSION as $a => $b)	$$a = $b;

foreach ($_POST as $a => $b){
        $$a = $b;
        $_SESSION[$a] = $b;
}

foreach ($_GET as $a => $b){
        $$a = $b;
        $_SESSION[$a] = $b;
}
?>
