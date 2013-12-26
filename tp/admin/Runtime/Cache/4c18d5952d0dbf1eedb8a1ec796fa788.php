<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="off">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="__ROOT__/statics/admin/css/style.css" rel="stylesheet" type="text/css"/>
<link href="__ROOT__/statics/css/dialog.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="__ROOT__/statics/js/jquery/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="__ROOT__/statics/js/dialog.js"></script>
<title><?php echo (L("website_manage")); ?></title>
</head>
<body scroll="no">
<div id="header">
    <div class="logo"><a href="__APP__" title="<?php echo (L("website_manage")); ?>"></a></div>
    <div class="fr">
        <div class="style_but"></div>
    </div>
    <div class="col-auto" style="overflow: visible">
        <div class="log white cut_line"> <?php echo (L("hello")); ?>！<?php echo ($my_info["user_name"]); ?> [<?php echo ($admin_level["name"]); ?>]
              |  
            <a href="<?php echo ($site_root); ?>" target="_blank">[站点首页]</a>   |            
            <a href="<?php echo u('Public/logout');?>">[<?php echo (L("logout")); ?>]</a>
        </div>            
		<div class="log_right white cut_line">
	        <a target="_blank" href="www.yangyongfu.com.cn">官方网站</a>			
			<span>|</span>
			<a target="_blank" href="www.yangyongfu.com.cn">支持论坛</a>
			<span> </span>
			<a target="_blank" href="www.yangyongfu.com.cn">Provide by (yangyongfu.com.cn)</a>			
        </div>             
    </div>
    <ul class="nav white" id="top_menu">
        <?php if(is_array($top_menu)): $i = 0; $__LIST__ = $top_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li id="_M<?php echo ($val["id"]); ?>" class="top_menu">
            	<a href="javascript:_M(<?php echo ($val["id"]); ?>,'')"  hidefocus="true" style="outline:none;"><?php echo ($val["title"]); ?></a>
         	</li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</div>
<div id="content">
    <div class="left_menu fl">
        <div id="leftMain"></div>
        <a href="javascript:;" id="openClose" style="outline-style: none; outline-color: invert; outline-width: medium;" hideFocus="hidefocus" class="open" title="<?php echo ($lang["expand_or_contract"]); ?>"></a>
	 </div>
    <div class="right_main">
        <div class="crumbs">
            <div class="shortcut cu-span"> 
				<a href="<?php echo ($site_root); ?>" target="_blank">
               	 	<span><?php echo (L("site_home")); ?></span>
                </a>  
				<a href="<?php echo u('Cache/index');?>" target="right">
               		 <span><?php echo (L("flush_cache")); ?></span>
                </a></div>
            <span id="current_pos"></span>
        </div>
        <div class="rmc">
            <div class="content" style="position:relative; overflow:hidden">
                <iframe name="right" id="rightMain" src="<?php echo u('Public/main');?>" frameborder="false" scrolling="auto" style="overflow-x:hidden;border:none;" width="100%" height="auto" allowtransparency="true"></iframe>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function windowW(){
	if($(window).width()<980){
			$('#header').css('width',980+'px');
			$('#content').css('width',980+'px');
			$('body').attr('scroll','');
			$('body').css('overflow','');
	}
}
windowW();
$(window).resize(function(){
	if($(window).width()<980){
		windowW();
	}else{
		$('#header').css('width','auto');
		$('#content').css('width','auto');
		$('body').attr('scroll','no');
		$('body').css('overflow','hidden');

	}
});
window.onresize = function(){
	var heights = document.documentElement.clientHeight-110;
	document.getElementById('rightMain').height = heights;
	var openClose = $("#rightMain").height()+9;
	$('#center_frame').height(openClose+9);
	$("#openClose").height(openClose+30);
}
window.onresize();

$(function(){
	//默认载入左侧菜单
	$("#leftMain").load("<?php echo u('Public/menu', array('tag'=>'9'));?>");
	$.get("<?php echo u('Index/current_pos', array('tag'=>'9'));?>", function(data){
		$("#current_pos").html(data);
	});
	$('#top_menu li').first().addClass('on');
})

//左侧开关
$("#openClose").click(function(){
	if($(this).data('clicknum')==1) {
		$("html").removeClass("on");
		$(".left_menu").removeClass("left_menu_on");
		$(this).removeClass("close");
		$(this).data('clicknum', 0);
	} else {
		$(".left_menu").addClass("left_menu_on");
		$(this).addClass("close");
		$("html").addClass("on");
		$(this).data('clicknum', 1);
	}
	return false;
});

function _M(tag,targetUrl) {
	$.get("<?php echo u('Public/menu');?>", {tag:tag}, function(data){
		$("#leftMain").html(data);
	});

	//$("#rightMain").attr('src', targetUrl);
	$('.top_menu').removeClass("on");
	$('#_M'+tag).addClass("on");

	$.get("<?php echo u('Index/current_pos');?>", {tag:tag}, function(data){
		$("#current_pos").html(data);
	});

	//显示左侧菜单，当点击顶部时，展开左侧
	$(".left_menu").removeClass("left_menu_on");
	$("#openClose").removeClass("close");
	$("html").removeClass("on");
	$("#openClose").data('clicknum', 0);
	$("#current_pos").data('clicknum', 1);
}

function _MP(menuid,targetUrl) {
	$("#rightMain").attr('src', targetUrl);
	$('.sub_menu').removeClass("on fb blue");
	$('#_MP'+menuid).addClass("on fb blue");
	$("#current_pos").data('clicknum', 1);
	$.get("<?php echo u('Index/current_pos');?>", {menuid:menuid}, function(data){
		$("#current_pos").html(data);
	});
}

function Refresh() {
	var src = $("#rightMain").attr('src');
	$("#rightMain").attr('src',src);
}
</script>
<pin:load type="js" href="__STATIC__/js/jquery/plugins/jquery.tools.min.js,__STATIC__/js/jquery/plugins/jquery.masonry.js,__STATIC__/js/jquery/plugins/formvalidator.js,__STATIC__/js/fileuploader.js,__STATIC__/js/pinphp.js,__STATIC__/js/front.js,__STATIC__/js/dialog.js,__STATIC__/js/wall.js,__STATIC__/js/item.js,__STATIC__/js/user.js,__STATIC__/js/album.js" />
</body>
</html>