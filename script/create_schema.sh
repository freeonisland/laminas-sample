#!/bin/bash

DBNAME=laminas.db3
sqlite3 /appli/data/sqlite/$DBNAME < /appli/src_bonus/BlogTuto/schema/album.schema.sql
sqlite3 /appli/data/sqlite/$DBNAME < /appli/src_bonus/BlogTuto/schema/blog.schema.sql