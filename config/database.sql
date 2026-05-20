CREATE TABLE users (
    id SERIAL PRIMARY KEY UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    pasword TEXT NOT NULL,
    mobile_phone VARCHAR(20) NOT NULL UNIQUE,
    gender integer NULL,
    adress VARCHAR(100),
    birthday DATE,
    status BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),X
    deleted_at TIMESTAMP
);