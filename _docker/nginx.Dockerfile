
FROM nginx:1.27.3-alpine3.20

COPY _docker/nginx.conf /etc/nginx/conf.d/default.conf