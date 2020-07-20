let notificationMsgs = localStorage.getItem('notificationMsgs') ? JSON.parse(localStorage.getItem('notificationMsgs')) : [];
let mailboxMsgs = localStorage.getItem('mailboxMsgs') ? JSON.parse(localStorage.getItem('mailboxMsgs')) : [];
let ad_space_4 = "";
let server_error = getCookie('server_error');

$.ajax({
    url: "/ads/4", 
    success: function(data){
        ad_space_4 = data;
    }
});

$(document).on('click', '.mail-item', function () {
    var id = $(this).attr('id');
    $("#tm-message > div").fadeOut(100);
    if($(this).hasClass('active')) {
        $(this).removeClass('active');
        $("#tm-message > .no-mails").delay(100).fadeIn(100);
    } else {
        $(".mail-item").removeClass('active');
        $(this).addClass('active');
        $("#tm-message > .no-mails").fadeOut(100);
        if($("#content-"+id+" .tm_ads").length == 0) {
            $("#content-"+id).prepend("<div class='tm_ads'>"+$(".tm-message > span.ad_space_2")[0].innerHTML+"</div>");
            $("#content-"+id).append("<div class='tm_ads'>"+$(".tm-message > span.ad_space_3")[0].innerHTML+"</div>");
        }
        $("#content-"+id).delay(100).fadeIn(100);
        $('html, body').animate({
            scrollTop: $("header").offset().top
        }, 500);
    }
});

$(document).on('keyup', 'input[name="search"]', function () {
    mails = document.querySelectorAll('.mail-item');
    mails.forEach(mail => {
        if(document.querySelector(`#content-${mail.id}`).innerText.toLowerCase().includes(this.value.toLowerCase())) {
            mail.hidden = false
            if(mail.classList.contains('active')) {
                mail.classList.remove('active');
                document.querySelector(`#content-${mail.id}`).style.display = "none";
                $("#tm-message > .no-mails").delay(100).fadeIn(100);
            }
        } else {
            mail.hidden = true
        }
    })
});

$(document).on('click', '.tm-domain-selector', function () {
    if($(this).hasClass('open')) {
        $(this).removeClass('open');
    } else {
        $(this).addClass('open');
    }
});

$(document).on('click', '.domain-selector', function () {
    var value = $(this).text();
    $("input[type='hidden'][name='domain']").val(value.replace('@', ''));
    $("#selected-domain").html(value);
});

$(document).on('click', '#btn-new', function () {
    $( "#actions-flip > .front" ).slideUp( 300, function() {
        $( "#actions-flip > .back" ).slideDown( 300 );
    });
});

$(document).on('click', '#btn-cancel', function () {
    $( "#actions-flip > .back" ).slideUp( 300, function() {
        $( "#actions-flip > .front" ).slideDown( 300 );
    });
});

$(document).on('click', '.action-item', function () {
    var action = $(this).attr('action');
    if(action == "delete") {
        $.post("/mailbox/delete", {
            "_token": $('#token').val()
        },
        function(data, status){
            if(data) {
                window.location.href = "/mailbox/"+data;
            } else {
                window.location.href = "/";
            }
        });
    } else if (action == "copy") {
        var input = document.getElementById("current-id");
        var isiOSDevice = navigator.userAgent.match(/ipad|iphone/i);
        if (isiOSDevice) {
            var editable = input.contentEditable;
            var readOnly = input.readOnly;
            input.contentEditable = true;
            input.readOnly = false;
            var range = document.createRange();
            range.selectNodeContents(input);
            var selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
            input.setSelectionRange(0, 999999);
            input.contentEditable = editable;
            input.readOnly = readOnly;
        } else {
            input.select();
        }
        document.execCommand('copy');
        input.blur();
    } else if (action == "refresh") {
        if($(".refresh > span.icon > i").hasClass("stop-spinner")) {
            return true;
        }
        if($(".refresh > span.icon > i").hasClass("pause-spinner")) {
            $(".refresh > span.icon > i").removeClass("pause-spinner");
            var currentRequest = null;  
            currentRequest = $.ajax({
                url: "/mail/fetch?new=true", 
                beforeSend : function()    {           
                    if(currentRequest != null) {
                        currentRequest.abort();
                    }
                },
                success: function(data){
                    if(data.length > 0) {
                        $("#mails > p").remove();
                    }
                    fetch(data, true);
                    setCookie('server_error', false, 20);
                    server_error = false;
                },
                error: function(data, status) {
                    setCookie('server_error', true, 20);
                    if(!server_error) {
                        location.reload();
                    }
                    Swal.fire({
                        type: status,
                        title: 'Oops...',
                        text: notificationMsgs.error.common,
                        confirmButtonText: notificationMsgs.button.reload,
                        footer: '<a href="/faq">'+notificationMsgs.faq+'</a>',
                        onClose: function(){ location.reload(); }
                    });
                    $("#mails").html("<p>ERROR</p>");
                    $(".refresh > span.icon > i").addClass("pause-spinner");
                    $(".refresh > span.icon > i").addClass("stop-spinner");
                }
            });
        }
    }
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

$(document).on('click', '.close-mail-content', function () {
    $(".mail-item").removeClass('active');
    $(".mail-content").fadeOut(100);
});

$(document).on('click', '.snackbar', function () {
    var msg = $(this).attr('msg');
    $("#snackbar").html(msg);
    $("#snackbar").addClass('show');
    setTimeout(function(){ 
        $("#snackbar").removeClass('show');
    }, 3000);
});

$(document).on('click', '#toggle', function () {
    $(this).toggleClass('active');
    $('#overlay').toggleClass('open');
});

function fetch(mails, newFetch = false) {
    $(".refresh > span.icon > i").addClass("pause-spinner");
    $.each( mails, function( key, value ) {
        if(key == "length") {
            return true;
        }
        $("#mails").prepend('<div id="mail-'+key+'" class="mail-item"><div class="row sender-time"><div class="col-6 sender">'+value['sender_name']+'</div><div class="col-6 time">'+value['short_time']+'</div></div><div class="subject">'+value['subject']+'</div><div class="message">'+value['text'].substring(0, 150)+'</div></div>');
        if(($("#mails > div").length) % 4 == 0) {
            if(ad_space_4.length > 0) {
                $("#mails").prepend("<div class='mail-item'>"+ad_space_4+"</div>");
            }
        }

        value['html'] = value['html'].replace("href", "target='_blank' href");

        var message = '<div id="content-mail-'+key+'" class="mail-content"><div class="close-mail-content"><i class="fas fa-angle-double-left"></i><span>View all mails</span></div><div class="subject">'+value['subject']+'</div><div class="row sender-time"><div class="col-md-9 sender">'+value['sender_name']+' - '+value['sender_email']+'</div><div class="col-md-3 time">'+value['time']+'</div></div><span class="mail-delete" uid="'+key+'"><i class="fas fa-trash-alt"></i></span><span class="mail-download" key="'+key+'" subject="'+value['subject'].replace(/ /g, "_")+'"><i class="fas fa-save"></i></span><div class="message">'+value['html']+'</div><div class="attachments">';
        $.each( value['attachments'], function( akey, avalue ) {
            message += '<a href="'+avalue['path']+'" download="" target="_blank"><i class="fas fa-paperclip"></i>'+avalue['name']+'</a>';
        });

        var textarea = '<textarea class="d-none" id="download-'+key+'">To: '+$("#current-id").val()+'\nFrom: "'+value['sender_name']+'" <'+value['sender_email']+'>\nSubject: '+value['subject']+'\nDate: '+value['time']+'\nContent-Type: text/html\n\n'+value['html']+'</textarea>';

        message += '</div>';
        message += textarea;
        message += '</div>';
        $("#tm-message").prepend(message);
        
        if(newFetch) {
            notifyUser(value['subject'], value['text'].substring(0, 50));
        }
    });
}

$(document).on('click', '.mail-download', function () {
    const a = document.createElement('a')
    a.download = this.getAttribute('subject') + ".eml"
    a.href = makeTextFile(this.getAttribute('key'))
    document.body.appendChild(a)
    a.click()
    a.remove()
});

function makeTextFile(key) {
    var textFile = null
    text = document.getElementById('download-'+key).value;
    var data = new Blob([text], {type: 'text/plain'});
    if (textFile !== null) {
        window.URL.revokeObjectURL(textFile);
    }
    textFile = window.URL.createObjectURL(data);
    return textFile;
}

$(document).on('click', '#fetch', function () {
    $.ajax({
        url: "/mail/fetch", 
        success: function(data){
            if(data.length > 0) {
                $("#mails").html("");
                fetch(data);
            } else {
                $(".refresh > span.icon > i").addClass("pause-spinner");
                $("#mails").html("<p>"+mailboxMsgs.nomails+"</p>");
                setTimeout(function(){ 
                    $("#mails").html("<p>"+mailboxMsgs.emails+"</p>");
                }, 3000);
            }
            setCookie('server_error', false, 20);
            server_error = false;
        },
        error: function(data, status) {
            setCookie('server_error', true, 20);
            if(!server_error) {
                location.reload();
            }
            Swal.fire({
                type: status,
                title: 'Oops...',
                text: notificationMsgs.error.common,
                confirmButtonText: notificationMsgs.button.reload,
                footer: '<a href="/faq">'+notificationMsgs.faq+'</a>',
                onClose: function(){ location.reload(); }
            });
            $("#mails").html("<p>ERROR</p>");
            $(".refresh > span.icon > i").addClass("pause-spinner");
            $(".refresh > span.icon > i").addClass("stop-spinner");
        }
    });
    $("#fetch").remove();
});

$(document).on('click', '.mail-delete', function () {
    var uid = $(this).attr('uid');
    $("#mail-"+uid).fadeOut();
    $("#content-mail-"+uid).fadeOut();
    $("#tm-message > .no-mails").delay(100).fadeIn(100);
    $.post("/mail/delete", {
        "_token": $('#token').val(),
        "uid": uid
    },
    function(data, status){
        $("#mail-"+data).remove();
        $("#content-mail-"+data).remove();
        if($("#mails").is(":empty")) {
            $("#mails").html("<p>"+mailboxMsgs.emails+"</p>");
        }
    }).fail(function() {
        Swal.fire({
            type: "error",
            title: 'Oops...',
            text: notificationMsgs.error.delete,
            confirmButtonText: notificationMsgs.button.close,
            footer: '<a href="/faq">'+notificationMsgs.faq+'</a>'
        });
        $("#mail-"+uid).fadeIn();
        $("#content-mail-"+uid).fadeIn();
    });
});

$(document).on('change', '#locale', function () {
    var locale = $(this).val();
    $.post("/locale", {
        "_token": $('#token').val(),
        "locale": locale
    },
    function(data, status){
        location.reload();
    }).fail(function() {
        Swal.fire({
            type: "error",
            title: 'Oops...',
            text: notificationMsgs.error.common,
            confirmButtonText: notificationMsgs.button.reload,
            footer: '<a href="/faq">'+notificationMsgs.faq+'</a>'
        });
        $("#mail-"+uid).fadeIn();
        $("#content-mail-"+uid).fadeIn();
    });
});

function notifyUser(title = "", body = "") {
    var options = {
        body: body,
        icon: "/images/icon.png"
    };
    if(title) {
        if (Notification.permission === "granted") {
            var n = new Notification(title, options);
            n.onclick = function () {
                window.focus();
            };
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission(function(permission) {
                if (permission === "granted") {
                    var n = new Notification(title, options);
                    n.onclick = function () {
                        window.focus();
                    };
                }
            });
        }
    }
}
if ($.isFunction($.fn.shortcode)) { 
    $('body').shortcode({
        blogs: function() {
            var returnData = '<div class="blogs row">'
            var fetchUrl = this.options.url + "/wp-json/wp/v2/posts?_fields[]=link&_fields[]=title&_fields[]=excerpt"
            var filters = {
                'context': this.options.context,
                'page': this.options.page,
                'per_page': this.options.per_page,
                'search': this.options.search,
                'after': this.options.after,
                'author': this.options.author,
                'author_exclude': this.options.author_exclude,
                'before': this.options.before,
                'exclude': this.options.exclude,
                'include': this.options.include,
                'offset': this.options.offset,
                'order': this.options.order,
                'orderby': this.options.orderby,
                'slug': this.options.slug,
                'status': this.options.status,
                'categories': this.options.categories,
                'categories_exclude': this.options.categories_exclude,
                'tags': this.options.tags,
                'tags_exclude': this.options.tags_exclude,
                'sticky': this.options.sticky,
            }
            Object.keys(filters).forEach(function(key){
                if(filters[key]) {
                    fetchUrl += '&'+key+'='+filters[key]
                }
            })
            var blogData = [];
            $.ajax({url: fetchUrl, success: function(result){
                blogData = result;
            }, error: function(){
                console.log("Error! Please contact admin")
            }}).then(function() {
                blogData.forEach(function(item){
                    returnData += '<div class="blog-item col-md-4">'
                    returnData += '<a href="'+item.link+'" target="_blank">'
                    returnData += '<span class="title">'+item.title.rendered+'</span>'
                    returnData += '<span class="excerpt">'+item.excerpt.rendered+'</span>'
                    returnData += '</a>'
                    returnData += '</div>'
                })
                returnData += '</div>'
                if(blogData.length) {
                    $("#blogs").html(returnData)
                } else {
                    $("#blogs").html('<div class="no-content">204 - NO CONTENT AVAILABLE</div>')
                }
            });
            return "<div id='blogs'><div class='content-loader'><i class='fas fa-sync fa-spin'></i></div>"
        }
    });
}

