var prefix = '..';
var count = 0;
$(document).ready(function () {
    get(prefix, function (data) {
        if (data.length == 0) return;
        for (var i = 2; i < data.length; i++) {
            $('.window').append("<div class='list-item' data-url='" + prefix + '/' + data[i] + "'><p>" + data[i] + "</p><div class='inner'></div></div>");
        }
    });

    $('#sub').click(function () {
        var search = $('#req').val();
        var url = $('span.current').html();
        if (search == '' || url == '') return;
        $('.result').html('');
        finder(url, search);

        //$.ajax({
        //    url: 'finder.php',
        //    type: 'post',
        //    data: 'search=' + search + '&root=' + url,
        //    success: function (data) {
        //        $('.result').html(data);
        //    }
        //});
    });

    $('.container').on('click', 'div.list-item', function (event) {
        event.stopPropagation();
        $('span.current').html($(this).data('url'));
        if ($(this).hasClass('expand')) {
            $(this).find('.inner').hide();
            $(this).removeClass('expand');
            return;
        }
        if ($(this).find('>.inner').find('.list-item').length > 0) {
            $(this).find('>.inner').show();
            $(this).addClass('expand');
        } else {
            var url = $(this).data('url');
            var self = this;
            get(url, function (data) {
                if (data.length == 0) return;
                for (var i = 2; i < data.length; i++) {
                    $(self).find('>div.inner').append("<div class='list-item' data-url='" + url + '/' + data[i] + "'><p>" + data[i] + "</p><div class='inner'></div></div>");
                }
                $(self).addClass('expand');
            })
        }
    })
});

function finder(file, str) {

    $.ajax({
        url: 'findInDir.php',
        type: 'post',
        //dataType : 'json',
        data: 'root=' + file + '&search=' + str,
        success: function (data) {
            $('.result').append(data);
            //count--;
        }
    });

    a();

    //if(count >= 10){
    //
    //
    //    var id = setInterval(function(){
    //        //console.log(count);
    //        if(count < 10){
    //            count++;
    //            clearInterval(id);
    //            a();
    //        }
    //    }, 500);
    //} else {
    //    count++;
    //    a();
    //}


    //count--;

    function a(){
        $.ajax({
            url: 'getDirs.php',
            type: 'post',
            dataType: 'json',
            data: 'path=' + file,
            success: function (data) {
                request(data);
            }
        });
    }

    function request(data) {
        for (var i = 0; i < data.length; i++) {

            finder(data[i], str);

            //console.log(data[i]);
        }
        count--;
        if (count == 0) {
            console.log('last');
        }
    }
}

function get(path, func) {
    $.ajax({
        url: 'get.php',
        type: 'post',
        dataType: 'json',
        data: 'path=' + path,
        success: func
    });
}
