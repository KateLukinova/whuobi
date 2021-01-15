<?php
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

/* Осуществляем проверку вводимых данных и их защиту от враждебных
скриптов */
$your_name = htmlspecialchars($_POST["your_name"]);
$email = htmlspecialchars($_POST["email"]);
$message = htmlspecialchars($_POST["messages"]);

/* Устанавливаем e-mail адресата */
$myemail = "feedback@tbccwallet.com";

/* Проверяем заполнены ли обязательные поля ввода, используя check_input
функцию */
$your_name = check_input($_POST["your_name"], "Введите ваше имя!");
$email = check_input($_POST["email"], "Введите ваш e-mail!");
$message = check_input($_POST["messages"], "Вы забыли написать сообщение!");
/* Проверяем правильно ли записан e-mail */
if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email))
{
    show_error("Е-mail адрес не существует");
}
/* Создаем новую переменную, присвоив ей значение */
$message_to_myemail = "Здравствуйте!
Вашей контактной формой было отправлено сообщение!
Имя отправителя: $your_name
E-mail: $email
Текст сообщения: $message
Конец";
/* Отправляем сообщение, используя mail() функцию */
$from  = "From: $your_name <$email> \r\n Reply-To: $email \r\n";
mail($myemail, $message_to_myemail, $from);

/* Если при заполнении формы были допущены ошибки сработает
следующий код: */
function check_input($data, $problem = "")
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($problem && strlen($data) == 0)
    {
        show_error($problem);
    }
    return $data;
}

function show_error($myError)
{
    echo $myError;
    exit();
}
?>
