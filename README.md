# Spreadsheet service

This service converts XML file in to Google Sheet, and share ownership of the created document with configurable user email.

##Requirements 

- Create google project : https://cloud.google.com/resource-manager/docs/creating-managing-projects
- Enable Google sheet API : https://developers.google.com/sheets/api/quickstart/php
- Enable Google drive API : https://developers.google.com/drive/api/v3/enable-drive-api
- Create a service account for your project : 
`make sure to assign project owner permission to the account`
  https://cloud.google.com/iam/docs/service-accounts
- Download the credentials file and add it to project on the root level, then add the name of the file in the .env file :
  `AUTH_CONFIG=product_sheet.json`
- The service will share the created Google sheet with an email, can be added to .env file on `SHEET_SHARE_EMAIL` 
- For the service to be able to send email notification about the shared document, update `SEND_NOTIFICATION_EMAIL=true` in the .env file.
- For the shared document permission level, update `SHEET_PERMISSION` in the .env file to one of the permissions : 
  - owner
  - organizer
  - fileOrganizer
  - writer
  - commenter
  - reader
## Commands
- Build the service and keep track the logs 
`make buils` 
- Run the service
`make run`
- Get inside the service docker container
`make enter`
- Run code static analysis 
`make static-analysis`

For more commands check `make help`.

## Run Service
After `make run`, with the current setup, run `php ./bin/console.php` to see the list of commands already have been added.

To use the test command:

`
php ./bin/console.php spreadsheet:validate_transform
`

## Register new command to the service: 
Add the command namespace to `config/command.php`, and the service will auto register it.