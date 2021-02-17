#!/bin/bash
python3 init.py
sqlite3 movies_rating.db < db_init.sql
