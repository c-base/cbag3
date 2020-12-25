FROM python:3.6

ADD requirements.txt /requirements.txt

RUN pip install --upgrade pip && \
    pip install --upgrade -r /requirements.txt

# install npm and yarn
RUN set -xe \
    && curl -sL https://deb.nodesource.com/setup_10.x | bash \
    && apt-get install --yes nodejs \
    && node -v  \
    && npm -v \
    && curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt-get install --yes yarn


WORKDIR /opt/cbag3

EXPOSE 8000
ENTRYPOINT ["/opt/cbag3/entrypoint"]



