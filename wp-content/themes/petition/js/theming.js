(function($) {
    "use strict";

    // BJAX INIT
    $(document).on('click', '[data-bjax]', function(e) {
        new Bjax(this);
        $('.bjax-backdrop').append('<div class="bjax-loading-wrapper">' + theming_vars.html_preloader + '</div>');
        $('html,body').scrollTop(0);
        e.preventDefault();
    });

    // DIMMER
    $(document).on("hover", '.blogs.post .image, .team, .petition-list-card .ui.image', function(e) {
      if(e.type == "mouseenter") {
        $(this).dimmer('show')
      }
      else if (e.type == "mouseleave") {
        $(this).dimmer('hide')
      }
    });

    $('.searchBtn, .searchBtnMobile').on('click', function() {
        $('.search-menu').css('display', 'block')
        $('#leftside-menu').sidebar('hide')
        $('.search-input').focus()
    });

    $('#closeSearch').on('click', function() {
        $('.search-menu').css('display', 'none')
    });

    // TYPE USER BUTTON
    $('.typeUser').on('click', function() {
        var typeUser = $("input[name='typeUser']:checked").val()
        if ( typeUser == 'decisioner' ) {
            $('#decision-fields').css('display','none')
            $('#decision-custom-fields').css('display','none')
            $('#petitioner').removeClass('grey button').addClass('primary button')
            $('#decisioner').removeClass('primary button').addClass('grey button')
        } else {
            $('#decision-fields').css('display','flex')
            $('#decision-custom-fields').css('display','flex')
            $('#decisioner').removeClass('grey button').addClass('primary button')
            $('#petitioner').removeClass('primary button').addClass('grey button')
        }
    });

    // DROPDOWN MENU
    $('.edit-update, .more-share, #search_topics, select.dropdown').dropdown();
    $('.category-select').dropdown('set selected', $('#category_id').val());
    $('.decision-title-select').dropdown('set selected', $('#decision_title_id').val());
    $(' .user-menu, .header-submenu, .more-share, .nav-submenu').dropdown({on: 'hover'});

    // SEARCH TOPICS AUTOCOMPLETE
    $('#topics-search').dropdown({
        apiSettings: {
            url: theming_vars.home_url + '/topics-search?q={query}'
        },
        allowReselection: true,
        allowAdditions: true,
        hideAdditions: false,
        maxSelections: 5
    });
    var set_topics = [];
    $('input[name="current_topics[]"]').each(function(index) {
        var topic = $(this).val();
        set_topics.push(topic);
    });
    $('#topics-search').dropdown('set exactly', set_topics);

    $('.search-petition').keyup(function(){
        var keyword = $(this).val();
        $('.search-keywords').text(keyword);
    });

    // SEARCH ORGANIZATION DECISION MAKER
    $('#organization-search').dropdown({
        apiSettings: {
            url: theming_vars.home_url + '/organization-search?q={query}'
        },
        allowReselection: true,
        allowAdditions: true,
        hideAdditions: false,
        maxSelections: 1
    });
    $('#organization-search').dropdown('set selected', $('#decision_organization_name').val() );

    // SIDEBAR MENU
    $('#left-menu-btn').on('click', function() {
        $('#leftside-menu').sidebar('toggle', {
            transition: 'overlay'
        })
    });

    $('#mobile-sign-btn').on('click', function() {
        $('#sign-sidebar').sidebar('toggle', {
            transition: 'overlay'
        })
    });

    $('#close-mobile-sign').on('click', function() {
        $('#sign-sidebar').sidebar('toggle')
    });

    // MESSAGE CLOSE
    $(document).on('click', '.message .close', function() {
        $('.message .close').closest('.message').transition('fade');
    });

    // TRANSITION
    $('.new-comment').transition('fade');

    // ACCORDION
    $('.ui.accordion').accordion();

    // PROGRESS
    $('.petition-goal').progress({
        'label': false
    });

    // STICKY
    $('#sign-sticky').sticky({
        context: '#content',
        offset: 60,
        observeChanges: true
    });

    $('#sign-category').sticky({
        context: '#content',
        offset: 70,
        observeChanges: true
    });

    $('#about-sticky').sticky({
        context: '#content',
        offset: 70,
        observeChanges: true
    });

    $('#tab-sticky, #navigation-sticky').sticky({
        context: '#main-content, #content',
        offset: 0,
        observeChanges: true,
        onStick: function() {
            $(this).addClass('color white');
        },
        onUnstick: function() {
            $(this).removeClass('color white');
        }
    });

    $('#share-post').sticky({
        context: '#content',
        offset: 200,
        observeChanges: true
    });

    // POPUP
    $('#share-message').popup();
    $('.social-share .button, .social-share .item').popup();

    // ADD RECEIDER
    var max_fields = 10; //maximum input boxes allowed
    var wrapper = $(".input-fields-wrap"); //Fields wrapper
    var add_button = $(".add-field-button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e) { //on add input button click
        e.preventDefault();
        if (x < max_fields) { //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="ui grid search decision-search">' +
                '<div class="sixteen wide mobile eight wide tablet eight wide computer column">' +
                '<div class="ui large fluid input">' +
                '<input class="prompt" type="text" id="new_receiver" name="new_receiver[]" placeholder="' + theming_vars.full_name_holder + '" value="">' +
                '<input class="new_decisionmakers" type="hidden" name="new_decisionmakers[]" value="">' +
                '</div>' +
                '</div>' +
                '<div class="sixteen wide mobile eight wide tablet eight wide computer column">' +
                '<div class="ui large fluid input">' +
                '<input class="decision-title" type="text" id="new_postion" name="new_position[]" placeholder="' + theming_vars.position_holder + '" value="">' +
                '</div>' +
                '</div>' +
                '<div class="results"></div>' +
                '<a href="#" class="remove-field"><i class="inverted circular close link icon"></i></a>' +
                '</div>'); //add input box
        }
    });

    $(wrapper).on("click", ".remove-field", function(e) { //user click on remove text
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });

    // SETTING CAROWSEL
    $('.post-carousel').slick({
        dots: true,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 3,
        adaptiveHeight: true,
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                variableWidth: true,
                arrows: false
              }
            }
          ]
    });

    $('.testimonial-carousel').slick({
        dots: true,
        infinite: true,
        autoplay: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        appendArrows: '',
    });

    $('.feature-petition').slick({
        adaptiveHeight: true,
        lazyLoad: 'progressive',
        asNavFor: '.feature-navigation'
    });

    $('.feature-navigation').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        asNavFor: '.feature-petition',
        centerMode: true,
        centerPadding: '40px',
        appendArrows: '',
        focusOnSelect: true
    });

    // MODAL SETTING
    $('.ui.modal').modal({
        transition: 'fade down'
    });

    $('.signin-btn').on('click', function() {
        $('#signinModal').modal('show');
        $('#userLoginForm').css('display', 'block');
        $('#userSignupForm').css('display', 'none');
        $('#signin-button').css('display', 'none');
        $('#signup-button').css('display', 'inline-block');
    });
    $('.signup-btn, .signup-guest').on('click', function() {
        $('#signinModal').modal('show');
        $('#userLoginForm').css('display', 'none');
        $('#userSignupForm').css('display', 'block');
        $('#signin-button').css('display', 'inline-block');
        $('#signup-button').css('display', 'none');
    });
    $('.forgot-password').on('click', function() {
        $('#forgot-password').modal('show');
    });
    $('#set-goal').on('click', function() {
        $('#set-goal-confirm').modal('show');
        $('#goal-number').text($('#new-goal').val());
        $('#goal-response').empty();
    });
    $('#reopen-petition').on('click', function() {
        $('#reopen-confirm').modal('show')
    });
    $('#close-petition').on('click', function() {
        $('#close-confirm').modal('show')
    });
    $('#contact-btn').on('click', function() {
        $('#contact-user').modal('show')
    });
    $('#invite-leader-to-lead-btn').on('click', function() {
        $('#request-issue-support').modal('show')
    });
    $('.invite-responsive').on('click', function() {
        var email = $(this).attr('data-email');
        $('#invite-modal').modal('show')
        $('#invitation-response').empty();
        $('#invite_email').val(email);
    })
    $('#invita-cancel').on('click', function() {
        $('#invite-modal').modal('hide')
    })

    // CHECKBOX
    $('.ui.checkbox').checkbox();

    $('#up_birthday').calendar({
        startMode: 'year',
        type: 'date',
        formatter: {
            date: function(date, settings) {
                if (!date) return '';
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                return month + '/' + day + '/' + year;
            }
        }
    });

    // PETITION TAB
    $('#petition-tab .item').tab();
    $('#petition-tab .item').on('click', function(){
        $('html,body').animate({
            scrollTop: $('#main-content').offset().top 
        }, 300);
    });

    // STEP BY STEP SUBMIT
    function stepbystep(current) {
        var one = 'step-one',
            two = 'step-two',
            three = 'step-three',
            four = 'step-four';

        $('html,body').animate({
            scrollTop: 0
        }, 500);

        if (current === one) {
            $.tab('change tab', one);
            $('#step-one').addClass('active').removeClass('completed');
            $('#step-two').removeClass('active completed')
            $('#step-three').removeClass('active completed')
            $('#step-four').removeClass('active completed')

            $('#next-two').css('display', 'inline-block');
            $('#next-three').css('display', 'none');
            $('#next-four').css('display', 'none');
            $('#finish-btn').css('display', 'none');

            $('#back-one').css('display', 'none');
            $('#back-two').css('display', 'none');
            $('#back-three').css('display', 'none');

            $('.step-one').transition('fade down');
            $('.step-two').transition('hide');
            $('.step-three').transition('hide');
            $('.step-four').transition('hide');
        } else if (current === two) {
            $.tab('change tab', two);
            $('#step-one').removeClass('active').addClass('completed');
            $('#step-two').addClass('active').removeClass('completed disabled');
            $('#step-three').removeClass('active completed')
            $('#step-four').removeClass('active completed')

            $('#next-two').css('display', 'none');
            $('#next-three').css('display', 'inline-block');
            $('#next-four').css('display', 'none');
            $('#finish-btn').css('display', 'none');

            $('#back-one').css('display', 'inline-block');
            $('#back-two').css('display', 'none');
            $('#back-three').css('display', 'none');

            $('.step-one').transition('hide');
            $('.step-two').transition('fade down');
            $('.step-three').transition('hide');
            $('.step-four').transition('hide');
        } else if (current === three) {
            $.tab('change tab', three);
            $('#step-one').removeClass('active').addClass('completed');
            $('#step-two').removeClass('active').addClass('completed');
            $('#step-three').addClass('active').removeClass('completed disabled');
            $('#step-four').removeClass('active completed')

            $('#next-two').css('display', 'none');
            $('#next-three').css('display', 'none');
            $('#next-four').css('display', 'none');
            $('#finish-btn').css('display', 'inline-block');

            $('#back-one').css('display', 'none');
            $('#back-two').css('display', 'inline-block');
            $('#back-three').css('display', 'none');

            $('.step-one').transition('hide');
            $('.step-two').transition('hide');
            $('.step-three').transition('fade down');
            $('.step-four').transition('hide');
        } else {
            $.tab('change tab', four);
            $('#step-one').removeClass('active').addClass('completed');
            $('#step-two').removeClass('active').addClass('completed');
            $('#step-three').removeClass('active').addClass('completed');
            $('#step-four').addClass('active').removeClass('completed disabled');

            $('#next-two').css('display', 'none');
            $('#next-three').css('display', 'none');
            $('#next-four').css('display', 'none');
            $('#finish-btn').css('display', 'inline-block');

            $('#back-one').css('display', 'none');
            $('#back-two').css('display', 'none');
            $('#back-three').css('display', 'inline-block');

            $('.step-one').transition('hide');
            $('.step-two').transition('hide');
            $('.step-three').transition('hide');
            $('.step-four').transition('fade down');
        }
    }

    $('.step-two').transition('hide');
    $('.step-three').transition('hide');
    $('.step-four').transition('hide');
    $('#step-one').on('click', function() {
        stepbystep('step-one')
    });
    $('#step-two').on('click', function() {
        stepbystep('step-two')
    });
    $('#step-three').on('click', function() {
        stepbystep('step-three')
    });
    $('#step-four').on('click', function() {
        stepbystep('step-four')
    });

    $('#next-two').click(function() {
        stepbystep('step-two')
    });
    $('#next-three').click(function() {
        stepbystep('step-three')
    });
    $('#next-four').click(function() {
        stepbystep('step-four')
    });

    $('#back-one').click(function() {
        stepbystep('step-one')
    });
    $('#back-two').click(function() {
        stepbystep('step-two')
    });
    $('#back-three').click(function() {
        stepbystep('step-three')
    });

    //SHADOW IMAGE
    if ($('#slideshow > div').length > 1) {
        $("#slideshow > div:gt(0)").hide();

        setInterval(function() {
            $('#slideshow > div:first')
                .fadeOut(1000)
                .next()
                .fadeIn(1000)
                .end()
                .appendTo('#slideshow');
        }, 6000);
    }

    // FIX MENU WHEN PASSED
    if (theming_vars.type_menu != 'none') {
        $('.masthead').visibility({
            once: false,
            onBottomPassed: function() {
                $('.menu-home').removeClass('inverted menu').addClass('fixed menu header-menu');
                $('.fixed-logo').transition('fade in').css('display', 'block');
                $('.inverted-logo').transition('hide');

                if ( $('.signup-btn').hasClass('inverted') && $('.signin-btn').hasClass('inverted') ) {
                    $('.signup-btn').removeClass('inverted button').addClass('green button signup-btn-style')
                    $('.signin-btn').removeClass('inverted button').addClass('primary button')
                }
                if ( $('#add-petition-btn').hasClass('inverted') ) {
                    $('#add-petition-btn').removeClass('inverted button').addClass('primary button')
                }
            },
            onBottomPassedReverse: function() {
                $('.menu-home').removeClass('fixed menu header-menu').addClass('inverted menu');
                $('.fixed-logo').transition('hide');
                $('.inverted-logo').transition('fade in');

                if ( !$('.signup-btn').hasClass('inverted') && !$('.signin-btn').hasClass('inverted') ) {
                    $('.signup-btn').removeClass('green button signup-btn-style').addClass('inverted button')
                    $('.signin-btn').removeClass('primary button').addClass('inverted button')
                    $('.btn-modal').removeClass('inverted button').addClass('button signup-btn-style')
                }

                if ( !$('#add-petition-btn').hasClass('inverted') ) {
                    $('#add-petition-btn').removeClass('primary button').addClass('inverted button')
                }

            }
        });
    } else {
        $('.header-menu').removeClass('fixed menu').addClass('menu')
        $('#wrapper').css('padding-top', '1px')
    }

    // FIX COMMENT BOX WHEN PASSED
    if (theming_vars.is_mobile == 'false') {
        var comment_width = $('#content').width();
        $('#comments-list').visibility({
            once: false,
            onTopVisible: function() {
                $('#comment-sticky').removeClass('sticky').addClass('fixed bottom sticky').css('width', comment_width)
            },
            onTopVisibleReverse: function() {
                $('#comment-sticky').removeClass('fixed bottom sticky').addClass('sticky').removeAttr("style")
            },
            onBottomVisible: function() {
                $('#comment-sticky').removeClass('fixed bottom sticky').addClass('sticky').removeAttr("style")
            },
            onBottomVisibleReverse: function() {
                $('#comment-sticky').removeClass('sticky').addClass('bottom fixed sticky').css('width', comment_width)
            }
        });
    }

    // FIX SIGN MENU ON MOBILE
    $('#main-petition').visibility({
        once: false,
        onTopVisible: function() {
            $('#mobile-sign-btn').removeClass('sticky').addClass('fixed bottom sticky').css('width', '100%');
        },
        onTopVisibleReverse: function() {
            $('#mobile-sign-btn').removeClass('fixed bottom sticky').addClass('sticky').removeAttr("style");
        },
        onBottomVisible: function() {
            $('#mobile-sign-btn').removeClass('fixed bottom sticky').addClass('sticky').removeAttr("style");
        },
        onBottomVisibleReverse: function() {
            $('#mobile-sign-btn').removeClass('sticky').addClass('bottom fixed sticky').css('width', '100%');
        }
    });

    // HIDEN NAVIGATION WHEN SCROLL
    var lastScrollTop = 0;
    var navHeight = $('.header-menu').height();
    $(window).scroll(function(event){
        var st = $(this).scrollTop();
        if (st > lastScrollTop && st >= navHeight){
            if (theming_vars.type_menu == 'scroll') {
                $('.header-menu').removeClass('nav-down').addClass('nav-up')
            } else if (theming_vars.type_menu == 'fixed') {
                $('#tab-sticky, #navigation-sticky').css('margin-top', '0px').removeClass('nav-down').addClass('nav-up')
            }
            $('#mobile-sign-btn').removeClass('sign-btn-down').addClass('sign-btn-up')
        } else {
            if (theming_vars.type_menu == 'scroll') {
                $('.header-menu').removeClass('nav-up').addClass('nav-down')
            } else if (theming_vars.type_menu == 'fixed') {
                $('#tab-sticky, #navigation-sticky').css('margin-top', '0px').removeClass('nav-up').addClass('nav-down')
            }
            $('#mobile-sign-btn').removeClass('sign-btn-up').addClass('sign-btn-down')
        }
       lastScrollTop = st;
    });

    // MENU NAVIGATION ACTIVE
    $(document).on("scroll", onScroll);

    function onScroll(event){
        var scrollPos = $(document).scrollTop();
        $('#navigation-menu a').each(function () {
            var currLink = $(this);
            var refElement = $(currLink.attr("href"));
            if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                $('#navigation-menu a').removeClass("active");
                currLink.addClass("active");
            }
            else{
                currLink.removeClass("active");
            }
        });
    }

    $('a[href^="#"]').on('click', function (e) {
        e.preventDefault();
        $(document).off("scroll");
        
        $('a').each(function () {
            $(this).removeClass('active');
        })
        $(this).addClass('active');
        var target = this.hash,
        menu = target,
        $target = $(target);
              
       $('html, body').stop().animate({
            'scrollTop': $target.offset().top+2
        }, 600, 'swing', function () {
            window.location.hash = target;
            $(document).on("scroll", onScroll);
        });
    });


    // BACK TO TOP
    if ($('#back-to-top').length) {
        var scrollTrigger = 100, // px
            backToTop = function() {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#back-to-top').addClass('show');
                } else {
                    $('#back-to-top').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function() {
            backToTop();
        });
        $('#back-to-top').on('click', function(e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 600);
        });
    }

    // COMMENT FOLLOW HEIGHT
    $('.auto-height').bind('keydown', autosize);

    function autosize() {
        var el = this;
        setTimeout(function() {
            el.style.cssText = 'height:' + (el.scrollHeight + 2) + 'px;';
        }, 0);
    }

    // BLOG FEATURE HIGHT
    var blogfeatureHeigh = $('#blog-featured').height() + 150;
    if (theming_vars.is_mobile == 'true') {
        $('#blog-hero-container, .blog-hero').attr('style', 'height: ' + blogfeatureHeigh + 'px')
    }

    // LETTER EDIT FORM
    $('#edit-letter').on('click', function() {
        var letter_content = $('#content-letter').html();
        letter_content = letter_content.replace(/<br\s*[\/]?>/gi, "\n");
        var html = '<textarea id="textarea-letter" rows="20" style="width: 100%; border: 0;">' +
            letter_content +
            '</textarea>';
        $('#content-letter').html(html).focus();
        $('#save-letter').css('display', 'block');
        $('#edit-letter').css('display', 'none');
    });

    // EDIT COMMENT FORM
    $(document).on('click', 'a.edit', function() {
        var comment_id = $(this).attr('data-id');
        var content_height = $('#comment-content-' + comment_id).height() + 20;
        var comment_content = $('#comment-content-' + comment_id).find('p').html();
        comment_content = comment_content.replace(/<br\s*[\/]?>/gi, "\n");
        var html = '<div class="respon-message" id="comment-edit-message-' + comment_id + '"></div><div class="ui form"><div class="field"><textarea rows="1" class="auto-height" id="comment-editor-' + comment_id + '" style="width: 100%; height: ' + content_height + 'px">' +
            comment_content +
            '</textarea></div>' +
            '<a href="javascript:void(0)" class="ui right floated mini button comment-edit-cancel" id="comment-edit-cancel-' + comment_id + '" data-id="' + comment_id + '">' + theming_vars.cancel + '</a>' +
            ' <a href="javascript:void(0)" class="ui primary right floated mini button comment-edit-submit" id="comment-edit-submit-' + comment_id + '" data-id="' + comment_id + '"><i class="save icon"></i>' + theming_vars.save + '</a>' +
            '</div>';
        $('#comment-content-' + comment_id).html(html).focus();
    });

    $(document).on('click', 'a.comment-edit-cancel', function() {
        var comment_id = $(this).attr('data-id');
        var content = $('#comment-editor-' + comment_id).val();
        content = content.replace(/\n\r?/g, '<br/>');
        $('#comment-content-' + comment_id).html(content);
    });

    $('#supporters-list, #region-list').slimScroll({
        height: '450px',
        size: '3px'
    });

    // COPY TO CLIPBOARD
    $('#copy-link').on('click', function() {
        copyToClipboardMsg(document.getElementById("short-link"), 'msg-copy');
    });

    function copyToClipboardMsg(elem, msgElem) {
        var succeed = copyToClipboard(elem);
        var msg;
        if (!succeed) {
            msg = '<i class="remove icon"></i>' + theming_vars.copy_clipboard_err
        } else {
            msg = '<i class="checkmark icon"></i>' + theming_vars.copy_clipboard
        }
        if (typeof msgElem === "string") {
            msgElem = document.getElementById(msgElem);
        }
        msgElem.innerHTML = msg;
        setTimeout(function() {
            msgElem.innerHTML = "";
        }, 2000);
    }

    function copyToClipboard(elem) {
        // create hidden text element, if it doesn't already exist
        var targetId = "_hiddenCopyText_";
        var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
        var origSelectionStart, origSelectionEnd;
        if (isInput) {
            // can just use the original source element for the selection and copy
            target = elem;
            origSelectionStart = elem.selectionStart;
            origSelectionEnd = elem.selectionEnd;
        } else {
            // must use a temporary form element for the selection and copy
            target = document.getElementById(targetId);
            if (!target) {
                var target = document.createElement("textarea");
                target.style.position = "absolute";
                target.style.left = "-9999px";
                target.style.top = "0";
                target.id = targetId;
                document.body.appendChild(target);
            }
            target.textContent = elem.textContent;
        }
        // select the content
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);

        // copy the selection
        var succeed;
        try {
            succeed = document.execCommand("copy");
        } catch (e) {
            succeed = false;
        }
        // restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }

        if (isInput) {
            // restore prior selection
            elem.setSelectionRange(origSelectionStart, origSelectionEnd);
        } else {
            // clear temporary content
            target.textContent = "";
        }
        return succeed;
    }

})(jQuery);