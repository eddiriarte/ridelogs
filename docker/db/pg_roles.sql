-- ############################################################
--
-- Managing PostgresSQL users and roles
--
--   - https://aws.amazon.com/de/blogs/database/managing-postgresql-users-and-roles/
--
-- ############################################################

-- SERVICE USER

CREATE ROLE readwrite;
GRANT CONNECT ON DATABASE app TO readwrite;
GRANT USAGE ON SCHEMA public TO readwrite;
GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO readwrite;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT SELECT, INSERT, UPDATE, DELETE ON TABLES TO readwrite;
GRANT USAGE ON ALL SEQUENCES IN SCHEMA public TO readwrite;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT USAGE ON SEQUENCES TO readwrite;

CREATE USER app_service WITH PASSWORD 'secret';
GRANT readwrite TO app_service;


-- DEPLOY USER
--     https://tableplus.io/blog/2018/06/postgresql-how-to-create-user.html

CREATE USER app_deploy WITH PASSWORD 'secret';
GRANT ALL PRIVILEGES ON DATABASE app TO app_deploy;


-- GROUP
--     creates a group and add some users to set table ownerships
CREATE GROUP app_group WITH USER app_service, app_deploy;
-- REASSIGN OWNED BY root TO app;

-- check tables:
-- SELECT * FROM pg_tables WHERE schemaname = 'public';
