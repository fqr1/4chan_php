<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
#use Illuminate\Support\Facades\Redis;
class fillDB extends Command
{
  /**
  * The name and signature of the console command.
  *
  * @var string
  */
  protected $signature = 'threads:fill';

  /**
  * The console command description.
  *
  * @var string
  */
  protected $description = 'Command description';

  /**
  * Create a new command instance.
  *
  * @return void
  */
  public function __construct()
  {
    parent::__construct();
  }

  /**
  * Execute the console command.
  *
  * @return mixed
  */
  public function handle()
  {
    echo "aaaaaaa\n";
// aco b gif hc hr r s t
    $boards = [
      't' => 'threads',
      'hc'=>'harcdore',
      'gif'=>'gif',
      's'=>'girl',
      'b' =>'random',
      'hr'=>'high resolition',
      'r'=> 'request',

      'aco'=> 'cartoons',


    ];
    while(true){
      foreach ($boards as $board => $value) {
        echo "Consulting thread $board\n";
        $this->getThreadsFromBoard($board);
        sleep(2);
      }
    }

    /*
    $job_hc = (new \App\Jobs\FillThreads('hc'))->onQueue('hc');
    dispatch($job_hc);

    $job_ = (new \App\Jobs\FillThreads('hc'))->onQueue('hc');
    dispatch($job_hc);

    $job_hc = (new \App\Jobs\FillThreads('hc'))->onQueue('hc');
    dispatch($job_hc);

    $job_hc = (new \App\Jobs\FillThreads('hc'))->onQueue('hc');
    dispatch($job_hc);
    */
    #Queue::push('FillThreads', array('message' => 'Time: '.time()));// this will push job in queue
    echo "bbbbbbbb\n";
  }

  public function getThreadsFromBoard($board){
    try{
      $r = \Httpful\Request::get("http://a.4cdn.org/".$board."/threads.json")
      ->autoparse(false)
      ->expectsJson()
      ->send();
    }catch(\Exception $e){
      echo "There was a problem consulting 4chan tread\n";
      sleep(15*60);
      return;
    }

    $response = json_decode($r);

    foreach($response as $page){
      foreach ($page->threads as $key => $thread_main) {
        $thread_id = $thread_main->no;
        echo "Thread no. ".$thread_id." $board\n";
        $this->getResponsesFromThread($thread_id,$board);

        sleep(2);
      }
    }
  }

  #private
  public
  function getResponsesFromThread($thread_id,$board){
    try{
      $response_tread_raw =
      \Httpful\Request::get("http://a.4cdn.org/".$board.
      "/thread/".$thread_id.".json")
      ->autoparse(false)
      ->expectsJson()
      ->send();
    }catch(\Exception $e){
      echo "There was a problem consulting 4chan tread\n";
      sleep(15*60);
      return;
    }
    echo "Decoding... \n";
    $response_tread = json_decode($response_tread_raw);
    $posts = [];
    if(isset($response_tread->posts)){
      foreach ($response_tread->posts as $key => $post) {

        //delete
        $posts[] = $post;

        $this->getInfoFromComment($key,$post,$board,$thread_id);
      }
    }
    return $posts;
  }

  #private
  public
  function getInfoFromComment($key,$post,$board,$thread_id){

    $values = [
      "now",
      "name",
      "com",
      "filename",
      "ext",
      "w",
      "h",
      "tn_w",
      "tn_h",
      "tim",
      "time",
      "md5",
      "fsize",
      "resto",
      "bumplimit",
      "imagelimit",
      "semantic_url", //only the first thread
      "replies",
      "images",
      "unique_ips",
    ];

    $th = new \App\Thread();
    $th->thread_id = $thread_id;
    $th->board = $board;
    $th->reply_id=  isset($post->no) ? $post->no : null;// as no.

    /*
    $th->now
    $th->name
    $th->com
    $th->filename
    $th->ext
    $th->w
    $th->h
    $th->tn_w
    $th->tn_h
    $th->tim
    $th->time
    $th->md5
    $th->fsize
    $th->resto
    $th->bumplimit
    $th->imagelimit
    $th->semantic_url //only the first thread
    $th->replies
    $th->images
    $th->unique_ips
    */

    foreach ($values as $value) {
      $th->$value = isset($post->$value) ? $post->$value : null;
    }
    if($th->tim && $th->ext){
      $th->url_data = 'http://i.4cdn.org/'.$board.'/'.$th->tim.$th->ext;
    }

    //$th->save();
    //*
    try{
      $th->save();
    }catch(\Exception $e){
      //echo "Exception \n";
    }
    //*/

  }
}
