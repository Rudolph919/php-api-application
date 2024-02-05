CREATE TABLE subscribers (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  status VARCHAR(255) NOT NULL
);

CREATE INDEX idx_subscribers_email ON subscribers(email);
