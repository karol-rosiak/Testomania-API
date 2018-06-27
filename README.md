# Testomania API
A little API project for a quiz site.
# Overview
The API was done using python flask. The API gets data from MySQL database. I used mysql.connector to fetch data from it. Client side of this project was done mostly in PHP. One page was done in JavaScript and AJAX.
# How to run
- To run the server you need a python interpreter and compile it. I developed it on PyCharm.
- To run the client you need a php server. I used xampp which provieds apache server
- Also you need mysql server to import the database. I used xampp for that too
# Documenation
The documentation is located in the Doc directory. It's a static documentation generated from swagger JSON file using [Spectacle](https://github.com/sourcey/spectacle). You can also run the Swagger UI version by typing http://localhost:5000/apidocs in your browser while the server is running. This documentation was generated using [Flasgger](https://github.com/rochacbruno/flasgger)  
# TODO
- Code clean up
- Removing some unnecessary prints in python code 
- Creating a PHP class for the API calls so it's more readable 
