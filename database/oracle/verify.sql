SELECT table_name FROM user_tables ORDER BY 1;
SELECT object_name, object_type, status FROM user_objects WHERE object_type IN ('TRIGGER','FUNCTION','PROCEDURE','SEQUENCE') ORDER BY 2,1;
EXIT;
