jQuery(function($){
    $(document).ready(function () {
        $('.fl-btn-menu').on('click', '.fl-btn', function (e) {
            e.preventDefault();
            $('.fl-btn-menu').toggleClass('fl-opened');
            $('.fl-btn-closed-icon').toggle();
            $('.fl-btn-opened-icon').toggle();
        });
    });
});