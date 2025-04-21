DROP TABLE IF EXISTS MEME_VARIATION;
DROP TABLE IF EXISTS MEME_REFERENCE;  
DROP TABLE IF EXISTS MEME_TREND;     

DROP TABLE IF EXISTS MEME;

UPDATE users SET is_admin = 1 WHERE username = 'ScootingStar';
ALTER TABLE users ADD COLUMN is_admin BOOLEAN NOT NULL DEFAULT 0;

ALTER TABLE meme_submission
DROP FOREIGN KEY meme_submission_ibfk_1;

ALTER TABLE meme_submission
ADD CONSTRAINT fk_submission_user
FOREIGN KEY (user_id) REFERENCES users(id)
ON DELETE CASCADE;

ALTER TABLE meme_submission
DROP FOREIGN KEY fk_submission_user;

ALTER TABLE meme_submission
ADD CONSTRAINT fk_submission_user
FOREIGN KEY (user_id) REFERENCES users(id)
ON DELETE CASCADE;
SELECT
    CONSTRAINT_NAME,
    TABLE_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM
    information_schema.KEY_COLUMN_USAGE
WHERE
    TABLE_NAME = 'meme_submission'
    AND COLUMN_NAME = 'user_id'
    AND REFERENCED_TABLE_NAME IS NOT NULL;
ALTER TABLE meme_submission
DROP FOREIGN KEY fk_submission_user;
ALTER TABLE meme_submission
ADD CONSTRAINT fk_submission_user
FOREIGN KEY (user_id) REFERENCES users(id)
ON DELETE CASCADE;

ALTER TABLE MEME
ADD COLUMN is_approved BOOLEAN NOT NULL DEFAULT 0;


CREATE TABLE MEME (
    meme_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    origin_platform VARCHAR(50),
    first_appearance DATE,
    description TEXT,
    reference_description TEXT,
    platform VARCHAR(50),
    engagement_metrics INT,
    peak_popularity INT
);

CREATE TABLE MEME_VARIATION (
    variation_id INT,
    meme_id INT,
    variation_type VARCHAR(100),
    date DATE,
    platform VARCHAR(50),
    PRIMARY KEY (meme_id, variation_id),
    FOREIGN KEY (meme_id) REFERENCES MEME(meme_id) ON DELETE CASCADE
);
INSERT INTO MEME (
    name,
    origin_platform,
    first_appearance,
    description,
    reference_description,
    platform,
    engagement_metrics,
    peak_popularity
) VALUES (
    'Chopped Chin',
    'Instagram',
    '2024-08-06',
    'A viral meme featuring Renee Montgomery and her adopted son Angel Wiley dancing courtside at an Atlanta Dream game. The meme rose to prominence after an emotional remix by Instagram user @halal_man_2 using the song "Bring Me Back (Enox Mantano Remix)" by Miles Away. The term "Chopped Chin" refers to Wiley''s facial appearance in the meme.',
    '@halal_man_2 was the original meme uploader, but the account is currently inaccessible. The meme is derived from a 2023 Atlanta Dream courtside clip.',
    'TikTok',
    1500000,
    2500000
);
ALTER TABLE MEME
DROP COLUMN engagement_metrics;
ALTER TABLE MEME
DROP COLUMN platform,
DROP COLUMN reference_description;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


SELECT table_schema, table_name 
FROM information_schema.tables 
WHERE table_name IN ('MEME', 'MEME_VARIATION');
CREATE DATABASE meme_wiki;
