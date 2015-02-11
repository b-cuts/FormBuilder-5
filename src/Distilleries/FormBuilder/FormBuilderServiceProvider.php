<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 11/02/2015
 * Time: 10:38 AM
 */

namespace Distilleries\FormBuilder;

use Illuminate\Support\ServiceProvider;
use Distilleries\FormBuilder\FormBuilder;
use Distilleries\FormBuilder\FormHelper;

class FormBuilderServiceProvider extends ServiceProvider {


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Distilleries\FormBuilder\Console\FormMakeCommand');

        $this->registerFormHelper();

        $this->app->bindShared('laravel-form-builder', function ($app) {

            return new FormBuilder($app, $app['laravel-form-helper']);
        });
    }

    protected function registerFormHelper()
    {
        $this->app->bindShared('laravel-form-helper', function ($app) {

            $configuration = $app['config']->get('laravel-form-builder::config');

            return new FormHelper($app['view'], $app['request'], $configuration);
        });

        $this->app->alias('laravel-form-helper', 'Distilleries\FormBuilder\FormHelper');
    }

    public function boot()
    {
        $this->package('distilleries/laravel-form-builder');
    }

    /**
     * @return string[]
     */
    public function provides()
    {
        return ['laravel-form-builder'];
    }

}