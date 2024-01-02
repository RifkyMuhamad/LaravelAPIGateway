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
+    |-- docs/
+m    |   |-- user-api.json
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
     |   |   |-- public/
     |   |   |   |-- .gitignore
     |   |   |
     |   |   |-- .gitignore
     |   |
     |   |-- framework/
     |   |   |-- cache/
     |   |   |   |-- data/
     |   |   |   |   |-- .gitignore
     |   |   |   |
     |   |   |   |-- .gitignore
     |   |   |
     |   |   |-- sessions/
     |   |   |
     |   |   |-- testing/
     |   |   |
     |   |   |-- views/
     |   |
     |   |-- logs/
     |
     |-- tests/
     |   |-- Feature/
     |   |   |-- ExampleTest.php
+    |   |   |-- UserTest.php
     |   |
     |   |-- Unit/
     |   |   |-- ExampleTest.php
     |   |
     |   |-- CreatesApplication.php
     |   |-- TestCase.php
     |
     |-- vendor/
     |
     |-- .editorconfig
     |-- .env
     |-- .env.example
     |-- .gitattributes
     |-- .gitignore
+    |-- .phpunit.result.cache
+    |-- .vercelignore
     |-- artisan
     |-- composer.json
     |-- composer.lock
-    |-- package.json
     |-- phpunit.xml
     |-- README.md
+    |-- vercel.json
-    |-- vite.config.js
```