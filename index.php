<?php
include 'db_connect.php';

// Handle Contact Form Submission (Lab 7 & Lab 8 concepts)
$contact_feedback = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact'])) {
    $sender_name = htmlspecialchars(strip_tags($_POST['name']));
    $sender_email = htmlspecialchars(strip_tags($_POST['email']));
    $message_text = htmlspecialchars(strip_tags($_POST['message']));

    if (empty($sender_name) || empty($sender_email) || empty($message_text)) {
        $contact_feedback = "<p class='error-msg'>Please fill in all fields.</p>";
    } elseif (!filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
        $contact_feedback = "<p class='error-msg'>Invalid email format.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO messages (sender_name, sender_email, message_text) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $sender_name, $sender_email, $message_text);
        if ($stmt->execute()) {
            $contact_feedback = "<p class='success-msg'>Thank you, $sender_name! Your message has been saved.</p>";
        } else {
            $contact_feedback = "<p class='error-msg'>Error saving message: " . $conn->error . "</p>";
        }
        $stmt->close();
    }
}

// Fetch Profile Info
$profile_sql = "SELECT * FROM profile_info LIMIT 1";
$profile_result = $conn->query($profile_sql);
$profile = ($profile_result && $profile_result->num_rows > 0) ? $profile_result->fetch_assoc() : [
    'full_name' => 'Yazeed Mohammad',
    'job_title' => 'Software Engineering Student',
    'welcome_msg' => 'Welcome to my personal portfolio!',
    'about_text' => 'Student at University of Ha\'il.',
    'email' => 'student@uoh.edu.sa',
    'university' => 'University of Ha\'il'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profile['full_name']); ?> - Portfolio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo"><?php echo htmlspecialchars($profile['full_name']); ?></div>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About Me</a></li>
            <li><a href="#skills">Skills</a></li>
            <li><a href="#projects">Projects</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <button id="themeToggle" class="theme-btn" onclick="toggleDarkMode()">Dark Mode</button>
    </nav>

    <!-- Home / Welcome Section -->
    <header id="home" class="hero-section">
        <div class="container">
            <h1>Hello, I'm <span><?php echo htmlspecialchars($profile['full_name']); ?></span></h1>
            <h3><?php echo htmlspecialchars($profile['job_title']); ?> | <?php echo htmlspecialchars($profile['university']); ?></h3>
            <p><?php echo htmlspecialchars($profile['welcome_msg']); ?></p>
            <a href="#projects" class="btn">View My Projects</a>
        </div>
    </header>

    <!-- About Me Section -->
    <section id="about" class="section">
        <div class="container">
            <h2 class="section-title">About Me</h2>
            <div class="about-card">
                <p><?php echo htmlspecialchars($profile['about_text']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($profile['email']); ?></p>
            </div>
        </div>
    </section>

    <!-- Skills Section (Loaded dynamically from MySQL) -->
    <section id="skills" class="section bg-alt">
        <div class="container">
            <h2 class="section-title">My Skills</h2>
            <div class="grid-container">
                <?php
                $skills_sql = "SELECT skill_name, skill_level FROM skills";
                $skills_result = $conn->query($skills_sql);
                if ($skills_result && $skills_result->num_rows > 0) {
                    while ($row = $skills_result->fetch_assoc()) {
                        echo "<div class='card skill-card'>";
                        echo "<h3>" . htmlspecialchars($row['skill_name']) . "</h3>";
                        echo "<span class='badge'>" . htmlspecialchars($row['skill_level']) . "</span>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No skills found in database.</p>";
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Projects Section (Loaded dynamically from MySQL + JS Filter) -->
    <section id="projects" class="section">
        <div class="container">
            <h2 class="section-title">My Projects</h2>
            
            <!-- JavaScript Filter Buttons -->
            <div class="filter-buttons">
                <button class="filter-btn active" onclick="filterProjects('all', this)">All</button>
                <button class="filter-btn" onclick="filterProjects('Web', this)">Web</button>
                <button class="filter-btn" onclick="filterProjects('Testing', this)">Testing</button>
            </div>

            <div class="grid-container" id="projectsContainer">
                <?php
                $projects_sql = "SELECT title, category, description, tech_used FROM projects";
                $projects_result = $conn->query($projects_sql);
                if ($projects_result && $projects_result->num_rows > 0) {
                    while ($proj = $projects_result->fetch_assoc()) {
                        $cat = htmlspecialchars($proj['category']);
                        echo "<div class='card project-card' data-category='$cat'>";
                        echo "<span class='category-tag'>$cat</span>";
                        echo "<h3>" . htmlspecialchars($proj['title']) . "</h3>";
                        echo "<p>" . htmlspecialchars($proj['description']) . "</p>";
                        echo "<p class='tech-stack'><strong>Technologies:</strong> " . htmlspecialchars($proj['tech_used']) . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No projects found in database.</p>";
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section id="contact" class="section bg-alt">
        <div class="container">
            <h2 class="section-title">Contact Me</h2>
            <?php echo $contact_feedback; ?>
            <form name="contactForm" action="index.php#contact" method="post" onsubmit="return validateContactForm()" class="contact-form">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your name">

                <label for="email">Email Address:</label>
                <input type="text" id="email" name="email" placeholder="Enter your email">

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" placeholder="Write your message here..."></textarea>

                <button type="submit" name="submit_contact" class="btn">Send Message</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 <?php echo htmlspecialchars($profile['full_name']); ?> - University of Ha'il</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
<?php $conn->close(); ?>
