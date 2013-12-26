<?php if (!defined('THINK_PATH')) exit(); if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><h3 class="f14"><span class="switchs cu on" title="<?php echo ($lang["expand_or_contract"]); ?>"></span><?php echo ($item["name"]); ?></h3>
<ul>
	<?php if(is_array($item['navs'])): $i = 0; $__LIST__ = $item['navs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><li id="_MP<?php echo ($nav["id"]); ?>" class="sub_menu"><a href="javascript:_MP(<?php echo ($nav["id"]); ?>,'<?php echo ($nav["url"]); ?>');" hidefocus="true" style="outline:none;"><?php echo ($nav["action_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul><?php endforeach; endif; else: echo "" ;endif; ?>
<script type="text/javascript">
$(".switchs").each(function(i){
	var ul = $(this).parent().next();
	$(this).click(
	function(){
		if(ul.is(':visible')){
			ul.hide();
			$(this).removeClass('on');
				}else{
			ul.show();
			$(this).addClass('on');
		}
	})
});
</script>