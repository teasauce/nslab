CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL
);

-- Add some test data so you can see it working
INSERT INTO articles (title, date) VALUES 
('Innovative AI Techniques in Education', '2026-01-09'),
('Advances in Quantum Computing', '2026-01-06');
