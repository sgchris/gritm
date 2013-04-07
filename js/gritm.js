(function(GLOBAL, $) {

	// debug functions /////////////////////
	var _debug = function() {
		console.log.apply(console, arguments);
	};

	// helper object ///////////////////////
	// some heler functions
	var _helper = {
		// email validation functiokn
		// returns "1" on success, otherwise error string
		emailCheck: function(a) {
			var e = /^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/, a = a.match(/^(.+)@(.+)$/);
			if (null == a)
				return"Email address seems incorrect (check @ and .'s)";
			for (var c = a[1], b = a[2], a = 0; a < c.length; a++)
				if (127 < c.charCodeAt(a))
					return"Ths username contains invalid characters.";
			for (a = 0; a < b.length; a++)
				if (127 < b.charCodeAt(a))
					return"Ths domain name contains invalid characters.";
			if (null == c.match(/^([^\s\(\)><@,;:\\\"\.\[\]]+|("[^"]*"))(\.([^\s\(\)><@,;:\\\"\.\[\]]+|("[^"]*")))*$/))
				return"The username doesn't seem to be valid.";
			c = b.match(/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/);
			if (null != c) {
				for (a = 1; 4 >= a; a++)
					if (255 < c[a])
						return"Destination IP address is invalid!";
				return!0
			}
			for (var c = /^[^\s\(\)><@,;:\\\"\.\[\]]+$/, b = b.split("."), d = b.length, a = 0; a < d; a++)
				if (-1 == b[a].search(c))
					return"The domain name does not seem to be valid.";
			return 2 != b[b.length - 1].length && -1 == b[b.length - 1].search(e) ? "The address must end in a well-known domain or two letter country." : 2 > d ? "This address is missing a hostname!" : "1"
		},
		getFileExtension: function(filename) {
			if (!filename)
				return '';

			var splittedFilename = filename.split('.');
			return splittedFilename.pop();
		},
		// get the base name of the file (from file path)
		basename: function(filePath) {
			if (!filePath)
				return '';
			var splittedFilename = filePath.split('/');
			return splittedFilename.pop();
		},
		// get the directory from the full file path
		dirname: function(filePath) {
			if (!filePath)
				return '';
			var splittedFilename = filePath.split('/');
			splittedFilename.pop();
			return splittedFilename.length ? splittedFilename.join('/') : '';
		},
		reloadPage: function() {
			document.location.href += " ";
		},
		getObjectLength: function(obj) {
			var counter = 0;
			if (!obj)
				return 0;
			for (var i in obj) {
				counter++;
			}

			return counter;
		},
		getMaxObjectIndex: function(obj) {
			if (!obj)
				return 0;

			var maxValue = 0;
			for (var i in obj) {
				// compare only if this is a numeric string
				i = parseInt(i, 10);
				if (i > maxValue)
					maxValue = i;
			}
			return parseInt(maxValue, 10);
		},
		_uniqid: (function() {
			var startNumber = Math.floor(Math.random() * 10000);
			return function() {
				return (startNumber++) + 1;
			}
		})(),
		// implementation of the $.extend function
		extend: function() {
			var a, c, d, e, f, g, h = arguments[0] || {}, i = 1, j = arguments.length, k = !1;
			typeof h == "boolean" && (k = h, h = arguments[1] || {}, i = 2), typeof h != "object" && !p.isFunction(h) && (h = {}), j === i && (h = this, --i);
			for (; i < j; i++)
				if ((a = arguments[i]) != null)
					for (c in a) {
						d = h[c], e = a[c];
						if (h === e)
							continue;
						k && e && (p.isPlainObject(e) || (f = p.isArray(e))) ? (f ? (f = !1, g = d && p.isArray(d) ? d : []) : g = d && p.isPlainObject(d) ? d : {}, h[c] = p.extend(k, g, e)) : e !== b && (h[c] = e)
					}
			return h
		}
	};

	GLOBAL.Gritm = {
		popup: {
			// Show the popup
			// the config is an extension of Gritm.popup.defaultConfig
			show: (function() {
				// define the popups counter
				var _modalsCounter = 1;

				// default configuration for a popup
				var _defaultConfig = {
					// the title of the window
					title: 'Gritm app window',
					// the HTML of the window
					html: '',
					// the additional buttons (except "close", which is defined by "closeButton:true" item)
					buttons: [{
							caption: 'Ok',
							// html attributes of the element
							attributes: {
								class: 'btn'
							},
							// the callback function for the button
							click: function(popupHTMLElement) {
								alert('Ok clicked');
							}
						}],
					// the "X" on the top right corner and the "close" button at the bottom
					closeButton: true,
					// dimentions
					width: 400,
					height: 200
				};

				var _createPopup = function(config) {
					_modalsCounter++;

					// extend the config
					config = $.extend({}, _defaultConfig, config);


					// create the modal
					var modalWindow = document.createElement('div');
					modalWindow.setAttribute('id', 'modal' + _modalsCounter);
					modalWindow.setAttribute('class', 'modal hide fade in');

					// the HEADER
					var modalHeader = document.createElement('div');
					modalHeader.setAttribute('class', 'modal-header');

					if (config.closeButton) {
						var closeTopButton = document.createElement('button');
						closeTopButton.setAttribute('type', 'button');
						closeTopButton.setAttribute('class', 'close');
						closeTopButton.setAttribute('data-dismiss', 'modal');
						closeTopButton.setAttribute('aria-hidden', 'true');
						closeTopButton.innerHTML = '&times;';
						modalHeader.appendChild(closeTopButton);
					}

					var modalHeaderH3 = document.createElement('h3');
					modalHeaderH3.innerHTML = config.title;
					modalHeader.appendChild(modalHeaderH3);
					modalWindow.appendChild(modalHeader);

					// the BODY
					var modalBody = document.createElement('div');
					modalBody.setAttribute('class', 'modal-body');
					// check if "p" is necessary
					modalBody.innerHTML = config.html;
					modalWindow.appendChild(modalBody);

					// the FOOTER
					var modalFooter = document.createElement('div');
					modalFooter.setAttribute('class', 'modal-footer');

					// add the "close" button
					if (config.closeButton) {
						var closeBottomButton = document.createElement('button');
						closeBottomButton.setAttribute('class', 'btn');
						closeBottomButton.setAttribute('data-dismiss', 'modal');
						closeBottomButton.innerHTML = 'Close';
						modalFooter.appendChild(closeBottomButton);
					}

					// add another buttons
					if (config.buttons) {
						config.buttons.forEach(function(buttonObj) {
							var _button = document.createElement('button');

							// set attributes
							if (buttonObj.attributes) {
								for (var i in buttonObj.attributes) {
									_button.setAttribute(i, buttonObj.attributes[i]);
								}
							}
							if (!_button.hasAttribute('class')) {
								_button.setAttribute('class', 'btn');
							}

							_button.innerHTML = buttonObj.caption;
							_button.onclick = function() {
								buttonObj.click(modalWindow);
							};
							modalFooter.appendChild(_button);
						});
					}
					modalWindow.appendChild(modalFooter);

					// add the modal window to the body
					var docBody = document.querySelector('body');
					if (docBody.children[0]) {
						docBody.insertBefore(modalWindow, docBody.children[0]);
					} else {
						docBody.appendChild(modalWindow);
					}

					return $('#modal' + _modalsCounter)
				};

				return function(config) {
					var modalElem = _createPopup(config);
					modalElem.modal('show');
				};
			})()

					// add header

					/**
					 * <div class="modal hide fade">
					 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					 <h3>Modal header</h3>
					 </div>
					 <div class="modal-body">
					 <p>One fine body…</p>
					 </div>
					 <div class="modal-footer">
					 <a href="#" class="btn">Close</a>
					 <a href="#" class="btn btn-primary">Save changes</a>
					 </div>
					 </div>
					 */
		}
	}

})(window, jQuery);