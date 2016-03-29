<?php

/**
* Example
*/
class Example extends Controller
{
	/* for not ajax */
	public function action()
	{
		if (isset($_POST['Form'])) {
			if ($this->formToken->is_token_valid()) {
                // do something here
            } else {
            	// invalid token
            }
		}
		$data['formToken'] = $this->formToken->renderToken();
		$this->load->view('some_view', $data);

	}

	/* for ajax */

	public function ajax_action()
	{
		if ($this->is_ajax()) {
			if (!$new_token = $this->formToken->is_token_valid()) {
				// failed
                $this->ajax_response(array('message' => 'Invalid token'), 403);
            } else {
				// success
				echo json_encode(array('status' => true, 'formToken' => $new_token));
				die;
			}
		}
		
		$data['formToken'] = $this->formToken->renderToken();
		$this->load->view('some_view', $data);

	}	
}


/* some_view.php */
?>

<div>
	<form action="/Example/action" method="post">
		<!-- name of hidden field have to be called 'formToken' -->
		<input type="hidden" id="formToken" name="formToken" value="<?php echo $formToken ?>">
		<!-- some other fields here -->
	</form>
	<script type="text/javascript">
		$('form').submit(function(e){
			e.preventDefault();
			$.ajax({
	            type: "POST",
	            dataType: "json",
	            url: '/Example/ajax_action',
	            data: {
	            	// send formToken field
	                formToken: $('#formToken').val()
	            },
	            success: function(data){
	                // update token
	                $('#formToken').val(data.formToken);
	                
	            }
	        })

		})
	</script>
</div>


