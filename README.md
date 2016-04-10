# PAMERIN
Project final praktikum pemrograman web

## USAGE
- [Build](README.md#BUILD) the **assets file**
- Import the [databse.sql](database.sql) file to database 
- Set [Database configuration](project_application/config/database.php)
- Open the web and register the user
- After register user open the database, open table **USER** and set the user level to **1** for **Administrator User**

## BUILD
1. Install Node.js [download](https://nodejs.org/en/)
2. Install Gruntjs

   ```
    npm install -g grunt-cli
    ```
3. Install package from [build](build) directory

   ```
   npm install
   ```

4. Run build process

    ```
    grunt dist --force
    ```

## Project Based
- Backend:
  - [Codeigniter 3.0.4](https://codeigniter.com/) For base PHP Framework
- Frontend:
  - [Bootstrap v3.3.6](http://getbootstrap.com) For base CSS and Javascript Framework
  - [JQuery 1.12.1](http://jquery.com/) For javascript Framework
  - [Moment](http://momentjs.com) For manipulating time with javascript
  - [Bootstrap3-dialog](https://github.com/nakupanda/bootstrap3-dialog) For some modal dialog
  - [Bootstrap File Input](http://plugins.krajee.com/file-input) For Input File
  - [Imagesloaded](http://imagesloaded.desandro.com/) For manage action after image loaded
  - [Masonry](http://masonry.desandro.com/) For listing cards in Timeline

## License
Code release under [Apache License 2.0](LICENSE)
