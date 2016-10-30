$(document).ready(function(){
  console.log("asd");

  inputs = [
    $('#gif'),
    $('#aco'),
    $('#hr'),
    $('#hc'),
    $('#s'),
    $('#b'),
    $('#r'),
  ];


  $('#query_button').click(function(){
    
    $result = $('#result').empty();
    $('#more_info').empty();

    var val = $('#query_input').val();
    if(val == ''){
      alert('Error, input required');
      return;
    }
    console.log('Query clicked!');
    getAjax('search/'+val+'/'+getInputs());

  });

  $('#thread_button').click(function(){

    $result = $('#result').empty();
    $('#more_info').empty();

    var val = $('#thread_input').val();
    if(val == ''){
      alert('Error, input required');
      return;
    }
    console.log('Thread clicked!');
    getAjax('search/thread/'+val);
  });


  $('#check').click(function(){
    $val = $('#check').is(":checked");
    console.log($val);

    //$('#options').toggle();
    $opt = $('#options');
    $val ? $opt.show() : $opt.hide();
    //$('#options').show($val);

  });

});

function getAjax($url){
  $.ajax({
    url:$url,
    type: 'get',
    dataType: 'json',
    success: function(data){
      console.log("Sucess",data);

        $('#more_info').append("Total: "+data.length);

      data.forEach(insertField);
    },
    error: function(data){
      console.error("Error",data);
    }

  });
};

function getInputs(){
  $arr = [];
  $s = '';
  inputs.forEach(function(e){
    $id =$(e).attr('id');
    $val =  $(e).is(":checked");

    if(! $('#check').is(":checked")){
      $val = true;
    }

    $s += $id+'='+$val+',';
    //$arr[$(e).attr('id')] = $(e).is(":checked");
    //console.log($(e).attr('id'), $(e).is(":checked"))

  });
  $s = $s.substring(0,$s.length - 1);
  return $s;
}


function insertField(data){
  $result = $('#result');

$main = $('<div>',{style:'margin-top: 50px;border-style: solid;border-color: gray;'});
$result.append($main);

$left = $('<div>',{style:'display:inline-block'});
$right = $('<div>',{style:'display:inline-block'});

$left_top = $('<div>',{style:'border-bottom: gray;border-bottom-style: dashed;'});
$left_bottom = $('<div>',{html:data.com});
$left.append($left_top,$left_bottom);

$p1 = $('<p>',{text:'thread:'+data.thread_id});
$p2 = $('<p>',{text:'board:'+data.board});
$p3 = $('<p>',{text:'downloaded:'+data.downloaded});
$p4 = $('<p>',{text:'url data:'+data.url_data});
$p5 = $('<p>',{text:'semantic_url:'+data.semantic_url,style:'color:red'});
$left_top.append($p1,$p2);

if(data.semantic_url != null){
  $left_top.append($p5);
}

if(data.url_data != null){
  $left_top.append($p3,$p4);
}

if(data.url_data != null){
  $img = $('<img>',{src:data.url_data,style:'width: 100%'});
  $img = $('<img>',{src:'4/'+data.board+'/'+data.thread_id+'/'+data.tim+data.ext,style:'width: 100%'});
  $right.append($img);
}

$main.append($left,$right);



}
