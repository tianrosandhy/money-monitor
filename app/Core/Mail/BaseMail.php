<?php
namespace App\Core\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

class BaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public 
        $subject,
        $precontent,
        $title,
        $subheader,
        $top_description,
        $content,
        $button,
        $unsubscribe_url,
        $additional_footer,
        $additional_view,
        $file,
        $var,
        $new_params,
        $rep;

    // dynamic property setter & getter
    public function __call($name, $arguments){
        $method = substr($name, 0, 3);
        if(in_array($method, ['get', 'set'])){
            $prop = substr($name, 3);
            $prop = Str::snake($prop);

            if($method == 'get' && property_exists($this, $prop)){
                return $this->{$prop};
            }
            if($method == 'set' && isset($arguments[0])){
                $this->{$prop} = $arguments[0];
            }
            if($method == 'has'){
                $cond = isset($this->{$prop});
                if($cond){
                    return !empty($cond);
                }
                return false;
            }
        }
        return $this;
    }

    public function build(){
        $objvar = get_object_vars($this);
        $exclude  = [
            'html', 'view', 'textView', 'viewData', 'callbacks', 'connection', 'queue', 'chainConnection', 'chainQueue', 'delay', 'chained'
        ];
        foreach($exclude as $exc){
            if(isset($objvar[$exc])){
                unset($objvar[$exc]);
            }
        }

        $output = $this
            ->subject($this->subject)
            ->view('core::mail.master')
            ->with($objvar);

        if(!empty($this->rep)){
            $output = $output->replyTo($this->rep);
        }

        if(!empty($this->file)){
            foreach($this->file as $file){
                $output = $output->attach($file);
            }
        }

        return $output;
    }

}