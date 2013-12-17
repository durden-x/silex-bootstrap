<?php

setlocale(LC_TIME, 'fr_FR.utf8', 'fra');

// Registration SILEX
require __DIR__ . '/../src/app.php';

require __DIR__ . '/hook.php';
require __DIR__ . '/routes.php';