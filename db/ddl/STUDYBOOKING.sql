------------------------------------------------------------------
--  TABLE STUDYBOOKING
------------------------------------------------------------------

CREATE TABLE STUDYBOOKING
(
   "UnityId"        VARCHAR2 (20),
   "Id"             VARCHAR2 (20),
   "CheckoutTime"   TIMESTAMP,
   "Upto"           NUMBER(10)
)
NOCACHE
LOGGING;

ALTER TABLE studybooking
   ADD CONSTRAINT fk_studybooking_1 FOREIGN KEY ("UnityId")
       REFERENCES rnagill.librarypatron ("UnityId")
       VALIDATE;

ALTER TABLE studybooking
   ADD CONSTRAINT fk_studybooking_2 FOREIGN KEY ("Id")
       REFERENCES rnagill.study_room ("Id")
       VALIDATE;


