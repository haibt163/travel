<?php ?>		
		<form id="confirmation-form" method="post" action="" class="booking" style="display:none">
			<fieldset>
				<h3><span>02 </span><?php _e('Confirmation', 'bookyourtravel') ?></h3>
				<div class="text-wrap">
					<p><?php _e('Thank you. We will get back you with regards your reservation within 24 hours.', 'bookyourtravel') ?></p>
				</div>				
				<h3><?php _e('Traveller info', 'bookyourtravel') ?></h3>
				<div class="text-wrap">
					<div class="output">
						<p><?php _e('First name', 'bookyourtravel') ?>: </p>
						<p id="confirm_first_name"></p>
						<p><?php _e('Last name', 'bookyourtravel') ?>: </p>
						<p id="confirm_last_name"></p>
						<p><?php _e('Email address', 'bookyourtravel') ?>: </p>
						<p id="confirm_email_address"></p>
						<p><?php _e('Phone', 'bookyourtravel') ?>: </p>
						<p id="confirm_phone"></p>
						<p><?php _e('Street', 'bookyourtravel') ?>: </p>
						<p id="confirm_street"></p>
						<p><?php _e('Town/City', 'bookyourtravel') ?>: </p>
						<p id="confirm_town"></p>
						<p><?php _e('Zip code', 'bookyourtravel') ?>: </p>
						<p id="confirm_zip"></p>
						<p><?php _e('Country', 'bookyourtravel') ?>:</p>
						<p id="confirm_country"></p>
					</div>
				</div>			
				<h3><?php _e('Special requirements', 'bookyourtravel') ?></h3>
				<div class="text-wrap">
					<p id="confirm_requirements"></p>
				</div>				
				<div class="text-wrap">
					<p><?php _e(sprintf('<strong>We wish you a pleasant stay</strong><br /><i>your %s team</i>', of_get_option('contact_company_name', 'BookYourTravel')), 'bookyourtravel') ?></p>
				</div>
			</fieldset>
		</form>
<?php ?>