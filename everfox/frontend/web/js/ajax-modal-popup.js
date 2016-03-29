$(function(){

    $(document).on('click', '.showModalButton', function(){
        var modal = $(this).data("modal");
        //alert($(this).attr('value'));
        if ($(modal).data('bs.modal').isShown) {
            $(modal).find('#modalContent')
                .load($(this).attr('value'));
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        } else {
            //if modal isn't open; open it and load content
            $(modal).modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        }
    });

});