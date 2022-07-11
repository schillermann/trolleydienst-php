CREATE TABLE user (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    phone TEXT DEFAULT NULL,
    mobile TEXT DEFAULT NULL,
    congregation TEXT DEFAULT NULL,
    language TEXT DEFAULT NULL,
    note_user TEXT,
    note_admin TEXT,
    active INTEGER DEFAULT 1,
    administrative INTEGER DEFAULT 0,
    logged_on TEXT DEFAULT NULL,
    updated_on TEXT NOT NULL,
    created_on TEXT NOT NULL
);