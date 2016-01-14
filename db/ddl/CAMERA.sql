------------------------------------------------------------------
--  TABLE CAMERA
------------------------------------------------------------------

CREATE TABLE CAMERA
(
   ID                   VARCHAR2 (20) NOT NULL,
   MAKE                 VARCHAR2 (20),
   MODEL                VARCHAR2 (20),
   LENS_CONFIGURATION   VARCHAR2 (50),
   MEMORY               VARCHAR2 (50),
   LOCATION             VARCHAR2 (40),
   IS_RESERVED   		CHAR (1)
)
NOCACHE
LOGGING;

ALTER TABLE camera
   ADD CONSTRAINT sys_c00815014 PRIMARY KEY (id) VALIDATE;

ALTER TABLE camera
   ADD CONSTRAINT library_locations CHECK
          (location IN ('D.H.Hill Library', 'James B.Hunt Library'))
          VALIDATE;


