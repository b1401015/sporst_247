git pull
sudo docker-compose -f docker-compose-dev.yml down
sudo docker-compose -f docker-compose-dev.yml build
sudo docker-compose -f docker-compose-dev.yml up -d