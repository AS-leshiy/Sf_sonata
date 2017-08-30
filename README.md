Symfony 3 + Sonata Admin Bundle
===============================

For details on how to download and get started with Symfony, see the
[Installation][1] chapter of the Symfony Documentation.

What's inside?
--------------

1. All that includes Symfony Standard Edition;
2. Installed and configured SonataAdminBundle + FOSUserBundle
3. For anonymous user: 
    3.1 list of posts
    3.2 propose new post page;
4. For admin user: 
    4.1 sonata admin panel

How to start?
--------------

First instal (for windows)
1. instal local server (xampp), composer, cmder
2. create folder site.loc on C:\xampp\htdocs
3. create folder www in site.loc
4. run cmder and write commands:
5. cd C:\xampp\htdocs\site.loc\www
6. git clone https://github.com/AS-leshiy/Sf_sonata.git
7. cd Sf_sonata
8. composer install --no-interaction
9. open xampp control panel, run Apache & MySQL
10. restart cmder and write commands:
11. cd C:\xampp\htdocs\site.loc\www\Sf_sonata
12. php bin\console doctrine:database:create
13. php bin\console doctrine:schema:create
14. php bin\console fos:user:create admin admin@gmail.com adminpass
15. php bin\console fos:user:promote admin --super
16. php bin\console cache:clear --env=prod --no-warmup
17. go to Xampp control panel and restart Apache
18. go to cmder and write:
19. php bin\console server:run
20. open http://127.0.0.1:8000 in your browser

21. Admin panel: login: admin  ||  password: adminpass
