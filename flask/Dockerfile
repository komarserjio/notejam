FROM ubuntu:16.04
RUN apt-get update && apt-get -qy upgrade && apt-get install -qy \
    -o APT::Install-Recommends=false -o APT::Install-Suggests=false \
    python python-pip python-setuptools python-dev \
    vim
COPY . /app
WORKDIR /app
RUN pip install --upgrade pip wheel
RUN pip install -r requirements.txt
ENTRYPOINT ["python"]
CMD ["runserver.py"]
