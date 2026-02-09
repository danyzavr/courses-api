`# API Документация

## 1️⃣ Заявки

Базовый маршрут: api/applications

1. Создание заявки

Метод: POST
Маршрут: /applications
Описание: Создает новую заявку на курс.

Параметры запроса (body JSON):

Поле Тип Обязательное Правила валидации Пример
course_id string Да UUID, существует в courses    "019c..."
first_name string Да max:255    "Иван"
last_name string Да max:255    "Иванов"
middle_name string Да max:255    "Иванович"
email string Да email, max:255    "ivan@example.com"

Успешный ответ: 200 OK

{
"status": true,
"statusCode": 200,
"timestamp": 1700000000,
"message": "Заявка успешно создана",
"data": {
"id": "uuid-заявки",
"course_id": "uuid-курса",
"first_name": "Иван",
"last_name": "Иванов",
"middle_name": "Иванович",
"email": "ivan@example.com",
"created_at": "2026-02-09T00:00:00Z",
"updated_at": "2026-02-09T00:00:00Z"
}
}

Ошибки валидации (400 Bad Request)
Пример:

{
"status": false,
"statusCode": 400,
"timestamp": 1700000000,
"message": "Validation failed",
"data": null,
"errors": {
"email": ["The email must be a valid email address."]
},
"errorCode": "VALIDATION_FAILED"
}

2. Удаление заявки

Метод: DELETE
Маршрут: /applications
Описание: Удаляет заявку по id.

Параметры запроса (body JSON):

Поле Тип Обязательное Правила валидации
id string Да UUID, существует в applications

Успешный ответ: 200 OK

{
"status": true,
"statusCode": 200,
"timestamp": 1700000000,
"message": "Заявка успешно удалена",
"data": null
}

Ошибки валидации (400 Bad Request)
Пример:

{
"status": false,
"statusCode": 400,
"timestamp": 1700000000,
"message": "Validation failed",
"data": null,
"errors": {
"id": ["The selected id is invalid."]
},
"errorCode": "VALIDATION_FAILED"
}

3. Получение списка заявок

Метод: GET
Маршрут: /applications
Описание: Возвращает список заявок, можно фильтровать и сортировать.

Параметры запроса (query params):

Поле Тип Обязательное Правила Пример
email string Нет email ivan@example.com
course_id string Нет UUID, существует в courses    "019c..."
sort string Нет first_name, last_name, email, created_at created_at
order string Нет asc или desc desc
page integer Нет min:1 1
per_page integer Нет min:1, max:100 20

Успешный ответ (пагинация)

{
"status": true,
"statusCode": 200,
"timestamp": 1700000000,
"message": "OK",
"data": [
{
"id": "uuid-заявки",
"course_id": "uuid-курса",
"first_name": "Иван",
"last_name": "Иванов",
"middle_name": "Иванович",
"email": "ivan@example.com",
"created_at": "2026-02-09T00:00:00Z",
"updated_at": "2026-02-09T00:00:00Z"
}
],
"pagination": {
"meta": {
"page": {
"current": 1,
"first": 1,
"last": 5,
"next": 2,
"previous": null,
"per": 20,
"from": 1,
"to": 20,
"count": 20,
"total": 100,
"isFirst": true,
"isLast": false,
"isNext": true,
"isPrevious": false
}
}
}
}

Если заявки не найдены (404 Not Found)

{
"status": false,
"statusCode": 404,
"timestamp": 1700000000,
"message": "Заявки не найдены",
"data": null,
"errors": [],
"errorCode": "RESOURCE_NOT_FOUND"
}

`
