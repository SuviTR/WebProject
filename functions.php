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
    $putdata = file_get_contents('php://input');
    $para = json_decode($putdata, true);

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "UPDATE CV SET Fullname=:fullname, Profession=:profession, FrontPicture=:picture WHERE CvId=1";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':fullname', $para["Fullname"], PDO::PARAM_STR);
    $statement->bindParam(':profession', $para["Profession"], PDO::PARAM_STR);
    $statement->bindParam(':picture', $para["FrontPicture"], PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}
function putAbout($parameters) {
    $putdata = file_get_contents('php://input');
    $para = json_decode($putdata, true);

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "UPDATE CV SET AboutPicture=:picture, Heading=:heading, Description=:description WHERE CvId=1";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':picture', $para["AboutPicture"], PDO::PARAM_STR);
    $statement->bindParam(':heading', $para["Heading"], PDO::PARAM_STR);
    $statement->bindParam(':description', $para["Description"], PDO::PARAM_STR);

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
    $putdata = file_get_contents('php://input');
    $para = json_decode($putdata, true);

    $db = new Database();
    $conn = $db->getConnection();

    if (!isset($parameters)) {

        $sql = "INSERT INTO Experience (Title, Exp_Year, Company, Description, TagLink) VALUES (:title, :exp_year, :company, :description, :taglink)";

        $statement = $conn->prepare($sql);

        $statement->bindParam(':title', $para["Title"], PDO::PARAM_STR);
        $statement->bindParam(':expyear', $para["Exp_year"], PDO::PARAM_STR);
        $statement->bindParam(':company', $para["Company"], PDO::PARAM_STR);
        $statement->bindParam(':description', $para["Description"], PDO::PARAM_STR);
        $statement->bindParam(':taglink', $para["TagLink"], PDO::PARAM_STR);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($rows);
    }
    else {
        $sql = "UPDATE Experience SET Title=:title, Exp_Year=:expyear, Company=:company, Description=:description, TagLink=:taglink";

        $statement = $conn->prepare($sql);

        $statement->bindParam(':title', $para["Title"], PDO::PARAM_STR);
        $statement->bindParam(':expyear', $para["Exp_year"], PDO::PARAM_STR);
        $statement->bindParam(':company', $para["Company"], PDO::PARAM_STR);
        $statement->bindParam(':description', $para["Description"], PDO::PARAM_STR);
        $statement->bindParam(':taglink', $para["TagLink"], PDO::PARAM_STR);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($rows);
    }
}

function putEducation($parameters) {

    $putdata = file_get_contents('php://input');
    $para = json_decode($putdata, true);

    $db = new Database();
    $conn = $db->getConnection();

    if (!isset($parameters)) {
        $sql = "INSERT INTO Education (Academy, Description, Degree, Edu_year, TagLink) VALUES (:academy, :description, :degree, :eduyear, :taglink)";

        $statement = $conn->prepare($sql);
        $statement->bindParam(':academy', $para["Academy"], PDO::PARAM_STR);
        $statement->bindParam(':description', $para["Description"], PDO::PARAM_STR);
        $statement->bindParam(':degree', $para["Degree"], PDO::PARAM_STR);
        $statement->bindParam(':eduyear', $para["Edu_year"], PDO::PARAM_STR);
        $statement->bindParam(':taglink', $para["TagLink"], PDO::PARAM_STR);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($rows);
    }
    else {
        $sql = "UPDATE Education SET Academy=:academy, Description=:description, Degree=:degree, Edu_year=:eduyear, TagLink=:taglink";

        $statement = $conn->prepare($sql);
        $statement->bindParam(':academy', $para["Academy"], PDO::PARAM_STR);
        $statement->bindParam(':description', $para["Description"], PDO::PARAM_STR);
        $statement->bindParam(':degree', $para["Degree"], PDO::PARAM_STR);
        $statement->bindParam(':eduyear', $para["Edu_year"], PDO::PARAM_STR);
        $statement->bindParam(':taglink', $para["TagLink"], PDO::PARAM_STR);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($rows);
    }
}

function putContact($parameters) {

    $putdata = file_get_contents('php://input');
    $para = json_decode($putdata, true);

    $db = new Database();
    $conn = $db->getConnection();

    if (!isset($parameters)) {
        $sql = "INSERT INTO Contact (Phone, Mail, Address) VALUES (:phone, :mail, :address)";

        $statement = $conn->prepare($sql);
        $statement->bindParam(':phone', $para["Phone"], PDO::PARAM_STR);
        $statement->bindParam(':mail', $para["Mail"], PDO::PARAM_STR);
        $statement->bindParam(':address', $para["Address"], PDO::PARAM_STR);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $sql = "INSERT INTO Some (Name, Link) VALUES (:name, :link)";

        $statement = $conn->prepare($sql);
        $statement->bindParam(':name', $para["Name"], PDO::PARAM_STR);
        $statement->bindParam(':link', $para["Link"], PDO::PARAM_STR);

        $statement->execute();
        $rows2 = $statement->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($rows);
    }
    else {
        $sql = "UPDATE Contact SET Phone=:phone, Mail=:mail, Address=:address";

        $statement = $conn->prepare($sql);
        $statement->bindParam(':phone', $para["Phone"], PDO::PARAM_STR);
        $statement->bindParam(':mail', $para["Mail"], PDO::PARAM_STR);
        $statement->bindParam(':address', $para["Address"], PDO::PARAM_STR);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $sql = "UPDATE Some SET (:name, :link)";

        $statement = $conn->prepare($sql);
        $statement->bindParam(':name', $para["Name"], PDO::PARAM_STR);
        $statement->bindParam(':link', $para["Link"], PDO::PARAM_STR);

        $statement->execute();
        $rows2 = $statement->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($rows);
    }
}

function deleteSkills($parameters) {
    # Example: GET /cv/skills
    $message = array("msgS"=>"success", "msgE"=>"error");

    $putdata = file_get_contents('php://input');
    $para = json_decode($putdata, true);

    $db = new Database();
    $conn = $db->getConnection();

    if (!isset($parameters)) {
        $sql = "DELETE FROM Skills WHERE SId=:id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id', $para["SId"], PDO::PARAM_STR);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($rows);
        echo json_encode($message["msgS"]);
    }
    else {
        echo json_encode($message["msgE"]);
    }
}
function deleteExperience($parameters) {
    # Example: GET /cv/experience
    $message = array("msgS"=>"success", "msgE"=>"error");

    $putdata = file_get_contents('php://input');
    $para = json_decode($putdata, true);

    $db = new Database();
    $conn = $db->getConnection();

    if (!isset($parameters)) {
        $sql = "DELETE FROM Experience WHERE ExId=:id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id', $para["ExId"], PDO::PARAM_STR);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($rows);
        echo json_encode($message["msgS"]);
    }
    else {
        json_encode($message["msgE"]);
    }
}
function deleteEducation($parameters) {
    # Example: GET /cv/education
    $message = array("msgS"=>"success", "msgE"=>"error");

    $putdata = file_get_contents('php://input');
    $para = json_decode($putdata, true);

    $db = new Database();
    $conn = $db->getConnection();

    if (!isset($parameters)) {
        $sql = "DELETE FROM Education WHERE EdId=:id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id', $para["EdId"], PDO::PARAM_STR);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($rows);
        echo json_encode($message["msgS"]);
    }
    else {
        echo json_encode($message["msgE"]);
    }
}

# ----- PORTFOLIO Handlers -----

function getPortfolio($parameters){
    # Example: GET /portfolio/

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT Name, Subtitle, Description, Picture, Tag, PId FROM Project";
    $statement = $conn->prepare($sql);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}
function getProject($id){
    # Example: GET /portfolio/id


    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT Name, Subtitle, Description, Picture, Tag FROM Project WHERE PId=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);
}
function putProject($parameters) {

    $putdata = file_get_contents('php://input');
    $para = json_decode($putdata, true);

    $db = new Database();
    $conn = $db->getConnection();

    if (!isset($parameters)) {
        $sql = "INSERT INTO Project (Name, Subtitle, Decription, Picture, Tag) VALUES (:name, :subtitle, :description, :picture, :tag)";

        $statement = $conn->prepare($sql);
        $statement->bindParam(':name', $para["Name"], PDO::PARAM_STR);
        $statement->bindParam(':subtitle', $para["Subtitle"], PDO::PARAM_STR);
        $statement->bindParam(':description', $para["Description"], PDO::PARAM_STR);
        $statement->bindParam(':picture', $para["Picture"], PDO::PARAM_STR);
        $statement->bindParam(':tag', $para["Tag"], PDO::PARAM_STR);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($rows);
    }
    else {
        $sql = "UPDATE Project SET Name=:name, Subtitle=:subtitle, Description=:description, Picture=:picture, Tag=:tag";

        $statement = $conn->prepare($sql);
        $statement->bindParam(':name', $para["Name"], PDO::PARAM_STR);
        $statement->bindParam(':subtitle', $para["Subtitle"], PDO::PARAM_STR);
        $statement->bindParam(':description', $para["Description"], PDO::PARAM_STR);
        $statement->bindParam(':picture', $para["Picture"], PDO::PARAM_STR);
        $statement->bindParam(':tag', $para["Tag"], PDO::PARAM_STR);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($rows);
    }
    function deleteProject($parameters){
        $message = array("msgS"=>"success", "msgE"=>"error");

        $putdata = file_get_contents('php://input');
        $para = json_decode($putdata, true);

        $db = new Database();
        $conn = $db->getConnection();

        if (!isset($parameters)) {
            $sql = "DELETE FROM Project WHERE PId=:id";
            $statement = $conn->prepare($sql);
            $statement->bindParam(':id', $para["PId"], PDO::PARAM_STR);

            $statement->execute();
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode($rows);
            echo json_encode($message["msgS"]);
        }
        else {
            echo json_encode($message["msgE"]);}
    }
}