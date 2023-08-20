# Data Mapping from different Providers

## How to use?
--
Inside   `root folder`  run `docker compose up -d`
--
OR you can run Luman Only by run `composer install` and `php -S localhost:8000 -t public`
--
PLease change the url in Guzzlehttp clinent in DataProvider.php class function read() because it doesn't work on localhost
and i used this solution to test the code

[]: https://stackoverflow.com/questions/6014958/why-does-file-get-contents-work-with-google-com-but-not-with-my-site/57572727#57572727
