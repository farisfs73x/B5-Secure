<?php

/** @var Connection $connection */
$connection = require_once 'connection_notes.php';

$connection->removeNote($_POST['id']);

header('Location: notes.php');
