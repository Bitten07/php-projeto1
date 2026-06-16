FROM php:alpine

RUN apk upgrade && apk update

WORKDIR /app

COPY . .

CMD ["sleep", "infinity"]