CREATE TABLE STUDENT
(
   "UnityId"            VARCHAR2 (20),
   "StudentNo"          NUMBER (20) NOT NULL,
   "Name"               VARCHAR2 (20),
   "PhoneNo"            VARCHAR2 (20),
   "AlternatePhoneNo"   VARCHAR2 (20),
   "HomeAddress"        VARCHAR2 (40),
   "DateOfBirth"        VARCHAR2 (20),
   "Sex"                VARCHAR2 (20),
   "Nationality"        VARCHAR2 (20),
   "Department"         VARCHAR2 (20),
   "Classification"     VARCHAR2 (20),
   "DegreeProgram"      VARCHAR2 (20),
   "Category"           VARCHAR2 (20)
)
NOCACHE
LOGGING;

ALTER TABLE student
   ADD CONSTRAINT sys_c00815740 PRIMARY KEY ("UnityId") VALIDATE;

ALTER TABLE student
   ADD CONSTRAINT "FK_Student_1" FOREIGN KEY ("UnityId")
       REFERENCES rnagill.librarypatron ("UnityId")
       VALIDATE;