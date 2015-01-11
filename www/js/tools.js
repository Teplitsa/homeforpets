var speedSlider  = 500;  // скорость смены слайда
var periodSlider = 3000; // период автоматической смены слайда
var timerSlider  = null;

var speedNews = 500; // скорость смены новостей

(function($) {

    $(document).ready(function() {

        // поле поиска
        $('.search-input input').each(function() {
            if ($(this).val() != '') {
                $(this).parent().find('span').hide();
            }
        });

        $('.search-input input').focus(function() {
            $(this).parent().find('span').hide();
        });

        $('.search-input input').blur(function() {
            if ($(this).val() == '') {
                $(this).parent().find('span').show();
            }
        });

        // раскраска строк таблиц
        $('.content table tbody tr:odd').addClass('odd');

        // слайдер на главной
        $('.slider').each(function() {
            var curSlider = $(this);
            curSlider.data('curIndex', 0);
            timerSlider = window.setTimeout(gotoNextSlider, periodSlider);
            var sizeSlider = curSlider.find('li').length;

            var ctrlHTML = '';
            for (var i = 0; i < sizeSlider; i++) {
                ctrlHTML += '<a href="#"></a>';
            }
            curSlider.find('.slider-ctrl').html(ctrlHTML);
            curSlider.find('.slider-ctrl a:first').addClass('active');
            curSlider.find('.slider-ctrl a').bind('click', function() {
                window.clearTimeout(timerSlider);
                timerSlider = null;

                var curIndex = curSlider.data('curIndex');
                var newIndex = curSlider.find('.slider-ctrl a').index($(this));

                curSlider.find('li').eq(curIndex).css({'z-index':2});
                curSlider.find('li').eq(newIndex).css({'z-index':1, 'display':'block'});

                curSlider.find('li').eq(curIndex).fadeOut(speedSlider, function() {
                    curSlider.data('curIndex', newIndex);
                    timerSlider = window.setTimeout(gotoNextSlider, periodSlider);
                    curSlider.find('.slider-ctrl a.active').removeClass('active');
                    curSlider.find('.slider-ctrl a').eq(newIndex).addClass('active');
                });
                return false;
            });
        });

        // инициализация новостей на главной
        $('.main-news').each(function() {
            var curSlider = $(this);
            curSlider.data('curIndex', 0);
            curSlider.find('ul').width(curSlider.find('li').length * curSlider.find('li:first').width());
            if (curSlider.find('li').length < 3) {
                $('.main-news-next').addClass('main-news-next-disabled');
            }
        });

        // переход к предыдущим новостям
        $('.main-news-prev').click(function() {
            var curSlider = $('.main-news');
            var curIndex = curSlider.data('curIndex');
            $('.main-news-next').removeClass('main-news-next-disabled');
            curIndex -= 2;
            if (curIndex < 0) {
                curIndex = 0;
            }
            if (curIndex == 0) {
                $('.main-news-prev').addClass('main-news-prev-disabled');
            }
            curSlider.data('curIndex', curIndex);
            curSlider.find('ul').animate({'left':-curIndex * curSlider.find('li:first').width()}, speedNews);

            return false;
        });

        // переход к следующим новостям
        $('.main-news-next').click(function() {
            var curSlider = $('.main-news');
            var curIndex = curSlider.data('curIndex');
            $('.main-news-prev').removeClass('main-news-prev-disabled');
            curIndex += 2;
            if (curIndex > curSlider.find('li').length - 2) {
                curIndex = curSlider.find('li').length - 2;
            }
            if (curIndex >= curSlider.find('li').length - 2) {
                $('.main-news-next').addClass('main-news-next-disabled');
            }
            curSlider.data('curIndex', curIndex);
            curSlider.find('ul').animate({'left':-curIndex * curSlider.find('li:first').width()}, speedNews);

            return false;
        });

    });

    // переход к следующему слайду
    function gotoNextSlider() {
        var curSlider = $('.slider');
        var curIndex = curSlider.data('curIndex');
        var newIndex = curIndex + 1;
        if (newIndex == curSlider.find('li').length) {
            newIndex = 0;
        }
        curSlider.find('li').eq(curIndex).css({'z-index':2});
        curSlider.find('li').eq(newIndex).css({'z-index':1, 'display':'block'});
        curSlider.find('li').eq(curIndex).fadeOut(speedSlider, function() {
            curSlider.data('curIndex', newIndex);
            timerSlider = window.setTimeout(gotoNextSlider, periodSlider);
            curSlider.find('.slider-ctrl a.active').removeClass('active');
            curSlider.find('.slider-ctrl a').eq(newIndex).addClass('active');
        });
    }

})(jQuery);