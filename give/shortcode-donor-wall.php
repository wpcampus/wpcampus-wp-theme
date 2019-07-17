<?php
/**
 * This template is used to display the donation grid with [donation_grid]
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @var $donor Give_Donor */
$donation = $args[0];

//{meta_donation_for_the_donor_wall}

/*
    [_give_payment_meta] => Array
        (
            [_give_donation_company] => Pagely, Inc.
            [_give_payment_total] => 1030.180000
            [_give_payment_currency] => USD
            [_give_donor_billing_first_name] => Joshua
            [_give_donor_billing_last_name] => Strebel
            [_give_payment_gateway] => paypal
            [_give_payment_form_title] => Fundraising for Gutenberg Accessibility Audit
            [_give_payment_form_id] => 31082
            [_give_payment_price_id] => 6
            [_give_payment_donor_email] => joshua@pagely.com
            [_give_payment_donor_title_prefix] =>
            [_give_payment_donor_ip] => 64.79.144.10,64.79.144.10
            [_give_payment_purchase_key] => WPC-AUDIT-a10fcfa98da3d2c6ebbbf77fb21322ec
            [_give_payment_mode] => live
            [_give_payment_donor_id] => 12
            [_give_current_url] => https://wpcampus.org/2018/11/fundraising-for-wpcampus-gutenberg-accessibility-audit/
            [_give_current_page_id] => 31040
            [_give_anonymous_donation] => 0
            [_give_fee_donation_amount] => 1000.000000
            [_give_fee_amount] => 30.180000
            [key] => WPC-AUDIT-a10fcfa98da3d2c6ebbbf77fb21322ec
            [form_title] => Fundraising for Gutenberg Accessibility Audit
            [email] => joshua@pagely.com
            [form_id] => 31082
            [price_id] => 6
            [date] => 2018-11-27 19:31:21
            [currency] => USD
            [user_info] => Array
                (
                    [first_name] => Joshua
                    [last_name] => Strebel
                    [email] => joshua@pagely.com
                    [id] => 0
                    [address] =>
                )

            [for_the_donor_wall] => YES - I would like my company displayed
            [share_your_response] => NO - Do not share my response
        )

    [_give_payment_date] => 2018-11-27 19:31:21
    [_give-form-fields_id] => 31082
    [_give_mc_campaign_id] =>
    [_give_mc_email_id] =>
    [give_last_paypal_ipn_received] => 1543347125
    [_give_payment_transaction_id] => 7SK94370VT5216513
    [_give_completed_date] => 2018-11-27 19:32:06
    [donation_id] => 31155
    [name_initial] => JS
    [donor_comment] =>*/

// Shortcode attributes.
$atts = $args[2];

// Give settings.
//$give_settings = $args[1];

$show_name      = false;
$show_company   = false;
$anonymous = (bool) $donation['_give_payment_meta']['_give_anonymous_donation'];

$give_show_name = ( true === $atts['show_name'] );
if ( $give_show_name ) {

	$for_donor_wall = $donation['for_the_donor_wall'];
	switch ( $for_donor_wall ) {

		case 'YES - I would like my name displayed':
			$show_name = true;
			break;

		case 'YES - I would like my name and company displayed':
			$show_name    = true;
			$show_company = true;
			break;

		case 'YES - I would like my company displayed':
			$show_company = true;
			break;

		case 'NO - Do not display my information. I would like to remain anonymous.':
			$anonymous = true;
			break;
	}
}

$donor_name = ! $show_name ? '' : esc_html( trim( $donation['_give_donor_billing_first_name'] . ' ' . $donation['_give_donor_billing_last_name'] ) );
$company_name = ! $show_company ? '' : esc_html( trim( $donation['_give_donation_company'] ) );

?>
<div class="give-grid__item">
	<div class="give-donor give-card">
		<div class="give-donor__header">
			<?php

			/*if( true === $atts['show_avatar'] ) {
				// Maybe display the Avatar.
				echo sprintf(
					'<div class="give-donor__image" data-donor_email="%1$s" data-has-valid-gravatar="%2$s">%3$s</div>',
					md5( strtolower( trim( $donation['_give_payment_donor_email'] ) ) ),
					absint( give_validate_gravatar( $donation['_give_payment_donor_email'] ) ),
					$donation['name_initial']
				);
			}*/

			?>
			<div class="give-donor__details">
				<?php

				if ( $give_show_name ) :
					?>
					<h3 class="give-donor__name">
						<?php

						if ( $anonymous ) {
							echo 'Anonymous';
						} else if ( $show_company && ! $show_name ) {
							echo $company_name;
						} else {
							echo $donor_name;
						}

						?>
					</h3>
					<?php

					if ( ! $anonymous && $show_company && $show_name ) :
						?>
						<span class="give-donor__company"><?php echo $company_name; ?></span>
						<?php
					endif;
				endif;

				if ( true === $atts['show_total'] ) : ?>
					<span class="give-donor__total">
						<?php echo give_donation_amount( $donation['donation_id'], true ); ?>
					</span>
				<?php endif; ?>

				<?php if ( true === $atts['show_time'] ) : ?>
					<span class="give-donor__timestamp">
						<?php echo date_i18n( give_date_format(), strtotime( $donation['_give_completed_date'] ) ); ?>
					</span>
				<?php endif; ?>
			</div>
		</div>
		<?php

		if ( ! $anonymous ) {

			$share_your_response = $donation['share_your_response'];
			if ( 'YES - I\'m ok with WPCampus sharing why accessibility matters to me' == $share_your_response ) :

				$comment = esc_html( trim( $donation['wed_love_to_hear_more_from_you_please_share_why_accessibility_matters_to_you'] ) );

				if ( ! empty( $comment ) ) :

					?>
					<div class="give-donor__content">
						<h3 class="give-donner__message">Why accessibility matters to me:</h3>
						<?php echo wpautop( $comment );

						/*$comment     = trim( $donation['donor_comment'] );
						$total_chars = strlen( $comment );
						$max_chars   = $atts['comment_length'];

						// A truncated excerpt is displayed if the comment is too long.
						if ( $max_chars < $total_chars ) {
							$excerpt    = '';
							$offset     = -( $total_chars - $max_chars );
							$last_space = strrpos( $comment, ' ', $offset );

							if ( $last_space ) {
								// Truncate excerpt at last space before limit.
								$excerpt = substr( $comment, 0, $last_space );
							} else {
								// There are no spaces, so truncate excerpt at limit.
								$excerpt = substr( $comment, 0, $max_chars );
							}

							$excerpt = trim( $excerpt, '.!,:;' );

							echo sprintf(
								'<p class="give-donor__excerpt">%s&hellip;<span> <a class="give-donor__read-more">%s</a></span></p>',
								nl2br( esc_html( $excerpt ) ),
								esc_html( $atts['readmore_text'] )
							);
						}

						echo sprintf(
							'<p class="give-donor__comment">%s</p>',
							nl2br( esc_html( $comment ) )
						);*/

						?>
					</div>
					<?php
				endif;
			endif;

		}

		?>
	</div>
</div>