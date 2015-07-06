;(ns notejam.handler-test
  ;(:require [clojure.test :refer :all]
            ;[ring.mock.request :as mock]
            ;[notejam.handler :refer :all]))

;(deftest test-app
  ;(testing "main route"
    ;(let [response (app (mock/request :get "/"))]
      ;(is (= (:status response) 200))
      ;(is (= (:body response) "Index"))))

  ;(testing "not-found route"
    ;(let [response (app (mock/request :get "/invalid"))]
      ;(is (= (:status response) 404)))))

(ns notejam.handler-test
  (:require [notejam.handler :refer [app]]
            [kerodon.core :refer :all]
            [kerodon.test :refer :all]
            [environ.core :refer [env]]
            [clojure.test :refer :all]
            [korma.core :refer :all]))

;(defn init-db []
  ;)

(println (env :database-file))

(deftest initial-testing
  (-> (session app)
      (visit "/")
      (has (text? "Index"))))

(deftest signup-testing
  (-> (session app)
      (visit "/signup")
      (has (text? "Sign up"))))
