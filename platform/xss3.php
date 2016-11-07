<?php

require('../utils/DB.php');
$db = new DB();
if ($_POST) {
    $db->add($_POST['name'], $_POST['phone']);
}
if ($_GET['delete']) {
    $db->remove($_GET['delete']);
}
$contacts = $db->all();
