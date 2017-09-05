var map;
var appMap;
var geocoder;

(function($) {
    "use strict";

    function urlParam(name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
            return null;
        } else {
            return results[1] || 0;
        }
    }

    function getPathFromUrl(url) {
        return url.split("?")[0];
    }

    function guestSign() {
        var name = $('#nameSign').val();
        var email = $('#emailSign').val();
        if(email != "") {
        var username = email.split('@', 1);
            username = username[0];
        } else {
            username = "";
        }
        var pass = $('#passSign').val();
        var address = $('#addressSign').val();
        var pincode = $('#pincodeSign').val();
        var city = $('#citySign').val();
        var state = $('#stateSign').val();
        var neighborhood = $('#neighborhoodSign').val();
        var country = $('#countrySign').val();
        var lat = $('#latSign').val();
        var lng = $('#lngSign').val();
        var security = $('#securitySignup').val();
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';

        $('.submitSign').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_user_signup_form',
                'signup_user': username,
                'signup_name': name,
                'signup_email': email,
                'signup_pass': pass,
                'signup_repass': pass,
                'signup_address': address,
                'signup_pincode': pincode,
                'signup_city': city,
                'signup_state': state,
                'signup_neighborhood': neighborhood,
                'signup_country': country,
                'signup_lat': lat,
                'signup_lng': lng,
                'security': security
            },
            success: function(data) {
                $('.submitSign').removeClass('loading disabled');
                if (data.signedup === true) {
                    if ($('.fb-publish').hasClass('checked')) {
                        fbPublish();
                    }
                    var message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                    $('#usernameSignin').val(username);
                    $('#passwordSignin').val(pass);
                    $('#signSignin').val('true');
                    $('#signMessage').empty().append(message);
                    userSignin();
                } else {
                    var message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="warning circle icon"></i>' + data.message +
                        '</div>';
                    $('#signMessage').empty().append(message);
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    $('.submitSign').click(function() {
        guestSign();
    });

    $('#usernameSign, #firstnameSign, #lastnameSign, #emailSign, #passSign').keydown(function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            guestSign();
        }
    });

    function userSignup() {
        var name = $('#nameSignup').val();
        var email = $('#emailSignup').val();
        if(email != "") {
        var username = email.split('@', 2);
        var userpart = username[1].split('.', 1);
            username = username[0] + '_' + userpart[0];
        }else {
            userpart = "";
            username = "";
        }
        var pass = $('#passSignup').val();
        var repass = $('#repassSignup').val();
        var address = $('#addressSignup').val();
        var pincode = $('#pincodeSignup').val();
        var city = $('#citySignup').val();
        var state = $('#stateSign').val();
        var neighborhood = $('#neighborhoodSignup').val();
        var country = $('#countrySignup').val();
        var lat = $('#latSignup').val();
        var lng = $('#lngSignup').val();
        var security = $('#securitySignup').val();
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';

        $('#submitSignup').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_user_signup_form',
                'signup_user': username,
                'signup_name': name,
                'signup_email': email,
                'signup_pass': pass,
                'signup_repass': repass,
                'signup_address': address,
                'signup_pincode': pincode,
                'signup_city': city,
                'signup_state': state,
                'signup_neighborhood': neighborhood,
                'signup_country': country,
                'signup_lat': lat,
                'signup_lng': lng,
                'security': security
            },
            success: function(data) {
                $('#submitSignup').removeClass('loading disabled');
                if (data.signedup === true) {
                    var message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                    $('#usernameSignin').val(username);
                    $('#passwordSignin').val(pass);
                    $('#signSignin').val('false');
                    $('#signinMessage').empty().append(message);
                    userSignin();
                } else {
                    var message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="warning circle icon"></i>' + data.message +
                        '</div>';
                    $('#signinMessage').empty().append(message);
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#submitSignup').click(function() {
        userSignup();
    });

    $('#usernameSignup, #firstnameSignup, #lastnameSignup, #emailSignup, #passSignup').keydown(function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            userSignup();
        }
    });

    function userSignin() {
        var username = $('#usernameSignin').val();
        var password = $('#passwordSignin').val();
        var security = $('#securitySignin').val();
        var remember = $('#rememberSignin').is(':checked');
        var referent = $('input[name="_wp_http_referer"]').val();
        var signature = $('#signSignin').val();
        var comment = $('#sign-comment').val();
        if ($('#email-notice').hasClass('checked')) {
            var notice = false;
        } else {
            var notice = true;
        }
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';

        $('#submitSignin').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_user_signin_form',
                'signin_user': username,
                'signin_pass': password,
                'remember': remember,
                'security': security,
                'referent': referent,
                'signature': signature,
                'comment': comment,
                'notice': notice,
                'post_id': services_vars.post_id
            },
            success: function(data) {
                $('#submitSignin').removeClass('loading disabled');
                if (data.signedin === true) {
                    var message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                    $('#signinMessage').empty().append(message);
                    document.location.href = data.referent;
                } else {
                    var message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="warning circle icon"></i>' + data.message +
                        '</div>';
                    $('#signinMessage').empty().append(message);
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#submitSignin').click(function() {
        userSignin();
    });

    $('#usernameSignin, #passwordSignin').keydown(function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            userSignin();
        }
    });

    function forgotPassword() {
        var email = $('#emailForgot').val();
        var postID = $('#postID').val();
        var security = $('#securityForgot').val();
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';

        $('#submitForgot').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_forgot_pass_form',
                'forgot_email': email,
                'security-login': security,
                'postid': postID
            },

            success: function(data) {
                $('#submitForgot').removeClass('loading disabled');
                $('#emailForgot').val('');

                if (data.sent === true) {
                    var message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                    $('#forgotMessage, #resetPassMessage').empty().append(message)
                    $('#forgot-password').modal('hide')
                    $('#resetpass').modal('show')
                    $('#resetLogin').val(data.login)
                } else {
                    var message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="warning circle icon"></i>' + data.message +
                        '</div>';
                    $('#forgotMessage').empty().append(message)
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#submitForgot').click(function() {
        forgotPassword();
    });

    $('#emailForgot').keydown(function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            forgotPassword();
        }
    });

    if (urlParam('action') && urlParam('action') == 'rp') {
        setTimeout(function(){
            $('#resetpass').modal('show')
            $('#resetKey').val(urlParam('key')).parent().addClass('disabled')
        }, 3000)
    }

    function resetPassword() {
        var pass_1 = $('#resetPass_1').val();
        var pass_2 = $('#resetPass_2').val();
        var key = urlParam('key') || $('#resetKey').val();
        var login = urlParam('login') || $('#resetLogin').val();
        var security = $('#securityResetpass').val();
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';

        $('#submitResetPass').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_reset_pass_form',
                'pass_1': pass_1,
                'pass_2': pass_2,
                'key': key,
                'login': login,
                'security-reset': security
            },

            success: function(data) {
                $('#submitResetPass').removeClass('loading disabled');
                $('#resetPass_1').val('');
                $('#resetPass_2').val('');

                if (data.reset === true) {
                    var message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                    $('#resetpass').modal('hide');
                    $('#signin-modal').modal('show').on('shown.bs.modal', function(e) {
                        $('#signinMessage').empty().append(message);
                    });
                } else {
                    var message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="warning circle icon"></i>' + data.message +
                        '</div>';
                    $('#resetPassMessage').empty().append(message);
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#submitResetPass').click(function() {
        resetPassword();
    });

    $('#resetKey, #resetPass_1, #resetPass_2').keydown(function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            resetPassword();
        }
    });

    $('#fbLoginBtn').on('click', function() {
        $('.signinFBText').addClass('loading disabled');
        fbLogin();
    });

    function fbLogin() {
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                var newUser = getUserInfo(function(user) {
                    var newUserAvatar = getUserPhoto(function(photo) {
                        wpFBLogin(user, photo);
                    });
                });
            } else if (response.status === 'not_authorized') {
                FB.login(function(response) {
                    if (response.authResponse) {
                        var newUser = getUserInfo(function(user) {
                            var newUserAvatar = getUserPhoto(function(photo) {
                                wpFBLogin(user, photo);
                            });
                        });
                    } else {
                        $('.signinFBText').removeClass('loading disabled');
                        var message = '<div class="ui error message">' +
                            '<i class="close icon"></i><i class="warning circle icon"></i>' + services_vars.fb_login_error +
                            '</div>';
                        $('#signinMessage').empty().append(message);
                    }
                }, {
                    scope: 'email, public_profile, publish_actions, user_birthday'
                });
            } else {
                FB.login(function(response) {
                    if (response.authResponse) {
                        var newUser = getUserInfo(function(user) {
                            var newUserAvatar = getUserPhoto(function(photo) {
                                wpFBLogin(user, photo);
                            });
                        });
                    } else {
                        $('.signinFBText').removeClass('laoding disabled');
                        var message = '<div class="ui error message">' +
                            '<i class="close icon"></i><i class="warning circle icon"></i>' + services_vars.fb_login_error +
                            '</div>';
                        $('#signinMessage').empty().append(message);
                    }
                }, {
                    scope: 'email, public_profile, publish_actions, user_birthday'
                });
            }
        });
    }

    function getUserInfo(callback) {
        FB.api('/me', {
            fields: 'name, first_name, middle_name, last_name, email, birthday, gender, cover'
        }, function(response) {
            callback(response);
        });
    }

    function getUserPhoto(callback) {
        FB.api('/me/picture?type=large', function(response) {
            callback(response.data.url);
            console.log(response)
        });
    }

    function wpFBLogin(user, photo) {
        var userid = user.id;
        var username = user.first_name;
        username = username.toLowerCase().replace(' ', '') + userid;
        var cover = '';
        var security = $('#securitySignin').val();
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        console.log(user)
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_facebook_login',
                'user_id': userid,
                'signin_user': username,
                'full_name': user.name,
                'first_name': user.first_name,
                'last_name': user.last_name,
                'email': user.email,
                'birthday': user.birthday,
                'gender': user.gender,
                'cover': cover,
                'avatar': photo,
                'security': security
            },
            success: function(data) {
                $('.signinFBText').removeClass('laoding disabled');
                if (data.signedin === true) {
                    var message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                    $('#signinMessage').empty().append(message);
                    document.location.href = services_vars.signin_redirect;
                } else {
                    var message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="warning circle icon"></i>' + data.message +
                        '</div>';
                    $('#signinMessage').empty().append(message);
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#googleSigninBtn').click(function() {
        $('#googleSigninBtn').addClass('disabled loading');
        var additionalParams = {
            'callback': googleSignin,
            'scope': 'profile email'
        };
        gapi.auth.signIn(additionalParams);
    });

    function googleSignin(authResult) {
        if (authResult['status']['signed_in']) {
            gapi.client.load('plus', 'v1', gapiClientLoaded);
        } else {
            $('#googleSigninBtn').removeClass('disabled loading');
            var message = '<div class="ui error message">' +
                '<i class="close icon"></i><i class="warning circle icon"></i>' + services_vars.google_signin_error +
                '</div>';
            $('#signinMessage').empty().append(message);
        }
    }

    function gapiClientLoaded() {
        gapi.client.plus.people.get({
            userId: 'me'
        }).execute(handleGoogleResponse);
    }

    function handleGoogleResponse(resp) {
        var userid = resp.id;
        var username = resp.name.givenName;
        username = username.toLowerCase().replace(' ', '') + userid;
        var fullname = resp.displayName;
        var firstname = resp.name.givenName;
        var lastname = resp.name.familyName;
        var birthday = resp.birthday;
        var email;
        for (var i = 0; i < resp.emails.length; i++) {
            if (resp.emails[i].type === 'account') {
                email = resp.emails[i].value;
            }
        }
        var url = resp.url;
        var cover = '';
        var avatar = getPathFromUrl(resp.image.url);
        var security = $('#securitySignin').val();
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';

        console.log(resp);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_google_signin',
                'userid': userid,
                'signin_user': username,
                'full_name': fullname,
                'first_name': firstname,
                'last_name': lastname,
                'email': email,
                'birthday': birthday,
                'gender': 'male',
                'url': url,
                'cover': cover,
                'avatar': avatar,
                'security': security
            },
            success: function(data) {
                $('#googleSigninBtn').removeClass('loading disabled');
                if (data.signedin === true) {
                    var message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                    $('#signinMessage').empty().append(message);
                    document.location.href = services_vars.signin_redirect;
                } else {
                    var message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="warning circle icon"></i>' + data.message +
                        '</div>';
                    $('#signinMessage').empty().append(message);
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    // FACEBOOK PUBLISH TO WALL
    function fbPublish() {
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                fbPost();
            } else if (response.status === 'not_authorized') {
                FB.login(function(response) {
                    if (response.authResponse) {
                        fbPost();
                    }
                }, {
                    scope: 'publish_actions'
                });
            } else {
                FB.login(function(response) {
                    if (response.authResponse) {
                        fbPost();
                    }
                }, {
                    scope: 'publish_actions'
                });
            }
        });
    }

    function fbPost() {
        var content = $('.sign-comment').val();
        var url = window.location.href;

        FB.api('/me/feed', 'POST', {
                message: content,
                link: url
            },
            function(response) {
                if (response && !response.error) {
                    $('.postFB').removeClass('disabled loading');
                    $('.postFB').children('i').removeClass('facebook').addClass('checkmark');
                } else {
                    $('.postFB').removeClass('disabled loading');
                }
            });
    }

    function fbSharing() {
        var url = window.location.href;
        FB.ui({
            method: 'share',
            mobile_iframe: true,
            href: url,
        }, function(response){
            callback(response);
        });
    }

    $('.share-facebook').on('click', function(){
        fbSharing();
    });

    function fbSending() {
        var url = window.location.href;
        FB.ui({
            method: 'send',
            link: url,
        }, function(response){
            callback(response);
        });
    }

    $('.send-message').on('click', function(){
        fbSending();
    });

    function handleNoGeolocation(errorFlag) {
        if (errorFlag) {
            alert('Error: The Geolocation service failed.');
        } else {
            alert('Error: Your browser doesn\'t support geolocation.');
        }
    }

    function formatPrice(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    // FACEBOOK PUBLISHING OPTION
    $('.fb-publish').click(function() {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securitySign').val();

        if ($('.fb-publish').hasClass('checked')) {
            var publish = false;
        } else {
            var publish = true;
        }

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_facebook_publish',
                'user_id': services_vars.user_id,
                'publish': publish,
                'security': security
            },
            success: function(data) {

            },
            error: function(errorThrown) {

            }
        });
    });

    // EMAIL NOTIFY OPTION
    $('.email-notice').click(function() {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securitySign').val();

        if ($('.email-notice').hasClass('checked')) {
            var notice = false;
        } else {
            var notice = true;
        }

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_email_notice',
                'user_id': services_vars.user_id,
                'notice': notice,
                'security': security
            },
            success: function(data) {

            },
            error: function(errorThrown) {

            }
        });
    });

    // UPDATE PROFILE
    $('#updateProfileBtn').click(function() {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityUserProfile').val();
        var typeUser = $('input[name="typeUser"]:checked').val();
        $('#up_response').empty();
        $('#updateProfileBtn').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_update_user_profile',
                'user_id': $('#idUser').val(),
                'type': typeUser,
                'name': $('#nameUser').val(),
                'firstname': $('#firstnameUser').val(),
                'lastname': $('#lastnameUser').val(),
                'gender': $('input[name="genderUser"]:checked').val(),
                'nickname': $('#nicknameUser').val(),
                'email': $('#emailUser').val(),
                'birthday': $('#birthdayUser').val(),
                'address': $('#addressUser').val(),
                'pincode': $('#pincodeUser').val(),
                'neighborhood': $('#neighborhoodUser').val(),
                'state': $('#stateUser').val(),
                'city': $('#cityUser').val(),
                'country': $('#countryUser').val(),
                'lat': $('#latUser').val(),
                'lng': $('#lngUser').val(),
                'website': $('#websiteUser').val(),
                'bio': $('#bioUser').val(),
                'password': $('#passUser').val(),
                're_password': $('#repassUser').val(),
                'avatar': $('#new_gallery').val(),
                'avatar_id': $('#new_attach').val(),
                'decision_id': $('#decision_id').val(),
                'decision_title': $('#titleUser').val(),
                'decision_organization': $('#organizationUser').val(),
                'security': security
            },
            success: function(data) {
                $('#updateProfileBtn').removeClass('loading disabled');
                var message = '';
                if (data.save === true) {
                    var message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                } else {
                    var message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="warning circle icon"></i>' + data.message +
                        '</div>';
                }
                $('#up_response').empty().html(message)
                $('#decision_id').val(data.decision_id)
                if (typeUser === 'petitioner') $('#decision_status').empty()
                $('html,body').animate({ scrollTop: 0 }, 300)
            },
            error: function(errorThrown) {

            }
        });
    });

    // get content petition        
    function get_tinymce_content(id) {
        if ($('#isDesc').length > 0) {
            var content;
            var inputid = id;
            tinyMCE.triggerSave();
            var editor = tinyMCE.get(inputid);
            var textArea = jQuery('textarea#' + inputid);
            if (textArea.length > 0 && textArea.is(':visible')) {
                content = textArea.val();
            } else {
                content = editor.getContent();
            }
            return content;
        } else {
            return '';
        }
    }

    // SUBMIT PETITION
    function submitPetition() {
        var receiver = '';
        $('input[name="new_receiver[]"]').each(function(index) {
            receiver += $(this).val() + ',';
        });
        var position = '';
        $('input[name="new_position[]"]').each(function(index) {
            position += $(this).val() + ',';
        });
        var decisionmakers = '';
        $('input[name="new_decisionmakers[]"]').each(function(index) {
            decisionmakers += $(this).val() + ',';
        });

        var topics = $('#new_topics').val();

        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securitySubmitPetition').val();
        $('#finish-btn').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_save_petition',
                'new_id': $('#new_id').val(),
                'user': $('#current_user').val(),
                'title': $('#new_title').val(),
                'content': get_tinymce_content('new_content'),
                'category': $('#new_category').val(),
                'topics': topics,
                'city': $('#new_city').val(),
                'lat': $('#new_lat').val(),
                'lng': $('#new_lng').val(),
                'address': $('#new_address').val(),
                'neighborhood': $('#new_neighborhood').val(),
                'state': $('#new_state').val(),
                'country': $('#new_country').val(),
                'zip': $('#new_zip').val(),
                'receiver': receiver,
                'position': position,
                'decisionmakers': decisionmakers,
                'goal': $('#new_goal_d').val(),
                'video': $('#new_video').val(),
                'thumb': $('#new_thumb').val(),
                'gallery': $('#new_gallery').val(),
                'attach': $('#new_attach').val(),
                'status': $('#new_status').val(),
                'security': security
            },
            success: function(data) {
                var message = '';
                console.log(data);
                $('#finish-btn').removeClass('loading disabled');
                if (data.save === true) {
                    $('#new_id').val(data.propID);
                    if (data.propStatus == 'publish') {
                        $('#viewPropertyBtn').css('display', 'inline-block').attr('href', data.propLink);
                    }
                    $('#deletePropertyBtn').css('display', 'inline-block');

                    message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle large icon"></i>' + data.message +
                        '</div>';
                    $('#save-response').empty().append(message);
                    document.location.href = data.propLink;
                } else {
                    message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="warning circle large icon"></i>' + data.message +
                        '</div>';
                    $('#save-response').empty().append(message);
                }

                $('#propertyModal .modal-dialog').removeClass('modal-sm');
                $('#save_response').html(message);
                $('.close-modal').click(function() {
                    $('#save_response').empty();
                    $('#propertyModal').modal('hide');
                    $('#propertyModal .modal-dialog').addClass('modal-sm');
                });
                $('html,body').animate({ scrollTop: 0 }, 300)
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#finish-btn').click(function() {
        submitPetition();
    });

    // SET NEW GOAL
    function setGoal(post_id, goal) {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityDashboard').val();

        $('#approve-goal').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_set_goal',
                'post_id': post_id,
                'goal': goal,
                'security': security
            },
            success: function(data) {
                $('#approve-goal').removeClass('loading disabled');
                document.location.href = data.link;
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#approve-goal').on('click', function() {
        var post_id = $(this).attr('data-id');
        var goal = $('#new-goal').val();
        setGoal(post_id, goal);
    });

    // REOPEN AND CLOSE PETITION
    function statusPetition(id, post_id, status) {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityDashboard').val();

        $(id).addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_status_petition',
                'post_id': post_id,
                'status': status,
                'security': security
            },
            success: function(data) {
                $(id).removeClass('loading disabled');
                document.location.href = data.link;
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#approve-reopen').on('click', function() {
        var post_id = $(this).attr('data-id');
        statusPetition('#approve-reopen', post_id, 0);
    });

    $('#approve-close').on('click', function() {
        var post_id = $(this).attr('data-id');
        statusPetition('#approve-close', post_id, 2);
    });

    // ADD UPDATE PETITION
    function postUpdate() {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityUpdate').val();
        $('#submitUpdate').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_add_update_petition',
                'user_id': services_vars.user_id,
                'post_id': services_vars.post_id,
                'update_id': $('#update_id').val(),
                'status': $('#status').val(),
                'title': $('#update_title').val(),
                'content': get_tinymce_content('update_content'),
                'type': $('#update_type').val(),
                'media': $('#update_media').val(),
                'petition_id': $('#petition_id').val(),
                'gallery': $('#new_gallery').val(),
                'video': $('#new_video').val(),
                'thumb': $('#new_thumb').val(),
                'attach': $('#new_attach').val(),
                'security': security
            },
            success: function(data) {
                var message = '';
                var update = '';
                $('#submitUpdate').removeClass('loading disabled');
                if (data.status === true) {
                    message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle large icon"></i>' + data.message +
                        '</div>';
                    document.location.href = data.link;
                } else {
                    message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="check circle large icon"></i>' + data.message +
                        '</div>';
                }
                $('#update-response').empty().append(message);
                $('html,body').animate({ crollTop: 0 }, 300)
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#submitUpdate').click(function() {
        postUpdate();
    });

    // DELETE UPDATE PETITION
    function deleteUpdate(update_id) {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityUpdate').val();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_delete_update',
                'update_id': update_id,
                'security': security
            },
            success: function(data) {
                if (data.delete == true) {
                    $('#update-' + update_id).fadeOut(300);
                }
            }
        });
    }

    $(document).on('click', 'a.delete-update', function() {
        var update_id = $(this).attr('data-id');
        deleteUpdate(update_id);
    });

    // LOAD MORE UPDATES
    function loadUpdates(offset) {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityUpdate').val();

        $('#updates-more').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_load_updates_petition',
                'user_id': services_vars.user_id,
                'post_id': services_vars.post_id,
                'offset': offset,
                'security': security
            },
            success: function(data) {
                $('#updates-more').removeClass('loading disabled');
                if (data.status == true) {
                    var updates = '';
                    var html = '';
                    $.each(data.updates, function(id, update) {
                        html += '<div class="ui fluid card" id="update-' + update.id + '">' +
                            '<div class="content">' +
                            '<div class="right floated meta">' +
                            '<div class="ui icon top right pointing dropdown edit-update">' +
                            '<i class="angle down icon"></i>' +
                            '<div class="menu">' +
                            '<a href="' + update.edit_link + '" class="item" data-bjax>' + services_vars.edit + '</a>' +
                            '<a href="javascript:void(0)" class="item delete-update" data-id="' + update.id + '">' + services_vars.delete + '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="header">' +
                            '<a href="' + update.link + '" data-bjax>' + update.title + '</a>' +
                            '</div>' +
                            '<div class="description">' +
                            '<div class="ui grid">' +
                            '<div class="sixteen wide mobile sixteen tablet thirteen wide computer column update-excertp">' +
                            update.excerpt +
                            '</div>' +
                            '<div class="three wide column computer only">' +
                            '<a href="' + update.link + '" data-bjax>' +
                            '<img class="ui fluid image" id="thumbnail-post" src="' + update.thumbnail + '">' +
                            '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="extra content">'
                        if (update.comment > 0) {
                            html += '<span>' +
                                '<i class="comments icon"></i>' +
                                update.comment + ' '.services_vars.comments +
                                '</span>';
                        }
                        html += '<span class="right floated">' + update.date + '</span>' +
                            '</div>' +
                            '</div>';
                    });

                    $('#update-list').append(html);
                    $('#updates-more').attr('data-offset', (parseInt(offset) + parseInt(data.per_page)));
                    if (parseInt(data.updates.length) < parseInt(data.per_page)) {
                        $('#updates-more').css('display', 'none');
                    }
                    $('.edit-update').dropdown();
                } else {
                    $('#updates-more').css('display', 'none');
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#updates-more').on('click', function() {
        var offset = $(this).attr('data-offset');
        loadUpdates(offset);
    });

    $('.signBtn').click(function() {
        signPetition('.signBtn');
        addComment('.sign-comment', '.signBtn', true);
        if ($('.fb-publish').hasClass('checked') && $('.signBtn').hasClass('signPetition')) {
            fbPublish();
        }
    });

    $('.postFB').click(function() {
        if ($('.postFB').children('i').hasClass('facebook')) {
            $('.postFB').addClass('disabled loading');
            fbPublish();
        }
    });

    // SIGN PETITION
    function signPetition(id) {
        var petition_id = $('#petition_id').val();
        if (petition_id == '') {
            petition_id = services_vars.post_id;
        }
        var reason = $('.sign-comment').val();

        if ($('.email-notice').hasClass('checked')) {
            var notice = true;
        } else {
            var notice = false;
        }

        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securitySign').val();

        $(id).addClass('loading disabled');
        if ($(id).hasClass('signPetition')) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxURL,
                data: {
                    'action': 'conikal_add_to_signatures',
                    'user_id': services_vars.user_id,
                    'post_id': petition_id,
                    'reason': reason,
                    'notice': notice,
                    'security': security
                },
                success: function(data) {
                    $(id).removeClass('loading disabled');
                    if (data.addsign === true) {
                        $('.fav_no').html(data.number);
                        $('.ned_no').html(data.need);
                        $(id).removeClass('signPetition').addClass('signedPetition');
                        $(id).children('i').removeClass('write').addClass('checkmark');
                        $('.petition-goal').progress('increment').attr('data-value', data.number);
                    }
                },
                error: function(errorThrown) {

                }
            });
        } else if ($(id).hasClass('signedPetition')) {

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxURL,
                data: {
                    'action': 'conikal_remove_from_signatures',
                    'user_id': services_vars.user_id,
                    'post_id': petition_id,
                    'security': security
                },
                success: function(data) {
                    $(id).removeClass('loading disabled');
                    if (data.removesign === true) {
                        $('.fav_no').html(data.number);
                        $('.ned_no').html(data.need);
                        $(id).removeClass('signedPetition').addClass('signPetition');
                        $(id).children('i').removeClass('checkmark').addClass('write');
                        $('.petition-goal').progress('increment').attr('data-value', data.number);
                    }
                },
                error: function(errorThrown) {

                }
            });
        }
    }

    // BOOKMARK PETITION
    function bookmarkPetition(id) {
        var post_id = services_vars.post_id;
        var user_id = services_vars.user_id;
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityBookmark').val();

        if ($(id).hasClass('bookmarkPetition')) {
            $(id).removeClass('bookmarkPetition').addClass('bookmarkedPetition');
            $(id).children('i').removeClass('remove bookmark').addClass('bookmark');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxURL,
                data: {
                    'action': 'conikal_add_to_bookmarks',
                    'user_id': user_id,
                    'post_id': post_id,
                    'security': security
                },
                success: function(data) {

                }
            });
        } else if ($(id).hasClass('bookmarkedPetition')) {
            $(id).removeClass('bookmarkedPetition').addClass('bookmarkPetition');
            $(id).children('i').removeClass('bookmark').addClass('remove bookmark');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxURL,
                data: {
                    'action': 'conikal_remove_from_bookmarks',
                    'user_id': user_id,
                    'post_id': post_id,
                    'security': security
                },
                success: function(data) {

                }
            });
        }
    }

    $('#bookmarkBtn').click(function() {
        bookmarkPetition('#bookmarkBtn');
    });


    // FOLLOW USER

    function followUser(follow_id, type) {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityFollow').val();

        if (type == 'follow') {
            $.post(ajaxURL, {'action': 'conikal_follow_user', 'user_id': services_vars.user_id, 'follow_id': follow_id, 'type': 'follow', 'security': security})
        } else if (type == 'unfollow') {
            $.post(ajaxURL, {'action': 'conikal_follow_user', 'user_id': services_vars.user_id, 'follow_id': follow_id, 'type': 'unfollow', 'security': security})
        }
    }

    $(document).on('click', 'a.follow-user', function() {
        var follow_id = $(this).attr('data-id');
        if ($(this).hasClass('follow')) {
            $(this).removeClass('basic button follow-user follow').addClass('primary button follow-user following').html('<i class="checkmark icon"></i>')
            followUser(follow_id, 'follow')
        } else if ($(this).hasClass('following')) {
            $(this).removeClass('primary button follow-user following').addClass('basic button follow-user follow').html('<i class="plus icon"></i>')
            followUser(follow_id, 'unfollow');
        }
    });

    $(document).on('click', 'a.follow-profile', function() {
        var follow_id = $(this).attr('data-id');
        if ($(this).hasClass('follow')) {
            $(this).removeClass('inverted button follow-profile follow').addClass('primary button follow-profile following').html('<i class="checkmark icon"></i>' + services_vars.following)
            followUser(follow_id, 'follow')
        } else if ($(this).hasClass('following')) {
            $(this).removeClass('primary button follow-profile following').addClass('inverted button follow-profile follow').html('<i class="plus icon"></i>' + services_vars.follow)
            followUser(follow_id, 'unfollow');
        }
    });

    $(document).on('click', 'a.follow-page', function() {
        var follow_id = $(this).attr('data-id');
        if ($(this).hasClass('follow')) {
            $(this).removeClass('basic button follow-page follow').addClass('primary button follow-page following').html('<i class="checkmark icon"></i>' + services_vars.following)
            followUser(follow_id, 'follow')
        } else if ($(this).hasClass('following')) {
            $(this).removeClass('primary button follow-page following').addClass('basic button follow-page follow').html('<i class="plus icon"></i>' + services_vars.follow)
            followUser(follow_id, 'unfollow');
        }
    });


    // FOLLOW TOPIC
    function followtopic(topic_id, type) {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityFollow').val();

        if (type == 'follow') {
            $.post(ajaxURL, {'action': 'conikal_follow_topic', 'user_id': services_vars.user_id, 'topic_id': topic_id, 'type': 'follow', 'security': security})
        } else if (type == 'unfollow') {
            $.post(ajaxURL, {'action': 'conikal_follow_topic', 'user_id': services_vars.user_id, 'topic_id': topic_id, 'type': 'unfollow', 'security': security})
        }
    }

    $(document).on('click', 'button.follow-topic', function() {
        var follow_id = $(this).attr('data-id');
        if ($(this).hasClass('follow')) {
            $(this).removeClass('follow-topic follow').addClass('follow-topic following').html(services_vars.following)
            followtopic(follow_id, 'follow')
        } else if ($(this).hasClass('following')) {
            $(this).removeClass('follow-topic following').addClass('follow-topic follow').html(services_vars.follow)
            followtopic(follow_id, 'unfollow');
        }
    });

    $(document).on('click', 'a.follow-topic', function() {
        var follow_id = $(this).attr('data-id');
        if ($(this).hasClass('follow')) {
            $(this).removeClass('inverted button follow-topic follow').addClass('primary button follow-topic following').html('<i class="checkmark icon"></i>' + services_vars.following)
            followtopic(follow_id, 'follow')
        } else if ($(this).hasClass('following')) {
            $(this).removeClass('primary button follow-topic following').addClass('inverted button follow-topic follow').html('<i class="plus icon"></i>' + services_vars.follow)
            followtopic(follow_id, 'unfollow');
        }
    });


    // ADD NEW COMMENT
    function addComment(id, submit, parent, sign) {
        if ($(id).val().length > 0) {
            var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
            var security = $('#securityComment').val();
            var content = $(id).val();
            content = content.replace(/\n\r?/g, '<br/>');
            if (!parent) {
                parent = 0;
            }
            var count = $('#comment-count').text();

            $(submit).addClass('loading disabled');

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxURL,
                data: {
                    'action': 'conikal_add_comments',
                    'user_id': services_vars.user_id,
                    'post_id': services_vars.post_id,
                    'content': content,
                    'parent': parent,
                    'security': security
                },
                success: function(data) {
                    $(submit).removeClass('loading disabled');
                    $(id).val('');
                    if (data.save == true) {
                        var comment = '<div class="comment" id="comment-' + data['details'].comment_ID + '">' +
                            '<a class="avatar"><img class="ui bordered image" src="' + data['details'].comment_author_avatar + '"></a>' +
                            '<div class="content">' +
                            '<a class="author">' + data['details'].comment_author_name + '</a>' +
                            '<div class="metadata">' +
                            '<div class="date">' + data.time + '</div>' +
                            '<div class="date"> · </div>' +
                            '<div class="rating"><span id="vote-num-' + data['details'].comment_ID + '">0</span> ' + services_vars.comment_vote + '</div>' +
                            '</div>' +
                            '<div class="text">' + data['details'].comment_content + '</div>' +
                            '<div class="actions">' +
                            '<a href="javascript:void(0)" class="vote up" id="vote-' + data['details'].comment_ID + '" data-author="' + data['details'].comment_author_name + '" data-id="' + data['details'].comment_ID + '"><i class="thumbs up icon"></i>' + services_vars.comment_up_vote + '</a>' +
                            '<a href="javascript:void(0)" class="reply" id="comment-reply" data-author="' + data['details'].comment_author_name + '" data-id="' + data['details'].comment_ID + '"><i class="reply icon"></i>' + services_vars.comment_reply + '</a>' +
                            '<a href="javascript:void(0)" class="edit" id="edit-' + data['details'].comment_ID + '" data-author="' + data['details'].comment_author_name + '" data-id="' + data['details'].comment_ID + '"><i class="pencil icon"></i>' + services_vars.edit + '</a>' +
                            '<a href="javascript:void(0)" class="delete" id="delete-' + data['details'].comment_ID + '" data-author="' + data['details'].comment_author_name + '" data-id="' + data['details'].comment_ID + '"><i class="delete icon"></i>' + services_vars.delete + '</a>' +
                            '</div>' +
                            '</div>';
                        if (data['details'].comment_parent == 0) {
                            comment += '<div class="comments" id="replies-' + data['details'].comment_ID + '"></div>';
                        }
                        comment += '</div>';
                        if (data['details'].comment_parent == 0) {
                            $('#comments-list').append(comment);
                        } else {
                            $('#replies-' + data['details'].comment_parent).append(comment);
                        }
                        $('#comment-count').text(parseInt(count) + 1);
                        $('#no-comment').empty();
                        $('#content-comment').attr('placeholder', services_vars.comment_placeholder).css('height', '40px');
                        $('#comment-parent').val('');
                    } else {
                        $(submit).removeClass('loading disabled');
                        var message = '<div class="ui error message">' +
                            '<i class="close icon"></i><i class="warning circle icon"></i>' + data.message +
                            '</div>';
                        $('#commentMessage').empty().append(message);
                    }
                },
                error: function() {
                    $(submit).removeClass('loading disabled');
                }
            });
        } else {
            if (sign == false) {
                $('#field-comment').addClass('error');
            }
        }
    }

    $('#content-comment').keydown(function(e) {
        if (e.keyCode == 13 && !e.shiftKey && services_vars.is_mobile == 'false') {
            var parent_id = $('#comment-parent').val();
            addComment('#content-comment', '#submitComment', parent_id, false);
            e.preventDefault();
        }
    });

    $('#send-comment').on('click', function(){
        var parent_id = $('#comment-parent').val();
        addComment('#content-comment', '#submitComment', parent_id, false);
    });

    $('#content-comment').click(function() {
        $('#field-comment').removeClass('error');
    });

    // UPVOTE COMMENT
    function voteComment(comment_id, type) {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityComment').val();

        var vote_number = $('#vote-num-' + comment_id).text();
        if (type == 'up') {
            vote_number = (parseInt(vote_number) + 1);
            $('#vote-num-' + comment_id).text(vote_number);
            $('#vote-' + comment_id).removeClass('up').addClass('down').html('<i class="thumbs down icon"></i>' + services_vars.comment_down_vote);
        } else if (type == 'down') {
            vote_number = (parseInt(vote_number) - 1);
            $('#vote-num-' + comment_id).text(vote_number);
            $('#vote-' + comment_id).removeClass('down').addClass('up').html('<i class="thumbs up icon"></i>' + services_vars.comment_up_vote);
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_vote_comment',
                'user_id': services_vars.user_id,
                'post_id': services_vars.post_id,
                'comment_id': comment_id,
                'type': type,
                'security': security
            },
            success: function(data) {
                if (data.status == true) {

                }
            },
            error: function() {

            }
        });
    }

    $(document).on('click', 'a.vote', function() {
        var comment_id = $(this).attr('data-id');
        if ($(this).hasClass('up')) {
            voteComment(comment_id, 'up');
        } else if ($(this).hasClass('down')) {
            voteComment(comment_id, 'down');
        }

    });

    // UPDATE COMMENT
    function updateComment(comment_id) {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityComment').val();
        var content = $('#comment-editor-' + comment_id).val();
        content = content.replace(/\n\r?/g, '<br/>');

        $('#comment-edit-submit-' + comment_id).addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_update_comment',
                'user_id': services_vars.user_id,
                'post_id': services_vars.post_id,
                'comment_id': comment_id,
                'content': content,
                'security': security
            },
            success: function(data) {
                $('#comment-edit-submit-' + comment_id).removeClass('loading disabled');
                if (data.status == true) {
                    $('#comment-content-' + comment_id).html(data.content);
                } else {
                    var message = '<div class="ui small error message">' +
                        '<i class="close icon"></i><i class="warning circle icon"></i>' + data.message +
                        '</div>';
                    $('#comment-edit-message-' + comment_id).html(message);
                }
            },
            error: function() {

            }
        });
    }

    $(document).on('click', 'a.comment-edit-submit', function() {
        var comment_id = $(this).attr('data-id');
        updateComment(comment_id);
    });

    // DELETE COMMENT
    function deleteComment(comment_id) {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityComment').val();

        var count = $('#comment-count').text();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_delete_comment',
                'user_id': services_vars.user_id,
                'post_id': services_vars.post_id,
                'comment_id': comment_id,
                'security': security
            },
            success: function(data) {
                if (data.status == true) {
                    $('#comment-' + data.id).fadeOut(200);
                    $('#comment-count').text(parseInt(count) - 1);
                }
            }
        });
    }

    $(document).on('click', 'a.delete', function() {
        var comment_id = $(this).attr('data-id');
        deleteComment(comment_id);
    });

    // LOAD MORE COMMENT
    function loadComments(parent_id, offset) {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var comment_number = $('#comment-number').val();
        var reply_number = $('#reply-number').val();

        if (parent_id == 0) {
            $('#comment-more').addClass('loading disabled');
            var offset = $('#comment-offset').val();
        } else {
            var offset = 0;
        }

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_load_comments',
                'user_id': services_vars.user_id,
                'post_id': services_vars.post_id,
                'parent_id': parent_id,
                'offset': offset
            },
            success: function(data) {
                $('#comment-more').removeClass('loading disabled');
                if (data.status == true) {
                    var html = '';
                    $.each(data.comments, function(id, comment) {
                        html += '<div class="comment" id="comment-' + comment.comment_ID + '">' +
                            '<a href="' + comment.comment_author_link + '" class="avatar" data-bjax><img class="ui bordered image" src="' + comment.comment_author_avatar + '"></a>' +
                            '<div class="content">' +
                            '<a href="' + comment.comment_author_link + '" class="author" data-bjax>' + comment.comment_author_name + '</a>' +
                            '<div class="metadata">' +
                            '<div class="date">' + comment.comment_time + '</div>' +
                            '<div class="date"> · </div>' +
                            '<div class="rating"><span id="vote-num-' + comment.comment_ID + '">' + comment.comment_vote + '</span> ' + services_vars.comment_vote + '</div>' +
                            '</div>' +
                            '<div class="text" id="comment-content-' + comment.comment_ID + '"><p>' + comment.comment_content + '</p></div>' +
                            '<div class="actions">';
                        if (comment.comment_voted == true) {
                            html += '<a href="javascript:void(0)" class="vote down" id="vote-' + comment.comment_ID + '" data-author="' + comment.comment_author_name + '" data-id="' + comment.comment_ID + '"><i class="thumbs up icon"></i>' + services_vars.comment_down_vote + '</a>';
                        } else {
                            html += '<a href="javascript:void(0)" class="vote up" id="vote-' + comment.comment_ID + '" data-author="' + comment.comment_author_name + '" data-id="' + comment.comment_ID + '"><i class="thumbs up icon"></i>' + services_vars.comment_up_vote + '</a>';
                        }
                        html += '<a href="javascript:void(0)" class="reply" id="reply-' + comment.comment_ID + '" data-author="' + comment.comment_author_name + '" data-id="' + comment.comment_ID + '"><i class="reply icon"></i>' + services_vars.comment_reply + '</a>';
                        if (services_vars.user_id == comment.user_id || services_vars.administrator == 1) {
                            html += '<a href="javascript:void(0)" class="edit" id="edit-' + comment.comment_ID + '" data-author="' + comment.comment_author_name + '" data-id="' + comment.comment_ID + '"><i class="pencil icon"></i>' + services_vars.edit + '</a>';
                            html += '<a href="javascript:void(0)" class="delete" id="delete-' + comment.comment_ID + '" data-author="' + comment.comment_author_name + '" data-id="' + comment.comment_ID + '"><i class="delete icon"></i>' + services_vars.delete + '</a>';
                        }
                        html += '</div>' +
                            '</div>';
                        if (parent_id == 0) {
                            html += '<div class="comments">';
                        }
                        if (comment.replies_total > parseInt(reply_number)) {
                            html += '<a href="javascript:void(0)" class="hide-replies" id="hide-' + comment.comment_ID + '" data-id="' + comment.comment_ID + '" style="display: none;"><i class="angle up icon"></i>' + services_vars.comment_replies_hide + '</a>';
                            html += '<a href="javascript:void(0)" class="more-replies" id="more-' + comment.comment_ID + '" data-id="' + comment.comment_ID + '"><i class="angle down icon"></i>' + services_vars.comment_view_all + ' ' + (parseInt(comment.replies.length) + parseInt(data.per_comment)) + ' ' + services_vars.comment_replies + '</a>';
                            html += '<div class="ui active mini inline loader" id="loading-' + comment.comment_ID + '" style="display: none"></div>'
                        }
                        html += '<div id="replies-' + comment.comment_ID + '">';
                        if (comment.replies) {
                            $.each(comment.replies, function(id, reply) {
                                html += '<div class="comment" id="comment-' + reply.comment_ID + '">' +
                                    '<a href="' + reply.comment_author_link + '" class="avatar" data-bjax><img class="ui bordered image" src="' + reply.comment_author_avatar + '"></a>' +
                                    '<div class="content">' +
                                    '<a href="' + reply.comment_author_link + '" class="author" data-bjax>' + reply.comment_author_name + '</a>' +
                                    '<div class="metadata">' +
                                    '<div class="date">' + reply.comment_time + '</div>' +
                                    '<div class="date"> · </div>' +
                                    '<div class="rating"><span id="vote-num-' + reply.comment_ID + '">' + reply.comment_vote + '</span> ' + services_vars.comment_vote + '</div>' +
                                    '</div>' +
                                    '<div class="text" id="comment-content-' + reply.comment_ID + '"><p>' + reply.comment_content + '</p></div>' +
                                    '<div class="actions">';
                                if (reply.comment_voted == true) {
                                    html += '<a href="javascript:void(0)" class="vote down" id="vote-' + reply.comment_ID + '" data-author="' + reply.comment_author_name + '" data-id="' + reply.comment_ID + '"><i class="thumbs up icon"></i>' + services_vars.comment_down_vote + '</a>';
                                } else {
                                    html += '<a href="javascript:void(0)" class="vote up" id="vote-' + reply.comment_ID + '" data-author="' + reply.comment_author_name + '" data-id="' + reply.comment_ID + '"><i class="thumbs up icon"></i>' + services_vars.comment_up_vote + '</a>';
                                }
                                html += '<a href="javascript:void(0)" class="reply" id="reply-' + comment.comment_ID + '" data-author="' + reply.comment_author_name + '" data-id="' + comment.comment_ID + '"><i class="reply icon"></i>' + services_vars.comment_reply + '</a>';
                                if (services_vars.user_id == reply.user_id || services_vars.administrator == 1) {
                                    html += '<a href="javascript:void(0)" class="edit" id="edit-' + reply.comment_ID + '" data-author="' + reply.comment_author_name + '" data-id="' + reply.comment_ID + '"><i class="pencil icon"></i>' + services_vars.edit + '</a>';
                                    html += '<a href="javascript:void(0)" class="delete" id="delete-' + reply.comment_ID + '" data-author="' + reply.comment_author_name + '" data-id="' + reply.comment_ID + '"><i class="delete icon"></i>' + services_vars.delete + '</a>';
                                }
                                html += '</div>' +
                                    '</div>' +
                                    '</div>';
                            });
                        }
                        html += '</div>';
                        if (parent_id == 0) {
                            html += '</div>';
                        }
                        html += '</div>';
                    });

                    if (parent_id == 0) {
                        $('#comments-list').prepend(html);
                        $('#comment-offset').val((parseInt(offset) + parseInt(data.per_page)));
                    } else {
                        $('#hide-' + parent_id).css('display', 'block');
                        $('#more-' + parent_id).css('display', 'none');
                        $('#loading-' + parent_id).css('display', 'none');
                        $('#replies-' + parent_id).html(html);
                    }
                } else {
                    $('#comment-more').removeClass('loading disabled').css('display', 'none');
                }
                if ((data.comments.length < $('#comment-number').val()) && parent_id == 0) {
                    $('#comment-more').css('display', 'none');
                }
            },
            error: function() {
                $('#comment-more').removeClass('loading disabled');
            }
        });
    }

    $('#comment-more').click(function() {
        loadComments(0);
    });

    $(document).on('click', 'a.more-replies', function() {
        var parent_id = $(this).attr('data-id');
        var offset = $(this).attr('data-offset');
        loadComments(parent_id, offset);
        $('#loading-' + parent_id).css('display', 'block');

    });

    $(document).on('click', 'a.hide-replies', function() {
        var parent_id = $(this).attr('data-id');
        $('#more-' + parent_id).css('display', 'block');
        $('#hide-' + parent_id).css('display', 'none');
        $('#replies-' + parent_id).html('');
    });

    // REPLY COMMENT
    $(document).on('click', 'a.reply', function() {
        var comment_id = $(this).attr('data-id'),
            author_name = $(this).attr('data-author');
        $('#comment-parent').val(comment_id);
        $('#content-comment').attr('placeholder', services_vars.comment_reply_to + ' ' + author_name).focus();
    });

    // EDIT LETTER PETITION
    $('#save-letter').on('click', function() {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var letter = $('#textarea-letter').val();
        letter = letter.replace(/\n\r?/g, '<br/>');
        var security = $('#securityLetter').val();
        $('#letter-response').empty();
        $('#save-letter').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_update_letter',
                'post_id': services_vars.post_id,
                'letter': letter,
                'security': security
            },
            success: function(data) {
                $('#save-letter').removeClass('loading disabled');
                var message = '';
                if (data.save === true) {
                    var message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                    $('#content-letter').html(letter);
                    $('#save-letter').css('display', 'none');
                    $('#edit-letter').css('display', 'block');
                } else {
                    var message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="warning circle icon"></i>' + data.message +
                        '</div>';
                }
                $('#letter-response').empty().html(message).fadeOut(2000);
            },
            error: function(errorThrown) {

            }
        });
    });

    // LOAD MORE PETITION
    function loadPetitions(id, context) {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityPetitions').val();
        var post_number = $(id).attr('data-number');
        var typed = $(id).attr('data-type');
        var author = $(id).attr('data-author');
        var paged = $(id).attr('data-page');

        $(id).addClass('loading disabled');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': typed,
                'user_id': services_vars.user_id,
                'author_id': author,
                'paged': paged,
                'security': security
            },
            success: function(data) {
                $(id).removeClass('loading disabled');
                if (data.status == true) {
                    var html = '';
                    $.each(data.petitions, function(id, petition) {
                        html += '<div class="ui segments petition-list-card">' +
                            '<div class="ui segment">';
                        if (parseInt(petition.sign) >= parseInt(petition.goal) || petition.status == '1') {
                            html += '<div class="ui primary right corner large label victory-label"><i class="flag icon"></i></div>';
                        }
                        html += '<div class="ui grid">' +
                            '<div class="sixteen wide mobile ten wide tablet ten wide computer column">' +
                            '<div class="petition-content">' +
                            '<div class="ui grid">' +
                            '<div class="sixteen wide column">' +
                            '<div class="ui header list-petition-title">' +
                            '<div class="content">' +
                            '<div class="sub header truncate"><i class="send icon"></i>' + services_vars.petition_to + ' ' + petition.receiver + '</div>' +
                            '<a href="' + petition.link + '" data-bjax>' + petition.title + '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="sixteen wide column tablet computer only" style="padding-top: 0; padding-bottom: 0;">' +
                            '<div class="text grey">' + petition.excerpt + '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="ui grid">' +
                            '<div class="petition-footer">' +
                            '<div class="sixteen wide column">' +
                            '<span class="text grey place"><i class="marker icon"></i>' + (petition.city ? petition.city + ', ' : '') + (petition.state ? petition.state + ', ' : '') + (petition.country ? petition.country : '') + '</span>' +
                            '<div class="ui tiny indicating primary progress petition-goal" id="petition-goal" data-value="' + petition.sign + '" data-total="' + (petition.status == '1' ? petition.sign : petition.goal) + '">' +
                            '<div class="bar">' +
                            '<div class="progress"></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="sixteen wide mobile six wide tablet six wide computer column">' +
                            '<a class="ui fluid image" href="' + petition.link + '" target="_blank" data-bjax>' +
                            '<div class="ui dimmer">' +
                            '<div class="content">' +
                            '<div class="center">' +
                            '<div class="ui icon inverted circular large button"><i class="external icon"></i></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<img class="ui fluid image" id="thumbnail-post" src="' + petition.thumbnail + '">' +
                            '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="ui segment" style="border-top-color: rgba(0,0,0,.05);">' +
                            '<div class="ui grid">' +
                            '<div class="ten wide tablet ten wide computer column tablet computer only">' +
                            '<span class="ui primary label"><i class="user icon"></i>' + petition.sign_fomated + ' ' + services_vars.supporters + '</span> ' +
                            '<span class="ui label"><i class="comments icon"></i>' + petition.comments_fomated + ' ' + services_vars.comments + '</span> ';
                        if (petition.category_name) {
                            html += '<a class="ui label" href="' + petition.category_link + '" data-bjax><i class="tag icon"></i>' + petition.category_name + '</a>';
                        }
                        html += '</div>' +
                            '<div class="six wide tablet six wide computer right aligned column tablet computer only">' +
                            '<a href="' + petition.author_link + '" data-bjax>' +
                            '<strong>' + petition.author_name + '</strong> <img class="ui avatar bordered image" src="' + petition.author_avatar + '" />' +
                            '</a>' +
                            '</div>' +

                            '<div class="thirteen wide column mobile only">' +
                            '<span class="ui primary label"><i class="user icon"></i>' + petition.sign_compact + ' ' + services_vars.supporters + '</span>' +
                            '<span class="ui label"><i class="comments icon"></i>' + petition.comments_fomated + '</span> ' +
                            '</div>' +
                            '<div class="three wide right aligned column mobile only">' +
                            '<a href="' + petition.author_link + '" data-bjax>' +
                            '<img class="ui avatar bordered image" src="' + petition.author_avatar + '" />' +
                            '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    });

                    $(id).attr('data-page', (parseInt(paged) + 1));
                    $(id).attr('data-number', (parseInt(post_number) + data.found_posts));

                    // Append content
                    $(context).append(html);

                    if (data.found_posts < data.per_page || (post_number + data.found_posts) == data.total) {
                        $(id).css('display', 'none');
                    }

                    // Refresh progress
                    $('.petition-goal').progress({
                        'label': false
                    });
                } else {
                    $(id).removeClass('loading disabled').css('display', 'none');
                }
            },
            error: function() {}
        });
    }

    $('#load-more').on('click', function() {
        loadPetitions('#load-more', '#content');
    });

    $('#load-more').visibility({
        once: false,
        observeChanges: true,
        offset: 800,
        onTopVisible: function() {
            loadPetitions('#load-more', '#content');
        }
    });

    // load trending petition homepage
    $('#load-trending').on('click', function() {
        loadPetitions('#load-trending', '#content-trending');
    });

    $('#load-trending').visibility({
        once: false,
        observeChanges: true,
        offset: 800,
        onTopVisible: function() {
            loadPetitions('#load-trending', '#content-trending');
        }
    });

    // load recent petition homepage
    $('#load-recent').on('click', function() {
        loadPetitions('#load-recent', '#content-recent');
    });

    $('#load-recent').visibility({
        once: false,
        observeChanges: true,
        offset: 800,
        onTopVisible: function() {
            loadPetitions('#load-recent', '#content-recent');
        }
    });

    // LOAD MORE POSTS
    function loadPosts(id) {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityPosts').val();
        var post_number = parseInt($('#post-number').text());
        var typed = $(id).attr('data-type');
        var paged = $(id).attr('data-page');

        $(id).addClass('loading disabled');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': typed,
                'user_id': services_vars.user_id,
                'paged': paged,
                'security': security
            },
            success: function(data) {
                $(id).removeClass('loading disabled');
                if (data.status == true) {
                    var html = '';
                    $.each(data.posts, function(id, post) {
                        html += '<div class="card">' +
                            '<div class="image">' +
                            '<a href="' + post.link + '" data-bjax>' +
                            '<img class="ui fluid image" src="' + post.thumbnail + '">' +
                            '</a>' +
                            '</div>' +
                            '<div class="content">' +
                            '<a href="' + post.link + '" class="header card-post-title" data-bjax>' + post.title + '</a>' +
                            '<div class="meta">' +
                            '<a href="' + post.category_link + '" data-bjax>' + post.category_name + '</a>' +
                            '</div>' +
                            '<div class="description text grey">' + post.excerpt + '</div>' +
                            '</div>' +
                            '<div class="extra content">';
                        if (post.comments) {
                            html += '<span class="right floated">' +
                                '<a href="' + post.link + '" class="header" data-bjax>' +
                                '<i class="comments icon"></i>' + post.comments +
                                '</a>' +
                                '</span>';
                        }
                        html += '<span><i class="calendar outline icon"></i>' + post.date + '</span>' +
                            '</div>' +
                            '</div>';
                    });

                    $(id).attr('data-page', (parseInt(paged) + 1));
                    $('#post-number').text((post_number + data.found_posts));
                    $('#content').append(html);
                    if (data.found_posts < data.per_page || (post_number + data.found_posts) == data.total) {
                        $(id).css('display', 'none');
                    }
                } else {
                    $(id).removeClass('loading disabled').css('display', 'none');
                }
            },
            error: function() {}
        });
    }

    $('#load-posts-more').on('click', function() {
        loadPosts('#load-posts-more');
    });

    // SEND MESSAGE TO US
    $('#sendContactMessageBtn').click(function() {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityContactPage').val();
        $('#cp_response').empty();
        $('#sendContactMessageBtn').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_send_message_to_company',
                'company_email': $('#company_email').val(),
                'name': $('#cp_name').val(),
                'email': $('#cp_email').val(),
                'subject': $('#cp_subject').val(),
                'message': $('#cp_message').val(),
                'security': security
            },
            success: function(data) {
                $('#sendContactMessageBtn').removeClass('loading disabled');
                var message = '';
                if (data.sent === true) {
                    message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                    $('#cp_name').val('');
                    $('#cp_email').val('');
                    $('#cp_subject').val('');
                    $('#cp_message').val('');
                } else {
                    message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                }

                $('#cp_response').html(message);
            },
            error: function(errorThrown) {

            }
        });
    });

    // SEND MESSAGE TO USER
    $('#sendBtn').click(function() {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityContactUser').val();
        $('#contact-response').empty();
        $('#sendBtn').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_send_message_to_user',
                'user_email': $('#user_email').val(),
                'name': $('#contact_name').val(),
                'email': $('#contact_email').val(),
                'subject': $('#contact_subject').val(),
                'message': $('#contact_message').val(),
                'security': security
            },
            success: function(data) {
                $('#sendBtn').removeClass('loading disabled');
                var message = '';
                if (data.sent === true) {
                    message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                    $('#contact_name').val('');
                    $('#contact_email').val('');
                    $('#contact_subject').val('');
                    $('#contact_message').val('');
                } else {
                    message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                }

                $('#contact-response').html(message);
            },
            error: function(errorThrown) {

            }
        });
    });

    // SEND INVITATION LETTER
    $('#send-invite').click(function() {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityInvitation').val();
        
        $('#invitation-response').empty();
        $('#send-invite').addClass('loading disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_send_invatation',
                'user_email': $('#user_email').val(),
                'name': $('#invite_name').val(),
                'email': $('#invite_email').val(),
                'subject': $('#invite_subject').val(),
                'message': $('#invite_message').val() + $('#invite_link').val(),
                'security': security
            },
            success: function(data) {
                $('#send-invite').removeClass('loading disabled');
                var message = '';
                if (data.sent === true) {
                    message = '<div class="ui success message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                } else {
                    message = '<div class="ui error message">' +
                        '<i class="close icon"></i><i class="check circle icon"></i>' + data.message +
                        '</div>';
                }

                $('#invitation-response').html(message);
            },
            error: function(errorThrown) {

            }
        });
    });

    // SEARCH DECISION MAKERS
    $(document).on('click', '.decision-search', function() {
        $('.decision-search').search({
            showNoResults: false,
            transition: 'fade down',
            minCharacters : services_vars.min_characters,
            maxResults : services_vars.max_results,
            apiSettings: {
              url: services_vars.home_url + '/decision-makers-search/?q={query}'
            },
            fields: {
              results: 'results',
              title: 'name',
              description: 'description',
              image: 'avatar'
            },
            onSelect: function(result, response) {
                $(this).find('.decision-title').val(result.description)
                $(this).find('.new_decisionmakers').val(result.author)
            }
        });
        $(this).find('.decision-title, .prompt').change(function() {
            var decisionmakers = $(this).next().val()
            if (decisionmakers) { 
                $(this).next().val('')
            }
        })
    });

    // SEARCH PETITION AUTOCOMPLETE
    var search_settings = $.parseJSON( services_vars.search_settings );
    var suggest_fiels = {
        results : 'results',
        title : 'title'
    }

    if (services_vars.is_mobile == 'false') {
        if (search_settings.conikal_s_link_field == 'enabled') { suggest_fiels.url = 'link' }
        if (search_settings.conikal_s_description_field == 'enabled') { suggest_fiels.description = 'excerpt' }
        if (search_settings.conikal_s_image_field == 'enabled') { suggest_fiels.image = 'thumbnail' }
        if (search_settings.conikal_s_supporters_field == 'enabled') { suggest_fiels.price = 'sign_compact' }
    }

    $('.petitions-search').search({
        minCharacters : services_vars.min_characters,
        transition: 'fade down',
        type: services_vars.search_type,
        apiSettings: {
            onResponse: function(petitionResponse) {
                $('.search-input').keydown(function(e){
                    if (e.keyCode === 13) {
                        e.preventDefault();
                        document.location.href = petitionResponse.action.url;
                    }
                })
                if (services_vars.search_type == 'category') {
                    var response = {
                            results : {},
                            action : petitionResponse.action
                        };
                    $.each(petitionResponse.results, function(index, item) {
                      var
                        category   = item.category_name || 'Unknown',
                        maxResults = services_vars.max_results
                      ;
                      if(index >= maxResults) {
                        return false;
                      }
                      // create new category
                      if(response.results[category] === undefined) {
                        response.results[category] = {
                          name    : category,
                          results : []
                        };
                      }
                      // add result to category
                      response.results[category].results.push({
                        title           : item.title,
                        excerpt         : item.excerpt,
                        link            : item.link,
                        thumbnail       : item.thumbnail,
                        sign_compact    : item.sign_compact
                      });
                    });
                } else {
                    response = petitionResponse;
                }
                return response;
            },
            url: services_vars.home_url + '/petitions-search/?q={query}'
        },
        fields: suggest_fiels
    });

    // PETITION SEARCH REAL-TIME
    $('.page-search').search({
        minCharacters : services_vars.min_characters,
        maxResults : services_vars.max_results,
        transition: 'fade down',
        apiSettings: {
            url: services_vars.home_url + '/petitions-search/?q={query}',
            onResponse: function(response) {
                var html = '';
                $.each(response.results, function(index, item) {
                    html += '<div class="item">';
                        html += '<div class="image">';
                            if ( parseInt(item.sign) >= parseInt(item.goal) || item.status == '1') {
                                html += '<div class="ui primary left corner label victory-label"> <i class="flag icon"></i></div>';
                            }
                                html += '<a href="' + item.link + '" data-bjax><img class="ui fluid image" src="' + item.thumbnail + '" /></a>' +
                                '</div>' +
                                '<div class="content">' +
                                    '<a class="header" href="' + item.link + '" data-bjax>' + item.title + '</a>' +
                                    '<div class="meta">' +
                                        '<span class="receiver"><i class="send icon"></i> ' + services_vars.petition_to + ' ' + item.receiver + '</span>' +
                                    '</div>' +
                                    '<div class="description">' +
                                        '<div class="text grey">' + item.excerpt + '</div>' +
                                    '</div>' +
                                    '<div class="extra">';
                                    if (services_vars.is_mobile == 'false') {
                                        html += '<div class="ui right floated tiny header">' +
                                            '<a href="' + item.author_link + '" data-bjax><strong>' + item.author_name + '</strong>' +
                                                ' <img class="ui avatar bordered image" src="' + item.author_avatar + '" />' +
                                            '</a>' +
                                        '</div>' +
                                        '<div class="ui primary label"><i class="user icon"></i>' + item.sign + ' ' + services_vars.supporters + '</div> ' +
                                        '<div class="ui label"><i class="comments icon"></i>' + item.comments + ' ' + services_vars.comments + '</div> ';
                                    } else {
                                        html += '<div class="ui right floated tiny header">' +
                                            '<a href="' + item.author_link + '" data-bjax>' +
                                                '<img class="ui avatar bordered image" src="' + item.author_avatar + '" />' +
                                            '</a>' +
                                        '</div>' +
                                        '<div class="ui primary label"><i class="user icon"></i>' + item.sign + ' ' + services_vars.supporters + '</div> ' +
                                        '<div class="ui label"><i class="comments icon"></i>' + item.comments + '</div>';
                                    }
                                    if (item.category_name && services_vars.is_mobile == 'false') {
                                        html += '<a class="ui label" href="' + item.category_link + '" data-bjax><i class="tag icon"></i>' + item.category_name + '</a>';
                                    }
                            html += '</div>' +
                                '</div>' +
                            '</div>';
                });
                $('.results-number').text(response.total);
                $('#search-results').html(html);
                $('.search-input').keydown(function(e){
                    if (e.keyCode === 13) {
                        e.preventDefault();
                        document.location.href = response.action.url;
                    }
                });
            }
        }
    });

    // FILTER SEARCH

    $('input[name="search_topics[]"], input[name="search_category[]"], input[name="search_neighborhood[]"], input[name="search_city[]"], input[name="search_state[]"], #search_country').change(function(){
        filter_search()
    });

    function filter_search() {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securitySearch').val();

        var topics = '',
            category = '', 
            neighborhood = '', 
            city = '',
            state = '',
            country = $('#search_country option:selected').val();

        $('input[name="search_topics[]"]').each(function(index) { topics += $(this).val() + ',' })
        $('input[name="search_category[]"]:checked').each(function(index) { category += $(this).val() + ',' })
        $('input[name="search_neighborhood[]"]:checked').each(function(index) { neighborhood += $(this).val() + ',' })
        $('input[name="search_city[]"]:checked').each(function(index) { city += $(this).val() + ',' })
        $('input[name="search_state[]"]:checked').each(function(index) { state += $(this).val() + ',' })

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'conikal_load_search_petitions',
                'search_keyword': $('.search-keywords').text(),
                'search_topics': topics,
                'search_category': category,
                'search_neighborhood': neighborhood,
                'search_city': city,
                'search_state': state,
                'search_country': country,
                'security': security
            },
            success: function(response) {
                var html = '';
                $.each(response.petitions, function(index, item) {
                    html += '<div class="item">';
                        html += '<div class="image">';
                            if ( parseInt(item.sign) >= parseInt(item.goal) || item.status == '1') {
                                html += '<div class="ui primary left corner label victory-label"> <i class="flag icon"></i></div>';
                            }
                                html += '<a href="' + item.link + '" data-bjax><img class="ui fluid image" src="' + item.thumbnail + '" /></a>' +
                                '</div>' +
                                '<div class="content">' +
                                    '<a class="header list-petition-title" href="' + item.link + '" data-bjax>' + item.title + '</a>' +
                                    '<div class="meta">' +
                                        '<span class="receiver"><i class="send icon"></i> ' + services_vars.petition_to + ' ' + item.receiver + '</span>' +
                                    '</div>' +
                                    '<div class="description">' +
                                        '<div class="text grey">' + item.excerpt + '</div>' +
                                    '</div>' +
                                    '<div class="extra">';
                                    if (services_vars.is_mobile == 'false') {
                                        html += '<div class="ui right floated tiny header">' +
                                            '<a href="' + item.author_link + '" data-bjax><strong>' + item.author_name + '</strong>' +
                                                ' <img class="ui avatar bordered image" src="' + item.author_avatar + '" />' +
                                            '</a>' +
                                        '</div>' +
                                        '<div class="ui primary label"><i class="user icon"></i>' + item.sign + ' ' + services_vars.supporters + '</div> ' +
                                        '<div class="ui label"><i class="comments icon"></i>' + item.comments + ' ' + services_vars.comments + '</div> ';
                                    } else {
                                        html += '<div class="ui right floated tiny header">' +
                                            '<a href="' + item.author_link + '" data-bjax>' +
                                                '<img class="ui avatar bordered image" src="' + item.author_avatar + '" />' +
                                            '</a>' +
                                        '</div>' +
                                        '<div class="ui primary label"><i class="user icon"></i>' + item.sign + ' ' + services_vars.supporters + '</div> ' +
                                        '<div class="ui label"><i class="comments icon"></i>' + item.comments + '</div>';
                                    }
                                    if (item.category_name && services_vars.is_mobile == 'false') {
                                        html += '<a class="ui label" href="' + item.category_link + '" data-bjax><i class="tag icon"></i>' + item.category_name + '</a>';
                                    }
                            html += '</div>' +
                                '</div>' +
                            '</div>';
                });
                $('.results-number').text(response.total);
                $('#search-results').html(html);
                $('html,body').animate({ crollTop: 0 }, 300)
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#reset-filter').on('click', function() {
        $('#form-filter')[0].reset()
        $('#search_country').dropdown('restore defaults')
        $('#search_topics').dropdown('restore defaults')
        filter_search()
    });


    // PLACE AUTOCOMPLATE
    if ($('#new_address').length > 0) {
        var stateOptions = {
            types: ['(regions)'],
            language: ['en']
        }
        var address = document.getElementById('new_address');
        var addressAuto = new google.maps.places.Autocomplete(address, stateOptions);
        google.maps.event.addListener(addressAuto, 'place_changed', function() {
            var place = addressAuto.getPlace();
            $('#new_address').blur();
            //setTimeout(function() { $('#new_address').val(place.name); }, 1);
            var lat = place.geometry.location.lat,
                lng = place.geometry.location.lng;

            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];

                var val = place.address_components[i].short_name;

                if (addressType === 'administrative_area_level_1') {
                    $('#new_state').val(val);
                } else if (addressType === 'administrative_area_level_2') {
                    $('#new_city').val(val);
                } else if (addressType === 'locality') {
                    $('#new_city').val(val);
                } else if (addressType === 'sublocality') {
                    $('#new_neighborhood').val(val);
                } else if (addressType === 'neighborhood') {
                    $('#new_neighborhood').val(val);
                } else if (addressType === 'sublocality_level_1') {
                    $('#new_neighborhood').val(val);
                } else if (addressType === 'country') {
                    $('#new_country').val(val);
                } else if (addressType === 'postal_code') {
                    $('#new_zip').val(val);
                }

            }

            $('#new_lat').val(lat);
            $('#new_lng').val(lng);

            return false;
        });
    }

    $('#new_address').keydown(function(){
        if ($(this).val().length <= 1) {
            $('#new_country').val('');
            $('#new_state').val('');
            $('#new_city').val('');
            $('#new_neighborhood').val('');
            $('#new_zip').val('');
            $('#new_lat').val('');
            $('#new_lng').val('');
        }
    });

    function place_autocomplete(id) {
        var stateOptions = {
            types: ['(regions)'],
            language: ['en']
        }
        if ($('#address' + id).length > 0) {
            var address = document.getElementById('address' + id);
            var addressAuto = new google.maps.places.Autocomplete(address, stateOptions);
            google.maps.event.addListener(addressAuto, 'place_changed', function() {
                var place = addressAuto.getPlace();
                $('#address' + id).blur();
                //setTimeout(function() { $('#new_address').val(place.name); }, 1);
                var lat = place.geometry.location.lat,
                    lng = place.geometry.location.lng;

                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];

                    var val = place.address_components[i].short_name;

                    if (addressType === 'administrative_area_level_1') {
                        $('#state' + id).val(val);
                    } else if (addressType === 'administrative_area_level_2') {
                        $('#city' + id).val(val);
                    } else if (addressType === 'locality') {
                        $('#city' + id).val(val);
                    } else if (addressType === 'sublocality') {
                        $('#neighborhood' + id).val(val);
                    } else if (addressType === 'neighborhood') {
                        $('#neighborhood' + id).val(val);
                    } else if (addressType === 'sublocality_level_1') {
                        $('#neighborhood' + id).val(val);
                    } else if (addressType === 'country') {
                        $('#country' + id).val(val);
                    } else if (addressType === 'postal_code') {
                        $('#zip' + id).val(val);
                    }

                }
                $('#lat' + id).val(lat);
                $('#lng' + id).val(lng);
                return false;
            });
        }
        $('#address' + id).keydown(function(){
            if ($(this).val().length <= 1) {
                $('#country' + id).val('');
                $('#state' + id).val('');
                $('#city' + id).val('');
                $('#neighborhood' + id).val('');
                $('#zip' + id).val('');
                $('#lat' + id).val('');
                $('#lng' + id).val('');
            }
        });
    }

    place_autocomplete('Sign');
    place_autocomplete('Signup');
    place_autocomplete('User');

})(jQuery);