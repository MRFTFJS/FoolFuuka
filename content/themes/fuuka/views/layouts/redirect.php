<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php if(isset($title)) echo $title; else echo $template['title'] ?></title>
		<meta charset="utf-8">
		<style type="text/css">
			.outer { text-align: center }
			.inner { margin: auto; display: table; display: inline-block; text-decoration: none; text-align: left; padding: 1em; border: thin dotted }
			.text { font-family: Mono, 'MS PGothic' !important }
			h1 { font-family: Georgia, serif; margin: 0 0 0.4em 0; font-size: 4em; text-align: center }
			p { margin-top: 2em; text-align: center; font-size: small }
			a { color: #34345C }
			a:visited { color: #34345C }
			a:hover { color: #DD0000 }
		</style>
		<?php if (isset($fast_redirect)) : ?>
		<meta http-equiv="Refresh" content="0; url=<?php echo $redirection_url ?>" />
		<?php else : ?>
		<meta http-equiv="Refresh" content="2; url=<?php echo $redirection_url ?>" />
		<?php endif; ?>
	</head>
	<body>
		<?php if (!isset($fast_redirect)) : ?>
		<h1><?php if(isset($title)) echo $title; else echo $template['title'] ?></h1>
		<div class="outer">
			<div class="inner">
				<span class="text"><?php echo nl2br(fuuka_message()) ?></span>
			</div>
		</div>
		<p><a href="<?php echo $redirection_url ?>" rel="noreferrer"><?php echo $redirection_url ?></a><br/>All characters <acronym title="DO NOT STEAL MY ART">&#169;</acronym> Darkpa's party</p>
		<?php else: ?>
		<script type="text/javascript">
			window.location.href = '<?php echo $redirection_url ?>';
		</script>
		<?php endif; ?>
	</body>
</html>