<?php

$this['satis.config_file']       = 'config.json';
$this['gaufrette.adapter.class'] = 'Local';
$this['gaufrette.options']       = array($this['app.data_dir']);
$this['app.node_path']           = '/usr/bin/node';

$this['satis_runner'] = $this->share(function() {
    return new SatisAdmin\Runner\SatisRunner(
        $this['model_manager'],
        $this['monolog'],
        $this['app.web_dir'],
        $this['app.bin_dir'],
        $this['app.cache_dir']
    );
});
