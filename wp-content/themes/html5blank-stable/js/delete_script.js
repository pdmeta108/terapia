jQuery( document ).ready( function($) {
    $(document).on( 'click', '.delete-post', function() {
        var id = $(this).data('id');
        var nonce = $(this).data('nonce');
        var post = $(this).parents('.videos:first');
        $.ajax({
            type: 'post',
            url: MyAjax.ajaxurl,
            data: {
                action: 'my_delete_post',
                nonce: nonce,
                id: id
            },
            success: function( result ) {
                if( result == 'success' ) {
                    post.fadeOut( function(){
                        post.parentNode.removeChild(post);
                    });
                }
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
        return false;
    });
});