(function(GLOBAL, $) {

    // DEBUG option - to avoid reload after forms (popup) submit
    var _reloadAfterSubmit = true;

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
        getHtmlElement: function(tagName, attributes, innerHtml) {
            var elem = document.createElement(tagName);
            if (innerHtml) {
                elem.innerHTML = innerHtml;
            }

            if (attributes) {
                for (var i in attributes) {
                    elem.setAttribute(i, attributes[i]);
                }
            }

            return elem;
        }

    }; // helper

    GLOBAL.Gritm = {
        /**
         * Global functions related to the tables on the page
         */
        table: {
            getSelectedRow: function(tableDbName) {
                var tbl = document.querySelector('table[table-db-name="'+tableDbName+'"]');
                if (tbl) {
                    var selectedRow = tbl.querySelector('tr.selected');
                    if (selectedRow) {
                        return selectedRow;
                    }
                }
                
                return null;
            }
        },
                
        /**
         * Global functions for popup manipulation
         */
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
                    // execute once the popup shown/loaded...
                    onload: function() {
                        console.log('popup loaded');
                    },
                    // the additional buttons (except "close", which is defined by "closeButton:true" item)
                    buttons: [{
                            caption: 'Ok',
                            // html attributes of the element
                            attributes: {
                                class: 'btn'
                            },
                            // the callback function for the button
                            click: function(popupHTMLElement) {
                                $(popupHTMLElement).modal('hide');
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
                    var modalWindow = _helper.getHtmlElement('div', {id: 'modal' + _modalsCounter, class: 'modal hide fade in'});

                    // the HEADER
                    var modalHeader = _helper.getHtmlElement('div', {class: 'modal-header'});

                    if (config.closeButton) {
                        var closeTopButton = _helper.getHtmlElement('button', {
                            type: 'button',
                            class: 'close',
                            'data-dismiss': 'modal',
                            'aria-hidden': true
                        }, '&times;');
                        modalHeader.appendChild(closeTopButton);
                    }

                    var modalHeaderH3 = _helper.getHtmlElement('h3', {}, config.title);
                    modalHeader.appendChild(modalHeaderH3);
                    modalWindow.appendChild(modalHeader);

                    // the BODY
                    var modalBody = _helper.getHtmlElement('div', {class: 'modal-body'}, config.html);
                    modalWindow.appendChild(modalBody);

                    // the FOOTER
                    var modalFooter = _helper.getHtmlElement('div', {class: 'modal-footer'});

                    // add the "close" button
                    if (config.closeButton) {
                        var closeBottomButton = _helper.getHtmlElement('button', {class: 'btn', 'data-dismiss': 'modal'}, 'Close');
                        modalFooter.appendChild(closeBottomButton);
                    }

                    // add another buttons
                    if (config.buttons) {
                        config.buttons.forEach(function(buttonObj) {

                            buttonObj.attributes = buttonObj.attributes || {};
                            if (buttonObj.attributes && !buttonObj.attributes.class) {
                                buttonObj.attributes.class = 'btn';
                            }

                            var _button = _helper.getHtmlElement('button', buttonObj.attributes, buttonObj.caption);
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

                    return $('#modal' + _modalsCounter);
                };

                return function(config) {
                    var modalElem = _createPopup(config);

                    // check if a `load` event was defined
                    if (typeof(config.onload) === 'function') {
                        modalElem.on('show', config.onload);
                    }

                    // display the popup
                    modalElem.modal('show');
                };
            })(), // Gritm.popup.show 

            // res - the AJAX result object (JSON)
            _onPopupLoad: function(res) {

                // execute JS
                if (res.javascript) {
                    eval(res.javascript);
                }

                // add CSS styles
                if (res.css) {
                    var styleElem = _helper.getHtmlElement('style', {type: 'text/css'}, res.css);
                    document.getElementsByTagName('head')[0].appendChild(styleElem);
                }
            },
            showAddNewRecord: function(tableDbName) {

                // get fields for mode "new"
                $.getJSON('?table=' + tableDbName + '&mode=new', function(res) {
                    if (!res || res.error || res.result !== 'ok') {
                        alert('Error getting fields for adding new record ' + (res && res.error ? res.error : ''));
                    }

                    // create the form element
                    var form = _helper.getHtmlElement('form', {
                        action: '?table=' + tableDbName + '&mode=new',
                        method: 'post',
                        onsubmit: 'return false;',
                        enctype: 'multipart/form-data'
                    });

                    // create the fields
                    var dt, dd, dl = document.createElement('dl');
                    if (res.fields) {
                        for (var i in res.fields) {
                            if (!res.fields[i].html) {
                                continue;
                            } else {
                                console.log('res.fields[i].html', res.fields[i].html);
                            }

                            dt = _helper.getHtmlElement('dt', {}, res.fields[i].name);
                            dl.appendChild(dt);
                            dd = _helper.getHtmlElement('dd', {}, res.fields[i].html);
                            dl.appendChild(dd);
                        }
                    }

                    form.appendChild(dl);

                    Gritm.popup.show({
                        title: 'Add new record',
                        html: form.outerHTML,
                        onload: function() {
                            Gritm.popup._onPopupLoad(res);
                        },
                        buttons: [{
                                caption: 'Add',
                                attributes: {
                                    class: 'btn btn-primary'
                                },
                                click: function(popupElem) {
                                    var frm = popupElem.querySelector('form'),
                                            iframeSubmit = document.querySelector('iframe#form-submit');
                                    if (!iframeSubmit) {
                                        iframeSubmit = _helper.getHtmlElement('iframe', {id: 'form-submit', name: 'form-submit', width: 1, height: 1, frameborder: 0});
                                        document.querySelector('body').appendChild(iframeSubmit);
                                    }

                                    iframeSubmit.onload = function() {
                                        // reload the page
                                        if (_reloadAfterSubmit) {
                                            document.location.href += ' ';
                                        }
                                    };

                                    frm.setAttribute('target', 'form-submit');
                                    frm.onsubmit = null;
                                    frm.submit();
                                }
                            }]
                    })

                });

            }, // Gritm.popup.showAddNewRecord 

            showEditRecord: function(tableDbName, pkValue) {
                if (!pkValue) {
                    Gritm.popup.show({
                        title: 'Error',
                        html: 'Please select a row to update'
                    });
                    return;
                }

                // get fields for mode "new"
                $.getJSON('?table=' + tableDbName + '&mode=edit&pk=' + pkValue, function(res) {
                    if (!res || res.error || res.result !== 'ok') {
                        alert('Error getting fields for editing the record ' + (res && res.error ? res.error : ''));
                    }

                    // create the form element
                    var form = _helper.getHtmlElement('form', {
                        action: '?table=' + tableDbName + '&mode=edit&pk=' + pkValue,
                        method: 'post',
                        onsubmit: 'return false;',
                        enctype: 'multipart/form-data'
                    });

                    // create the fields
                    var dt, dd, dl = document.createElement('dl');
                    if (res.fields) {
                        for (var i in res.fields) {
                            if (!res.fields[i].html)
                                continue;

                            dt = _helper.getHtmlElement('dt', {}, res.fields[i].name);
                            dl.appendChild(dt);
                            dd = _helper.getHtmlElement('dd', {}, res.fields[i].html);
                            dl.appendChild(dd);
                        }
                    }

                    form.appendChild(dl);

                    Gritm.popup.show({
                        title: 'Update record',
                        html: form.outerHTML,
                        onload: function() {
                            Gritm.popup._onPopupLoad(res);
                        },
                        buttons: [{
                                caption: 'Update',
                                attributes: {
                                    class: 'btn btn-primary'
                                },
                                click: function(popupElem) {
                                    var frm = popupElem.querySelector('form'),
                                            iframeSubmit = document.querySelector('iframe#form-submit');
                                    if (!iframeSubmit) {
                                        iframeSubmit = _helper.getHtmlElement('iframe', {id: 'form-submit', name: 'form-submit', width: 1, height: 1, frameborder: 0});
                                        document.querySelector('body').appendChild(iframeSubmit);
                                    }

                                    iframeSubmit.onload = function() {
                                        // reload the page
                                        if (_reloadAfterSubmit) {
                                            document.location.href += ' ';
                                        }
                                    };

                                    frm.setAttribute('target', 'form-submit');
                                    frm.onsubmit = null;
                                    frm.submit();
                                }
                            }]
                    })

                });

            }, // showEditRecord

            showDeleteRecord: function(tableDbName, pkValue) {
                // check the selected row
                if (!pkValue) {
                    Gritm.popup.show({
                        title: 'Error',
                        html: 'Please select a row to delete'
                    });
                    return;
                }

                // confirm the delete
                Gritm.popup.show({
                    title: 'Delete a record',
                    html: 'Sure?',
                    buttons: [{
                            caption: 'Delete!',
                            attributes: {
                                class: 'btn btn-danger'
                            },
                            click: function(popupElem) {

                                var iframeSubmit = document.querySelector('iframe#form-submit');
                                if (!iframeSubmit) {
                                    iframeSubmit = _helper.getHtmlElement('iframe', {id: 'form-submit', name: 'form-submit', width: 1, height: 1, frameborder: 0});
                                    document.querySelector('body').appendChild(iframeSubmit);
                                }

                                iframeSubmit.onload = function() {
                                    // reload the page
                                    if (_reloadAfterSubmit) {
                                        document.location.href += ' ';
                                    }
                                };

                                var frm = _helper.getHtmlElement('form', {
                                    action: '?table=' + tableDbName + '&mode=delete&pk=' + pkValue,
                                    method: 'post',
                                    target: 'form-submit',
                                    enctype: 'multipart/form-data'
                                });
                                frm.onsubmit = null;
                                frm.submit();
                            }
                        }]
                });
            } // showDeleteRecord
        } // Gritm.popup
    } // Gritm

})(window, jQuery);