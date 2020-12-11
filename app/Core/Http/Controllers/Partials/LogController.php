<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Models\LogMaster;
use App\Core\Presenters\BaseViewPresenter;

trait LogController
{

    public function log(){
        $title = 'Log';

        $active_log = $this->request->active_log;
        $available_log = $this->getAvailableFileLog();
        $log_size = $this->getLogSize();

        $stored_log_count = LogMaster::where('is_reported', 0)->count();
        $reported_stored_log_count = LogMaster::where('is_reported', 1)->count();
        $stored_log = LogMaster::where('is_reported', 0)->orderBy('created_at', 'DESC')->take(30)->get([
            'id', 'url', 'type', 'description', 'file_path', 'is_reported', 'created_at'
        ]);

        $selected_menu = 'log';
        $presenter = (new BaseViewPresenter)->with(compact(
            'title',
            'available_log',
            'active_log',
            'log_size',
            'stored_log',
            'stored_log_count',
            'reported_stored_log_count',
            'selected_menu'
        ))->setView('core::pages.log');
        return $presenter->render();
    }

    public function logDetail($id){
        $data = LogMaster::find($id);
        if(empty($data)){
            abort(404);
        }

        $title = 'Log Detail';
        return view('core::pages.log-detail', compact(
            'data',
            'title'
        ));
    }

    public function logMarkAsReported(){
        $changed = LogMaster::where('is_reported', 0)->update([
            'is_reported' => 1
        ]);

        if($changed){
            $msg = $changed .' error report has been marked as reported';
        }
        else{
            $msg = 'All error report has been marked';
        }

        return redirect()->route('admin.log.index')->with('success', $msg);
    }



    public function getLogSize(){
        $this->request->active_log;
        $ava = $this->getAvailableFileLog();
        if(in_array($this->request->active_log, $ava)){
            $filepath = $this->logPath($this->request->active_log);
            return filesize_formatted($filepath);
        }
        return false;
    }

    public function getFileLog($filename=''){
        $available = $this->getAvailableFileLog();
        if(strlen($filename) > 0){
            if(in_array($filename, $available)){
                $logpath = $this->logPath($filename);
                if(is_file($logpath)){
                    return file_get_contents($logpath);
                }
            }
        }
        return false;
    }


    public function getAvailableFileLog(){
        $path = $this->logPath();
        if(is_dir($path)){
            $list = scandir($path);
            //buang . , .. , .gitignore , laravel.log
            $list = array_values(array_diff($list, [
                '.',
                '..',
                '.gitignore'
            ]));

            if($list){
                return $list;
            }
        }
        return [];
    }

    protected function logPath($path=''){
        return storage_path('logs') . (strlen($path) > 0 ? '/'.$path : '');
    }


    public function logExport(){
        $active_log = $this->request->active_log;
        $file_log = $this->logPath($active_log);
        if(strlen($file_log) > 0){
            return response()->download($file_log);
        }
    }

}