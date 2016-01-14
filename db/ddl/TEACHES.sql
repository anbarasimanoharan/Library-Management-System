------------------------------------------------------------------
--  TABLE TEACHES
------------------------------------------------------------------

CREATE TABLE TEACHES
(
   "UnityId"    VARCHAR2 (20),
   "CourseId"   VARCHAR2 (20)
)
NOCACHE
LOGGING;

ALTER TABLE teaches
   ADD CONSTRAINT fk_teaches_2 FOREIGN KEY ("CourseId")
       REFERENCES rnagill.courses ("CourseId")
       VALIDATE;

ALTER TABLE teaches
   ADD CONSTRAINT fk_teaches_1 FOREIGN KEY ("UnityId")
       REFERENCES rnagill.faculty ("UnityId")
       VALIDATE;


