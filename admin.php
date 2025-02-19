<!DOCTYPE html>
<html>
<head>
  <title>VillageHub Admin Panel</title>
  <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
  <header>
    <img src="logo.ico" alt="VillageHub logo">
    <a href="home.php" style="float: right; margin-top: 10px; margin-right: 10px;">Home</a>
    <h1>Admin Panel</h1>
  </header>
  <main>
    <label for="statusFilter">Filter by Status:</label><br>
    <input type="checkbox" id="uploaded" name="status" value="UPLOADED" onchange="filterTable()"> Uploaded<br>
    <input type="checkbox" id="sarpanch_viewed" name="status" value="SARPANCH VIEWED" onchange="filterTable()"> Sarpanch Viewed<br>
    <input type="checkbox" id="department_took_case" name="status" value="Dept took case" onchange="filterTable()"> Department Took Case<br>
    <input type="checkbox" id="department_handling_case" name="status" value="Dept handling case" onchange="filterTable()"> Department Handling Case<br>
    <input type="checkbox" id="Completed" name="status" value="COMPLETED" onchange="filterTable()"> Completed<br>

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
      session_start();
      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Fetch all issues from the database
      $sql = "SELECT * FROM issues";
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
                <a href="javascript:void(0)" onclick="showIssueDetails(<?= $id ?>)">View</a> |
                <a href="javascript:void(0)" onclick="removeIssue(<?= $id ?>)">Remove</a> |
                <!-- <form onsubmit="return addComment(<?= $id ?>)"> -->
                <!-- <form onsubmit="return addComment(<?= $id ?>, this.comment.value)" autocomplete="off">
    <input type="text" name="comment" placeholder="Enter your comment">
    <input type="submit" value="Add Comment">
</form> -->

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
    <script>
function filterTable() {
      var checkboxes = document.querySelectorAll('input[name="status"]:checked');
      var statuses = Array.from(checkboxes).map(function (checkbox) {
        return checkbox.value;
      });

      var rows = document.querySelectorAll('.issue-row');
      rows.forEach(function (row) {
        var status = row.getAttribute('data-status');
        if (statuses.includes(status) || statuses.length === 0) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    }

      function showIssueDetails(issueId) {
        var iframe = document.getElementById("issueDetails");
        iframe.src = "issue_details.php?id=" + issueId;
        iframe.style.display = "block";
      }

      function removeIssue(issueId) {
    if (confirm("Are you sure you want to remove this issue?")) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Reload the page after successful deletion
                    location.reload();
                } else {
                    console.error("Error removing issue: " + xhr.statusText);
                }
            }
        };
        xhr.open("GET", "remove_issue.php?id=" + issueId, true);
        xhr.send();
    }
}



//       function addComment(issueId, comment) {
//     var xhr = new XMLHttpRequest();
//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === 4) {
//             if (xhr.status === 200) {
//                 // Comment added successfully, you can handle the response here
//                 alert("Comment added successfully");
//             } else {
//                 // Error adding comment, you can handle the error here
//                 console.error("Error adding comment: " + xhr.statusText);
//             }
//         }
//     };
//     xhr.open("POST", "add_comment.php", true);
//     xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     xhr.send("issue_id=" + issueId + "&comment=" + encodeURIComponent(comment));

//     return false; // Prevent form submission
// }





    </script>
  </main>
  <footer>
    <p>Contact Us: <a href="mailto:admin@villagehub.com">admin@villagehub.com</a></p>
    <p>For more information and support, please visit our <a href="support.html">Support Center</a>.</p>
  </footer>
</body>
</html>
