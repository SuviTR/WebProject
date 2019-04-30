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
  CvId INT NOT NULL,
  PRIMARY KEY (CvId)
);

CREATE TABLE Skills
(
  Name INT NOT NULL,
  Level INT NOT NULL,
  SId INT NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (SId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Experience
(
  Title INT NOT NULL,
  Year INT NOT NULL,
  ExId INT NOT NULL,
  Company INT NOT NULL,
  Description INT NOT NULL,
  ProjectLink INT NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (ExId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Education
(
  EdId INT NOT NULL,
  Academy INT NOT NULL,
  Description INT NOT NULL,
  Degree INT NOT NULL,
  Year INT NOT NULL,
  ProjectLink INT NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (EdId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Some
(
  SomeId INT NOT NULL,
  Name INT NOT NULL,
  Link INT NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (SomeId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Project
(
  PId INT NOT NULL,
  Name INT NOT NULL,
  Description INT NOT NULL,
  Picture INT NOT NULL,
  Tag INT NOT NULL,
  CvId INT NOT NULL,
  PRIMARY KEY (PId),
  FOREIGN KEY (CvId) REFERENCES CV(CvId)
);

CREATE TABLE Pictures
(
  Id INT NOT NULL,
  PId INT NOT NULL,
  PRIMARY KEY (Id),
  FOREIGN KEY (PId) REFERENCES Project(PId)
);
