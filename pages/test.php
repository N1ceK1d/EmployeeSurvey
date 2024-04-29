<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тест</title>
    <link rel="icon" href="../favicon.ico">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="help bg-light border w-50 mx-auto my-2 p-1">
            <p class='lead'>Выберите ответы в порядке приоритетности для вас <br>
            <b>(от самого приоритетного до менее приоритетного)</b></p>
        </div>
    <?php 
        require("../php/conn.php");
        session_start();

        $answers_sql = "SELECT * FROM Answers";
        $answers = $conn->query($answers_sql);

        $sql = "SELECT company_id FROM Users WHERE id = ". $_SESSION['user_id'];
        $company_id = mysqli_fetch_assoc($conn->query($sql))['company_id'];
        $sql = "SELECT * FROM Companies WHERE id = $company_id;";
        $result = mysqli_fetch_assoc($conn->query($sql));
    ?>

    <div class="selected_answers border w-100">
        <p class="h3 text-white bg-primary">Выбранные ответы</p>
        <div class="selected_list"></div>
        <form class="data-form" method="GET" action="../php/saveAnswer.php">
            <div class="selected-items"></div>
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
            <button type="submit" class="btn btn-primary submit_data m-1">Отправить</button>
        </form>
    </div>
    <div class="answers">
        <?php foreach ($answers as $row) :?>  
            <div role='button' class="answer border rounded p-1 bg-light w-25 m-1">
                <?php echo $row['anser_text']; ?>
                <input type="hidden" name="answer_id" value="<?php echo $row['id'] ?>" readonly/>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!--Modal start-->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Вариант теста</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="popup_answers">
                    <ul class='answers_list'></ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--Modal end-->
    <script src="../js/main.js"></script>
    <script>
        userAnswer(<?php echo $result['max_answers']; ?>);
    </script>
    </div>
</body>
</html>