###### what:

demo. it can fetch things, keep them in db and allow to search them.

as required just bare-bones php.

###### how:

* clone
* `docker-compose up` — it will take some time because of mysql
* it's alive at http://localhost:8000
* ^C when done

###### todo:

* it absolutely should not be raw PDO. proper ORM (read Doctrine) will make it maintainable and straight
* it should use any basic MVC framework instead of messing with html inside php
* it should be typesafe (no bare arrays juggle)
* it should gracefully handle not-so-happy-paths (but it's the most time consuming thing)
* it's incomplete dew to time constraints (~3h): partial data (just searchable fields); no create/delete (more forms/fields)

###### no license
