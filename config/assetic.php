<?php

use Assetic\Asset\AssetCache;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\GlobAsset;
use Assetic\AssetManager;
use Assetic\Cache\FilesystemCache;
use Assetic\FilterManager;
use Assetic\Filter\CoffeeScriptFilter;
use Assetic\Filter\LessFilter;

return array(
    'assetic.path_to_web' => $this['app.web_dir'],
    'assetic.options' => array(
        'debug'            => $this['debug'],
        'auto_dump_assets' => $this['debug'],
    ),
    'assetic.filters' => $this->protect(function(FilterManager $fm) {
        $fm->set('less', new LessFilter($this['app.node_path'], array(__DIR__.'/../node_modules')));
        $fm->set('coffee', new CoffeeScriptFilter(__DIR__.'/../node_modules/.bin/coffee', $this['app.node_path']));
    }),
    'assetic.assets' => $this->protect(function(AssetManager $am, FilterManager $fm) {
        $am->set('styles', new AssetCache(
            new GlobAsset(
                array(
                    $this['app.components_dir'].'/bootstrap/less/bootstrap.less'
                ),
                array($fm->get('less'))
            ),
            new FilesystemCache($this['app.cache_dir'].'/assetic')
        ));
        $am->get('styles')->setTargetPath('css/styles.css');

        $am->set('scripts', new AssetCache(
            new AssetCollection(
                array(
                    new GlobAsset(array($this['app.components_dir'].'/jquery/jquery.js')),
                    new GlobAsset(array($this['app.resources_dir'].'/coffee/*.coffee'), array($fm->get('coffee'))),
                )
            ),
            new FilesystemCache($this['app.cache_dir'].'/assetic')
        ));
        $am->get('scripts')->setTargetPath('js/scripts.js');
    })
);
