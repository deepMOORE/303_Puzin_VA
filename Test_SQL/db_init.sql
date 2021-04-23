-- tables
create table groups
(
    id     INTEGER PRIMARY KEY,
    number INTEGER not null
);

create table students
(
    id        INTEGER PRIMARY KEY,
    full_name TEXT    NOT NULL,
    group_id  INTEGER NOT NULL,
    foreign key (group_id) references groups (id)
);

create table class_marks
(
    id         INTEGER PRIMARY KEY,
    student_id INTEGER NOT NULL,
    marked_at  TEXT    NOT NULL,
    foreign key (student_id) references students (id)
);

-- filling
insert into groups (number)
VALUES (303),
       (402);

insert into students(full_name, group_id)
VALUES ('Алексеев Алексей', 1),
       ('Ашрятова Римма', 1),
       ('Борисов Александр', 1),
       ('Гарин Максим', 1),
       ('Головатюк Анастасия', 1),
       ('Горбунов Андрей', 1),
       ('Гуськов Артем', 1),
       ('Дворянинова Дарья', 1),
       ('Еделева Юлия', 1),
       ('Зевайкин Андрей', 1),
       ('Исоков Асадбек', 1),
       ('Казакова Ирина', 1),
       ('Квашнин Кирилл', 1),
       ('Кирдюшкин Данила', 1),
       ('Козина Светлана', 1),
       ('Козлова Екатерина', 1),
       ('Котков Сергей', 1),
       ('Ландышев Александр', 1),
       ('Логинов Виталий', 1),
       ('Малов Кирилл', 1),
       ('Манин Данила', 1),
       ('Маслова Елена', 1),
       ('Паршин Артем', 1),
       ('Пузин Владислав', 1),
       ('Сайфетдинов Салават', 1),
       ('Симатов Вадим', 1),
       ('Александров К.В.', 2),
       ('Антонов К.Ю.', 2),
       ('Арянов В.А.', 2),
       ('Ахунзада Г.А.', 2),
       ('Балашов В.В.', 2),
       ('Бикмаев Р.Р.', 2),
       ('Булатова Г.Р.', 2),
       ('Гераськин В.М.', 2),
       ('Гурьков Н.Д.', 2),
       ('Дурнаев Н.С.', 2),
       ('Егоров О.А.', 2),
       ('Кокулов А.Ф.', 2),
       ('Кудашкин А.Е.', 2),
       ('Лихорадов И.И.', 2),
       ('Логинов А.Д.', 2),
       ('Ломайкин А.С.', 2),
       ('Макушев В.А.', 2),
       ('Макшев Н.И.', 2),
       ('Матвеев М.Д.', 2),
       ('Парамонов О.Н.', 2),
       ('Плаксин Д.В.', 2),
       ('Сазонов А.В.', 2),
       ('Седики Х.Ю.', 2),
       ('Сюсин А.В.', 2),
       ('Тростин С.А.', 2),
       ('Шабарин И.А.', 2);

insert into class_marks(marked_at, student_id)
values ('02.04.2021 17:58:38', 39),
       ('02.04.2021 17:59:17', 49),
       ('02.04.2021 18:01:55', 44),
       ('02.04.2021 18:03:22', 47),
       ('02.04.2021 18:04:03', 33),
       ('02.04.2021 18:04:13', 46),
       ('02.04.2021 18:10:19', 29),
       ('02.04.2021 19:03:42', 34),
       ('02.04.2021 19:25:13', 48),
       ('03.04.2021 13:02:39', 47),
       ('03.04.2021 13:03:37', 29),
       ('03.04.2021 14:31:47', 48),
       ('03.04.2021 14:50:01', 49),
       ('05.04.2021 9:48:22', 49),
       ('09.04.2021 18:00:20', 33),
       ('09.04.2021 18:00:35', 46),
       ('09.04.2021 18:01:48', 29),
       ('09.04.2021 18:05:27', 49),
       ('09.04.2021 18:06:11', 48),
       ('09.04.2021 19:30:02', 45),
       ('09.04.2021 19:42:48', 44),
       ('10.04.2021 13:03:03', 34),
       ('10.04.2021 13:33:42', 39),
       ('10.04.2021 14:55:33', 33),
       ('10.04.2021 17:12:13', 46),
       ('12.04.2021 11:15:24', 49),
       ('16.04.2021 18:00:58', 33),
       ('16.04.2021 18:00:59', 39),
       ('16.04.2021 18:02:25', 29),
       ('16.04.2021 18:04:53', 46),
       ('16.04.2021 18:11:56', 44),
       ('17.04.2021 10:16:29', 12),
       ('17.04.2021 10:39:40', 17),
       ('17.04.2021 10:39:51', 13),
       ('17.04.2021 10:39:59', 19),
       ('17.04.2021 10:40:08', 10),
       ('17.04.2021 10:40:42', 26),
       ('17.04.2021 10:41:09', 20),
       ('17.04.2021 10:41:38', 21),
       ('17.04.2021 11:07:11', 18),
       ('17.04.2021 11:13:47', 25),
       ('17.04.2021 11:15:29', 8),
       ('17.04.2021 11:16:46', 11),
       ('17.04.2021 11:17:49', 7),
       ('17.04.2021 11:36:40', 9);
