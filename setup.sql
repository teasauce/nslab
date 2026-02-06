-- 1. Blow everything away so we start fresh
DROP TABLE IF EXISTS articles;
DROP TABLE IF EXISTS professors;

-- 2. Create tables with the 'content' column included
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    content TEXT
);

CREATE TABLE professors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    photo VARCHAR(255),
    bio TEXT 
);

-- 3. Seed data
INSERT INTO articles (title, date, content) VALUES 
('Innovative AI Techniques in Education', '2026-01-09', 'Exploring how AI transforms classrooms.'),
('Advances in Quantum Computing', '2026-01-06', 'A look into the next generation of processing.');

INSERT INTO professors (name, photo, bio) VALUES 
(
    'Dr. Jumadi M. Parenreng, S.Pd., M.Pd.', 
    '../../assets/images/jumadi.jpg', 
    'Dr. Jumadi M. Parenreng is a lecturer and researcher focusing on education, instructional technology, and curriculum development.'
);
