------------------------------------------------------------------
--  TABLE JOURNAL
------------------------------------------------------------------

CREATE TABLE JOURNAL
(
   ID     NUMBER (*, 0),
   ISSN   VARCHAR2 (30)
)
NOCACHE
LOGGING;

ALTER TABLE journal
   ADD CONSTRAINT sys_c00815023 PRIMARY KEY (id, issn) VALIDATE;

ALTER TABLE journal
   ADD CONSTRAINT fk_journal_2 FOREIGN KEY (issn)
       REFERENCES alakshm6.publication (identifier)
       VALIDATE;

ALTER TABLE journal
   ADD CONSTRAINT fk_journal_1 FOREIGN KEY (id)
       REFERENCES alakshm6.publication (id)
       VALIDATE;


