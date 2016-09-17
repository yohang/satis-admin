<?php

namespace SatisAdmin;

use Bt51\Silex\Provider\GaufretteServiceProvider\GaufretteServiceProvider;
use Monolog\Logger;
use SatisAdmin\Controller\DefaultController;
use SatisAdmin\Model\ModelManager;
use Silex\Application as BaseApplication;
use Silex\Application\MonologTrait;
use Silex\Application\SecurityTrait;
use Silex\Application\TwigTrait;
use Silex\Application\UrlGeneratorTrait;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use SilexAssetic\AsseticServiceProvider;

/**
 * The Application.
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class Application extends BaseApplication
{
    use MonologTrait, SecurityTrait, TwigTrait, UrlGeneratorTrait;

    /**
     * {@inheritDoc}
     */
    public function __construct($env, array $values = [])
    {
        parent::__construct($values);

        $this->registerConfig($env);
        $this->registerProviders();
        $this->registerServices();
        $this->registerControllers();
        $this->bindEvents();
    }

    protected function registerConfig($env)
    {
        $this['env']                = $env;
        $this['app.root_dir']       = realpath(__DIR__.'/../..');
        $this['app.cache_dir']      = $this['app.root_dir'].'/cache';
        $this['app.bin_dir']        = $this['app.root_dir'].'/vendor/composer/satis/bin';
        $this['app.config_dir']     = $this['app.root_dir'].'/config';
        $this['app.components_dir'] = $this['app.root_dir'].'/bower_components';
        $this['app.data_dir']       = $this['app.root_dir'].'/data';
        $this['app.logs_dir']       = $this['app.root_dir'].'/logs';
        $this['app.resources_dir']  = $this['app.root_dir'].'/resources';
        $this['app.web_dir']        = $this['app.root_dir'].'/web';
        $this['app.users_file']     = $this['app.config_dir'].'/users.json';
        $this['app.env_settings_file']  = $this['app.config_dir'].'/env_settings.json';

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
        $this->register(new MonologServiceProvider, require $this['app.config_dir'].'/monolog.php');
        $this->register(new SecurityServiceProvider, require $this['app.config_dir'].'/security.php');
        $this->register(new ServiceControllerServiceProvider);
        $this->register(new TranslationServiceProvider);
        $this->register(new UrlGeneratorServiceProvider);
        $this->register(new ValidatorServiceProvider);
        $this->register(
            new TwigServiceProvider,
            [
                'debug'               => $this['debug'],
                'twig.path'           => $this['app.resources_dir'].'/views',
                'twig.options'        => ['cache' => $this['app.cache_dir'].'/twig'],
                'twig.form.templates' => ['form/form_div_layout.html.twig'],
            ]
        );
        $this->register(
            new AsseticServiceProvider,
            [
                'assetic.path_to_web' => $this['app.web_dir'],
                'assetic.options' => [
                    'debug'            => $this['debug'],
                    'auto_dump_assets' => $this['debug'],
                ],
            ]
        );
        require $this['app.config_dir'].'/assetic.php';

        if ($this['debug']) {
            $this->register(
                $profiler = new WebProfilerServiceProvider,
                [
                    'profiler.cache_dir' => $this['app.cache_dir'].'/profiler',
                ]
            );
            $this->mount('/_profiler', $profiler);
        }
    }

    protected function bindEvents()
    {
    }
}
