var icms = icms || {};

icms.rating = (function ($) {

    this.options = {};

    this.setOptions = function(options){
        this.options = options;
    };

    this.onDocumentReady = function(){
        $('.rating_widget').each(function(){
            icms.rating.bindWidget($(this));
        });
        
        // Также привязываем десктопные виджеты
        $('.rating_widget[id$="-desktop"]').each(function(){
            icms.rating.bindWidget($(this));
        });
    };

    this.bindWidget = function(widget){

        var controller = widget.data('target-controller');
        var subject = widget.data('target-subject');
        var id = widget.data('target-id');
        
        // Если это десктопный виджет, удаляем суффикс -desktop для голосования
        if(widget.attr('id') && widget.attr('id').endsWith('-desktop')) {
            // ID для голосования остается без суффикса
        }

        $('a.vote-up', widget).off('click').on('click', function(){
            return icms.rating.vote('up', controller, subject, id);
        });

        $('a.vote-down', widget).off('click').on('click', function(){
            return icms.rating.vote('down', controller, subject, id);
        });

        $('.score span.clickable', widget).off('click').on('click', function(){
            var url = widget.data('info-url');
            icms.modal.openAjax(url, {
               controller: controller,
               subject: subject,
               id: id
            }, function(){
                icms.rating.bingInfoPages();
            });
        });

    };

    this.vote = function(direction, controller, subject, id){

        var widget_id = 'rating-' + subject + '-' + id;
        var widget = $('#'+widget_id).first();

        $('.arrow svg', widget).unwrap();
        $('.arrow svg', widget).wrap('<span class="disabled"></span>');
        $('.score', widget).addClass('is-busy');

        $.ajax({
            url: this.options.url,
            type: 'POST',
            cache: false,
            data: {
                direction: direction,
                controller: controller,
                subject: subject,
                id: id,
                _nocache: new Date().getTime()
            },
            dataType: 'json',
            success: function(result){

                $('.score', widget).removeClass('is-busy');

                if (!result.success){
                    if (result.message){
                        icms.modal.alert(result.message);
                        $('.disabled', widget).attr('title', result.message);
                    }
                    if (result.rating){
                        $('.score', widget).html('<span class="'+result.css_class+'">'+result.rating+'</span>');
                    }
                    return;
                }

                var newHtml = '<span class="'+result.css_class+'">'+result.rating+'</span>';

                // Обновляем основной виджет
                $('.score', widget).html(newHtml);
                $('.disabled', widget).attr('title', result.message);

                // Разворачиваем кнопки и делаем их неактивными
                $('.arrow svg', widget).unwrap();
                $('.arrow svg', widget).wrap('<span class="disabled" title="' + result.message + '"></span>');

                // Обновляем десктопный виджет (если есть)
                var desktopWidgetId = widget_id + '-desktop';
                var desktopWidget = $('#' + desktopWidgetId);
                if(desktopWidget.length > 0) {
                    $('.score', desktopWidget).html(newHtml);
                    $('.disabled', desktopWidget).attr('title', result.message);
                    
                    // Разворачиваем кнопки и делаем их неактивными
                    $('.arrow svg', desktopWidget).unwrap();
                    $('.arrow svg', desktopWidget).wrap('<span class="disabled" title="' + result.message + '"></span>');
                    
                    // Привязываем обработчики для десктопного виджета
                    icms.rating.bindWidget(desktopWidget);
                }

                icms.rating.bindWidget(widget);
            },
            error: function(xhr, status, error) {
                $('.score', widget).removeClass('is-busy');
                icms.modal.alert('Произошла ошибка при голосовании');
            }
        });

        return false;
    };

    this.bingInfoPages = function(){

        var widget = $('.rating_info_pagination');

        var controller = widget.data('target-controller');
        var subject = widget.data('target-subject');
        var id = widget.data('target-id');
        var url = widget.data('url');

        $('a', widget).click(function(){

            var link = $(this);
            var page = link.data('page');
            var list = $('#rating_info_window:visible .rating_info_list');

            $('a', widget).removeClass('active');
            link.addClass('active');

            list.addClass('loading-panel');

            $.post(url, {

                controller: controller,
                subject: subject,
                id: id,
                page: page,
                is_list_only: true

            }, function(result){

                list.html(result).removeClass('loading-panel');

            }, "html");

            return false;
        });
    };

    return this;

}).call(icms.rating || {},jQuery);