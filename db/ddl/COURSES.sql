------------------------------------------------------------------
--  TABLE COURSES
------------------------------------------------------------------

CREATE TABLE COURSES
(
   "CourseId"   VARCHAR2 (20) NOT NULL
)
NOCACHE
LOGGING;

ALTER TABLE courses
   ADD CONSTRAINT sys_c00815753 PRIMARY KEY ("CourseId") VALIDATE;


