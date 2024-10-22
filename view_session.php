

<?php
session_start();
echo '<h1>Session Variables</h1>';
echo '<pre>';
print_r($_SESSION['test']);
echo '</pre>';
?>
