set -e

echo "deploying..."

#maintainance
php artisan down
    #update code
    git pull

#exit maintainance
php artisan up

echo "deployed"
