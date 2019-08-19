FROM python:2.7.16-stretch as base

WORKDIR /app

RUN DEBIAN_FRONTEND=noninteractive apt update && \
  apt install -y default-libmysqlclient-dev

COPY requirements.txt .

RUN pip install -r requirements.txt && pip install mysql-python

COPY notejam/ notejam/
COPY db.py db.py
COPY tests.py tests.py
COPY runserver.py runservery.py

# Run tests
RUN python tests.py

FROM base as db-migration

RUN python db.py

FROM base as release

EXPOSE 5000

ENTRYPOINT ["python", "runserver.py"]
