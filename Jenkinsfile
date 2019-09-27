/**
* SUBSCRIPTION MANAGER Jenkinsfile
* MAINTAINER: Luis Chacón <luisgreen at gmail dot com>
*/
def APP_VERSION
def IMAGE_TAG
def TEST_BASE_URL
def GCP_WORKLOAD_NAME

pipeline {
    agent any

    options {
        timestamps()
    }

    environment {
        GCP_PROJECT_NAME    = "${env.GCP_PROJECT_NAME}"
        K8S_WORKLOAD        = "notejam"
        APP_NAME            = "notejam"
    }
    stages {
        stage('Checkout Source Control') {
            steps {
                script {
                        IMAGE_TAG="gcr.io/${GCP_PROJECT_NAME}/${APP_NAME}:latest"
                    }
                }
        }
        stage('Building Applications on base Image') {
            steps {
                    sh 'yes Y | gcloud auth configure-docker'
                    sh "gcloud beta container clusters get-credentials interview-toptal-cluster --region us-central1 --project ${GCP_PROJECT_NAME}"
                    sh "docker build -t ${IMAGE_TAG} ."
                }
        }
        stage('Running Migrations') {
            stages {
                stage('Starting SQL PROXY') {
                    steps {
                        sh "docker container run --network=host --name sql_proxy --detach -e GCP_DB_INSTANCE=${GCP_DB_INSTANCE} gcr.io/${GCP_PROJECT_NAME}/sql_proxy:latest"
                        echo "Waiting for proxy to settle..."
                        sh 'sleep 2s'
                    }
                }
                stage('Running Migrations') {
                    steps {
                        sh "docker run --network=host --entrypoint /var/www/migrate.sh ${IMAGE_TAG} "
                        // touch app/database/notejam.db && 
                    }
                }
            }
        }
        stage('Pushing API Image') {
            steps {
                sh "docker push ${IMAGE_TAG}"
            }
        }
        stage('Reloading Workload') {
            steps {
                echo "Deploying: ${IMAGE_TAG}"
                sh "kubectl patch deployment ${K8S_WORKLOAD} -p \"{\\\"spec\\\":{\\\"template\\\":{\\\"metadata\\\":{\\\"annotations\\\":{\\\"date\\\":\\\"`date +'%s'`\\\"}}}}}\""
            }
        }
        stage('K8s API Deploy Check') {
            steps {
                timeout(time: 5, unit: 'MINUTES') {
                    retry(3) {
                        echo "Checking ${K8S_WORKLOAD} Deploy Health Check"
                        sh "kubectl  rollout status deploy/${K8S_WORKLOAD} | grep successfully"
                    }
                } 
            }
        }
        stage('Registry Cleanup') {
            steps {
                sh "gcloud container images list-tags gcr.io/${GCP_PROJECT_NAME}/${APP_NAME} --format=\"flattened\" | grep dig | awk '{print \$2}' | tail -n +4 | while read tag; do gcloud container images delete --force-delete-tags --quiet gcr.io/${GCP_PROJECT_NAME}/${APP_NAME}@\$tag 2>&1 | tail ; done;"
            }
        }
    }
    post {
        success {
            script {
                echo "Success"
            }
        }
        cleanup {
            script {
                sh "docker container stop sql_proxy; docker container rm sql_proxy"
                sh "docker system prune -a --force"
            }
        }
    }
}
