# Tutor

#### [https://rnaveen99.github.io/tutor/](https://rnaveen99.github.io/tutor/)

### A tutorial website made with PHP, MYSQL, Parsedown, Materialize, Skeleton.

## Prerequisites

1. `XAMMP` .
2. `git` (optional).

## Instructions

1. Go to `C:\xampp\htdocs`.
2. Open `cmd` and type the following to clone this repo
   ```
   git clone https://github.com/RNaveen99/tutor.git
   ```
3. Change the contents of `C:\xampp\htdocs\index.php` file as :
   ```
   <?php
     header('location:/tutor/src/welcome.php')
   ?>
   ```
4. Open XAMMP and start `Apache` and `MYSQl`.
5. Open browser and type `localhost` and hit enter.

## Additional Information

1. The database setup will be done automatically according to `C:\xampp\htdocs\tutor\src\config.php` file.

2. The `config.php` file has the following values for database connectivity

   - `DB_USERNAME` as `root`
   - `DB_PASSWORD` as '' (empty string)

3. `config.php` file creates :

   - `project` database
   - `users, topics, quiz` and `requesttopic` tables

4. The `privileges` field in `users` table decides the access level for that user.

   - `1` for `admin` access
   - `0` for normal `user` access

5. The `password` field in `users` table stores hashed passwords.

6. The various external resources used by the files stored in `src` directory are available in the `resources` directory in the `.zip` file format. You need not to extract these and move extracted contents to `src` directory as those are already present in it.
