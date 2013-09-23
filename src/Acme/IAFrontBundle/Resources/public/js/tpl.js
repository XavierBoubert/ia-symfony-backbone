/**
 * Templates engine
 * @author Fork modification from icanhazjs.com
 * @return object tpl object
 */

var tpl = {
	templates: {},

	trim: function(stuff) {
        if (''.trim) {
        	return stuff.trim();
        }
        else {
        	return stuff.replace(/^\s+/, '').replace(/\s+$/, '');
        }
    },

    addTemplate: function(name, templateString) {
		tpl.templates[name] = templateString;
		tpl[name] = function (replaces, increment) {
			replaces = replaces || {};
			increment = increment || 0;

			var text = tpl.templates[name],
				finalText = '',
				item;

			if(typeof replaces == 'object' && (replaces instanceof Array)) {
				for(var i = 0; i < replaces.length; i++) {
					finalText += tpl[name](replaces[i], i);
				}
			}
			else {
				replaces['%INCREMENT%'] = increment;

				finalText = text;
				for(item in replaces) {
					finalText = finalText.replace(new RegExp('({{ '+item+' }})', 'g'), replaces[item]);
				}
			}

			return finalText;
		};
    },

    loadTemplate: function(url) {
		$.getJSON(url, function (templates) {
			$.each(templates, function (template) {
				tpl.addTemplate(template.name, template.template);
			});
		});
    },

	grabTemplates: function() {
		var i,
			scripts = document.getElementsByTagName('script'),
			trash = [];
		for (i = 0; i < scripts.length; i++) {
			var script = scripts[i];
			if (script && script.innerHTML && script.id && script.type === "text/html") {
				tpl.addTemplate(script.id, tpl.trim(script.innerHTML));
				trash.unshift(script);
			}
		}
		for (i = 0; i < trash.length; i++) {
			trash[i].parentNode.removeChild(trash[i]);
		}
	}
};

$(document).ready(function () {
	tpl.grabTemplates();
});