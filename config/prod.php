<?php

$this['satis.config_file']       = 'config.json';
$this['gaufrette.adapter.class'] = 'Local';
$this['gaufrette.options']       = array($this['app.data_dir']);
$this['app.node_path']           = is_file('/usr/bin/node') ? '/usr/bin/node' : '/usr/local/bin/node';

if (!is_file($this['app.env_settings_file'])) {
    file_put_contents($this['app.env_settings_file'], json_encode([]));
}
$settings = json_decode(file_get_contents($this['app.env_settings_file']), true);
if ($settings) {
    foreach ($settings as $key => $value) {
        putenv(sprintf('%s=%s', $key, $value));
    }
}

$this['satis_runner'] = $this->share(function() {
    return new SatisAdmin\Runner\SatisRunner(
        $this['model_manager'],
        $this['monolog'],
        $this['app.web_dir'],
        $this['app.bin_dir'],
        $this['app.cache_dir']
    );
});
