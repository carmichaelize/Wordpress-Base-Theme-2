jQuery(document).ready(function($){

    function sc_wp_gallery_images(container){

        function init(container){

            //Meta Containers
            this.file_frame = null;
            this.currentItem = null;
            this.single = container.hasClass('single') ? true : false;
            this.itemContainer = container.parents('.inside');

            this.actions(this);
        }

        init.prototype.setImage = function(self, event, append, item){

            event.preventDefault();

            var container = self.itemContainer;

            //Get Gallery Item
            if(append == false){
                self.currentItem = item;
            } else {
                self.currentItem = $(container.find('#sc_gallery_image_single').html());
            }

            //Open Uploader If It Already Exsists.
            if(self.file_frame){
                self.file_frame.open();
                return false;
            }

            //Create the media frame.
            self.file_frame = wp.media.frames.file_frame = wp.media({
                title: $(this).data( 'uploader_title' ),
                button: {
                     text: $(this).data( 'uploader_button_text' ),
                },
                multiple: false // Set to true to allow multiple files to be selected
            });

            //Add / Update Image on Selection
            self.file_frame.on( 'select', function() {

               attachment = self.file_frame.state().get('selection').first().toJSON();
               //Update Imge SRC and Input Value
               self.currentItem.find('.image-mask').attr('style','background-image: url("'+attachment.url+'");');
               self.currentItem.find('.upload_image_id').attr({'value': attachment.id});

               container.find('.sc_gallery_container').find('li.clear').before(self.currentItem);

               //Hide Add Button on Selection (Single Mode)
               if(self.single){
               		container.find('.sc-add-image').hide();
               }

               return false;

            });

            //Open Media Uploader
            self.file_frame.open();

            return false;
        }

        init.prototype.actions = function(self){

            //Add New Image
            this.itemContainer.on('click', '.sc-add-image', function(event){
                self.setImage(self, event, true);
            });

            //Change Image
            this.itemContainer.on('click', '.sc-set-image', function(event){
                var item = $(this).parents('.sc_gallery_item');
                self.setImage(self, event, false, item);
            });

            //Remove Image From Container/DOM
            this.itemContainer.on('click', '.remove-image', function(){
                var container = $(this).parents('.sc_gallery_item');
                container.fadeOut(600, function(){
                    container.remove();

                    //Re-display Add Button on Item Remove (Single Mode)
	                if(self.single){
	               		self.itemContainer.find('.sc-add-image').show();
	                }

                });

                return false;
            });

            //jQuery Sortable / Change Gallery Order
            if( !this.single ){
	            this.itemContainer.find('.sc_gallery_container.multiple').sortable({
	                appendTo: document.body,
	                // start: function( event, ui ) {
	                //     $('.sc_gallery_container li.clear').hide();
	                // },
	                // out: function( event, ui ) {
	                //     $('.sc_gallery_container li.clear').show();
	                // }
	            });
            }

        }

        $(container).each(function(){
	   		var self = new init($(this));
	        return self;
        });

    }

    new sc_wp_gallery_images('.sc_gallery_container');

});