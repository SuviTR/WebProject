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
	function postPerson($parameters) {
		# implements POST method for person
		# Example: POST /staffapi/person/id=13&firstname="John"&lastname="Doe"
		$firstname=urldecode($parameters["firstname"]);
		$lastname=urldecode($parameters["lastname"]);
		echo "Posted ".$parameters["id"]." ".$firstname." ".$lastname;
	}
	function getPersons() {
		# implements GET method for persons (collection)
		# Example: GET /staffapi/persons
		echo "Getting list of persons";
	}
	function getPerson($id) {
		# implements GET method for person
		# Example: GET /staffapi/person/13
		echo "Getting person: ".$id;
	}
	function deletePerson($id) {
		# implements DELETE method for person
		# Example: DELETE /staffapi/person/13
		echo "Deleting person: ".$id;
	}
# Main
# ----

echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'];
echo "REQUEST_METHOD " . $_SERVER['REQUEST_URI'];
	$resource = getResource();
    $request_method = getMethod();
    $parameters = getParameters();
    # Redirect to appropriate handlers.
	if ($resource[0]=="cv") {
    	if ($request_method=="GET" && $resource[1]=="") {
        	postPerson($parameters);
    	}
		else if ($request_method=="PUT" && $resource[1]=="") {
			getPersons();
		}
		else if ($request_method=="DELETE" && $resource[1]=="") {
			getPerson($resource[2]);
		}
		else if ($request_method=="DELETE" && $resource[1]=="") {
			deletePerson($resource[2]);
		}
		else {
			http_response_code(405); # Method not allowed
		}
	}
	else if ($resource[0]=="portfolio"){
		http_response_code(405); # Method not allowed
	}
?>
