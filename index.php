<?php
/*
* сайт gosusluga
* дата 25.10.2019
*/
session_start();

//установка временной зоны
date_default_timezone_set("Asia/Almaty");

// Выключение протоколирования ошибок
error_reporting(0);

// Включать в отчет простые описания ошибок
error_reporting(E_ERROR | E_PARSE);

/* подключаем базу данных */
include "db.php";

//подключаем переменные, сессии и переменные авторизации
include "var.php";

//подключаем логику движка
include "engine.php";

/* закрываем базу данных */
include "dbclose.php";
?>