# laravel-dynamodb-auth
Laravel Reference Implementation of Authenticating Directly with DynamoDB Tables Instead of MySQL

## Assumptions
- you have an AWS account set up
- you have created a users table in DynamoDB
- you are accessing the table remotely (i.e. not using a local instance of DynamoDB)
- table has the following fields:
-- id - String - primary key
-- username - String
-- password - String

## Usage

- rename env-sample to .env
- edit .env.  set the following values:
-- DYNAMODB_KEY - key created from AWS console
-- DYNAMODB_SECRET - relate secret from AWS console
-- DYNAMODB_REGION - region where your DynamoDB instance resides
-- NOTE: database section in file is not used
- modify app/Models/DynamoDbUser.php
-- change $table value to the name of your users table
-- this assumes that the primary key field's name is 'id'


## Testing it
- from the command line, run 'php artisan server'
- navigate to http://localhost:8000 and click the login link


## Modifications
- this code assumes that the password is stored in the clear
- update DynamoDbProvider.validateCredentials() to compare the password to a hashed verison of it (assuming you're saving the user's password in that manner)