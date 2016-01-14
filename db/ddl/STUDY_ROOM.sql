------------------------------------------------------------------
--  TABLE STUDY_ROOM
------------------------------------------------------------------

CREATE TABLE STUDY_ROOM
(
   ID         NUMBER (*, 0),
   ROOM_NO    VARCHAR2 (20) NOT NULL,
   FLOOR_NO   NUMBER (*, 0),
   CAPACITY   NUMBER (*, 0)
)
NOCACHE
LOGGING;

ALTER TABLE study_room
   ADD CONSTRAINT sys_c00815010 PRIMARY KEY (id) VALIDATE;

ALTER TABLE study_room
   ADD CONSTRAINT fk_study_room_1 FOREIGN KEY (id)
       REFERENCES alakshm6.room (id)
       VALIDATE;



