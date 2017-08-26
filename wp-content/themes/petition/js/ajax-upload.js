(function($) {
    "use strict";

    function parseVideoURL(url) {

        function getParm(url, base) {
            var re = new RegExp("(\\?|&)" + base + "\\=([^&]*)(&|$)");
            var matches = url.match(re);
            if (matches) {
                return (matches[2]);
            } else {
                return ("");
            }
        }

        var retVal = {};
        var matches;
        var success = false;

        if (url.match('http(s)?://(www.)?youtube|youtu\.be')) {
            if (url.match('embed')) {
                retVal.id = url.split(/embed\//)[1].split('"')[0];
            } else {
                retVal.id = url.split(/v\/|v=|youtu\.be\//)[1].split(/[?&]/)[0];
            }
            retVal.provider = "youtube";
            retVal.url = 'https://www.youtube.com/embed/' + retVal.id;
            retVal.link = 'https://www.youtube.com/watch?v=' + retVal.id;
            retVal.thumb = 'http://img.youtube.com/vi/' + retVal.id + '/maxresdefault.jpg';
            retVal.settings = {
                color: 'white',
                theme: 'light',
                controls: 1,
                rel: 0,
                modestbranding: 1,
                showinfo: 0,
                modestbranding: 1
            };
            success = true;
        } else if (matches = url.match(/^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/)) {
            retVal.provider = "vimeo";
            retVal.id = matches[5];
            retVal.url = 'http://player.vimeo.com/video/' + retVal.id;
            retVal.link = 'https://vimeo.com/' + retVal.id;
            $.ajax({
                type:'GET',
                url: 'http://vimeo.com/api/v2/video/' + retVal.id + '.json',
                jsonp: 'callback',
                dataType: 'jsonp',
                success: function(data){
                    retVal.thumb = data[0].thumbnail_large;
                    $('#new_thumb').val(retVal.thumb);
                    console.log(data)
                }
            });
            retVal.settings = {
                color: 'ffffff',
                badge: 0,
                byline: 0,
                portrait: 0,
                title: 0
            };
            success = true;
        } else {
            retVal.url = url;
            success = true;
        }

        if (success) {
            return retVal;
        } else {
            alert('No valid media id detected');
        }
    }

    var newImage = '';
    if (typeof(plupload) !== 'undefined') {
        var uploader = new plupload.Uploader(ajax_vars.plupload);
        uploader.init();
        uploader.bind('FilesAdded', function(up, files) {
            $.each(files, function(i, file) {
                $('#aaiu-upload-imagelist').append(
                    '<div id="' + file.id + '" style="margin-bottom:5px;font-size:12px;">' +
                    file.name + ' (' + plupload.formatSize(file.size) + ') <div></div>' +
                    '</div>');

            });
            up.refresh(); // Reposition Flash/Silverlight
            uploader.start();
        });

        uploader.bind('UploadProgress', function(up, file) {
            $('#' + file.id + " div").html('<div class="ui active inverted dimmer" id="file-upload">' +
                '<div class="ui text loader">Loading... ' + /*file.percent*/ '</div>' +
                '</div>');
        });

        // On error occur
        uploader.bind('Error', function(up, err) {
            $('#gallery-upload-message').html('<div class="ui error message"><i class="close icon"></i><div class="header">Error: ' + err.code + '</div>' +
                '<p> Message: ' + err.message +
                (err.file ? ', File: ' + err.file.name : '') +
                '</p></div>'
            );
            up.refresh(); // Reposition Flash/Silverlight
        });

        uploader.bind('FileUploaded', function(up, file, response) {
            var result = $.parseJSON(response.response);

            $('#' + file.id).remove();
            if (result.success) {
                newImage += '~~~' + result.html;
                $('#new_gallery').val(newImage);
                $('#new_attach').val(result.attach);
                $('#imagelist').append('<div class="ui fluid bordered image" style="margin-bottom:10px" id="' + result.attach + '"><img src="' + result.html + '" alt="thumb" /><label class="ui top right attached label deleteImage"><i class="right trash icon"></i>Delete</label></div>');

                $('#upload-tool').css('display', 'none');
                $('#box-upload').removeClass('box-upload');
            }
        });

        $('#aaiu-uploader').on('click', function(e) {
            uploader.start();
            e.preventDefault();
            uploader.refresh();
        });
    }

    $('#step-four').on('click', function() {
        uploader.refresh();
    });
    $('#next-four').on('click', function() {
        uploader.refresh();
    });

    jQuery("#imagelist").on("click", ".deleteImage", function() {
        var photos = jQuery("#new_gallery").val();
        var photo_id = jQuery("#new_attach").val();
        if (!photo_id) {
            photo_id = jQuery("#edit_attach").val();
        }
        var delPhoto = jQuery(this).prev('img').attr('src');
        var newPhotos = photos.replace('~~~' + delPhoto, '');
        newImage = newPhotos;
        $.post(ajax_vars.ajaxurl, {'action': 'conikal_delete_file', 'attach_id': photo_id});
        jQuery("#new_gallery").val(newPhotos);
        jQuery("#new_attach").val('');
        jQuery("#edit_attach").val('');
        jQuery(this).parent().remove();

        $('#upload-tool').css('display', 'block');
        $('#box-upload').addClass('box-upload');
        uploader.refresh();
    });

    var edit_avatar = $('#edit_avatar').val();
    if (edit_avatar) {
        var current_avatar = $('#edit_avatar').val();
        if (current_avatar != '') {
            newImage += '~~~' + current_avatar;
            $('#new_gallery').val(newImage);
            $('#imagelist').append('<div class="uploaded_images"><img src="' + current_avatar + '" alt="thumb" /><div class="deleteImage"><span class="fa fa-trash-o"></span></div></div>');
        }
    }

    var edit_gallery = $('#edit_gallery').val();
    if (edit_gallery) {
        var current_gallery = $('#edit_gallery').val();
        var images = current_gallery.split("~~~");

        for (var i = 1; i < images.length; i++) {
            newImage += '~~~' + images[i];
            $('#new_gallery').val(newImage);
            $('#imagelist').append('<div class="ui fluid bordered image" style="margin-bottom:10px"><img src="' + images[i] + '" alt="thumb" /><label class="ui top right attached label deleteImage"><i class="right trash icon"></i>Delete</label></div>');
        }
        $('#upload-tool').css('display', 'none');
        $('#box-upload').removeClass('box-upload');
    }

    var edit_video = $('#edit_video').val();
    if (edit_video) {
        var video_url = $('#edit_video').val(),
            video = parseVideoURL(video_url);
        $('#embed-media').embed({
            url: video.url,
            placeholder: video.thumb,
            parameters: video.settings
        }).css('display', 'block');
        $('#new_video').val(video.link);
        $('#new_thumb').val(video.thumb);
        $('#upload-tool').css('display', 'none');
        $('#delete-embed').css('display', 'block');
        $('#box-upload').removeClass('box-upload');
    }

    $('#embed-btn').on('click', function() {
        var video_url = $('#video_url').val(),
            video = parseVideoURL(video_url);
        $('#embed-media').embed({
            url: video.url,
            placeholder: video.thumb,
            parameters: video.settings
        }).css('display', 'block');
        $('#new_video').val(video.link)
        $('#new_thumb').val(video.thumb)
        $('#upload-tool').css('display', 'none')
        $('#delete-embed').css('display', 'block')
        $('#box-upload').removeClass('box-upload')
    });

    $('#delete-embed').on('click', function() {
        $('#new_video').val('')
        $('#new_thumb').val('')
        $('#embed-media').embed('reset').css('display', 'none')
        $('#delete-embed').css('display', 'none')
        $('#upload-tool').css('display', 'block')
        $('#box-upload').addClass('box-upload')
        uploader.refresh();
    });


    // Petition video
    var petition_video_url = $('#video-url').val();
    var petition_thumb_url = $('#thumb-url').val();
    if (petition_video_url) {
        var video_url = $('#video-url').val(),
            video = parseVideoURL(video_url);
        $('#media-embed').embed({
            url: video.url,
            placeholder: petition_thumb_url,
            parameters: video.settings
        });
    }

})(jQuery);