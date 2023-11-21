<?php
//error_reporting(0);

include 'config.php';
if (isset($_POST["vn"])) { $query=$_POST["vn"];    }else{ $query='';}
if (isset($_POST["domain"])) { $domain=$_POST["domain"];    }else{ $domain='';}
if (isset($_POST["Keyword"])) { $Keyword=$_POST["Keyword"];    }else{ $Keyword='';}


 function getemail($Keyword,$query,$domain,$GOOGLE_CSE_CX,$GOOGLE_API_KEY){
   

   $pages = isset($_POST["pages"])?$_POST["pages"]:10;
   $gl = isset($_POST["gl"])?$_POST["gl"]:"us";
   $hl = isset($_POST["hl"])?$_POST["hl"]:"en";



$found='';
 for ($page = 1;$page <= $pages && $found == false;$page++){
  $start =($page-1)*10+1 ; 

	$obj = json_decode(file_get_contents("https://www.googleapis.com/customsearch/v1?q=site:$domain+'$Keyword'+$query&cx=$GOOGLE_CSE_CX&key=$GOOGLE_API_KEY&hl=$hl&gl=$gl&start=$start"));
	foreach ($obj->items as $idx=>$item) {
$text= $item->snippet;
    if (!empty($text)) {
  $res = preg_match_all(
    "/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i",
    $text,
    $matches
  );

  if ($res) {
    foreach(array_unique($matches[0]) as $email) {
      echo $email . "\n";
    }
  }
    }}
}}






?>

<!DOCTYPE html>
<html dir="">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
 <head>
    <title>Email Extractor</title>  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>
<body>
<style type="text/css">
  html,body{
        height: 100%;
        background:#EEEEEE;
      }
 
</style>

  
<div class="container">

    
  <div style="padding-top:5%;"class="row">
    <div class="col-sm-4">
  <form action="index.php" method="POST">
    <div class="card ">
    <div class="card-header  "><h5> email extractor   </h5></div>
    <div class="card-body">
   <div class="mb-3">
    <label class="form-label"for="email"> Keyword </label>

    <input name="Keyword" value="<?php echo $Keyword ?>" type="text" class="form-control" placeholder="Keyword" required />
    </div>

  <div class="mb-3">
    <label class="form-label"for="email"> Domain </label>

    <input name="domain" value="<?php echo $domain ?>" type="text" class="form-control" placeholder="domain.com"  required/>
    </div>
  <div class="mb-3">

<label class="form-label"for="provider"> provider </label>

    <input name="vn" value="<?php echo $query ?>" type="text" class="form-control" placeholder="@domain.com" required />
    </div>  
  
 
   <div class="mb-3">
  <div class="btn-list">
 <button class="btn btn-primary w-100"> Extract Emails </button>

 </div> </form>
              </div>
             
    </div></div></div>
    <div class="col-sm-8">
      <?php if (isset($_POST['vn'])) {?>
      <textarea class="form-control" rows="10" style="width: 100%;height:500px;background:#22203c;color:#fff;">
          <?php   getemail($_POST['Keyword'],$_POST['vn'],$_POST['domain'],$GOOGLE_CSE_CX,$GOOGLE_API_KEY)  ?>  </textarea>  <?php }else {?>

              <div class="empty">
              <div class="empty-img"><center><img style="width: 50%;height:300px;" src="img/9318694.png" height="128" alt=""></center>
              </div>
              <center><h4> No results found </h4></center>
              <center><h6 class="empty-subtitle text-muted">
                Try adjusting your search or filter to find what youre looking for
              </h6></center>
              
            </div>

       <?php }?>

           </div>
    </div></div>
    </div>
</div>
