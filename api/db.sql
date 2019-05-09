use webproject;

DROP TABLE IF EXISTS Experience;
DROP TABLE IF EXISTS Education;
DROP TABLE IF EXISTS Skills;
DROP TABLE IF EXISTS Some;
DROP TABLE IF EXISTS Pictures;
DROP TABLE IF EXISTS Project;
DROP TABLE IF EXISTS CV;

CREATE TABLE CV
(
  Fullname VARCHAR(100) NOT NULL,
  FrontPicture VARCHAR(1000) NOT NULL,
  AboutPicture VARCHAR(1000) NOT NULL,
  Profession VARCHAR(100) NOT NULL,
  Heading VARCHAR(100) NOT NULL,
  Description VARCHAR(1000) NOT NULL,
  Phone VARCHAR(100) NOT NULL,
  Mail VARCHAR(100) NOT NULL,
  Address VARCHAR(100) NOT NULL,
  CvId INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (CvId)
);

CREATE TABLE Skills
(
  Name VARCHAR(100) NOT NULL,
  SkillLevel INT NOT NULL,
  SId INT NOT NULL AUTO_INCREMENT,
  CvId INT NOT NULL,
  PRIMARY KEY (SId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Experience
(
  Title VARCHAR(100) NOT NULL,
  Exp_Year VARCHAR(50) NOT NULL,
  ExId INT NOT NULL AUTO_INCREMENT,
  Company VARCHAR(100) NOT NULL,
  Description VARCHAR(2000) NOT NULL,
  TagLink VARCHAR(1000) NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (ExId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Education
(
  EdId INT NOT NULL AUTO_INCREMENT,
  Academy VARCHAR(100) NOT NULL,
  Description VARCHAR(2000) NOT NULL,
  Degree VARCHAR(100) NOT NULL,
  Edu_Year VARCHAR(50) NOT NULL,
  TagLink VARCHAR(1000) NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (EdId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Some
(
  SomeId INT NOT NULL AUTO_INCREMENT,
  Name VARCHAR(100) NOT NULL,
  Link VARCHAR(1000) NOT NULL,
  SomeIcon VARCHAR(1000) NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (SomeId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Project
(
  PId INT NOT NULL AUTO_INCREMENT,
  Name VARCHAR(100) NOT NULL,
  Subtitle VARCHAR(100) NOT NULL,
  Description VARCHAR(2000) NOT NULL,
  Picture VARCHAR(1000) NOT NULL,
  Tag VARCHAR(100) NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (PId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Pictures
(
  PicId INT NOT NULL AUTO_INCREMENT,
  Link VARCHAR(1000) NOT NULL,
  PId INT NOT NULL,
  PRIMARY KEY (PicId),
  FOREIGN KEY (PId) REFERENCES Project(PId)
);

INSERT INTO CV (CvId, Fullname, FrontPicture, AboutPicture, Profession, Heading,
Description, Phone, Mail, Address)
VALUES (1, "Jane Doe", "/img/cv_janeDoe_cropped2_darkened.jpg",
"/img/cv_janeDoe2_cropped.jpg", "Software engineer", "Hello! I'm Jane",
"I am energetic software engineer
                    with 4 years experience developing robust code for high-volume businesses.
                    I'm a hard working, flexible and reliable person,
                    who learns quickly and willing to undertake any task given me.
                    I enjoy meeting people and work well as part of a team or on my own.
                    I am also fun and caring. My family including my sweet dog means everything to me.
                    I love hanging out with my family and friends.
                    On my spare time I enjoy reading, going hiking and just walking in nature.
                    <br><br><button class=\"resumebutton\" onclick=\"router.navigateTo(window.location.href = \'/resume\');\">See My Resume</button>
                </p>",
"123-456-7890", "jane.doe(at)mail.com", "Example Street 10 London, UK");

INSERT INTO Skills (Name, SkillLevel, SId, CVId)
VALUES ("HTML", 90, 1, 1);

INSERT INTO Experience (Title, Exp_Year, ExId, Company, Description, TagLink, CvId)
VALUES ("Junior Developer", "2018--", 1, "Rovio Entertainment Oyj", "I participated in creating the Angry Birds 2 mobile game. ", "Rovio", 1);

INSERT INTO Education (EdId, Academy, Description, Degree, Edu_Year, TagLink, CvId)
VALUES (1, "Metropolia University of Applied Sciences",
                            "I studied software engineering and graduated with a Bachelor in Information and Communications Technology.
                            I got familiar with Java, Python, making web applications and so on.", "Bachelor\'s Degree", "2012-2015", "Metropolia", 1);

INSERT INTO Some (SomeId, Name, Link, SomeIcon, CvId)
VALUES (1, "LinkedIn", "","img/iconfinder_linkedin_2691280.png", 1);
INSERT INTO Some (SomeId, Name, Link, SomeIcon, CvId)
VALUES (2, "Twitter", "","img/iconfinder_twitter_2691271.png", 1);
INSERT INTO Some (SomeId, Name, Link, SomeIcon, CvId)
VALUES (3, "Instagram", "","img/iconfinder_instagram_2691281.png", 1);

INSERT INTO Project (PId, Name, Subtitle, Description, Picture, Tag, CvId)

VALUES (1, "Playroom", "Playroom for 6 year old girl",
                "The purpose of this project was to design a playroom to my client''s daughter.
                Principles of designing the playroom were its cost and budget. Low-budget means creativity and making things yourself.
                The parents'' wished for good storage system, ease of cleaning and reconfigurability. Colors and small interior items were all child''s choices.
                Type of furniture and materials choices and overall designing were left for me.
                Reconfigurability means that the room was decided to paint white.
                When the child grows older, it''s much easier to change the furniture and decor when walls are neutral.",
                "img/playroom4_cropped2.jpg", "Visual Merchandising", 1);

INSERT INTO Pictures(PicId, Link, PId)
VALUES (1, "/img/playroom.jpeg", 1);
INSERT INTO Pictures(PicId, Link, PId)
VALUES (2, "/img/playroom2.jpg", 1);
INSERT INTO Pictures(PicId, Link, PId)
VALUES (3, "/img/playroom3.jpeg", 1);

