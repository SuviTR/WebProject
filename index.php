<?php

# ----- SQL OPERATIONS -----
include_once 'config.php';
include_once 'functions.php';

# Main
// echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'];
// echo "<br>REQUEST_METHOD " . $_SERVER['REQUEST_METHOD'];

$resource = getResource();
$is_api = array_shift($resource);
// echo "<br>resource: ";
// print_r($resource);

$request_method = getMethod();
$parameters = getParameters();
$loggedin = true;

// echo "<br><br>";

# Redirect to appropriate handlers.
# ----- CV/ -----
if($is_api != "api") {
    //Let's fire up the default view!
    include('index.html');
    exit();
}
if ($resource[0]=="cv") {
    if ($request_method=="GET" && $resource[1]=="") {
        //getCV($parameters);
        echo "cv";
    }
    else if ($request_method=="GET" && $resource[1]=="front") {
        getFront($parameters);
    }
    else if ($request_method=="GET" && $resource[1]=="about") {
        getAbout($parameters);
    }
    else if ($request_method=="GET" && $resource[1]=="skills") {
        getSkills($parameters);
    }
    else if ($request_method=="GET" && $resource[1]=="experience") {
        getExperiences($parameters);
    }
    else if ($request_method=="GET" && $resource[1]=="education") {
        getEducations($parameters);
    }
    else if ($request_method=="GET" && $resource[1]=="contact") {
        getContacts($parameters);

    }

    else if ($request_method=="PUT" && $resource[1]=="front" && $loggedin) {
        putFront($resource[2]);
    }
    else if ($request_method=="PUT" && $resource[1]=="about" && $loggedin) {
        putAbout($resource[2]);
    }
    else if ($request_method=="PUT" && $resource[1]=="skills" && $loggedin) {
        putSkills($resource[2]);
    }
    else if ($request_method=="PUT" && $resource[1]=="experience" && $loggedin) {
        putExperience($resource[2]);
    }
    else if ($request_method=="PUT" && $resource[1]=="education" && $loggedin) {
        putEducation($resource[2]);
    }
    else if ($request_method=="PUT" && $resource[1]=="contact" && $loggedin) {
        putContact($resource[2]);
    }

    else if ($request_method=="DELETE" && $resource[1]=="skills" && $loggedin) {
        deleteSkills($resource[2]);
    }
    else if ($request_method=="DELETE" && $resource[1]=="experience" && $loggedin) {
        deleteExperience($resource[2]);
    }
    else if ($request_method=="DELETE" && $resource[1]=="education" && $loggedin) {
        deleteEducation($resource[2]);
    }
    else if ($request_method=="DELETE" && $resource[1]=="contact" && $loggedin) {
        deleteSome($resource[2]);
    }

    else if ($request_method=="" && $resource[1]=="" && $loggedin) {

    }
    else {
        http_response_code(405); # Method not allowed
    }

# ----- PORTFOLIO -----
} else if ($resource[0]=="portfolio") {
    if ($request_method=="GET" && $resource[1]=="") {
        getPortfolio($parameters);
    }
    else if ($request_method=="GET" && $resource[1]=="id") {
        echo "one project with id";
        getProject($resource[2]);
    }
    else if ($request_method=="PUT" && $resource[1]=="id" && $loggedin) {
        putProject($resource[2]);
    }
    else if ($request_method=="DELETE" && $resource[1]=="id" && $loggedin) {
        deleteProject($resource[2]);
    }

    else {
        http_response_code(405); # Method not allowed
    }
}
?>
