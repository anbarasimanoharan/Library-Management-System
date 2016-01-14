CREATE TABLE ALAKSHM6.NOTIFICATION
(
   UNITYID       VARCHAR2 (20) NOT NULL,
   TIME          TIMESTAMP (6) NOT NULL,
   INFORMATION   CLOB
)
NOCACHE
LOGGING;

ALTER TABLE alakshm6.notification
   ADD CONSTRAINT sys_c00879551 PRIMARY KEY (unityid, time) VALIDATE;

ALTER TABLE alakshm6.notification
   ADD CONSTRAINT pk_notification FOREIGN KEY (unityid)
       REFERENCES alakshm6.authentication ("UnityId")
       VALIDATE;