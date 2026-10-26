const d=document,R=d.documentElement,$=i=>d.getElementById(i);
$('th').onclick=()=>{R.dataset.t=R.dataset.t=='dark'?'light':'dark';try{localStorage.t=R.dataset.t}catch(e){}};
const b=$('bar');addEventListener('scroll',()=>b.style.width=scrollY/(R.scrollHeight-innerHeight||1)*100+'%',{passive:true});
d.addEventListener('keydown',e=>{if(e.key=='/'&&!/INPUT|TEXTAREA|SELECT/.test(e.target.tagName)){e.preventDefault();$('q').focus()}});
const c=$('cp');c&&(c.onclick=()=>navigator.clipboard.writeText(location.href).then(()=>c.textContent='Link copied'));
