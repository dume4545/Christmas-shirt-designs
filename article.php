<?php require 'inc.php';
$r=rows(q('SELECT * FROM posts WHERE slug=?','s',$_GET['s']??''))[0]??null;
if(!$r){http_response_code(404);head('Not found');echo '<h1 class="nf">That story is not here.</h1><a class="btn" href="index.php">Back to latest stories</a>';foot();exit;}
q('UPDATE posts SET views=views+1 WHERE id=?','i',$r['id']);
$rel=rows(q('SELECT * FROM posts WHERE category=? AND id<>? ORDER BY created_at DESC LIMIT 3','si',$r['category'],$r['id']));
head($r['title'].' — The Front Row Africa',$r['category']);?>
<article class="art"><a class="cat" href="index.php?c=<?=e($r['category'])?>"><?=e($r['category'])?></a>
<h1><?=e($r['title'])?></h1><p class="lead"><?=e($r['excerpt'])?></p>
<div class="meta"><?=date('F j, Y',strtotime($r['created_at']))?>, <?=mins($r)?> min read, <?=number_format($r['views']+1)?> views</div>
<?php if($r['image_url'])echo '<div class="img wide" '.img($r).'></div>';?>
<div class="body"><?php foreach(preg_split('/\R{2,}/',trim($r['body'])) as $x)echo '<p>'.nl2br(e($x)).'</p>';?></div>
<button id="cp">Copy link</button></article>
<?php if($rel){echo '<h2 class="sec">More in '.e($r['category']).'</h2><div class="more">';foreach($rel as $x)echo item($x);echo '</div>';}foot();
