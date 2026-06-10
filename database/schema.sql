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
  status ENUM('open', 'in_behandeling', 'opgelost') NOT NULL DEFAULT 'open',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO help_requests
  (title, description, category, requester_name, location, contact, status)
VALUES
  ('Boodschappen doen voor buurvrouw', 'Ik zoek iemand die vrijdagmiddag kan helpen met boodschappen halen bij de supermarkt.', 'Boodschappen', 'Mevrouw Jansen', 'Kanaleneiland', 'jansen@example.com', 'open'),
  ('Laptop instellen', 'Mijn laptop start traag op en ik krijg mijn e-mail niet goed ingesteld.', 'Computerhulp', 'Henk de Vries', 'Lombok', '06-12345678', 'in_behandeling'),
  ('Tuin opruimen', 'Door rugklachten lukt het niet om het onkruid en bladeren uit de voortuin weg te halen.', 'Tuin', 'Fatima El Idrissi', 'Overvecht', 'fatima@example.com', 'open'),
  ('Kleine klus in huis', 'Ik heb hulp nodig met het ophangen van twee planken in de keuken.', 'Klusje', 'Robin Smit', 'Zuilen', 'robin@example.com', 'opgelost');

