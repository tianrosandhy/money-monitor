<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutocrudPresenter extends Command
{

    protected $signature = 'autocrud:presenter';
    protected $description = 'Create presenter autocrud in module';

    public 
        $module_name,
        $presenter_name;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //
        do{
            $this->module_name = $this->ask('Where do you want to create the Presenter class?');
        }while(strlen($this->module_name) == 0);

        $this->module_name = ucfirst($this->module_name);
        if(strtolower($this->module_name) == 'core'){
            $this->mpath = 'Core';
        }
        else{
            $this->mpath = 'Modules/'.$this->module_name;
        }
        $namespace = 'App/' . $this->mpath.'/Presenters';

        $try_location = base_path('app/'.$this->mpath);
        if(is_dir($try_location)){
            do{
                $this->presenter_name = $this->ask('Type your Presenters classname');
            }while(strlen($this->presenter_name) == 0);

            $this->presenter_name = ucfirst($this->presenter_name);
            $this->createProcessCopy();
            return $this->info('Presenter class has been made in "'.$namespace.'/'.$this->presenter_name.'"');
        }
        else{
            return $this->error('Module name "'.$this->module_name.'" is not exists.');
        }    
    }


    public function createProcessCopy(){
        $savepath = base_path('app/'.$this->mpath.'/Presenters/'.$this->presenter_name.'.php');
        if(is_file($savepath)){
            $this->error('File ' . $savepath .' is already exists.');
            die();
        }

        $namespace = 'App\\' . $this->mpath.'\\Presenters';
        $stub_path = base_path(config('module-setting.stubs.presenter'));
        $stub_file = fopen($stub_path, 'r');
        $stub_content = fread($stub_file, filesize($stub_path));
        $stub_content = str_replace('[CURRENT_NAMESPACE]', $namespace, $stub_content);
        $stub_content = str_replace('[CLASSNAME]', $this->presenter_name, $stub_content);
        fclose($stub_file);

        file_put_contents($savepath, $stub_content);
    }

}