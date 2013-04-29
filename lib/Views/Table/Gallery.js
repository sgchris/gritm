(function() {

    // the gallery resource
    var gallery = {
        get: function(tableDbName, pk, callback) {
            var url = '?galleryTable=' + tableDbName + '&pk=' + pk;
            $.getJSON(url, function(res) {
                console.log('ajax return from', url);
                if (typeof(callback) === 'function') {
                    callback(res);
                }
            });
        },
        drawLoader: function() {
            var galleryImages = document.querySelector('#gallery-images');
            if (!galleryImages) {
                alert('Error initializing gallery div');
                return false;
            }

            galleryImages.innerHTML = '<div id="images-upload-loader">' +
                    '<h3><img src="' + _HTTP_ROOT + '/img/ajax-loader2.gif" /></h3>' +
                    '</div>';
        },
        drawImages: function(imagesArray) {
            var galleryImages = document.querySelector('#gallery-images');
            if (!galleryImages) {
                alert('Error initializing gallery div');
                return false;
            }

            // create the uploader DIV
            galleryImages.innerHTML = '<div id="images-upload">' +
                    '<h3>Drag images here to upload</h3>' +
                    '<input type="file" multiple="true" />' +
                    '</div>'+
                    '<div id="images-list"></div>';
            
            // create the div with the current images
            if (imagesArray && imagesArray.length) {
                for (var i in imagesArray) {
                    var imgDiv = _helper.getHtmlElement('div'), 
                            img = imagesArray[i];
                    imgDiv.innerHTML = '<div class="image-item">'+
                            '<img src="'+img.src+'" style="height: 100px" />'+
                            '</div>';
                    document.querySelector('#images-list').appendChild(imgDiv);
                }
            }
            
            // bind uploader events
            
        }
    };


    // initialize the button click event
    [].forEach.call(document.querySelectorAll("a.btn[button-operation=\'show-gallery\']"), function(elem) {
        elem.onclick = function() {
            // get the db name of the table
            var tableDbName = elem.getAttribute("table-db-name");

            // get the selected row (selected gallery)
            var selectedRow = Gritm.table.getSelectedRow(tableDbName);
            if (!selectedRow) {
                Gritm.popup.show({
                    title: 'Hm...',
                    html: 'Please select one row (one gallery)'
                });
                return;
            }

            // get the PK of the row
            var pk = selectedRow.getAttribute('row-pk');
            if (!pk)
                return;

            // get the images
            gallery.drawLoader();
            gallery.get(tableDbName, pk, function(res) {
                if (res && res.result === 'ok') {
                    gallery.drawImages(res.images);
                }
            });
        };
    });
})();