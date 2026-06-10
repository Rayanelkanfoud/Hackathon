# SamenSterk - De Buurt-Helpdesk

Hackathon prototype voor de eerste casus: **SamenSterk - De Buurt-Helpdesk**.

De applicatie laat buurtbewoners hulpvragen plaatsen, bekijken, aanpassen en verwijderen. Andere bewoners kunnen reageren door de status van een hulpvraag te wijzigen. Dit sluit aan op de techstack-opdracht: HTML, CSS, JavaScript, PHP, MySQL en CRUD-functionaliteit.

## Techstack

- HTML voor de pagina-structuur
- CSS voor styling en responsive layout
- JavaScript voor filters, formulierhulp en kleine interacties
- PHP voor server-side logica
- MySQL voor opslag van hulpvragen
- PDO voor veilige databasequeries

## WAMP installatie

1. Kopieer de hele map:
   `C:\Users\Relka\OneDrive\Desktop\School\Hackathon`
2. Plak deze map in:
   `C:\wamp64\www\Hackathon`
3. Start WAMP en open phpMyAdmin:
   `http://localhost/phpmyadmin`
4. Maak een database aan met de naam:
   `samensterk`
5. Importeer dit bestand in phpMyAdmin:
   `database/schema.sql`
6. Open de app in je browser:
   `http://localhost/Hackathon/`

## Database-instellingen

De standaardinstellingen staan in `config/database.php`:

- host: `localhost`
- database: `samensterk`
- gebruiker: `root`
- wachtwoord: leeg

Dit is de standaardconfiguratie voor WAMP.

## Functies

- Hulpvragen bekijken
- Hulpvraag aanmaken
- Hulpvraag wijzigen
- Hulpvraag verwijderen
- Status aanpassen naar open, in behandeling of opgelost
- Prioriteit instellen: laag, normaal of hoog
- Gewenste datum per hulpvraag opslaan
- Zoeken op titel, omschrijving, naam of locatie
- Filteren op categorie, prioriteit en status
- Dashboard met statistieken
- Animaties, hover-effecten en oplopende tellers
- Responsive layout voor laptop en mobiel

## Waarom deze casus

Gekozen concept: **1. SamenSterk - De Buurt-Helpdesk**.

Deze casus past goed bij de opdracht omdat hij haalbaar is binnen een hackathon en tegelijk genoeg technische onderdelen bevat:

- Eerstejaarsdeel: HTML, CSS, JavaScript, formulieren en CRUD-schermen.
- Tweedejaarsdeel: PHP-structuur, MySQL-database, PDO, validatie en statuslogica.
- Demo/pitch: maatschappelijke impact, duidelijke workflow en zichtbare resultaten.

## Beoordelingspunten die erin zitten

- Werkende CRUD-functionaliteit
- MySQL database met voorbeelddata
- PHP backend zonder framework, dus makkelijk te draaien in WAMP
- JavaScript voor interactie en animaties
- Nette en responsive interface
- Branches in GitHub
- README met installatie-instructies

## Git branches

Gebruikte branch voor de uitwerking:

- `feature/techstack-samensterk`
