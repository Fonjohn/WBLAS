import sqlite3
import csv
import os

# Directory and file paths
script_dir = os.path.dirname(os.path.abspath(__file__))
tsv_path = os.path.abspath(os.path.join(script_dir, '../data/old_nfl_players.txt'))
db_path = os.path.abspath(os.path.join(script_dir, '../data/player_data.db'))

# Debugging: Print paths to check correctness
print(f"Script directory: {script_dir}")
print(f"TSV file path: {tsv_path}")
print(f"Database file path: {db_path}")

# Create directory if it doesn't exist
directory = os.path.dirname(db_path)
if not os.path.exists(directory):
    os.makedirs(directory)

# Function to clean the name field
def clean_name(name):
    parts = name.split()
    parts = [x.lower().capitalize() for x in parts]
    if len(parts) > 1:
        return ' '.join(parts[:2])
    return name

def clean_position(position):
    if position in ["LWR", "RWR", "SWR"]:
        return "WR"
    return position


# Connect to an SQLite database (or create it if it doesn't exist)
conn = sqlite3.connect(db_path)
cursor = conn.cursor()

# Drop the table if it exists
cursor.execute('DROP TABLE IF EXISTS players')

# Create the table if it doesn't exist
cursor.execute('''
CREATE TABLE IF NOT EXISTS players (
    Team TEXT,
    Position TEXT,
    Name TEXT
)
''')

# Read and parse the TSV file
try:
    with open(tsv_path, 'r') as file:
        reader = csv.DictReader(file, delimiter='\t')
        for row in reader:
            team = row['Team']
            position = clean_position(row['Position'])
            name = clean_name(row['Name'])
            
            # Insert the cleaned data into the database
            cursor.execute('INSERT INTO players (Team, Position, Name) VALUES (?, ?, ?)', (team, position, name))
except FileNotFoundError:
    print(f"Error: TSV file not found at {tsv_path}")

# Commit the changes and close the connection
conn.commit()
conn.close()
