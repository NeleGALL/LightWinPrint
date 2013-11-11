<?
echo '<br><br>';
require_once 'config.php';
require_once 'functions.php';
if (isset($_GET['day']) && isset($_GET['mode']) && isset($_GET['item'])){
include 'detail.php';
}elseif (isset($_GET['day']) && isset($_GET['mode'])){
include 'day.php';
}else{
include 'month.php';
}
?>