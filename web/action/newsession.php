<?php

include '../init.php';

Logins::newSession();

header("Location: ../index.php");
