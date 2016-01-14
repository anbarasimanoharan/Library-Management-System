------------------------------------------------------------------
--  TABLE CONFERENCE_PROCEEDING
------------------------------------------------------------------

CREATE TABLE CONFERENCE_PROCEEDING
(
   ID                  NUMBER (*, 0),
   CONFERENCE_NUMBER   VARCHAR2 (20) NOT NULL,
   CONFERENCE_NAME     VARCHAR2 (100)
)
NOCACHE
LOGGING;

ALTER TABLE conference_proceeding
   ADD CONSTRAINT sys_c00815027 PRIMARY KEY (id, conference_number) VALIDATE;

ALTER TABLE conference_proceeding
   ADD CONSTRAINT fk_conference_proceeding_1 FOREIGN KEY (id)
       REFERENCES alakshm6.publication (id)
       VALIDATE;
       
ALTER TABLE conference_proceeding
   ADD CONSTRAINT fk_conference_proceeding_2 FOREIGN KEY (conference_number)
       REFERENCES alakshm6.publication (identifier)
       VALIDATE;


