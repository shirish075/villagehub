<!DOCTYPE html>
<html>
<head>
  <title>VillageHub - Check Issue Status</title>
  <link rel="stylesheet" type="text/css" href="admin.css">
  <?php session_start();
  $isAdmin = isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] === true;
  ?>

  <script>
    function showIssueDetails(issueId) {
      var isAdmin = <?php echo $isAdmin ? 'true' : 'false'; ?>;
      var iframe = document.getElementById("issueDetails");
      iframe.src = "issue_details.php?id=" + issueId + "&isAdmin=" + isAdmin;
      iframe.style.display = "block";
    }
  </script>
</head>
<body>
  <header>
  <div class="logo-container">
      <!-- <a href="home.php" style="float: right; margin-top: 10px; margin-right: 10px;">Home -->
        <img src="logo.ico" alt="VillageHub logo">
        <a href="home.php" style="float: right; margin-top: 10px; margin-right: 10px;"><h1>VillageHub</h1></a>
    </div>
    <h1>Check Issue Status</h1>
  </header>
  <main>
    <table id="issueTable">
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Category</th>
          <th>Photo</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "villagehub";
      
      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Fetch issues uploaded by the current user from the database
      $user_id = $_SESSION['user_id'];
      $sql = "SELECT * FROM issues WHERE user_id = $user_id";

      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $id = $row["id"];
          $title = htmlspecialchars($row["title"]);
          $description = htmlspecialchars($row["description"]);
          $category = htmlspecialchars($row["category"]);
          $photo = htmlspecialchars($row["photo"]);
          $status = htmlspecialchars($row["STATUS"]);
      ?>
            <tr class="issue-row" data-status="<?= $status ?>">
              <td><?= $title ?></td>
              <td><?= $description ?></td>
              <td><?= $category ?></td>
              <td><img src="<?= $photo ?>" alt="Issue Photo" style="max-width: 100px; max-height: 100px;"></td>
              <td><?= $status ?></td>
              <td>
                <a href="javascript:void(0)" onclick="showIssueDetails(<?= $id ?>)">View</a>
            </td>
            </tr>
      <?php
        }
      } else {
      ?>
          <tr>
            <td colspan="6">No issues found</td>
          </tr>
      <?php
      }
      ?>
      </tbody>
    </table>
    <iframe id="issueDetails" style="display: none; border: none; width: 100%; height: 500px;"></iframe>
  </main>
  <footer>
    <p>Contact Us: <a href="mailto:admin@villagehub.com">admin@villagehub.com</a></p>
    <p>For more information and support, please visit our <a href="support.html">Support Center</a>.</p>
  </footer>
</body>
</html>
