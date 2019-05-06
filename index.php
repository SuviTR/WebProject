<?php
# ----- URI PARSER FUNCTIONS -----
function getResource() {
    # returns numerically indexed array of URI parts
    $resource_string = $_SERVER['REQUEST_URI'];
    if (strstr($resource_string, '?')) {
        $resource_string = substr($resource_string, 0, strpos($resource_string, '?'));
    }
    $resource = array();
    $resource = explode('/', $resource_string);
    array_shift($resource); //There is an empty cell because of the trailing slash.
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

# ----- SQL OPERATIONS -----
include_once 'config.php';

# ----- CV Handlers -----
function getCV($parameters) {
    # implements GET method for cv -> GET /cv/
    #print version
    echo "Posted ";
}
function getFront($parameters) {
    # Example: GET /cv/front

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT Fullname, Profession, FrontPicture FROM CV WHERE CvId=1";
    $statement = $conn->prepare($sql);
    $statement->execute();

    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);

}
function getAbout($parameters) {
    # Example: GET /cv/about

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT AboutPicture, Heading, Description FROM CV WHERE CvId=1";
    $statement = $conn->prepare($sql);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}
function getSkills($parameters) {
    # Example: GET /cv/skills

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT Name, SkillLevel FROM Skills";
    $statement = $conn->prepare($sql);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}
function getExperiences($parameters) {
    # Example: GET /cv/experience

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT Title, Exp_Year, Company, Description, TagLink FROM Experience";
    $statement = $conn->prepare($sql);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}
function getEducations($parameters) {
    # Example: GET /cv/education

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT Academy, Description, Degree, Edu_Year, TagLink FROM Education";
    $statement = $conn->prepare($sql);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}

function getContacts($parameters) {
    # Example: GET /cv/contact

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT
            CV.Phone, CV.Mail, CV.Address,
            Some.Name, Some.Link, Some.SomeIcon
            FROM Some
            INNER JOIN CV
            ON Some.SomeId = CV.CvId";
    $statement = $conn->prepare($sql);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}

function putFront($parameters) {
    $fullname = urldecode($parameters["fullname"]);
    $profession = urldecode($parameters["profession"]);
    $picture = urldecode($parameters["picture"]);

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "UPDATE CV SET Fullname=:fullname, Profession=:profession, FrontPicture=:picture WHERE CvId=1";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':fullname', $fullname, PDO::PARAM_STR);
    $statement->bindParam(':profession', $profession, PDO::PARAM_STR);
    $statement->bindParam(':picture', $picture, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}
function putAbout($parameters) {
    $heading = urldecode($parameters["heading"]);
    $description = urldecode($parameters["description"]);
    $picture = urldecode($parameters["picture"]);

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "UPDATE CV SET AboutPicture=:picture, Heading=:heading, Description=:description WHERE CvId=1";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':picture', $picture, PDO::PARAM_STR);
    $statement->bindParam(':heading', $heading, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}
function putSkills($parameters) {
    # Example: GET /cv/skills
    $putdata = file_get_contents('php://input');
    $para = json_decode($putdata, true);

    $db = new Database();
    $conn = $db->getConnection();

    if (!isset($parameters)) {
        $sql = "INSERT INTO Skills (Name, SkillLevel) VALUES (:skill, :level)";

        $statement = $conn->prepare($sql);
        $statement->bindParam(':skill', $para["Name"], PDO::PARAM_STR);
        $statement->bindParam(':level', $para["SkillLevel"], PDO::PARAM_STR);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($rows);
    }

    else {
        $sql = "UPDATE Skills SET Name=:skill, SkillLevel=:level";

        $statement = $conn->prepare($sql);
        $statement->bindParam(':skill', $para["Name"], PDO::PARAM_STR);
        $statement->bindParam(':level', $para["SkillLevel"], PDO::PARAM_STR);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($rows);
    }
}

function putExperience($parameters) {


    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT Title, Exp_Year, Company, Description, TagLink FROM Experience";

    $sql = "IF EXISTS (SELECT * FROM Experience WHERE Sid=:id)
            UPDATE Experience SET Title=:title, Exp_year=:expyear, Company=:company, Description=:description, TagLink=:taglink WHERE Sid=:id
            ELSE INSERT INTO Experience (Title, Exp_year, Company, Description, TagLink) VALUES (:title, :expyear, :company, :description, :taglink)";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':expyear', $expyear, PDO::PARAM_STR);
    $statement->bindParam(':company', $company, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':taglink', $taglink, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}

function putEducation($parameters) {
    $id = urldecode($parameters["id"]);
    $academy = urldecode($parameters["academy"]);
    $description = urldecode($parameters["description"]);
    $degree = urldecode($parameters["degree"]);
    $eduyear = urldecode($parameters["eduyear"]);
    $taglink = urldecode($parameters["taglink"]);

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "IF EXISTS (SELECT * FROM Education WHERE Sid=:id)
            UPDATE Education SET Academy=:academy, Description=:description, Degree=:degree, Edu_year=:eduyear, TagLink=:taglink WHERE Sid=:id
            ELSE INSERT INTO Education (Academy, Description, Degree, Edu_year, TagLink) VALUES (:academy, :description, :degree, :eduyear, :taglink)";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->bindParam(':academy', $academy, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':degree', $degree, PDO::PARAM_STR);
    $statement->bindParam(':eduyear', $eduyear, PDO::PARAM_STR);
    $statement->bindParam(':taglink', $taglink, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}

function putContact($parameters) {
    $call = urldecode($parameters["call"]);
    $mail = urldecode($parameters["mail"]);
    $address = urldecode($parameters["address"]);
    $somename = urldecode($parameters["somename"]);
    $somelink = urldecode($parameters["somelink"]);

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "BEGIN TRANSACTION

            UPDATE CV SET Call=:call, Mail=:mail, Address=:address WHERE CvId=1    
            UPDATE CV SET Name=:name, Link=:link
            
            COMMIT";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':call', $call, PDO::PARAM_STR);
    $statement->bindParam(':mail', $mail, PDO::PARAM_STR);
    $statement->bindParam(':address', $address, PDO::PARAM_STR);
    $statement->bindParam(':name', $somename, PDO::PARAM_STR);
    $statement->bindParam(':link', $somelink, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}

function deleteSkills($parameters) {
    # Example: GET /cv/skills
    $id = urldecode($parameters["id"]);

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "DELETE FROM Skills WHERE Sid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}
function deleteExperience($parameters) {
    # Example: GET /cv/experience
    $id = urldecode($parameters["id"]);

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "DELETE FROM Experience WHERE Exid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}
function deleteEducation($parameters) {
    # Example: GET /cv/education
    $id = urldecode($parameters["id"]);

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "DELETE FROM Education WHERE Edid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}

# ----- PORTFOLIO Handlers -----

function getPortfolio($parameters){
    # Example: GET /portfolio/

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT Name, Subtitle, Description, Picture, Tag FROM Project";
    $statement = $conn->prepare($sql);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}
function getProject($parameters){
    # Example: GET /portfolio/id
    $id = urldecode($parameters["id"]);

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT Name, Subtitle, Description, Picture, Tag FROM Project WHERE Pid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}
function putProject($parameters) {
    $id = urldecode($parameters["id"]);
    $name = urldecode($parameters["name"]);
    $subtitle = urldecode($parameters["subtitle"]);
    $description = urldecode($parameters["description"]);
    $picture = urldecode($parameters["picture"]);
    $tag = urldecode($parameters["tag"]);

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "IF EXISTS (SELECT * FROM Education WHERE Sid=:id)
            UPDATE Education SET Academy=:academy, Description=:description, Degree=:degree, Edu_year=:eduyear, TagLink=:taglink WHERE Sid=:id
            ELSE INSERT INTO Education (Academy, Description, Degree, Edu_year, TagLink) VALUES (:academy, :description, :degree, :eduyear, :taglink)";

    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);

}
function deleteProject($parameters){
    $id = urldecode($parameters["id"]);

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "DELETE FROM Project WHERE Pid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}


# Main
// echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'];
// echo "<br>REQUEST_METHOD " . $_SERVER['REQUEST_METHOD'];

$resource = getResource();
// echo "<br>resource: ";
// print_r($resource);

$request_method = getMethod();
$parameters = getParameters();
$loggedin = true;

// echo "<br><br>";

# Redirect to appropriate handlers.
# ----- CV/ -----
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
        putFront($parameters);
    }
    else if ($request_method=="PUT" && $resource[1]=="about" && $loggedin) {
        putAbout($parameters);
    }
    else if ($request_method=="PUT" && $resource[1]=="skills" && $loggedin) {
        putSkills($resource[2]);
    }
    else if ($request_method=="PUT" && $resource[1]=="experience" && $loggedin) {
        putExperience($parameters);
    }
    else if ($request_method=="PUT" && $resource[1]=="education" && $loggedin) {
        putEducation($parameters);
    }
    else if ($request_method=="PUT" && $resource[1]=="contact" && $loggedin) {
        putContact($parameters);
    }

    else if ($request_method=="DELETE" && $resource[1]=="skills" && $loggedin) {
        deleteSkills($parameters);
    }
    else if ($request_method=="DELETE" && $resource[1]=="experience" && $loggedin) {
        deleteExperience($parameters);
    }
    else if ($request_method=="DELETE" && $resource[1]=="education" && $loggedin) {
        deleteEducation($parameters);
    }
    else if ($request_method=="DELETE" && $resource[1]=="contact" && $loggedin) {
        deleteSome($parameters);
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
        getProject($parameters);
    }
    else if ($request_method=="PUT" && $resource[1]=="id" && $loggedin) {
        putProject($parameters);
    }
    else if ($request_method=="DELETE" && $resource[1]=="id" && $loggedin) {
        deleteProject($parameters);
    }

    else {
        http_response_code(405); # Method not allowed
    }
} else if ($resource[0]=="oddball"){
    http_response_code(405); # Method not allowed
} else {
    //Let's fire up the default view!
    include('index.html');
}
?>
