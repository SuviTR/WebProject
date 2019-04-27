<?php
# URI parser functions
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

# Handlers -----------
function getCV($parameters) {
    # implements GET method for cv
    # Example: GET /cv/
    #print version
    echo "Posted ";
}
function getFront($parameters) {
    # Example: GET /cv/front
    $fullname = urldecode($parameters["fullname"]);
    $profession = urldecode($parameters["profession"]);
    $picture = "";
    echo "Posted ".$fullname." ".$profession;
}
function getAbout($parameters) {
    # Example: GET /cv/about
    $heading = urldecode($parameters["heading"]);
    $description = urldecode($parameters["description"]);
    $picture = "";
    echo "Posted ".$heading." ".$description;
}
function getSkills($parameters) {
    # Example: GET /cv/skills
    $id = urldecode($parameters["id"]);
    $skill = urldecode($parameters["skill"]);
    $level = urldecode($parameters["level"]);
    $bar = "";
    echo "Posted ".$parameters["id"]." ".$skill." ".$level;
}
function getExperience($parameters) {
    # Example: GET /cv/experience
    $id = urldecode($parameters["id"]);
    $year = urldecode($parameters["year"]);
    $title = urldecode($parameters["title"]);
    $company = urldecode($parameters["company"]);
    $description = urldecode($parameters["description"]);
    $projects = urldecode($parameters["projects"]);
    echo "Posted ".$parameters["id"]." ".$year." ".$title." ".$company." ".$description." ".$projects;
}
function getEducation($parameters) {
    # Example: GET /cv/education
    $id = urldecode($parameters["id"]);
    $year = urldecode($parameters["year"]);
    $title = urldecode($parameters["title"]);
    $academy = urldecode($parameters["academy"]);
    $description = urldecode($parameters["description"]);
    $projects = urldecode($parameters["projects"]);
    echo "Posted ".$parameters["id"]." ".$year." ".$title." ".$academy." ".$description." ".$projects;
}
function getContact($parameters) {
    # Example: GET /cv/contact
    $call = urldecode($parameters["call"]);
    $mail = urldecode($parameters["mail"]);
    $address = urldecode($parameters["address"]);
    $some = urldecode($parameters["some"]);
    echo "Posted ".$parameters["id"]." ".$call." ".$address." ".$some;
}

# Main
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'];
echo "<br>REQUEST_METHOD " . $_SERVER['REQUEST_METHOD'];

$resource = getResource();
$request_method = getMethod();
$parameters = array_splice($resource, 0 ,2);
$loggedin = false;

# Redirect to appropriate handlers.
# ----- CV/ -----
if ($resource[0]=="cv") {
    if ($request_method=="GET" && $resource[1]=="") {
        //getCV($parameters);
        echo "cv";
    }
    else if ($request_method=="GET" && $resource[1]=="front") {
        //getFront($parameters);
        echo "front";
    }
    else if ($request_method=="GET" && $resource[1]=="about") {
        //getAbout($parameters);
        echo "about";
    }
    else if ($request_method=="GET" && $resource[1]=="skills") {
        //getSkills($parameters);
        echo "skills";
    }
    else if ($request_method=="GET" && $resource[1]=="experience") {
        //getExperience($parameters);
        echo "experience";
    }
    else if ($request_method=="GET" && $resource[1]=="education") {
        //getEducation($parameters);
        echo "education";
    }
    else if ($request_method=="GET" && $resource[1]=="contact") {
        //getContact($parameters);
        echo "contact";
    }
    else if ($request_method=="PUT" && $resource[1]=="" && $loggedin) {

    }
    else if ($request_method=="DELETE" && $resource[1]=="" && $loggedin) {

    }
    else if ($request_method=="" && $resource[1]=="" && $loggedin) {

    }
    else {
        http_response_code(405); # Method not allowed
    }
}

# ----- PORTFOLIO -----
if ($resource[0]=="portfolio") {
    if ($request_method=="GET" && $resource[1]=="") {
        //getProjects($parameters);
        echo "projects";
    }
    else if ($request_method=="GET" && $resource[1]=="id") {
        echo "one project with id";
    }
    else if ($request_method=="PUT" && $resource[1]=="" && $loggedin) {

    }
    else if ($request_method=="DELETE" && $resource[1]=="" && $loggedin) {

    }
    else if ($request_method=="DELETE" && $resource[1]=="" && $loggedin) {

    }
    else {
        http_response_code(405); # Method not allowed
    }
}
else if ($resource[0]=="portfolio"){
    http_response_code(405); # Method not allowed
}

?>
