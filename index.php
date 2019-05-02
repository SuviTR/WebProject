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
    $fullname = urldecode($parameters["fullname"]);
    $profession = urldecode($parameters["profession"]);
    $picture = "";

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "SELECT Fullname, Profession, FrontPicture FROM CV WHERE id=1";
    $statement = $conn->prepare($sql);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Selected Front: ";
    foreach ($rows as $row) {
        echo $row['Fullname']." ".$row['Profession']." ".$row['FrontPicture'];
    }
}
function getAbout($parameters) {
    # Example: GET /cv/about
    $heading = urldecode($parameters["heading"]);
    $description = urldecode($parameters["description"]);
    $picture = "";

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "SELECT AboutPicture, Heading, Description FROM CV WHERE id=1";
    $statement = $conn->prepare($sql);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Selected About: ";
    foreach ($rows as $row) {
        echo $row['AboutPicture']." ".$row['Heading']." ".$row['Description'];
    }
}
function getSkills($parameters) {
    # Example: GET /cv/skills
    $id = urldecode($parameters["id"]);
    $skill = urldecode($parameters["skill"]);
    $level = urldecode($parameters["level"]);
    $bar = "";

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "SELECT Name, SkillLevel FROM Skills WHERE Sid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Selected Skills: ";
    foreach ($rows as $row) {
        echo $row['Name']." ".$row['SkillLevel'];
    }
}
function getExperience($parameters) {
    # Example: GET /cv/experience
    $id = urldecode($parameters["id"]);
    $year = urldecode($parameters["year"]);
    $title = urldecode($parameters["title"]);
    $company = urldecode($parameters["company"]);
    $description = urldecode($parameters["description"]);
    $projects = urldecode($parameters["projects"]);

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "SELECT Title, Year, Company, Description, ProjectLink FROM Experience WHERE Exid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Selected Experience: ";
    foreach ($rows as $row) {
        echo $row['Title']." ".$row['Year']." ".$row['Company']." ".$row['Description']." ".$row['ProjectLink'];
    }
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

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "SELECT Academy, Description, Degree, Year, ProjectLink FROM Education WHERE Edid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Selected Education: ";
    foreach ($rows as $row) {
        echo $row['Academy']." ".$row['Description']." ".$row['Degree']." ".$row['Year']." ".$row['ProjectLink'];
    }
}

function getContact($parameters) {
    # Example: GET /cv/contact
    $call = urldecode($parameters["call"]);
    $mail = urldecode($parameters["mail"]);
    $address = urldecode($parameters["address"]);
    $somename = urldecode($parameters["somename"]);
    $somelink = urldecode($parameters["somelink"]);

    echo "Posted ".$parameters["id"]." ".$call." ".$address." ".$somename." ".$somelink;

    $conn = new Database();
    $db = $conn->getConnection();

    //Contact
    $sql = "SELECT Call, Mail, Address FROM CV WHERE Id=1";
    $statement = $conn->prepare($sql);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Selected Contact: ";
    foreach ($rows as $row) {
        echo $row['Call']." ".$row['Mail']." ".$row['Address'];
    }

    //Some
    $sql = "SELECT Name, Link FROM Some";
    $statement = $conn->prepare($sql);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        echo $row['Name']." ".$row['Link'];
    }
}

function putFront($parameters) {
    $fullname = urldecode($parameters["fullname"]);
    $profession = urldecode($parameters["profession"]);
    $picture = "";

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "UPDATE CV SET Fullname=:fullname, Profession=:profession, FrontPicture=:picture WHERE id=1";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':fullname', $fullname, PDO::PARAM_STR);
    $statement->bindParam(':profession', $profession, PDO::PARAM_STR);
    $statement->bindParam(':picture', $picture, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Updated Front: ";
    foreach ($rows as $row) {
        echo $row['Fullname']." ".$row['Profession']." ".$row['FrontPicture'];
    }
}
function putAbout($parameters) {
    $heading = urldecode($parameters["heading"]);
    $description = urldecode($parameters["description"]);
    $picture = "";

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "UPDATE CV SET AboutPicture=:picture, Heading=:heading, Description=:description WHERE id=1";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':picture', $picture, PDO::PARAM_STR);
    $statement->bindParam(':heading', $heading, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Updated About: ";
    foreach ($rows as $row) {
        echo $row['AboutPicture']." ".$row['Heading']." ".$row['Description'];
    }
}
function putSkills($parameters) {
    # Example: GET /cv/skills
    $id = urldecode($parameters["id"]);
    $skill = urldecode($parameters["skill"]);
    $level = urldecode($parameters["level"]);
    $bar = "";

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "SELECT Name, SkillLevel FROM Skills WHERE Sid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Selected Skills: ";
    foreach ($rows as $row) {
        echo $row['Name']." ".$row['SkillLevel'];
    }
}

function putExperience($parameters) {

}

function putEducation($parameters) {

}

function putContact($parameters) {
    $call = urldecode($parameters["call"]);
    $mail = urldecode($parameters["mail"]);
    $address = urldecode($parameters["address"]);
    $somename = urldecode($parameters["somename"]);
    $somelink = urldecode($parameters["somelink"]);

    $conn = new Database();
    $db = $conn->getConnection();

    //Contact
    $sql = "UPDATE CV SET Call=:call, Mail=:mail, Address=:address WHERE Id=1";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':call', $call, PDO::PARAM_STR);
    $statement->bindParam(':mail', $mail, PDO::PARAM_STR);
    $statement->bindParam(':address', $address, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Selected Contact: ";
    foreach ($rows as $row) {
        echo $row['Call']." ".$row['Mail']." ".$row['Address'];
    }

    //Some
    $sql = "UPDATE Some SET Name=:name, Link=:link";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':name', $somename, PDO::PARAM_STR);
    $statement->bindParam(':link', $somelink, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        echo $row['Name']." ".$row['Link'];
    }
}

function deleteSkills($parameters) {
    # Example: GET /cv/skills
    $id = urldecode($parameters["id"]);
    $skill = urldecode($parameters["skill"]);
    $level = urldecode($parameters["level"]);
    $bar = "";

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "DELETE FROM Skills WHERE Sid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Skill deleted ";
    foreach ($rows as $row) {
        echo $row['Name']." ".$row['SkillLevel'];
    }
}
function deleteExperience($parameters) {
    # Example: GET /cv/experience
    $id = urldecode($parameters["id"]);
    $year = urldecode($parameters["year"]);
    $title = urldecode($parameters["title"]);
    $company = urldecode($parameters["company"]);
    $description = urldecode($parameters["description"]);
    $projects = urldecode($parameters["projects"]);

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "DELETE FROM Experience WHERE Exid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Experience deleted ";
    foreach ($rows as $row) {
        echo $row['Title']." ".$row['Year']." ".$row['Company']." ".$row['Description']." ".$row['ProjectLink'];
    }
}
function deleteEducation($parameters) {
    # Example: GET /cv/education
    $id = urldecode($parameters["id"]);
    $year = urldecode($parameters["year"]);
    $title = urldecode($parameters["title"]);
    $academy = urldecode($parameters["academy"]);
    $description = urldecode($parameters["description"]);
    $projects = urldecode($parameters["projects"]);
    echo "Posted ".$parameters["id"]." ".$year." ".$title." ".$academy." ".$description." ".$projects;

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "DELETE FROM Education WHERE Edid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Education deleted ";
    foreach ($rows as $row) {
        echo $row['Academy']." ".$row['Description']." ".$row['Degree']." ".$row['Year']." ".$row['ProjectLink'];
    }
}

# ----- PORTFOLIO Handlers -----

function getPortfolio($parameters){
    # Example: GET /portfolio/
    $id = urldecode($parameters["id"]);
    $name = urldecode($parameters["name"]);
    $subtitle = urldecode($parameters["subtitle"]);
    $description = urldecode($parameters["description"]);
    $picture = urldecode($parameters["picture"]);
    $tag = urldecode($parameters["tag"]);

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "SELECT Name, Subtitle, Description, Picture, Tag FROM Project";
    $statement = $conn->prepare($sql);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Selected Portfolio: ";
    foreach ($rows as $row) {
        echo $row['Name']." ".$row['Subtitle']." ".$row['Description']." ".$row['Picture']." ".$row['Tag'];
    }
}
function getProject($parameters){
    # Example: GET /portfolio/id
    $id = urldecode($parameters["id"]);
    $name = urldecode($parameters["name"]);
    $subtitle = urldecode($parameters["subtitle"]);
    $description = urldecode($parameters["description"]);
    $picture = urldecode($parameters["picture"]);
    $tag = urldecode($parameters["tag"]);

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "SELECT Name, Subtitle, Description, Picture, Tag FROM Project WHERE Pid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Selected Project: ";
    foreach ($rows as $row) {
        echo $row['Name']." ".$row['Subtitle']." ".$row['Description']." ".$row['Picture']." ".$row['Tag'];
    }
}
function putProject($parameters) {

}
function deleteProject($parameters){
    $id = urldecode($parameters["id"]);
    $name = urldecode($parameters["name"]);
    $subtitle = urldecode($parameters["subtitle"]);
    $description = urldecode($parameters["description"]);
    $picture = urldecode($parameters["picture"]);
    $tag = urldecode($parameters["tag"]);

    $conn = new Database();
    $db = $conn->getConnection();

    $sql = "DELETE FROM Project WHERE Pid=:id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "Project deleted ";
    foreach ($rows as $row) {
        echo $row['Name']." ".$row['Subtitle']." ".$row['Description']." ".$row['Picture']." ".$row['Tag'];
    }
}


# Main
// echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'];
// echo "<br>REQUEST_METHOD " . $_SERVER['REQUEST_METHOD'];

$resource = getResource();
// echo "<br>resource: ";
// print_r($resource);

$request_method = getMethod();
$parameters = getParameters();
$loggedin = false;

// echo "<br><br>";

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
        $about_arr = ['heading' => "Hello! I'm Jane",
                    'picture' => "img/cv_janeDoe2_cropped.jpg",
                    'description' => "I am energetic software engineer
                    with 4 years experience developing robust code for high-volume businesses.
                    I'm a hard working, flexible and reliable person,
                    who learns quickly and willing to undertake any task given me.
                    I enjoy meeting people and work well as part of a team or on my own.
                    I am also fun and caring. My family including my sweet dog means everything to me.
                    I love hanging out with my family and friends.
                    On my spare time I enjoy reading, going hiking and just walking in nature.
                    <br><br><button class=\"resumebutton\" onclick=\"window.location.href = 'resume.html';\">See My Resume</button>
                </p>"];
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($about_arr);
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

    else if ($request_method=="PUT" && $resource[1]=="front" && $loggedin) {
        putFront($parameters);
    }
    else if ($request_method=="PUT" && $resource[1]=="about" && $loggedin) {
        putAbout($parameters);
    }
    else if ($request_method=="PUT" && $resource[1]=="skills" && $loggedin) {

    }
    else if ($request_method=="PUT" && $resource[1]=="experience" && $loggedin) {

    }
    else if ($request_method=="PUT" && $resource[1]=="education" && $loggedin) {

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

    //Entäpä somelinkit???

    else if ($request_method=="" && $resource[1]=="" && $loggedin) {

    }
    else {
        http_response_code(405); # Method not allowed
    }

# ----- PORTFOLIO -----
} else if ($resource[0]=="portfolio") {
    if ($request_method=="GET" && $resource[1]=="") {
        //getPortfolio($parameters);
        echo "portfolio";
    }
    else if ($request_method=="GET" && $resource[1]=="id") {
        echo "one project with id";
        getProject($parameters);
    }
    else if ($request_method=="PUT" && $resource[1]=="id" && $loggedin) {

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
