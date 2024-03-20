FROM nginx:1.25.0-alpine

# Config Files
COPY nginx.conf  /etc/nginx/nginx.conf
COPY sites/default.conf /etc/nginx/conf.d/default.conf
COPY conf.d/default.conf /etc/nginx/conf.d/upstream.conf

#RUN echo "upstream php-upstream { server php-fpm:9000; }" > /etc/nginx/conf.d/upstream.conf

EXPOSE 80 443