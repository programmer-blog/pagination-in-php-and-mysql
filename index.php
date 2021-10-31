<?php
    use \App\
    { 
        Database,
        Functions,
        Pagination 
    };

    include_once('vendor/autoload.php');

    $dbObj = new Database();
    $db = $dbObj->db_connect();
    $utility = new Functions($dbObj);
    $total_count = $utility->count_users();
    $page = $_GET['page'] ?? 1;
    $pagination = new Pagination($total_count, $page, 20);
    $users = $utility->find_users($pagination->per_page, $pagination->offset());

?>

<!doctype html>

<html lang="en">
  <head>
    <title>User Listing</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>

    <h1>Users Listing - Pagination in PHP and MySQL </h1>

    <p class="page-status">
      Page <?php echo $pagination->current_page; ?> of <?php echo $pagination->total_pages(); ?>
    </p>

    <table id="customer-list">
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Date Added</th>
      </tr>

      <?php
        while($user = $dbObj->db_fetch_assoc($users)) {
          echo "<tr>";
          echo "<td>" . $utility->escape($user['first_name']) . "</td>";
          echo "<td>" . $utility->escape($user['last_name']) . "</td>";
          echo "<td>" . $utility->escape(Date('Y-m-d', strtotime($user['date_added']))) . "</td>";
          echo "</tr>";
        } // end while

        $dbObj->db_free_result($users);
      ?>
    </table>

    <?php echo $pagination->page_links('index.php'); ?>

  </body>
</html>

<?php if(isset($dbObj)) { $dbObj->db_close($db); } ?>
