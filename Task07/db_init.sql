DROP TABLE IF EXISTS specialties;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS employee_statuses;
DROP TABLE IF EXISTS doctors;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS speciality_categories;
DROP TABLE IF EXISTS reception_statuses;
DROP TABLE IF EXISTS receptions;
DROP TABLE IF EXISTS statistics_doctors;
DROP TABLE IF EXISTS statistics_billings;
DROP TABLE IF EXISTS billings;

CREATE TABLE IF NOT EXISTS specialties
(
    id    INTEGER PRIMARY KEY,
    title TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS categories
(
    id    INTEGER PRIMARY KEY,
    title TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS employee_statuses
(
    id    INTEGER PRIMARY KEY,
    title TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS doctors
(
    id                  INTEGER PRIMARY KEY,
    first_name          TEXT    NOT NULL,
    last_name           TEXT    NOT NULL,
    patronymic          TEXT,
    date_of_birth       TEXT    NOT NULL,
    speciality_id       INTEGER NOT NULL,
    earning_in_percents INTEGER NOT NULL,
    employee_status_id  INTEGER NOT NULL,
    FOREIGN KEY (speciality_id) REFERENCES specialties (id),
    FOREIGN KEY (employee_status_id) REFERENCES employee_statuses (id)
);

CREATE TABLE IF NOT EXISTS clients
(
    id            INTEGER PRIMARY KEY,
    first_name    TEXT NOT NULL,
    last_name     TEXT NOT NULL,
    patronymic    TEXT,
    date_of_birth TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS services
(
    id                  INTEGER PRIMARY KEY,
    title               TEXT    NOT NULL,
    price               DECIMAL NOT NULL,
    duration_in_minutes INTEGER NOT NULL,
    category_id         INTEGER NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories (id)
);

CREATE TABLE IF NOT EXISTS speciality_categories
(
    id            INTEGER PRIMARY KEY,
    category_id   INTEGER NOT NULL,
    speciality_id INTEGER NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories (id),
    FOREIGN KEY (speciality_id) REFERENCES specialties (id)
);

CREATE TABLE IF NOT EXISTS reception_statuses
(
    id    INTEGER PRIMARY KEY,
    title TEXT
);

CREATE TABLE IF NOT EXISTS receptions
(
    id           INTEGER PRIMARY KEY,
    doctor_id    INTEGER NOT NULL,
    client_id    INTEGER NOT NULL,
    service_id   INTEGER NOT NULL,
    scheduled_at TEXT,
    started_at   TEXT,
    ended_at     TEXT,
    cancelled_at TEXT,
    is_completed INTEGER,
    status_id    INTEGER NOT NULL,
    FOREIGN KEY (doctor_id) REFERENCES doctors (id),
    FOREIGN KEY (client_id) REFERENCES clients (id),
    FOREIGN KEY (service_id) REFERENCES services (id),
    FOREIGN KEY (status_id) REFERENCES reception_statuses (id)
);

CREATE TABLE IF NOT EXISTS statistics_doctors
(
    id                INTEGER PRIMARY KEY,
    related_entity_id INTEGER NOT NULL,
    `key`             TEXT,
    sub_key           TEXT,
    value             FLOAT   NOT NULL,
    `period`          TEXT    NOT NULL,
    period_date       TEXT
);

CREATE TABLE IF NOT EXISTS statistics_billings
(
    id                INTEGER PRIMARY KEY,
    related_entity_id INTEGER NOT NULL,
    `key`             TEXT,
    value             FLOAT   NOT NULL,
    `period`          TEXT    NOT NULL,
    period_date       TEXT
);

CREATE TABLE IF NOT EXISTS billings
(
    id              INTEGER PRIMARY KEY,
    doctor_id       INTEGER NOT NULL,
    paid_at         TEXT,
    original_amount DECIMAL NOT NULL DEFAULT 0,
    earnings_amount DECIMAL NOT NULL DEFAULT 0
);

INSERT INTO reception_statuses (title)
VALUES ('new'),
       ('done'),
       ('cancelled');

INSERT INTO employee_statuses (title)
VALUES ('working'),
       ('absent'),
       ('fired'),
       ('vacationed');

INSERT INTO specialties (title)
VALUES ('therapist'),
       ('surgeon'),
       ('orthodontist');

INSERT INTO categories (title)
VALUES ('Inspection'),
       ('Tooth treatment'),
       ('Prophylaxis');

INSERT INTO speciality_categories (category_id, speciality_id)
VALUES (1, 1),
       (1, 2),
       (2, 2),
       (2, 3),
       (3, 3),
       (3, 1);

INSERT INTO clients (first_name, last_name, patronymic, date_of_birth)
VALUES ('Ivan', 'Ivanov', 'Ivanovich', '1995-01-15'),
       ('Petr', 'Petrov', 'Petrovich', '1994-01-15'),
       ('Alexey', 'Alexeev', 'Alexeevich', '1993-01-15');

INSERT INTO doctors (first_name, last_name, patronymic, date_of_birth, speciality_id, earning_in_percents,
                     employee_status_id)
VALUES ('Abram', 'Abramov', 'Abramovich', '1983-01-15', 1, 80, 1),
       ('Izya', 'Izeev', 'Izeevich', '1983-01-15', 2, 70, 1),
       ('Adam', 'Adamov', 'Adamovich', '1983-01-15', 3, 75, 1);

INSERT INTO services (title, price, duration_in_minutes, category_id)
VALUES ('Single tooth examination', 300, 5, 1),
       ('All teeth examination', 1000, 30, 1),
       ('Tooth removal', 500, 5, 2),
       ('Whitening', 600, 20, 3);

INSERT INTO receptions (doctor_id, client_id, scheduled_at, started_at, ended_at, cancelled_at, is_completed, status_id, service_id)
VALUES (1, 1, '2020-04-12 10:30:00', null, null, null, 0, 1, 2),
       (1, 2, '2020-04-13 11:30:00', null, null, null, 0, 1, 1),
       (2, 3, '2020-04-14 12:00:00', null, null, null, 0, 1, 3),
       (2, 3, null, '2020-04-08 12:00:00', '2020-04-08 12:05:00', null, 1, 2, 3),
       (3, 3, null, '2020-04-08 12:00:00', '2020-04-08 12:06:00', null, 1, 2, 3);

INSERT INTO statistics_billings (related_entity_id, `key`, value, period, period_date)
VALUES (1, 'original_amount', 100000, 'whole', null),
       (2, 'original_amount', 150000, 'whole', null),
       (3, 'original_amount', 200000, 'whole', null),
       (1, 'earning_amount', 80000, 'month', '2020-04-01 00:00:00'),
       (2, 'earning_amount', 120000, 'month', '2020-04-01 00:00:00'),
       (3, 'earning_amount', 150000, 'month', '2020-04-01 00:00:00');

INSERT INTO statistics_doctors (related_entity_id, `key`, sub_key, value, period, period_date)
VALUES (1, 'receptions', 'done', 50, 'whole', null),
       (2, 'receptions', 'done', 30, 'whole', null),
       (3, 'receptions', 'done', 70, 'whole', null),
       (1, 'receptions', 'done', 10, 'month', '2020-04-01 00:00:00'),
       (2, 'receptions', 'done', 5, 'month', '2020-04-01 00:00:00'),
       (3, 'receptions', 'done', 15, 'month', '2020-04-01 00:00:00'),

       (1, 'receptions', 'cancelled', 2, 'whole', null),
       (2, 'receptions', 'cancelled', 5, 'whole', null),
       (3, 'receptions', 'cancelled', 1, 'whole', null),
       (1, 'receptions', 'cancelled', 0, 'month', '2020-04-01 00:00:00'),
       (2, 'receptions', 'cancelled', 1, 'month', '2020-04-01 00:00:00'),
       (3, 'receptions', 'cancelled', 0, 'month', '2020-04-01 00:00:00');

INSERT INTO billings (doctor_id, paid_at, original_amount, earnings_amount)
VALUES (1, '2020-04-02 00:00:00', 10000, 8000),
       (2, '2020-04-03 00:00:00', 15000, 12000),
       (3, '2020-04-04 00:00:00', 20000, 15000),
       (1, '2020-04-05 00:00:00', 5000, 4000),
       (2, '2020-04-06 00:00:00', 5000, 3500),
       (3, '2020-04-07 00:00:00', 6000, 4500);