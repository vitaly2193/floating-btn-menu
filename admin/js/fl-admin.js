jQuery(function($){
    $(document).ready(function () {
        setTimeout(function () {
            $('.fl-submit-mesage').slideUp();
        }, 3000);
        $('input[name=fl-icon]').on('change', function () {
            console.log($(this).val());
            if ($(this).val() == 1) {
                $('.icon-fa-row').fadeIn();
                $('.icon-text-row').hide();
            } else {
                $('.icon-fa-row').hide();
                $('.icon-text-row').fadeIn();
            }
        });
        $('#fl-select-fa').on('change', function () {
            var icon = $(this).val();
            $('#icon-preview').attr('class', 'fa fa-'+icon+'');
        });
        $('input.fl-color').wpColorPicker();
    });
});