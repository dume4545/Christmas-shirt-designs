<?php
session_start();
const DB=['localhost','root','','frontrow']; // edit for your host
const CATS=['Politics','Business','Tech','Culture','Sport','Opinion'];
$db=new mysqli(...DB);$db->set_charset('utf8mb4');
function e($s){return htmlspecialchars($s??'',ENT_QUOTES);}
function csrf(){return $_SESSION['t']??=bin2hex(random_bytes(16));}
function check(){hash_equals(csrf(),$_POST['t']??'')||die('Session expired. Go back and retry.');}
function q($sql,$ty='',...$a){global $db;$s=$db->prepare($sql);if($ty)$s->bind_param($ty,...$a);$s->execute();return $s;}
function rows($s){return $s->get_result()->fetch_all(MYSQLI_ASSOC);}
function mins($r){return max(1,ceil(str_word_count($r['body'])/200));}
function img($r){return 'data-c="'.e($r['category']).'"'.($r['image_url']?' style="background-image:url('.e($r['image_url']).')"':'');}
function item($r){return '<a class="item" href="article.php?s='.e($r['slug']).'"><div><span class="cat">'.e($r['category']).'</span><h3>'.e($r['title']).'</h3><p class="ex">'.e($r['excerpt']).'</p><span class="meta">'.date('M j',strtotime($r['created_at'])).', '.mins($r).' min read</span></div><div class="img" '.img($r).'></div></a>';}
function head($t='The Front Row Africa',$c=''){?>
<!doctype html><html lang="en"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=e($t)?></title>
<script>try{document.documentElement.dataset.t=localStorage.t||(matchMedia('(prefers-color-scheme:dark)').matches?'dark':'light')}catch(e){}</script>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Newsreader:opsz,wght@6..72,400;6..72,600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css"><div id="bar"></div>
<header><div class="w"><div class="top"><a class="logo" href="index.php">The Front Row <i>Africa</i></a>
<form class="s" action="index.php"><input id="q" name="s" value="<?=e($_GET['s']??'')?>" placeholder="Search stories (press /)" aria-label="Search stories"></form>
<button class="ic" id="th" aria-label="Switch light or dark theme">◐</button></div>
<nav><a href="index.php" class="<?=$c?'':'on'?>">Latest</a><?php foreach(CATS as $k)echo '<a href="index.php?c='.$k.'" class="'.($c==$k?'on':'').'">'.$k.'</a>';?></nav></div></header><main class="w">
<?php }
function foot(){?></main><footer class="w">© <?=date('Y')?> The Front Row Africa. Stories from the continent, first.</footer><script src="assets/app.js"></script><?php }
