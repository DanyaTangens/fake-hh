#Простой фреймворк на php с применением паттерна MVC и ООП
Запускалось все на OpenServer
[Настройки OpenServer](https://prnt.sc/uva9t3)
---
# **Создание и подключение БД**
В корневом каталоге лежит файл fakehh_db.sql, нужно выполнить экспорт в phpMyAdmin, до этого создав БД с именем fakehh

При успешном создании БД переходим в каталог проекта "fake-hh>application>config>db.php" и меняем на свое

```
<?php

return [
	'host' => 'localhost',
	'name' => 'fakehh',
	'user' => 'root',
	'password' => 'root',
];
```
---
# Уже имеются два пользователя

1. Первый
  1. login: user
  1. password: 123
2. Второй
  2. login: user1
  2. password: 123
	
# Панель администратора
## В нее можно попасть прописав в адресной строке fake-hh/admin/login

логин и пароль можно заменить в файле по пути "fake-hh>application>config>admin.php"
```
<?php
return [
	'login' => 'admin',
	'password' => '12345',
];
```