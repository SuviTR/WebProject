DROP TABLE IF EXISTS 'CV';
DROP TABLE IF EXISTS 'Skills';
DROP TABLE IF EXISTS 'Experience';
DROP TABLE IF EXISTS 'Education';
DROP TABLE IF EXISTS 'Some';
DROP TABLE IF EXISTS 'Project';
DROP TABLE IF EXISTS 'Pictures';

CREATE TABLE CV
(
  Fullname INT NOT NULL,
  FrontPicture INT NOT NULL,
  AboutPicture INT NOT NULL,
  Profession INT NOT NULL,
  Heading INT NOT NULL,
  Description INT NOT NULL,
  Call INT NOT NULL,
  Mail INT NOT NULL,
  Address INT NOT NULL,
  PRIMARY KEY (Fullname)
);

CREATE TABLE Skills
(
  Name INT NOT NULL,
  Level INT NOT NULL,
  SId INT NOT NULL,
  Fullname INT NOT NULL,
  PRIMARY KEY (SId),
  FOREIGN KEY (Fullname) REFERENCES CV(Fullname)
);

CREATE TABLE Experience
(
  Title INT NOT NULL,
  Year INT NOT NULL,
  ExId INT NOT NULL,
  Company INT NOT NULL,
  Description INT NOT NULL,
  ProjectLink INT NOT NULL,
  Fullname INT NOT NULL,
  PRIMARY KEY (ExId),
  FOREIGN KEY (Fullname) REFERENCES CV(Fullname)
);

CREATE TABLE Education
(
  EdId INT NOT NULL,
  Academy INT NOT NULL,
  Description INT NOT NULL,
  Degree INT NOT NULL,
  Year INT NOT NULL,
  ProjectLink INT NOT NULL,
  Fullname INT NOT NULL,
  PRIMARY KEY (EdId),
  FOREIGN KEY (Fullname) REFERENCES CV(Fullname)
);

CREATE TABLE Some
(
  SomeId INT NOT NULL,
  Name INT NOT NULL,
  Link INT NOT NULL,
  Fullname INT NOT NULL,
  PRIMARY KEY (SomeId),
  FOREIGN KEY (Fullname) REFERENCES CV(Fullname)
);

CREATE TABLE Project
(
  PId INT NOT NULL,
  Name INT NOT NULL,
  Description INT NOT NULL,
  Picture INT NOT NULL,
  Tag INT NOT NULL,
  Fullname INT NOT NULL,
  PRIMARY KEY (PId),
  FOREIGN KEY (Fullname) REFERENCES CV(Fullname)
);

CREATE TABLE Pictures
(
  Id INT NOT NULL,
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
"123-456-7890​", "jane.doe(at)mail.com", "Example Street 10<br>London, UK");