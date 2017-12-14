$.AMUI.progress.start();

$(window).on("load", function () {
    $.AMUI.progress.done();
})

var hideNotice = function () {
    $(".notice").fadeOut("slow");
}
setTimeout(hideNotice, 4000);