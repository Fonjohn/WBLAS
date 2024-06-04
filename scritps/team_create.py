import sqlite3

# Define the team names
team_names = ["John", "Ben", "Tyler", "Doug", "Mark", "Josh", "Tom", "Jeremy", "Stacy", "Justin"]

# Connect to the SQLite database (it will create the database if it doesn't exist)
conn = sqlite3.connect('../data/team_data.db')
c = conn.cursor()

c.execute('DROP TABLE IF EXISTS teams')

# Create the teams table with default values for 'funds' and 'max_bid'
c.execute('''
    CREATE TABLE teams (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        funds INTEGER DEFAULT 200,
        max_bid INTEGER DEFAULT 186,
        QB TEXT DEFAULT NULL,
        RB1 TEXT DEFAULT NULL,
        RB_flex TEXT DEFAULT NULL,
        WR1 TEXT DEFAULT NULL,
        WR2 TEXT DEFAULT NULL,
        TE_flex TEXT DEFAULT NULL,
        TE TEXT DEFAULT NULL,
        K TEXT DEFAULT NULL,
        DST TEXT DEFAULT NULL,
        B1 TEXT DEFAULT NULL,
        B2 TEXT DEFAULT NULL,
        B3 TEXT DEFAULT NULL,
        B4 TEXT DEFAULT NULL,
        B5 TEXT DEFAULT NULL,
        B6 TEXT DEFAULT NULL
    )
''')

# Insert 10 teams with the provided names, letting the default values for funds and max_bid be applied
for name in team_names:
    c.execute('''
        INSERT INTO teams (name, funds, max_bid) VALUES (?, 200, 186)
    ''', (name,))

# Commit the transaction
conn.commit()

# Close the connection
conn.close()

print("Database created and teams inserted successfully.")
