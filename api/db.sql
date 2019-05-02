DROP TABLE IF EXISTS 'CV';
DROP TABLE IF EXISTS 'Skills';
DROP TABLE IF EXISTS 'Experience';
DROP TABLE IF EXISTS 'Education';
DROP TABLE IF EXISTS 'Some';
DROP TABLE IF EXISTS 'Project';
DROP TABLE IF EXISTS 'Pictures';

CREATE TABLE CV
(
  Fullname VARCHAR(100) NOT NULL,
  FrontPicture VARCHAR(1000) NOT NULL,
  AboutPicture VARCHAR(1000) NOT NULL,
  Profession VARCHAR(100) NOT NULL,
  Heading VARCHAR(100) NOT NULL,
  Description VARCHAR(1000) NOT NULL,
  Call VARCHAR(100) NOT NULL,
  Mail VARCHAR(100) NOT NULL,
  Address VARCHAR(100) NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (CvId)
);

CREATE TABLE Skills
(
  Name VARCHAR(100) NOT NULL,
  SkillLevel INT NOT NULL,
  SId INT NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (SId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Experience
(
  Title VARCHAR(100) NOT NULL,
  Year VARCHAR(50) NOT NULL,
  ExId INT NOT NULL,
  Company VARCHAR(100) NOT NULL,
  Description VARCHAR(2000) NOT NULL,
  ProjectLink VARCHAR(1000) NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (ExId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Education
(
  EdId INT NOT NULL,
  Academy VARCHAR(100) NOT NULL,
  Description VARCHAR(500) NOT NULL,
  Degree VARCHAR(100) NOT NULL,
  Year VARCHAR(50) NOT NULL,
  ProjectLink VARCHAR(1000) NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (EdId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Some
(
  SomeId INT NOT NULL,
  Name VARCHAR(100) NOT NULL,
  Link VARCHAR(1000) NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (SomeId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Project
(
  PId INT NOT NULL,
  Name VARCHAR(100) NOT NULL,
  Subtitle VARCHAR(100) NOT NULL,
  Description VARCHAR(500) NOT NULL,
  Picture VARCHAR(1000) NOT NULL,
  Tag VARCHAR(100) NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (PId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Pictures
(
  PicId INT NOT NULL,
  Link VARCHAR(1000) NOT NULL,
  PId INT NOT NULL,
  PRIMARY KEY (Id),
  FOREIGN KEY (PId) REFERENCES Project(PId)
);

INSERT INTO CV (Id, Fullname, FrontPicture, AboutPicture, Profession, Heading,
Description, Call, Mail, Address)
VALUES (1, "Jane Doe", "img/cv_janeDoe_cropped2_darkened.jpg",
"img/cv_janeDoe2_cropped.jpg", "Software engineer", "Hello! I'm Jane",
"I am energetic software engineer
                    with 4 years experience developing robust code for high-volume businesses.
                    I'm a hard working, flexible and reliable person,
                    who learns quickly and willing to undertake any task given me.
                    I enjoy meeting people and work well as part of a team or on my own.
                    I am also fun and caring. My family including my sweet dog means everything to me.
                    I love hanging out with my family and friends.
                    On my spare time I enjoy reading, going hiking and just walking in nature.
                    <br><br><button class="resumebutton" onclick="window.location.href = 'resume.html';">See My Resume</button>
                </p>",
"123-456-7890", "jane.doe(at)mail.com", "Example Street 10<br>London, UK");

INSERT INTO Skills (Name, SkillLevel, SId, CVId)
VALUES ("HTML", 90, 1, 1);

INSERT INTO Experience (Title, Year, ExId, Company, Description, ProjectLink, CvId)
VALUES ("Junior Developer", "2018--", 1, "Rovio Entertainment Oyj", "I made..", "", 1);

INSERT INTO Education (EdId, Academy, Description, Degree, Year, ProjectLink, CvId)
VALUES (1, "Metropolia University of Applied Sciences", "I graduated..", "Bachelor's Degree", "2012-2015", "", 1);

INSERT INTO Some (SomeId, Name, Link, CvId)
VALUES (1, "Instagram", "", 1);

INSERT INTO Project (PId, Name, Subtitle, Description, Picture, Tag, CvId)
VALUES (1, "Playroom", "Play room for 6 year old girl", "", "", "Visual Merchandising", 1);

INSERT INTO Pictures(PicId, Link, PId)
VALUES (1, "", 1);
