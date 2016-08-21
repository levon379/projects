<script id="bookings-warning" type="text/x-handlebars-template">
    <ul id="multiple-warning">
        {{#each errors as |error errorId| }}
        <li class="alert alert-warning">{{error}}</li>
        {{/each}}
    </ul>
</script>