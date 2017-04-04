/*! formstone v1.3.2 [viewer.js] 2017-03-10 | GPL-3.0 License | formstone.it */

!function(a){"function"==typeof define&&define.amd?define(["jquery","./core","./transition"],a):a(jQuery,Formstone)}(function(a,b){"use strict";function c(){e(),X.on("scroll",e),Q=b.$body}function d(){W.iterate.call(Z,N)}function e(){Y=X.scrollTop()+b.windowHeight,Y<0&&(Y=0)}function f(){W.iterate.call(Z,I)}function g(){Z=a(T.base),Z.length?W.lockViewport(S):W.unlockViewport(S)}function h(b){var c,d="",e=[U.control,U.control_previous].join(" "),f=[U.control,U.control_next].join(" "),h=[U.control,U.control_zoom_in].join(" "),i=[U.control,U.control_zoom_out].join(" ");b.thisClasses=[U.base,U.loading,b.customClass,b.theme],b.images=[],b.source=!1,b.gallery=!1,b.tapTimer=null,b.action=!1,b.isRendering=!1,b.isZooming=!1,b.isAnimating=!1,b.keyDownTime=1,b.$images=this.find("img").addClass(U.source),b.index=0,b.total=b.$images.length-1,b.customControls="object"===a.type(b.controls)&&b.controls.zoom_in&&b.controls.zoom_out,b.$images.length>1&&(b.gallery=!0,b.thisClasses.push(U.gallery),!b.customControls||b.controls.previous&&b.controls.next||(b.customControls=!1));for(var j=0;j<b.$images.length;j++)c=b.$images.eq(j),b.images.push(c.attr("src"));d+='<div class="'+U.wrapper+'">',d+='<div class="'+U.loading_icon+'"></div>',d+='<div class="'+U.viewport+'"></div>',d+="</div>",b.controls&&!b.customControls&&(d+='<div class="'+U.controls+'">',d+='<button type="button" class="'+e+'">'+b.labels.previous+"</button>",d+='<button type="button" class="'+i+'">'+b.labels.zoom_out+"</button>",d+='<button type="button" class="'+h+'">'+b.labels.zoom_in+"</button>",d+='<button type="button" class="'+f+'">'+b.labels.next+"</button>",d+="</div>"),this.addClass(b.thisClasses.join(" ")).prepend(d),b.$wrapper=this.find(T.wrapper),b.$viewport=this.find(T.viewport),b.customControls?(b.$controls=a(b.controls.container).addClass([U.controls,U.controls_custom].join(" ")),b.$controlPrevious=a(b.controls.previous).addClass(e),b.$controlNext=a(b.controls.next).addClass(f),b.$controlZoomIn=a(b.controls.zoom_in).addClass(h),b.$controlZoomOut=a(b.controls.zoom_out).addClass(i)):(b.$controls=this.find(T.controls),b.$controlPrevious=this.find(T.control_previous),b.$controlNext=this.find(T.control_next),b.$controlZoomIn=this.find(T.control_zoom_in),b.$controlZoomOut=this.find(T.control_zoom_out)),b.$controlItems=b.$controlPrevious.add(b.$controlNext),b.$controlZooms=b.$controlZoomIn.add(b.$controlZoomOut),g(),b.$controlItems.on(V.click,b,L),b.$controlZooms.on([V.touchStart,V.mouseDown].join(" "),b,E).on([V.touchEnd,V.mouseUp].join(" "),b,H),k(b,b.images[b.index],!0),M(b)}function i(a){a.$wrapper.remove(),a.$image.removeClass(U.source),a.controls&&!a.customControls&&a.$controls.remove(),a.customControls&&(a.$controls.removeClass([U.controls,U.controls_custom].join(" ")),a.$controlItems.off(V.click).removeClass([U.control,U.control_previous,U.control_next].join(" ")),a.$controlZooms.off([V.touchStart,V.mouseDown].join(" ")).off([V.touchStart,V.mouseDown].join(" ")).off([V.touchEnd,V.mouseUp].join(" ")).removeClass([U.control,U.control_zoom_in,U.control_zoom_out].join(" "))),this.removeClass(a.thisClasses.join(" ")).off(V.namespace),g()}function j(a,b){a.index=0,"string"==typeof b?(a.total=0,a.images=[b],a.gallery=!1,a.$el.removeClass(U.gallery)):(a.total=b.length-1,a.images=b,b.length>1&&(a.gallery=!0,a.$el.addClass(U.gallery)),b=a.images[a.index]),K(a,function(){k(a,b)})}function k(b,c,d){b.isAnimating||(b.isAnimating=!0,b.$container=a('<div class="'+U.container+'"><img></div>'),b.$image=b.$container.find("img"),b.$viewport.append(b.$container),b.$image.one(V.load,function(){m(b),b.isAnimating=!1,b.$container.fsTransition({property:"opacity"},function(){}),b.$el.removeClass(U.loading),b.$container.fsTouch({pan:!0,scale:!0}).on(V.scaleStart,b,A).on(V.scaleEnd,b,C).on(V.scale,b,B),b.$el.trigger(V.loaded)}).one(V.error,b,l).attr("src",c).addClass(U.image),(b.$image[0].complete||4===b.$image[0].readyState)&&b.$image.trigger(V.load),b.source=c)}function l(a){var b=a.data;b.$el.trigger(V.error)}function m(a){n(a),o(a),a.containerTop=a.viewportHeight/2,a.containerLeft=a.viewportWidth/2,q(a),a.imageHeight=a.naturalHeight,a.imageWidth=a.naturalWidth,u(a),p(a),r(a),s(a),t(a);var b={containerTop:a.containerTop,containerLeft:a.containerLeft,imageHeight:a.imageHeight,imageWidth:a.imageWidth,imageTop:a.imageTop,imageLeft:a.imageLeft};z(a,b),a.isRendering=!0}function n(a){var b=P(a.$image);a.naturalHeight=b.naturalHeight,a.naturalWidth=b.naturalWidth,a.ratioHorizontal=a.naturalHeight/a.naturalWidth,a.ratioVertical=a.naturalWidth/a.naturalHeight,a.isWide=a.naturalWidth>a.naturalHeight}function o(a){a.viewportHeight=a.$viewport.outerHeight(),a.viewportWidth=a.$viewport.outerWidth()}function p(a){a.imageHeight<=a.viewportHeight?(a.containerMinTop=a.viewportHeight/2,a.containerMaxTop=a.viewportHeight/2):(a.containerMinTop=a.viewportHeight-a.imageHeight/2,a.containerMaxTop=a.imageHeight/2),a.imageWidth<=a.viewportWidth?(a.containerMinLeft=a.viewportWidth/2,a.containerMaxLeft=a.viewportWidth/2):(a.containerMinLeft=a.viewportWidth-a.imageWidth/2,a.containerMaxLeft=a.imageWidth/2)}function q(a){a.isWide?(a.imageMinWidth=a.viewportWidth,a.imageMinHeight=a.imageMinWidth*a.ratioHorizontal,a.imageMinHeight>a.viewportHeight&&(a.imageMinHeight=a.viewportHeight,a.imageMinWidth=a.imageMinHeight*a.ratioVertical)):(a.imageMinHeight=a.viewportHeight,a.imageMinWidth=a.imageMinHeight*a.ratioVertical,a.imageMinWidth>a.viewportWidth&&(a.imageMinWidth=a.viewportWidth,a.imageMinHeight=a.imageMinWidth*a.ratioHorizontal)),(a.imageMinWidth>a.naturalWidth||a.imageMinHeight>a.naturalHeight)&&(a.imageMinHeight=a.naturalHeight,a.imageMinWidth=a.naturalWidth),a.imageMaxHeight=a.naturalHeight,a.imageMaxWidth=a.naturalWidth}function r(a){a.imageTop=-(a.imageHeight/2),a.imageLeft=-(a.imageWidth/2)}function s(a){a.lastContainerTop=a.containerTop,a.lastContainerLeft=a.containerLeft,a.lastImageHeight=a.imageHeight,a.lastImageWidth=a.imageWidth,a.lastImageTop=a.imageTop,a.lastImageLeft=a.imageLeft}function t(a){a.renderContainerTop=a.lastContainerTop,a.renderContainerLeft=a.lastContainerLeft,a.renderImageTop=a.lastImageTop,a.renderImageLeft=a.lastImageLeft,a.renderImageHeight=a.lastImageHeight,a.renderImageWidth=a.lastImageWidth}function u(a){a.imageHeight=a.imageMinHeight,a.imageWidth=a.imageMinWidth}function v(a){a.imageHeight<a.imageMinHeight&&(a.imageHeight=a.imageMinHeight),a.imageHeight>a.imageMaxHeight&&(a.imageHeight=a.imageMaxHeight),a.imageWidth<a.imageMinWidth&&(a.imageWidth=a.imageMinWidth),a.imageWidth>a.imageMaxWidth&&(a.imageWidth=a.imageMaxWidth)}function w(a){a.containerTop<a.containerMinTop&&(a.containerTop=a.containerMinTop),a.containerTop>a.containerMaxTop&&(a.containerTop=a.containerMaxTop),a.containerLeft<a.containerMinLeft&&(a.containerLeft=a.containerMinLeft),a.containerLeft>a.containerMaxLeft&&(a.containerLeft=a.containerMaxLeft)}function x(a){null===a.tapTimer?a.tapTimer=W.startTimer(a.tapTimer,500,function(){y(a)}):(y(a),D(a))}function y(a){W.clearTimer(a.tapTimer),a.tapTimer=null}function z(a,c){if(b.transform){var d=c.imageWidth/a.naturalWidth,e=c.imageHeight/a.naturalHeight;a.$container.css(b.transform,"translate3d("+c.containerLeft+"px, "+c.containerTop+"px, 0)"),a.$image.css(b.transform,"translate3d(-50%, -50%, 0) scale("+d+","+e+")")}else a.$container.css({top:c.containerTop,left:c.containerLeft}),a.$image.css({height:c.imageHeight,width:c.imageWidth,top:c.imageTop,left:c.imageLeft})}function A(a){var b=a.data;x(b),s(b)}function B(a){var b=a.data;y(b),b.isRendering=!1,b.isZooming=!1;b.imageHeight>b.imageMinHeight+1;b.containerTop=b.lastContainerTop+a.deltaY,b.containerLeft=b.lastContainerLeft+a.deltaX,b.imageHeight=b.lastImageHeight*a.scale,b.imageWidth=b.lastImageWidth*a.scale,p(b),w(b),v(b),r(b);var c={containerTop:b.containerTop,containerLeft:b.containerLeft,imageHeight:b.imageHeight,imageWidth:b.imageWidth,imageTop:b.imageTop,imageLeft:b.imageLeft};z(b,c)}function C(a){var b=a.data;b.isZooming||(s(b),t(b),b.isRendering=!0)}function D(a){var b=a.imageHeight>a.imageMinHeight+1;a.isZooming=!0,s(a),t(a),b?(a.imageHeight=a.imageMinHeight,a.imageWidth=a.imageMinWidth):(a.imageHeight=a.imageMaxHeight,a.imageWidth=a.imageMaxWidth),p(a),w(a),r(a),a.isRendering=!0}function E(b){W.killEvent(b);var c=a(b.currentTarget),d=b.data,e=c.hasClass(U.control_zoom_out)?"out":"in";"out"===e?G(d):F(d)}function F(a){a.keyDownTime=1,a.action="zoom_in"}function G(a){a.keyDownTime=1,a.action="zoom_out"}function H(a){var b=a.data;b.action=!1}function I(a){if(a.isRendering){if(a.action){a.keyDownTime+=a.zoomIncrement;var b=("zoom_out"===a.action?-1:1)*Math.round(a.imageWidth*a.keyDownTime-a.imageWidth);b>a.zoomDelta&&(b=a.zoomDelta),a.isWide?(a.imageWidth+=b,a.imageHeight=Math.round(a.imageWidth/a.ratioVertical)):(a.imageHeight+=b,a.imageWidth=Math.round(a.imageHeight/a.ratioHorizontal)),v(a),r(a),p(a),w(a)}a.renderContainerTop+=Math.round((a.containerTop-a.renderContainerTop)*a.zoomEnertia),a.renderContainerLeft+=Math.round((a.containerLeft-a.renderContainerLeft)*a.zoomEnertia),a.renderImageTop+=Math.round((a.imageTop-a.renderImageTop)*a.zoomEnertia),a.renderImageLeft+=Math.round((a.imageLeft-a.renderImageLeft)*a.zoomEnertia),a.renderImageHeight+=Math.round((a.imageHeight-a.renderImageHeight)*a.zoomEnertia),a.renderImageWidth+=Math.round((a.imageWidth-a.renderImageWidth)*a.zoomEnertia);var c={containerTop:a.renderContainerTop,containerLeft:a.renderContainerLeft,imageHeight:a.renderImageHeight,imageWidth:a.renderImageWidth,imageTop:a.renderImageTop,imageLeft:a.renderImageLeft};z(a,c)}}function J(a){K(a)}function K(a,b){a.isAnimating||(y(a),a.isAnimating=!0,a.isRendering=!1,a.isZooming=!1,O(a),a.$container.fsTransition({property:"opacity"},function(){a.isAnimating=!1,a.$container.remove(),"function"==typeof b&&b.call(window,a)}),a.$el.addClass(U.loading))}function L(b){W.killEvent(b);var c=a(b.currentTarget),d=b.data,e=d.index+(c.hasClass(U.control_next)?1:-1);d.isAnimating||(e<0&&(e=0),e>d.total&&(e=d.total),e!==d.index&&(d.index=e,K(d,function(){k(d,d.images[d.index])})),M(d))}function M(a){a.$controlItems.removeClass(U.control_disabled),0===a.index&&a.$controlPrevious.addClass(U.control_disabled),a.index===a.images.length-1&&a.$controlNext.addClass(U.control_disabled)}function N(a){o(a),p(a),q(a),r(a),p(a),w(a),v(a)}function O(a){a.$container&&a.$container.length&&a.$container.fsTouch("destroy").off(V.scaleStart,A).off(V.scaleEnd,C).off(V.scale,B)}function P(a){var b=a[0],c=new Image;return"undefined"!=typeof b.naturalHeight?{naturalHeight:b.naturalHeight,naturalWidth:b.naturalWidth}:"img"===b.tagName.toLowerCase()&&(c.src=b.src,{naturalHeight:c.height,naturalWidth:c.width})}var Q,R=b.Plugin("viewer",{widget:!0,defaults:{controls:!0,customClass:"",labels:{count:"of",next:"Next",previous:"Previous",zoom_in:"Zoom In",zoom_out:"Zoom Out"},theme:"fs-light",zoomDelta:100,zoomEnertia:.2,zoomIncrement:.01},classes:["source","wrapper","viewport","container","image","gallery","loading_icon","controls","controls_custom","control","control_previous","control_next","control_zoom_in","control_zoom_out","control_disabled","loading"],events:{loaded:"loaded",ready:"ready"},methods:{_setup:c,_construct:h,_destruct:i,_resize:d,_raf:f,resize:N,load:j,unload:J}}),S=R.namespace,T=R.classes,U=T.raw,V=R.events,W=R.functions,X=(b.window,b.$window),Y=0,Z=[]});