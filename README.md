      STOCK PRICE TRACKER APP

Stock Price Tracker App is a Laravel-based application that fetches real-time stock market data using the Alpha Vantage API. It provides API endpoints for retrieving stock prices and historical data.

PHP 8.2  
Laravel 10.10  
MySQL

Instructions:

1. Run composer to install the dependencies
2. Set Up the env file with keys listed below
3. Set up database
4. Run php artisan migrate:fresh --seed to populate the database
5. The app has a built in cronjob that fetches stock data evey minute(php artisan schedule:run
   ). Also can be fetched directly with command: 
php artisan import:stock-data
6. Use the apis provided in postman collection within the project



Env keys for Alpha vantage API:

ALPHA_VANTAGE_API_KEY=RJIIFS4CSJ4A3E37
ALPHA_VANTAGE_URL=https://www.alphavantage.co/query
