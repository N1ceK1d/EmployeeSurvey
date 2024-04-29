<?php
    session_start();
    if(!isset($_SESSION['admin_id']))
    {
        header("Location: login.php");
    }
    require("../../php/conn.php");
    require("../../php/showDiagramm.php");
    $company_id = 0;
    if(isset($_GET['company_id']))
    {
        $company_id = $_GET['company_id'];
    }
    $user_type = 0;
    if(isset($_GET['user_type']))
    {
        $user_type = $_GET['user_type'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Работники</title>
    <link rel="icon" href="../../favicon.ico">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="../../js/jquery-3.7.1.min.js"></script>
    <script src="../../js/diagramm.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="../../js/getPDF.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="container p-1">
        <h1>Сотрудники</h1>
        <?php require("../../php/admin_header.php"); ?>
        <button class='pdf_export btn btn-primary'>Экспорт PDF</button>
        <form class="search form border w-25 p-2 m-auto text-center" action="" method="GET">
            <select name="company_id" class="form-select form-select-sm my-1 w-100" aria-label="Default select example">
                <option value="0" selected>Все компании</option>
                <?php
                    $companies = $conn->query("SELECT * FROM Companies;");
                    foreach ($companies as $row):?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                <?php endforeach ?>
            </select>
            <div class="types text-start">
                <div class="answer-item text-left">
                    <input class="form-check-input radio_inp" type="radio" name='user_type' value="0"/>
                    <label class='large'>Все</label>
                </div>
                <div class="answer-item">
                    <input class="form-check-input radio_inp" type="radio" name='user_type' value="1"/>
                    <label class='large'>Анонимные</label>
                </div>
                <div class="answer-item">
                    <input class="form-check-input radio_inp" type="radio" name='user_type' value="2"/>
                    <label class='large'>Не анонимные</label>
                </div>
            </div>
            
            <input type="submit" value="Найти" class="btn btn-primary my-1">
        </form>
        <div class="diagramms">
            <?php 
                if($company_id > 0)
                {
                    $sql = "SELECT *, Users.id as user_id,
                    CONCAT(Users.second_name, ' ', Users.first_name, ' ', Users.last_name) as fullname
                    FROM Users
                    INNER JOIN Companies ON Users.company_id = Companies.id
                    WHERE company_id = $company_id";
                    if($user_type > 0)
                    {
                        if($user_type == 1) 
                        {
                            $sql .= " AND is_anon = 1";
                        }
                        if($user_type == 2) 
                        {
                            $sql .= " AND is_anon = 0";
                        }
                    } 
                } else 
                {
                    $sql = "SELECT *, Users.id as user_id,
                    CONCAT(Users.second_name, ' ', Users.first_name, ' ', Users.last_name) as fullname
                    FROM Users
                    INNER JOIN Companies ON Users.company_id = Companies.id";
                    if($user_type > 0)
                    {
                        if($user_type == 1) 
                        {
                            $sql .= " WHERE is_anon = 1";
                        }
                        if($user_type == 2) 
                        {
                            $sql .= " WHERE is_anon = 0";
                        }
                    } 
                }
            ?>
            <?php foreach($users = $conn->query($sql) as $row):?>
                <div class="employee-item border my-1 w-75">
                    <div class="employee_header bg-primary text-white p-1">
                        <p class="name h3 mb-0"><?php echo $row['fullname']; ?></p>
                        <p class="lead"><?php echo $row['name']; ?></p>
                    </div>
                    <div class="employee-body p-1">
                        <?php
                            $answers = $conn->query("SELECT * FROM UserAnswers
                            INNER JOIN Answers ON UserAnswers.answer_id = Answers.id 
                            WHERE user_id = ".$row['user_id']);
                            foreach($answers as $answer):?>
                            <div class='border-bottom'>
                                <p class='mb-0'>
                                    <b><?php echo $answer['answer_priority']; ?></b>
                                    <?php echo $answer['anser_text']; ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php 
            $name = "Все компании";
            $company_name = $conn->query("SELECT * FROM Companies WHERE id = $company_id");
            
            if($company_name->num_rows > 0)
            {
                $name = mysqli_fetch_assoc($company_name)['name'];
            }
        ?>
    </div>
    
    <script>
        console.log('<?php echo $company_name->num_rows ?>');
        $('.pdf_export').on('click', () => {
            generatePDF2('<?php echo $name; ?>', 'PDF');
        })
    </script>
</body>
</html>