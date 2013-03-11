<?php

namespace SatisAdmin;

use Bt51\Silex\Provider\GaufretteServiceProvider\GaufretteServiceProvider;
use SatisAdmin\Controller\DefaultController;
use SatisAdmin\Model\ModelManager;
use Silex\Application as BaseApplication;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use SilexAssetic\AsseticExtension;

/**
 * The Application.
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class Application extends BaseApplication
{
    /**
     * {@inheritDoc}
     */
    public function __construct($env, array $values = array())
    {
        parent::__construct($values);

        $this->registerConfig($env);
        $this->registerProviders();
        $this->registerServices();
        $this->registerControllers();
    }

    protected function registerConfig($env)
    {
        $this['app.root_dir']       = realpath(__DIR__.'/../..');
        $this['app.cache_dir']      = $this['app.root_dir'].'/cache';
        $this['app.config_dir']     = $this['app.root_dir'].'/config';
        $this['app.components_dir'] = $this['app.root_dir'].'/components';
        $this['app.data_dir']       = $this['app.root_dir'].'/data';
        $this['app.resources_dir']  = $this['app.root_dir'].'/resources';
        $this['app.web_dir']        = $this['app.root_dir'].'/web';

        require sprintf('%s/%s.php', $this['app.config_dir'], $env);
    }

    protected function registerServices()
    {
        $this['model_manager'] = $this->share(function() {
            return new ModelManager($this['gaufrette.filesystem'], $this['satis.config_file']);
        });
    }

    protected function registerControllers()
    {
        $this->mount('/', new DefaultController);
    }

    protected function registerProviders()
    {
        $this->register(new FormServiceProvider);
        $this->register(new GaufretteServiceProvider);
        $this->register(new ServiceControllerServiceProvider);
        $this->register(new TranslationServiceProvider);
        $this->register(new UrlGeneratorServiceProvider);
        $this->register(new ValidatorServiceProvider);
        $this->register(
            new TwigServiceProvider,
            array(
                'debug'               => $this['debug'],
                'twig.path'           => $this['app.resources_dir'].'/views',
                'twig.options'        => array('cache' => $this['app.cache_dir'].'/twig'),
                'twig.form.templates' => array('form/form_div_layout.html.twig')
            )
        );
        $this->register(new AsseticExtension, require $this['app.config_dir'].'/assetic.php');

        if ($this['debug']) {
            $this->register(
                $profiler = new WebProfilerServiceProvider,
                array(
                    'profiler.cache_dir' => $this['app.cache_dir'].'/profiler',
                )
            );
            $this->mount('/_profiler', $profiler);
        }
    }
}
