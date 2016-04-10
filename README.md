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
