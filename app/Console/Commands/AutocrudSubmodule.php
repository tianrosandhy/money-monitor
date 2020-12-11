<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FilesystemIterator;

class AutocrudSubmodule extends Command
{
    protected $signature = 'autocrud:submodule';
    protected $description = 'Scaffold CMS Sub Module';

    public $proper_name, $lowercase_name, $namespace, $old_module_name, $module_name, $module_dir;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
    	$old_module = $this->ask('Please insert your existing module name : ');

    	$this->old_module_name = ucwords($old_module);
    	$this->old_module_name = str_replace(' ', '', $this->old_module_name);
        $this->namespace = 'App\\Modules\\' . $this->old_module_name;
        if(!$this->isOldModuleExists()){
        	return $this->error('Old Module name ' . $this->old_module_name . ' is not exists');
        }


        $name = $this->ask('Please insert your new submodule name');
        $this->proper_name = ucwords($name);
        $this->module_name = str_replace(' ', '', $this->proper_name);
        $this->lowercase_name = strtolower(str_replace(' ', '_', $this->proper_name));

        $base_dir = base_path('app/Modules/' . $this->old_module_name .'/');
        $path = realpath($base_dir);
        if(!$path){
            $this->error('Directory ' . $path . ' is not exists. We cannot generate submodule in non existent directory');
        }
        else{
        	$this->module_dir = $path;
            copy_directory(__DIR__ .'/../../Core/Stubs/SubModules', $this->module_dir);
            $this->info('Scaffolding file copied successfully');

            $this->renameAllStubToPhp();

            $this->renameModules([
            	'Facades/BlankFacade.php',
            	'Http/Controllers/BlankController.php',
            	'Http/Process/BlankCrudProcess.php',
            	'Http/Process/BlankDatatableProcess.php',
            	'Http/Process/BlankDeleteProcess.php',
            	'Http/Skeleton/BlankSkeleton.php',
                'Migrations/2020_06_20_000000_blank.php',
                'Migrations/2020_06_20_000000_blank_translator.php',
                'Models/Blank.php',
                'Models/BlankTranslator.php',
            	'Presenters/BlankCrudPresenter.php',
            	'Presenters/BlankIndexPresenter.php',
            	'Services/BlankInstance.php',
            ]);

            $this->changeContents([
            	'Facades/'.$this->module_name.'Facade.php',
            	'Http/Controllers/'.$this->module_name.'Controller.php',
            	'Http/Process/'.$this->module_name.'CrudProcess.php',
            	'Http/Process/'.$this->module_name.'DatatableProcess.php',
            	'Http/Process/'.$this->module_name.'DeleteProcess.php',
            	'Http/Skeleton/'.$this->module_name.'Skeleton.php',
                'Migrations/2020_06_20_000000_'.$this->lowercase_name.'.php',
                'Migrations/2020_06_20_000000_'.$this->lowercase_name.'_translator.php',
                'Models/'.$this->module_name.'.php',
                'Models/'.$this->module_name.'Translator.php',
            	'Presenters/'.$this->module_name.'CrudPresenter.php',
            	'Presenters/'.$this->module_name.'IndexPresenter.php',
            	'Services/'.$this->module_name.'Instance.php',
            ]);

            $this->info('New submodule scaffold has been created for you. Now you just need to define : SidebarGenerator, Routes, Translations, ');

        }

    }

    protected function isOldModuleExists(){
    	return file_exists(base_path('app/Modules/' . $this->old_module_name));
    }


    protected function renameAllStubToPhp(){
        $path = $this->module_dir;
        $di = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        //rename .stub -> .php
        foreach($di as $fname => $fio) {
            $file_full_path = $fio->getPath() . DIRECTORY_SEPARATOR . $fio->getFilename();
            if(strpos($file_full_path, '.stub') !== false){
                rename($file_full_path, str_replace('.stub', '.php', $file_full_path));
            }
        }
    }

    protected function renameModule($module_path){
        $first_char = substr($module_path, 0, 1);
        if(!in_array($first_char, ['/', '\\', DIRECTORY_SEPARATOR])){
            $module_path = DIRECTORY_SEPARATOR . $module_path;
        }

        $rename_path = str_replace('blank', $this->lowercase_name, $module_path);
        $rename_path = str_replace('Blank', $this->module_name, $rename_path);
        $rename_path = str_replace('.stub', '.php', $rename_path);

        rename($this->module_dir.$module_path, $this->module_dir.$rename_path);
    }


    protected function renameModules($list_of_path=[]){
        foreach($list_of_path as $path){
            $this->renameModule($path);
        }
    }

    protected function changeContents($list_of_path){
        foreach($list_of_path as $path){
            $this->changeContent($path);
        }
    }

    protected function changeContent($path){
        $first_char = substr($path, 0, 1);
        if(!in_array($first_char, ['/', '\\', DIRECTORY_SEPARATOR])){
            $path = DIRECTORY_SEPARATOR . $path;
        }

        $content = file_get_contents($this->module_dir . $path);
        $content = str_replace('[MODULE_NAME]', $this->module_name, $content);
        $content = str_replace('[LOWERCASE_MODULE_NAME]', $this->lowercase_name, $content);
        $content = str_replace('[PROPER_MODULE_NAME]', $this->proper_name, $content);
        $content = str_replace('[NAMESPACE]', $this->namespace, $content);
        file_put_contents($this->module_dir . $path, $content);
    }


}