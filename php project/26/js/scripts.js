$(document).ready(function() {
    $(".fancybox").fancybox({
        afterLoad: function() {
            var tArr = this.title.split('|');
            this.title = '<a class="addBtn btn1" href="'+baseUrl+'?add2cart=' + tArr[0] + '">افزودن به سبد خرید</a> ' +
             '<span class="btn1" >' + tArr[1] + '</span> ';
        },
        helpers : {
            title: {
                type: 'inside'
            }
        }
    });

});