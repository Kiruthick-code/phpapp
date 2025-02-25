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
    conn = sqlite3.connect('reviews.db')
    conn.row_factory = sqlite3.Row  # Allows column access by name
    return conn
	
@app.route('/')
def home():
    return render_template('kevin.html')

@app.route('/bangalore')
def bangalore():
    return render_template('bangalore.html')

@app.route('/ooty')
def ooty():
    return render_template('ooty.html')

@app.route('/kodaikanal')
def kodaikanal():
    return render_template('kodaikanal.html')

@app.route('/about-us')
def about_us():
    return render_template('about-us.html')

@app.route('/rating')
def rating():
    # Fetch reviews from the database
    conn = get_db_connection()
    reviews = conn.execute('SELECT * FROM reviews').fetchall()
    conn.close()
    return render_template('rating.html', reviews=reviews)  # Render your HTML form (r.html)

@app.route('/review', methods=['POST'])
def review():
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

    # Insert review into the database using your table structure
    conn = get_db_connection()
    conn.execute('INSERT INTO reviews (name, rating, review, review_image) VALUES (?, ?, ?, ?)',
                 (name, rating, review, review_image))
    conn.commit()
    conn.close()

    return redirect('/')

if __name__ == '__main__':
    app.run(debug=True)
