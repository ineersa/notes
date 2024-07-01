-- SELECT * FROM migrations;
/**
  Test
 */
-- SELECT * FROM notes;

-- INSERT INTO notes (id, content, metadata, shared, public, archived)
-- VALUES (1, 'test', null, 0, 0, 0);

/*
 Updates
 */
--  UPDATE notes
--  SET created_at=CURRENT_TIMESTAMP
--  WHERE id = 1;

SELECT * FROM notes;

DELETE FROM notes;

SELECT * FROM notes;
