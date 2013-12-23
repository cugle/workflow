/**
 *waterfall.js文件
 * 瀑布流插件
 * @author    Gardenia <fooying@qq.com>
 * window.onload = function(){
 *        waterfallinit({:''})//配置参数
 *        function success(data){}//添加节点函数，返回true 
 *    }
 *只需为瀑布流初始化函数 waterfallinit
 *配置一下函数
 *父类ID：                parent:'main',
 *子类ID：                 pin:'pin',
 *判断ajax是否返回成功：    successFn:success,
 *loading显示的图片地址     loadImgSrc:'./pic/load.gif',
 *没有更多数据显示的图片地址    endImg:'./pic/end.gif',
 *数据请求地址                requestUrl:'request.php',
 *每次请求的图片数，默认15           requestNum:15,
 *选择显示时风格,可以不设置默认为1                style:4,
 *设置loading图片的ID     loadImgId:loadImg,
 *
 *
 *添加数据到html successFn函数
    function success(data){
        var oParent = document.getElementById('main'); //获取父节点
        for(i in data){
                var oPin = document.createElement('div');
                oPin.className = 'pin';
                oParent.appendChild(oPin);
                var oBox = document.createElement('div');
                oBox.className = 'box';
                oPin.appendChild(oBox);
                var oImg = document.createElement('img');
                oImg.src = './pic/'+data[i].src;
                oBox.appendChild(oImg);
        }
        return true;
    }
}
 *
 *
 **/
 function waterfallinit(json){
    var parent = json.parent;
    var pin = json.pin;
    var successFn = json.successFn;
    var loadImgSrc = json.loadImgSrc;
    var endImgSrc = json.endImgSrc;
    var requestUrl = json.requestUrl;
    var requestNum = json.requestNum ? json.requestNum:10;
    var style = json.style;
    var loadImgId = json.loadImgId;
    var endImgId = json.endImgId;
    var oParent = document.getElementById(parent); //获取父节点
 /*最初加载*/
    ajaxRequest();
 /*触动滚动条循环加载*/
    var ajaxState = true;
    var page = 0;
    var endData = true;             
    window.onscroll = function(){
        if(checkScrollSite() && ajaxState && endData){ 
            page++;
            ajaxState = false;
            ajaxRequest();
        }
    }
 /*判断数据库数据返回数据是否为空*/
    function checkData(data){
        var oParent = document.getElementById(parent); //获取父节点
        var bool = false;
        if(data[0] != undefined){
            bool = true;
        }else{
            bool = false;
        }
        return bool;
    }
 /*ajax请求*/
    function ajaxRequest(){
            $.ajax({
                type:'GET',
                url:requestUrl,
                data:'page='+ page +'&requestNum=' + requestNum,
                dataType:'json',
                beforeSend:function(){
                    if(page){
                        var aPin = getClassObj(oParent,pin); //父节点下的class子节点数组
                        var lastPinH = aPin[aPin.length-1].offsetTop+
                            Math.floor(aPin[aPin.length-1].offsetHeight);
                        
                        addImg(loadImgSrc,loadImgId);
                    }
                },
                success:function(data){
                    if(successFn(data)){
                        waterfall(parent,pin,style);
                        endData = checkData(data);
                        if(!endData){
                            addImg(endImgSrc,endImgId);
                        }
                    }
                },
                complete:function(data){
                    if(page){
                        oParent.removeChild(document.getElementById(loadImgId));
                    }    
                    ajaxState = true;
                }
            })
    }
 /*校验滚动条位置*/
    function checkScrollSite(){
        //var aPin = getClassObj(oParent,pin); //父节点下的class子节点数组
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        var documentH = document.documentElement.clientHeight; 
        return getLastH()<scrollTop+documentH ? true:false;
    }
 /*获取最末尾最短高度*/
    function getLastH(){
        var aPin = getClassObj(oParent,pin); //父节点下的class子节点数组
        var lastPinH = aPin[aPin.length-1].offsetTop+Math.floor(aPin[aPin.length-1].offsetHeight);
        return lastPinH;
    }    
    /*增加图片标签，如：loading图标*/
    function addImg(src,id){
        var loadImg = document.createElement('img');
        loadImg.src = src;
        loadImg.id  = id;
        oParent.appendChild(loadImg);
        loadImg.style.position = 'absolute';
        loadImg.style.top = getLastH() + 'px';
        loadImg.style.left = Math.floor(oParent.offsetWidth - loadImg.offsetWidth)/2 + 'px';
            
    }
 }
 /*
*瀑布流排列
*
*/
 function  waterfall(parent,pin,style){
    var oParent = document.getElementById(parent); //获取父节点
    var aPin = getClassObj(oParent,pin); //父节点下的class子节点数组
    //alert(aPin.length);
    var iPinW = aPin[0].offsetWidth; //获取固定宽度
    var num = Math.floor(oParent.offsetWidth/iPinW); //获取横向组数
    oParent.style.cssText = 'width:' + num*iPinW +'px;margin:0px auto;position:relative'; //父类具体宽度
    
    var compareAarr = [];
    var copareAll =[];
    //alert(aPin.length);
    for(var i=0;i<aPin.length;i++){ //根据子节点长度
        if(i<num){
            compareAarr[i] = aPin[i].offsetHeight;//获取每个子节点的高度
        }else{
            var minH = Math.min.apply('',compareAarr);//获取最小值
            var minKey = getMinKey(compareAarr,minH);//获取最小值的键值
            compareAarr[minKey] += aPin[i].offsetHeight;
            setmoveStyle(aPin[i],minH,aPin[minKey].offsetLeft,i,style);
        }
    }
 }
 /*
*通过class选择元素 
*/
 function getClassObj(parent,className){
    var obj = parent.getElementsByTagName('*');
    var result = [];
    for (var i = 0; i < obj.length; i++) {
        if (obj[i].className == className) {
            result.push(obj[i]);
        }
    }
    return result;
 }
 /**设置运动风格
*setmoveStyle
*@param  obj 对象
*@param  top 飞入布局 
*@param  left 飞入布局
*@param  index 
*@param  style 飞入形势选择
*1、从底下中间飞入
*2、透明度渐现
*3、从左右两边飞入
*4、从各组下渐现飞入
**/
 var startNum = 0;
 function setmoveStyle(obj,top,left,index,style){
    /*if(index <= startNum){
        return;
    }*/
    obj.style.position = 'absolute';
    switch(style){
        case 1: //从底下中间飞入
        obj.style.top = getTotalH() + 'px';
        obj.style.left = Math.floor((document.documentElement.clientWidth-obj.offsetWidth)/2) + 'px';
        $(obj).stop().animate({
            top:top,
            left:left
        },600);
        break;
        case 2://渐现
        obj.style.top = top + 'px';
        obj.style.left = left + 'px';
        obj.style.apacity = 0;
        obj.style.filter = 'alpha(opacity=0)';
        $(obj).stop().animate({
            opacity:1,
        },1000);
        break;
        case 3:
        obj.style.top = getTotalH() + 'px';
        if(index % 2){
            obj.style.left = -obj.offsetWidth + 'px';
        }else{
            obj.style.left = document.documentElement.clientWidth + 'px';
        
        }
        $(obj).stop().animate({
            top:top,
            left:left
        },1000);
        break;
        case 4:
        obj.style.top = getTotalH() + 'px';
        obj.style.left = left +'px';
        $(obj).stop().animate({
            top:top,
            left:left
        },1600);
        break;
    }
    //更新索引
    startNum = index;
 }
 /*获取滚动条的高度,总高度*/
 function getTotalH(){
    return document.documentElement.scrollHeight || document.body.scrollHeight; 
    
 }
 /** 
*获取图片数组最小值的键值
*
*/
 function getMinKey(arr,minH){
    for (key in arr) {
        if(arr[key] == minH){
            return key;
        }
    }
 }
 /*先图片返回数据从而固定布局，一般不用*/
 function callBack(w,h,imgObj){
    //alert(w+':'+h);
    imgObj.style.width = 205 + 'px';
    var scale =  w/205;
    imgObj.style.height = Math.floor(h/scale)+ 'px';
 }
 /*先返回数据固定好布局后，图像加载*/
 function loadImg(url,fn,imgObj){ 
    var img = new Image();
    img.src = url;
    if(img.complete){
        //alert(img.width);
        fn(img.width,img.height,imgObj);
    }else{
        img.onload = function(){
            fn(img.width,img.height,imgObj);
        }
    }
 }