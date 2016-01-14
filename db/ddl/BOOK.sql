CREATE TABLE BOOK
(
   ID            NUMBER (*, 0),
   ISBN          VARCHAR2 (30),
   EDITION       VARCHAR2 (20),
   IS_RESERVED   CHAR (1)
)
NOCACHE
LOGGING;

ALTER TABLE book
   ADD CONSTRAINT sys_c00815020 PRIMARY KEY (id, isbn) VALIDATE;

ALTER TABLE book
   ADD CONSTRAINT fk_book_2 FOREIGN KEY (id)
       REFERENCES alakshm6.publication (id)
       VALIDATE;

ALTER TABLE book
   ADD CONSTRAINT fk_book_1 FOREIGN KEY (isbn)
       REFERENCES alakshm6.publication (identifier)
       VALIDATE;
