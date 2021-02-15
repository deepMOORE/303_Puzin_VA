EOL = '\n'
RESULT_FILE_PATH = 'db_init.sql'

create_tables_queries = {
    "movies" : 'CREATE TABLE IF NOT EXISTS movies(id INTEGER PRIMARY KEY, title TEXT, year INTEGER, genres TEXT);' + EOL,
    "ratings" : 'CREATE TABLE IF NOT EXISTS ratings(id INTEGER PRIMARY KEY, user_id INTEGER, movie_id INTEGER, rating REAL, timestamp INTEGER);' + EOL,
    "tags" : 'CREATE TABLE IF NOT EXISTS tags(id INTEGER PRIMARY KEY, movie_id INTEGER, tag TEXT, timestamp INTEGER);' + EOL,
    "users" : 'CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY, name TEXT, email TEXT, gender TEXT, register_date TEXT, occupation TEXT);' + EOL
}

purge_tables_queries = {
    "movies" : 'DROP TABLE IF EXISTS movies;' + EOL,
    "ratings" : 'DROP TABLE IF EXISTS ratings;' + EOL,
    "tags" : 'DROP TABLE IF EXISTS tags;' + EOL,
    "users" : 'DROP TABLE IF EXISTS users;' + EOL
}

fill_database_core_queries = {
    "movies" : 'INSERT INTO movies (title, year, genres) VALUES ',
    "ratings" : 'INSERT INTO ratings (user_id, movie_id, rating, timestamp) VALUES ',
    "tags" : 'INSERT INTO tags (user_id, movie_id, tag, timestamp) VALUES ',
    "users" : 'INSERT INTO users (name, email, gender, register_date, occupation) VALUES '
}

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

def compose_insert_query_from_file(coreInsertQuery, file_name, splitter):
    usersFile = open(file_name, 'r')
    sqlCoreInsertQuery = coreInsertQuery

    lines = None
    if file_name[-3:] == 'csv':
        lines = usersFile.readlines()[1:]
    else:
        lines = usersFile.readlines()

    comma = ','

    for rawLine in lines:
        fields = rawLine.split(splitter)

        if file_name[-3:] == 'csv':
            fields.pop(0)

        fields[:] = ['"' + x + '"' for x in fields]

        commaSeparatedFields = comma.join(fields)
        fieldsToInsertSqlQuery = '(' + commaSeparatedFields + ')'
        sqlCoreInsertQuery += fieldsToInsertSqlQuery + ','

    return sqlCoreInsertQuery[:-1] + ';'

def write(file, line):
    file.write(line)

def handle():
    file = open(RESULT_FILE_PATH, 'a')

    write_purge_database_queries(file)

    write_create_tables_queries(file)

    insertUsersQuery = compose_insert_query_from_file(fill_database_core_queries['users'], 'users.txt', '|')

    insertMoviesQuery = compose_insert_query_from_file(fill_database_core_queries['movies'], 'movies.csv', ',')

    insertRatingsQuery = compose_insert_query_from_file(fill_database_core_queries['ratings'], 'ratings.csv', ',')

    insertTagsQuery = compose_insert_query_from_file(fill_database_core_queries['tags'], 'tags.csv', ',')

    write(file, insertUsersQuery)
    write(file, insertMoviesQuery)
    write(file, insertRatingsQuery)
    write(file, insertTagsQuery)

    file.close()


handle()