CREATE DATABASE IF NOT EXISTS samensterk
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE samensterk;

DROP TABLE IF EXISTS help_requests;

CREATE TABLE help_requests (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(120) NOT NULL,
  description TEXT NOT NULL,
  category VARCHAR(40) NOT NULL,
  requester_name VARCHAR(80) NOT NULL,
  location VARCHAR(100) NOT NULL,
  contact VARCHAR(120) NOT NULL,
  priority ENUM('laag', 'normaal', 'hoog') NOT NULL DEFAULT 'normaal',
  needed_by DATE NULL,
  status ENUM('open', 'in_behandeling', 'opgelost') NOT NULL DEFAULT 'open',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO help_requests
  (title, description, category, requester_name, location, contact, priority, needed_by, status)
VALUES
  ('Boodschappen doen voor buurvrouw', 'Ik zoek iemand die vrijdagmiddag kan helpen met boodschappen halen bij de supermarkt. Het gaat vooral om zware producten zoals melk en aardappelen.', 'Boodschappen', 'Mevrouw Jansen', 'Kanaleneiland', 'jansen@example.com', 'hoog', '2026-06-12', 'open'),
  ('Laptop instellen', 'Mijn laptop start traag op en ik krijg mijn e-mail niet goed ingesteld. Een korte uitleg over veilig inloggen zou ook fijn zijn.', 'Computerhulp', 'Henk de Vries', 'Lombok', '06-12345678', 'normaal', '2026-06-15', 'in_behandeling'),
  ('Tuin opruimen', 'Door rugklachten lukt het niet om het onkruid en bladeren uit de voortuin weg te halen. Twee uurtjes hulp is al genoeg.', 'Tuin', 'Fatima El Idrissi', 'Overvecht', 'fatima@example.com', 'normaal', '2026-06-18', 'open'),
  ('Kleine klus in huis', 'Ik heb hulp nodig met het ophangen van twee planken in de keuken. Het materiaal is al aanwezig.', 'Klusje', 'Robin Smit', 'Zuilen', 'robin@example.com', 'laag', '2026-06-20', 'opgelost'),
  ('Samen wandelen na school', 'Mijn vader wil graag vaker naar buiten maar vindt het lastig om alleen te wandelen. Een vaste wandelafspraak zou helpen.', 'Gezelschap', 'Nora Bakker', 'Oog in Al', 'nora@example.com', 'normaal', '2026-06-14', 'open'),
  ('Formulier gemeente invullen', 'Ik zoek hulp bij een digitaal formulier van de gemeente. Het lukt mij niet om de juiste bijlage te uploaden.', 'Computerhulp', 'Abdi Hassan', 'Hoograven', 'abdi@example.com', 'hoog', '2026-06-11', 'open');
