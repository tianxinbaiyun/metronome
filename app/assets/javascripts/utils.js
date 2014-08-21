/**
 * Utils.js
 */

;(function($){

    $.fn.dropdown = function(options){

        var defaults = {};
        var settings = $.extend({}, defaults, options);
        var _dropdown = this;

        var initialize = function(){
            _dropdown.each(function(){
                var ctrl = $(this);
                ctrl.click(function(e){
                    e.preventDefault();
                    ctrl.next().toggleClass('open');
                });
            });
        };
        initialize();

        return _dropdown;
    };
})(jQuery);

$(document).on('page:fetch', function(){
    $('.spinner').fadeIn();
});

$(document).on('page:change', function(){
    var selection = $('.category.selection>a');
    var numberOfTab = $('ul.tab').data('number');
    $('.spinner').fadeOut();
    $('.user-opt').dropdown();
    $('span.timeago').timeago();
    $('textarea').autosize();
    $('form>input.auto[type=file]').change(function(){
        $(this).parent('form').submit();
    });
    selection.click(function(e){
        var categoryId = $(this).data('categoryId');
        if (categoryId) {
            e.preventDefault();
            $('form>input#category').val(categoryId);
            selection.removeClass('selected');
            $(this).addClass('selected');
        };
    });
    $('ul.tab>li').each(function(index){
        if (index == numberOfTab) {
            $(this).addClass('actived');
        }
    });
    $('pre').addClass('prettyprint');
    prettyPrint();
});

$(document).on('page:restore', function(){
    $('.spinner').hide();
});
