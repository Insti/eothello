<?php
//error_reporting(E_ALL);
ob_start();
session_start();
include_once ('inc/db_connect.php');
include_once('inc/db_players.php');
include_once('inc/db_games.php');
include_once('inc/emails.php');
include_once ('inc/validate.php');
include_once ('inc/misc.php');
?>