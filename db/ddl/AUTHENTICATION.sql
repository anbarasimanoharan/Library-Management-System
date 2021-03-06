CREATE TABLE AUTHENTICATION
(
   "UnityId"    VARCHAR2 (20) NOT NULL,
   "Password"   VARCHAR2 (20) NOT NULL
)
NOCACHE
LOGGING;

ALTER TABLE authentication
   ADD CONSTRAINT sys_c00830551 PRIMARY KEY ("UnityId") VALIDATE;

ALTER TABLE authentication
   ADD CONSTRAINT fk_authentication_1 FOREIGN KEY ("UnityId")
       REFERENCES rnagill.librarypatron ("UnityId") ON DELETE CASCADE
       VALIDATE;

GRANT DELETE ON AUTHENTICATION TO ALAKSHM6 WITH GRANT OPTION;

GRANT INSERT ON AUTHENTICATION TO ALAKSHM6 WITH GRANT OPTION;

GRANT SELECT ON AUTHENTICATION TO ALAKSHM6 WITH GRANT OPTION;

GRANT UPDATE ON AUTHENTICATION TO ALAKSHM6 WITH GRANT OPTION;

GRANT REFERENCES ON AUTHENTICATION TO ALAKSHM6 WITH GRANT OPTION;

GRANT ALTER ON AUTHENTICATION TO AMANOHA2 WITH GRANT OPTION;

GRANT DELETE ON AUTHENTICATION TO AMANOHA2 WITH GRANT OPTION;

GRANT INDEX ON AUTHENTICATION TO AMANOHA2 WITH GRANT OPTION;

GRANT INSERT ON AUTHENTICATION TO AMANOHA2 WITH GRANT OPTION;

GRANT SELECT ON AUTHENTICATION TO AMANOHA2 WITH GRANT OPTION;

GRANT UPDATE ON AUTHENTICATION TO AMANOHA2 WITH GRANT OPTION;

GRANT REFERENCES ON AUTHENTICATION TO AMANOHA2 WITH GRANT OPTION;

GRANT ON COMMIT REFRESH ON AUTHENTICATION TO AMANOHA2 WITH GRANT OPTION;

GRANT QUERY REWRITE ON AUTHENTICATION TO AMANOHA2 WITH GRANT OPTION;

GRANT DEBUG ON AUTHENTICATION TO AMANOHA2 WITH GRANT OPTION;

GRANT FLASHBACK ON AUTHENTICATION TO AMANOHA2 WITH GRANT OPTION;

GRANT DELETE ON AUTHENTICATION TO APATLOL2 WITH GRANT OPTION;

GRANT INSERT ON AUTHENTICATION TO APATLOL2 WITH GRANT OPTION;

GRANT SELECT ON AUTHENTICATION TO APATLOL2 WITH GRANT OPTION;

GRANT UPDATE ON AUTHENTICATION TO APATLOL2 WITH GRANT OPTION;

GRANT REFERENCES ON AUTHENTICATION TO APATLOL2 WITH GRANT OPTION;

GRANT ALTER ON AUTHENTICATION TO RNAGILL WITH GRANT OPTION;

GRANT DELETE ON AUTHENTICATION TO RNAGILL WITH GRANT OPTION;

GRANT INDEX ON AUTHENTICATION TO RNAGILL WITH GRANT OPTION;

GRANT INSERT ON AUTHENTICATION TO RNAGILL WITH GRANT OPTION;

GRANT SELECT ON AUTHENTICATION TO RNAGILL WITH GRANT OPTION;

GRANT UPDATE ON AUTHENTICATION TO RNAGILL WITH GRANT OPTION;

GRANT REFERENCES ON AUTHENTICATION TO RNAGILL WITH GRANT OPTION;

GRANT ON COMMIT REFRESH ON AUTHENTICATION TO RNAGILL WITH GRANT OPTION;

GRANT QUERY REWRITE ON AUTHENTICATION TO RNAGILL WITH GRANT OPTION;

GRANT DEBUG ON AUTHENTICATION TO RNAGILL WITH GRANT OPTION;

GRANT FLASHBACK ON AUTHENTICATION TO RNAGILL WITH GRANT OPTION;