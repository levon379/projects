
var Utilities = {
    settings: {

    },
    showSuccessAlert: function(reload){
        swal({title:"Success", text:"Completed successfully!", type:"success"},function(){
            if(reload==1){
                location.reload();
            }
        });
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
    hideBusy: function() {

    }
};

$(function(){

   $(document).on('click', '.loadContent', function(){
     alert('yes');
        var content = $(this).data("content");
        alert(content);
        $(content).load($(this).attr('value'));
    });

	$(document).on('focus', 'div.form-group-options div.input-group-option:last-child input', function(){

		var sInputGroupHtml = $(this).parent().html();
		var sInputGroupClasses = $(this).parent().attr('class');
		$(this).parent().parent().append('<div class="'+sInputGroupClasses+'">'+sInputGroupHtml+'</div>');

	});

	$(document).on('click', 'div.form-group-options .input-group-addon-remove', function(){

		$(this).parent().remove();

	});


});
