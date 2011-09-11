FB.provide('FBML5',{parse:function(c,a){c=c||document.body;var b=1,d=function(){b--;if(b===0){a&&a();FB.Event.fire('xfbml.render');}};FB.Array.forEach(FB.XFBML._tagInfos,function(f){if(!f.xmlns)
f.xmlns='fb';var g=FB.FBML5._getDomElements(c,f.xmlns,f.localName);for(var e=0;e<g.length;e++){var h=g[e];b++;FB.XFBML._processElement(h,f,d);}});window.setTimeout(function(){if(b>0)
FB.log(b+' FBML5 tags failed to render in '
+FB.XFBML._renderTimeout+'ms.');},FB.XFBML._renderTimeout);d();},_getDomElements:function(a,e,d){var c='data-'+e,b=[],g=a.getElementsByTagName('embed');for(var h=0;h<g.length;h++)
if(g[h].hasAttribute(c)&&g[h].getAttribute(c)==d)
b.push(FB.FBML5._transform(e,g[h]));return b;},_transform:function(e,g){var a=document.createElement('div');var c=g.parentNode;for(var b=0;b<g.attributes.length;b++)
a.setAttribute(g.attributes[b].nodeName,g.attributes[b].nodeValue);c.insertBefore(a,g);c.removeChild(g);return a;}});FB_init_original=FB.init;FB.init=function(a){FB_init_original(a);if(a.fbml5)
window.setTimeout(function(){if(FB.FBML5)
FB.Dom.ready(FB.FBML5.parse);},0);};var HTMLDivElement_getAttribute_original=HTMLDivElement.prototype.getAttribute;HTMLDivElement.prototype.getAttribute=function(x)
{if(this.hasAttribute(x))
return HTMLDivElement_getAttribute_original.call(this,x);else
return HTMLDivElement_getAttribute_original.call(this,'data-'+x);};