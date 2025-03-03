from flask import Flask, request, redirect, render_template
import sqlite3
import os

app = Flask(__name__)

# Path to save uploaded images
UPLOAD_FOLDER = 'uploads'
os.makedirs(UPLOAD_FOLDER, exist_ok=True)
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

# SQLite database setup
def get_db_connection():
    conn = sqlite3.connect('madesh.db')
    conn.row_factory = sqlite3.Row  # Allows column access by name
    return conn

@app.route('/')
def index():
    return render_template('r.html')  # Render the HTML form

@app.route('/submit_review', methods=['POST'])
def submit_review():
    # Get data from the form
    name = request.form['name']
    rating = request.form['rating']
    review = request.form['review']
    review_image = None

    # Handle image upload if any
    if 'review_image' in request.files:
        image = request.files['review_image']
        if image.filename != '':
            image_path = os.path.join(app.config['UPLOAD_FOLDER'], image.filename)
            image.save(image_path)
            review_image = image.filename

    # Insert review into the database
    try:
        conn = get_db_connection()
        conn.execute('INSERT INTO madesh (name, rating, review, review_image) VALUES (?, ?, ?, ?)',
                     (name, rating, review, review_image))
        conn.commit()
        conn.close()
        print("Review inserted into database successfully!")
    except Exception as e:
        print(f"Error inserting review into database: {e}")
        return f"An error occurred: {e}"

    return redirect('/')

if __name__ == '__main__':
    app.run(debug=True)
