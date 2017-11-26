<?php
if(isset($_GET['action']))
    return $_GET['action'];
elseif (isset($_POST['action']))
    return $_POST['action'];
else
    return 'index';