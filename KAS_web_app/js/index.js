$(function() {
	startTime();
});
function startTime() {
var today=new Date();
var h=today.getHours();
var m=today.getMinutes();
var s=today.getSeconds();
h=checkTime(h);
m=checkTime(m);
s=checkTime(s);
document.getElementById('ctime').innerHTML=h+":"+m+":"+s;
t=setTimeout('startTime()',500);
}
function checkTime(i) {
    if (i<10) {
        i="0" + i;
    }
    return i;
}
function getsize() {
    <!--
    var viewportwidth;
    var viewportheight;
    if (typeof window.innerWidth != 'undefined')
    {
    viewportwidth = window.innerWidth,
    viewportheight = window.innerHeight
    }
    else if (typeof document.documentElement != 'undefined'
    && typeof document.documentElement.clientWidth !=
    'undefined' && document.documentElement.clientWidth != 0)
    {
    viewportwidth = document.documentElement.clientWidth,
    viewportheight = document.documentElement.clientHeight
    }
    else
    {
    viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
    viewportheight = document.getElementsByTagName('body')[0].clientHeight
    }
    document.write(viewportwidth+'x'+viewportheight);
    //-->
}