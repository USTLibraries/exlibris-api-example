<?php
// web page example - for an api returning json data see api.php

require_once __DIR__."/custom/inc.php"; // this is required to be placed at start of execution - it loads the config, app vars, core app functions, and init

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Example of JavaScript API with Ex Libris</title>
	</head>

	<body>

		<h1>Example Page</h1>
		<p>For this example to work you will need to set up the following:</p>

		<ol>
		<li>An API key in the Ex Libris Development Center</li>
		<li>Fill in the appropriate fields in /custom/config.ini.php</li>
		<li>Have at least 1 active course in Alma Course Reserves.</li>
		<li>Make sure everything is uploaded and you should see a course listing at the bottom of this page</li>
		</ol>

		<p>Feel free to explore the code paying particular attention to the api.php file and /js/main.js file.</p>
		<p>The only other file you would need to touch is /custom/config.ini.php, but that's only for set up.</p>
		<p>Don't forget to run this page with <a href="?debug=true">?debug=true</a> from a valid debug IP (see allow-debug-ip below).</p>
		<p>You can also run <a href="api.php?debug=true">?debug=true</a> on api.php as long as you have bad-origin-allow-ip set up as described below.</p>

		<h2>API Key</h2>
		<p>Go into the <a href="https://developers.exlibrisgroup.com">Ex Libris Development Center</a>, log in, and create an API key for a new application. For details on getting started with Ex Libris APIs (creating your account, creating new application keys) go here: <a href="https://developers.exlibrisgroup.com/primo/apis">https://developers.exlibrisgroup.com/primo/apis</a></p>
		<p>The API application you will create will need READ access to the COURSES API.</p>
		<p>Now that you have the API key you are ready to fill in the appropriate fields in config.ini.php.</p>
		<h2>Set up config.ini.php</h2>
		<p>You only need to update the following fields:</p>
		<h3>allow-origin</h3>
		<p>What domains do you expect to be hosting the JavaScript? If you place the JavaScript on pages hosted by the example.com domain, then example.com will be the domain to put in here. If there are multiple known domains, put them in. If there are multiple, unknown domains, or the request won't be coming from domains at all, then leave this empty.</p>
		<h3>bad-origin-allow-ip</h3>
		<p>This just adds flexibility expecially when you are setting things up. If the allow-origin doesn't match (suppose it should be example.com but you are using a testing server temporarily) what is the IP of the requesting machine that you will allow? Since you are testing, this is typically your own IP or IP range (in regex). This is also helpful when debugging the api.php as you can then access it directly without a referrer.</p>
		<h3>allow-debug-ip</h3>
		<p>If you are allowing debug mode for testing and development you should restrict the IP range that has access to the extra debug information.</p>
		<h3>allow-debug-host</h3>
		<p>If you wish to allow debugging only on a test.example.com domain, then enter that here and don't enter your production domain. Note: this is for the server the application is hosted on, not the same as the allow-origin (unless it is).</p>
		<h3>require-ssl</h3>
		<p>If you have a secure certificate for the hosting domain then set this to 1. Otherwise if requests need to be done via http then set it to 0.
		<h3>[exlibris]apikey</h3>
		<p>Don't confuse this with apikey under [security]. This is located near the bottom of the file. This is where you will put the API key generated at developers.exlibrisgroup.com</p>

		<h2>JS Template</h2>

		<p>This is an example of the JS Template calling an API (api.php) and displaying the data.</p>
		<p>There is a configuration variable in the source code of this page as an example of allowing custom settings.</p>
		<p>JavaScript is contained within the js/main.js file. Most of the code you will add will be in the execute() function.</p>

		<script>
			var exlibrisexample_config = {
				silence: { allowToggle: true, default: false },
				allowMultipleExecutions: false, // no reason to ever set this as true
				apiURL: "api.php", // set this to the location of the api
		};
		</script>
		<script src="js/main.js"></script>
	</body>
</html>
<!-- optional, but sets debug info and will display if debug mode is enabled -->
<?php appExecutionEnd(); ?>