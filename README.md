Bookmarks RESTfull API
========================

Является WEB-API для добавления URL'ов в закладки
и коментарев к ним. Построено по принципу
 [REST](https://habrahabr.ru/post/38730/).  Возвращаемые данные имеют формат JSON.


API позволяет:

   * получить список 10 последних добавленных Bookmark'ов
   * получить Bookmark (с комментариями) по Bookmark.url
   * добавить Bookmark по url и получить Bookmark.id. Если уже есть Bookmark с таким url, возвращает Bookmark.id.
   * добавить Comment к Bookmark (по id) и получить Comment.id
   

**Примеры запросов-ответов:**

  **GET /bookmarks**    
     
     {
         "status": "ok",
         "bookmarks": [
             {
                 "id": 1,
                 "url": "symfony.com",
                 "createdAt": {
                     "date": "2017-07-17 17:28:19.000000",
                     "timezone_type": 3,
                     "timezone": "Europe/Moscow"
                 },
                 "updatedAt": {
                     "date": "2017-07-17 17:28:26.000000",
                     "timezone_type": 3,
                     "timezone": "Europe/Moscow"
                 }
             },
             {
                 "id": 5,
                 "url": "vk.com",
                 "createdAt": {
                     "date": "2017-07-17 19:20:39.000000",
                     "timezone_type": 3,
                     "timezone": "Europe/Moscow"
                 },
                 "updatedAt": {
                     "date": "2017-07-17 19:20:39.000000",
                     "timezone_type": 3,
                     "timezone": "Europe/Moscow"
                 }
             }
         ]
     }


**GET bookmarks/vk.com**     
   
    [
      {
        "ipAddress": "127.0.0.1",
        "id": 2,
        "text": "wow such site"
      },
      {
        "ipAddress": "192.168.0.101",
        "id": 3,
        "text": "very social, so network"
      }
    ]


**POST /comments/bookmark/5?text=very interesting**


    {   
       "status": "ok",
       "id": 5
    }

**POST /bookmarks/?url=vk.com**
       

    {
        "status": "ok",
        "id": 5
    }
    (если была создана запись -- код ответа будет 201, если такая существует -- 200)


