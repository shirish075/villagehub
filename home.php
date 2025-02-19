<!DOCTYPE html>
<html>
<head>
  <title>VillageHub</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<style>
  /* Reset default margin and padding */
body, h1, ul, li, img {
  margin: 0;
  padding: 0;
}

/* Basic styles for header */
header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 20px;
  background-color: #f1f1f1;
}

.logo {
  max-height: 50px;
}

/* Main content container */
.header-content {
  margin-left: 20px; /* Adjust as needed */
}

/* Styles for features list */
.features-list {
  list-style-type: none;
  padding: 0;
}

/* Styles for feature items */
.feature-item {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

/* Styles for feature images */
.feature-image {
  max-height: 50px;
  margin-right: 20px;
}

/* Styles for feature details */
.feature-details {
  /* Add styles as needed */
}

/* Styles for feature titles */
.feature-title {
  /* Add styles as needed */
}

/* Styles for feature descriptions */
.feature-description {
  /* Add styles as needed */
}

  </style>
<body>
  <header>
    <div class="logo-container">
        <img src="logo.ico" alt="VillageHub logo">
        <h1>VillageHub</h1>
    </div>
    <nav>
    <ul>
    <?php
        session_start();

        if ($_SESSION["admin_logged_in"] === false) {
          
        echo '<li><a href="issuereport.html">Issue Reporting</a></li>';
        echo '<li><a href="issue_tracking.php">Issue Tracking</a></li>';
       
            echo "<li>Welcome, " . $_SESSION["user_name"] . "</li>";
            echo '<li><a href="logout.php">Logout</a></li>'; // Logout link
        } 
        elseif($_SESSION["admin_logged_in"] === true){
          echo "<li>Welcome, " . $_SESSION["admin_name"] . "</li>";
          echo "<li><a href=\"admin.php\">Admin panel</a></li>";
          echo '<li><a href="logout.php">Logout</a></li>'; // Logout link

        }
        else {
            echo '<li><a href="login.html">Login</a></li>';
        }
        ?>
    </ul>
</nav>


  
</header>

<section class="hero">
  <img src="resizedbg.jpg" alt="Rural community" class="hero-image" style="filter: brightness(110%); opacity: 0.7;">
  <div class="hero-content">
      <h1 style="background-color: #ccc; color: #333; padding: 2px 5px; border-radius: 5px;">Empowering Rural Communities</h1>
      <p style="background-color: #ccc; color: #333; padding: 2px 5px; border-radius: 5px;">VillageHub is a platform that makes it easy for residents to report issues and for admins to track and resolve them.</p>
  </div>
</section>

  <section class="features">
    <h2>Key Features</h2>
    <ul class="features-list">
    <li class="feature-item">
      <img src="issuereport.png" alt="Easy Issue Reporting" class="feature-image">
      <div class="feature-details">
        <h2 class="feature-title">Easy Issue Reporting</h2>
        <p class="feature-description">Residents can quickly and easily report issues through the VillageHub website or mobile app.</p>
      </div>
    </li>
    <li class="feature-item">
      <img src="ttracking.jpg" alt="Transparent Tracking" class="feature-image">
      <div class="feature-details">
        <h2 class="feature-title">Transparent Tracking</h2>
        <p class="feature-description">Issues are tracked and updated in real-time, allowing residents to see the status of their reported issues.</p>
      </div>
    </li>
    <li class="feature-item">
      <img src="community.png" alt="Community Engagement" class="feature-image">
      <div class="feature-details">
        <h2 class="feature-title">Community Engagement</h2>
        <p class="feature-description">VillageHub fosters a sense of community and encourages residents to work together to resolve issues.</p>
      </div>
    </li>
  </ul>
  </section>
  <section class="how-it-works">
    <h2>How It Works</h2>
    <ol>
      <li>Residents report issues through the VillageHub website or mobile app.</li>
      <li>Admin staff review and assign issues to the appropriate team or individual for resolution.</li>
      <li>Issues are tracked and updated in real-time, allowing residents to see the status of their reported issues.</li>
      <li>Issues are resolved and closed, with feedback provided to residents to ensure their concerns have been addressed.</li>
    </ol>
  </section>
  <section class="cta">
    <a href="issuereport.html" class="button">Report an Issue</a>
  </section>
  <section class="testimonials">
    <h2>Testimonials</h2>
    <blockquote>
      <p>VillageHub has made it so easy for me to report issues in my community. I love being able to see the status of my reported issues in real-time.</p>
      <cite>- Jane Doe, Resident</cite>
    </blockquote>
    <blockquote>
      <p>As an admin, VillageHub has been a game-changer for our community. We can now track and resolve issues more efficiently than ever before.</p>
      <cite>- John Smith, Admin</cite>
    </blockquote>
  </section>
  <footer>
    <p>Contact Us: <a href="mailto:info@villagehub.com">info@villagehub.com</a></p>
    <p>Follow us on social media:</p>
    <ul>
      <li><a href="#">Facebook</a></li>
      <li><a href="#">Twitter</a></li>
      <li><a href="#">Instagram</a></li>
    </ul>
  </footer>
</body>
</html>