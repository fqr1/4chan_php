<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class getData extends Command
{
  //private $board = null;

  /**
  * The name and signature of the console command.
  *
  * @var string
  */
  protected $signature = 'data:get {board}';

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
    //$this->board = $board;
  }

  /**
  * Execute the console command.
  *
  * @return mixed
  */
  public function handle()
  {
$board = $this->argument('board');

if(!$board){Echo "No board specified, will consult all";$board ='';}

    $base_dir = getenv('BASE_URL');
    //$base_dir = '/home/ubuntu/4/';

    $finished = false;
    $offset = 0;
    $limit=100;
    while(true){
    while(!$finished){
      echo "Getting data...\n";
      $threads = \App\Thread::whereNotNull('url_data')
      //->where('board','aco')
      ->where('downloaded','0')
      ->where('board','like',$board)
      ->orderBy('thread_id','asc')
      ->limit($limit)
      //->offset($offset)
      ->get();
      $offset += $limit;

      if($threads->count() < 1){
        $finished = true;
        continue;
      }

      foreach ($threads as $thread) {
        $board = $thread->board;
        $title = $thread->thread_id;
        $url = $thread->url_data;

        if(!is_dir($base_dir.$board)){
          mkdir($base_dir.$board);
        }

        if (!is_dir($base_dir.$board.'/'.$title)) {
          echo 'creating dir '.$title." in board ".$board."\n";
          mkdir($base_dir.$board.'/'.$title);
        }

        $path_to_save = $base_dir .$board.'/'. $title . '/' . $thread->tim . $thread->ext;

        //symlink('/home/ubuntu/4/hc/1002455','/home/ubuntu/4/hc/always-wanted-to-know-more-about-this-girl');
        //file_exists('/home/ubuntu/4/hc/always-wanted-to-know-more-about-this-girl');

        try {
              if(!file_exists($path_to_save)) {
            echo "[".\Carbon\Carbon::now("America/Mexico_city")."] Saving... ".$path_to_save."\n";
            file_put_contents($path_to_save, fopen($url, 'r'));
            sleep(1);
            //$thread->downloaded=true;
            //$thread->save();
          }

          $thread->downloaded=true;
          $thread->save();
        }catch(\Exception $e){
          echo "Exception\n";
          \Log::warning('Data exception',compact('url','path_to_save'));
          \Log::error($e);
            $thread->downloaded=-1;
            $thread->save();
        }
      }
    }
    echo "FINISHED! will sleep for 15 min \n";
  sleep(5*60);
  $finished = false;
  }
  }
}
