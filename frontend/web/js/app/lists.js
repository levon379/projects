
var ListManagement = {
    settings: {

    },
    showSuccessAlert: function(){
        swal({title:"Success", text:"Completed successfully!", type:"success"},function(){
            //location.reload();
        });
    },
    resetForm: function () {
        $('#name').val("");
        $('#description').val("");
    },
};

$(document).ready(function(){

    $(".list-container").bind({
        mouseenter:
           function()
           {
                $('#'+$(this).data('id')).show();
           },
        mouseleave:
           function()
           {
                $('#'+$(this).data('id')).hide();
           }
       }
    );

});
