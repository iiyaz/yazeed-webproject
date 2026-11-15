-- Create Database


-- Table 1: Student Profile Info (Home & About Me)
CREATE TABLE IF NOT EXISTS profile_info (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    job_title VARCHAR(100) NOT NULL,
    welcome_msg TEXT NOT NULL,
    about_text TEXT NOT NULL,
    email VARCHAR(100) NOT NULL,
    university VARCHAR(100) NOT NULL
);

-- Table 2: Skills
CREATE TABLE IF NOT EXISTS skills (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    skill_name VARCHAR(100) NOT NULL,
    skill_level VARCHAR(50) NOT NULL
);

-- Table 3: Projects
CREATE TABLE IF NOT EXISTS projects (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    category VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    tech_used VARCHAR(150) NOT NULL
);

-- Table 4: Contact Messages (Contact Form)
CREATE TABLE IF NOT EXISTS messages (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    sender_name VARCHAR(100) NOT NULL,
    sender_email VARCHAR(100) NOT NULL,
    message_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Sample Data for Yazeed Mohammad
INSERT INTO profile_info (full_name, job_title, welcome_msg, about_text, email, university) VALUES
('Yazeed Mohammad', 'Software Engineering Student', 'Welcome to my personal portfolio! Explore my skills, projects, and academic journey.', 'I am a Software Engineering student at the University of Ha\'il passionate about web development, database systems, and software quality assurance.', 'yazeed.m@example.com', 'University of Ha\'il');

INSERT INTO skills (skill_name, skill_level) VALUES
('HTML5 & CSS3', 'Advanced'),
('JavaScript (DOM & Events)', 'Intermediate'),
('PHP & MySQL', 'Intermediate'),
('Software Testing (JUnit)', 'Advanced'),
('Database Design (SQL)', 'Intermediate');

INSERT INTO projects (title, category, description, tech_used) VALUES
('Personal Portfolio Website', 'Web', 'A responsive dynamic portfolio website connected to MySQL using PHP and styled with CSS.', 'HTML, CSS, JS, PHP, MySQL'),
('University Course Registration Testing', 'Testing', 'Automated unit testing and black-box/white-box test suites for UCRS.', 'Java, JUnit 5, JaCoCo'),
('Online Store XML Catalogue', 'Web', 'Structured product catalogue validated using custom DTD rules.', 'XML, DTD');
