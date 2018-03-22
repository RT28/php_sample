!function(t){"use strict";var i=-1,e=function(e,n){return this.itemsContainerSelector=n.container,this.itemSelector=n.item,this.nextSelector=n.next,this.paginationSelector=n.pagination,this.$scrollContainer=e,this.$container=window===e.get(0)?t(document):e,this.defaultDelay=n.delay,this.negativeMargin=n.negativeMargin,this.nextUrl=null,this.isBound=!1,this.isPaused=!1,this.isInitialized=!1,this.listeners={next:new IASCallbacks,load:new IASCallbacks,loaded:new IASCallbacks,render:new IASCallbacks,rendered:new IASCallbacks,scroll:new IASCallbacks,noneLeft:new IASCallbacks,ready:new IASCallbacks},this.extensions=[],this.scrollHandler=function(){if(this.isBound&&!this.isPaused){var t=this.getCurrentScrollOffset(this.$scrollContainer),e=this.getScrollThreshold();i!=e&&(this.fire("scroll",[t,e]),t>=e&&this.next())}},this.getItemsContainer=function(){return t(this.itemsContainerSelector)},this.getLastItem=function(){return t(this.itemSelector,this.getItemsContainer().get(0)).last()},this.getFirstItem=function(){return t(this.itemSelector,this.getItemsContainer().get(0)).first()},this.getScrollThreshold=function(t){var e;return t=t||this.negativeMargin,t=t>=0?-1*t:t,e=this.getLastItem(),0===e.length?i:e.offset().top+e.height()+t},this.getCurrentScrollOffset=function(t){var i=0,e=t.height();return i=window===t.get(0)?t.scrollTop():t.offset().top,(-1!=navigator.platform.indexOf("iPhone")||-1!=navigator.platform.indexOf("iPod"))&&(e+=80),i+e},this.getNextUrl=function(i){return i=i||this.$container,t(this.nextSelector,i).last().attr("href")},this.load=function(i,e,n){var s,r,o=this,a=[],h=+new Date;n=n||this.defaultDelay;var l={url:i};return o.fire("load",[l]),t.get(l.url,null,t.proxy(function(i){s=t(this.itemsContainerSelector,i).eq(0),0===s.length&&(s=t(i).filter(this.itemsContainerSelector).eq(0)),s&&s.find(this.itemSelector).each(function(){a.push(this)}),o.fire("loaded",[i,a]),e&&(r=+new Date-h,n>r?setTimeout(function(){e.call(o,i,a)},n-r):e.call(o,i,a))},o),"html")},this.render=function(i,e){var n=this,s=this.getLastItem(),r=0,o=this.fire("render",[i]);o.done(function(){t(i).hide(),s.after(i),t(i).fadeIn(400,function(){++r<i.length||(n.fire("rendered",[i]),e&&e())})})},this.hidePagination=function(){this.paginationSelector&&t(this.paginationSelector,this.$container).hide()},this.restorePagination=function(){this.paginationSelector&&t(this.paginationSelector,this.$container).show()},this.throttle=function(i,e){var n,s,r=0;return n=function(){function t(){r=+new Date,i.apply(n,o)}var n=this,o=arguments,a=+new Date-r;s?clearTimeout(s):t(),a>e?t():s=setTimeout(t,e)},t.guid&&(n.guid=i.guid=i.guid||t.guid++),n},this.fire=function(t,i){return this.listeners[t].fireWith(this,i)},this.pause=function(){this.isPaused=!0},this.resume=function(){this.isPaused=!1},this};e.prototype.initialize=function(){if(this.isInitialized)return!1;var t=!!("onscroll"in this.$scrollContainer.get(0)),i=this.getCurrentScrollOffset(this.$scrollContainer),e=this.getScrollThreshold();return t?(this.hidePagination(),this.bind(),this.fire("ready"),this.nextUrl=this.getNextUrl(),i>=e?(this.next(),this.one("rendered",function(){this.isInitialized=!0})):this.isInitialized=!0,this):!1},e.prototype.reinitialize=function(){this.isInitialized=!1,this.unbind(),this.initialize()},e.prototype.bind=function(){if(!this.isBound){this.$scrollContainer.on("scroll",t.proxy(this.throttle(this.scrollHandler,150),this));for(var i=0,e=this.extensions.length;e>i;i++)this.extensions[i].bind(this);this.isBound=!0,this.resume()}},e.prototype.unbind=function(){if(this.isBound){this.$scrollContainer.off("scroll",this.scrollHandler);for(var t=0,i=this.extensions.length;i>t;t++)"undefined"!=typeof this.extensions[t].unbind&&this.extensions[t].unbind(this);this.isBound=!1}},e.prototype.destroy=function(){this.unbind(),this.$scrollContainer.data("ias",null)},e.prototype.on=function(i,e,n){if("undefined"==typeof this.listeners[i])throw new Error('There is no event called "'+i+'"');return n=n||0,this.listeners[i].add(t.proxy(e,this),n),this},e.prototype.one=function(t,i){var e=this,n=function(){e.off(t,i),e.off(t,n)};return this.on(t,i),this.on(t,n),this},e.prototype.off=function(t,i){if("undefined"==typeof this.listeners[t])throw new Error('There is no event called "'+t+'"');return this.listeners[t].remove(i),this},e.prototype.next=function(){var t=this.nextUrl,i=this;if(this.pause(),!t)return this.fire("noneLeft",[this.getLastItem()]),this.listeners.noneLeft.disable(),i.resume(),!1;var e=this.fire("next",[t]);return e.done(function(){i.load(t,function(t,e){i.render(e,function(){i.nextUrl=i.getNextUrl(t),i.resume()})})}),e.fail(function(){i.resume()}),!0},e.prototype.extension=function(t){if("undefined"==typeof t.bind)throw new Error('Extension doesn\'t have required method "bind"');return"undefined"!=typeof t.initialize&&t.initialize(this),this.extensions.push(t),this.isInitialized&&this.reinitialize(),this},t.ias=function(i){var e=t(window);return e.ias.apply(e,arguments)},t.fn.ias=function(i){var n=Array.prototype.slice.call(arguments),s=this;return this.each(function(){var r=t(this),o=r.data("ias"),a=t.extend({},t.fn.ias.defaults,r.data(),"object"==typeof i&&i);if(o||(r.data("ias",o=new e(r,a)),t(document).ready(t.proxy(o.initialize,o))),"string"==typeof i){if("function"!=typeof o[i])throw new Error('There is no method called "'+i+'"');n.shift(),o[i].apply(o,n)}s=o}),s},t.fn.ias.defaults={item:".item",container:".listing",next:".next",pagination:!1,delay:600,negativeMargin:10}}(jQuery);