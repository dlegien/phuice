-- Patch 1.0.0.0

--
-- DO
--

START TRANSACTION;

INSERT INTO changelog (date, change, version) VALUES
(NOW(), "Applied Patch 1.0.0.0", "1.0.0.0");

COMMIT;

--
-- UNDO
--

START TRANSACTION;

INSERT INTO changelog (date, change, version) VALUES
(NOW(), "Reverted Patch 1.0.0.0", "0.0.0.0");

COMMIT;

--
--
--