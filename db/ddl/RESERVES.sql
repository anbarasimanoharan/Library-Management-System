------------------------------------------------------------------
--  TABLE RESERVES
------------------------------------------------------------------

CREATE TABLE RESERVES
(
   ISBN        VARCHAR2 (30),
   "UnityId"   VARCHAR2 (20)
)
NOCACHE
LOGGING;

ALTER TABLE reserves
   ADD CONSTRAINT fk_reserves_2 FOREIGN KEY ("UnityId")
       REFERENCES rnagill.faculty ("UnityId")
       VALIDATE;

ALTER TABLE reserves
   ADD CONSTRAINT fk_reserves_1 FOREIGN KEY (isbn)
       REFERENCES rnagill.book (isbn)
       VALIDATE;


