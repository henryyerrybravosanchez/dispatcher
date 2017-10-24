/**
 * Created by hbs on 18/08/16.
 */
$(document).ready(function() {
    var items= $(".itemre");
    items.click(function () {
        backgroundItems(items);
        $(this).addClass('active');
    });
});

function clickItems(item) {

    if(item.hasClass('active'))
    {
        item.removeClass('active');
    } else {
        item.addClass('active');
    }
}
function backgroundItems(items) {
    $.each(items, function (e, y) {
        $(this).removeClass('active');
    })
}