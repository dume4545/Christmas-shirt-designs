CREATE DATABASE IF NOT EXISTS frontrow CHARACTER SET utf8mb4;
USE frontrow;
CREATE TABLE admins(id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50) UNIQUE, password_hash VARCHAR(255));
CREATE TABLE posts(id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(200), slug VARCHAR(220) UNIQUE, category VARCHAR(40), excerpt VARCHAR(300), body MEDIUMTEXT, image_url VARCHAR(500) DEFAULT '', views INT DEFAULT 0, featured TINYINT(1) DEFAULT 0, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
INSERT INTO posts(title,slug,category,excerpt,body,featured) VALUES
('Welcome to The Front Row Africa','welcome-1','Culture','Sample story. Replace it from the admin panel with your first real headline.','This is a sample story.\n\nSign in at /admin.php to publish your own news, mark a story as featured, and delete these samples.',1),
('How to publish your first story','first-story-2','Tech','Sample story. Write a title, a short summary, then the body. A blank line starts a new paragraph.','Stories are plain text.\n\nAdd an image link if you have one. Without it, the story gets a colour block for its category.',0),
('A headline that earns the click','headline-3','Opinion','Sample story. Short, specific headlines read best on phones.','Keep summaries under two sentences.\n\nReaders scan first and read second.',0);
