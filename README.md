## DEMO PROJECT


**Story**

Als Anwendungsentwickler,
Möchte ich das Hunde Flöhe bekommen können,
Damit die Flöhe ein schöne Zuhause finden und Hunde einen Grund zum Baden bekommen.
Akzeptanzkriterien


(x) (x) (x) Anwendung läuft lokal und die Datenmigration wurde ausgeführt (Alle Schritte in der Readme wurden ausgeführt und System ist Betreibsbereit)

(x) (x) (x) Jeder Floh kann über einen Button "beißen" einen Hund beißen

(x) (x) (x) Die Übersicht für die Hunde wurde um die Ansicht der zugehörigen Flöhe erweitert

(x) (x) (x) Ein Floh kann immer nur einem Hund zugeordnet sein

(x) (x) (x) Ein Hund kann mehrere Flöhe haben

(x) (x) (x) Alle Flöhe von einem Hund können über einen "Baden" Button vom Hund entfernt werden


## Infos

(i) Usability und Design müssen nicht näher betrachtet werden.


**DEV SERVER:**

Requirements:
install docker and composer

web url: http://localhost:8000/

* Step 1 start docker in root

  ``docker-compose up --build -d``


* Step 2 connect to php container run composer install.

  ``composer install``


* Step 3 connect to php container and run the following commands to create the schema.

  ``php bin/console doctrine:schema:create``


* Step 4 run tables schema

  ``php bin/console doctrine:schema:update --force``


* Step 5 seed the database:
  seed the tables based on files in src/DataFixtures.
  Use em parameter for the corresponding entity manager.

  ``php bin/console doctrine:fixtures:load``


* Step 6 (if needed)
  if no permission to cache and log
  ``sudo chmod 777 ./app/var/ -R``
