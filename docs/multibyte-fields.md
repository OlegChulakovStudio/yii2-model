# Текстовые поля с мультибайтовой валидацией

Если требуется возможность сохранять расширенный список символов, например `utf8mb4`,
то данная кодировка применяется непосредственно к полям, требующим возможность
сохранения более широкого диапазона символов.

В этой ситуации необходимо настроить подключение к базе данных с указанием
соответствующей кодировки и при добавлении такого поля указать:

```
// Конфигурация @common/config/main-local.php
'db' => [
    ...
    'charset' => 'utf8mb4'
]

// Кодировка поля при создании таблицы
$this->createTable('{{%table}}', [
    ...
    'comment' => $this->string(191)->notNull()->append('COLLATE utf8mb4_unicode_ci'),
    ...
]);
```

> **ВАЖНО:**
> Для полей в кодировке `utf8mb4` имеется ограничение на размер индекса.
> Если требуется построить индекс по такому полю, то его длина не должна
> превышать **191** символ.

Если же текстовые поля не требуют возможности сохранять расширенный диапазон символов,
поля должны быть отфильтованы непосредственно в форме добавления записи от всех
символов выходящих из разрешенного диапазона. Для этой цели в компоненте имеется
специальный фильтр-валидатор `ClearMultibyteValidator`, который очистит мультибайтовые
символы и проведет дополнительно `trim` фильтрацию текстового поля.

Валидатор следует использовать первым в списке правил валидации, чтобы после очистки
текстового поля была проведена корректная проверка на обязательность полей и прочих
валидаторов, например проверки длины строки, т.е. всего, что требует работы с уже
очищенной строкой.