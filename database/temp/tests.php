<?php
$postdata = serialize($_POST);
file_put_contents("updategjusername.txt", $postdata);
?>