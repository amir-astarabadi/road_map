FROM nginx:stable-alpine

ENV NGINX_USER=road_map
ENV NGINX_GROUP=road_map

RUN mkdir -p /var/www/html/public
RUN mkdir -p /var/log/nginx/road_map

COPY default.conf /etc/nginx/conf.d/default.conf

RUN sed -i "s/user www-data /user ${NGINX_USER}/g" /etc/nginx/nginx.conf

RUN adduser -g ${NGINX_GROUP} -s /bin/sh -D ${NGINX_USER}  