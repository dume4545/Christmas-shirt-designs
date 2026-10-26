<?php require 'inc.php';
$c=in_array($_GET['c']??'',CATS)?$_GET['c']:'';$s=trim($_GET['s']??'');$p=max(1,(int)($_GET['p']??1));$n=8;
$w='1=1';$t='';$a=[];
if($c){$w.=' AND category=?';$t.='s';$a[]=$c;}
if($s!==''){$w.=' AND (title LIKE ? OR excerpt LIKE ?)';$t.='ss';$a[]=$a[]="%$s%";}
$hero=(!$c&&!$s)?(rows(q('SELECT * FROM posts ORDER BY featured DESC,created_at DESC LIMIT 1'))[0]??null):null;
if($hero){$w.=' AND id<>?';$t.='i';$a[]=$hero['id'];}
$tot=rows(q("SELECT COUNT(*) c FROM posts WHERE $w",$t,...$a))[0]['c'];
$list=rows(q("SELECT * FROM posts WHERE $w ORDER BY created_at DESC LIMIT $n OFFSET ".(($p-1)*$n),$t,...$a));
$top=rows(q('SELECT title,slug FROM posts ORDER BY views DESC LIMIT 5'));
$qs=http_build_query(array_filter(['c'=>$c,'s'=>$s]));
head($c?"$c — The Front Row Africa":'The Front Row Africa',$c);
if($hero&&$p==1){?>
<section class="hero"><div class="tx"><span class="cat"><?=e($hero['category'])?></span><h1><?=e($hero['title'])?></h1><p class="ex"><?=e($hero['excerpt'])?></p><a class="btn" href="article.php?s=<?=e($hero['slug'])?>">Read the story</a></div><div class="img" <?=img($hero)?>></div></section>
<?php }?>
<div class="cols"><section><?php
if($s!=='')echo '<h2 class="sec">'.$tot.' result'.($tot==1?'':'s').' for “'.e($s).'”</h2>';
elseif($c)echo '<h2 class="sec">'.e($c).'</h2>';
if(!$list)echo '<p class="empty">No stories here yet. Try another category or a different search.</p>';
foreach($list as $r)echo item($r);
echo '<div class="pg">';if($p>1)echo '<a class="btn alt" href="?'.$qs.'&p='.($p-1).'">Newer stories</a>';if($p*$n<$tot)echo '<a class="btn" href="?'.$qs.'&p='.($p+1).'">Older stories</a>';echo '</div>';?></section>
<aside><h2 class="sec">Most read</h2><ol class="top"><?php foreach($top as $r)echo '<li><a href="article.php?s='.e($r['slug']).'">'.e($r['title']).'</a></li>';?></ol></aside></div>
<?php foot();
