<?php
// api example
require_once __DIR__."/custom/inc.php"; // this is required to be placed at start of execution - it loads the config, app vars, core app functions, and init

function generateResponse() {

	$json = array();
	
	
	$p = ["offset"=>"0","order_by"=>"code,section","direction"=>"ASC","limit"=>"10"];
	if (getParameter("code")) {
		$code = strtoupper(getParameter("code")); // this gets the parameter passed to this api service /api.php?code=BIOL
		logMsg("CODE: '".$code."' passed as parameter");
		$p["q"]="code~".$code; // add it to the parameters in the q field
	}
	
	// get data by passing the data url and any parameters (as a key,value pair array)
	$data = getExlibrisAPI("/almaws/v1/courses", $p);
	
	if( isset($data['course'])) {
						
		$courseData = $data['course'];

		logMsg("Going through course list and filtering out inactive");

		// iterate through each of the returned courses, we are not limiting by active or inactive, but the course code could have been used to limit to 1
		$len = count($courseData);
		for( $i = 0; $i < $len; $i++ ) {

			$course = array();

			$course["code"] = $courseData[$i]['code'];
			$course["name"] = $courseData[$i]['name'];

			logMsg("Added '".$course["code"]."' to response data");

			$json[] = $course; // add course to array

		}
	}
	
	return $json;
}

// This function can be used for any application you create that requires access of Ex Libris APIs and can be modified for all API access
function getExLibrisAPI($url = "", $params = array() ) {
	
	$makeRequest = true;
	
	// check to make sure the admin filled in an api key in config.ini.php
	if (!hasData(getCfg("exlibris")["apikey"])) {
		logMsg("Ex Libris API key not set. Edit /custom/config.ini.php and fill in your app specfic API key.");
		$makeRequest = false;
	}
	
	// check to make sure apidomain is set in config, and that a URL was passed
	if (!hasData(getCfg("exlibris")["apidomain"])) {
		logMsg("Ex Libris API Domain not set. Edit /custom/config.ini.php and fill in the domain used to access Ex Libris API. ex: https://api-na.hosted.exlibrisgroup.com");
		$makeRequest = false;
	} else if ($url === "") {
		logMsg("The API URL must be provided. You are requesting data from ".getCfg("exlibris")["apidomain"]."______?????_____");
		$makeRequest = false;
	}
	
	if ($makeRequest) {
		
		// generate request URL with the domain, url, and api key
		$requestURL = getCfg("exlibris")["apidomain"].$url."?apikey=".getCfg("exlibris")["apikey"]."&format=json";
		
		// add any passed parameters
		foreach ($params as $key => $value) {
			$requestURL .= "&".$key."=".urlencode($value);
		}
		
		logMsg($requestURL);
		
		//return getDataFromJSON($requestURL) which is included in the framework
		return getDataFromJSON($requestURL);
	}
	
}

/* **********************************************
 *  START
 */

// begin JSON output

if(isApprovedOrigin()) {

	$json = generateResponse();

	if(!debugOn()) {

		httpReturnHeader(getCacheExpire("api"), getRequestOrigin(), "application/json");
		echo json_encode($json);

	} else {
		echo "<h3>JSON RAW</h3>";
		echo "<p>";
		echo json_encode($json);
		echo "</p>";
		echo "<h3>JSON FORMATTED</h3>";
		echo "<pre>";
		print_r($json);
		echo "</pre>";
		appExecutionEnd();
	}

} else {
	echo (getRequestOrigin()." not an allowed origin");
}

?>