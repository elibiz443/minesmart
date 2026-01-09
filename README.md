# MINESMART FLOOD SENTINEL

```
touch .gitignore && touch send_mail.php && mkdir includes && mkdir uploads && touch .htaccess
```

## Introduction

This is a website that includes:

* Landing Page.

## Colors

Setting up DB:
- Go To: http://localhost/phpmyadmin
- DB Name(eg: minesmart_db)
- seed db: http://localhost/minesmart/db/db-setup.php
- For production: https://minesmart/db/db-setup.php

Populate alerts:

* Localhost:
```
http://localhost/minesmart/db/populate_alerts.php
```

* production:
```
https://minesmart/db/populate_alerts.php
```

Adding mailer:
```
composer require phpmailer/phpmailer
```

Watch CSS:
```
npx tailwindcss -i ./assets/css/style.css -o ./assets/css/output.css --watch
```

Go To App in development:
-Go To: http://localhost/minesmart/

Deployment:

Minify CSS:
```
npx tailwindcss -i ./assets/css/style.css -o ./assets/css/output.css --minify
```

## Uploading files:

Give permission to upload folder: 
```
mkdir uploads
chmod 0755 uploads
sudo chown -R daemon:daemon uploads
```

Push to production:
```
zip -r ../minesmart_production.zip . -x "uploads/*" -x ".htaccess" -x "*.DS_Store" -x "README.md" -x ".gitignore" -x ".git/*"
```