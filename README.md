# COVID Vaccine Registration System

This project is a COVID vaccine registration system built using Laravel and blade. The application allows users to register for vaccinations, check their registration status, and manage vaccination schedules.

## Features

- User registration for vaccination at selected vaccine centers
- Distribution of registered users to vaccine centers based on capacity
- Scheduling of vaccination dates using a first-come, first-serve strategy
- Email notifications sent to users the night before their scheduled vaccination date
- Search functionality to check registration status using NID

## Installation Instructions

To run this project, follow these steps:

### Prerequisites

- PHP >= 8.3
- Composer
- Laravel 11
- MySQL (or any compatible database)

### Step 1: Clone the repository

```bash
git clone https://github.com/sajidwarner/sajid-covid-vaccine-registration.git
```
```bash
cd sajid-covid-vaccine-registration
```

### Step 2: Install dependencies
Run the following command to install the project dependencies:



```bash
composer install
```

### Step 3: Set up the environment

Copy the .env.example file to .env:

```bash
cp .env.example .env
```
Update the .env file with your database credentials and mail configuration.


## Set up the database in the .env file:


```bash

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sajid_covid_vaccine_registration
DB_USERNAME=root
DB_PASSWORD=

```


### Step 4: Generate application key
Run the following command to generate the application key:


```bash
php artisan key:generate
```


### Step 5: Run migrations and seed the database
Migrate the database and seed it with vaccine centers:


```bash
php artisan migrate --seed
```

### Step 6: Start the development server
Run the following command to start the Laravel development server:


```bash
php artisan serve
```
The application will be accessible at http://localhost:8000.


### Step 7: Start and Check Scheduled Tasks on Localhost
To manually run the scheduler in the background for testing on localhost, use the following command:
The vaccination schedule will be run every 5 minutes so that you can check the status.


```bash
php artisan schedule:work
```
or 
```bash
php artisan schedule:run
```

To manually run the scheduler in the background for instant testing of email notifications on your localhost, use the following command:

```bash
php artisan app:send-vaccination-reminders
```

## Optimization Notes
To optimize the performance of user registration and search:

Implement caching for frequently accessed data (e.g., vaccine centers).
Use indexing on database columns that are frequently queried (e.g., NID).


## Future Enhancements
If an additional requirement for sending SMS notifications along with email notifications is introduced:

Integrate an SMS gateway.
Create a service class to handle SMS sending.
Update the notification logic to include SMS notifications alongside email notifications.
