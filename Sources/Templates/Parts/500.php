<?php

$title    = "500: Internal Server Error";
$subtitle = "<i>*brain explodes*</i>";
$text     = "The popcorn software encountered an error which prevented the last request from completing. This is worth reporting
             to an admin if one can be located. Be sure to include the following:<br><code>" . $e->getMessage() . "</code>";

include $pages . "page.php";

?>