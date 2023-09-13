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
	<title>Two Factor Authentication &lsaquo; eBakim &#8212; WordPress</title>
	<meta name='robots' content='max-image-preview:large, noindex, noarchive' />
	<link rel='stylesheet' id='buttons-css' href='buttons.min.css' media='all' />
	<link rel='stylesheet' id='forms-css' href='forms.min.css' media='all' />
	<link rel='stylesheet' id='login-css' href='login.min.css' media='all' />

	<style></style>
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

		.button-primary {
			background-color: #414BB2 !important;
			border-color: #414BB2 !important;
		}
	</style>
</head>

<body class="login no-js login-action-login wp-core-ui  locale-en-us">


	<div id="login">

		<h1><img src="<?= plugins_url('/ebakim-wp/src/assets/images/main-logo.png') ?>" style="background-size: contain;width: 170px;height: 160px " alt="Logo"></h1>

		<?php
		$flash_error = get_flash_error_cookie();
		if ($flash_error) {
			echo '<div id="login_error"> <strong>Error:</strong> ' . esc_html($flash_error) . '.<br></div>';
		}
		?>






		<form name="loginform" id="loginform" action="<?= admin_url('admin-post.php'); ?>" method="post">
			<input type="hidden" name="action" value="verify_2fa" />
			<p>
				<label for="2fa_code">Enter 2FA Code</label>
				<input type="number" name="2fa_code" id="2fa_code" placeholder="Enter 2FA Code" aria-describedby="login-message" class="input" value="" size="20" autocapitalize="off" autocomplete="" required="required" />
			</p>
			<p class="submit">
				<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" style="width:100%;" value="Submit Code" />
			</p>
		</form>
	</div>
</body>

</html>