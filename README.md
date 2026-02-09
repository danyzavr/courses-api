# Тестовое задание — courses-api

**Описание:** API для работы с заявками и курсами  

**Авторизация:** Bearer token `super-secret-token`

**Ограничение запросов** не более 10 за 1 сек по токену/ip 

**Валидация** входящих данных

**База данных** - в корне дамп courses_api_dump.sql Также приложены миграции и сидеры. 





## 1.Заявки
### Маршруты

| Метод  | URL                 | Действие | Описание                                           |
|--------|-------------------|----------|--------------------------------------------------|
| POST   | /api/applications | store    | Создание новой заявки                             |
| DELETE | /api/applications | delete   | Удаление заявки по id                             |
| GET    | /api/applications | get      | Получение списка заявок с фильтрацией и пагинацией |

### Структура ответа
- `status` — успех запроса (`true`/`false`)
- `statusCode` — HTTP код ответа
- `message` — сообщение
- `data` — данные (ресурс или коллекция ресурсов)
- `timestamp` — метка времени
- `errorCode` — код ошибки (если есть)
- `pagination` — пагинация
### Получение заявок (GET /api/applications)

**Query-параметры:**

- `email` — фильтр по email (необязательно)
- `course_id` — фильтр по курсу (UUID, необязательно)
- `sort` — поле для сортировки (`first_name`, `last_name`, `email`, `created_at`)
- `order` — порядок сортировки (`asc`, `desc`)
- `page` — номер страницы
- `per_page` — количество элементов на странице (макс. 100)

**Пример запроса:**

GET http://localhost:port/api/applications?course_id=uuid_курса&sort=created_at&order=desc&page=1&per_page=20

**Пример успешного ответа:**
```json
{
  "status": true,
  "statusCode": 200,
  "timestamp": 1676457600,
  "message": "OK",
  "data": [
    {
      "id": "uuid_заявки_1",
      "course_id": "uuid_курса",
      "first_name": "Иван",
      "last_name": "Иванов",
      "middle_name": "Иванович",
      "email": "ivan@example.com",
      "created_at": "2026-02-09T12:00:00Z"
    },
    {
      "id": "uuid_заявки_2",
      "course_id": "uuid_курса",
      "first_name": "Мария",
      "last_name": "Петрова",
      "middle_name": "Алексеевна",
      "email": "maria@example.com",
      "created_at": "2026-02-08T16:20:00Z"
    }
  ],
  "pagination": {
    "meta": {
      "page": {
        "current": 1,
        "first": 1,
        "last": 10,
        "next": 2,
        "previous": null,
        "per": 20,
        "from": 1,
        "to": 20,
        "count": 20,
        "total": 200,
        "isFirst": true,
        "isLast": false,
        "isNext": true,
        "isPrevious": false
      }
    }
  }
}
```

## Создание заявки (POST /api/applications)
**Параметры запроса**
- `course_id`: uuid_курса,
- `first_name`: "Иван",
- `last_name`: "Иванов",
- `middle_name`: "Иванович",
- `email`: "ivan@example.com"

**Пример запроса**
POST http://localhost:port/api/applications
```json
{
  "course_id": "uuid_курса",
  "first_name": "Иван",
  "last_name": "Иванов",
  "middle_name": "Иванович",
  "email": "ivan@example.com"
}
```
**Пример успешного ответа:**
```json
{
  "status": true,
  "statusCode": 200,
  "timestamp": 1676457600,
  "message": "Заявка успешно создана",
  "data": {
    "id": "uuid_заявки",
    "course_id": "uuid_курса",
    "first_name": "Иван",
    "last_name": "Иванов",
    "middle_name": "Иванович",
    "email": "ivan@example.com",
    "created_at": "2026-02-09T12:00:00Z"
  }
}
```
## Удаление заявки (DELETE /api/applications)
**Параметры запроса (JSON body):**

- `id` — UUID заявки, обязательный

**Пример запроса:**
DELETE http://localhost:port/api/applications?id=uuid_заявки

```json
{
  "id": "uuid_заявки"
}
```

**Пример успешного ответа:**

```json
{
  "status": true,
  "statusCode": 200,
  "timestamp": 1676457600,
  "message": "Заявка успешно удалена",
  "data": null
}
```

## 2. Курсы

### Маршруты

| Метод  | URL                 | Действие | Описание                                           |
|--------|-------------------|----------|--------------------------------------------------|
| GET    | /api/courses | get      | Получение списка курсов с фильтрацией и пагинацией |

### Структура ответа
- `status` — успех запроса (`true`/`false`)
- `statusCode` — HTTP код ответа
- `message` — сообщение
- `data` — данные (ресурс или коллекция ресурсов)
- `timestamp` — метка времени
- `errorCode` — код ошибки (если есть)
- `pagination` — пагинаци
### Получение курсов (GET /api/courses)

**Query-параметры:**

- `title` — фильтр по названию (необязательно)
- `start_date` — фильтр по дате начала курса (YYYY-MM-DD, необязательно)
- `end_date` - фильтр по дате окончания курса (YYYY-MM-DD, необязательно)
- `sort` — поле для сортировки (title, start_date, end_date, необязательно)
- `order` — порядок сортировки (`asc`, `desc`)
- `page` — номер страницы
- `per_page` — количество элементов на странице (макс. 100)

**Пример запроса:**

GET http://localhost:port/api/courses?title=Программирование&sort=start_date&order=asc&page=1&per_page=10

**Структура ответа**
```json
{
  "status": true,
  "statusCode": 200,
  "timestamp": 1676457600,
  "message": "OK",
  "data": [
    {
      "id": "uuid_курса_1",
      "title": "PHP для начинающих",
      "description": "Курс для изучения основ PHP",
      "start_date": "2026-03-01",
      "end_date": "2026-06-01",
      "created_at": "2026-02-09T12:00:00Z"
    },
    {
      "id": "uuid_курса_2",
      "title": "Laravel продвинутый",
      "description": "Глубокое погружение в Laravel",
      "start_date": "2026-04-01",
      "end_date": "2026-07-01",
      "created_at": "2026-02-10T10:30:00Z"
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
        "per": 10,
        "from": 1,
        "to": 10,
        "count": 10,
        "total": 50,
        "isFirst": true,
        "isLast": false,
        "isNext": true,
        "isPrevious": false
      }
    }
  }
}
```
