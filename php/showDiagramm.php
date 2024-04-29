<?php 
function getUserResult($user_id, $username){?>
  <div class='diagramm-item m-1 border w-100'>
    <?php
    require('conn.php');

    $sql = "SELECT COUNT(Answers.id) as count, Answers.anser_text FROM UserAnswers
    INNER JOIN Answers ON UserAnswers.answer_id = Answers.id
    INNER JOIN Users ON UserAnswers.user_id = Users.id
    WHERE Users.id = $user_id
    GROUP BY Answers.anser_text";

    $res = $conn->query($sql);

    while($row = $res->fetch_assoc()) {
      $myArray[] = $row;
    }

    
    ?>
    <canvas id="myChart<?php echo $user_id ?>" style="max-width:1500px;height:500px"></canvas>
    <script src="../js/diagramm.js"></script>
    <?php
      $company_name = "SELECT * FROM Users
      INNER JOIN Companies ON Users.company_id = Companies.id 
      WHERE Users.id = $user_id";

      $name = mysqli_fetch_assoc($conn->query($company_name));

      $answers = $conn->query("SELECT * FROM Answers");
      while ($row = $answers->fetch_assoc()) {
        $answersArray[] = $row['anser_text'];
      }
    ?>
    <script>
      showDiagramm(<?php echo json_encode($myArray); ?>, <?php echo $user_id ?>, "<?php echo $username ?>", '<?php echo $name['name'] ?>', <?php echo json_encode($answersArray); ?>);
    </script>
  </div>
<?php } ?>


<?php 
function getAverageResult($company_id, $company_name){?>
  <div class='diagramm-item m-1 border w-100'>
    <?php
    require('conn.php');

    $sql = "SELECT 
    Answers.anser_text,
    ROUND((COUNT(UserAnswers.id) / (SELECT COUNT(*) FROM UserAnswers)) * 100, 2) AS percentage
    FROM 
        UserAnswers
    JOIN 
        Answers ON UserAnswers.answer_id = Answers.id
    JOIN
        Users ON UserAnswers.user_id = Users.id
    JOIN
        Companies ON Users.company_id = Companies.id
    WHERE 
    	Users.company_id = $company_id
    GROUP BY 
        Answers.id
    ORDER BY 
    percentage DESC;";

    $res = $conn->query($sql);

    while($row = $res->fetch_assoc()) {
      $myArray[] = $row;
    }

    $answers = $conn->query("SELECT * FROM Answers");
    while ($row = $answers->fetch_assoc()) {
      $answersArray[] = $row['anser_text'];
    }
    ?>
    <canvas id="myChart<?php echo $company_id ?>" style="max-width:1500px;height:500px"></canvas>
    <script src="../js/diagramm.js"></script>
    <script>
      console.log(<?php echo json_encode($myArray); ?>);
      showDiagramm(<?php echo json_encode($myArray); ?>, <?php echo $company_id ?>, '<?php echo $company_name; ?>', '<?php echo $company_name; ?>', <?php echo json_encode($answersArray); ?>);
    </script>
  </div>
<?php } ?>