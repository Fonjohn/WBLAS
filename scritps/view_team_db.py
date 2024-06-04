import sqlite3
import os

# Path to the database file
script_dir = os.path.dirname(os.path.abspath(__file__))
db_path = os.path.abspath(os.path.join(script_dir, '../data/team_data.db'))

# Connect to the SQLite database
conn = sqlite3.connect(db_path)
cursor = conn.cursor()

# Query the data
cursor.execute('SELECT * FROM teams')

# Fetch all results
rows = cursor.fetchall()

# Print the column names
column_names = [description[0] for description in cursor.description]
print(column_names)

# Check if there are any rows and print them
if rows:
    for row in rows:
        print(row)
else:
    print("No rows found in the database.")

# Close the connection
conn.close()
