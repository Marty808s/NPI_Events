# NPI Events

Jedná se o webovou násťenku, kam by naše krajské pracoviště přidávalo vypsané vzdělávací programy do 3 kategorií. Tato aplikace umožňuje tvoření, mazání a správu jednotlivých kurzů. Celou myšlenkou je udělat násťěnku kurzů, kde by uživatelé prokliky získali informace k přihlášení.

## Funkce

- **Autentizace Uživatelů**: přihlášení uživatelů - následující manipulaci s Eventy.
- **Správa Událostí**: Uživatelé mohou přidávat, upravovat a mazat události.
- **Využití XML propojené s MySQL**: Vizualizace je provedena pomocí XML souboru kam uživatelé přidávají/spravují/vymazávají kurzy, zároveň se změny zapisují do MySQL.

## Použité Technologie

- **PHP**: Skriptovací jazyk na straně serveru.
- **MySQL**: Relační databázoví systém.
- **Apache s PHP**: Nástroj pro obsluhu prohlížečů jednotlivých návštěvníků .
- **phpMyAdmin**: Nástroj pro správu obsahu databáze MySQL.
- **HTML/CSS**: Značkovací a stylovací jazyky.
- **Bootstrap**: Framework pro front-end a design.
- **JavaScript**: Skriptovací jazyk na straně klienta.

## Instalace
### Klonování Repozitáře

- git clone https://github.com/Marty808s/NPI_Events
- cd NPI_EVENTS
- docker-compose up

### Přístup k Apache + php

http://localhost:8000/ -> Apache

### Přístup k phpMyAdmin

http://localhost:9001/ -> phpMyAdmin
- Přihlášení:
- servername = "database";
- username = "admin";
- password = "heslo";
- database = "npi_events";
- možná bude nutné importovat stávající events_list.sql, který se nachází v Dockerfiles, taky je možné že u Vás bude testovací event mimo databázi - klidně ho můžete smazat

### Port pro MySQL

http://localhost:9006/


### Přihlašovací údaje do aplikace:**
Ve fromátu **jmeno : heslo**
- pepa : pepa
- alena : heslo
- petr : 12345

### Předpoklady

- PHP 7.4 nebo vyšší
- MySQL 5.7 nebo vyšší
- Composer (pro správu PHP závislostí)

