/*!
 * jQuery 3D Flip //Alex//Ka-ex
*/
(function($){
	var flip = function(dom, flipedRotate){
		dom.data("fliped", true);
		dom.css({
			transform: flipedRotate
		});
	};
	var unflip = function(dom){
		dom.data("fliped", false);
		dom.css({
			transform: "rotatex(0deg)"
		});
	};
  $.fn.flip = function(options) {
  	var jqObj = this;
    var width = this.width();
		var height = this.height();
		var prespective = width*2;
  	if(options !== undefined && typeof(options) == "boolean"){
  		if(options){
  			flip(this, this.data("flipedRotate"));
  		}else{
  			unflip(this);
  		}
  	}else{
			var settings = $.extend({
				axis: "y",
				trigger: "click"
	    }, options );
			if(settings.axis.toLowerCase() == "x"){
				prespective = height*2;
				this.data("flipedRotate", "rotatex(180deg)");
			}else{
				this.data("flipedRotate", "rotatey(180deg)");
			}
			var flipedRotate = this.data("flipedRotate");
			this.wrap("<div class='flip'></div>");
			this.parent().css({
				perspective: prespective,
				position: "relative",
				width: width,
				height: height
			});
			this.css({
				"transform-style": "preserve-3d",
				transition: "all 0.5s ease-out"
			});
			this.find(".front").wrap("<div class='front-wrap'></div>");
			this.find(".back").wrap("<div class='back-wrap'></div>");
			this.find(".front, .back").css({
				width: "100%",
				height: "100%"
			});
			this.find(".front-wrap, .back-wrap").css({
				position: "absolute",
				"backface-visibility": "hidden",
				width: "100%",
				height: "100%"
			})
			this.find(".back-wrap").css({
				transform: flipedRotate
			})
			if(settings.trigger.toLowerCase() == "click"){
				this.parent().click(function(){
					if(jqObj.data("fliped")){
						unflip(jqObj);
		      }else{
		      	flip(jqObj, flipedRotate);
		      }
				});
			}else if(settings.trigger.toLowerCase() == "hover"){
				this.parent().hover(function(){
					flip(jqObj, flipedRotate);
				}, function(){
					unflip(jqObj);
				});
			}	
  	}
	return this;		
  };
}(jQuery));