# Формат данных
Timestamp use UNIX format

### Ratings
 userId `BIGINT` | movieId `BIGINT` | rating `real` | timestamp `BIGINT` | 
 --- | --- | --- | ---  
 1 | 1 | 9 |  1493845678
 1 | 2 | 5.5 | 1493848567
 
### Movies
 moviedId `BIGINT` | title `VARCHAR(256)` | genres `TEXT` 
 --- | --- | ---   
 1 | Toy Story (1995) | Adventure &#124; Animation &#124; Children &#124; Comedy &#124; Fantasy
 2 | Jumanji (1995)  | Adventure &#124; Children &#124; Fantasy
 
### Tags
 userId `BIGINT` | movieId `BIGINT` | tag `VARCHAR(50)` | timestamp`BIGINT` 
 --- | --- | --- | ---   
 1 | 1 | funny | 1493845678 
 2 | 1 | will ferrel | 1493845678
  
  