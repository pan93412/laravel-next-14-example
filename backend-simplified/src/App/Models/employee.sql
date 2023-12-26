CREATE TABLE IF NOT EXISTS employees (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name TEXT NOT NULL,
    password TEXT NOT NULL,
    join_at DATE DEFAULT NOW(),
    address TEXT,
    email TEXT,
    phone TEXT
);
