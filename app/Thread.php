<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //

    public static function link(){

      $threads = self::whereNotNull('semantic_url')->get();

      foreach ($threads as $key => $thread) {
        $board = $thread->board;
        $base_dir = getenv('BASE_URL');
        $thread_id = $thread->thread_id;
        $semantic_url = $thread->semantic_url;

        $old_url = $base_dir.$board.'/'.$thread_id;
        $new_url = $base_dir.$board.'/'.$semantic_url;

        echo 'Old: '.$old_url."\nNew:".$new_url."\n\n";
        if(!file_exists($new_url)){
          symlink($old_url,$new_url);
        }

        //symlink('/home/ubuntu/4/hc/1002455','/home/ubuntu/4/hc/always-wanted-to-know-more-about-this-girl');
        //file_exists('/home/ubuntu/4/hc/always-wanted-to-know-more-about-this-girl');
      }

      return self::whereNotNull('semantic_url')->count();
    }
}
