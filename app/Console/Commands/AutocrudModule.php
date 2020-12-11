<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FilesystemIterator;

class AutocrudModule extends Command
{
    protected $signature = 'autocrud:module';
    protected $description = 'Scaffold new CMS Module';

    public $proper_name, $lowercase_name, $namespace, $module_name, $module_dir;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->ask('Please insert module name');
        $this->proper_name = ucwords($name);
        $this->module_name = str_replace(' ', '', $this->proper_name);
        $this->lowercase_name = strtolower(str_replace(' ', '_', $this->proper_name));
        $this->namespace = 'App\\Modules\\' . $this->module_name;

        //bikin module dir dulu kalau blm ada
        if(!is_dir(base_path('app/Modules'))){
            mkdir(base_path('app/Modules', 0755, true));
        }
        $base_dir = base_path('app/Modules');
        $path = realpath($base_dir . '/'.$this->module_name);
        if($path){
            $this->error('Directory ' . $path . ' is exists. Please try using another module name');
        }
        else{
            $module_dir = $base_dir .'/'.$this->module_name;
            $this->module_dir = $module_dir;
            mkdir($module_dir, 0755);
            copy_directory(__DIR__ .'/../../Core/Stubs/Modules', $module_dir);
            $this->info('Scaffolding file copied successfully');

            $this->renameAllStubToPhp();

            $this->renameModules([
            	'Exceptions/BlankException.php',
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
            	'Providers/BlankServiceProvider.php',
            	'Services/BlankInstance.php',
            ]);

            $this->changeContents([
            	'Configs/module-setting.php',
            	'Configs/permission.php',
            	'Exceptions/'.$this->module_name.'Exception.php',
                'Extenders/MigrationModifier.php',
                'Extenders/SettingGenerator.php',
            	'Extenders/SidebarGenerator.php',
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
            	'Providers/'.$this->module_name.'ServiceProvider.php',
            	'Routes/web.php',
            	'Services/'.$this->module_name.'Instance.php',
            	'Translations/en/module.php',
            	'Translations/id/module.php',
                'Views/crud.blade.php',
            ]);

            $this->info('New module has been created for you. Now you just need to register the service provider (in config/modules.php or in config/app.php) , manage migration, manage the model and skeleton.');

        }

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