<?php
setcookie("MC-token", "", 0, route, domain, false, true);
header("Location: ".route."/");
