CREATE TABLE FACULTY
(
   "UnityId"           VARCHAR2 (20),
   "FacultyNo"         NUMBER (15) NOT NULL,
   "Name"              VARCHAR2 (32),
   "Category"          VARCHAR2 (20),
   "Nationality"       VARCHAR2 (20),
   "Department"        VARCHAR2 (20)
)
NOCACHE
LOGGING;

ALTER TABLE faculty
   ADD CONSTRAINT sys_c00815737 PRIMARY KEY ("UnityId") VALIDATE;

ALTER TABLE faculty
   ADD CONSTRAINT fk_faculty_1 FOREIGN KEY ("UnityId")
       REFERENCES librarypatron ("UnityId")
       VALIDATE;