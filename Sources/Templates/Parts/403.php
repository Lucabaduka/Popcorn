<?php

$title    = "403: Access Denied";
$subtitle = "You do not have the authority to be here.";
$text     = "You have just tried to do something that requires admin permissions, however there are actually checks to verify
             that you really do have those permissions.<br><br>(You do not, by the way)";

include $pages . "page.php";

?>