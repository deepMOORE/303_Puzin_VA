import csv
import re
import os

EOL = '\n'
RESULT_FILE_PATH = 'db_init.sql'

create_tables_queries = {
    "movies": 'CREATE TABLE IF NOT EXISTS movies(id INTEGER PRIMARY KEY, title TEXT, year INTEGER, genres TEXT);' + EOL,
    "ratings": 'CREATE TABLE IF NOT EXISTS ratings(id INTEGER PRIMARY KEY, user_id INTEGER, movie_id INTEGER, rating REAL, timestamp INTEGER);' + EOL,
    "tags": 'CREATE TABLE IF NOT EXISTS tags(id INTEGER PRIMARY KEY, user_id INTEGER, movie_id INTEGER, tag TEXT, timestamp INTEGER);' + EOL,
    "users": 'CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY, name TEXT, email TEXT, gender TEXT, register_date TEXT, occupation TEXT);' + EOL
}

purge_tables_queries = {
    "movies": 'DROP TABLE IF EXISTS movies;' + EOL,
    "ratings": 'DROP TABLE IF EXISTS ratings;' + EOL,
    "tags": 'DROP TABLE IF EXISTS tags;' + EOL,
    "users": 'DROP TABLE IF EXISTS users;' + EOL
}

fill_database_core_queries = {
    "movies": 'INSERT INTO movies (id, title, year, genres) VALUES ' + EOL,
    "ratings": 'INSERT INTO ratings (user_id, movie_id, rating, timestamp) VALUES ' + EOL,
    "tags": 'INSERT INTO tags (user_id, movie_id, tag, timestamp) VALUES ' + EOL,
    "users": 'INSERT INTO users (id, name, email, gender, register_date, occupation) VALUES ' + EOL
}


def delete_result_file():
    try:
        os.remove(RESULT_FILE_PATH)
    except OSError:
        pass


def write_create_tables_queries(file):
    file.write(create_tables_queries['movies'])
    file.write(create_tables_queries['ratings'])
    file.write(create_tables_queries['tags'])
    file.write(create_tables_queries['users'])


def write_purge_database_queries(file):
    file.write(purge_tables_queries['movies'])
    file.write(purge_tables_queries['ratings'])
    file.write(purge_tables_queries['tags'])
    file.write(purge_tables_queries['users'])


def compose_insert_query_from_file(file_name):
    current_file = open(file_name, 'r')

    file_type = file_name[-3:]
    table_name = file_name[:-4]

    insert_into_table_query_part = fill_database_core_queries[table_name]

    full_query = insert_into_table_query_part

    lines = None
    splitter = None
    if file_type == 'csv':
        lines = current_file.readlines()[1:]
        splitter = ','
    else:
        lines = current_file.readlines()
        splitter = '|'

    comma = ','

    for raw_line in lines:
        fields = raw_line.split(splitter)

        fields[:] = ['"' + x.replace('"', '""').replace('\'', '\'\'').replace('\n', '') + '"' for x in fields]

        comma_separated_fields = comma.join(fields)
        values_to_insert_query_part = '(' + comma_separated_fields + ')' + EOL
        full_query += values_to_insert_query_part + ','

    return full_query[:-1] + ';' + EOL

def compose_insert_query_movies_table_from_file(file_name):
    movies_file_csv =  open(file_name, 'r')
    dict_reader = csv.DictReader(movies_file_csv)

    insert_into_table_query_part = fill_database_core_queries['movies']

    full_query = insert_into_table_query_part

    for row in dict_reader:
        title = row['title'].replace('"', '""').replace('\'', '\'\'')
        year = get_year_from_title(row['title'])
        full_query += f"({row['movieId']}, \"{title}\", {year}, \"{row['genres']}\" )," + EOL

    return full_query[:-2] + ';' + EOL

def get_year_from_title(line):
    result = re.search(r'\d{4}', line)

    if result == None:
        return 'null'

    return result.group(0)


def write_insert_queries(file):
    insertUsersQuery = compose_insert_query_from_file('users.txt')

    insertMoviesQuery = compose_insert_query_movies_table_from_file('movies.csv')

    insertRatingsQuery = compose_insert_query_from_file('ratings.csv')

    insertTagsQuery = compose_insert_query_from_file('tags.csv')

    write(file, insertUsersQuery)
    write(file, insertMoviesQuery)
    write(file, insertRatingsQuery)
    write(file, insertTagsQuery)

def write(file, line):
    file.write(line)


def handle():
    delete_result_file()

    file = open(RESULT_FILE_PATH, 'a')

    write_purge_database_queries(file)

    write_create_tables_queries(file)

    write_insert_queries(file)

    file.close()


handle()
