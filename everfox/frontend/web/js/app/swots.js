
var SwotManagement = {
    settings: {

    },
    showSuccessAlert: function(){
        swal({title:"Success", text:"Completed successfully!", type:"success"},function(){
            //location.reload();
        });
    },
    resetFormByName: function (name) {
        $(name + ' :input').val("");
    },
    showBusy: function(message) {
        $.blockUI({ css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff'
        }, message: message, baseZ:10000 });
    },
    toggleEdit: function(id) {
        var e = document.getElementById(id);
        if(e.style.display == 'block')
            e.style.display = 'none';
        else
            e.style.display = 'block';
    },
    toggleHelp: function(divId) {
        $("#"+divId).fadeToggle("fast", "linear");
    },
    hideAddLink: function(heading) {
        $('#add_' + heading).hide();
    }
};

$(document).ready(function(){

    $('tr td').on({
        'mouseenter':function(){
            $('#'+$(this).data('id')).delay(500).show();
        },'mouseleave':function(){
            $('#'+$(this).data('id')).hide("fast");
        }
    });

    $(".list-container").bind({
        mouseenter:
           function()
           {
                $('#'+$(this).data('id')).show();
           },
        mouseleave:
           function()
           {
                $('#'+$(this).data('id')).hide("fast");
           }
       }
    );

    function toggle_visibility(id) {
        var e = document.getElementById(id);
        if(e.style.display == 'block')
            e.style.display = 'none';
        else
            e.style.display = 'block';
    }

    $('#swots-filter').multiselect({
        numberDisplayed: 4,
        checkboxName: 'swotlist[]'
    });

    $('[data-toggle="tooltip"]').tooltip({
        placement : 'right'
    });

});
