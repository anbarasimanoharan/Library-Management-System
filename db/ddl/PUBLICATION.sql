CREATE TABLE PUBLICATION
(
   ID           NUMBER (*, 0) NOT NULL,
   IDENTIFIER   VARCHAR2 (30) NOT NULL,
   TYPE         VARCHAR2 (20),
   TITLE        VARCHAR2 (100),
   YEAR         NUMBER (*, 0),
   PUBLISHER    VARCHAR2 (100),
   COPY_TYPE    VARCHAR2 (20),
   LOCATION	    VARCHAR2(40),
   IS_RESERVED   CHAR (1)
)
NOCACHE
LOGGING;

ALTER TABLE publication
   ADD CONSTRAINT sys_c00815018 PRIMARY KEY (id) VALIDATE;

ALTER TABLE publication
   ADD CONSTRAINT unique_identifier UNIQUE (identifier) VALIDATE;

ALTER TABLE publication
   ADD CONSTRAINT copy_type CHECK
          (copy_type IN ('Electronic', 'Hardcopy'))
          VALIDATE;
         
ALTER TABLE publication
   ADD CONSTRAINT location_values CHECK
          (location IN ('D.H.Hill Library', 'James B.Hunt Library'))
          VALIDATE;
