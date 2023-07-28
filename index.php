<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Книга контактов</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.maskedinput.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        require_once 'DB.php';
    ?>
    <div class="container">
        <div class="title">Добавить контакт</div>
        <form id="add" class="add">
            <input class="text_input" type="text" name="name" id="name" placeholder="Имя">
            <input class="text_input" type="tel" name="phone" id="phone" placeholder="Телефон">
            <input type="submit" value="Добавить" class="submit">
        </form>
        <div id="message"></div>
    </div>
    <script>
        $("#add").on("submit", function(event){
            event.preventDefault();
            $.ajax({
                url: '/add.php',
                method: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                success: function(data) {
                    console.log(data);
                    if (data.type !== "yes") {
                        $('#message').html(data.message);
                    } else {
                        location.reload();
                    }
                },
                error: function (err){
                    console.log(err);
                    $('#message').html("Ошибка: непредвиденная ошибка!");
                }
            });
        });
    </script>
    <div class="container">
        <div class="title">Список контактов</div>
            <?php
            if (isset($pdo)){
                $sth = $pdo->prepare("SELECT * FROM `phone_book`");
                $sth->execute();
                $res = $sth->fetchAll(PDO::FETCH_ASSOC);

                foreach ($res as $contact){
                    echo '<div class="contact">
                    <div class="name">' . $contact['name'] . '
                    <img src="img/cross.svg" onclick="$.get(\'/delete.php\', 
                        {delete: \'' . $contact['id'] . '\'},
                        function (data){
                            if (data.type == \'yes\'){
                                location.reload();
                            } else {
                                console.log(data);
                            }
                        }, 
                        \'json\')" alt>
                    </div>
                    <div class="phone">' . $contact['phone'] . '
                    </div>
                </div>';
                }
            } else {
                echo '<div class="contact">
                    <div class="name">ОШИБКА!</div>
                    <div class="phone">Нет связи с базой данных</div>
                </div>';
            }

            ?>
    </div>
    <script>
        $(function(){
            $("#phone").mask("+7 (999) 999-99-99", {placeholder: " " });
        });
    </script>
</body>
</html>