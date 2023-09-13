<!DOCTYPE html>
<?php
$current_file_path = dirname(__FILE__);
$wp_root_path = false;

while (!$wp_root_path && '/' !== $current_file_path) {
    if (file_exists($current_file_path . '/wp-load.php')) {
        $wp_root_path = $current_file_path;
    }
    $current_file_path = dirname($current_file_path);
}

require_once  $wp_root_path . '/wp-load.php';
?>
<html lang="en-US">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Setup Two Factor Authentication &lsaquo; eBakim &#8212; WordPress</title>
	<meta name='robots' content='max-image-preview:large, noindex, noarchive' />
	<link rel='stylesheet' id='buttons-css' href='buttons.min.css' media='all' />
	<link rel='stylesheet' id='forms-css' href='forms.min.css' media='all' />
	<link rel='stylesheet' id='login-css' href='login.min.css' media='all' />
	<meta name='referrer' content='strict-origin-when-cross-origin' />
	<meta name="viewport" content="width=device-width" />
	<style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		/* Firefox */
		input[type=number] {
			-moz-appearance: textfield;
		}
		.button-primary{
			background-color: #414BB2 !important;
			border-color: #414BB2 !important;
		}
	</style>
</head>

<body class="login no-js login-action-login wp-core-ui  locale-en-us">
	<div id="login" style="padding: 2% 0 5% 0 !important;">
		<h1><img src="<?= plugins_url('/ebakim-wp/src/assets/images/main-logo.png') ?>" style="background-size: contain;width: 170px;height: 160px " alt="Logo"></h1>
		
		<?php
		$flash_error = get_flash_error_cookie();
		if ($flash_error) {
			echo '<div id="login_error"> <strong>Error:</strong> '. esc_html($flash_error) .'.<br></div>';
		}
		?>
		<form name="loginform" id="loginform" action="<?= admin_url('admin-post.php'); ?>" style="    margin-top: 0px !important;" method="post">
			<input type="hidden" name="action" value="setup_2fa" />

			<style>
				.center {
					display: flex;
					align-items: center;
					justify-content: center;
					flex-direction: column;
				}

				/* Chrome, Safari, Edge, Opera */
				input::-webkit-outer-spin-button,
				input::-webkit-inner-spin-button {
					-webkit-appearance: none;
					margin: 0;
				}

				/* Firefox */
				input[type=number] {
					-moz-appearance: textfield;
				}
			</style>
			<div style="display: flex;flex-direction: column;gap: 15px;">

				<div class="center">
					<div scope="row"><b><?php _e('Download Fron Playstore:', 'ebakim-wp'); ?></b></div>
					<div>
						<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=tr&pli=1"><img style="width: 200px;" src="https://static.turkiye.gov.tr/themes/edk_mobil/tanitim/img/googleplay.1.8.0.png" alt=""></a>
					</div>
				</div>

				<div class="center">
					<div scope="row"><b><?php _e('Download Fron Appstore:', 'ebakim-wp'); ?></b></div>
					<div>
						<a href="https://apps.apple.com/tr/app/google-authenticator/id388497605?l=tr"><img style="width: 200px;" src="https://static.turkiye.gov.tr/themes/edk_mobil/tanitim/img/appstore.1.8.0.png" alt=""></a>
					</div>
				</div>

				<div class="center">
					<div scope="row"><b><?php _e('Authentication QR Code:', 'ebakim-wp'); ?></b></div>
					<br>
					<div>
						<?php
						$key = get_2fa_key();
						$secretKey = base32_encode($key);
						$authenticator = new PHPGangsta_GoogleAuthenticator();
						$qrCodeUrl = $authenticator->getQRCodeGoogleUrl($key, $secretKey);
						?>
						<img src="<?php echo esc_attr($qrCodeUrl); ?>" alt="QR Code">
					</div>
				</div>

				<div class="center" style="align-items: unset;">
					<div scope="row"><b><?php _e('Enter 2FA Code:', 'ebakim-wp'); ?></b></div>
					<div>
						<input class="input" type="number" name="2fa_code">
					</div>
				</div>
				<div class="center">
					<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large " style="width: 100%;" value="Submit Code" />
				</div>
			</div>



























		</form>
	</div>
</body>

</html>