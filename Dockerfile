FROM nginx
MAINTAINER Nikolay Voloshin <voloshin07@gmail.com>
ENTRYPOINT ["/entrypoint.sh"]
ENV TZ=Asia/Bishkek
WORKDIR /app
RUN apt-get update && apt-get install -y python2.7 python-pip
COPY . .
RUN ls -lh
RUN pip install virtualenv virtualenvwrapper
RUN pip install -r /app/requirements.txt
COPY ./entrypoint.sh /entrypoint.sh
RUN chmod 777 /entrypoint.sh
