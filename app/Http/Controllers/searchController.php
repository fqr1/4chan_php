<?php
namespace App\Http\Controllers;

class searchController extends BaseController(){
  public function getSearch($words){
    $result = App\Thread::where('com','like',$words)->get();


  }
}
