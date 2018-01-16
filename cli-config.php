<?php
$app = require __DIR__.'/src/app.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($app['em']); 
