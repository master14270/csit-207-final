# csit-207-final
This is my Final Project for Web Programming II.

## Step 1: Run 'make_db.php'
Doing this creates the database, then populates it with some values.

## Step 2: Go Bonkers
At this point, the API is fully functional. There isn't much data in the database, but the three GET endpoints and the one POST endpoint all work.
So you can access each GET endpoint by using the following (without the brackets):\
localhost/final%20project/api.php?id=[user input here] \
localhost/final%20project/api.php?hobby=[user input here] \
localhost/final%20project/api.php?major=[user input here] 

Of course, you may have to modify this url depending on how exactly you are running the server and database. This was set up using XAMMP.

As for what each of these endpoints do, I'll explain below.

the 'id' endpoint echos a json object of all data in the database with a matching unique user id. (don't worry! no real passwords were used.)

the 'hobby' endpoint echos a json object of a list of all users with a matching hobby.

the 'major' endpoint similarly echos a json object of a list of all users with a matching major.

## Step 3 (optional): Use Form to Add Items to Database
Like I mentioned before, the POST endpoint is functional. An easy way I made to test it was with 'form.html'. \
However, If you would like to test it with other methods, feel free.
