<?php require 'inc.php';
$n=rows(q('SELECT COUNT(*) c FROM admins'))[0]['c'];$err='';
if(isset($_GET['out'])){session_destroy();header('Location: admin.php');exit;}
if($_SERVER['REQUEST_METHOD']=='POST'){check();$a=$_POST['a']??'';
 if($a=='setup'&&!$n&&strlen($_POST['p'])>=8){q('INSERT INTO admins(username,password_hash) VALUES(?,?)','ss',trim($_POST['u']),password_hash($_POST['p'],PASSWORD_DEFAULT));session_regenerate_id(true);$_SESSION['adm']=1;header('Location: admin.php');exit;}
 if($a=='login'){$u=rows(q('SELECT * FROM admins WHERE username=?','s',$_POST['u']))[0]??null;
  if($u&&password_verify($_POST['p'],$u['password_hash'])){session_regenerate_id(true);$_SESSION['adm']=1;header('Location: admin.php');exit;}$err='Username or password is wrong.';}
 if(!empty($_SESSION['adm'])){
  if($a=='add'&&trim($_POST['title'])!==''){$t=trim($_POST['title']);$im=filter_var($_POST['img'],FILTER_VALIDATE_URL)?:'';
   $sl=trim(strtolower(preg_replace('/[^a-z0-9]+/i','-',$t)),'-').'-'.substr(uniqid(),-5);
   q('INSERT INTO posts(title,slug,category,excerpt,body,image_url,featured) VALUES(?,?,?,?,?,?,?)','ssssssi',$t,$sl,in_array($_POST['cat'],CATS)?$_POST['cat']:'Culture',trim($_POST['ex']),trim($_POST['body']),$im,isset($_POST['f'])?1:0);}
  if($a=='del')q('DELETE FROM posts WHERE id=?','i',$_POST['id']);
  header('Location: admin.php');exit;}}
head('Admin — The Front Row Africa');$T='<input type="hidden" name="t" value="'.csrf().'">';
if(empty($_SESSION['adm'])){?>
<form method="post" class="panel narrow"><h1><?=$n?'Sign in':'Create your admin account'?></h1><?=$T?><input type="hidden" name="a" value="<?=$n?'login':'setup'?>">
<?php if($err)echo '<p class="err">'.$err.'</p>';?><label>Username<input name="u" required autofocus></label><label>Password<?=$n?'':' (8 characters or more)'?><input type="password" name="p" required minlength="<?=$n?1:8?>"></label>
<button><?=$n?'Sign in':'Create account'?></button></form>
<?php }else{$ps=rows(q('SELECT id,title,category,views,featured FROM posts ORDER BY created_at DESC'));?>
<form method="post" class="panel"><h1>Publish a story</h1><?=$T?><input type="hidden" name="a" value="add">
<label>Title<input name="title" required maxlength="200"></label>
<div class="two"><label>Category<select name="cat"><?php foreach(CATS as $k)echo "<option>$k</option>";?></select></label><label>Image link (optional)<input name="img" type="url" placeholder="https://"></label></div>
<label>Summary<input name="ex" maxlength="300" required></label>
<label>Story (a blank line starts a new paragraph)<textarea name="body" rows="10" required></textarea></label>
<label class="chk"><input type="checkbox" name="f"> Feature on the home page</label><button>Publish story</button></form>
<div class="panel"><h1>Your stories <a class="out" href="?out=1">Sign out</a></h1><table><?php foreach($ps as $r){?><tr><td><a href="index.php?s=<?=urlencode($r['title'])?>"><?=e($r['title'])?></a><br><span class="meta"><?=e($r['category'])?>, <?=$r['views']?> views<?=$r['featured']?', featured':''?></span></td>
<td><form method="post" onsubmit="return confirm('Delete this story?')"><?=$T?><input type="hidden" name="a" value="del"><input type="hidden" name="id" value="<?=$r['id']?>"><button class="alt">Delete</button></form></td></tr><?php }?></table></div>
<?php }foot();
