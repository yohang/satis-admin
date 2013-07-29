<?php

use Assetic\Asset\AssetCache;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;
use Assetic\AssetManager;
use Assetic\Cache\FilesystemCache;
use Assetic\FilterManager;
use Assetic\Filter\CoffeeScriptFilter;
use Assetic\Filter\LessFilter;
use Assetic\Filter\UglifyJs2Filter;
use SatisAdmin\Application;


$this['assetic.filter_manager'] = $this->share(
    $this->extend('assetic.filter_manager', function(FilterManager $fm) {
        $lessFilter = new LessFilter($this['app.node_path'], array(__DIR__ . '/../node_modules'));

        $fm->set('less', $lessFilter);
        $fm->set('coffee', new CoffeeScriptFilter(__DIR__.'/../node_modules/.bin/coffee', $this['app.node_path']));

        if (!$this['debug']) {
            $lessFilter->setCompress(true);
            $fm->set('uglify_js', new UglifyJs2Filter(__DIR__.'/../node_modules/.bin/uglifyjs', $this['app.node_path']));
        }

        return $fm;
    })
);

$this['assetic.asset_manager'] = $this->share(
    $this->extend('assetic.asset_manager', function(AssetManager $am) {
        $fm = $this['assetic.filter_manager'];

        $am->set('styles', new AssetCache(
            new FileAsset($this['app.resources_dir'].'/less/global.less', [$fm->get('less')]),
            new FilesystemCache($this['app.cache_dir'].'/assetic')
        ));
        $am->get('styles')->setTargetPath('css/styles.css');

        $am->set('scripts', new AssetCache(
            new AssetCollection(
                array(
                    new GlobAsset(array($this['app.components_dir'].'/jquery/jquery.js')),
                    new GlobAsset(array($this['app.resources_dir'].'/coffee/*.coffee'), array($fm->get('coffee'))),
                ),
                $this['debug'] ? [] : [$fm->get('uglify_js')]
            ),
            new FilesystemCache($this['app.cache_dir'].'/assetic')
        ));
        $am->get('scripts')->setTargetPath('js/scripts.js');

        return $am;
    })
);
