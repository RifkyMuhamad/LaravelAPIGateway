# DyoneStrankers Laravel API

## Project Structure
```diff
LaravelAPIGateway/
     |-- app/
     |   |-- Console/
     |   |   |-- Kernel.php
     |   |
     |   |-- Exceptions/
     |   |   |-- Handler.php
     |   |   
     |   |-- Http/
     |   |   |-- Controllers/
     |   |   |   |-- Controller.php
+    |   |   |   |-- UserController.php
     |   |   |
     |   |   |-- Middleware/
+    |   |   |   |-- ApiAuthMiddleware.php
     |   |   |   |-- Authenticate.php
     |   |   |   |-- EncryptCookies.php
     |   |   |   |-- PreventRequestDuringMaintenance.php
     |   |   |   |-- RedirectIfAuthenticated.php
     |   |   |   |-- TrimStrings.php
     |   |   |   |-- TrustHosts.php
     |   |   |   |-- TrustProxies.php
     |   |   |   |-- ValidateSignature.php
     |   |   |   |-- VerifyCsrfToken.php
     |   |   |
+    |   |   |-- Requests/
+    |   |   |   |-- UserLoginRequest.php
+    |   |   |   |-- UserRegisterRequest.php
+    |   |   |   |-- UserUpdateRequest.php
     |   |   |
+    |   |   |-- Resources/
+    |   |   |   |-- UserResources.php
     |   |   |
     |   |   |-- Kernal.php
     |   |
+    |   |-- Models/
+    |   |   |-- Address.php
+    |   |   |-- Contact.php
+    |   |   |-- User.php
     |   |
     |   |-- Providers/
     |       |-- AppServiceProvider.php
     |       |-- AuthServiceProvider.php
     |       |-- BroadcastServiceProvider.php
     |       |-- EventServiceProvider.php
     |       |-- RouteServiceProvider.php
     |
     |-- bootstrap/
     |   |-- cache/
     |   |   |-- .gitignore
     |   |
     |   |-- app.php
     |
     |-- config/
     |
     |-- database/
     |   |-- factories/
     |   |   |-- UserFactory.php
     |   |
     |   |-- migrations/
-    |   |   |-- 2014_10_12_000000_create_users_table.php
-    |   |   |-- 2014_10_12_100000_create_password_reset_tokens_table.php
-    |   |   |-- 2019_08_19_000000_create_failed_jobs_table.php
-    |   |   |-- 2019_12_14_000001_create_personal_access_tokens_table.php
+    |   |   |-- 2024_01_02_030001_create_users_table.php
+    |   |   |-- 2024_01_02_031519_create_contacts_table.php
+    |   |   |-- 2024_01_02_032757_create_addresses_table.php
     |   |
     |   |-- seeders/
+    |   |   |-- AddressSeeder.php
+    |   |   |-- ContactSeeder.php
     |   |   |-- DatabaseSeeder.php
+    |   |   |-- UserSeeder.php
     |   |
     |   |-- .gitignore
     |
+    |-- docs/
+    |   |-- user-api.json
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
     |   └──  views/
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