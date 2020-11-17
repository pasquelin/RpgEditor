<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<!DOCTYPE html>
<html lang="fr">
		<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
				<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
				<title><?php echo Kohana::config( 'game.name' ); ?></title>
				<?php echo isset( $css ) ? $css : FALSE; ?>
		</head>
		<body id="body">
				<?php echo isset( $content ) ? $content : FALSE; ?>
				<?php echo isset( $script ) ? $script : FALSE; ?>
                <script type="text/javascript">

                    var _gaq = _gaq || [];
                    _gaq.push(['_setAccount', 'UA-9457746-6']);
                    _gaq.push(['_trackPageview']);

                    (function() {
                        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                    })();

                </script>
		</body>
</html>
<!-- Rendered in {execution_time} seconds, using {memory_usage} of memory -->