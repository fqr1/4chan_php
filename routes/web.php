<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/db',function(Request $request){
  $time_before = \Carbon\Carbon::now('America/Chicago');
  $downloaded = App\Thread::where('downloaded','!=','0')->count();
  $not_downloaded = App\Thread::where('downloaded','0')->whereNotNull('url_data')->count();
  $error = App\Thread::where('downloaded','-1')->whereNotNull('url_data')->count();
  $total_url = App\Thread::whereNotNull('url_data')->count();
  $total = App\Thread::all()->count();
  $time_after = \Carbon\Carbon::now('America/Chicago');
  $db_size = DB::select(DB::raw("
  SELECT
  sum( data_length + index_length ) / 1024 / 1024 'DataBaseSizeInMB'
  FROM information_schema.TABLES
  where table_schema = '4chan'
  GROUP BY table_schema;
"));

  $f = '/home/ubuntu/4';
      $io = popen ( '/usr/bin/du -sk ' . $f, 'r' );
      $size = fgets ( $io, 4096);
      $size = substr ( $size, 0, strpos ( $size, "\t" ) );
      pclose ( $io );
      $dir =  'Directory: ' . $f . ' => Size: ' . ($size/1000/1000).' Gb';

  return "
  <div>
    Holi
    <div>Downloaded: ".$downloaded."</div>
    <div>Not downloaded: ".$not_downloaded."</div>
    <div>Error: ".$error."</div>
    <div>Total url: ".$total_url."</div>
    <div>Total: ".$total."</div>
    <div>Time: <ul><li>Before: ".$time_before." </li><li> After: ".$time_after."</li></ul></div>
    <div>".$dir."</div>
    <div>DB Size: ". $db_size[0]->DataBaseSizeInMB." Mb</div>
  </div>
<script>
setTimeout(location.reload(),1000);

</script>
  ";
});

Route::get('/search',function(Request $request){
  return view('search');
});
