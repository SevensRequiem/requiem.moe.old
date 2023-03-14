<div class="modal fade" id="report" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" role="form" class="report">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?php echo $language['misc']['report']; ?></h4>
				</div>

				<div class="modal-body">

					<div class="form-group">
						<input type="hidden" name="token" value="<?php echo $token->hash; ?>" />
						<input type="hidden" name="type" value="" />
						<input type="hidden" name="reported_id" value="" />
					</div>

					<div class="form-group">
						<label><?php echo $language['forms']['email']; ?></label>
						<input type="text" name="email" class="form-control" />
					</div>

					<div class="form-group">
						<label><?php echo $language['misc']['report_reason']; ?></label>
						<textarea name="message" class="form-control" rows="4" style="resize:none;"></textarea>
					</div>

					<div class="form-group" id="report_recaptcha">

					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $language['misc']['close_modal']; ?></button>
					<button type="submit" class="btn btn-default"><?php echo $language['forms']['submit']; ?></button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {

	$('form.report').submit(function(event) {
		/* Close the modal */
		$('#report').modal('hide')
		
		/* Get the form element the submit button belongs to */
		var $form = $(this).closest('form');

		/* Get the values from elements on the specific form */
		var Data = $form.serializeArray();

		/* Post and get response */
		$.post('processing/process_reports.php', Data, function(data) {
			$('html, body').animate({scrollTop:0},'slow');

			var result = JSON.parse(data);

			/* Display success message */
			$('#response').html(result.message).fadeIn('slow');

			setTimeout(function() {
				$('#response').fadeOut('slow');
			}, 5000);

			/* Clear the textarea */
			$('textarea').val('');

		});

		event.preventDefault();
	});

});
</script>