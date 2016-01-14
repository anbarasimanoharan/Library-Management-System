CREATE TABLE QUEUE
(
   "QueueType"    VARCHAR2 (20) NOT NULL,
   "QueueId"      VARCHAR2 (20) NOT NULL,
   "WaitlistNo"   VARCHAR2 (20),
   "UnityId"      VARCHAR2 (20),
   "Id"           VARCHAR2 (20)
)
NOCACHE
LOGGING;

ALTER TABLE queue
   ADD CONSTRAINT sys_c00815744 PRIMARY KEY ("QueueType", "QueueId") VALIDATE;

ALTER TABLE queue
   ADD CONSTRAINT fk_queue_1 FOREIGN KEY ("UnityId")
       REFERENCES rnagill.librarypatron ("UnityId")
       VALIDATE;