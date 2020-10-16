(function($) {

    $.fn.serializefiles = function() {
        var self = $(this);
        /* ADD FILE TO PARAM AJAX */
        var formData = new FormData(document.getElementById(self.attr('id')));
        $.each($(self).find("input[type='file']"), function(i, tag) {
            $.each($(tag)[0].files, function(i, file) {
                formData.set($(tag).attr('name'), file);
            });
        });
        var params = $(self).serializeArray();
        $.each(params, function (i, val) {
            formData.set(val.name, val.value);
        });

        return formData;
    };

    $.fn.popupDialog = function (options) {

        var opts = $.extend({
            actionCallback: false,
            columnClass: 'col-md-8'
        }, options);

        this.bind('click.popupDialog', function (e) {
            e.preventDefault();
            //var remote_url = ($(this).attr('href') || $(this).data('url')) + '?layout=ajax';
            var remote_url = ($(this).attr('href') || $(this).data('url')) + '?layout=ajax';

            var jc = $.dialog({
                title: '',
                content: 'url:' + remote_url,
                columnClass: opts.columnClass,
                onContentReady: function(){
                    $('.select-2').select2({
                        placeholder: 'Select an option',
                        width: '100%',
                        allowClear: true,
                        dropdownParent: $(".jconfirm")
                    });

                    $('.select2-single').select2({
                        dropdownParent: $(".jconfirm")
                    });

                    $('.select2-sortable').select2({
                        placeholder: 'Select an option',
                        allowClear: true,
                        dropdownParent: $(".jconfirm"),
                        templateResult: function (state) {
                            if (!state.id) {
                                return state.text;
                            }
                            if (state.id.toString().length > 1) {
                                var offset = state.id.length - 2;
                                if (offset == 1) {
                                    var ob = "<span class='ml-2'>" + state.text + "</span>";
                                } else {
                                    var ob = "<span class='ml-" + offset.toString() + "'>- " + state.text + "</small></span>";
                                }
                                return ob;
                            }
                            return "<strong>" + state.text + "</strong>";

                        },
                        escapeMarkup: function (m) {
                            return m;
                        },
                        width: '100%'
                    });
                    $(".date-picker").datepicker({format: 'yyyy-mm-dd', autoclose: true});
                    if($.isFunction(opts.actionCallback)){
                        $('form').on('submit', function (event) {
                            event.preventDefault();

                            $.ajax({
                                type: 'POST',
                                url: $(this).attr('action'),
                                enctype:  $(this).attr('enctype'),
                                data: $(this).serializefiles(),
                                processData: false,
                                contentType: false,
                            }).done(function (res) {
                                jc.close();
                                var res = $.parseJSON(res);
                                opts.actionCallback(res);
                            });
                        });
                    }
                }
            });

            return false;
        });
    }

    $.fn.popupConfirm = function (options) {

        var opts = $.extend({
            ajax: false,
            actionCallback: false
        }, options);

        this.bind('click.popupConfirm', function (e) {
            e.preventDefault();

            var message = $(this).data('message') || 'Are you sure to confirm it?';
            var href = $(this).attr('href');

            $.confirm({
                title: 'Confirm!',
                content: message,
                buttons: {
                    confirm: function () {
                        if (opts.ajax) {
                            $.getJSON(href, function(response){
                                if($.isFunction(opts.actionCallback)){
                                    opts.actionCallback(response);
                                }
                            });
                        } else {
                            window.location = href;
                        }
                    },
                    cancel: function () {
                    }
                }
            });
            return false;
        })
    }

    $.fn.popupAction = function (options) {

        var opts = $.extend({
            ajax: false,
            actionCallback: false
        }, options);

        this.bind('click.popupAction', function (e) {
            e.preventDefault();

            var message = $(this).data('message') || 'Are you sure to confirm it?';
            var href = $(this).attr('href') + '?layout=ajax';

            $.confirm({
                title: 'Confirm!',
                content: message,
                buttons: {
                    confirm: function () {
                        $.dialog({
                            title: '',
                            content: 'url:' + href,
                            columnClass: 'col-md-8'
                        });
                    },
                    cancel: function () {
                    }
                }
            });
            return false;
        })
    }

})(jQuery);
