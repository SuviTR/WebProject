<?php
# URI parser helper functions
# ---------------------------
    function getResource() {
        # returns numerically indexed array of URI parts
        $resource_string = $_SERVER['REQUEST_URI'];
        if (strstr($resource_string, '?')) {
            $resource_string = substr($resource_string, 0, strpos($resource_string, '?'));
        }
        $resource = array();
        $resource = explode('/', $resource_string);
        array_shift($resource);
        return $resource;
    }
    function getParameters() {
        # returns an associative array containing the parameters
        $resource = $_SERVER['REQUEST_URI'];
        $param_string = "";
        $param_array = array();
        if (strstr($resource, '?')) {
            # URI has parameters
            $param_string = substr($resource, strpos($resource, '?')+1);
            $parameters = explode('&', $param_string);
            foreach ($parameters as $single_parameter) {
                $param_name = substr($single_parameter, 0, strpos($single_parameter, '='));
                $param_value = substr($single_parameter, strpos($single_parameter, '=')+1);
                $param_array[$param_name] = $param_value;
            }
        }
        return $param_array;
    }
    function getMethod() {
        # returns a string containing the HTTP method
        $method = $_SERVER['REQUEST_METHOD'];
        return $method;
    }

# Handlers
# ------------------------------
# These are mock implementations
	function getAbout($parameters) {
		# implements GET method for cv About
		# Example: GET /cv/about/
		$firstname=urldecode($parameters["firstname"]);
		$lastname=urldecode($parameters["lastname"]);
		echo "Posted ".$parameters["id"]." ".$firstname." ".$lastname;
	}
# Main
# ----

echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'];
echo "<br>REQUEST_METHOD " . $_SERVER['REQUEST_METHOD'];

    $resource = getResource();
    $request_method = getMethod();
    $parameters = array_splice($resource, 0 ,2);
    $loggedin = false;

    # Redirect to appropriate handlers.
	if ($resource[0]=="cv") {
        echo "cv";
    	if ($request_method=="GET" && $resource[1]=="") {
        	//getAbout($parameters);

    	}
		else if ($request_method=="PUT" && $resource[1]==""
    && $loggedin) {

		}
		else if ($request_method=="DELETE" && $resource[1]=="") {

		}
		else if ($request_method=="DELETE" && $resource[1]=="") {

		}
		else {
			http_response_code(405); # Method not allowed
		}
	}
	else if ($resource[0]=="portfolio"){
		http_response_code(405); # Method not allowed
	}
?>
