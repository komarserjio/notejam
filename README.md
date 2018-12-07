NoteJam-MySQL
=============

An experimental framework for continuous development, testing, and
deployment using [Sergey Komar](https://github.com/komarserjio)'s
[NoteJam](https://github.com/komarserjio/notejam) experimental framework
for application development as the payload application.


What is NoteJam-MySQL?
----------------------

NoteJam-MySQL is a fork of the original NoteJam programming framework
experimentation project.  This fork aims to accomplish the following:

- Refactor the one-box/local-machine implementation of NoteJam into an
  n-Tier application.
- Provision the entire architecture with an Infrastructure-as-Code
  language (Ansible/Chef/Puppet, Terraform, Packer).
- Provision into a commodity infrastructuer provider (AWS, GCP, Azure,
  etc.)
- Complete automation for the deployment of new code and execution of
  tests.  Attempt to catch performance regressions.
- Mutable components such as block, API, and database storage must be
  backed up at least daily.
- Logs must be centralized, or at a minimum easily accessible without
  SSH access to hosts.
- Historical metrics must be made available for us in spotting and
  debugging bottlenecks.

This repository contains the following:
- A diagram showing architecture of NoteJam-MySQL [link](image-file.jpg)
- Infrastructure-as-Code: Ansible/Molecule, Terraform/Terratest, Packer,
  and Docker code
- Orchestration for test, build, deploy, scale, and backup-on-demand:
  Make, Bash
- A fork of NoteJam in Node.js/Express.


NoteJam-MySQL Architecture
--------------------------

![NoteJam-MySQL Architecture][arch]

[arch]: docs/notejam-mysql-infra-diagram.png "NoteJam-MySQL Architecture"


Requirements
------------

NoteJam-MySQL requires the following tools, utilities, libraries and
other software:

- [Docker](https://www.docker.com) 18.09 and Docker-compose 1.17.1 or
  later, as well as [DockerHub](https://www.dockerhub.com) access.
- [AWS](https://aws.amazon.com) account with permissions to create VPC,
  EC2, RDS, and Cloudwatch resources.
- [Ansible](https://www.ansible.com) 2.7.3 and
  [Molecule](https://molecule.readthedocs.io/en/latest) 2.19.0 or later.
- [Hashicorp](https://www.hashicorp.com)
  [Terraform](https://www.terraform.io/) 0.11.10 and
  [Gruntwork](https://gruntwork.io)
  [Terratest](https://github.com/gruntwork-io/terratest) 0.13.13 or
  later.
- [Hashicorp](https://www.hashicorp.com)
  [Packer](https://www.packer.io/) 1.3.2 or later.
- [GNU](https://aws.amazon.com/cli/)
  [Make](https://www.gnu.org/software/make/).
- [GNU](https://aws.amazon.com/cli/)
  [Bash](https://www.gnu.org/software/bash/).
- [Stephen Dolan](https://github.com/stedolan)'s
  [JQ](https://stedolan.github.io/jq/).
- [Amazon AWSCLI](https://aws.amazon.com/cli/).
- [Giles Hall](https://github.com/vishnubob)'s
  [wait-for-it.sh](https://github.com/vishnubob/wait-for-it).


How to run the NoteJam app in dev, containers, or instances
-----------------------------------------------------------

This section describes how to configure and launch NoteJam-MySQL during
development and production operations.

### Configuration with environment variables

Aside from being broken into n-Tiers, NoteJam has been modified to
obtain its configuration from environment variables.  This allows for
local development and production operations from the same artifacts
(i.e. Docker containers, EC2 instances, or even tar.gz packages).  Local
devs can simply set environment variables, while production systems can
receive configuration from tools like envconsul, which can read secrets
from Hashicorp Vault.

NoteJam-MySQL requires environment variables to be present and
intentionally fails if they are not set.  This prevents
misconfigurations that might allow developers to run against production
resources, or production misconfigurations that might lead to data loss.
The following environment variables must be specified or NoteJam will fail:


| Environment Variable | Purpose |
| --- | --- |
| `MYSQL_HOST` | DNS hostname or IP address of the MySQL-compatible database server to connect |
| `MYSQL_ROOT_PASSWORD` | Root password for the MySQL-compatible database server |
| `MYSQL_TCP_PORT` | TCP port on which the MySQL-compatible database server is listening |
| `NODE_ENV` | Environment for Node.js configuration, i.e. include/exclude testing libraries |
| `NOTEJAM_HOST` | DNS hostname or IP address of the NoteJam server |
| `NOTEJAM_PORT` | TCP port on which the NoteJam server is listening |
| `NOTEJAM_VERSION` | Version of NoteJam in use.  Note that this is always obtained from `package.json` |


#### Launch a stack or subcomponent with included Makefiles

Local Development with Docker.  Note that host variables rely on Docker
DNS.  They are already set in the included Dockerfiles.

```
cd notejam-mysql

export MYSQL_ROOT_PASSWORD="SomethingSecure123!"
export MYSQL_TCP_PORT=3306
export NODE_ENV=development
export NOTEJAM_PORT=3000
export NOTEJAM_VERSION=$(jq -r '.version' notejam/package.json)

make build-stack-docker
```

Production Ops with EC2 and RDS.  No Host vars needed as Terraform will
make them for us.  Note that environment variables need to be
re-exported as `TF_VAR_<lowercase var name>` in order to be read by
Terraform.  AWS stacks require an SSH key as well, which must be
generated outside automation processes to make it available to the
stack user.

```
cd notejam-mysql

export MYSQL_ROOT_PASSWORD="SomethingSecure123!"
export MYSQL_TCP_PORT=3306
export NODE_ENV=development
export NOTEJAM_PORT=3000
export NOTEJAM_VERSION=$(jq -r '.version' notejam/package.json)

export TF_VAR_mysql_root_password="${MYSQL_ROOT_PASSWORD}"
export TF_VAR_mysql_tcp_port="${MYSQL_TCP_PORT}"
export TF_VAR_node_env="${NODE_ENV}"
export TF_VAR_notejam_port="${NOTEJAM_PORT}"
export TF_VAR_notejam_version="$(jq -r '.version' notejam/package.json)"
export TF_VAR_ssh_key_name="notejam"

make build-stack-ec2
```


### Development and deployment workflow:

The development, testing, and deployment workflow is designed for simple
invocation by a human during development, and is repeatable during
automated testing by calling the same make targets a human would use.
To build a complete stack, the process is as follows:

*Building a Docker stack*
The Docker stack can be built using a pre-built container, or it can run
NoteJam inline based on the Node container.  Prebuilding a container is
the default workflow.

1. Set environment variables (see above).
2. Make changes as needed.
3. Run tests with `make test-container` and `make test-stack-docker`.
4. Build the test container with `make build-container`.
5. Build the test stack with `make build-stack-docker`.
6. Repeat steps 1-5 to deploy new versions.
7. When finished, tear down the stack with `make rm-stack-docker`.

*Building an AWS EC2 stack*
The AWS stack is fairly straightforward, and is similar to the Docker
process.

1. Create or use an existing SSH keypair and upload it to AWS EC2.
2. Set environment variables (see above).
3. Make necessary changes.
4. Test AMI changes with `make test-ami`.
5. Test changes to the stack with `make test-stack-aws`.
6. Build the stack with `make build-stack-aws`.
7. *For first-time stacks, you will need to manually seed the database
   with schema and test data.  See RDS documentation for more info.*
8. Deployment: Make changes to the application and AMI, then run
   `make build-stack-aws`.  Terraform's AMI data object is written to
   search for the latest version of the NoteJam AMI.  A new launch
   config will be generated and old instances will be "drained" from
   a production-configured load balancer to be replaced
   automatically by new instances.
9. When finished, tear down the stack with `make rm-stack-aws`.


Caveats
-------

This is a rudimentary example of an n-Tier implementation of NoteJam
with MySQL.  It is a MVP (minimum viable product) that could be deployed
into a production environment, which means it is lacking in certain
features and functionality:

- Monolith, not microservices: Since this is an example of
  infrastructure and CI/CD processes, the application logic and UI
  components of NoteJam have not been fully broken out into separate
  microservices.
- Not fully secure: One of the weak points of this stack is that a secure
  key-value configuration store is not available (outside the scope of
  this exercise).  As such, configurations are retrieved from
  environment variables on the developer machine, or they are embedded
  into EC2 instance data and made available to NoteJam on launch.
- MySQL root user: Out of convenience (to achieve uniformity across
  environments) the root database user is in place rather than a
  properly-secured non-root user.
