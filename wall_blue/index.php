<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微信上墙</title>
<script type="text/javascript" src="js/jquery.js"></script>
<link rel="stylesheet" href="css/wxwall.css" type="text/css">
<link href="style/css/wall.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body bgproperties="fixed" background="images/bg.png">
<div class="main"  >
    	<div id="header">
		<div class="headerLeft"></div>
		<div class="headerRight">
			<div class="text">
				<div class="topic"></div>
			</div>
		</div>
	</div>
	<div class="wall">
		<div class="left"></div>
		<div class="center">
			<div class="list">
				<ul id="list"></ul>
			</div>
			
		</div>
		<div class="right"></div>
	</div>
	
	<div class="mone" id="mone" onclick="viewOneHide();"></div>
	<div id="explan" style="display:none" onclick="viewExplan();"><p><b style="font-size:50px;">上墙方法：</b><br />1.微信添加微信号： <br />2.按照提示进入上墙模块发送你想说的话，通过审核后即可上墙！</p></div>
</div>
<div class="footer"></div>
<script type="text/javascript">
var base_url='http://ids-wxwall.ap01.aws.af.cm/';
var len=3;
var cur=0;//当前位置
var mtime;
var data=new Array();
data[0]=new Array('0','http://www.idsclub.org/assets/img/logo-b.png','IDs澳洲互联网俱乐部','欢迎来到微信互动墙，积极发言哦！');

//var word_id='96';
var lastid='0';
var vep=true;//查看上墙说明
var vone=false;//查看单条

function viewOneHide(){
	vone=false;
	$("#mone").hide();
}
function viewOne(cid,t)
{
	if(vone==false)
	{
		vone=true;
		var str=t.innerHTML;
		$("#mone").html(str);
		$("#mone").fadeIn(700);
	}else
	{
		vone=false;
		$("#mone").hide();
	}
}
function viewExplan()
{
	if(vep==false)
	{
		vep=true;
		$("#explan").fadeIn(700);
		//clearInterval(mtime);
	}else
	{
		vep=false;
		$("#explan").hide();
		//mtime=setInterval(messageAdd,5000);
	}
}
function messageAdd()
{
	if(cur==len)
	{
		messageData();
		return false;
	}
	var str='<li id=li'+cur+' onclick="viewOne('+cur+',this);"><div class=m1><div class=m2><div class="pic"><img src="'+data[cur][1]+'" width="100" height="100" /></div><div class="c f2"><span>'+data[cur][2]+'：</span>'+data[cur][3]+'<div class="num">'+data[cur][0]+'#</div></div></div></div></li>';
	$("#list").prepend(str);
	$("#li"+cur).slideDown(800);
	cur++;
	messageData();
}
function messageData()
{
  var url=base_url + 'wall/api.php';
	$.getJSON(url,{lastid:lastid},function(d) {
		//alert(d);return;
		if(d['ret']==1)
		{
			$.each(d['data'], function(i,v){
				data.push(new Array(v['num'],v['avatar'],v['nickname'],v['content']));
				lastid=v['num'];
				len++;
			});
		}else{
				//	alert('木有新消息..每5秒ajax一次');
					window.setTimeout('messageData();', 3000);
		}	
	});
}
function getinfo() {
	var html;
    $.getJSON(base_url + 'show_config.php', function (data) {
        if (data.status == 'ok') {
        	$('.topic').html(data.info.huati);
        	$('#explan p').html('<b style="font-size:50px;">上墙方法：</b><br />1.微信添加微信号：'+ data.info.wxh +'<br />2.发送'+ data.info.huati +'+您想说的话即可上墙！');
        }else {
        };
    });
}
window.onload=function()
{
	getinfo();
	messageAdd();
	mtime=setInterval(messageAdd,3000);
	}
</script>
	<!--<li>
		<div class="l"></div>
		<div class="r">
			<span></span>
					</div>
	</li>-->
</body>
</html>
