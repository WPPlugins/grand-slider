// Docu : http://wiki.moxiecode.com/index.php/TinyMCE:Create_plugin/3.x#Creating_your_own_plugins

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('gsld');
	 
	tinymce.create('tinymce.plugins.gsld', {
		
		init : function(ed, url) {
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');

			ed.addCommand('gsld', function() {
				ed.windowManager.open({
					file : url + '/blackbox.php',
					width : 460,
					height : 449,
					inline : 1
				}, {
					plugin_url : url // Plugin absolute URL
				});
			});

			// Register example button
			ed.addButton('gsld', {
				title : 'Grand Slider',
				cmd : 'gsld',
				image : url + '/shortcode.png'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('gsld', n.nodeName == 'IMG');
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
					longname  : 'gsld',
					author 	  : 'zourbuth',
					authorurl : 'http://www.zourbuth.com',
					infourl   : 'http://www.zourbuth.com/grand-slider',
					version   : "0.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('gsld', tinymce.plugins.gsld);
})();


