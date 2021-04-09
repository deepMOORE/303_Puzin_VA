---- Создание
-- Специальность (хирург)
CREATE TABLE IF NOT EXISTS specialties --
(
    id    INTEGER PRIMARY KEY,
    title TEXT NOT NULL
);

-- Категория оказываемых услуг (удаление зуба)
CREATE TABLE IF NOT EXISTS categories --
(
    id    INTEGER PRIMARY KEY,
    title TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS employee_statuses --
(
    id    INTEGER PRIMARY KEY,
    title TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS users --
(
    id            INTEGER PRIMARY KEY,
    first_name    TEXT NOT NULL,
    last_name     TEXT NOT NULL,
    patronymic    TEXT,
    date_of_birth TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS doctors
(
    id                  INTEGER PRIMARY KEY,
    user_id             TEXT    NOT NULL,
    speciality_id       INTEGER NOT NULL,
    earning_in_percents INTEGER NOT NULL,
    employee_status_id  INTEGER NOT NULL,
    FOREIGN KEY (speciality_id) REFERENCES specialties (id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (employee_status_id) REFERENCES employee_statuses (id)
);

CREATE TABLE IF NOT EXISTS clients
(
    id      INTEGER PRIMARY KEY,
    user_id TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id)
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

-- На одну специальность может быть несколько категорий услуг
CREATE TABLE speciality_categories
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
    scheduled_at TEXT,
    started_at   TEXT,
    ended_at     TEXT,
    cancelled_at TEXT,
    is_completed INTEGER,
    status_id    INTEGER NOT NULL,
    FOREIGN KEY (doctor_id) REFERENCES doctors (id),
    FOREIGN KEY (client_id) REFERENCES clients (id),
    FOREIGN KEY (status_id) REFERENCES reception_statuses (id)
);

CREATE TABLE IF NOT EXISTS periods
(
    id    INTEGER PRIMARY KEY,
    title TEXT NOT NULL
);

-- В полях статистики не задаются связи и ключи, потому что
-- 1) Статистика должна быть изолирована и защищенна от каких-либо действий с данными, foreign keys лучше избежать,
-- 2) Сложная поддержка посредством базы, но через код легко организовать поиск и обновление.
-- Идея такова, допустим доктор успешно завершил процедуру, тогда инкрементиться количество завершенных процедур,
--   благодарая этому, мы может избежать постоянного использования аггрегирующий функций, что позволяет разгрузить систему,
--   а обновление одного поля по индексу очень быстро.
CREATE TABLE IF NOT EXISTS statistics_doctors
(
    id                INTEGER PRIMARY KEY,
    related_entity_id INTEGER NOT NULL,
    `key`             TEXT,
    sub_key           TEXT,
    value             FLOAT   NOT NULL,
    period_id         INTEGER NOT NULL,
    period_date       TEXT,
    FOREIGN KEY (period_id) REFERENCES periods (id)
);

CREATE TABLE IF NOT EXISTS statistics_billings
(
    id                INTEGER PRIMARY KEY,
    related_entity_id INTEGER NOT NULL,
    `key`             TEXT,
    value             FLOAT   NOT NULL,
    period_id         INTEGER NOT NULL,
    period_date       TEXT,
    FOREIGN KEY (period_id) REFERENCES periods (id)
);

CREATE TABLE IF NOT EXISTS billings
(
    id              INTEGER PRIMARY KEY,
    doctor_id       INTEGER NOT NULL,
    paid_at         TEXT,
    original_amount DECIMAL NOT NULL DEFAULT 0,
    earnings_amount DECIMAL NOT NULL DEFAULT 0
);

--- Заполнение
INSERT INTO reception_statuses (title)
VALUES ('new'),
       ('done'),
       ('cancelled');

INSERT INTO employee_statuses (title)
VALUES ('working'),
       ('absent'),
       ('fired'),
       ('vacationed');

INSERT INTO users (first_name, last_name, patronymic, date_of_birth)
VALUES ('Ivan', 'Ivanov', 'Ivanovich', '1995-01-15'),
       ('Petr', 'Petrov', 'Petrovich', '1994-01-15'),
       ('Alexey', 'Alexeev', 'Alexeevich', '1993-01-15'),

       ('Abram', 'Abramov', 'Abramovich', '1983-01-15'),
       ('Izya', 'Izeev', 'Izeevich', '1983-01-15'),
       ('Adam', 'Admov', 'Adamovich', '1983-01-15');

INSERT INTO specialties (title)
VALUES ('therapist'),
       ('surgeon'),
       ('orthodontist');

INSERT INTO categories (title)
VALUES ('Inspection'),
       ('Tooth treatment'),
       ('Prophylaxis');

INSERT INTO clients (user_id)
VALUES (1),
       (2),
       (3);

INSERT INTO doctors (user_id, speciality_id, earning_in_percents, employee_status_id)
VALUES (4, 1, 80, 1),
       (5, 2, 70, 1),
       (6, 3, 75, 1);

INSERT INTO services (title, price, duration_in_minutes, category_id)
VALUES ('Осмотр 1 зуба', 300, 5, 1),
       ('Осмотр всех зубов', 1000, 30, 1),
       ('Удаление зуба', 500, 5, 2),
       ('Отбеливание', 600, 20, 3);

INSERT INTO periods (title)
VALUES ('whole'),
       ('month');

INSERT INTO receptions (doctor_id, client_id, scheduled_at, started_at, ended_at, cancelled_at, is_completed, status_id)
VALUES (4, 1, '2020-04-12 10:30:00', null, null, null, 0, 1),
       (4, 2, '2020-04-13 11:30:00', null, null, null, 0, 1),
       (5, 3, '2020-04-14 12:00:00', null, null, null, 0, 1),
       (5, 3, null, '2020-04-08 12:00:00', '2020-04-08 12:05:00', null, 1, 2),
       (6, 3, null, '2020-04-08 12:00:00', '2020-04-08 12:06:00', null, 1, 2);

INSERT INTO statistics_billings (related_entity_id, key, value, period_id, period_date)
VALUES (4, 'original_amount', 100000, 1, null),
       (5, 'original_amount', 150000, 1, null),
       (6, 'original_amount', 200000, 1, null),
       (4, 'earning_amount', 80000, 2, '2020-04-01 00:00:00'),
       (5, 'earning_amount', 120000, 2, '2020-04-01 00:00:00'),
       (6, 'earning_amount', 150000, 2, '2020-04-01 00:00:00');

INSERT INTO statistics_doctors (related_entity_id, key, sub_key, value, period_id, period_date)
VALUES (4, 'receptions', 'done', 50, 1, null),
       (5, 'receptions', 'done', 30, 1, null),
       (6, 'receptions', 'done', 70, 1, null),
       (4, 'receptions', 'done', 10, 2, '2020-04-01 00:00:00'),
       (5, 'receptions', 'done', 5, 2, '2020-04-01 00:00:00'),
       (6, 'receptions', 'done', 15, 2, '2020-04-01 00:00:00'),

       (4, 'receptions', 'cancelled', 2, 1, null),
       (5, 'receptions', 'cancelled', 5, 1, null),
       (6, 'receptions', 'cancelled', 1, 1, null),
       (4, 'receptions', 'cancelled', 0, 2, '2020-04-01 00:00:00'),
       (5, 'receptions', 'cancelled', 1, 2, '2020-04-01 00:00:00'),
       (6, 'receptions', 'cancelled', 0, 2, '2020-04-01 00:00:00');

INSERT INTO billings (doctor_id, paid_at, original_amount, earnings_amount)
VALUES (4, '2020-04-02 00:00:00', 10000, 8000),
       (5, '2020-04-03 00:00:00', 15000, 12000),
       (6, '2020-04-04 00:00:00', 20000, 15000),
       (4, '2020-04-05 00:00:00', 5000, 4000),
       (5, '2020-04-06 00:00:00', 5000, 3500),
       (6, '2020-04-07 00:00:00', 6000, 4500);