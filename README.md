# DyoneStrankers Laravel API

```diff
     LaravelAPIGateway/
     |-- app/
     |   |-- Console/
     |   |   |--Kernel.php
     |   |
     |   |-- Exceptions/
     |   |   |--Handler.php
     |   |   
     |   |-- Http/
     |   |   |-- Controllers/
     |   |   |   |--Kernel.php
     |   |   |
     |   |   |-- Middleware/
     |   |   |   |--Authenticate.php
     |   |   |   |--EncryptCookies.php
     |   |   |   |--PreventRequestDuringMaintenance.php
     |   |   |   |--RedirectIfAuthenticated.php
     |   |   |   |--TrimStrings.php
     |   |   |   |--TrustHosts.php
     |   |   |   |--TrustProxies.php
     |   |   |   |--ValidateSignature.php
     |   |   |   |--VerifyCsrfToken.php
     |   |   |
     |   |   |--Kernal.php
     |   |
+    |   |-- Models/
     |   |
     |   |-- Providers/
     |
     |-- bootstrap/
     |
     |-- config/
     |
     |-- database/
     |   |-- factories/
     |   |
     |   |-- migrations/
     |   |
     |   |-- seeders/
     |
     |-- public/
     |   |-- css/
     |   |
     |   |-- js/
     |   |
     |   |-- images/
     |
     |-- resources/
     |   |-- lang/
     |   |
     |   |-- views/
     |
     |-- routes/
     |
     |-- storage/
     |   |-- app/
     |   |
     |   |-- framework/
     |   |   |-- cache/
     |   |   |
     |   |   |-- sessions/
     |   |   |
     |   |   |-- testing/
     |   |
     |   |-- logs/
     |
     |-- tests/
     |
     |-- vendor/
     |
     |-- .editorconfig
     |-- .env
     |-- .env.example
     |-- .gitattributes
     |-- .gitignore
     |-- artisan
     |-- composer.json
     |-- composer.lock
-    |-- package.json
     |-- phpunit.xml
     |-- README.md
     |-- vite.config.js
```