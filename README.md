# Clinical Trial Search
The Clinical Trial Search application is a stylized search engine that allows the intended users such Medical students, professionals, or simply the medically literate, to be able to search a curated library of 
Clinical Trial Information based on a variety of criteria related to the trial. Such criteria is not limited just to the trial itself, but also about journals that have mentioned the trial, or the instutitions and 
healthcare personnel that were involved in the trial. This allows the users to use the Search Engine as the center of a much large investigation into the details of related medical information.

Users are required to register and login to a user database in order to use the application. While users cannot edit any of the curated information, this requirement ensures the site is not overwelmed with traffic 
ensuring fast connections and better ease of use.

![image](https://github.com/NicoleK286/Clinical-Trial-Search-Suite/assets/113560469/38d23d5c-8519-41b7-9051-ac5b641d17e3)


**SNAPSHOTS OF SITE**
![image](https://github.com/NicoleK286/Clinical-Trial-Search-Suite/assets/113560469/e1ccc2ea-63c2-4a87-8669-2220e4303f04)

![image](https://github.com/NicoleK286/Clinical-Trial-Search-Suite/assets/113560469/dd58dd23-170d-44fd-882c-368f520d20ea)



## Requirements
At minimum, to access the full functionality of the Web Application in its current storage location, you must have a webbrowser which can support the following:

* PHP
* CSS
* Javascript
* Ajax/Jquery
* Bootstrap

Should the user wish to install the application and its relevant data library on their own computer to run as a web server, they must also have the following:

* MySQL Workbench
* XAMPP

These two applications will be necessary for properly running the php-files from you own computer as a web server, and for storing the SQL data tables.

## Project Notes
The application works through dynamically generated search result pages from the search-form for Clinical Trial based on pertinent information such as involved Institutions, Health Care Personnel, or Trial Sites. The visible pages of the search application are subject to bootstrap wrappers to modify their stylization for better visual effect.


## Setup
To access the Clinical Trial Search in its current location, please simply follow the link below:

* https://in-info-web4.informatics.iupui.edu ~ajettpac/Al_Austin_Koshy_Project/Clinical_Trial_Search/main/homepage.php

From there, the user can follow the directions of Registration and Login, where the users Registration information will be added to already existing database.

Should the user wish to install the Application and run on their own server, they must download the directory [Clinical Trial Search], and its sub direcotries [main, css, inc] and all the files included. This will require the XAMPP application to allow their own server to act as a web browser. The user also then have a valid MySQL Workbench from which to install and run the required Clinical Data Search library and user table. The files for this are in the directory [SQL] in the following files:

* nickoshy_db.sql : Contains the entire Clinical Trial Relational database library
* user_table.sql  : Contains the existing user table with dummy users already created

From there, the user must then downdowl the Clinical Trial Search directory into the valid XAMPP directory for running php files. The user must then take one of the following two actions:

*Create a database within their MySQL Workbench under the name `ajettpac_db`
*User must go into the following file directory: [Clinical_Trial_Search\inc\sql_connect.php] and change the variables [$username] and [$password] to those of their own MySQL Workbench login

or

*User open the files of [nickoshy_db.sql] and and [user_table.sql] and fine lines 22 and 24 which say [-- Database: `ajettpac_db`] and [USE `ajettpac_db`;] respecivly
*Change these lines in both files to the name of a custom database of the users nameing on MySQL Workbench. Make sure that both files go to the same database.
*User must go into the following file directory: [Clinical_Trial_Search\inc\sql_connect.php] and change the variables [$username] and [$password] to those of their own MySQL Workbench login, and variable [$db] to the name of their database which the previous 2 files were imported into.


## Files & directories
The Clinical Trial Search Application can be found in the directory [Clinical_Trial_Search], which itself contains the three directories of [main, inc, css] which contain the main-page files and support files, back-end proceedural helper-files, and stylization files respecivily. A full list of the directories and their files and purposes is stated in the table below:
-----------------------------------------------------------------------------------------
|Dictory Name      |File Name	              |File Description and Purpose               |
-----------------------------------------------------------------------------------------
|main              |homepage.php            |Explanatory homepage of application,       |
|                  |                        |location of successful signin.             |
|                  |------------------------|-------------------------------------------|
|                  |signin.php              |User signin page                           |
|                  |------------------------|-------------------------------------------|
|                  |register.php            |User registration page                     |
|                  |------------------------|-------------------------------------------|
|                  |ProjectPracticeForm.php |Clinical Trial Search form                 |
|                  |------------------------|-------------------------------------------|
|                  |ProjectSearch_2.php     |Table of results of Trial Search Form      |
|                  |------------------------|-------------------------------------------|
|                  |full_trial.php          |Page of all relevant information of trial  |
|                  |                        |selected from ProjectSearch_2.php          |
|                  |------------------------|-------------------------------------------|
|                  |searchbcg.png           |Background image of ProjectPracticeForm.php|
|                  |------------------------|-------------------------------------------|
|                  |image_fittedv2.jpg      |Background image of [register.php,         |
|                  |                        |signin.php, and full_trail.php]            |
|                  |------------------------|-------------------------------------------|
|                  |CTsearch2.png           |Background image of homepage.php           |
|------------------|------------------------|-------------------------------------------|
|inc               |captcha.inc.php         |Generates captcha image on signin.php      |
|                  |------------------------|-------------------------------------------|
|                  |countries.txt           |List of countries to generate country      |
|                  |                        |selection on ProjectPracticeForm.php search|
|                  |                        |form                                       |
|                  |------------------------|-------------------------------------------|
|                  |header.inc.php          |Forms navigation bar and page title for    |
|                  |                        |[homepage, signin, registration,           |
|                  |                        | trial search, and full trial pages]       |
|                  |------------------------|-------------------------------------------|
|                  |signin.inc.php          |Confirms validity of user signin.php form, | 
|                  |                        |and signs in user if successful            |
|                  |------------------------|-------------------------------------------|
|                  |register.inc.php        |Confirms validity of user register.php     |
|                  |                        |form, and creates user if successful       |
|                  |------------------------|-------------------------------------------|
|                  |sql_connect.php         |Establishes connection to sql database     |
|                  |------------------------|-------------------------------------------|
|                  |functions.inc.php       |Creates helper fuctions for inclusion pages|
|                  |------------------------|-------------------------------------------|
|                  |logout.inc.php          |Logs out user                              |
|------------------|------------------------|-------------------------------------------|
|css               |header_style.css        |Sytlizes Navigation bar of header.inc.php  |
|                  |------------------------|-------------------------------------------|
|                  |search_stylesheet.css   |Stylizes ProjectPracticeForm.php and       |
|                  |                        |ProjectSearch_2.php                        |
|                  |------------------------|-------------------------------------------|
|                  |trail_style.css         |Styles full_trial.php page                 |
-----------------------------------------------------------------------------------------
