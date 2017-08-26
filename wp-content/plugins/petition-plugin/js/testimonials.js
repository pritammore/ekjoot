(function($) {
    "use strict";

    $('#testimonialsAvatarBtn').click(function() {
        tb_show('', 'media-upload.php?width=800&amp;height=500&amp;type=image&amp;TB_iframe=true');
        $('#TB_ajaxWindowTitle').html('Customer Avatar Photo');
        window.send_to_editor = function(html) {
            var imgURL = $('img',html).attr('src');
            $('#testimonials_avatar').val(imgURL);
            tb_remove();
        }
        return false;
    });

})(jQuery);