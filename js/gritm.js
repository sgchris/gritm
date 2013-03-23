(function(GLOBAL, $) {

    GLOBAL.Gritm = {
        popup: {
            defaultConfig: {
             		title: 'Gritm',
             		html: null,
             		buttons: [{
             			caption: 'Close',
             			attributes: {
             				class: 'btn',
                            
             				popupId: '123'
             			}
             			click: function() {
             				
             			},
             			hover: function() {...}
             		}],
             		closeButton: true,
             		width: 400,
             		height: 200
             },
            /**
             * @param object config - {
             *		title: 'popup Title...',
             *		html: 'popup HTML...',
             *		buttons: [{
             *			caption: 'Some Button',
             *			attributes: {
             *				class: 'btn btn-primary',
             *				popupId: '123'
             *			}
             *			click: function() {
             *				
             *			},
             *			hover: function() {...}
             *		}],
             *		closeButton: true,
             *		width: 400,
             *		height: 200
             *	}
             */
            show: function(config) {
                var modalsCounter = 1;
                
                // search for free modal id
                while (document.querySelector('div#modal'+modalsCounter)) modalsCounter++;
                
                // create the modal
                var modalWindow = document.createElement('div');
                modalWindow.id = 'modal'+modalsCounter;
                modalWindow.class = 'modal hide fade';
                
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
    }

})(window, jQuery);