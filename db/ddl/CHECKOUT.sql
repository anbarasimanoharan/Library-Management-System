CREATE TABLE CHECKOUT
(
   "UnityId"        VARCHAR2 (20),
   "QueueType"      VARCHAR2 (20),
   "QueueId"        VARCHAR2 (20),
   "DueDate"        TIMESTAMP,
   "CheckOutDate"   TIMESTAMP,
   "ReturnDate"     TIMESTAMP
)
NOCACHE
LOGGING;

ALTER TABLE checkout
   ADD CONSTRAINT fk_checkout_1 FOREIGN KEY ("UnityId")
       REFERENCES rnagill.librarypatron ("UnityId")
       VALIDATE;

ALTER TABLE checkout
   ADD CONSTRAINT fk_checkout_2 FOREIGN KEY ("QueueType", "QueueId")
       REFERENCES rnagill.queue ("QueueType", "QueueId")
       VALIDATE;