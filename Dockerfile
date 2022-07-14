FROM amazonlinux:2

# install amazon-linux-extras install
RUN amazon-linux-extras install -y

# yum update & install
RUN yum update -y \
    && yum install \
        systemd \
        tar \
        unzip \
        sudo \
        -y
# RUN curl -L git.io/nodebrew | perl - setup
# RUN echo 'export PATH=$HOME/.nodebrew/current/bin:$PATH' >> ~/.bashrc
# RUN source ~/.bashrc

# install aws cli v2
RUN curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip" \
    && unzip awscliv2.zip \
    && sudo ./aws/install

# create user
# ENV user contuser1
# RUN useradd "contuser1" -u 1000 -m -d /home/${user} ${user}\
#     && chown -R ${user} /home/${user} >> /etc/sudoers
RUN useradd "ec2-user" && echo "ec2-user ALL=NOPASSWD: ALL" >> /etc/sudoers

# install for develop, etc.
RUN sudo amazon-linux-extras install golang1.11 -y

# npm install
RUN yum -y repolist
RUN curl -sL https://rpm.nodesource.com/setup_12.x | sudo bash -
RUN yum -y install --enablerepo=nodesource nodejs
# RUN yum -y install nodejs
# RUN yum -y install npm

# RUN curl -L git.io/nodebrew | perl - setup
# RUN echo 'export PATH=$HOME/.nodebrew/current/bin:$PATH' >> ~/.bashrc
# RUN source ~/.bashrc
# RUN nodebrew install-binary v9.3.0
# RUN nodebrew use v8.9.4

ADD package.json .
ADD index.js .

# init
COPY startup.sh /startup.sh
RUN chmod 744 /startup.sh
CMD ["/startup.sh"]
