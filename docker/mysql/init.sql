-- MySQL initialization script for AdminLTE Laravel Application

-- Create additional configurations if needed
SET GLOBAL sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO';

-- Set timezone
SET GLOBAL time_zone = '+07:00';

-- Create indexes for better performance (will be created by migrations)
-- These are just placeholders, actual table creation will be handled by Laravel migrations

FLUSH PRIVILEGES;
