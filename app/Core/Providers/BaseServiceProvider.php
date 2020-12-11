<?php
namespace App\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Foundation\AliasLoader;

class BaseServiceProvider extends ServiceProvider
{

    protected function registerFacadeAlias($alias_name, $target){
        AliasLoader::getInstance()->alias($alias_name, $target);
    }

    protected function mergeConfigLists($arr=[]){
        foreach($arr as $cfg_name => $path){
            $this->mergeConfigFrom($path, $cfg_name);
        }
    }


	protected function mergeConfigFrom($path, $key)
    {
        $config = $this->app['config']->get($key, []);
        $this->app['config']->set($key, $this->mergeConfig(require $path, $config));
    }
    /**
     * Merges the configs together and takes multi-dimensional arrays into account.
     *
     * @param  array  $original
     * @param  array  $merging
     * @return array
     */
    protected function mergeConfig(array $original, array $merging)
    {
        $array = array_merge($original, $merging);
        foreach ($original as $key => $value) {
            if (! is_array($value)) {
                continue;
            }
            if (! Arr::exists($merging, $key)) {
                continue;
            }
            if (is_numeric($key)) {
                continue;
            }
            $array[$key] = $this->mergeConfig($value, $merging[$key]);
        }
        return $array;
    }

    protected function loadHelpers($dir)
    {
        foreach (glob($dir.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

}