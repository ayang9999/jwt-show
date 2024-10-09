## laravel Jwt Authentication

This is a simple laravel jwt authentication and react system 

steps to run the project:

1. Clone the repository
   run `git clone git@github.com:ayang9999/jwt-show.git`
2. Run `composer install`
3. Run `cp .env.example .env && php artisan key:generate`
4. 使用pest进行单元测试
   Run `./vendor/bin/pest --coverage` 
5. Run `docker-compose up`
6. Open your browser and go to `http://localhost:8080`


**主要功能是jwt的认证，没有弄mysql等等,用户写死的只有一个用户1234567890，密码是123456**

**用最新版php和laravel框架, 国内composer和docker镜像源都有可能会有问题, 推荐科学上网大法**
