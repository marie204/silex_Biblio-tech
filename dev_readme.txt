En allant dans le dossier où vous avez mis bibliotech et après y avoir posé composer.phar: 
c:\xampp\php\php.exe composer.phar install
Puis créer sur phpmyadmin une base de donnée bibliotech et entrer sur la console: 
c:\xampp\php\php.exe vendor/doctrine/orm/bin/doctrine orm:schema-tool:create
Puis lancer la commande: 
c:\xampp\php\php.exe bin\console LRA
c:\xampp\php\php.exe bin\console LRU
