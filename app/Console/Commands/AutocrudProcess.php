<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutocrudProcess extends Command
{

    protected $signature = 'autocrud:process';
    protected $description = 'Create process autocrud in module';

    public 
        $module_name,
        $processor_name;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //
        do{
            $this->module_name = $this->ask('Where do you want to create the Process class?');
        }while(strlen($this->module_name) == 0);

        $this->module_name = ucfirst($this->module_name);
        if(strtolower($this->module_name) == 'core'){
            $this->mpath = 'Core';
        }
        else{
            $this->mpath = 'Modules/'.$this->module_name;
        }
        $namespace = 'App/' . $this->mpath.'/Http/Process';

        $try_location = base_path('app/'.$this->mpath);
        if(is_dir($try_location)){
            do{
                $this->processor_name = $this->ask('Type your Process classname');
            }while(strlen($this->processor_name) == 0);

            $this->processor_name = ucfirst($this->processor_name);
            $this->createProcessCopy();
            return $this->info('Process class has been made in "'.$namespace.'/'.$this->processor_name.'"');
        }
        else{
            return $this->error('Module name "'.$this->module_name.'" is not exists.');
        }
    }

    public function createProcessCopy(){
        $savepath = base_path('app/'.$this->mpath.'/Http/Process/'.$this->processor_name.'.php');
        if(is_file($savepath)){
            $this->error('File ' . $savepath .' is already exists.');
            die();
        }

        $namespace = 'App\\' . $this->mpath.'\\Http\\Process';
        $stub_path = base_path(config('module-setting.stubs.process'));
        $stub_file = fopen($stub_path, 'r');
        $stub_content = fread($stub_file, filesize($stub_path));
        $stub_content = str_replace('[CURRENT_NAMESPACE]', $namespace, $stub_content);
        $stub_content = str_replace('[CLASSNAME]', $this->processor_name, $stub_content);
        fclose($stub_file);

        file_put_contents($savepath, $stub_content);
    }
}
