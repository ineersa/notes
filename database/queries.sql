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

-- DELETE FROM notes;
--
-- DELETE FROM tags;
--
-- DELETE FROM taggables;

-- delete from migrations;
--
-- insert into migrations (migration, batch) values ('2024_07_01_142814_create_notes_table', 1);

SELECT * FROM notes;

SELECT * FROM tags;

SELECT * FROM taggables;

