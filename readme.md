# Clan Manager #
## Quick Description ##
A web-based application for accounting and billing, tailored to the specific needs of a gamehoster company.

## Quick Start
To start the web-server for quick testing, do the following:
* Execute StartDevelopmentServers.bat This starts a local PHP and MySQL Server.
* Open the address http://localhost:5723 in your webbrowser

## Full Description ##
Clan Manager is a web-based application for managing and billing clients (called gaming *clans*) of a gamehoster company.

The application features the following functions:

* Specify information about the clans, including name, contact information and accounting number
* Specify information about the operated gameservers, including server name, IP address, optional discount information, pricing, terms of payment etc.
* Assign gameservers to clans
* Suspend/Reactivate the operation of gameservers
* Track the payments made by the clans, including highlighting when payments or demand notes are due
* A slick PHP web interface

## Development environement ##
To start the application locally for development:

* Execute StartDevelopmentServers.bat This starts a local PHP and MySQL Server.
* Open the address http://localhost:5723 in your webbrowser

## Productive environment ##
To start the application in a productive environement

* Execute Setup\DatabaseSetup.sql on your productive MySQL database
* Copy the files in the \Application folder to your productive PHP web-folder
* Enter your productive database credentials into Application\util\dblogin.php
