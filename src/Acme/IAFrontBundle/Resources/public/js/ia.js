/**
 * IA engine
 * @author Xavier Boubert xavier@boubert.fr
 * @return object IA object
 */

(function($) {
	'use strict';

	var IA = function(config) {

		var _ia = this,
			tpl = window.tpl,
			_lastTalk = '',
			_stripHtmlDiv = document.createElement('DIV');

		// Extend window.IA with this new configuration in case others objets already exists inside
		$.extend(this, config);

		this.stripHtml = function(html) {
			_stripHtmlDiv.innerHTML = html;
			return _stripHtmlDiv.textContent || _stripHtmlDiv.innerText || '';
		};

		this.init = function() {
			_ia.resize();

			$('#sendButton').click(function() {
				_ia.talk($('#msgbox').val());
				$('#msgbox').val('');
			});

			$('#msgbox').keyup(function(e) {
				if(e.keyCode == 13) {
					_ia.talk($('#msgbox').val());
					$('#msgbox').val('');
				}
			});
		};

		this.goToBottom = function() {
			$('#chatmessagecontainer').animate({
				scrollTop: $('#chatmessageinner').height()
			}, 'fast');
		};

		this.talk = function(text) {
			var cleanText = _ia.stripHtml(text);

			var time = new Date();
			time = time.getHours() + ':' + time.getMinutes();

			$('#chatmessageinner').append(
				tpl.message({
					'avatar': _ia.userAvatar,
					'name': 'Moi',
					'text': cleanText,
					'time': time
				})
			);

			_ia.goToBottom();

			$.ajax({
				url: 'actions/talk',
				type: 'POST',
				data: {
					text: text,
					previous: _lastTalk
				},
				dataType: 'json'
			})
			.done(function(data, textStatus, jqXHR) {
				data.success = data.success || false;
				data.error = data.error || 'unknown';

				if(!data.success) {
					alert('Erreur : ' + data.error);
					return;
				}

				$('#contentCount').html(data.count);

				time = new Date();
				time = time.getHours() + ':' + time.getMinutes();

				var response = _ia.stripHtml(data.response);
				_lastTalk = response;

				$('#chatmessageinner').append(
					tpl.message({
						'avatar': _ia.avatar,
						'name': 'I.A.',
						'text': response,
						'time': time
					})
				);

				_ia.goToBottom();

			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				alert('Erreur serveur : ' + errorThrown);
			});
		};

		this.resize = function() {
			var $chatmessagecontainer = $('#chatmessagecontainer'),
				height = $(window).height() - ($chatmessagecontainer.offset().top + $('#sendBox').outerHeight() + parseInt($('#chatmessage').css('margin-bottom').replace(/[^-\d\.]/g, ''), 10));
			$chatmessagecontainer.css('height', height);
		};

		$(window).resize(function() {
			_ia.resize();
		});

	};

	window.IA = new IA(window.IA || {});

	$(window.document).ready(function () {
		window.IA.init();
	});

})($);
