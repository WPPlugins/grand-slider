function d(id) { return document.getElementById(id); }

function flipTab(n) {
	for (i=1;i<=4;i++) {
		c = d('content'+i.toString());
		t = d('tab'+i.toString());
		if ( n == i ) {
			c.className = '';
			t.className = 'current';
		} else {
			c.className = 'hidden';
			t.className = '';
		}
	}
}

tinyMCEPopup.onInit.add(function() {
	var win = tinyMCEPopup.getWin();
	
	if ( win.fullscreen && win.fullscreen.settings.visible ) {
		d('content1').className = 'hidden';
		d('tabs').className = 'hidden';
		d('content3').className = 'dfw';
	}

	if ( tinymce.isMac )
		document.body.className = 'macos';
	
	if ( tinymce.isMac && tinymce.isWebKit )
		document.body.className = 'macos macwebkit';

});

function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function insertSlidercode() {
	var slider_id  = document.getElementById('slider-id').value;
	var items_value  = document.getElementById('items').value;
	var slide_id_v  = document.getElementById('slide-id').value;
	var post_id_v  = document.getElementById('posts-id').value;
	var width_value  = document.getElementById('width').value;
	var height_value = document.getElementById('height').value;
	var ease_value = document.getElementById('ease').value;
	var speed_value = document.getElementById('speed').value;
	var pause_value = document.getElementById('pause').value;
	var fadespeed_value = document.getElementById('fadespeed').value;
	var slideCount_value = document.getElementById('slideCount').value;
	
	var thumbnail_value = document.getElementById('thumbnail').checked;
	var fade_value = document.getElementById('fade').checked;
	var controlsShow_value = document.getElementById('controlsShow').checked;
	var vertical_value = document.getElementById('vertical').checked;
	var auto_value = document.getElementById('auto').checked;
	var prevNext_value = document.getElementById('prevNext').checked;
	var dots_value = document.getElementById('dots').checked;

	var id				= ' id="' + slider_id + '"';
	var items			= ' items="' + items_value + '"';
	var slide_id		= ' slide_id="' + slide_id_v + '"';
	var posts_id		= ' posts_id="' + post_id_v + '"';
	var thumbnail		= ' thumbnail="' + thumbnail_value + '"';
	var width			= ' width="' + width_value + '"';
	var height			= ' height="' + height_value + '"';
	var controlsshow	= ' controlsshow="' + controlsShow_value + '"';
	var fade			= ' fade="' + fade_value + '"';
	var vertical		= ' vertical="' + vertical_value + '"';
	var ease			= ' ease="' + ease_value + '"';
	var speed			= ' speed="' + speed_value + '"';
	var auto			= ' auto="' + auto_value + '"';
	var pause			= ' pause="' + pause_value + '"';
	var prevNext		= ' prevnext="' + prevNext_value + '"';
	var dots			= ' dots="' + dots_value + '"';
	var fadespeed		= ' fadespeed="' + fadespeed_value + '"';
	var slideCount		= ' slideCount="' + slideCount_value + '"';
	
	var tagtext			= "[grand-slider ";
	var ctag 			= " ]";
	
	var options	= tagtext+id+slide_id+posts_id+items+thumbnail+height+width+controlsshow+fade+fadespeed+vertical+ease+auto+speed+pause+prevNext+dots+slideCount+ctag;
	
	window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, options);
	tinyMCEPopup.editor.execCommand('mceRepaint');
	tinyMCEPopup.close();
	return;
}

function insertSlidecode() {
	var tagtext;
	var ctag;

	var move		= document.getElementById('move').value;
	var gease_val	= document.getElementById('g-ease').value;
	
	var speed_value		= document.getElementById('speed').value;
	var distance_value	= document.getElementById('distance').value;
	var top_value 	 	= document.getElementById('top').value;
	var left_value	 	= document.getElementById('left').value;
	
	var inst = tinyMCE.getInstanceById('content');
	var html = inst.selection.getContent();

	var speed		= ' speed="' + speed_value + '"';
	var distance	= ' distance="' + distance_value + '"';
	var easing		= ' easing="' + gease_val + '"';
	var top			= ' top="' + top_value + '"';
	var left		= ' left="' + left_value + '"';
	tagtext			= "[" + move;
	
	if ( html )
		ctag = "[/" + move + "]";
	else
		ctag = " Your content here [/" + move + "]";

	window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext+top+left+speed+distance+easing+']'+html+ctag);

	tinyMCEPopup.editor.execCommand('mceRepaint');
	tinyMCEPopup.close();
	return;
}
