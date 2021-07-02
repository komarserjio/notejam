FROM python:2.7

LABEL authors="Paul Stagner"

#Environment variables
ENV PYTHONUNBUFFERED 1
ENV APP_HOME /usr/src/app       

COPY notejam/django/notejam /usr/src/app

WORKDIR $APP_HOME

COPY notejam/django/requirements.txt ./
RUN pip install -r requirements.txt

EXPOSE 8000