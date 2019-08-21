FROM python:2.7.16-stretch

WORKDIR /app

RUN DEBIAN_FRONTEND=noninteractive apt update && \
  apt install -y default-libmysqlclient-dev

COPY requirements.txt .

RUN pip install -r requirements.txt && pip install mysql-python

COPY notejam/ notejam/
COPY db.py db.py
COPY tests.py tests.py
COPY runserver.py runserver.py

EXPOSE 5000

CMD ["gunicorn", "--bind", "0.0.0.0:5000", "runserver:app"]
