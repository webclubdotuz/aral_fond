
$("form").submit(function (event) {
    if ($(this).hasClass("submitted")) {
        event.preventDefault();
    } else {
        // add loading icon
        $text = $(this).find(":submit").text();
        $(this).find(":submit").html('<i class="mdi mdi-loading mdi-spin"></i>' + $text);
        $(this).addClass("submitted");
    }
});



$(function() {

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        localStorage.setItem('lastTab', $(this).attr('href'));
    });

    var lastTab = localStorage.getItem('lastTab');

    if (lastTab) {
        $('[href="' + lastTab + '"]').tab('show');
    }

});
