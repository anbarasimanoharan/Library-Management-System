------------------------------------------------------------------
--  TABLE CONFERENCE_ROOM
------------------------------------------------------------------

CREATE TABLE CONFERENCE_ROOM
(
   ID         NUMBER (*, 0),
   ROOM_NO    VARCHAR2 (20) NOT NULL,
   FLOOR_NO   NUMBER (*, 0) NOT NULL,
   CAPACITY   NUMBER (*, 0)
)
NOCACHE
LOGGING;

ALTER TABLE conference_room
   ADD CONSTRAINT sys_c00815005 PRIMARY KEY (id) VALIDATE;

ALTER TABLE conference_room
   ADD CONSTRAINT fk_conference_room_1 FOREIGN KEY (id)
       REFERENCES alakshm6.room (id)
       VALIDATE;



