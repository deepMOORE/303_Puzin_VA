EOL = '\n'
RESULT_FILE_PATH = 'db_init.sql'

USERS_TO_INSERT_FILE = 'users.txt'

create_tables_queries = {
    "movies" : 'CREATE TABLE IF NOT EXISTS movies(id INTEGER PRIMARY KEY, title TEXT, year INTEGER, genres TEXT);' + EOL,
    "ratings" : 'CREATE TABLE IF NOT EXISTS ratings(id INTEGER PRIMARY KEY, user_id INTEGER, movie_id INTEGER, rating REAL, timestamp INTEGER);' + EOL,
    "tags" : 'CREATE TABLE IF NOT EXISTS tags(id INTEGER PRIMARY KEY, movie_id INTEGER, tag TEXT, timestamp INTEGER);' + EOL,
    "users" : 'CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY, name TEXT, email TEXT, gender TEXT, register_date TEXT, occupation TEXT);' + EOL
}

purge_tables_quiries = {
    "movies" : 'DROP TABLE IF EXISTS movies;' + EOL,
    "ratings" : 'DROP TABLE IF EXISTS ratings;' + EOL,
    "tags" : 'DROP TABLE IF EXISTS tags;' + EOL,
    "users" : 'DROP TABLE IF EXISTS users;' + EOL
}

def write_create_tables_queries(file):
    file.write(create_tables_queries['movies'])
    file.write(create_tables_queries['ratings'])
    file.write(create_tables_queries['tags'])
    file.write(create_tables_queries['users'])

def write_purge_database_queries(file):
    file.write(purge_tables_quiries['movies'])
    file.write(purge_tables_quiries['ratings'])
    file.write(purge_tables_quiries['tags'])
    file.write(purge_tables_quiries['users'])

def read_txt_file():
    usersFile = open(USERS_TO_INSERT_FILE, 'r')
    sqlCoreInsertQuery = 'INSERT INTO users (id, name, email, gender, register_date, occupation) VALUES '
    comma = ','

    i = 0
    for rawLine in usersFile.readlines():
        fields = rawLine.split('|')
        
        commaSeparatedFields = comma.join(fields)
        fieldsToInsertSqlQuery = '(' + commaSeparatedFields +')'
        sqlCoreInsertQuery += fieldsToInsertSqlQuery + ','
        if i == 3:
            break
        i = i + 1

    return sqlCoreInsertQuery

def echo(line):
    print(line + EOL)

def handle():
    file = open(RESULT_FILE_PATH, 'a')

    sqlCoreInsertQuery = read_txt_file()
    print(sqlCoreInsertQuery)
    #echo('Dropping existing tables')
    #write_purge_database_queries(file)

    #echo('Create tables')
    #write_create_tables_queries(file)

    #echo('All done')

    file.close()


handle()