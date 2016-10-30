<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use \App\Thread;

class searchController extends BaseController{


  public function getSearch($words,$boards){
    \Log::warning('Search');
    $words = "%$words%";
    $boardsArray = $this->boardsArray($boards);
    $result = Thread::where('com','like',$words)
    ->whereIn('board',$boardsArray)
    ->get();

    return json_encode($result);
  }

  public function getSearchThread($thread){
    \Log::warning('Search Thread');
    //$boardsArray = $this->boardsArray($boards);
    $result = Thread::whereThreadId($thread)
    //->whereIn('board',$boardsArray)
    ->get();

    return json_encode($result);
  }

  private function boardsArray($boards){
    $newBoards = [];
    $bs = explode(',',$boards);
    //$whereIn = '';
    foreach ($bs as $key => $b) {
      $new_b = explode('=',$b);

      if($new_b[1] === 'true'){
        $newBoards[] = $new_b[0];
      }
      //$newBoards[$new_b[0]] = $new_b[1];

    }

    return $newBoards;
  }


}
