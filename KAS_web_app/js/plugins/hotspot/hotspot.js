/*
	Hotspot 1.0
	Author: Nikolay Dyankov
	Site: http://www.nikolaydyankovdesign.com
	Email: me@nikolaydyankov.com
*/

(function($) {

	function Hotspot(root, options) {
		this.options = options;
		this.root = root;
	}
	Hotspot.prototype.init = function() {
		var html = '', spotClass = '', width = 'auto', visibilityClass = '', positionClass = '', x, y;
		
		html += '<img src="' + this.root.find('img').first().attr('src') + '" class="hsmap-image">';
		this.root.find('.hs-spot-object').each(function() {
			if ($(this).data('type') == 'rect') {
				spotClass = 'hs-rect';
				x = $(this).data('x');
				y = $(this).data('y');
			} else {
				spotClass= 'hs-spot';
				x = $(this).data('x') - $(this).data('width') / 2;
				y = $(this).data('y') - $(this).data('height') / 2;
			}
			
			if ($(this).data('visible') == 'visible') {
				visibilityClass = 'visible';
			} else {
				visibilityClass = '';
			}

			if ($(this).data('tooltip-auto-width') == false) {
				width = $(this).data('tooltip-width') + 'px';
			} else {
				width = 'auto';
			}
			
			positionClass = $(this).data('popup-position');
			
			html += '<div class="' + spotClass + ' ' + visibilityClass + ' ' + positionClass + ' hs-spot-object" style="left: ' + x + 'px; top: ' + y + 'px; width: ' + $(this).data('width') + 'px; height: ' + $(this).data('height') + 'px;">';
			html += '	<div class="hs-spot-shape"></div><div class="hs-spot-shape-inner"></div><div class="hs-spot-shape-inner-two"></div>';
			html += '	<div class="hs-spot-tooltip-outer">';
			html += '		<div class="hs-tooltip-buffer"></div>';
			html += '		<div class="hs-tooltip-wrap" style="width: ' + width + ';">';
			html += '			<div class="hs-tooltip">';
			html += 				$(this).html();
			html += '			</div>';
			html += '		</div>';
			html += '	</div>';
			html += '</div>';
		});
		
		this.root.html(html);
		this.root.removeClass('hs-loading');
		
		this.root.addClass(this.options['show_on']);
		this.root.addClass(this.options['color_scheme']);
		
		if (this.options['transparent_spots']) {
			this.root.addClass('transparent-spots');
		}
		
		// Add events
		
		if (this.options['show_on'] == 'click') {
			$('.hs-spot-object').on('click', function() {
				$(this).toggleClass('visible-tooltip');
			});
		}
		if (this.options['show_on'] == 'mouseover') {
			$('.hs-spot-object').on('mouseover', function() {
				$(this).addClass('visible-tooltip');
			});
			$('.hs-spot-object').on('mouseout', function(e) {
				$(this).removeClass('visible-tooltip');
			});
		}
		
		this.root.addClass('hs-loaded');
	}
	
	$.fn.hotspot = function(options) {
		var D = {
			'show_on' : 'mouseover',
			'transparent_spots' : true,
			'color_scheme' : 'red'
		};
		
		O = $.extend(true, D, options);
		
		return this.each(function() {
			var hotspot = new Hotspot($(this), O);
			hotspot.init();
		});
	}
})(jQuery);