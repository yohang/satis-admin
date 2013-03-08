<?php

$config = require __DIR__.'/dev.php';

$this['env']   = 'test';
$this['debug'] = true;

$this['gaufrette.adapter.class'] = 'InMemory';
$this['gaufrette.options']       = array(
    array(
        $this['satis.config_file'] => array(
            'mtime'   => time(),
            'content' => <<<EOF
{
    "name": "Test repository",
    "homepage": "https://github.com/yohang",
    "repositories": [
        { "type": "vcs", "url": "https://github.com/yohang/CalendR.git" },
        { "type": "vcs", "url": "https://github.com/yohang/Finite.git" },
        { "type": "vcs", "url": "https://github.com/frequence-web/OOSSH.git" }
    ]
}
EOF
        )
    )
);
