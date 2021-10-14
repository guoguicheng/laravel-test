# Init

    brew install heroku/brew/heroku
    heroku login
    git checkout -b main
    heroku create
    git push heroku main

    # database 
    heroku addons:create heroku-postgresql:hobby-dev
    heroku config
    # 查看pg数据库地址 格式为 postgres://username:password@host:port/dbname

    # 设置env
    heroku config:set DB_CONNECTION=pgsql .....

    composer install
    php artisan migrate
    php artisan passport:install
    php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
    php artisan admin:install
    php artisan db:seed --class=AdminMenuSeeder
    php artisan db:seed --class=AdminRolesSeeder
    # heroku 环境 则使用heroku run <command>

    # passport key 下载
    php artisan passport:synckeys

    # 启动
    heroku ps:scale web=1
    # 打开浏览器
    heroku open
    
    


