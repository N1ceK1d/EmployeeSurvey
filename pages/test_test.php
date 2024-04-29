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

    <form class="question-item col-lg-5 w-75 mt-2 mx-auto border rounded shadow-sm" method="GET">
        <div class='header bg-primary text-light p-1'>
            <h4>Что больше всего мотивирует вас к работе в компании?</h4>
            <p>Выберите <?php echo $result['max_answers'] ?> ответов</p>
        </div>

        <input type="hidden" class="max_answers" value='<?php echo $result['max_answers']; ?>' >
        <div class="answers p-1">
            <?php foreach ($answers as $row) :?>  
                <div class="answer-item">
                    <input class="form-check-input radio_inp" type="checkbox" name='answer[]' value="<?php echo $row['id']; ?>"/>
                    <label class='lead'><?php echo $row['anser_text']; ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
        <div class="btn-submit text-center p-1">
            <input class="btn btn-success btn-lg next_btn" type="submit" value="Закончить тест" data-bs-toggle="modal" data-bs-target="#exampleModal" disabled='true'>
        </div>
    </form>
    <!-- Модальное окно для отображения выбранных элементов и их приоритетов -->
    <div class="modal fade" id="priorityModal" tabindex="-1" role="dialog" aria-labelledby="priorityModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="priorityModalLabel">Приоритеты выбранных элементов</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul id="selectedItemsList"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" id="savePrioritiesBtn">Сохранить приоритеты</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateSelectedItemsList() {
            var selectedItemsList = document.getElementById('selectedItemsList');
            selectedItemsList.innerHTML = ''; // Очищаем список перед добавлением новых элементов

            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var selectedItems = [];

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    var label = checkbox.parentNode.querySelector('label').innerText;
                    var priority = parseInt(checkbox.getAttribute('data-priority'));
                    selectedItems.push({label: label, priority: priority});
                }
            });

            // Сортируем выбранные элементы по приоритету
            selectedItems.sort(function(a, b) {
                return a.priority - b.priority;
            });

            // Добавляем отсортированные элементы в список
            selectedItems.forEach(function(item) {
                var listItem = document.createElement('li');
                listItem.textContent = item.label;
                selectedItemsList.appendChild(listItem);
            });
        }

        function checkCheckboxLimit(event) {
            var maxAllowed = parseInt($('.max_answers').val()); // Максимальное количество ответов
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var checkedCount = 0;

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkedCount++;
                }
            });

            // Проверка на превышение максимального количества ответов
            if (checkedCount >= maxAllowed) {
                checkboxes.forEach(function(checkbox) {
                    if (!checkbox.checked) {
                        checkbox.disabled = true;
                    }
                });
                document.querySelector('.finish_btn').disabled = false;
            } else if (checkedCount > 0) { // Проверка на выбор хотя бы одного ответа
                checkboxes.forEach(function(checkbox) {
                    checkbox.disabled = false;
                });
                document.querySelector('.finish_btn').disabled = false;
            } else { // Ни один ответ не выбран
                checkboxes.forEach(function(checkbox) {
                    checkbox.disabled = false;
                });
                document.querySelector('.finish_btn').disabled = true;
            }

            updateSelectedItemsList(); // Обновляем список выбранных элементов
        }

        // Добавление обработчика события для каждого флажка
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', checkCheckboxLimit);
        });

        // Обработчик события для кнопки "Сохранить приоритеты"
        document.getElementById('savePrioritiesBtn').addEventListener('click', function() {
            // TODO: Реализация сохранения приоритетов выбранных элементов
            alert('Приоритеты сохранены');
            // Закрываем модальное окно
            $('#priorityModal').modal('hide');
        });
    </script>
    
    </div>
</body>
</html>