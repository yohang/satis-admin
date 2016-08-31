<?php

$config = require __DIR__.'/prod.php';

$this['env']               = 'dev';
$this['debug']             = true;
$this['satis.config_file'] = 'config_dev.json';
