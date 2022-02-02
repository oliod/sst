<?php
if(!defined('SST') || !constant(SST)) die('Not A Valid Entry Point');
$animCSS = '';
$animArr = null;
$animJS = '';
$animJQuery = '';
$animStart = false;
$animArr = array(1 => 'data-animsition-in-class="fade-in-left-lg"
							data-animsition-in-duration="1000"
							data-animsition-out-class="fade-out-left-lg"
							data-animsition-out-duration="800"',
				2 => 'data-animsition-in-class="fade-in-down-sm"
							data-animsition-in-duration="1000"
							data-animsition-out-class="fade-out-down-sm"
							data-animsition-out-duration="800"',
				3 => 'data-animsition-in-class="fade-in-down"
							data-animsition-in-duration="1000"
							data-animsition-out-class="fade-out-down"
							data-animsition-out-duration="800"',		
				4 => 'data-animsition-in-class="fade-in-up-sm"
							data-animsition-in-duration="1000"
							data-animsition-out-class="fade-out-up-sm"
							data-animsition-out-duration="800"',
				5 => 'data-animsition-in-class="fade-in-up-lg"
							data-animsition-in-duration="1000"
							data-animsition-out-class="fade-out-up-lg"
							data-animsition-out-duration="800"',
				6 => 'data-animsition-in-class="fade-in-right-sm"
							data-animsition-in-duration="1000"
							data-animsition-out-class="fade-out-right-sm"
							data-animsition-out-duration="800"',
				7 => 'data-animsition-in-class="fade-in-right-lg"
							data-animsition-in-duration="1000"
							data-animsition-out-class="fade-out-right-lg"
							data-animsition-out-duration="800"',
				8 => 'data-animsition-in-class="flip-in-x-fr"
							data-animsition-in-duration="1000"
							data-animsition-out-class="flip-out-x-fr"
							data-animsition-out-duration="800"',
				9 => 'data-animsition-in-class="zoom-in-sm"
							data-animsition-in-duration="1000"
							data-animsition-out-class="zoom-out-sm"
							data-animsition-out-duration="800"',
				10 => 'data-animsition-in-class="fade-in"
							data-animsition-in-duration="1000"
							data-animsition-out-class="fade-out"
							data-animsition-out-duration="500"'
);
$GLOBALS['animation'] = $animArr;

$main = new Main();
$animConfig = $GLOBALS['sst']['anim_front_page'] ;

if( isset($animConfig['true']) ) {
	switch(strtolower(key($animConfig['true']))) {
		case'default':
			$animStart = true;
			$animArr = $animArr[10];
		break;
		case'rand':
			$animStart = true;
			$animArr = $animArr[rand(1,10)];
		break;
		case'num':
			$animStart = true;
			$animArr =  $animArr[$animConfig['true'][key($animConfig['true'])]];
		break;
	}
	
} else { $animArr = ''; }

if (!array_key_exists('upload', $main->parseQueryString( Main::currentPageURL()) ) && $animStart) {
 
//-------------
$animCSS = <<<EOD
<link href="css/animsition.min.css" rel="stylesheet" />
EOD;
$animJS = <<<EOD
<script src="js/animsition.min.js" charset="utf-8"> </script>
EOD;
$animJQuery = <<<EOD
<script>
 $(document).ready(function() {
  $(".animsition").animsition({
    inClass: 'fade-in',
    outClass: 'fade-out',
    inDuration: 1500,
    outDuration: 800,
    linkElement: '.animsition-link',
    // e.g. linkElement: 'a:not([target="_blank"]):not([href^="#"])'
    loading: true,
    loadingParentElement: 'body', //animsition wrapper element
    loadingClass: 'animsition-loading',
    loadingInner: '', // e.g '<img src="loading.svg" />'
    timeout: false,
    timeoutCountdown: 5000,
    onLoadEvent: true,
    browser: [ 'animation-duration', '-webkit-animation-duration'],
    // "browser" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
    // The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
    overlay : false,
    overlayClass : 'animsition-overlay-slide',
    overlayParentElement : 'body',
    transition: function(url){ window.location.href = url; }
  });
});
</script>
EOD;
}
?>