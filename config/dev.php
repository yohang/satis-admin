<?php

$config = require __DIR__.'/prod.php';

$this['env']               = 'dev';
$this['debug']             = true;
$this['satis.config_file'] = 'config_dev.json';

$this['satis_runner'] = $this->share(function() {
    return new SatisAdmin\Runner\NullRunner($this['monolog']);
});
