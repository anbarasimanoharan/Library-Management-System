------------------------------------------------------------------
--  TABLE ROOM
------------------------------------------------------------------

CREATE TABLE ROOM
(
   ID     NUMBER (*, 0) NOT NULL,
   LOCATION   VARCHAR2 (40) NOT NULL,
   TYPE   VARCHAR2 (20) NOT NULL,
   IS_RESERVED   CHAR (1)
)
NOCACHE
LOGGING;

ALTER TABLE room
   ADD CONSTRAINT sys_c00815001 PRIMARY KEY (id) VALIDATE;

ALTER TABLE room
   ADD CONSTRAINT type_values CHECK (TYPE IN ('Study', 'Conference'))
       VALIDATE;

ALTER TABLE room
   ADD CONSTRAINT location_values CHECK
          (location IN ('D.H.Hill Library', 'James B.Hunt Library'))
          VALIDATE;

