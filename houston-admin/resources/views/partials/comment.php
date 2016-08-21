<script id="comment-edit-row-template" type="text/x-handlebars-template">
    <textarea class="form-control comment-text" cols="65" rows="2">{{{comment}}}</textarea>
</script>

<script id="comment-save-row-template" type="text/x-handlebars-template">
    <div class="comment-text">{{{comment}}}</div>
</script>

<script id="comment-row-template" type="text/x-handlebars-template">
    <div class="comment">
        <p class="pull-right"><small>{{comment_date}}</small></p>
        <input type="hidden" id="booking-comment-id-value" name="booking_comment_id[]" value="0">
        <input type="hidden"  id="comment-date-value"  name="comment_date[]" value="{{comment_date}}">
        <input type="hidden"  id="comment-firstname-value"  name="comment_firstname[]" value="{{comment_firstname}}">
        <input type="hidden"  id="comment-firstname-value"  name="comment_lastname[]" value="{{comment_lastname}}">
        <input type="hidden"  id="comment-firstname-value"  name="comment_user[]" value="{{coment_user_id}}">
        <input type="hidden"  id="comment-text-value"  name="comment_text[]" value="{{{comment}}}">
        <div class="comment-body">
            <h4 class="comment-heading user-name">{{name}}</h4>
            <div class="comment-text">{{{comment}}}</div>
            <p><small><a href="#" class="comment-es">Edit</a> - <a href="#" class="comment-delete">Delete</a></small></p>
        </div>
    </div>
</script>