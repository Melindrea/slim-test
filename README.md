```
public_html
    index.php -- initiering + routing, mest includes
    assets
        - Byggda från ... någonstans. EJ I GIT!

bootstrap.php -- autoload + skapa object, includas i public_html
.env -- EJ I GIT, diverse config saker som ska ligga i minnet, ex DB
app
    config
        config-filer som inte är environment (ex app, dirs, database ...)
```

http://pmjones.io/adr/

Route /posts: returnerar PostsAction->response();

- PostsAction
    - Hämtar data från Domain (ex Post)
    - Posts (i någon form) skickas till PostsResponder
    - Reponse() is a thinly-veiled wrapper around the returned response from Responder
- PostsResponder
    - View system
    - Headers
    - Content types
