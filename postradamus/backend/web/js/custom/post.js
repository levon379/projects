$(document).ready(function() {

    //Select platform change
    $('#post_to').change(function() {

        if($(this).val() == 'facebook') {

            $('.lists_block').hide();
            $('#fb_list_block').show();
            $('#platform_alert').hide();

        }
        else if($(this).val() == 'pinterest') {

            $('.lists_block').hide();
            $('#pin_boards_block').show();
            $('#platform_alert').hide();

        }
        else if($(this).val() == 'wordpress') {

            $('.lists_block').hide();
            $('#wp_list_block').show();
            $('#platform_alert').hide();

        }
        else {
            $('.lists_block').hide();
            $('#platform_alert').show();
        }

    });

    //Set fb list type
    $('#clistpost-fb_page_id').change(function() {

        var type = '';
        var lbl = $('#clistpost-fb_page_id option:selected').parent('optgroup').attr('label');
        if(lbl == 'Pages') {

            type = 'page';
            $('#fb_list_alert').hide();
        }
        else if(lbl == 'Groups') {

            type = 'group';
            $('#fb_list_alert').hide();
        }
        else if(lbl == 'My Feed') {

            type = 'me';
            $('#fb_list_alert').hide();
        }
        else {
            $('#fb_list_alert').show();
        }

        $('#page_type').val(type);

    });

    //Check WP categories select
    $('#clistpost-wp_cat_id').change(function() {

        if(!$(this).val()) {

            $('#wp_list_alert').show();

        }
        else {

            $('#wp_list_alert').hide();
        }

    });

    //Check Pinterest boards select
    $('#clistpost-board_id').change(function() {

        if(!$(this).val()) {

            $('#pin_list_alert').show();

        }
        else {

            $('#pin_list_alert').hide();
        }

    });


    //Send button click
    $('#btn_send').on('click', function() {


        if ( !$( ".file-drop-disabled .file-preview-thumbnails img" ).length ) {

            $('input[name="image_url"]').val('');

        }

        var platform = $('#post_to option:selected').val();

        if(!platform){

            $('#platform_alert').show();
            return false;

        }
        else if(platform == 'facebook' && !$('#clistpost-fb_page_id option:selected').val()) {

            $('#platform_alert').hide();
            $('#fb_list_alert').show();
            return false;

        }
        else if(platform == 'wordpress' && !$('#clistpost-wp_cat_id option:selected').val()) {

            $('#platform_alert').hide();
            $('#wp_list_alert').show();
            return false;
        }
        else if(platform == 'pinterest' && !$('#clistpost-board_id option:selected').val()) {

            $('#platform_alert').hide();
            $('#pin_list_alert').show();
            return false;
        }
        else {

            $('#platform_alert').hide();

        }

    });

});