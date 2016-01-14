CREATE TABLE AUTHOR
(
   IDENTIFIER         VARCHAR2 (30),
   PUBLICATION_TYPE   VARCHAR2 (30),
   NAME               VARCHAR2 (50)
)
NOCACHE
LOGGING;

ALTER TABLE author
   ADD CONSTRAINT fk_author_1 FOREIGN KEY (identifier)
       REFERENCES alakshm6.publication (identifier)
       VALIDATE;

ALTER TABLE author
   ADD CONSTRAINT publication_type CHECK
          (publication_type IN ('Book', 'Journal', 'Conference Proceeding'))
          VALIDATE;