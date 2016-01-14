------------------------------------------------------------------
--  TABLE TAKES
------------------------------------------------------------------

CREATE TABLE TAKES
(
   "CourseId"   VARCHAR2 (20),
   "UnityId"    VARCHAR2 (20)
)
NOCACHE
LOGGING;

ALTER TABLE takes
   ADD CONSTRAINT fk_takes_1 FOREIGN KEY ("CourseId")
       REFERENCES rnagill.courses ("CourseId")
       VALIDATE;

ALTER TABLE takes
   ADD CONSTRAINT fk_takes_2 FOREIGN KEY ("UnityId")
       REFERENCES rnagill.student ("UnityId")
       VALIDATE;


